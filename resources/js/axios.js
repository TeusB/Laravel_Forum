import axios from 'axios'

const instance = axios.create({
    baseURL: 'https://freeonlinecrm.com:8000/api/',
    timeout: 5000
})

export default instance
