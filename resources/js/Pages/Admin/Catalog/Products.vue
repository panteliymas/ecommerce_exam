<script setup>

import { Head, router, Link } from '@inertiajs/vue3';
import Header from '@/Pages/Admin/Header.vue';
import { library } from '@fortawesome/fontawesome-svg-core'
import { faEdit, faTrash } from '@fortawesome/free-solid-svg-icons'
library.add(faEdit, faTrash);

defineProps({
    products: {
        type: Array,
        required: true
    }
});

const deleteProduct = (id) => {
    router.delete(route('admin.products.delete', id), {}, {
        preserveScroll: true,
        replace: true,
    });
};

</script>

<template>
    <Head title="Admin Products" />
    <Header />

    <div class="flex justify-end max-w-7xl mx-auto overflow-scroll">
        <div class="flex p-4 m-4">
            <a
                class="text-md bg-blue-800 text-white px-4 py-2 rounded-xl w-full text-center hover:cursor-pointer"
                :href="route('admin.products.create')"
            >
                Create new product
            </a>
        </div>
    </div>
    <div class="flex max-w-7xl mx-auto overflow-scroll">
        <table class="table-auto min-w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2">Stock</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products" :key="product.id">
                    <td class="border px-4 py-2">{{ product.id }}</td>
                    <td class="border px-4 py-2">{{ product.name }}</td>
                    <td class="border px-4 py-2">{{ product.description }}</td>
                    <td class="border px-4 py-2">{{ product.price }}</td>
                    <td class="border px-4 py-2">{{ product.stock }}</td>
                    <td class="border px-4 py-2">
                        <button @click="router.visit(route('admin.products.product', product.id))" class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            <font-awesome-icon :icon="['fas', 'edit']" />
                            Edit
                        </button>
                        <button @click.prevent="deleteProduct(product.id)" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5" href="#">
                            <font-awesome-icon :icon="['fas', 'trash']" />
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>