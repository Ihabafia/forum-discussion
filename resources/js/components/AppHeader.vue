<script lang="ts" setup>
import AppLogo from '@/components/AppLogo.vue';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu';
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger } from '@/components/ui/sheet';
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';
import UserMenuContent from '@/components/UserMenuContent.vue';
import { getInitials } from '@/composables/useInitials';
import type { BreadcrumbItem, NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Folder, House, LayoutGrid, LucideLogIn, Menu, Search, UserPlus } from 'lucide-vue-next';
import { computed } from 'vue';

interface Props {
    breadcrumbs?: BreadcrumbItem[];
}

const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const page = usePage();
const auth = computed(() => page.props.auth);

const isCurrentRoute = computed(() => (url: string) => page.url === url);

const activeItemStyles = computed(
    () => (url: string) => (isCurrentRoute.value(url) ? 'text-neutral-900 dark:bg-neutral-800 dark:text-neutral-100' : ''),
);

const mainNavItems: NavItem[] = [
    {
        title: 'Home',
        href: '/',
        icon: House,
        when: true,
    },
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
        when: page.props?.auth?.user,
    },
];

const rightNavItems: NavItem[] = [
    {
        title: 'FD Repo',
        href: 'https://github.com/ihabafia/forum-discussion',
        icon: Folder,
        when: true,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
        when: page.props.auth?.user,
    },
];
</script>

