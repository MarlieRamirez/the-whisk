<script setup lang="ts">
import { type BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import InputError from '@/components/InputError.vue';
import Select from 'primevue/select';
import { computed } from 'vue';

const props = defineProps<{
    in: boolean;
    ingredients: [any],
}>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Inventario',
        href: '/brand'
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
    ingredient_id: 0,
    //description auto pero que exista
    description: ' ',
    quantity: 0,
    from: 1,
    total: 0,
    price:0,
    session: ' ',
});

const submit = () => {
    form.post(route('storage.store'), {});
};


const current = computed(() => {
    return props.ingredients.filter((x) => x.id == form.ingredient_id)[0] || 0

})
</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

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

                <div class="grid gap-2 grid-cols-3">
                    <div class="">
                        <Label for="quantity">Cantidad*</Label>
                        <Input min="0" id="quantity" type="number" required autofocus :tabindex="2"
                            v-model="form.quantity" placeholder="1250" />
                        <InputError :message="form.errors.quantity" />
                    </div>
                    <div class="col-span-2">
                        <Label for="ingredientes">Ingrediente*</Label>
                        <div class="border-2 bg-[#ffffff] p-2 rounded-md dark:bg-[#000000] ">
                            <Select name="ingredientes" v-model="form.ingredient_id" :options="ingredients"
                                optionLabel="name"  option-value="id"
                                placeholder="Ingredientes" class="w-full" @update:model-value="form.price = current.price"/>

                        </div>
                        <InputError :message="form.errors.ingredient_id" />
                    </div>
                </div>
                <div class="grid gap-2 ">
                    <Label for="price">Precio por unidad*</Label>
                    <Input id="presentation_2" type="number" required autofocus :tabindex="1" v-model="form.price" 
                        placeholder="price" />
                    <!-- <CurrencyInput v-model="form.total" autofocus/> -->
                </div>


                <Button class="mt-4" :tabindex="4" :disabled="form.processing" v-on:click="submit()">
                    Guardar
                </Button>

            </form>
        </div>

    </AppLayout>
</template>