<script setup>

import { ref, onMounted, computed, watch } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

import { library } from '@fortawesome/fontawesome-svg-core'
import { faCartShopping, faCartArrowDown, faTrash } from '@fortawesome/free-solid-svg-icons'
library.add(faCartShopping, faCartArrowDown, faTrash);

const $page = usePage();

const cartTotal = computed(() => {
    if (!$page.props.cart) return 0
    return Object.values($page.props.cart).reduce((total, item) => total + item.total, 0)
})

const itemCount = computed(() => {
    return $page.props.cart?.length || 0
})

const fetchCart = () => {
    axios.get(route('cart.get'))
        .then(response => {
            if (response.data && response.data.data) {
                $page.props.cart = response.data.data;
                cartTotal.value = response.data.data.reduce((total, item) => {
                    return total + item.total;
                }, 0);
                itemCount.value = response.data.data.length;
            } else {
                $page.props.cart = [];
                cartTotal.value = 0;
                itemCount.value = 0;
            }
        });
};

const removeFromCart = (product_id) => {
    router.delete(route('cart.remove', product_id), {}, {
        preserveScroll: true,
        replace: true,
    });
};

onMounted(() => {
    fetchCart();
});

let cartOpened = ref(false);

if ($page.props.flash.error) {
    setTimeout(() => {
        $page.props.flash.error = null
    }, 10000)
}

if ($page.props.flash.message) {
    setTimeout(() => {
        $page.props.flash.message = null
    }, 10000)
}

</script>

<template>
    <header
        class="sticky top-0 bg-white text-black z-2 grid grid-cols-2 gap-2 px-10 items-center shadow-sm"
    >
        <div class="p-1.5">
            <Link
                :href="route('products.catalog')"
                class="rounded-md px-3 py-2 text-black text-lg ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:focus-visible:ring-white"
            >
                Ecommerce module
                <!-- <pre>{{ JSON.stringify($page.props.cart, null, 2) }}</pre> -->
            </Link>
        </div>
        <nav class="flex flex-1 justify-end items-center">

            <template v-if="!$page.props.auth.user">
                <Link
                    :href="route('login')"
                    class="rounded-md px-3 py-2 text-black border-b-2 border-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] hover:border-black"
                >
                    Log in
                </Link>

                <Link
                    :href="route('register')"
                    class="rounded-md px-3 py-2 text-black border-b-2 border-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] hover:border-black"
                >
                    Register
                </Link>
            </template>

            <template v-else-if="$page.props.auth.is_admin">
                <Link
                    :href="route('admin.dashboard')"
                    class="rounded-md px-3 py-2 text-black border-b-2 border-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] hover:border-black"
                >
                    Admin
                </Link>
            </template>

            <!-- Dropdown for cart -->
            <Dropdown contentClasses="bg-white" width="96">
                <template #trigger>
                    <button
                        type="button"
                        class="flex items-center text-lg font-medium text-gray-500 p-4 border rounded-[1rem] border-transparent focus:outline-none hover:border-black/50 transition duration-150 ease-in-out"
                    >
                        <font-awesome-icon :icon="['fas', 'cart-shopping']" />
                        <span class="ml-2">
                            {{ itemCount }}
                        </span>
                    </button>
                </template>

                <template #content>
                    <div v-for="cartItem in $page.props.cart" :key="cartItem.id + Date.now()" class="flex justify-between items-center h-20">
                        <img :src="`${$page.props.asset}/${cartItem.photo}`" alt="" class="h-full w-auto">
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-700">
                                {{ cartItem.name }}
                            </span>
                            <span class="text-sm text-gray-500">
                                {{ cartItem.quantity }} x ${{ cartItem.price }}
                            </span>
                            <span class="text-sm text-gray-500">
                                Total: ${{ cartItem.total.toFixed(2) }}
                            </span>
                        </div>
                        <button
                            type="button"
                            class="text-red-500 hover:text-red-700 px-4 py-2"
                            @click="removeFromCart(cartItem.id)"
                        >
                            <font-awesome-icon :icon="['fas', 'trash']" />
                        </button>
                    </div>
                    <div v-if="$page.props.cart.length > 0" class="flex justify-around items-center h-10">
                        Total: ${{ cartTotal.toFixed(2) }}
                    </div>
                    <div v-else class="text-center text-md py-6">
                        Your cart is empty
                    </div>
                    <a
                        :href="route('cart.checkout')"
                        class="block w-full px-4 py-2 leading-5 transition duration-150 ease-in-out hover:bg-gray-700 hover:text-white focus:bg-gray-100 focus:outline-none text-2xl mt-4 mx-0 text-center"
                    >
                        <font-awesome-icon :icon="['fas', 'cart-arrow-down']" />
                        Checkout
                    </a>
                </template>
            </Dropdown>
        </nav>
    </header>
    <div class="max-w-8xl bg-red-200 text-red-900 border-1 border-red-500 rounded-xl m-4 py-4 px-6 text-md" v-if="$page.props.flash.error">
        {{ $page.props.flash.error }}
    </div>
    <div class="max-w-8xl bg-green-200 text-green-900 border-1 border-green-500 rounded-xl m-4 py-4 px-6 text-md" v-if="$page.props.flash.message">
        {{ $page.props.flash.message }}
    </div>
</template>