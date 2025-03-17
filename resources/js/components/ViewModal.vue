<script setup lang="ts">
import { Link, } from '@inertiajs/vue3';

import {
    Dialog,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
    DialogScrollContent
} from '@/components/ui/dialog';
import { Eye, Pencil } from 'lucide-vue-next';
import SidebarSeparator from './ui/sidebar/SidebarSeparator.vue';
import HeadingSmall from './HeadingSmall.vue';

defineProps<{
    link: string,
    item: {
        id: string;
        name: string;
        details: any;
        sector: any;
        quantity: any;
        presentation: any;
        ingredients: any;

    };
    sector: [any];
}>();

</script>

<template>
    <Dialog>
        <DialogTrigger as-child title="View">
            <div
                class="cursor-pointer bg-blue-300 hover:bg-blue-400 dark:bg-blue-100 dark:hover:bg-blue-300 rounded-full p-2 my-2">
                <Eye :size="25" class="stroke-gray-600 dark:stroke-gray-600" />
            </div>
        </DialogTrigger>

        <DialogScrollContent class="max-w-3xl">

            <DialogHeader class="space-y-3">
                <DialogTitle>{{ item.quantity }} {{ item.presentation }} de {{ item.name }}</DialogTitle>
            </DialogHeader>
            <SidebarSeparator />

            <DialogDescription>
                <div v-for="sect in sector" v-bind:key="sect.id">
                    <!-- Use find to check if i need to show the section -->
                    <HeadingSmall class="mt-4" :title="sect.name"
                        v-if="item.details.find((o: any) => o.sector_id === sect.id) != undefined" />

                    <div v-for="detail in item.details" v-bind:key="detail.id">
                        <div v-if="detail.sector_id == sect.id" class="flex text-[#000000] dark:text-[#ffffff]">
                            <p class="flex-none text-base mt-1">{{ item.ingredients[detail.ingredient_id].name }}
                            </p>
                            <div
                                class="justify-self-stretch border-dotted w-full border-b-2 border-bottom border-[#000000] dark:border-[#ffffff]">
                            </div>
                            <p class="flex-none text-base mt-1 text-[#000000] dark:text-[#ffffff]">{{ detail.quantity }} {{ detail.presentation }}</p>
                        </div>
                    </div>

                </div>

            </DialogDescription>

            <DialogFooter class="gap-2">
                <Link  :href="route('ingredient.edit', item.id)" title="Editar ingrediente">
                <div
                    class="bg-blue-300 hover:bg-blue-400 dark:bg-blue-100 dark:hover:bg-blue-300 rounded-full p-2 my-2 flex">
                    <Pencil :size="25" class="stroke-gray-600 dark:stroke-gray-600" />
                    <p class="mx-2 text-gray-600 dark:text-gray-800 font-bold">Editar</p>
                </div>
                </Link>


            </DialogFooter>

        </DialogScrollContent>
    </Dialog>

</template>
