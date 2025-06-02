<script lang="ts" setup>
import Avatar from '@/components/Forum/Avatar.vue';
import InputError from '@/components/InputError.vue';
import Time from '@/components/Time.vue';
import { Button } from '@/components/ui/button';
import TextArea from '@/components/ui/input/TextArea.vue';
import { Label } from '@/components/ui/label';
import useCreatePost from '@/composables/useCreatePost';
import useMentionSearch from '@/composables/useMentionSearch';
import { PostObject } from '@/types/discussion';
import { router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Mentionable } from 'vue-mention';

const props = defineProps<{
    post: PostObject;
    isSolution?: boolean;
}>();

const { showCreatePostForm } = useCreatePost();
const { mentionSearch, mentionSearchResult } = useMentionSearch();
const editing = ref(false);

const editForm = useForm({
    body: props.post.body,
});

const updatePost = () => {
    editForm.patch(route('posts.update', props.post.id), {
        preserveScroll: true,
        onSuccess: () => {
            editing.value = false;
        },
    });
};
const deletePost = () => {
    if (!window.confirm('Are you sure you want to delete this post? This action cannot be undone.')) {
        return;
    }

    router.delete(route('posts.destroy', props.post.id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <div
        :id="`post-${post.id}`"
        :class="{
            '!border-purple-500': isSolution,
        }"
        class="card relative flex items-start space-x-5 border-3 border-transparent"
    >
        <div
            v-if="isSolution"
            class="absolute top-0 right-0 mr-0 h-4.5 w-36 rounded-bl-xl bg-purple-500 pl-0.5 text-center text-xs font-bold tracking-widest text-white uppercase shadow-sm"
        >
            Best Solution
        </div>
        <div class="w-10 flex-shrink-0">
            <Avatar :size="10" :user="post.user || {}" class="ring-2 dark:ring-gray-400" />
        </div>
        <div class="w-full">
            <div>
                <div>{{ post.user?.username || '[Deleted user]' }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Posted in
                    <Time :datetime="post.created_at">{{ post.created_at.fancy }}</Time>
                </div>
            </div>
            <form v-if="editing" class="mt-4" @submit.prevent="updatePost">
                <Label class="sr-only" for="body">Body</Label>
                <Mentionable :items="mentionSearchResult" :keys="['@']" offset="6" v-on:search="mentionSearch">
                    <TextArea id="body" v-model="editForm.body" class="h-48 w-full" />
                    <template #no-result>
                        <div class="mention-item">No username found</div>
                    </template>
                </Mentionable>
                <InputError :message="editForm.errors.body" />
                <div class="mt-3">
                    <Button class="text-md" size="sm" type="submit" variant="primary">Update</Button>
                    <Button class="text-md" type="button" variant="ghost" @click="editing = false"> Cancel</Button>
                </div>
            </form>
            <div v-else>
                <article class="markdown prose prose-sm dark:prose-invert mt-3 max-w-none" v-html="post.body_markdown" />
                <div class="mt-6 flex items-center justify-between">
                    <ul class="flex items-center">
                        <li v-if="post.discussion.user_can.reply">
                            <Button
                                class="cursor-pointer pl-0 text-sm text-purple-500"
                                variant="link"
                                @click="showCreatePostForm(post.discussion, post.user)"
                                >Reply
                            </Button>
                        </li>
                        <li v-if="post.user_can.edit">
                            <Button class="cursor-pointer pl-0 text-sm text-purple-500" variant="link" @click="editing = true"> Edit </Button>
                        </li>
                        <li v-if="post.user_can.delete">
                            <Button class="cursor-pointer pl-0 text-sm text-red-500" variant="link" @click="deletePost"> Delete </Button>
                        </li>
                    </ul>
                    <ul>
                        <li v-if="post.discussion.user_can.solve">
                            <Button
                                class="cursor-pointer pl-0 text-sm text-purple-500"
                                variant="link"
                                @click="
                                    router.patch(
                                        route('best-answer.patch', post.discussion.id),
                                        {
                                            post_id: isSolution ? null : post.id,
                                        },
                                        {
                                            preserveScroll: true,
                                        },
                                    )
                                "
                            >
                                <span v-if="isSolution" class="font-bold text-red-500">Mark it as not a solution</span>
                                <span v-else class="font-bold text-green-500">Mark it as a solution</span>
                            </Button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
