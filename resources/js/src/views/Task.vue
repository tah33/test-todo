<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <FlashMessage
                    :show="taskStore.message.show"
                    :type="taskStore.message.type"
                    :message="taskStore.message.text"
                    @close="taskStore.clearNotification"
                />
            </div>
            <div class="col-lg-12 d-flex justify-content-between">
                <h5>Task List</h5>
                <BButton variant="primary" size="sm" @click="modal = !modal">+ Add New</BButton>
            </div>
        </div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="taskStore.index_loading">
                <td colspan="3" class="text-center text-muted py-3">
                    Loading.....
                </td>
            </tr>

            <tr v-else-if="taskStore.tasks.length === 0">
                <td colspan="3" class="text-center text-muted py-3">
                    No Tasks Found
                </td>
            </tr>
            <tr v-else v-for="(task,index) in taskStore.tasks" :key="index">
                <td>{{ taskStore.paginated_data.first_item + index }}</td>
                <td>{{ task.title }}</td>
                <td>
                    <span v-if="task.is_completed" class="badge bg-success">Completed</span>
                    <BButton variant="primary" size="sm" v-else @click="taskStore.markTaskComplete(task.id)">Mark as Complete</BButton>
                </td>
                <td>
                    <BDropdown size="sm" text="Action" variant="primary" class="me-2">
                        <BDropdownItem href="javascript:void(0)" @click="editTask(task.id)">Edit</BDropdownItem>
                        <BDropdownItem href="javascript:void(0)" @click="taskStore.deleteTask(task.id)">Delete</BDropdownItem>
                    </BDropdown>
                </td>
            </tr>
            </tbody>
        </table>
        <BContainer v-if="!taskStore.index_loading && taskStore.tasks.length > 0">
            <BRow>
                <BCol>
                    <div class="overflow-auto">
                        <b-pagination
                            v-model="taskStore.paginated_data.currentPage"
                            :total-rows="taskStore.paginated_data.rows"
                            :per-page="taskStore.paginated_data.perPage"
                            aria-controls="my-table"
                            @page-click="taskStore.fetchTasks($event)"
                        />
                    </div>
                </BCol>
            </BRow>
        </BContainer>
        <TaskForm :show="modal" @close="modal = false"/>
    </div>
</template>

<script setup>

import {BButton, BCol, BContainer, BDropdown, BDropdownItem, BPagination, BRow, BSpinner} from "bootstrap-vue-next";
import {useTaskStore} from '../store/Task.js'

const taskStore = useTaskStore()
import FlashMessage from "../components/FlashMessage.vue";
import TaskForm from "../components/Task/TaskForm.vue";
import {onMounted, ref} from "vue";

onMounted(() => {
    taskStore.fetchTasks()
})
const modal = ref(false);

async function editTask(id) {
    modal.value = !modal.value
    await taskStore.editTask(id)
}

</script>
<style scoped>

</style>
