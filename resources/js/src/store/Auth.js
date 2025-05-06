import { defineStore } from 'pinia';
import {computed, reactive, ref} from 'vue';
import axios from '../plugins/axios.js';
import router from "../router/index.js";

export const useAuthStore = defineStore('auth', () => {
    const token = ref(null);
    const user = ref(null);
    const form = ref({
        email: '',
        password: '',
    });
    const errors = ref({});
    const loading = ref(false);

    const login = async () => {
        try {
            loading.value = true;
            let data = {
                email: form.value.email,
                password: form.value.password,
            }
            const response = await axios.post('/login', data);
            setTokens(response.data);
            loading.value = false;
        } catch (error) {
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors;
            }
            loading.value = false;
            logout();
            throw error;
        }
    };

    const setTokens = (data) => {
        token.value = data.token;
        user.value = data.user;
        if (! data.user) {
            fetchUser()
        }
        localStorage.setItem('token', data.token);
    };

    const fetchUser = async () => {
        try {
            const response = await axios.get('/me');
            user.value = response.data;
        } catch (error) {
            logout();
            throw error;
        }
    };
    const logout = () => {
        token.value = null;
        user.value = null;
        localStorage.removeItem('token');
        router.push({ name: 'login' });
    };

    return {
        form,
        login,
        errors,
        loading,
        token,
        user,
        isAuthenticated: computed(() => !!token.value),
        setTokens,
        logout
    };
});
