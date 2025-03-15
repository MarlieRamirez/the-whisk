<script setup lang="ts">
import { type BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import CurrencyInput from '@/components/CurrencyInput.vue';
import InputError from '@/components/InputError.vue';
import Select from 'primevue/select';

const props = defineProps<{
    model?: { id: string, quantity: number, unit: string, price: number,brand_id:string, category_id:string,name:string};
    categories: [{ id: string, name: string, description: string }];
    brand: [{ id: string, name: string }];
}>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Ingredientes',
        href: '/ingredients'
    },
    {
        title: props.model ? 'Actualizar' : 'Agregar',
        href: '/ingredient/new'
    },
];

const title = props.model ? 'Editar Ingrediente' : 'Nuevo Ingrediente';

const form = useForm({
    id: props.model ? props.model.id : '',
    brand_id: props.model ? props.model.brand_id : null,
    category_id: props.model ? props.model.category_id : null,
    unit: props.model ? props.model.unit : '',
    quantity: props.model ? props.model.quantity : '',
    price: props.model ? props.model.price : 0,
    name: props.model ? props.model.name : '',
    
});

const submit = () => {
    if (props.model) {
        form.put('/ingredient/' + form.id, {});
    } else {
        form.post(route('ingredient.store'), {});
    }

};



</script>

<template>

    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Agregar Categorias" />
        <div class=" m-3 flex flex-row justify-center">

            <form @submit.prevent="submit"
                class="flex flex-col gap-6 md:w-1/2 border rounded-3xl border-neutral-400 m-3 p-6">
                <p class="text-center text-2xl font-bold">{{ title }}</p>
                <div class="grid gap-6">
                    <div class="grid gap-2 ">
                        <Label for="price">Marca*</Label>
                        <div class="border-2 bg-[#ffffff] p-2 rounded-md">
                            <Select v-model="form.brand_id" :options="brand" optionLabel="name" option-value="id" placeholder="Marca del producto" class="w-full"/>
                        </div>
                        <InputError :message="form.errors.price" />
                    </div>
                    <div class="grid gap-2 ">
                        <Label for="price">Categoria del producto*</Label>
                        <div class="border-2 bg-[#ffffff] p-2 rounded-md">
                            <Select v-model="form.category_id" :options="categories" optionLabel="name"  option-value="id" placeholder="Categoria del producto" class="w-full"/>
                        </div>
                        <InputError :message="form.errors.price" />
                    </div>

                    <div class="grid gap-2 ">
                        <Label for="price">Nombre Completo*</Label>
                        <Input id="name" name="name" required autofocus v-model="form.name"
                        placeholder="Harina de trigo para pastelería"  />
                        <InputError :message="form.errors.price"/>
                    </div>

                    <div class="grid grid-cols-2 gap-2 ">
                        <div>
                            <Label for="quantity">Cantidad*</Label>
                            <Input id="quantity" type="number" required autofocus :tabindex="1" v-model="form.quantity"
                                placeholder="1250" />
                            <InputError :message="form.errors.quantity" />
                        </div>
                        <div>
                            <Label for="unit">Unidad de Medida*</Label>
                            <Input id="unit" type="text" required autofocus :tabindex="1" v-model="form.unit"
                                placeholder="gr" />
                            <InputError :message="form.errors.unit" />
                        </div>
                    </div>

                    <div class="grid gap-2 ">
                        <Label for="price">Precio de compra*</Label>
                        <CurrencyInput v-model="form.price" />
                        <InputError :message="form.errors.price" />
                    </div>

                    

                </div>


                <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Insertar
                </Button>
            </form>
        </div>

    </AppLayout>
</template>