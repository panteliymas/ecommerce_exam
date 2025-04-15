<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Header from '../Partials/Header.vue';
import Product from './Partials/Product.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    products: {
        type: Array,
        required: true
    }
});

</script>

<template>
    <Head title="Products" />
    <Header />

    <main>
        <div class="bg-white">
            <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
                <div class="mt-6 grid grid-cols-3 gap-4 sm:grid-cols-2 lg:grid-cols-4 xl:gap-6 catalog">
                    <Product 
                        v-for="product in products" 
                        :name="product.name" 
                        :price="product.price" 
                        :photo="product.photo" />
                </div>
            </div>
        </div>
    </main>
</template>