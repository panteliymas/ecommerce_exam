<script setup>

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    price: {
        type: Number,
        required: true,
    },
    photo: {
        type: String,
        required: true,
    },
});

</script>

<template>
    <div class="group relative">
        <img :src="props.photo" :alt="props.name" class="block h-auto w-5 shrink-0">
        <div class="mt-4 flex justify-between">
            <div>
                <h3 class="text-sm text-gray-700">
                <a href="#">
                    <span aria-hidden="true" class="absolute inset-0"></span>
                    {{ props.name }}
                </a>
                </h3>
            </div>
            <p class="text-sm font-medium text-gray-900">${{ parseFloat(props.price).toFixed(2) }}</p>
        </div>
    </div>
</template>