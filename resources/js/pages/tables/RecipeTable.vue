<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import Empty from '@/components/Empty.vue';
import { Toaster, toast } from 'vue-sonner'
import { computed, onMounted, onUpdated } from 'vue';
import TableLayout from '@/components/table/TableLayout.vue';
import ViewModal from '@/components/ViewModal.vue';
import { ChevronRight, Edit } from 'lucide-vue-next';
import DeleteModal from '@/components/DeleteModal.vue';

const props = defineProps<{
    list_of: [any];
    title: string;
    href: string
    add: boolean
    updated: false
    sector: [any]
    ingredients: [any]
}>();



const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: props.title,
        href: '/' + props.href,
        add: props.add
    }
];

const titles = ['Nombre', 'Cantidad Total', 'Precio Unitario', 'Costo del lote'];

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

const list = computed(() => {
    return props.list_of.filter((x: any) => x.status == 1);
})

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head :title="title" />
        <Toaster richColors position="bottom-right" />

        <div class="w-auto mt-8 " v-if="list_of.length > 0">
            <TableLayout link="ingredient" :titles="titles">
                <template v-slot:body>
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-100 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600"
                        v-for="item in list" v-bind:key="item.id">

                        <td class="pl-4"> {{ item.name }}</td>
                        <td class="pl-4"> {{ item.quantity }} {{ item.presentation }}</td>
                        <td class="pl-4"> {{ item.unit_price }}</td>
                        <td class="pl-4"> {{ item.batch_cost }}</td>
                        <td class="flex justify-around">

                            <DeleteModal class="w-min" link="recipe" :id="item.id" />
                            <ViewModal :sector="sector" link="recipe" :item="item" :ingredient="ingredients">
                                <div
                                    class="lg:mx-0 mx-2 cursor-pointer bg-blue-300 hover:bg-blue-400 dark:bg-blue-100 dark:hover:bg-blue-300 rounded-full p-2 my-2">
                                    <Edit class="stroke-gray-600 dark:stroke-gray-600" />
                                </div>
                            </ViewModal>
                            <Link :href="route('details.index', item.id)" title="Editar ingrediente">
                            <div
                                class="cursor-pointer bg-emerald-300 hover:bg-emerald-400 dark:bg-green-100 dark:hover:bg-green-300 rounded-full p-2 my-2">
                                <ChevronRight class="stroke-gray-600 dark:stroke-gray-600" />
                            </div>
                            </Link>
                        </td>
                    </tr>
                </template>
            </TableLayout>
        </div>
        <Empty v-else />

    </AppLayout>
</template>