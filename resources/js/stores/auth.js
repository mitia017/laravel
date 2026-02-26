import { defineStore } from 'pinia';
import axios from 'axios';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: JSON.parse(localStorage.getItem('user')) || null,
        token: localStorage.getItem('token') || null,
    }),
    actions: {
        async login(credentials) {
            const response = await axios.post('/api/login', credentials);
            this.user = response.data.user;
            this.token = response.data.token;
            localStorage.setItem('user', JSON.stringify(this.user));
            localStorage.setItem('token', this.token);
            axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
        },
        async register(userData) {
            const response = await axios.post('/api/register', userData);
            this.user = response.data.user;
            this.token = response.data.token;
            localStorage.setItem('user', JSON.stringify(this.user));
            localStorage.setItem('token', this.token);
            axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
        },
        async logout() {
            try {
                await axios.post('/api/logout');
            } catch (e) {
                console.error('Logout failed', e);
            }
            this.user = null;
            this.token = null;
            localStorage.removeItem('user');
            localStorage.removeItem('token');
            delete axios.defaults.headers.common['Authorization'];
        },
        async fetchUser() {
            if (!this.token) return;
            try {
                const response = await axios.get('/api/user');
                this.user = response.data;
                localStorage.setItem('user', JSON.stringify(this.user));
            } catch (e) {
                this.logout();
            }
        }
    }
});
