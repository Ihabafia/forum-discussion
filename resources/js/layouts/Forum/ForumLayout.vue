<script lang="ts" setup>
import CreateDiscussionForm from '@/components/Forum/CreateDiscussionForm.vue';
import CreatePostForm from '@/components/Forum/CreatePostForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';

defineProps(['breadcrumbs']);
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto max-w-7xl grid-cols-8 gap-0 space-y-6 pt-4 sm:w-7xl sm:px-2 sm:pt-6 md:grid md:space-y-0 lg:px-2">
            <div class="col-span-2 space-y-3">
                <slot name="side" />
            </div>
            <div class="col-span-6 mx-2">
                <slot />
            </div>
        </div>
    </AppLayout>
    <CreateDiscussionForm />
    <CreatePostForm />
</template>

<style scoped></style>
