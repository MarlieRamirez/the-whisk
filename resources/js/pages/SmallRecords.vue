<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import SmallCards from '@/components/small_model/SmallCards.vue';
import Empty from '@/components/Empty.vue';

const props = defineProps<{
    list_of: [];
    title: string;
    href: string
    add: boolean
}>();



const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: props.title,
        href: '/'+props.href,
        add: props.add
    }
];


</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbItems" >
        <Head :title="title" />

        <div class="grid grid-cols-4 gap-4" v-if="list_of.length >0">
            <SmallCards :list_of="list_of" :link="href" />
        </div>
        <Empty v-else/>
    </AppLayout>
</template>