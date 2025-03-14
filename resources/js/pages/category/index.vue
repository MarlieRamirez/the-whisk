<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import SmallCards from '@/components/small_model/SmallCards.vue';
import Empty from '@/components/Empty.vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Categorias',
        href: '/category',
        add: true
    }
];

defineProps<{
    categories: [];
}>();

</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbItems" >
        <Head title="Categorias" />

        <div class="grid grid-cols-4 gap-4" v-if="categories.length >0">
            <SmallCards :list_of="categories" link="category" />
        </div>
        <Empty v-else/>
    </AppLayout>
</template>