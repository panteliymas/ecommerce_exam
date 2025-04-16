<script setup>

import { ref, computed } from 'vue';
import { router, usePage, Head } from '@inertiajs/vue3';
import Header from '../Partials/Header.vue';
import { library } from '@fortawesome/fontawesome-svg-core'
import { faTrash } from '@fortawesome/free-solid-svg-icons'
library.add(faTrash);
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    cart: {
        type: Object,
        required: true,
    },
    shippingPrice: {
        type: Number,
        default: 0,
    },
});

const $page = usePage();

const cartTotal = computed(() => {
    if (!$page.props.cart) return 0
    return Object.values($page.props.cart).reduce((total, item) => total + item.total, 0)
})

const deliveryInfo = computed(() => {
    return {
        name: $page.props.auth.user?.name || '',
        email: $page.props.auth.user?.email || '',
        address: ''
    }
});

// console.log($page.props.auth.user);

</script>

<template>
    <Head title="Cart" />
    <Header />
    
    <main>
        <div class="bg-white">
            <div class="mx-auto max-w-7xl px-4 py-8 grid grid-cols-4 gap-8">
                <div class="col-span-3 flex flex-col border-1 border-black rounded-xl p-4">
                    <div class="flex justify-between">
                        <h1 class="text-gray-700 text-2xl">Shopping Cart</h1>
                    </div>
                    <div class="mt-6 flex flex-col gap-4">
                        <div 
                            v-for="(item, index) in cart" 
                            :key="index" 
                            class="grid grid-cols-3 items-center gap-4" 
                            :class="{'border-b-1 border-black': index !== cart.length - 1}"
                        >
                            <div class="p-2">
                                <img :src="`${$page.props.asset}/${item.photo}`" :alt="item.name" class="block h-auto shrink-0">
                            </div>
                            <div>
                                <h1 class="text-gray-700 text-xl">
                                    <a
                                        :href="route('products.product', item.id)"
                                        class="text-gray-700 text-xl hover:text-blue-800"
                                    >
                                        {{ item.name }}
                                    </a>
                                </h1>
                                <h2 class="text-gray-500 text-xl grow text-ellipsis line-clamp-3">{{ item.description }}</h2>
                            </div>
                            <div class="flex flex-col justify-between">
                                <p class="text-gray-700 my-4 text-lg text-end">
                                    {{ item.quantity }} for ${{ (parseFloat(item.quantity) * parseFloat(item.price)).toFixed(2) }}
                                </p>
                                <div class="flex justify-end rounded-md outline-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:outline-blue-800 w-fit self-end">
                                    <button 
                                        type="button" 
                                        class="text-sm bg-blue-800 text-white px-2 py-1" 
                                        @click="item.quantity = Math.max(1, parseFloat(item.quantity) - 1)"
                                    >
                                        -
                                    </button>
                                    <input type="text" :name="`cart[${item.id}]`" v-model="item.quantity" pattern="[0-9]*" class="focus:outline-none w-12 text-center"/>
                                    <button 
                                        type="button" 
                                        class="text-sm bg-blue-800 text-white px-2 py-1" 
                                        @click="item.quantity = Math.min(item.stock, parseFloat(item.quantity) + 1)"
                                    >
                                        +
                                    </button>
                                    <button 
                                        type="button" 
                                        class="text-sm bg-red-600 text-white px-2 py-1" 
                                        @click.self="removeFromCart(item.id)"
                                    >
                                        <font-awesome-icon :icon="['fas', 'trash']" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-1 border-1 border-black rounded-xl p-4">
                    <h1 class="text-gray-700 text-2xl text-center">Checkout</h1>
                    <div class="grid grid-cols-2">
                        <div class="flex flex-col">
                            <p class="text-gray-700 my-4 text-lg border-b-1 border-black">Subtotal</p>
                            <p class="text-gray-700 my-4 text-lg border-b-1 border-black">Shipping</p>
                            <p class="text-gray-700 my-4 text-lg border-b-1 border-black">Total</p>
                        </div>
                        <div class="flex flex-col text-end">
                            <p class="text-gray-700 my-4 text-lg border-b-1 border-black">${{ parseFloat(cartTotal).toFixed(2) }}</p>
                            <p class="text-gray-700 my-4 text-lg border-b-1 border-black">${{ parseFloat(shippingPrice) }}</p>
                            <p class="text-gray-700 my-4 text-lg border-b-1 border-black">${{ (parseFloat(cartTotal) + parseFloat(shippingPrice)).toFixed(2) }}</p>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <button 
                            :href="route('cart.checkout.post')" 
                            class="text-sm bg-blue-800 text-white px-2 py-1 w-full text-center hover:cursor-pointer"
                            @click="router.post(route('cart.checkout.post'), { cart: $page.props.cart, deliveryInfo }, { preserveScroll: true })"
                        >
                            Checkout
                        </button>
                    </div>
                </div>
            </div>
            <div class="mx-auto max-w-7xl px-4 py-8 grid grid-cols-4 gap-8">
                <div class="col-span-3 flex flex-col border-1 border-black rounded-xl p-4">
                    <h1 class="text-gray-700 text-2xl">Delivery Information</h1>
                    <div class="mt-6 flex flex-col gap-4">
                        <div v-if="$page.props.auth.user">
                            <form @submit.prevent="router.post(route('cart.checkout.post'), {},  { preserveScroll: true })" class="flex flex-col gap-4">
                                <div class="flex flex-col">
                                    <label for="name" class="text-gray-700">Name</label>
                                    <input 
                                        type="text" 
                                        id="name" 
                                        v-model="deliveryInfo.name" 
                                        name="delivery[name]"
                                        class="border border-gray-300 rounded-md p-2" 
                                        required 
                                    />
                                </div>
                                <div class="flex flex-col">
                                    <label for="email" class="text-gray-700">Email</label>
                                    <input 
                                        type="email" 
                                        id="email" 
                                        v-model="deliveryInfo.email" 
                                        name="delivery[email]"
                                        class="border border-gray-300 rounded-md p-2" 
                                        required 
                                    />
                                </div>
                                <div class="flex flex-col">
                                    <label for="address" class="text-gray-700">Address</label>
                                    <input 
                                        id="address" 
                                        type="text"
                                        class="border border-gray-300 rounded-md p-2"
                                        v-model="deliveryInfo.address"
                                        name="delivery[address]" 
                                        required 
                                    >
                                </div>
                            </form>
                        </div>
                        <div v-else>
                            <div class="flex flex-col items-center gap-4">
                                <p class="text-gray-700">Please log in or register to proceed with delivery information.</p>
                                <div class="flex gap-4">
                                    <a 
                                        :href="route('login')" 
                                        class="text-sm bg-blue-800 text-white px-4 py-2 rounded-md hover:cursor-pointer"
                                    >
                                        Login
                                    </a>
                                    <a 
                                        :href="route('register')" 
                                        class="text-sm bg-green-600 text-white px-4 py-2 rounded-md hover:cursor-pointer"
                                    >
                                        Register
                                    </a>
                                </div>
                            </div>
                        </div>

                        <script setup>
                        const deliveryInfo = ref({
                            name: '',
                            surname: '',
                            phone: '',
                            address: ''
                        });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>