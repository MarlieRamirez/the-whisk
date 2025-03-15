<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import Empty from '@/components/Empty.vue';
import { Toaster, toast } from 'vue-sonner'
import { onMounted, onUpdated } from 'vue';
import TableLayout from '@/components/table/TableLayout.vue';
import { Pencil } from 'lucide-vue-next';
import DeleteModal from '@/components/DeleteModal.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    list_of: [{ id: string, name: string, description: string }];
    title: string;
    href: string
    add: boolean
    updated: false
}>();



const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: props.title,
        href: '/' + props.href,
        add: props.add
    }
];

const titles = ['Nombre', 'Marca', 'Categoria', 'Tamaño'];

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

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head :title="title" />
        <Toaster richColors position="bottom-right" />

        <div v-if="list_of.length > 0">
            <TableLayout link="ingredient" :titles="titles">
                <tr v-for="item in list_of" v-bind:key="item.id">
                    <td> {{ item.name }}</td>
                    <td> {{ item.brand.name }}</td>
                    <td> {{ item.category.name }}</td>
                    <td> {{ item.quantity }} {{ item.unit }}</td>
                    <td class="flex justify-around">
                        <Link :href="route('ingredient.edit', item.id)">
                            <div class="bg-blue-300 hover:bg-blue-400 dark:bg-blue-100 dark:hover:bg-blue-400 rounded-full p-2 my-2">
                                <Pencil :size="25" class="stroke-gray-600 dark:stroke-gray-600" />
                            </div>
                        </Link>

                        <DeleteModal class="w-min" link="ingredient" :id="item.id" />
                    </td>
                </tr>
            </TableLayout>
        </div>
        <Empty v-else />
    </AppLayout>
</template>