<template>
    <div class="relative">
        <div v-if="images.length > 0" class="overflow-hidden rounded-lg">
            <div class="relative h-64 md:h-96">
                <img :src="images[currentIndex].url" class="absolute block w-full h-full object-cover transition-opacity duration-700 ease-in-out" alt="Property image">
            </div>

            <button v-if="images.length > 1" @click="prev" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none">
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 focus:ring-4 focus:ring-white">
                    <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button v-if="images.length > 1" @click="next" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none">
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 focus:ring-4 focus:ring-white">
                    <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>
        <div v-else class="h-64 md:h-96 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
            No Images Available
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
    images: {
        type: Array,
        default: () => []
    }
});

const currentIndex = ref(0);

const next = () => {
    currentIndex.value = (currentIndex.value + 1) % props.images.length;
};

const prev = () => {
    currentIndex.value = (currentIndex.value - 1 + props.images.length) % props.images.length;
};
</script>
