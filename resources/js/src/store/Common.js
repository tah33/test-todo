import { defineStore } from 'pinia';
import {computed, ref} from 'vue';

export const useCommonStore = defineStore('helpers', {
    state: () => ({
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

    }
})
