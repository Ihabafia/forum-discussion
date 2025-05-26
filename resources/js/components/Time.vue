<script lang="ts" setup>
defineProps({
    datetime: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <time :datetime="datetime.date" :title="datetime.fancy_day">
        <slot>{{ datetime.human }}</slot>
    </time>
</template>

<style scoped></style>
