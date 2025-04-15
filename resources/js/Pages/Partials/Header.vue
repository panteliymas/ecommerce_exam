<script setup>

import { Link } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown';

</script>

<template>
    <header
        class="sticky top-0 m-2 bg-white z-2 grid grid-cols-2 items-center gap-2 p-10 lg:grid-cols-3"
    >
        <div class="p-1.5">
            Ecommerce module
        </div>
        <nav class="-mx-3 flex flex-1 justify-end">

            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
            >
                <i class="fa-solid fa-cart-shopping"></i>
            </Link>

            <template v-else>
                <Link
                    :href="route('login')"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                    Log in
                </Link>

                <Link
                    :href="route('register')"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                    Register
                </Link>
            </template>
        </nav>
    </header>
</template>