<script setup lang="ts">

defineProps<{
    titles: string[];
    link: string;
}>();


</script>
<style>
table, th, td {
  border: 1px solid black;
}
</style>

<template>
    <div class="w-full flex justify-center">
        <table class="table-auto  m-4 w-3/4 ">
            <thead>
                <tr>
                    <th v-for="item in titles" v-bind:key="item">{{ item }}</th>
                    <th >Acciones</th>
                </tr>
            </thead>
            <tbody>
                <slot></slot>
            </tbody>
        </table>
    </div>


</template>