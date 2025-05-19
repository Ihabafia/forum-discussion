<script lang="ts" setup>
import AppHeaderLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppHeaderLayout :breadcrumbs="breadcrumbs" class="mb-16 bg-gray-100 dark:bg-gray-900">
        <slot />
    </AppHeaderLayout>
</template>
