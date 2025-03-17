<script setup lang="ts">
import CurrencyInput from '@/components/CurrencyInput.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import ViewModal from '@/components/ViewModal.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle, NotebookText } from 'lucide-vue-next';
import Select from 'primevue/select';
import { computed, ref } from 'vue';
import { Toaster, toast } from 'vue-sonner';

const props = defineProps<{
    //for selects
    sections: [any],
    ingredients: [any],
    //on update
    recipe?: {
        id: string,
        name: string
        quantity: number,
        presentation: any;
        unit_price: any;
        batch_cost: any;
        unit_cost: any;
        details?: [{
            id: number
        }]
    },


}>();

const item = {
    id: '',
    name: '',
    quantity: 0,
    presentation: '',
    unit_price: 0,
    batch_cost: 0,
    unit_cost: 0,
    details: [{}]
}

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Recetas',
        href: '/recipe'
    },
    {
        title: props.recipe ? 'Actualizar' : 'Agregar',
        href: '/ingredient/new'
    },
];
let title = props.recipe ? 'Editar Receta' : 'Nueva Receta';

const form = useForm({
    step1: {
        id: props.recipe ? props.recipe.id : '',
        name: props.recipe ? props.recipe.name : '',
        quantity: props.recipe ? props.recipe.quantity : 0,
        presentation: props.recipe ? props.recipe.presentation : '',
        unit_price: props.recipe ? props.recipe.unit_price : 0,
        batch_cost: props.recipe ? props.recipe.batch_cost : 0,
        unit_cost: props.recipe ? props.recipe.unit_cost : 0,
        details: props.recipe?.details ? props.recipe.details : [],
    },
    step2: {
        sector_id: 1,
        recipe_id: props.recipe ? props.recipe.id : 0,
        ingredient_id: 0,
        quantity: 0,
        presentation: '',
        cost: 0.0
    },
});

const currentStep = ref(0);

const submit = () => {
    if (props.recipe) {
        form.put('/recipe/' + form.id, {});
    } else {
        form.post(route('recipe.store'), {});
    }

};

//Multi step form
const nextStep = () => {
    if (currentStep.value == 0) {
        if (form.step1.name != '' && form.step1.quantity != 0 && form.step1.presentation != '' && form.step1.unit_price != 0) {
            title = 'Ingresar ingredientes de la receta';
            currentStep.value += 1
        } else {
            toast.error("Rellena todos los campos")
        }
    }
    else {

    }
}

const stepBack = () => {
    if (currentStep.value == 1) {
        title = 'Nueva Receta';
        currentStep.value -= 1
    } else {
        toast.error("Rellena todos los campos")
    }
}

const btn2Title = computed(() => {
    return currentStep.value == 0 ? 'Siguiente' : 'Siguiente Ingrediente';
})

const subtitle = computed(() => {
    return currentStep.value == 0 ? '' : form.step1.name;
})

const presentation = computed(() => {
    if(form.step2.ingredient_id !=0){
        const match = props.ingredients.filter((x)=>x.id==form.step2.ingredient_id)
        return match[0].unit;
    }
    else{
        return '';
    }
    
})


//GENERATE COST
// precio_ingrediente/cantidad_ingrediente -> precio_unit * cantidad -> cost
const create = () => {
    if (currentStep.value == 1) {
        form.step2.presentation = presentation.value
        if (form.step2.sector_id != 0 && form.step2.ingredient_id != 0 && form.step2.quantity > 0 && form.step2.presentation != '') {
            const value = costValue();

            item.details.push({
                sector_id: form.step2.sector_id,
                ingredient_id: form.step2.ingredient_id,
                quantity: form.step2.quantity,
                presentation: form.step2.presentation,
                cost: value
            })

            form.step1.details = item.details
            form.details = item.details;
            console.log(form.details)
            cleanDetail()
        }
        else {
            toast.error("Rellena todos los campos")
        }
    }
}

function costValue(){
    const match = props.ingredients.filter((x:any)=> x.id == form.step2.ingredient_id)[0]
    let cost = 0;
    let final = ''
    if(match != undefined){
        cost = match.price/ match.quantity;
        cost = cost * form.step2.quantity

        final = cost.toFixed(2)
    }
    return parseFloat(final);
}

function cleanDetail(){
    form.step2.cost = 0
    form.step2.ingredient_id = 0
    form.step2.presentation = ''
    form.step2.quantity = 0
}


