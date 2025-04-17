<script setup>

import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import Header from '@/Pages/Partials/Header.vue';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

let quantity = ref(Math.min(1, props.product.stock));

const addToCart = () => {
    quantity.value = Math.max(1, props.product.stock - quantity.value);
    router.post(route('cart.add'), {
        product_id: props.product.id,
        quantity: quantity.value,
    }, {
        preserveScroll: true,
        replace: true,
    });
};

</script>

<template>
    <Head :title="product.name"/>
    <Header />
    <div class="grid grid-cols-2 gap-4 items-center justify-center mt-10 mx-10 border-2 border-gray-300 rounded-md bg-white p-10">
        <div class="flex justify-center items-center">
            <img :src="`${$page.props.asset}/${product.photo}`" :alt="props.product.name" class="block h-auto shrink-0">
        </div>
        <div class="flex flex-col">
            <div class="flex justify-between">
                <h1 class="text-gray-700 text-2xl">
                    {{ props.product.name }}
                </h1>
                <div class="font-medium bg-blue-600 px-2 py-1 text-white w-fit rounded-xl">${{ parseFloat(props.product.price).toFixed(2) }}</div>
            </div>
            <div class="text-gray-700 my-4 text-xl">
                {{ props.product.description }}
            </div>
            <div class="flex justify-end rounded-md outline-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:outline-blue-800 w-fit self-end">
                <input type="text" name="quantity" v-model="quantity" pattern="[0-9]*" class="focus:outline-none"/>
                <button 
                    type="button" 
                    class="text-sm bg-blue-800 text-white px-2 py-1" 
                    :class="{ 'disabled': props.product.stock <= 0 }"
                    :disabled="props.product.stock <= 0"
                    @click.self="addToCart"
                >
                    Add to cart
                </button>
            </div>
            <p class="mt-3 text-sm/6 text-gray-600 text-end">In stock {{ props.product.stock }}</p>
            <p class="mt-3 text-sm/6 text-gray-600 text-end">
                <span class="font-medium bg-blue-500 px-2 py-1 text-white w-fit rounded-xl" 
                    v-for="category in props.product.categories">{{ category.name }}</span>
            </p>
        </div>
        
        
    </div>
</template>