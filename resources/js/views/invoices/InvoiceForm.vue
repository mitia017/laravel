<template>
    <div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Create Invoice</h2>

        <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6 max-w-2xl mx-auto">
            <form @submit.prevent="handleSubmit">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="client">Client</label>
                        <select v-model="form.client_id" id="client" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                            <option value="">Select a client</option>
                            <option v-for="client in clients" :key="client.id" :value="client.id">{{ client.name }}</option>
                        </select>
                        <span v-if="errors.client_id" class="text-red-600 text-sm">{{ errors.client_id[0] }}</span>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="number">Invoice Number</label>
                        <input v-model="form.number" type="text" id="number" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required />
                        <span v-if="errors.number" class="text-red-600 text-sm">{{ errors.number[0] }}</span>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="amount">Amount</label>
                        <input v-model="form.amount" type="number" step="0.01" id="amount" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required />
                        <span v-if="errors.amount" class="text-red-600 text-sm">{{ errors.amount[0] }}</span>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="status">Status</label>
                        <select v-model="form.status" id="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="date">Date</label>
                        <input v-model="form.date" type="date" id="date" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <router-link :to="{ name: 'invoices.index' }" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Cancel</router-link>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" :disabled="loading">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();

const clients = ref([]);
const form = ref({
    client_id: '',
    number: 'INV-' + Date.now(),
    amount: 0,
    status: 'pending',
    date: new Date().toISOString().split('T')[0]
});

const errors = ref({});
const loading = ref(false);

onMounted(async () => {
    const response = await axios.get('/api/clients');
    clients.value = response.data;
});

const handleSubmit = async () => {
    loading.value = true;
    errors.value = {};
    try {
        await axios.post('/api/invoices', form.value);
        router.push({ name: 'invoices.index' });
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
