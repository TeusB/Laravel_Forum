import axios from 'axios'

const instance = axios.create({
    baseURL: 'https://fritsnotenboom.nl:8000/api/',
    timeout: 5000
})

export default instance
