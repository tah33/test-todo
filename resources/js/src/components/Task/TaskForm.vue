<template>
    <BModal :show="show" @hide="$emit('close')" id="modal-center" centered :title="taskStore.form.id ? 'Edit Task' : 'Create Task'">
        <form>
            <div class="form-group mb-3">
                <label for="title">Title</label>
                <input type="text" v-model="taskStore.form.title" id="title" class="form-control">
                <p class="text-danger" v-if="taskStore.errors.title">{{ taskStore.errors.title[0] }}</p>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea  v-model="taskStore.form.description" id="description" class="form-control"></textarea>
                <p class="text-danger" v-if="taskStore.errors.description">{{ taskStore.errors.description[0] }}</p>
            </div>

        </form>
        <template #footer>
            <BButton variant="secondary" size="sm" @click="$emit('close')">Cancel</BButton>
            <BButton variant="primary" size="sm"
                     @click="submitTask"
                     :disabled="taskStore.loading">
                <template v-if="taskStore.loading">
                    <BSpinner small class="me-1" />
                    Submit...
                </template>
                <template v-else>
                    Submit
                </template>
                </BButton>
        </template>
    </BModal>
</template>
<script setup>
import { useTaskStore } from '../../store/Task.js'
const taskStore = useTaskStore()
import {BButton, BModal, BSpinner} from "bootstrap-vue-next";

defineProps({
    show : {
        type: Boolean,
        required: true
    }
});
const emit = defineEmits(['close']);
async function submitTask() {
    let res;
    if (taskStore.form.id) {
        res = await taskStore.updateTask(taskStore.form.id);
    } else {
        res = await taskStore.addTask();
    }
    if (res) {
        emit('close');
    }
}
</script>
<style scoped>

</style>
