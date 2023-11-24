import { defineStore } from "pinia";
import type { CreateUser } from "~/models/user/User";
import { toastError } from "~/utils/sweet-alert";

export const useUserStore = defineStore('user', () => {
  const user = ref(false);
  const loading = ref(false);

  async function registerUser(user:CreateUser) {
    loading.value = true;
    const {$api} = useNuxtApp();
    await $api.post('/user', user)
    .finally(() => {
      loading.value = false;
    })
  }

  return {
    loading,
    registerUser,
    user
  }

});