import { defineStore } from "pinia";
import { useRouter } from "vue-router";
import type { OwnerUser } from "~/models/user/User";

interface UserPayloadInterface {
  email: string;
  password: string;
}

export const useAuthStore = defineStore('auth', () => {
  const isAuth = ref(false);
  const loading = ref(false);
  const token = ref('');
  const url = '/auth/';

  async function authenticateUser({ email, password }: UserPayloadInterface) {
    loading.value = true;
    const {$api} = useNuxtApp();
    await $api.post(`${url}login`, {
        email,
        password
    }).then(
      (resp) => {
        const token = useCookie('token');
        token.value = resp.data;
        isAuth.value = true;
        toastSuccess(resp.data.message);
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
    toastSuccess("Usuário deslogado");
  }

  function hasExpired(){
    const token:any = useCookie('token');
    let finalDate = token.value?.expiration_time;
    finalDate = new Date(finalDate);
    if(finalDate < new Date()) return true;
    return false;
  }

  async function refreshToken(){
    const {$api} = useNuxtApp();
    return await $api.get(`${url}refresh`)
    .then((resp) => {
      const token = useCookie('token');
      token.value = resp.data;
      isAuth.value = true;
      return true;
    })
    .catch((err) => {
      toastError('Sua sessão expirou, faça login novamente para utilizar nossos serviços.');
      return false;
    });
  }

  async function validatePassword(password:string){
    loading.value = true;
    const {$api} = useNuxtApp();
    return await $api.post(`${url}validate-password`, {password:password})
    .then(() => true)
    .catch(() => false)
    .finally(() => {
      loading.value = false;
    })
  }

  async function me(){
    const {$api} = useNuxtApp();
    const resp:any = await $api.get(`${url}me`);
    return resp.data.data as OwnerUser
  }

  return {
    isAuth,
    loading,
    token,
    hasExpired,
    refreshToken,
    authenticateUser,
    logUserOut,
    me,
    validatePassword
  }

});