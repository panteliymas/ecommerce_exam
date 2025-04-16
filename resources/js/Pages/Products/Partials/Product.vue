<script setup>

import { ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { library } from '@fortawesome/fontawesome-svg-core'
import { faCartPlus } from '@fortawesome/free-solid-svg-icons'
library.add(faCartPlus);

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

let quantity = ref(1);
const addToCart = () => {
    router.post(route('cart.add'), {
        product_id: props.product.id,
        quantity: quantity.value,
    }, {
        preserveScroll: true,
        replace: true
    });
};

</script>

<template>
    <div class="group relative">
        <img :src="`${usePage().props.asset}/${props.product.photo}`" :alt="props.product.name" class="block h-auto shrink-0">
        <div class="text-md mt-4 flex justify-between">
            <div>
                <h3 class="text-gray-700">
                <a :href="route('products.product', props.product.id)">
                    <span aria-hidden="true"></span>
                    {{ props.product.name }}
                </a>
                </h3>
            </div>
            <p class="font-medium text-gray-900">${{ parseFloat(props.product.price).toFixed(2) }}</p>
        </div>
        <div class="flex justify-end rounded-md outline-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:outline-blue-800">
            <input type="text" name="quantity" v-model="quantity" pattern="[0-9]*" class="focus:outline-none grow"/>
            <button 
                type="button" 
                class="text-sm bg-blue-800 text-white px-2 py-1" 
                @click.self="addToCart"
            >
                <font-awesome-icon :icon="['fas', 'cart-plus']" />
                Add to cart
            </button>
        </div>
    </div>
</template>