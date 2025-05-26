<script lang="ts" setup>
import { UserObject } from '@/types/discussion';

defineProps<{
    user: UserObject;
    size?: number;
}>();
</script>

<template>
    <img
        :alt="user?.name || '[Deleted user]'"
        :class="{
            'h-7 w-7': size === 7,
            'h-8 w-8': size === 8,
            'h-10 w-10': size === 10,
            'h-11 w-11': size === 11,
            'h-12 w-12': size === 12,
            'h-9 w-9': !size || size === 9,
        }"
        :src="user?.avatar || '/imgs/logo.svg'"
        :title="user?.username || '[Deleted user]'"
        class="rounded-full"
    />
</template>

<style scoped></style>
