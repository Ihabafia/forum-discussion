<script lang="ts" setup>
import Avatar from '@/components/Forum/Avatar.vue';
import Time from '@/components/Time.vue';
import { DiscussionObject } from '@/types/discussion';
import { Link } from '@inertiajs/vue3';
import { Pin } from 'lucide-vue-next';
import pluralize from 'pluralize';
import { computed } from 'vue';

const props = defineProps<{
    discussion: DiscussionObject;
}>();

const limit = 4;
const more = computed(() => {
    return props.discussion.participants.length > limit ? props.discussion.participants.length - limit : 0;
});
const participants = computed(() => {
    return props.discussion.participants.slice(0, limit);
});
</script>

<template>
    <Link :href="route('discussion.show', discussion.slug)">
        <div class="card relative">
            <div class="card-body">
                <template v-if="discussion.is_pinned">
                    <Pin class="absolute top-3 left-3 mr-2 size-5 rounded-lg border border-purple-400 bg-transparent p-0.5 text-purple-400" />
                </template>
                <div class="shrink-flex-0 flex items-start justify-between space-x-3">
                    <div class="flex items-baseline justify-start space-x-3">
                        <span
                            class="inline-flex items-center rounded-full bg-gray-200 px-3 py-0.5 text-sm text-gray-800 dark:bg-gray-600 dark:text-gray-200"
                        >
                            {{ discussion.topic.title }}
                        </span>
                        <div>
                            <h1 class="text-lg font-medium">
                                {{ discussion.title }}
                            </h1>
                            <div class="prose prose-sm mt-2 line-clamp-2 dark:text-gray-400" v-html="discussion.post?.body_markdown"></div>
                        </div>
                    </div>
                    <div class="flex flex-shrink-0 flex-col items-end space-y-2">
                        <div>
                            <div class="flex items-center justify-start -space-x-3">
                                <template v-for="participant in participants" :key="participant.id">
                                    <Avatar
                                        v-if="participant"
                                        :size="7"
                                        :user="participant || {}"
                                        class="ring-2 ring-white first-of-type:h-9 first-of-type:w-9 dark:ring-gray-400"
                                    />
                                </template>
                            </div>
                            <div v-if="more" class="text-sm text-gray-600 dark:text-gray-300">+ {{ more }} more.</div>
                        </div>
                        <div class="text-sm dark:text-gray-400">
                            {{ pluralize('Reply', discussion.replies_count, true) }}
                        </div>
                    </div>
                </div>
                <template v-if="discussion.latest_post">
                    <Link
                        :href="route('discussion.show', { discussion: discussion.slug, post: discussion.latest_post.id })"
                        class="mt-5 inline-block text-sm text-gray-500 hover:text-purple-600 dark:text-gray-400 dark:hover:text-purple-400"
                    >
                        Last reply by {{ discussion.latest_post.user?.name || '[User deleted]' }},
                        <Time :datetime="discussion.latest_post.created_at">
                            {{ discussion.latest_post.created_at.datetime }}
                        </Time>
                    </Link>
                </template>
                <template v-else>
                    <div class="mt-5 text-sm text-gray-500 dark:text-gray-400">No posts yet</div>
                </template>
            </div>
        </div>
    </Link>
</template>

<style scoped></style>
