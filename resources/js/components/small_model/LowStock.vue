<script setup lang="ts">
import { Box, X } from 'lucide-vue-next';
import Heading from '../Heading.vue';
import { Link } from '@inertiajs/vue3';

defineProps<{
  list: [{ id: string, name: string, unit: string }],
  total_count: []
}>();
</script>
<template>
  <div class="">
    <Heading title="Ingredientes bajos" description="Que deberias comprar?" />
    <ul class="">
      <li class="flex flex-row align-middle" v-for="item, index in list" v-bind:key="item.id">
        <X height="20" class="my-auto" />
        <p class="">{{ item.name }}</p>
        <p class="flex-grow border-b-2 border-dotted border-bottom border-[#000000] dark:border-[#ffffff]"></p>
        <p>{{ total_count[index] }} {{ item.unit }}</p>


      </li>
    </ul>
    <Link :href="route('storage.index')" title="Ver todos los movimientos"
      class="absolute bottom-0 inset-x-0 mx-8 mb-4">
    <div
      class=" cursor-pointer bg-emerald-300 hover:bg-emerald-400 dark:bg-green-100 dark:hover:bg-green-300 rounded-full p-2 my-2 flex ">
      <Box class="stroke-gray-600 dark:stroke-gray-600" />
      <p class="ml-4 text-gray-600 dark:text-gray-800"><b>Hacer inventario</b></p>
    </div>
    </Link>
  </div>


</template>