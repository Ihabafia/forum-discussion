<script lang="ts" setup>
import Discussion from '@/components/Forum/Discussion.vue';
import Navigation from '@/components/Forum/Navigation.vue';
import Pagination from '@/components/Pagination.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import Select from '@/components/ui/select/Select.vue';
import useCreateDiscussion from '@/composables/useCreateDiscussion';
import ForumLayout from '@/layouts/Forum/ForumLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Discussions } from '@/types/discussion';
import { Head, router, useForm } from '@inertiajs/vue3';
import _debounce from 'lodash.debounce';
import _isEmpty from 'lodash.isempty';
import _omitBy from 'lodash.omitby';
import { computed, ref, watch } from 'vue';

// const props = defineProps(['discussions', 'query']);
const props = defineProps<{
    discussions: Discussions;
    query: object;
}>();

const searchQuery = ref(props.query.search || '');
const { showCreateDiscussionForm } = useCreateDiscussion();

const form = useForm({
    topic: '',
});

const showPagination = computed(() => {
    return props.discussions?.meta?.total > props.discussions?.meta?.per_page;
});
const filterTopic = (e: object) => {
    router.visit('/', {
        data: _omitBy(
            {
                'filter[topic]': e.target.value,
            },
            _isEmpty,
        ),
        preserveScroll: true,
    });
};

const handleSearchInput = _debounce((query: string) => {
    router.reload({
        data: { search: query },
        preserveScroll: true,
    });
}, 350);

watch(searchQuery, (query) => {
    handleSearchInput(query);
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Home',
        href: '/',
    },
];
</script>

<template>
    <Head title="Home" />

    <ForumLayout :breadcrumbs="breadcrumbs">
        <template #side>
            <div v-if="$page.props.auth.user" class="mx-2">
                <div class="rounded-lg">
                    <Button class="text-md h-10 w-full tracking-wide uppercase" variant="primary" @click="showCreateDiscussionForm">
                        Start a discussion
                    </Button>
                </div>
            </div>
            <Navigation :query="query" class="" />
        </template>
        <div class="space-y-4">
            <div class="space-y-6">
                <div class="card flex flex-row items-center space-x-3">
                    <div class="card-body flex-grow">
                        <Label class="sr-only" for="search">Search</Label>
                        <Input id="search" v-model="searchQuery" class="border2 border-gray-400" placeholder="Search discussions..." type="text" />
                    </div>
                    <div class="card-body">
                        <Label class="sr-only" for="topic">Topic</Label>
                        <Select id="topic" v-model="form.topic" class="border-2 border-gray-300" @change="filterTopic">
                            <option value="">All Topics</option>
                            <option
                                v-for="topic in $page.props.topics"
                                :key="topic.id"
                                :selected="query.filter?.topic === topic.slug"
                                :value="topic.slug"
                            >
                                {{ topic.title }}
                            </option>
                        </Select>
                    </div>
                </div>

                <div class="space-y-2">
                    <div v-for="discussion in discussions.data" :key="discussion.id">
                        <Discussion :discussion="discussion" />
                    </div>
                </div>
            </div>
            <template v-if="showPagination">
                <Pagination :meta="discussions.meta" :only="['discussions']" />
            </template>
        </div>
        <!--        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                        <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                            <PlaceholderPattern />
                        </div>
                        <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                            <PlaceholderPattern />
                        </div>
                        <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                            <PlaceholderPattern />
                        </div>
                    </div>
                    <div class="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 rounded-xl border md:min-h-min">
                        <PlaceholderPattern />
                    </div>
                </div>-->
    </ForumLayout>
</template>
