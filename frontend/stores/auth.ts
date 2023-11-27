import axios from "axios";
import { defineStore } from "pinia";
import { useRouter } from "vue-router";

interface UserPayloadInterface {
  email: string;
  password: string;
}

export const useAuthStore = defineStore('auth', () => {
  const isAuth = ref(false);
  const loading = ref(false);
  const token = ref('');

  async function authenticateUser({ email, password }: UserPayloadInterface) {
    loading.value = true;
    const {$api} = useNuxtApp();
    await $api.post('/auth/login', {
        email,
        password
    }).then(
      (resp) => {
        const token = useCookie('token');
        token.value = resp.data;
        isAuth.value = true;
      }
    )
    .finally(() => {
      loading.value = false;
    })
  }
    
  function logUserOut() {
    const token = useCookie('token');
    isAuth.value = false;
    token.value = null;
  }

  function hasExpired(){
    const token:any = useCookie('token');
    let finalDate = token.value?.expiration_time;
    finalDate = new Date(finalDate);
    if(finalDate < new Date()){
      return true;
    }
    return false;
  }

  async function refreshToken(){
    const {$api} = useNuxtApp();
    return await $api.get('/auth/refresh')
    .then((resp) => {
      const token = useCookie('token');
      token.value = resp.data;
      isAuth.value = true;
    })
    .catch((err) => {
      console.log("🚀 ~ file: auth.ts:58 ~ refreshToken ~ err:", err)
      toastError('Sua sessão expirou, faça login novamente para utilizar nossos serviços.');
      useRouter().push('/logout');
    });
  }

  return {
    isAuth,
    loading,
    token,
    hasExpired,
    refreshToken,
    authenticateUser,
    logUserOut
  }

});