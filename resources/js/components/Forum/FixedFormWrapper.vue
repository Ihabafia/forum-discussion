<script lang="ts" setup>
import MarkdownToolbarComponent from '@/components/Forum/MarkdownToolbarComponent.vue';
import { Button } from '@/components/ui/button';
import '@github/markdown-toolbar-element';
import axios from 'axios';
import { ref, watch } from 'vue';

const markdownPreviewEnabled = ref(false);
const markdownPreviewHtml = ref('');
const markdownPreviewLoading = ref(false);

const props = defineProps({
    form: {
        type: Object,
        default: () => ({}),
    },
});

watch(
    () => markdownPreviewEnabled.value,
    (toggled) => {
        if (!toggled) {
            return;
        }

        markdownPreviewLoading.value = true;

        axios
            .post(route('markdown-preview'), {
                body: props.form?.body,
            })
            .then((response) => {
                markdownPreviewHtml.value = response.data.html;
                markdownPreviewLoading.value = false;
            })
            .catch((error) => {
                console.error('Error fetching markdown preview:', error);
            });
    },
);
</script>

<template>
    <form class="fixed bottom-0 min-h-3/12 w-full space-y-3 border-t-4 border-t-gray-300 bg-white p-4 dark:border-t-gray-500 dark:bg-gray-700">
        <div class="mx-auto max-w-7xl space-y-4 sm:px-6 lg:px-11">
            <div>
                <slot name="header" />
            </div>
            <div>
                <slot :markdownPreviewEnabled="markdownPreviewEnabled" name="main" />
                <div
                    v-if="markdownPreviewEnabled"
                    :class="{
                        'opacity-20': markdownPreviewLoading,
                    }"
                    class="h-48 overflow-y-scroll rounded-lg border border-gray-200 bg-purple-50 px-3 py-2 shadow"
                    v-html="markdownPreviewHtml"
                />
                <div class="flex items-center justify-between">
                    <MarkdownToolbarComponent class="flex-grow" for="body" />
                    <Button
                        :variant="markdownPreviewEnabled ? 'primary' : 'ghost'"
                        class="mt-2 text-sm font-black"
                        size="sm"
                        type="button"
                        @click="markdownPreviewEnabled = !markdownPreviewEnabled"
                    >
                        Markdown Preview
                    </Button>
                </div>
            </div>
            <div>
                <slot name="button" />
            </div>
        </div>
    </form>
</template>

<style scoped></style>
