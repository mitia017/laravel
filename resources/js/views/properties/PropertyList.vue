<template>
    <div>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Properties</h2>
            <router-link :to="{ name: 'properties.create' }" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Add Property
            </router-link>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div v-for="property in properties" :key="property.id" class="bg-white overflow-hidden shadow sm:rounded-lg">
                <img v-if="property.images.length" :src="property.images[0].url" class="w-full h-48 object-cover" />
                <div v-else class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">No Image</div>

                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ property.title }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ property.description }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-indigo-600 font-bold">${{ property.price }}</span>
                        <span class="text-sm text-gray-500">{{ property.type }}</span>
                    </div>
                    <div class="mt-4 flex justify-end space-x-4">
                        <router-link :to="{ name: 'properties.show', params: { id: property.id } }" class="text-sm text-indigo-600 hover:text-indigo-900">View</router-link>
                        <router-link :to="{ name: 'properties.edit', params: { id: property.id } }" class="text-sm text-gray-600 hover:text-gray-900">Edit</router-link>
                        <button @click="deleteProperty(property.id)" class="text-sm text-red-600 hover:text-red-900">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const properties = ref([]);

const fetchProperties = async () => {
    const response = await axios.get('/api/properties');
    properties.value = response.data;
};

const deleteProperty = async (id) => {
    if (confirm('Are you sure you want to delete this property?')) {
        await axios.delete(`/api/properties/${id}`);
        fetchProperties();
    }
};

onMounted(fetchProperties);
</script>
