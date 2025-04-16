<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
    classList: {
        type: String,
        default: '',
    },
});
</script>

<template>
    <Link
        :href="href"
        class="block w-full px-4 py-2 leading-5 transition duration-150 ease-in-out hover:bg-gray-700 hover:text-white focus:bg-gray-100 focus:outline-none"
        :class="classList"
    >
        <slot />
    </Link>
</template>
