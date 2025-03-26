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
import { toast, Toaster } from 'vue-sonner';
import CurrencyInput from '@/components/CurrencyInput.vue';


const props = defineProps<{
    in: boolean;
    recipe: [any]
}>();


const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Saldo',
        href: '/balances'
    },
    {
        title: props.in ? 'Agregar al balance' : 'Restar del balance',
        href: '/balance/add'
    },
];

const title = props.in ? 'Agregar al Saldo' : 'Restar del saldo'

//No updates for records
const form = useForm({
    id: '',
    movement: props.in ? 'Entrada' : 'Salida',
    description: '',
    balance: 0,

    //only init
    quantity: 0,
    pprice: 0,
    unit: '',
    session: '',
    recipe_id: 0,
    current_balance: 0,
    // to_movement: props.id ? true : false
});


const submit = () => {
    // form.description = description.value;
    return toast.error("Se esta intentando restar más de lo que se tiene en inventario");

};


const current = computed(() => {
    return props.recipe.filter((x) => x.id == form.recipe_id)[0] || 0
})

</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
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

                <!-- SUMAR -->
                <div v-if="props.in" class="grid gap-4">
                    <div class="grid gap-2 ">
                        <Label for="recipe">Postre*</Label>
                        <div class="border-2 bg-[#ffffff] p-2 rounded-md dark:bg-[#000000]">

                            <Select :tabindex="4" name="recipe" :options="recipe" optionLabel="name"
                                v-model="form.recipe_id" option-value="id" placeholder="Postre" class="w-full"
                                @update:model-value="form.balance = current.unit_price; form.unit = current.presentation" />

                        </div>
                    </div>

                    <div class="grid grid-flow-col auto-cols-fr gap-2">

                        <div class="">
                            <Label for="quantity">Cantidad*</Label>
                            <Input min="0" id="quantity" type="number" required autofocus :tabindex="2"
                                v-model="form.quantity" placeholder="1250" />
                            <InputError :message="form.errors.quantity" />
                        </div>


                        <div class="">
                            <Label for="presentation">Unidades</Label>
                            <Input id="presentation_2" type="text" required autofocus :tabindex="3" v-model="form.unit"/>
                            <!-- <InputError :message="form.errors.step2?.presentation" /> -->
                        </div>
                    </div>

                    <div class="grid gap-2 ">
                        <Label for="price">Precio de venta*</Label>
                        <Input v-model="form.balance" id="presentation_2" type="number" required autofocus :tabindex="5" step="0.01"
                            placeholder="price" />
                        <!-- <CurrencyInput v-model="form.total" autofocus/> -->
                    </div>
                </div>

                <!-- RESTAR -->

                <div v-else>
                    <div class="grid gap-6">
                        <div class="grid gap-2 ">
                            <Label for="movement">Descripción*</Label>
                            <Input id="movement" name="movement" autofocus v-model="form.description" :tabindex="1"
                                placeholder="Mensualidad junio 2025" />
                        </div>

                        <div class="grid gap-2 ">
                            <Label for="movement">Saldo a restar*</Label>
                            <CurrencyInput :model-value="form.balance" />
                        </div>
                    </div>
                </div>


                <Button class="mt-4" :tabindex="6" :disabled="form.processing" v-on:click="submit()">
                    Guardar
                </Button>

            </form>
        </div>

    </AppLayout>
</template>