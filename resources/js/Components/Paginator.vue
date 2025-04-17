<script setup>

defineProps(['elements']);

const emit = defineEmits(['pageChange']);

const handleClick = (url) => {
    emit('pageChange', url);
};

</script>

<template>
    <div id="pagination" class="w-full flex justify-center border-t border-gray-100 pt-4 items-center">
        <div class="flex flex-wrap items-center">
            <div>
                <a
                    v-if="elements.current_page == elements.from"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 bg-blue-300 text-white rounded"
                    :href="elements.prev_page_url"
                    @click.prevent>
                    &lt;
                </a>
                <a
                    v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border border-blue-400 rounded hover:bg-blue-700 focus:border-blue-800 hover:text-white"
                    :href="elements.prev_page_url"
                    @click.prevent="handleClick(elements.prev_page_url)"
                >
                    &lt;
                </a>
            </div>
            <div v-for="(link, key) in elements.links.slice(1, elements.last_page + 1)" :key="key">
                <a
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border border-blue-400 rounded hover:bg-blue-700 focus:border-blue-800 hover:text-white"
                    :class="{ 'bg-blue-500 text-white': link.active }" 
                    :href="link.url" 
                    v-html="link.label"
                    @click.prevent="handleClick(link.url)"
                >
                </a>
            </div>
            <div>
                <a
                    v-if="elements.current_page == elements.last_page"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 bg-blue-300 text-white rounded"
                    :href="elements.next_page_url"
                    @click.prevent>
                    &gt;
                </a>
                <a
                    v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border border-blue-400 rounded hover:bg-blue-700 focus:border-blue-800 hover:text-white"
                    :href="elements.next_page_url"
                    @click.prevent="handleClick(elements.next_page_url)"
                >
                    &gt;
                </a>
            </div>
        </div>
    </div>
</template>