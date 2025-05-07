import { defineStore } from 'pinia';
import axios from '../plugins/axios.js';
import router from "../router/index.js";

export const useAuthStore = defineStore('auth', {
    state: () => ({
        loading: false,
        errors: {},
        form: {
            email: '',
            password: '',
        },
        message: {
            type: '', // 'success' | 'error'
            text: '',
            show: false,
            dismissible: true
        },
        paginated_data : {
            currentPage : 1,
            rows : 10,
            perPage : 10,
        },
        token : localStorage.getItem('token'),
        user : ''
    }),

    actions: {
        async login() {
            try {
                this.loading = true;
                let data = {
                    email: this.form.email,
                    password: this.form.password,
                }
                const response = await axios.post('/login', data);
                this.setTokens(response.data);
                this.loading = false;
                router.push({name: 'tasks'});
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }
                this.loading = false;
                throw error;
            }
        },
        setTokens(data) {
            localStorage.setItem('token', data.user.token);
            this.token = data.user.token;
            this.user = data.user;
            axios.defaults.headers['Authorization'] = `Bearer ${data.user.token}`;
        },
        async fetchUser() {
            try {
                const response = await axios.get('/me');
                this.user = response.data.user;
            } catch (error) {
                this.logout();
                throw error;
            }
        },
        async logout() {
            const response = await axios.post('/logout');
            this.token = null;
            this.user = null;
            localStorage.removeItem('token');
            router.push({ name: 'login' });
        },
        createFormData() {
            const formData = new FormData()
            for (const key in this.form) {
                formData.append(key, this.form[key])
            }
            if(this.form.id) {
                formData.append('_method', 'put')
            }
            return formData
        },
        resetFormData() {
            for (const key in this.form) {
                this.form[key] = '';
            }
        },
        clearNotification() {
            this.message.show = false;
        },
    }
});
