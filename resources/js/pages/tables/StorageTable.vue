<script setup lang="ts">
import Empty from '@/components/Empty.vue';
import Heading from '@/components/Heading.vue';
import TableLayout from '@/components/table/TableLayout.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { ChevronRight, Minus, Plus } from 'lucide-vue-next';

import { computed, onMounted, onUpdated } from 'vue';
import { toast, Toaster } from 'vue-sonner';

const props = defineProps<{
    href: string,
    list_of: any,
    list_totals:any,
    title: string;
    updated: false
}>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Inventario',
        href: '/storages',

    }
];

const titles = ['Ingrediente', 'Cantidad de empaque', 'Cantidad en Inventario', 'Precio'];

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
            <Link :href="route('storage.minus')" title="Editar ingrediente" class="ml-8">
            <div
                class="cursor-pointer bg-red-300 hover:bg-red-400 dark:bg-red-100 dark:hover:bg-red-300 rounded-full p-2">
                <Minus class="stroke-gray-600 dark:stroke-gray-600" />
            </div>
            </Link>

            <Heading class="text-center flex-grow align-middle mb-0" title="Espacio de inventario"
                description="Puede registrar sus entradas u usos de ingredientes" />

            <Link :href="route('storage.add')" title="Editar ingrediente" class="mr-8">
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
                        v-for="item, index in list" v-bind:key="item.id">

                        <td class="pl-4 ">{{ item.name }}</td>
                        <td class="pl-4 ">{{ item.quantity }} {{ item.unit }}</td>
                        <td class="pl-4 " :class="list_totals[index] > 0 ? 'text-green-600 dark:text-green-200': 'text-red-600 dark:text-red-200'">{{ list_totals[index] }} {{ item.unit }}</td>
                        <td class="pl-4"> C$ {{ item.price }}</td>
                        
                        <td class="flex justify-around">

                            <Link :href="route('storage.product.index', item.id)" title="Ver todos los movimientos">
                            <div
                                class="cursor-pointer bg-emerald-300 hover:bg-emerald-400 dark:bg-green-100 dark:hover:bg-green-300 rounded-full p-2 my-2">
                                <ChevronRight class="stroke-gray-600 dark:stroke-gray-600" />
                            </div>
                            </Link>
                        </td>
                    </tr>
                </template>

                <template v-slot:foot>
                    
                </template>
            </TableLayout>

        </div>
        <Empty v-else />


    </AppLayout>

</template>