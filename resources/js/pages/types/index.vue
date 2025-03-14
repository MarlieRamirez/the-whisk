<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import SmallCards from '@/components/small_model/SmallCards.vue';

import Empty from '@/components/Empty.vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Secciones de receta',
        href: '/types',
        add: true
    }
];

defineProps<{
    list_of: [];
}>();

</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbItems" >
        <Head title="Secciones de receta" />

        <div class="grid grid-cols-4 gap-4" v-if="list_of.length >0">
            <SmallCards :list_of="list_of" link="types" />
        </div>

        <Empty v-else/>
        
    </AppLayout>
</template>