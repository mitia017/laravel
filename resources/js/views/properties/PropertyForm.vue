<template>
    <div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">{{ isEdit ? 'Edit Property' : 'Add Property' }}</h2>

        <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6 max-w-4xl mx-auto">
            <form @submit.prevent="handleSubmit">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block font-medium text-sm text-gray-700" for="title">Title</label>
                        <input v-model="form.title" type="text" id="title" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required />
                    </div>

                    <div class="md:col-span-2">
                        <label class="block font-medium text-sm text-gray-700" for="description">Description</label>
                        <textarea v-model="form.description" id="description" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" rows="4" required></textarea>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="price">Price ($)</label>
                        <input v-model="form.price" type="number" step="0.01" id="price" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required />
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="type">Type</label>
                        <select v-model="form.type" id="type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                            <option value="house">House</option>
                            <option value="apartment">Apartment</option>
                            <option value="villa">Villa</option>
                            <option value="land">Land</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block font-medium text-sm text-gray-700" for="address">Address</label>
                        <input v-model="form.address" type="text" id="address" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required />
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="status">Status</label>
                        <select v-model="form.status" id="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                            <option value="available">Available</option>
                            <option value="sold">Sold</option>
                            <option value="rented">Rented</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="area">Area (sqft)</label>
                        <input v-model="form.area" type="number" id="area" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" />
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="bedrooms">Bedrooms</label>
                        <input v-model="form.bedrooms" type="number" id="bedrooms" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" />
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="bathrooms">Bathrooms</label>
                        <input v-model="form.bathrooms" type="number" id="bathrooms" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" />
                    </div>

                    <div class="md:col-span-2">
                        <label class="block font-medium text-sm text-gray-700">Images</label>
                        <input type="file" multiple @change="handleFileChange" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                        <div v-if="existingImages.length > 0" class="mt-4 grid grid-cols-4 gap-4">
                            <div v-for="img in existingImages" :key="img.id" class="relative">
                                <img :src="img.url" class="h-20 w-full object-cover rounded" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-8">
                    <router-link :to="{ name: 'properties.index' }" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Cancel</router-link>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" :disabled="loading">
                        {{ isEdit ? 'Update Property' : 'Save Property' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const router = useRouter();

const id = route.params.id;
const isEdit = computed(() => !!id);

const form = ref({
    title: '',
    description: '',
    price: 0,
    address: '',
    type: 'house',
    status: 'available',
    bedrooms: null,
    bathrooms: null,
    area: null
});

const selectedFiles = ref([]);
const existingImages = ref([]);
const loading = ref(false);

onMounted(async () => {
    if (isEdit.value) {
        const response = await axios.get(`/api/properties/${id}`);
        const data = response.data;
        form.value = {
            title: data.title,
            description: data.description,
            price: data.price,
            address: data.address,
            type: data.type,
            status: data.status,
            bedrooms: data.bedrooms,
            bathrooms: data.bathrooms,
            area: data.area
        };
        existingImages.value = data.images;
    }
});

const handleFileChange = (e) => {
    selectedFiles.value = Array.from(e.target.files);
};

const handleSubmit = async () => {
    loading.value = true;
    const formData = new FormData();

    // Append form fields
    for (const key in form.value) {
        if (form.value[key] !== null) {
            formData.append(key, form.value[key]);
        }
    }

    // Append images
    selectedFiles.value.forEach((file) => {
        formData.append('images[]', file);
    });

    try {
        if (isEdit.value) {
            // Laravel doesn't support FormData in PUT requests well, use POST with _method=PUT
            formData.append('_method', 'PUT');
            await axios.post(`/api/properties/${id}`, formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });
        } else {
            await axios.post('/api/properties', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });
        }
        router.push({ name: 'properties.index' });
    } catch (e) {
        console.error(e);
    } finally {
        loading.value = false;
    }
};
</script>
