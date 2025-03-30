<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import LowStock from '@/components/small_model/LowStock.vue';

defineProps({
    lowStock: []
})

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Administración',
        href: '/admin',
    },
];
</script>

<template>

    <Head title="Administración" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            
            
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-auto rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <LowStock :list="lowStock"/>
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>

            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                <div class="relative aspect-[17/9] rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-[17/9] aspect-auto rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
            
            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                <div class="relative aspect-[17/9] rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-[17/9] aspect-auto rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>

        </div>
    </AppLayout>
</template>
