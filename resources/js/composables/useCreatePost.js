import { nextTick, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const visible = ref(false);
const discussion = ref(null);
const user = ref(null);
const createPostRef = ref(null);

const form = useForm({
    discussion_id: '',
    body: '',
});

export default () => {
    const toggleCreatePostForm = () => {
        visible.value = !visible.value;
    };
    const showCreatePostForm = (discussionContext, userContext = null) => {
        visible.value = true;
        nextTick(() => {
            createPostRef.value?.focus();
        });
        discussion.value = discussionContext;
        user.value = userContext;
    };
    const hideCreatePostForm = () => {
        visible.value = false;
    };
    const clearForm = () => {
        form.reset();
        visible.value = false;
    };

    return {
        form,
        clearForm,
        visible,
        toggleCreatePostForm,
        showCreatePostForm,
        hideCreatePostForm,
        discussion,
        createPostRef,
        user,
    };
};
