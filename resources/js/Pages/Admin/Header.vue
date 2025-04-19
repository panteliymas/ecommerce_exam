<script setup>

import { Link, usePage } from '@inertiajs/vue3';

const $page = usePage();

const is_active = (page) => {
    return $page.url.includes(page);
};

</script>

<template>
    <header class="grid grid-cols-3 items-center bg-gray-500 sticky top-0 z-10 shadow-md text-white py-4 px-6">
        <div class="col-span-1">
            <Link
                :href="route('products.catalog')"
                class="rounded-md px-3 py-2 text-white text-lg ring-1 ring-transparent transition hover:text-white/70 hover:bg-gray-600 focus:outline-none focus-visible:ring-[#FF2D20]"
            >
                Shop
            </Link>
        </div>
        <div class="col-span-1 flex justify-center gap-4">
            <Link
                :href="route('admin.products.catalog')"
                class="rounded-md px-3 py-2 text-white text-lg ring-1 ring-transparent transition hover:text-white/70 hover:bg-gray-600 focus:outline-none focus-visible:ring-[#FF2D20]"
                :class="{ 'bg-gray-700': is_active('products') }"
            >
                Products
            </Link>
            <Link
                :href="route('admin.categories')"
                class="rounded-md px-3 py-2 text-white text-lg ring-1 ring-transparent transition hover:text-white/70 hover:bg-gray-600 focus:outline-none focus-visible:ring-[#FF2D20]"
                :class="{ 'bg-gray-700': is_active('categories') }"
            >
                Categories
            </Link>
        </div>
        <div class="col-span-1 flex justify-end">
            <Link
                :href="route('logout')"
                method="post"
                class="rounded-md px-3 py-2 text-white text-lg ring-1 ring-transparent transition hover:text-white/70 hover:bg-gray-600 focus:outline-none focus-visible:ring-[#FF2D20] hover:cursor-pointer"
            >
                Log out
            </Link>
        </div>
    </header>
</template>