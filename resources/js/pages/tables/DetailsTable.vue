<script setup lang="ts">
import DeleteModal from '@/components/DeleteModal.vue';
import Empty from '@/components/Empty.vue';
import TableLayout from '@/components/table/TableLayout.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Pencil } from 'lucide-vue-next';
import { computed, onMounted, onUpdated } from 'vue';
import { toast, Toaster } from 'vue-sonner';

const props = defineProps<{
    recipe: any,
    list_of: any,
    title: string;
    href: string
    add: boolean
    updated: false
}>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Recetas',
        href: '/recipes',
    },
    {
        title: props.title,
        href: '/recipes/' + props.href
    }
];

const titles = ['Sección de receta', 'Ingrediente', 'Cantidad Utilizada', 'Costo de uso'];

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

        <div class="w-auto mt-8 " v-if="list.length > 0">
            <TableLayout link="ingredient" :titles="titles">
                <template v-slot:body>
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-100 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600"
                        v-for="item in list" v-bind:key="item.id">

                        <td class="pl-4 "> {{ item.section.name }}</td>
                        <td class="pl-4 ">{{ item.ingredient.name }}</td>
                        <td class="pl-4"> {{ item.quantity }} {{ item.presentation }}</td>
                        <td class="pl-4 ">C$ {{ item.cost }}</td>
                        <td class="flex justify-around">

                            <DeleteModal class="w-min" link="details" :id="item.id" />
                            <Link :href="route('details.edit', item.id)" title="Editar ingrediente">
                            <div
                                class="cursor-pointer bg-blue-300 hover:bg-blue-400 dark:bg-blue-100 dark:hover:bg-blue-300 rounded-full p-2 my-2">
                                <Pencil class="stroke-gray-600 dark:stroke-gray-600" />
                            </div>
                            </Link>
                        </td>
                    </tr>
                </template>

                <template v-slot:foot>
                    <tr class="bg-gray-300 dark:bg-gray-700 font-semibold text-gray-900 dark:text-white">
                        <th scope="row" class="px-6 py-3 text-base">Total</th>
                        <td class="px-6 py-3"></td>
                        
                        <td class="px-6 py-3"></td>
                        <td class="px-4 py-3">C${{ Object.values(recipe)[0]!!.batch_cost }}</td>
                        <td class="px-6 py-3"></td>
                    </tr>
                </template>
            </TableLayout>

        </div>
        <Empty v-else />


    </AppLayout>

</template>