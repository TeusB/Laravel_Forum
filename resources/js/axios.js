import axios from 'axios'

const instance = axios.create({
    baseURL: 'https://fritsnotenboom.nl/',
    timeout: 5000
    
})

export default instance
