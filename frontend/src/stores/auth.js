import { defineStore } from 'pinia';
import api from '../api/axios';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        token: localStorage.getItem('token')
    }),

    actions: {

        async login(data) {
            const res = await api.post('/login', data);

            this.token = res.data.token;
            localStorage.setItem('token', this.token);

            await this.fetchUser();
        },

        async fetchUser() {
            const res = await api.get('/me');
            this.user = res.data;
        },

        logout() {
            localStorage.removeItem('token');
            this.token = null;
            this.user = null;
        }
    }
});