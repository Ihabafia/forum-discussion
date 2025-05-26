<script lang="ts" setup>
import FixedFormWrapper from '@/components/Forum/FixedFormWrapper.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';
import useCreateDiscussion from '@/composables/useCreateDiscussion';
import { X } from 'lucide-vue-next';

const { visible, hideCreateDiscussionForm, form, clearForm, createDiscussionRef } = useCreateDiscussion();

const createDiscussion = () => {
    form.post(route('discussions.store'), {
        onSuccess: () => {
            clearForm();
        },
    });
};
</script>

<template>
    <FixedFormWrapper v-if="visible" :form="form" @submit.prevent="createDiscussion">
        <template #header>
            <div class="flex items-center justify-between">
                <h1 class="text-lg font-semibold">New Discussion</h1>
                <TooltipProvider :delay-duration="0">
                    <Tooltip>
                        <TooltipTrigger>
                            <X class="h-8 w-8 cursor-pointer p-1" @click="hideCreateDiscussionForm" />
                        </TooltipTrigger>
                        <TooltipContent>
                            <p>Hide Form</p>
                        </TooltipContent>
                    </Tooltip>
                </TooltipProvider>
            </div>
        </template>
        <template #main="{ markdownPreviewEnabled }">
            <div class="flex items-start gap-5 space-y-4">
                <div class="flex-grow">
                    <Label class="sr-only" for="title">Title</Label>
                    <input
                        id="title"
                        ref="createDiscussionRef"
                        v-model="form.title"
                        :class="{
                            'ring-2 ring-red-500': form.errors.title,
                        }"
                        :tabindex="1"
                        class="dark:gray-50 dark:gray-50 block w-full rounded-md bg-white p-3 py-1.5 text-gray-900 shadow-sm ring-2 ring-gray-200 ring-inset placeholder:text-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-300 focus:outline-none focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-800 dark:text-gray-50 dark:ring-gray-600 dark:focus:ring-gray-600"
                        placeholder="Title your discussion"
                        type="text"
                    />
                    <InputError :message="form.errors.title" />
                </div>
                <div>
                    <Label class="sr-only" for="topic">Topic</Label>
                    <select
                        id="topic"
                        v-model="form.topic_id"
                        :class="{
                            'ring-2 ring-red-500': form.errors.topic_id,
                        } /*cn(
                                'file:text-foreground placeholder:text-muted-foreground selection:bg-primary selection:text-primary-foreground dark:bg-input/30 border-input flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm',
                                'focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]',
                                'aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive',
                            )*/"
                        :tabindex="2"
                        class="flex h-9 w-48 min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs focus:bg-white"
                    >
                        <option value="">Choose a topic...</option>
                        <option v-for="topic in $page.props.topics" :key="topic.id" :selected="form.topic_id === topic.id" :value="topic.id">
                            {{ topic.title }}
                        </option>
                    </select>
                    <InputError :message="form.errors.topic_id" />
                </div>
            </div>
            <div>
                <Label class="sr-only" for="body">Body</Label>
                <textarea
                    v-if="!markdownPreviewEnabled"
                    id="body"
                    v-model="form.body"
                    :class="{
                        'ring-2 ring-red-500': form.errors.body,
                    }"
                    class="dark:gray-50 dark:gray-50 block h-48 w-full rounded-lg bg-white p-3 py-1.5 text-gray-900 shadow-sm ring-2 ring-gray-200 ring-inset placeholder:text-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-300 focus:outline-none focus:ring-inset sm:text-sm sm:leading-6 dark:bg-gray-800 dark:text-gray-50 dark:ring-gray-600 dark:focus:ring-gray-600"
                    placeholder="What would you like to discuss?"
                    tabindex="3"
                ></textarea>
                <InputError :message="form.errors.body" />
            </div>
        </template>
        <template #button>
            <Button :tabindex="4" class="text-md" type="submit" variant="primary">Create</Button>
            <Button :tabindex="5" class="text-md" type="button" variant="ghost" @click="clearForm">Cancel</Button>
        </template>
    </FixedFormWrapper>
</template>

<style scoped></style>