<template>
    <div>
        <div class="border-sidebar-border/90 mb-6 border-b bg-gray-50 dark:bg-gray-950">
            <div class="mx-auto flex h-16 items-center px-4 md:max-w-7xl">
                <!-- Mobile Menu -->
                <div class="lg:hidden">
                    <Sheet>
                        <SheetTrigger :as-child="true">
                            <Button class="mr-2 h-9 w-9" size="icon" variant="ghost">
                                <Menu class="h-5 w-5" />
                            </Button>
                        </SheetTrigger>
                        <SheetContent class="w-[300px] p-6" side="left">
                            <SheetTitle class="sr-only">Navigation Menu</SheetTitle>
                            <SheetHeader class="flex justify-start text-left">
                                <AppLogoIcon class="size-6 fill-current text-black dark:text-white" />
                            </SheetHeader>
                            <div class="flex h-full flex-1 flex-col justify-between space-y-4 py-6">
                                <nav class="-mx-3 space-y-1">
                                    <div v-for="item in mainNavItems" :key="item.title">
                                        <Link
                                            v-show="item.when"
                                            :class="activeItemStyles(item.href)"
                                            :href="item.href"
                                            class="hover:bg-accent flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium"
                                        >
                                            <component :is="item.icon" v-if="item.icon" class="h-5 w-5" />
                                            {{ item.title }}
                                        </Link>
                                    </div>
                                </nav>
                                <div class="flex flex-col space-y-4">
                                    <a
                                        v-for="item in rightNavItems"
                                        :key="item.title"
                                        :href="item.href"
                                        class="flex items-center space-x-2 text-sm font-medium"
                                        rel="noopener noreferrer"
                                        target="_blank"
                                    >
                                        <component :is="item.icon" v-if="item.icon" class="h-5 w-5" />
                                        <span>{{ item.title }}</span>
                                    </a>
                                </div>
                            </div>
                        </SheetContent>
                    </Sheet>
                </div>

                <Link :href="route('home')" class="flex items-center gap-x-2">
                    <AppLogo />
                </Link>

                <!-- Desktop Menu -->
                <div class="hidden h-full lg:flex lg:flex-1">
                    <NavigationMenu class="ml-10 flex h-full items-stretch">
                        <NavigationMenuList class="flex h-full items-stretch space-x-2">
                            <div v-for="(item, index) in mainNavItems" :key="index">
                                <NavigationMenuItem v-if="item.when" class="relative flex h-full items-center">
                                    <Link :href="item.href">
                                        <NavigationMenuLink
                                            :class="[navigationMenuTriggerStyle(), activeItemStyles(item.href), 'h-9 cursor-pointer px-3']"
                                        >
                                            <component :is="item.icon" v-if="item.icon" class="mr-2 h-4 w-4" />
                                            {{ item.title }}
                                        </NavigationMenuLink>
                                    </Link>
                                    <div
                                        v-if="isCurrentRoute(item.href)"
                                        class="absolute bottom-0 left-0 h-0.5 w-full translate-y-px bg-black dark:bg-white"
                                    ></div>
                                </NavigationMenuItem>
                            </div>
                        </NavigationMenuList>
                    </NavigationMenu>
                </div>

                <div class="ml-auto flex items-center space-x-2">
                    <div class="relative flex items-center space-x-1">
                        <Button class="group h-9 w-9 cursor-pointer" size="icon" variant="ghost">
                            <Search class="size-5 opacity-80 group-hover:opacity-100" />
                        </Button>

                        <div class="hidden space-x-1 lg:flex">
                            <template v-for="item in rightNavItems" :key="item.title">
                                <TooltipProvider :delay-duration="0">
                                    <Tooltip>
                                        <TooltipTrigger>
                                            <Button as-child class="group h-9 w-9 cursor-pointer" size="icon" variant="ghost">
                                                <a :href="item.href" rel="noopener noreferrer" target="_blank">
                                                    <span class="sr-only">{{ item.title }}</span>
                                                    <component :is="item.icon" class="size-5 opacity-80 group-hover:opacity-100" />
                                                </a>
                                            </Button>
                                        </TooltipTrigger>
                                        <TooltipContent>
                                            <p>{{ item.title }}</p>
                                        </TooltipContent>
                                    </Tooltip>
                                </TooltipProvider>
                            </template>
                        </div>
                        <div v-if="!$page.props.auth.user" class="space-x-1 lg:flex">
                            <TooltipProvider :delay-duration="0">
                                <Tooltip>
                                    <TooltipTrigger>
                                        <Button as-child class="group h-9 w-9 cursor-pointer" size="icon" variant="ghost">
                                            <Link :href="route('login')" rel="noopener noreferrer">
                                                <span class="sr-only">Login</span>
                                                <component :is="LucideLogIn" class="size-5 opacity-80 group-hover:opacity-100" />
                                            </Link>
                                        </Button>
                                    </TooltipTrigger>
                                    <TooltipContent>
                                        <p>Login</p>
                                    </TooltipContent>
                                </Tooltip>
                            </TooltipProvider>
                        </div>
                        <div v-if="!$page.props.auth.user" class="space-x-1 lg:flex">
                            <TooltipProvider :delay-duration="0">
                                <Tooltip>
                                    <TooltipTrigger>
                                        <Button as-child class="group h-9 w-9 cursor-pointer" size="icon" variant="ghost">
                                            <Link :href="route('register')" rel="noopener noreferrer">
                                                <span class="sr-only">Login</span>
                                                <component :is="UserPlus" class="size-5 opacity-80 group-hover:opacity-100" />
                                            </Link>
                                        </Button>
                                    </TooltipTrigger>
                                    <TooltipContent>
                                        <p>Register</p>
                                    </TooltipContent>
                                </Tooltip>
                            </TooltipProvider>
                        </div>
                    </div>

                    <DropdownMenu>
                        <DropdownMenuTrigger :as-child="true">
                            <Button
                                v-if="$page.props.auth.user"
                                class="focus-within:ring-primary relative size-10 w-auto rounded-full p-1 focus-within:ring-2"
                                size="icon"
                                variant="ghost"
                            >
                                <Avatar v-if="auth?.user" class="size-8 overflow-hidden rounded-full">
                                    <AvatarImage v-if="auth?.user?.avatar" :alt="auth?.user?.name" :src="auth?.user?.avatar" />
                                    <AvatarFallback class="rounded-lg bg-neutral-200 font-semibold text-black dark:bg-neutral-700 dark:text-white">
                                        {{ getInitials(auth?.user?.name) }}
                                    </AvatarFallback>
                                </Avatar>
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end" class="w-56">
                            <UserMenuContent :user="auth?.user" />
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            </div>
        </div>

        <div v-if="props.breadcrumbs.length > 1" class="border-sidebar-border/70 flex w-full border-b">
            <div class="mx-auto flex h-12 w-full items-center justify-start px-4 text-neutral-500 md:max-w-7xl">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </div>
        </div>
    </div>
</template>
