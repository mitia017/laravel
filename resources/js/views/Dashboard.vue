<template>
    <div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Dashboard</h2>

        <div v-if="stats" class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6">
                <div class="text-sm font-medium text-gray-500 truncate">Total Clients</div>
                <div class="mt-1 text-3xl font-semibold text-gray-900">{{ stats.total_clients }}</div>
            </div>
            <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6">
                <div class="text-sm font-medium text-gray-500 truncate">Total Invoices</div>
                <div class="mt-1 text-3xl font-semibold text-gray-900">{{ stats.total_invoices }}</div>
            </div>
            <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6">
                <div class="text-sm font-medium text-gray-500 truncate">Total Revenue</div>
                <div class="mt-1 text-3xl font-semibold text-gray-900">${{ stats.total_revenue }}</div>
            </div>
            <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6">
                <div class="text-sm font-medium text-gray-500 truncate">Pending Invoices</div>
                <div class="mt-1 text-3xl font-semibold text-gray-900">{{ stats.pending_invoices }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Recent Clients</h3>
                </div>
                <div class="p-6">
                    <ul class="divide-y divide-gray-100">
                        <li v-for="client in stats?.recent_clients" :key="client.id" class="py-3 flex justify-between">
                            <span>{{ client.name }}</span>
                            <span class="text-gray-500 text-sm">{{ client.email }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Recent Invoices</h3>
                </div>
                <div class="p-6">
                    <ul class="divide-y divide-gray-100">
                        <li v-for="invoice in stats?.recent_invoices" :key="invoice.id" class="py-3 flex justify-between">
                            <span>{{ invoice.number }} ({{ invoice.client.name }})</span>
                            <span :class="getStatusClass(invoice.status)">{{ invoice.status }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const stats = ref(null);

onMounted(async () => {
    try {
        const response = await axios.get('/api/dashboard');
        stats.value = response.data;
    } catch (e) {
        console.error(e);
    }
});

const getStatusClass = (status) => {
    switch (status) {
        case 'paid': return 'text-green-600 font-medium';
        case 'pending': return 'text-yellow-600 font-medium';
        case 'cancelled': return 'text-red-600 font-medium';
        default: return 'text-gray-600';
    }
};
</script>
