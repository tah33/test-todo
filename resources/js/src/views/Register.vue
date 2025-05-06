<template>
    <div class="container mt-5">
        <div class="row">
            <h5 class="mb-3">Register to manage tasks easily</h5>
            <form @submit.prevent="register()">
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" v-model="form.name" id="name" class="form-control">
                    <p class="text-danger" v-if="errors.name">{{ errors.name[0] }}</p>
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" v-model="form.email" id="email" class="form-control">
                    <p class="text-danger" v-if="errors.email">{{ errors.email[0] }}</p>
                </div>
                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input type="password" v-model="form.password" id="password" class="form-control">
                    <p class="text-danger" v-if="errors.password">{{ errors.password[0] }}</p>
                </div>
                <div class="form-group mb-3">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" v-model="form.password_confirmation" id="password_confirmation" class="form-control">
                </div>
                <div class="form-group text-end">
                    <BButton variant="primary" size="sm"
                             type="submit"
                             :disabled="loading">
                        <template v-if="loading">
                            <BSpinner small class="me-1" />
                            Submit...
                        </template>
                        <template v-else>
                            Submit
                        </template>
                    </BButton>
                </div>
            </form>

            <p>Don't have account? <router-link :to="{ name : 'login' }">Click here to Login</router-link></p>
        </div>
    </div>
</template>

<script setup>

import {BButton, BSpinner} from "bootstrap-vue-next";
import {useAuthStore} from '../store/Auth.js'

const authStore = useAuthStore()
import {ref} from "vue";
import axios from "../plugins/axios.js";
import router from "../router/index.js";
const form = ref({
    name: '',
    email: '',
    password: '',
});
const errors = ref({});
const loading = ref(false);

const register = async () => {
    try {
        loading.value = true;
        let data = {
            name: form.value.name,
            email: form.value.email,
            password: form.value.password,
            password_confirmation: form.value.password,
        }
        await axios.post('/register', data);
        localStorage.setItem('token', data.token);
        loading.value = false;
        router.push({ name: 'login' });
    } catch (error) {
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors;
        }
        loading.value = false;
        throw error;
    }
};


</script>
<style scoped>

</style>
