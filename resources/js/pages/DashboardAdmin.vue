<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import LowStock from '@/components/small_model/LowStock.vue';
import RecipeWidget from '@/components/small_model/RecipeWidget.vue';

defineProps<{
  lowStock: [{ id: string, name: string, unit: string }],
  total_count: [],
  recipes: []
}>();


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


      <div class="grid  auto-rows-min gap-4 md:grid-cols-3">
        <div
          class="bg-[#ffffff33] p-5 relative aspect-[16/12] overflow-auto rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
          <LowStock :list="lowStock" :total_count="total_count" />
        </div>
        <div
          class="bg-[#ffffff33] p-5 relative aspect-[16/12] overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
          <RecipeWidget title="Recetas de las semanas" subtitle="Ingresar que recetas se hicieron esta semana"
            :recipes="recipes" />
        </div>
        <div
          class="bg-[#ffffff33] p-5 relative aspect-[16/12] overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
          <RecipeWidget title="Ventas de unidades" subtitle="Ventas de la semana" :recipes="recipes" :state="true" />
        </div>
      </div>
      <div class="grid auto-rows-min gap-4 md:grid-cols-2">
        <div class="relative aspect-[17/9] rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
          <PlaceholderPattern />
        </div>
        <div
          class="relative aspect-[17/9] aspect-auto rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
          <PlaceholderPattern />
        </div>
      </div>

    </div>
  </AppLayout>
</template>
