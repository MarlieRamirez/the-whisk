<script setup lang="ts">
import Card from '@/components/ui/card/Card.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardFooter from '@/components/ui/card/CardFooter.vue';
import {Link } from '@inertiajs/vue3';
import { Pencil,Trash2 } from 'lucide-vue-next';
import DeleteModal from '../DeleteModal.vue';

defineProps<{
    list_of: [];
    link: string;
}>();
</script>

<template>
    <Card class="m-2" v-for="item in list_of" v-bind:key="item.id">
        <CardTitle class="text-center my-2 text-xl">{{ item.name }}</CardTitle>
        <CardContent class="mt-4 text-center">{{ item.description }}</CardContent>
        <CardFooter class="border border-t-4 justify-around pb-4">
                    
            <Link :href="route( link+'.edit', item.id)">
                <div class="bg-blue-300 hover:bg-blue-400 dark:bg-blue-100 dark:hover:bg-blue-400 rounded-full p-2 mt-4"><Pencil :size="25" class="stroke-gray-600 dark:stroke-gray-600" /></div>
            </Link>
                 
            <DeleteModal :link="link" :id="item.id" />
            <!-- <Link :href="route(link+'.destroy')">
                <div class="bg-red-500 hover:bg-red-800 dark:bg-red-200 dark:hover:bg-red-400 rounded-full p-2 mt-4"><Trash2  :size="25" class="stroke-pink-100 dark:stroke-pink-800" /></div>
            </Link> -->
                    
        </CardFooter>
    </Card>
</template>