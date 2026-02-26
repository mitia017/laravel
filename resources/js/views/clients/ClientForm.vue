<template>
    <div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">{{ isEdit ? 'Edit Client' : 'Add Client' }}</h2>

        <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6 max-w-2xl mx-auto">
            <form @submit.prevent="handleSubmit">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="name">Name</label>
                        <input v-model="form.name" type="text" id="name" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required />
                        <span v-if="errors.name" class="text-red-600 text-sm">{{ errors.name[0] }}</span>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="email">Email</label>
                        <input v-model="form.email" type="email" id="email" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required />
                        <span v-if="errors.email" class="text-red-600 text-sm">{{ errors.email[0] }}</span>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="phone">Phone</label>
                        <input v-model="form.phone" type="text" id="phone" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" />
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="company">Company</label>
                        <input v-model="form.company" type="text" id="company" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" />
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="address">Address</label>
                        <textarea v-model="form.address" id="address" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" rows="3"></textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <router-link :to="{ name: 'clients.index' }" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Cancel</router-link>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" :disabled="loading">
                        {{ isEdit ? 'Update' : 'Save' }}
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
    name: '',
    email: '',
    phone: '',
    company: '',
    address: ''
});

const errors = ref({});
const loading = ref(false);

onMounted(async () => {
    if (isEdit.value) {
        const response = await axios.get(`/api/clients/${id}`);
        form.value = response.data;
    }
});

const handleSubmit = async () => {
    loading.value = true;
    errors.value = {};
    try {
        if (isEdit.value) {
            await axios.put(`/api/clients/${id}`, form.value);
        } else {
            await axios.post('/api/clients', form.value);
        }
        router.push({ name: 'clients.index' });
    } catch (e) {
        if (e.response && e.response.status === 422) {
            errors.value = e.response.data.errors;
        } else {
            console.error(e);
        }
    } finally {
        loading.value = false;
    }
};
</script>
