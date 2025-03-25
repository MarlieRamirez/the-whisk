<script setup lang="ts">
import DeleteModal from '@/components/DeleteModal.vue';
import Empty from '@/components/Empty.vue';
import Heading from '@/components/Heading.vue';
import TableLayout from '@/components/table/TableLayout.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Check,  Minus, Plus } from 'lucide-vue-next';

import { computed, onMounted, onUpdated } from 'vue';
import { toast, Toaster } from 'vue-sonner';

const props = defineProps<{
    href: string,
    list_of: any,
    title: string;
    id:number
    updated: false
}>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Inventario',
        href: '/storages',

    },
    {
        title: 'de Ingrediente',
        href: '/storages',

    }
];

const titles = ['Descripción', 'Tipo de movimiento', 'Cantidad', 'Sesión'];

onMounted(() => {
    if (props.updated) {
        toast.success("Se han guardado los cambios")
    }
});

onUpdated(() => {
    if (props.updated) {
        toast.success("Se han guardado los cambios")
    }
})

const list: any = computed(() => {
    return Object.values(props.list_of)
})

</script>


<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head :title="title" />
        <Toaster richColors position="bottom-right" />

        <div class="flex mt-4">
            <Link :href="route('storage.minus', id)" title="Editar ingrediente" class="ml-8">
            <div
                class="cursor-pointer bg-red-300 hover:bg-red-400 dark:bg-red-100 dark:hover:bg-red-300 rounded-full p-2">
                <Minus class="stroke-gray-600 dark:stroke-gray-600" />
            </div>
            </Link>

            <Heading class="text-center flex-grow align-middle mb-0" title="Espacio de inventario"
                description="Puede registrar sus entradas u usos de ingredientes" />

            <Link :href="route('storage.add', id)" title="Editar ingrediente" class="mr-8">
            <div
                class="cursor-pointer bg-emerald-300 hover:bg-emerald-400 dark:bg-emerald-100 dark:hover:bg-emerald-300 rounded-full p-2">
                <Plus class="stroke-gray-600 dark:stroke-gray-600" />
            </div>
            </Link>
        </div>

        <div class="w-auto mb-8 " v-if="list.length > 0">

            <TableLayout link="ingredient" :titles="titles">
                <template v-slot:body>

                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-100 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600"
                        v-for="item, i in list_of" v-bind:key="item.id">

                        <td class="pl-4 ">{{ item.description }}</td>
                        <td class="pl-4"> {{ item.movement.toUpperCase() }}</td>
                        <td class="pl-4 ">{{ item.quantity }}</td>
                        <td class="pl-4"> {{ item.session }}</td>

                        <td class="flex justify-around">
                            <DeleteModal v-if="i == list.length-1" :link="href" :id="item.id"/>
                            
                            <div v-else
                                class="bg-emerald-300 dark:bg-green-100 rounded-full p-2 my-2">
                                <Check  class="stroke-gray-600 dark:stroke-gray-600" />
                            </div>

                        </td>
                    </tr>
                </template>

                <template v-slot:foot>
                    <tr class="bg-gray-300 dark:bg-gray-700 font-semibold text-gray-900 dark:text-white">
                        <th scope="row" class="px-6 py-3 text-base">Total</th>
                        <td class="px-6 py-3"></td>

                        <td class="px-4 py-3">{{ Object.values(list)[list.length - 1]!.total || 0 }}</td>
                        <td class="px-6 py-3"></td>
                        <td class="px-6 py-3"></td>
                    </tr>
                </template>
            </TableLayout>

        </div>
        <Empty v-else />


    </AppLayout>

</template>