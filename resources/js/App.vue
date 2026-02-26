<template>
    <div class="min-h-screen bg-gray-100">
        <Navbar v-if="authStore.token" />
        <main class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <router-view></router-view>
            </div>
        </main>
    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import Navbar from './components/Navbar.vue';
import { useAuthStore } from './stores/auth';
import axios from 'axios';

const authStore = useAuthStore();

onMounted(() => {
    if (authStore.token) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${authStore.token}`;
        authStore.fetchUser();
    }
});
</script>
