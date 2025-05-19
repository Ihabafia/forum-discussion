<script lang="ts" setup>
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Home',
        href: '/',
    },
];
</script>

<template>
    <Head title="Home" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="card">
            <div class="card-header">Hello World!</div>
            <div class="card-body">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus, nostrum sit. Culpa deserunt dicta dolor dolores
                exercitationem expedita nam nulla odit quaerat, quas quod reiciendis repellendus saepe temporibus voluptates voluptatum.
            </div>
        </div>
        <div class="card">
            <div class="card-header">Hello World!</div>
            <div class="card-body">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus, nostrum sit. Culpa deserunt dicta dolor dolores
                exercitationem expedita nam nulla odit quaerat, quas quod reiciendis repellendus saepe temporibus voluptates voluptatum.
            </div>
        </div>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                    <PlaceholderPattern />
                </div>
                <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                    <PlaceholderPattern />
                </div>
                <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                    <PlaceholderPattern />
                </div>
            </div>
            <div class="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 rounded-xl border md:min-h-min">
                <PlaceholderPattern />
            </div>
        </div>
    </AppLayout>
</template>
