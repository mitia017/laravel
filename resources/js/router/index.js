import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'dashboard',
            component: () => import('../views/Dashboard.vue'),
            meta: { requiresAuth: true }
        },
        {
            path: '/login',
            name: 'login',
            component: () => import('../views/Login.vue'),
            meta: { guest: true }
        },
        {
            path: '/register',
            name: 'register',
            component: () => import('../views/Register.vue'),
            meta: { guest: true }
        },
        {
            path: '/clients',
            name: 'clients.index',
            component: () => import('../views/clients/ClientList.vue'),
            meta: { requiresAuth: true }
        },
        {
            path: '/clients/create',
            name: 'clients.create',
            component: () => import('../views/clients/ClientForm.vue'),
            meta: { requiresAuth: true }
        },
        {
            path: '/clients/:id/edit',
            name: 'clients.edit',
            component: () => import('../views/clients/ClientForm.vue'),
            meta: { requiresAuth: true },
            props: true
        },
        {
            path: '/invoices',
            name: 'invoices.index',
            component: () => import('../views/invoices/InvoiceList.vue'),
            meta: { requiresAuth: true }
        },
        {
            path: '/invoices/create',
            name: 'invoices.create',
            component: () => import('../views/invoices/InvoiceForm.vue'),
            meta: { requiresAuth: true }
        },
        {
            path: '/properties',
            name: 'properties.index',
            component: () => import('../views/properties/PropertyList.vue'),
            meta: { requiresAuth: true }
        },
        {
            path: '/properties/create',
            name: 'properties.create',
            component: () => import('../views/properties/PropertyForm.vue'),
            meta: { requiresAuth: true }
        },
        {
            path: '/properties/:id/edit',
            name: 'properties.edit',
            component: () => import('../views/properties/PropertyForm.vue'),
            meta: { requiresAuth: true },
            props: true
        },
        {
            path: '/properties/:id',
            name: 'properties.show',
            component: () => import('../views/properties/PropertyShow.vue'),
            meta: { requiresAuth: true },
            props: true
        }
    ]
});

router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();
    const isAuthenticated = !!authStore.token;

    if (to.meta.requiresAuth && !isAuthenticated) {
        next({ name: 'login' });
    } else if (to.meta.guest && isAuthenticated) {
        next({ name: 'dashboard' });
    } else {
        next();
    }
});

export default router;
