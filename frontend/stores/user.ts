import { defineStore } from "pinia";
import type { CreateUser } from "~/models/user/User";
import { toastError } from "~/utils/sweet-alert";

export const useUserStore = defineStore('user', () => {
  const user = ref(false);
  const loading = ref(false);

  async function registerUser(user:CreateUser) {
    loading.value = true;
    let sucess = false;
    const {$api} = useNuxtApp();
    await $api.post('/user', user)
    .then(() => sucess = true)
    .finally(() => {
      loading.value = false;
    })
    return sucess;
  }

  return {
    loading,
    registerUser,
    user
  }

});