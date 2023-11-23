import axios from "axios";

export default defineNuxtPlugin(async () => {
    const defaultUrl = 'http://localhost:80';
    let api = axios.create({
        baseURL: defaultUrl,
        headers:{
            'Content-Type': 'application/json',
        }
    });
    return {
        provide:{
            api:api
        }
    }
});