<script lang="ts" setup>
import { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';
import { useVModel } from '@vueuse/core';

const props = defineProps<{
    defaultValue?: string | number
    modelValue?: string | number
    class?: HTMLAttributes['class']
}>();

const emits = defineEmits<{
    (e: 'update:modelValue', payload: string | number): void
}>();

const modelValue = useVModel(props, 'modelValue', emits, {
    passive: true,
    defaultValue: props.defaultValue
});
</script>

<template>
    {{ props.ref }}
    <textarea
        v-model="modelValue"
        :class="cn(
      'p-3 block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-50 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6',
      props.class,
    )"
        data-slot="input"
    ></textarea>
</template>
