<script setup>
import {BNavbar, BNavbarBrand, BNavbarNav, BNavItemDropdown, BDropdownItem, BCollapse, BNavbarToggle} from "bootstrap-vue-next";

import {useAuthStore} from './store/Auth.js'
import {onMounted} from "vue";
const authStore = useAuthStore()

onMounted( () => {
    if (authStore.token) {
        authStore.fetchUser()
    }
})
</script>

<template>
    <BNavbar v-if="authStore.user" toggleable="lg" variant="primary">
        <BNavbarBrand href="#">NavBar</BNavbarBrand>
        <BNavbarToggle target="nav-collapse" />
        <BCollapse id="nav-collapse" is-nav>
            <BNavbarNav class="ms-auto mb-2 mb-lg-0">
                <BNavItemDropdown right>
                    <!-- Using 'button-content' slot -->
                    <template #button-content>
                        <em class="text-white">{{ authStore.user.name }}</em>
                    </template>
                    <BDropdownItem href="javascript:void(0)" data-test="sign-out" @click="authStore.logout">Sign Out</BDropdownItem>
                </BNavItemDropdown>
            </BNavbarNav>
        </BCollapse>
    </BNavbar>
    <router-view />
</template>

<style scoped>
</style>
