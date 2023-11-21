import axios from "axios";
import { defineStore } from "pinia";
import { useRouter } from "vue-router";

interface UserPayloadInterface {
  username: string;
  password: string;
}

export const useAuthStore = defineStore('auth', () => {
  const isAuth = ref(false);
  const loading = ref(false);
  const token = ref('');

  async function authenticateUser({ username, password }: UserPayloadInterface) {
    loading.value = true;
    const {$api} = useNuxtApp();
    await $api.post('https://dummyjson.com/auth/login', {
        username,
        password
    }).then(
      (resp) => {
        const token = useCookie('token');
        token.value = resp.data;
        isAuth.value = true;
      }
    ).finally(() => {
      loading.value = false;
    })
  }
    
  function logUserOut() {
    const token = useCookie('token');
    isAuth.value = false;
    token.value = null;
  }

  return {
    isAuth,
    loading,
    token,
    authenticateUser,
    logUserOut
  }

});