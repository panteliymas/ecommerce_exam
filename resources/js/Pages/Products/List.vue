<script setup>
import { ref, watch } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import Header from '../Partials/Header.vue';
import Product from './Partials/Product.vue';
import Paginator from '@/Components/Paginator.vue';

const props = defineProps({
    products: {
        type: Array,
        required: true
    },
    categories: {
        type: Array,
        required: true
    }
});

const selected = ref({
    categories: [],
    min_price: 0,
    max_price: 0
});

const updateFilters = () => {
    router.get(route('products.catalog'), {
        filter: selected.value,
        page: 1
    }, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    });
};

watch(() => selected.value, () => {
    updateFilters();
}, { deep: true, immediate: false });

const handlePageChange = (url) => {
    router.get(url, {}, {
        preserveState: true,
        preserveScroll: true
    });
};

</script>

<template>
    <Head title="Products" />
    <Header />

    <main>
        <div class="bg-white">
            <div class="mx-auto mt-4 max-w-8xl px-4 sm:px-6 lg:px-8 grid grid-cols-5">
                <div class="col-span-1 px-4 sm:px-6 lg:px-8 outline-1 outline-black rounded-xl h-fit sticky top-[70px]">
                    <div class="flex flex-col justify-between gap-8 my-6">
                        Filter
                        <div>
                            <label for="category" class="text-gray-700">Categories:</label>
                            <div v-for="category in categories" :key="category.id">
                                <input type="checkbox" :value="category.id" v-model="selected.categories" class="border-gray-300 rounded-md p-2" :id="`category${category.id}`"/>
                                <label :for="`category${category.id}`" class="text-gray-700">{{ category.name }} ({{ category.products_count || '0' }})</label>
                            </div>
                        </div>
                        <div>
                            <label for="price" class="text-gray-700">Price:</label>
                            <div class="flex outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:outline-blue-500 rounded-sm">
                                Min:
                                <input type="text" name="filter[min_price]" id="" placeholder="0" class="focus:outline-none" v-model="selected.min_price">
                            </div>
                            <div class="flex outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:outline-blue-500 rounded-sm">
                                Max:
                                <input type="text" name="filter[max_price]" id="" placeholder="0" class="focus:outline-none" v-model="selected.max_price">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-4 my-6 px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-3 gap-4 sm:grid-cols-2 lg:grid-cols-4 xl:gap-6 catalog">
                        <Product 
                            v-for="product in products.data" 
                            :product="product"
                            :key="product.id" />
                    </div>
                    <Paginator 
                        :elements="products" 
                        @page-change="handlePageChange"
                        class="mt-6 flex justify-center" />
                </div>
            </div>
        </div>
    </main>
</template>