<script setup lang="ts">
import { type BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import InputError from '@/components/InputError.vue';
import Select from 'primevue/select';
import { computed, ref } from 'vue';
import { toast, Toaster } from 'vue-sonner';


const props = defineProps<{
    in: boolean;
    ingredients: [any],
    totals?: [any]
    id?: number
}>();


const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Inventario',
        href: '/storages'
    },
    {
        title: props.in ? 'Agregar al inventario' : 'Restar del inventario',
        href: '/storage/new'
    },
];

const breadcrumbItemsID: BreadcrumbItem[] = [
    {
        title: 'Inventario',
        href: '/storages'
    },
    {
        title: 'De ingrediente',
        href: '/storage/product/' + props.id
    },
    {
        title: props.in ? 'Agregar al inventario' : 'Restar del inventario',
        href: '/storage/new'
    },
];

const title = props.in ? 'Agregar al inventario' : 'Restar del inventario'

//No updates for records
const form = useForm({
    id: '',
    movement: props.in ? 'Entrada' : 'Salida',
    //meti tanto de este material
    //limpie todo de este material
    ingredient_id: props.id ? props.id : 0,
    //description auto pero que exista
    description: '',
    quantity: 0,
    from: 1,
    total: 0,
    price: 0,
    session: ' ',
    records: 0,
    unit: '',
    to_movement: props.id ? true : false
});


const submit = () => {
    form.description = description.value;

    if (props.totals && props.totals[index.value] < form.quantity) {
        return toast.error("Se esta intentando restar más de lo que se tiene en inventario");
    } else {
        form.post(route('storage.store'), {});
    }

};


const current = computed(() => {
    return props.ingredients.filter((x) => x.id == form.ingredient_id)[0] || 0
})

const index = computed(() => {
    return props.ingredients.findIndex((x) => x.id == form.ingredient_id);
})

const description = computed(() => {
    if (form.ingredient_id != 0) {
        return (form.quantity + ' ' + current.value.unit + ' de ' + props.ingredients.find((x: any) => x.id == form.ingredient_id).name);
    } else {
        return '';
    }

})
const a = ref(current.value.name);
const unit = ref(current.value.unit || '');

</script>
<template>
    <AppLayout :breadcrumbs="id ? breadcrumbItemsID : breadcrumbItems">
        <Toaster rich-colors position="top-center" />

        <Head title="Manejar inventario" />
        <div class=" m-3 flex flex-row justify-center">

            <form @submit.prevent="submit"
                class="flex flex-col gap-6 md:w-1/2 border rounded-3xl border-neutral-400 m-3 p-6">
                <p class="text-center text-2xl font-bold">{{ title }}</p>

                <div class="grid gap-2 ">
                    <Label for="movement">Movimiento*</Label>
                    <Input disabled id="movement" name="movement" autofocus v-model="form.movement" :tabindex="1"
                        placeholder="Harina de trigo para pastelería" />
                </div>
                <div>
                    <div class="grid grid-flow-col auto-cols-fr gap-2">

                        <div class="">
                            <Label for="quantity">Cantidad*</Label>
                            <Input min="0" id="quantity" type="number" required autofocus :tabindex="2"
                                v-model="form.quantity" placeholder="1250" />
                            <InputError :message="form.errors.quantity" />
                        </div>


                        <div class="" v-if="!props.in">
                            <Label for="presentation">Unidades</Label>
                            <Input v-if="unit != ''" id="presentation_2" type="text" required autofocus :tabindex="3"
                                disabled :value="unit" v-model="unit" />

                            <Input v-else id="presentation_2" type="text" required autofocus :tabindex="3"
                                :value="current.unit" />
                            <!-- <InputError :message="form.errors.step2?.presentation" /> -->
                        </div>

                        <div>
                            <Label for="ingredientes">De Ingrediente*</Label>
                            <div class="border-2 bg-[#ffffff] p-2 rounded-md dark:bg-[#000000]" v-if="!id">

                                <Select :tabindex="4" name="ingredientes" :options="ingredients" optionLabel="name"
                                    v-model="form.ingredient_id" option-value="id" placeholder="Ingredientes"
                                    class="w-full" @update:model-value="form.price = current.price" />

                                <!-- @vue:mounted="form.ingredient_id != 0 ? form.price = current.price : 0" -->
                            </div>

                            <Input v-else disabled :model-value="a"
                                @vue:mounted="form.ingredient_id != 0 ? form.price = current.price : 0" />
                            <InputError :message="form.errors.ingredient_id" />
                        </div>
                    </div>
                    <p class="mt-2" v-if="props.in"><b>Cantidad Total: </b>{{ current.quantity * form.quantity || 0 }}
                        {{ current.unit || '' }}</p>

                    <p class="text-sm" v-else><b>Máximo en inventario: </b>{{ totals![index] || '' }} {{ unit ||
                        current.unit}}</p>

                </div>

                <div class="grid gap-2 " v-if="props.in">
                    <Label for="price">Precio por paquete*</Label>
                    <Input id="presentation_2" type="number" required autofocus :tabindex="5" v-model="form.price"
                        step="0.01" placeholder="price" />
                    <!-- <CurrencyInput v-model="form.total" autofocus/> -->
                </div>
                <Button class="mt-4" :tabindex="6" :disabled="form.processing" v-on:click="submit()">
                    Guardar
                </Button>

            </form>
        </div>

    </AppLayout>
</template>