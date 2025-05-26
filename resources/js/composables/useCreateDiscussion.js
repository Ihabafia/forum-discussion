import { nextTick, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const visible = ref(false);
const createDiscussionRef = ref(null);

const form = useForm({
    topic_id: '',
    title: '',
    body: '',
});

export default () => {
    const toggleCreateDiscussionForm = () => {
        visible.value = !visible.value;
    };
    const showCreateDiscussionForm = () => {
        visible.value = true;
        nextTick(() => {
            createDiscussionRef.value?.focus();
        });
    };
    const hideCreateDiscussionForm = () => {
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
        toggleCreateDiscussionForm,
        showCreateDiscussionForm,
        hideCreateDiscussionForm,
        createDiscussionRef,
    };
};
