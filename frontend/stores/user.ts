import axios from "axios";
import { defineStore } from "pinia";
import { useRouter } from "vue-router";
import type { CreateUser } from "~/models/user/User";
import { toastError } from "~/utils/sweet-alert";

export const useUserStore = defineStore('user', () => {
  const user = ref(false);
  const loading = ref(false);

  async function registerUser(user:CreateUser) {
    loading.value = true;
    const {$api} = useNuxtApp();
    await $api.post('/user', user).then(
      (resp) => {
        toastSuccess(resp.data.message)
      }
    )
    .catch((err) => {
      toastError(err.response.data.error)
    })
    .finally(() => {
      loading.value = false;
    })
  }

  return {
    loading,
    registerUser,
  }

});