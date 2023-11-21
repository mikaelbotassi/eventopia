import axios from "axios";

export default defineNuxtPlugin(async () => {
    const defaultUrl = 'https://localhost:80';
    let api = axios.create({
        baseURL: defaultUrl,
        headers:{
            common:{}
        }
    });
    return {
        provide:{
            api:api
        }
    }
});