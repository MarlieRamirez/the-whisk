<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, CircleDollarSign, FolderArchive, Github, LayoutGrid, Warehouse } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Categorias',
        href: '/categories',
        icon: FolderArchive,
    },
    {
        title: 'Secciones para recetas',
        href: '/types',
        icon: FolderArchive,
    },
    {
        title: 'Marcas',
        href: '/brands',
        icon: FolderArchive,
    },
    {
        title: 'Ingredientes',
        href: '/ingredients',
        icon: BookOpen,
    },
    {
        title: 'Receta',
        href: '/recipes',
        icon: BookOpen,
    },
    {
        title: 'Inventario',
        href: '/storages',
        icon: Warehouse,
    },
    {
        title: 'Saldo',
        href: '/balances',
        icon: CircleDollarSign,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'By Marlie',
        href: 'https://github.com/MarlieRamirez/the-whisk',
        icon: Github,
    },
    
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="$page.props.auth.user.role =='admin' ? mainNavItems: []" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
