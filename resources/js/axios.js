import axios from 'axios'

const instance = axios.create({
    baseURL: 'https://127.0.0.1:8000/api/',
    timeout: 5000
    
})

export default instance
