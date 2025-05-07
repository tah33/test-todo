<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="col-lg-12">
<!--                    <FlashMessage
                        :show="authStore.message.show"
                        :type="authStore.message.type"
                        :message="authStore.message.text"
                        @close="authStore.clearNotification"
                    />-->
                </div>
                <div class="card">
                    <div class="card-header">Log In</div>
                    <div class="card-body">
                        <h5 class="mb-3">Login to See Assigned Tasks</h5>
                        <form @submit.prevent="authStore.login()">
                            <div class="form-group mb-3">
                                <label for="title">Email</label>
                                <input type="email" name="email" v-model="authStore.form.email" id="email" class="form-control">
                                <p class="text-danger" v-if="authStore.errors.email">{{ authStore.errors.email[0] }}</p>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" v-model="authStore.form.password" id="password" class="form-control">
                                <p class="text-danger" v-if="authStore.errors.password">{{ authStore.errors.password[0] }}</p>
                            </div>
                            <div class="form-group text-end">
                                <BButton variant="primary" size="sm"
                                         type="submit"
                                         :disabled="authStore.loading">
                                    <template v-if="authStore.loading">
                                        <BSpinner small class="me-1" />
                                        Login...
                                    </template>
                                    <template v-else>
                                        Login
                                    </template>
                                </BButton>
                            </div>
                        </form>

                        <p>Don't have account? <router-link :to="{ name : 'register' }">Click here to Sign up</router-link></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import FlashMessage from "../components/FlashMessage.vue";
import {BButton, BSpinner} from "bootstrap-vue-next";
import {useAuthStore} from '../store/Auth.js'
const authStore = useAuthStore()



</script>
<style scoped>

</style>
