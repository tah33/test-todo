import axios from 'axios'

const token = localStorage.getItem('token');

const instance = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000/api', // Laravel API
    withCredentials: true, // if you're using cookies,
    headers : {
        'Authorization': `Bearer ${token}`
    }
})

export default instance
