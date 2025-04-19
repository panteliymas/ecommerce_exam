<script setup>

import { ref, watch } from 'vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import Header from '@/Pages/Admin/Header.vue';

const props = defineProps({
    category: {
        type: Object,
        default: () => ({
            id: 0,
            name: ''
        })
    },
});

const $page = usePage();

const isLoading = ref(false);

const _category = ref({
    ...props.category
});

const saveCategory = (category) => {
    router.post(route('admin.categories.save', category.id), {
        category
    }, {
        replace: true,
        preserveScroll: true,
    });
}

watch(() => $page.props.flash.message, (newStatus) => {
    if (newStatus) {
        setTimeout(() => {
            $page.props.flash.message = null
        }, 5000)
    }
})

</script>

<template>
    <Head title="Admin Category" />
    <Header />

    <div class="max-w-7xl m-auto flex flex-col gap-2">
        <div class="bg-gray-100 rounded-xl m-4 px-8 py-6">
            Edit Category:
        </div>
        <div class="bg-gray-100 rounded-xl m-4 px-8 py-6">
            <div class="flex flex-col gap-2">
                <label for="name">Name</label>
                <input type="text" id="name" class="border border-gray-300 rounded-md p-2" v-model="_category.name" />
            </div>
        </div>
        <div class="bg-gray-100 rounded-xl m-4">
            <div class="flex flex-col gap-2">
                <button 
                    class="text-md bg-blue-800 text-white px-4 py-2 rounded-xl w-full text-center hover:cursor-pointer"
                    :disabled="isLoading" 
                    @click="saveCategory(_category)"
                >
                    {{ $page.props.flash.message ? 'Сохраненo' : 'Сохранить' }}
                </button>
            </div>
        </div>
    </div>
</template>