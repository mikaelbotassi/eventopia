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
            if (response.status === 200 || response.status === 201)
                return Promise.resolve(response);
            else {
                if(response?.data.message) toastWarning(response?.data.message)
                return Promise.reject(response);
            }
        },
        error => {
            if(error.response.data.message) toastError(error.response.data.message)
            if (error.response.status) {
                const router = useRouter();
                const route = useRoute();
                switch (error.response.status) {
                
                    case 401:
                        setTimeout(() => {
                            if(route.name !== 'login'){
                                router.replace({
                                    path: "/logout"
                                });
                            }
                        },1000)
                        break;
                    case 403:
                        setTimeout(() => {
                            if(route.name !== 'login'){
                                router.replace({
                                    path: "/"
                                });
                            }
                        },1000)
                        break;
                    case 404:
                        setTimeout(() => {
                            router.replace({
                                path: "/"
                            });
                        },1000)
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