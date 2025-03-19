<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Toaster } from 'vue-sonner';

import Select from 'primevue/select';
import { LoaderCircle } from 'lucide-vue-next';
import { computed } from 'vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import Label from '@/components/ui/label/Label.vue';
import { Input } from '@/components/ui/input';
import Button from '@/components/ui/button/Button.vue';


const props = defineProps<{
    //for selects
    sections: [any],
    ingredients: [any],
    //reg
    recipe: any,
    detail: {
        ingredient_id: any;
        quantity: any;
        presentation: any;
        cost: any;
        sector_id: any;
        id: string
    }
}>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Recetas',
        href: '/recipes',
    },
    {
        title: 'Detalles',
        href: '/recipes/detail/' + props.recipe.id
    },
    {
        title: 'Editar',
        href: '/recipes/detail/' + props.recipe.id
    },
];

const form = useForm({
    sector_id:props.detail.sector_id,
    recipe_id: props.recipe.id,
    ingredient_id: props.detail.ingredient_id,
    quantity: props.detail.quantity,
    presentation: props.detail.presentation,
    cost: props.detail.cost ,
});

const presentation = computed(() => {
    if (form.ingredient_id != 0) {
        const match = props.ingredients.filter((x) => x.id == form.ingredient_id)
        return match[0].unit;
    }
    else {
        return '';
    }

})

function costValue(){
    const match = props.ingredients.filter((x:any)=> x.id == form.ingredient_id)[0]
    let cost = 0;
    let final = ''
    if(match != undefined){
        cost = match.price/ match.quantity;
        cost = cost * form.quantity
        final = cost.toFixed(2)
    }
    return parseFloat(final);
}

const submit = () => {
    form.cost = costValue();
    form.put('/detail/'+props.detail.id,{});
};
</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Toaster richColors position="top-center" />

        <div class=" m-3 flex flex-row justify-center">

            <Head title="Configurar Receta" />
            <form @submit.prevent="submit" id="regForm"
                class="flex flex-col gap-6 md:w-1/2 border rounded-3xl border-neutral-400 m-3 p-6">

                <div class="flex items-center">
                    <div class="justify-self-stretch w-full">
                        <p class="text-center text-2xl font-bold w-full ">Editar Registro</p>
                        <HeadingSmall class="text-center" :title="recipe.name" />
                    </div>
                </div>


                <div class="grid gap-2 ">
                    <Label for="price">Sección*</Label>
                    <div class="border-2 bg-[#ffffff] p-2 rounded-md dark:bg-[#000000] ">
                        <Select v-model="form.sector_id" :options="sections" optionLabel="name" option-value="id"
                            class="w-full" />
                    </div>
                    <InputError :message="form.errors.sector_id" />
                </div>

                <div class="grid gap-2 mt-4">
                    <Label for="price">Ingrediente*</Label>
                    <div class="border-2 bg-[#ffffff] p-2 rounded-md dark:bg-[#000000] ">
                        <Select v-model="form.ingredient_id" :options="ingredients" optionLabel="name" option-value="id"
                            placeholder="Ingredientes" class="w-full" />

                    </div>
                    <InputError :message="form.errors.ingredient_id" />
                </div>

                <div class="grid grid-cols-2 gap-2 mt-4">
                    <div>
                        <Label for="quantity">Cantidad*</Label>
                        <Input min="0" id="quantity" type="number" required autofocus :tabindex="1"
                            v-model="form.quantity" placeholder="1250" />
                        <InputError :message="form.errors.quantity" />
                    </div>
                    <div>
                        <Label for="presentation">Unidad*</Label>
                        <Input id="presentation_2" type="text" required autofocus :tabindex="1"
                            v-model="form.presentation" placeholder="gr" :value="presentation" />
                        <InputError :message="form.errors.presentation" />
                    </div>
                </div>

                <Button class="mt-4" :tabindex="4" :disabled="form.processing" v-on:click="submit()">
                    <LoaderCircle v-if="form.processing" />
                    Actualizar
                </Button>
            </form>
        </div>

    </AppLayout>
</template>