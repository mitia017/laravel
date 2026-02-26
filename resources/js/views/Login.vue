<template>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

            <form @submit.prevent="handleSubmit">
                <div>
                    <label class="block font-medium text-sm text-gray-700" for="email">Email</label>
                    <input v-model="form.email" type="email" id="email" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required autofocus autocomplete="username" />
                    <span v-if="errors.email" class="text-red-600 text-sm">{{ errors.email[0] }}</span>
                </div>

                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700" for="password">Password</label>
                    <input v-model="form.password" type="password" id="password" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required autocomplete="current-password" />
                    <span v-if="errors.password" class="text-red-600 text-sm">{{ errors.password[0] }}</span>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <router-link :to="{ name: 'register' }" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Need an account?
                    </router-link>

                    <button type="submit" class="ms-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" :disabled="loading">
                        Log in
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '../stores/auth';
import { useRouter } from 'vue-router';

const authStore = useAuthStore();
const router = useRouter();

const form = ref({
    email: '',
    password: ''
});

const errors = ref({});
const loading = ref(false);

const handleSubmit = async () => {
    loading.ref = true;
    errors.value = {};
    try {
        await authStore.login(form.value);
        router.push({ name: 'dashboard' });
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
