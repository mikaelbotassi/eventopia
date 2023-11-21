import { useAuthStore } from "~/stores/auth"

export default defineNuxtRouteMiddleware((to, from) => {
    if(to.name !== "login"){
        const auth = useAuthStore();
        auth.isAuth ? navigateTo(to) : navigateTo('/login');
    }
    else navigateTo(to);
})
  