</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Toaster richColors position="top-center" />

        <Head title="Configurar Receta" />
        <div class=" m-3 flex flex-row justify-center">
            <form @submit.prevent="submit" id="regForm"
                class="flex flex-col gap-6 md:w-1/2 border rounded-3xl border-neutral-400 m-3 p-6">
                <div class="flex items-center">
                    <div class="justify-self-stretch w-full">
                        <p class="text-center text-2xl font-bold w-full ">{{ title }}</p>
                        <HeadingSmall class="text-center" :title="subtitle" v-if="subtitle != ''" />
                    </div>
                    <ViewModal :ingredient="ingredients" v-if="subtitle" :sector="sections" link="recipe" :item="form.step1" >
                        <Button type="button" :tabindex="1" v-if="subtitle != ''" >
                            <NotebookText />
                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        </Button>
                    </ViewModal>


                </div>



                <div class="tab" v-if="currentStep == 0">
                    <div class="grid gap-2 ">
                        <Label for="name">Nombre Completo*</Label>
                        <Input id="name" name="name" required autofocus v-model="form.step1.name" :tabindex="1"
                            placeholder="Harina de trigo para pastelería" />
                        <InputError :message="form.errors.step1?.name" />
                    </div>

                    <div class="grid grid-cols-2 gap-2 ">
                        <div>
                            <Label for="quantity">Cantidad*</Label>
                            <Input min="0" id="quantity" type="number" required autofocus :tabindex="2"
                                v-model="form.step1.quantity" placeholder="1250" />
                            <InputError :message="form.errors.step1?.quantity" />
                        </div>
                        <div>
                            <Label for="presentation">Unidad*</Label>
                            <Input id="presentation" type="text" required autofocus :tabindex="3"
                                v-model="form.step1.presentation" placeholder="muffin" />
                            <InputError :message="form.errors.step1?.presentation" />
                        </div>
                    </div>

                    <div class="grid gap-2 mt-4">
                        <Label for="price">Precio de compra*</Label>
                        <CurrencyInput v-model="form.step1.unit_price" :tabindex="4" />
                        <InputError :message="form.errors.step1?.unit_price" />
                    </div>
                </div>

                <div class="tab" v-if="currentStep == 1">
                    <div class="grid gap-2 ">
                        <Label for="price">Sección*</Label>
                        <div class="border-2 bg-[#ffffff] p-2 rounded-md dark:bg-[#000000] ">
                            <Select v-model="form.step2.sector_id" :options="sections" optionLabel="name"
                                option-value="id" class="w-full" />
                        </div>
                        <InputError :message="form.errors.step2?.sector_id" />
                    </div>

                    <div class="grid gap-2 mt-4">
                        <Label for="price">Ingrediente*</Label>
                        <div class="border-2 bg-[#ffffff] p-2 rounded-md dark:bg-[#000000] ">
                            <Select v-model="form.step2.ingredient_id" :options="ingredients" optionLabel="name"
                                option-value="id" placeholder="Ingredientes" class="w-full" />
                                
                        </div>
                        <InputError :message="form.errors.step2?.ingredient_id" />
                    </div>

                    <div class="grid grid-cols-2 gap-2 mt-4">
                        <div>
                            <Label for="quantity">Cantidad*</Label>
                            <Input min="0" id="quantity" type="number" required autofocus :tabindex="1"
                                v-model="form.step2.quantity" placeholder="1250" />
                            <InputError :message="form.errors.step2?.quantity" />
                        </div>
                        <div>
                            <Label for="presentation">Unidad*</Label>
                            <Input id="presentation_2" type="text" required autofocus :tabindex="1"
                                v-model="form.step2.presentation" placeholder="gr" :value="presentation"/>
                            <InputError :message="form.errors.step2?.presentation" />
                        </div>
                    </div>

                </div>

                <div class="flex">
                    <Button class="mt-4" :tabindex="4" :disabled="form.processing || currentStep < 1"
                        v-on:click="stepBack()">
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        Anterior
                    </Button>

                    <div class="justify-self-stretch w-full "></div>

                    <Button type="button" class="mt-4" :tabindex="4" :disabled="form.processing"
                        v-on:click="currentStep == 0 ? nextStep() : create()">
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        {{ btn2Title }}
                    </Button>

                </div>
                <Button class="mt-4" :tabindex="4" :disabled="form.processing" v-on:click="submit()">
                    Guardar
                </Button>
            </form>

        </div>

    </AppLayout>
</template>