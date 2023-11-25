import axios from "axios";
import { toastWarning } from "~/utils/sweet-alert";
export default defineNuxtPlugin(async () => {
    const defaultUrl = 'http://localhost:80';
    let api = axios.create({
        baseURL: defaultUrl,
        headers:{
            'Content-Type': 'application/json',
        }
    });
    api.interceptors.request.use(
        config => {
            const token:any = useCookie('token');
            if (token)
            config.headers.Authorization = `Bearer ${token.value?.access_token}`;
            return config;
        },
        error => {
            return Promise.reject(error);
        }
    );
    api.interceptors.response.use(
        response => {
            if (response.status === 200 || response.status === 201) {
                toastSuccess(response.data.message);
                return Promise.resolve(response);
            } else {
                toastWarning(response?.data.message)
                return Promise.reject(response);
            }
        },
        error => {
            if(error.response.data.message) toastError(error.response.data.message)
            if (error.response.status) {
                const router = useRouter();
                const route = useRoute();
                switch (error.response.status) {
                    case 400:
                    
                    //do something
                    break;
                
                    case 401:
                        if(route.name !== 'login'){
                            router.replace({
                                path: "/logout"
                            });
                        }
                        break;
                    case 403:
                        if(route.name !== 'login'){
                            router.replace({
                                path: "/"
                            });
                        }
                        break;
                    case 404:
                        break;
                    case 502:
                        setTimeout(() => {
                            const router = useRouter();
                            useRouter().replace({
                            path: "/logout",
                            });
                        }, 1000);
                    break;
                }
                return Promise.reject(error.response);
            }
        }
    );
    return {
        provide:{
            api:api
        }
    }
});