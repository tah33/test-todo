import axios from 'axios'

const instance = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000/api', // Laravel API
    withCredentials: true // if you're using cookies
})

export default instance
