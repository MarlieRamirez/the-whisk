<script setup lang="ts">
import { Breadcrumb, BreadcrumbItem, BreadcrumbLink, BreadcrumbList, BreadcrumbPage, BreadcrumbSeparator } from '@/components/ui/breadcrumb';
import { Link } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';

interface BreadcrumbItem {
    title: string;
    href?: string;
    add?:false;
}

defineProps<{
    breadcrumbs: BreadcrumbItem[];
}>();
</script>

<template>
    
    <Breadcrumb class="w-full flex flex-row justify-between">
        <BreadcrumbList>
            <template v-for="(item, index) in breadcrumbs" :key="index">
                <BreadcrumbItem>
                    <template v-if="index === breadcrumbs.length - 1">
                        <BreadcrumbPage>{{ item.title }}</BreadcrumbPage>
                    </template>
                    <template v-else>
                        <BreadcrumbLink as-child>
                            <Link :href="item.href ?? '#'">{{ item.title }}</Link>
                        </BreadcrumbLink>
                    </template>
                </BreadcrumbItem>
                <BreadcrumbSeparator v-if="index !== breadcrumbs.length - 1" />
                
                
            </template>
            
            
           
        </BreadcrumbList>

        <Link v-if="breadcrumbs[0].add" :href="breadcrumbs[0].href+'/new'" class="justify-end ml-4 ">
            <div class="flex flex-row rounded-full py-1 pl-2 pr-5 bg-green-600 text-neutral-100 hover:bg-green-700 hover:text-neutral-100">
                <Plus class="self-center flex-none" width="30"/>
                <p class="flex-grow text-lg">Agregar</p>
            </div>
        </Link>

    </Breadcrumb>

    
</template>
