import {defineStore} from 'pinia'
import axios from '../plugins/axios'

export const useTaskStore = defineStore('task', {
    state: () => ({
        tasks: [],
        loading: false,
        index_loading: false,
        errors: {},
        form: {
            id: '',
            title: '',
            description: '',
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
        }
    }),
    actions: {
        async fetchTasks(event) {
            let page = 1;
            if (event) {
                page = parseInt(event.target.innerText)
            }
            try {
                this.index_loading = true
                const res = await axios.get(`/tasks?page=${page}`)
                this.tasks = res.data.tasks
                this.index_loading = false
                this.paginated_data = res.data.paginated_data
            } catch (error) {
                this.handleNotification(error);
            }
        },
        async addTask() {
            this.loading = true
            this.errors = {}
            try {
                const res = await axios.post('/tasks', this.createFormData())
                this.handleNotification(res)
                this.resetFormData()
                await this.fetchTasks()
                return true;
            } catch (error) {
                this.handleNotification(error);
                return false;
            }
        },
        async editTask(id) {
            try {
                let res = await axios.get(`/tasks/${id}`)
                this.form = res.data.task;
            } catch (error) {
                this.handleNotification(error);
            }
        },
        async updateTask(id) {
            this.loading = true
            this.errors = {}
            try {
                const res = await axios.post(`/tasks/${id}`, this.createFormData())
                this.handleNotification(res)
                this.resetFormData()
                await this.fetchTasks()
                return true;
            } catch (error) {
                this.handleNotification(error);
                return false;
            }
        },
        async deleteTask(id) {
            if (!confirm('Are you sure?')) {
                return
            }
            try {
                await axios.delete(`/tasks/${id}`)
                await this.fetchTasks()
            } catch (error) {
                this.handleNotification(error);
            }
        },
        async markTaskComplete(id) {
            try {
                this.loading = true;
                const response = await axios.get(`/tasks/complete/${id}`);
                await this.fetchTasks()
                this.handleNotification(response);
            } catch (error) {
                this.handleNotification();
                throw error;
            } finally {
                this.loading = false;
            }
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
        handleNotification(object) {
            if (object.status === 200) {
                console.log(object)
                this.message = {
                    type: 'success',
                    text: object.data.message,
                    show: true,
                    dismissible: true
                };
            } else if (object.response && object.response.status === 422) {
                this.errors = object.response.data.errors;
            } else {
                this.message = {
                    type: 'danger',
                    text: object.response.data.message,
                    show: true,
                    dismissible: true
                };
                this.errors = {}
            }
            this.loading = false;
            this.index_loading = false;
            setTimeout(() => this.clearNotification(), 5000);
        }
    }
})
