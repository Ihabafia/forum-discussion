<script lang="ts" setup>
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { AuthItem, type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, LucideHome, LucideLogIn, LucideUserPlus2 } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const page = usePage();

const mainNavItems: NavItem[] = [
    {
        title: 'Home',
        href: '/',
        icon: LucideHome,
        when: true,
    },
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
        when: page.props?.auth?.user,
    },
];

const authNavItems: AuthItem[] = [
    {
        title: 'Register',
        href: route('register'),
        icon: LucideUserPlus2,
        when: !page.props?.auth?.user,
    },
    {
        title: 'Login',
        href: route('login'),
        icon: LucideLogIn,
        when: !page.props?.auth?.user,
    },
];
const footerNavItems: NavItem[] = [
    {
        title: 'Forum Discussion Repo',
        href: 'https://github.com/ihabafia/forum-discussion',
        icon: Folder,
        when: true,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
        when: true,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton as-child size="lg">
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :auths="authNavItems" :items="footerNavItems" />
            <NavUser v-if="page.props?.auth?.user" />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
