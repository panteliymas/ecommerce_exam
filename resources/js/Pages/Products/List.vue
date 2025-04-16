<script setup>
import Header from '../Partials/Header.vue';
import Product from './Partials/Product.vue';
import { Head } from '@inertiajs/vue3';
import Paginator from '@/Components/Paginator.vue';

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
            <div class="mx-auto max-w-8xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
                <div class="mt-6 grid grid-cols-3 gap-4 sm:grid-cols-2 lg:grid-cols-5 xl:gap-6 catalog">
                    <Product 
                        v-for="product in props.products.data" 
                        :product="product"
                        :key="product.id" />
                </div>
                <Paginator 
                    :elements="props.products" 
                    class="mt-6 flex justify-center" />
            </div>
        </div>
    </main>
</template>