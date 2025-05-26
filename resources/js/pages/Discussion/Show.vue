<script lang="ts" setup>
import Navigation from '@/components/Forum/Navigation.vue';
import Post from '@/components/Forum/Post.vue';
import Pagination from '@/components/Pagination.vue';
import { Button } from '@/components/ui/button';
import useCreatePost from '@/composables/useCreatePost';
import ForumLayout from '@/layouts/Forum/ForumLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { DiscussionObject } from '@/types/discussion';
import { Head, router } from '@inertiajs/vue3';
import { Pin } from 'lucide-vue-next';
import pluralize from 'pluralize';
import { computed, nextTick, onMounted, onUpdated } from 'vue';
import VueScrollTo from 'vue-scrollto';

const props = defineProps<{
    query: object;
    discussion: DiscussionObject;
    posts: object;
    postId?: number;
}>();

const { showCreatePostForm } = useCreatePost();

const showPagination = computed(() => {
    return props.posts.meta?.total > props.posts.meta?.per_page;
});

const scrollToPost = (postId: number | undefined) => {
    if (!postId) {
        return;
    }

    nextTick(() => {
        VueScrollTo.scrollTo(`#post-${postId}`, 500, { offset: -50 });
    });
};
onMounted(() => {
    scrollToPost(props.postId);
});
onUpdated(() => {
    scrollToPost(props.postId);
});

const deleteDiscussion = () => {
    if (!window.confirm('Are you sure you want to delete this discussion?')) {
        return;
    }

    router.delete(route('discussions.destroy', props.discussion.id));
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Home',
        href: route('home'),
    },
    {
        title: props.discussion.title,
        href: route('discussion.show', { slug: props.discussion.slug }),
    },
];
</script>

<template>
    <Head :title="discussion.title" />

    <ForumLayout :breadcrumbs="breadcrumbs">
        <template #side>
            <div v-if="discussion.user_can.reply" class="mx-2">
                <div class="rounded-lg">
                    <Button class="text-md h-10 w-full tracking-wide uppercase" variant="primary" @click="showCreatePostForm(discussion)">
                        Reply to discussion
                    </Button>
                </div>
            </div>
            <Navigation :query="query" class="h-full" />
        </template>
        <div class="space-y-6">
            <div class="space-y-8">
                <div class="card">
                    <div class="flex items-center justify-between">
                        <div class="flex items-baseline justify-start space-x-3">
                            <div class="mr-2 rounded-full bg-gray-100 px-3 py-0.5 text-sm text-gray-800 dark:bg-gray-600 dark:text-gray-200">
                                {{ discussion.topic.title }}
                            </div>
                            <div class="text-lg font-medium">
                                <template v-if="discussion.is_pinned">
                                    <Pin class="mr-2 size-7 rounded-lg border border-purple-400 bg-transparent p-1 text-purple-400" />
                                </template>
                                <div>{{ discussion.title }}</div>
                            </div>
                        </div>
                        <div class="flex flex-shrink-0 flex-col items-end space-y-0">
                            <!--<Avatar :size="8" :user="discussion.user || {}" />-->
                            <div class="text-sm dark:text-gray-400">
                                {{ pluralize('Reply', discussion.replies_count, true) }}
                            </div>
                            <div v-if="discussion.user_can.delete">
                                <Button class="h-5 cursor-pointer p-0 text-sm text-red-500" variant="link" @click="deleteDiscussion"> Delete </Button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-4">
                    <Post v-for="post in posts.data" :key="post.id" :isSolution="discussion.solution?.id === post.id" :post="post" />
                </div>
            </div>
            <template v-if="showPagination">
                <Pagination :meta="posts.meta" :only="['posts']" />
            </template>
        </div>
    </ForumLayout>
</template>
