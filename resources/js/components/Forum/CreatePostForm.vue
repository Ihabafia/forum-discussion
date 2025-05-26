<script lang="ts" setup>
import FixedFormWrapper from '@/components/Forum/FixedFormWrapper.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';
import useCreatePost from '@/composables/useCreatePost';
import { X } from 'lucide-vue-next';

const { visible, hideCreatePostForm, form, clearForm, discussion, createPostRef } = useCreatePost();
const createPost = () => {
    form.post(route('posts.store', discussion.value?.id), {
        onSuccess: () => {
            clearForm();
        },
    });
};
</script>

<template>
    <FixedFormWrapper v-if="visible" :form="form" @submit.prevent="createPost">
        <template #header>
            <div class="flex items-center justify-between">
                <h1 class="text-lg font-semibold">Replying to "{{ discussion?.title }}"</h1>
                <TooltipProvider :delay-duration="0">
                    <Tooltip>
                        <TooltipTrigger>
                            <X class="h-8 w-8 cursor-pointer p-1" @click="hideCreatePostForm" />
                        </TooltipTrigger>
                        <TooltipContent>
                            <p>Hide Form</p>
                        </TooltipContent>
                    </Tooltip>
                </TooltipProvider>
            </div>
        </template>
        <template #main="{ markdownPreviewEnabled }">
            <div>
                <Label class="sr-only" for="body">Body</Label>
                <textarea
                    v-if="!markdownPreviewEnabled"
                    id="body"
                    ref="createPostRef"
                    v-model="form.body"
                    :class="{
                        'ring-2 ring-red-500': form.errors.body,
                    }"
                    class="dark:gray-50 dark:gray-50 block h-48 w-full rounded-lg bg-white p-3 py-1.5 text-gray-900 shadow-sm ring-2 ring-gray-200 ring-inset placeholder:text-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-300 focus:outline-none focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-800 dark:text-gray-50 dark:ring-gray-600 dark:focus:ring-gray-600"
                    placeholder="What would you like to say?"
                    tabindex="3"
                ></textarea>
                <InputError :message="form.errors.body" />
            </div>
        </template>
        <template #button>
            <Button :tabindex="4" class="text-md" type="submit" variant="primary">Reply</Button>
            <Button :tabindex="5" class="text-md" type="button" variant="ghost" @click="clearForm">Cancel</Button>
        </template>
    </FixedFormWrapper>
</template>

<style scoped></style>
