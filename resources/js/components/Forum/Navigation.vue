<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    query: {
        type: Object,
    },
});
</script>

<template>
    <div class="mx-2 rounded-lg bg-gray-100 py-4 text-gray-900 dark:bg-gray-800 dark:text-gray-50">
        <nav class="space-y-3">
            <ul class="mx-4 flex flex-col space-y-2">
                <Link href="/">
                    <li
                        :class="{
                            'w-full rounded-lg bg-purple-200 px-3 font-bold text-purple-700 dark:bg-purple-900 dark:text-purple-300':
                                !query?.filter && $page.component === 'Forum/Index',
                        }"
                        class="p-1 pl-3"
                    >
                        All Discussions
                    </li>
                </Link>
                <Link href="/?filter[noreplies]=1">
                    <li
                        :class="{
                            'w-full rounded-lg bg-purple-200 px-3 font-bold text-purple-700 dark:bg-purple-900 dark:text-purple-300':
                                query?.filter?.noreplies,
                        }"
                        class="p-1 pl-3"
                    >
                        No Replies
                    </li>
                </Link>
                <Link href="/?filter[solved]=1">
                    <li
                        :class="{
                            'w-full rounded-lg bg-purple-200 px-3 font-bold text-purple-700 dark:bg-purple-900 dark:text-purple-300':
                                query?.filter?.solved,
                        }"
                        class="py-1 pl-3"
                    >
                        Solved Discussions
                    </li>
                </Link>
                <Link href="/?filter[unsolved]=1">
                    <li
                        :class="{
                            'w-full rounded-lg bg-purple-200 px-3 font-bold text-purple-700 dark:bg-purple-900 dark:text-purple-300':
                                query?.filter?.unsolved,
                        }"
                        class="py-1 pl-3"
                    >
                        Unsolved Discussions
                    </li>
                </Link>
            </ul>
            <ul v-if="$page.props.auth?.user" class="mx-4 flex flex-col space-y-2 border-t border-t-gray-300 pt-3">
                <Link href="/?filter[mine]=1">
                    <li
                        :class="{
                            'w-full rounded-lg bg-purple-200 px-3 font-bold text-purple-700 dark:bg-purple-900 dark:text-purple-300':
                                query?.filter?.mine,
                        }"
                        class="py-1 pl-3"
                    >
                        My Discussions
                    </li>
                </Link>
                <Link href="/?filter[participating]=1">
                    <li
                        :class="{
                            'w-full rounded-lg bg-purple-200 px-3 font-bold text-purple-700 dark:bg-purple-900 dark:text-purple-300':
                                query?.filter?.participating,
                        }"
                        class="py-1 pl-3"
                    >
                        Participating Discussions
                    </li>
                </Link>
                <Link href="/?filter[mentioned]=1">
                    <li
                        :class="{
                            'w-full rounded-lg bg-purple-200 px-3 font-bold text-purple-700 dark:bg-purple-900 dark:text-purple-300':
                                query?.filter?.mentioned,
                        }"
                        class="py-1 pl-3"
                    >
                        Mentioned
                    </li>
                </Link>
            </ul>
        </nav>
    </div>
</template>

<style scoped></style>
