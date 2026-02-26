<template>
    <div v-if="property">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">{{ property.title }}</h2>
            <router-link :to="{ name: 'properties.index' }" class="text-indigo-600 hover:text-indigo-900">Back to List</router-link>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <PropertyCarousel :images="property.images" />

                <div class="mt-8 bg-white shadow sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4">Description</h3>
                    <p class="text-gray-700 whitespace-pre-line">{{ property.description }}</p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <div class="text-3xl font-bold text-indigo-600 mb-4">${{ property.price }}</div>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div class="text-gray-500">Type</div>
                        <div class="text-gray-900 font-medium capitalize">{{ property.type }}</div>

                        <div class="text-gray-500">Status</div>
                        <div class="text-gray-900 font-medium capitalize">{{ property.status }}</div>

                        <div class="text-gray-500">Area</div>
                        <div class="text-gray-900 font-medium">{{ property.area }} sqft</div>

                        <div class="text-gray-500">Bedrooms</div>
                        <div class="text-gray-900 font-medium">{{ property.bedrooms }}</div>

                        <div class="text-gray-500">Bathrooms</div>
                        <div class="text-gray-900 font-medium">{{ property.bathrooms }}</div>
                    </div>
                </div>

                <div class="bg-white shadow sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4">Location</h3>
                    <p class="text-gray-700">{{ property.address }}</p>
                </div>

                <div class="flex flex-col space-y-3">
                    <router-link :to="{ name: 'properties.edit', params: { id: property.id } }" class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Edit Property
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import PropertyCarousel from '../../components/PropertyCarousel.vue';

const route = useRoute();
const property = ref(null);

onMounted(async () => {
    const response = await axios.get(`/api/properties/${route.params.id}`);
    property.value = response.data;
});
</script>
