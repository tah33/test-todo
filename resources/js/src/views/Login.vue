<template>
    <div class="container mt-5">
        <div class="row">
            <h5 class="mb-3">Login to See Assigned Tasks</h5>
            <form @submit.prevent="authStore.login()">
                <div class="form-group mb-3">
                    <label for="title">Email</label>
                    <input type="email" v-model="authStore.form.email" id="email" class="form-control">
                    <p class="text-danger" v-if="authStore.errors.email">{{ authStore.errors.email[0] }}</p>
                </div>
                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input type="password" v-model="authStore.form.password" id="password" class="form-control">
                    <p class="text-danger" v-if="authStore.errors.password">{{ authStore.errors.password[0] }}</p>
                </div>
                <div class="form-group text-end">
                    <BButton variant="primary" size="sm"
                             type="submit"
                             :disabled="authStore.loading">
                        <template v-if="authStore.loading">
                            <BSpinner small class="me-1" />
                            Submit...
                        </template>
                        <template v-else>
                            Submit
                        </template>
                    </BButton>
                </div>
            </form>

            <p>Don't have account? <router-link :to="{ name : 'register' }">Click here to Sign up</router-link></p>
        </div>
    </div>
</template>

<script setup>

import {BButton, BSpinner} from "bootstrap-vue-next";
import {ref} from "vue";



</script>
<style scoped>

</style>
