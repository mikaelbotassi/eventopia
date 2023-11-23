import { useAuthStore } from "~/stores/auth"

export default defineNuxtRouteMiddleware((to) => {
    const { isAuth } = storeToRefs(useAuthStore()); // make authenticated state reactive
    const {hasExpired, logUserOut} = useAuthStore();
    const token = useCookie('token'); // get token from cookies

    if (token.value && !hasExpired()) {
        // check if value exists
        isAuth.value = true; // update the state to authenticated
    }

    if(token.value && hasExpired()){
        token.value = null;
        return navigateTo('/login')
    }

    // if token exists and url is /login redirect to homepage
    if (token.value && (to?.name === 'login' || to?.name === 'sing-up')) {
        return navigateTo('/');
    }

    // if token doesn't exist redirect to log in
    if (!token.value && to?.name !== 'login') {
        abortNavigation();
        return navigateTo('/login');
    }
})
  