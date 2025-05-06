<script setup>
import {BAlert} from "bootstrap-vue-next";
import { useTaskStore } from '../store/Task.js';

const taskStore = useTaskStore();
</script>

<template>
    <BAlert
        v-model="taskStore.message.show"
        :variant="taskStore.message.type"
        :dismissible="taskStore.message.dismissible"
        @dismissed="taskStore.clearNotification()"
        style="z-index: 11">
        {{ taskStore.message.text }}
    </BAlert>
</template>

<style scoped>

</style>
