<script setup lang="ts">
import {  X } from 'lucide-vue-next';
import Heading from '../Heading.vue';

defineProps({
    list: [],
})

</script>
<template>
    <div class="">
        <Heading title="Ingredientes bajos" description="Que deberias comprar?"/>
        <ul>
        <li class="flex flex-row align-middle" v-for="item in list" v-bind:key="item.id"><X height="20" class="my-auto"/>
            <p>{{ item.name }}</p>
            <p class="flex-grow border border-bottom border-dotted border-black" ></p>
        </li>
    </ul>
    </div>
    
    
</template>