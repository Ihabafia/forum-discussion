<script lang="ts" setup>
import Svg from '@/components/Svg.vue';
</script>

<template>
    <markdown-toolbar class="-ml-1 flex items-center">
        <md-bold class="cursor-pointer px-1 py-1.5">
            <Svg class="h-5 w-5" name="icon-bold" />
        </md-bold>
        <md-italic class="cursor-pointer px-1 py-1.5">
            <Svg class="h-5 w-5" name="icon-italic" />
        </md-italic>
        <md-code class="cursor-pointer px-1 py-1.5">
            <Svg class="h-5 w-5" name="icon-code" />
        </md-code>
        <md-link class="cursor-pointer px-1 py-1.5">
            <Svg class="h-5 w-5" name="icon-link" />
        </md-link>
        <md-mention class="cursor-pointer px-1 py-1.5">
            <Svg class="h-5 w-5" name="icon-at" />
        </md-mention>
    </markdown-toolbar>
</template>

<style scoped></style>
