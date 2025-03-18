<script setup lang="ts">

defineProps<{
    titles: string[];
    link: string;
}>();


</script>
<style>
/* table, th, td {
  border: 1px solid black;
} */
</style>

<template>
    <div class="w-full flex justify-center">
        <table class="w-3/4 text-sm text-left rtl:text-center border rounded-full text-gray-500 dark:text-gray-400 shadow-md sm:rounded-lg">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3" v-for="item in titles" v-bind:key="item">{{ item }}</th>
                    <th scope="col" class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <slot name="body"></slot>
            </tbody>

            <tfoot>
                <slot name="foot"></slot>
            </tfoot>
        </table>
    </div>


</template>