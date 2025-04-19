<script setup>

import { ref, watch } from 'vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import Header from '@/Pages/Admin/Header.vue';

const props = defineProps({
    product: {
        type: Object,
        default: () => ({
            id: 0,
            name: '',
            description: '',
            price: 0,
            stock: 0,
            categories: []
        })
    },
    categories: {
        type: Array,
        required: true
    }
});

const $page = usePage();

const isLoading = ref(false);

const _product = ref({
    ...props.product,
    categories: props.product.categories.map((cat) => cat.id)
});

const saveProduct = (product) => {
    router.post(route('admin.products.save', product.id), {
        product
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
    <Head title="Admin Product" />
    <Header />

    <div class="max-w-7xl m-auto flex flex-col gap-2">
        <div class="bg-gray-100 rounded-xl m-4 px-8 py-6">
            Edit Product:
        </div>
        <div class="bg-gray-100 rounded-xl m-4 px-8 py-6">
            <div class="flex flex-col gap-2">
                <label for="name">Photo</label>
                <input type="file" id="photo" class="border border-gray-300 rounded-md p-2" @change="_product.photo = $event.target.files[0]" />
            </div>
        </div>
        <div class="bg-gray-100 rounded-xl m-4 px-8 py-6">
            <div class="flex flex-col gap-2">
                <label for="name">Name</label>
                <input type="text" id="name" class="border border-gray-300 rounded-md p-2" v-model="_product.name" />
            </div>
        </div>
        <div class="bg-gray-100 rounded-xl m-4 px-8 py-6">
            <div class="flex flex-col gap-2">
                <label for="description">Description</label>
                <textarea id="description" class="border border-gray-300 rounded-md p-2" v-model="_product.description"></textarea>
            </div>
        </div>
        <div class="bg-gray-100 rounded-xl m-4 px-8 py-6">
            <div class="flex flex-col gap-2">
                <label for="price">Price</label>
                <input type="text" id="price" class="border border-gray-300 rounded-md p-2" v-model="_product.price" />
            </div>
        </div>
        <div class="bg-gray-100 rounded-xl m-4 px-8 py-6">
            <div class="flex flex-col gap-2">
                <label for="stock">Stock</label>
                <input type="number" id="stock" class="border border-gray-300 rounded-md p-2" v-model="_product.stock" />
            </div>
        </div>
        <div class="bg-gray-100 rounded-xl m-4 px-8 py-6">
            <div class="flex flex-col gap-2">
                <label for="category">Category</label>
                <div v-for="category in categories" :key="category.id">
                    <input 
                        type="checkbox" 
                        :value="category.id" 
                        v-model="_product.categories" 
                        class="border-gray-300 rounded-md p-2" 
                        :id="`category${category.id}`"
                        />
                    <label :for="`category${category.id}`" class="text-gray-700 ml-1">{{ category.name }} ({{ category.products_count || '0' }})</label>
                </div>
            </div>
        </div>
        <div class="bg-gray-100 rounded-xl m-4">
            <div class="flex flex-col gap-2">
                <button 
                    class="text-md bg-blue-800 text-white px-4 py-2 rounded-xl w-full text-center hover:cursor-pointer"
                    :disabled="isLoading" 
                    @click="saveProduct(_product)"
                >
                    {{ $page.props.flash.message ? 'Сохраненo' : 'Сохранить' }}
                </button>
            </div>
        </div>
    </div>
</template>