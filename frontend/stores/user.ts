import { defineStore } from "pinia";
import type { CreateUser, UpdateUser } from "~/models/user/User";
import { type OwnerUser } from '~/models/user/User';

export const useUserStore = defineStore('user', () => {
  const user = ref(false);
  const loading = ref(false);
  const entity = ref(new Object() as OwnerUser);

  async function registerUser(user:CreateUser) {
    loading.value = true;
    const {$api} = useNuxtApp();
    return await $api.post('/user', user)
    .then((resp) => {
      toastSuccess(resp.data.message);
      return true
    })
    .catch(() => false)
    .finally(() => {
      loading.value = false;
    })
  }
  
  async function update(user:UpdateUser) {
    loading.value = true;
    const {$api} = useNuxtApp();
    return await $api.put('/user', user)
    .then((resp) => {
      toastSuccess(resp.data.message);
      return true
    })
    .catch(() => false)
    .finally(async () => {
      const {me} = useAuthStore();
      entity.value = await me();
      loading.value = false;
    })
  }

  async function getByToken(){
    const {me} = useAuthStore();
    loading.value = true;
    entity.value = await me().finally(() => loading.value = false);
  }

  async function compareOwner(){
    loading.value = true;
    const {me} = useAuthStore();
    const user = await me().finally(() => loading.value = false);
    if(user.id === entity.value?.id) return true;
    return false;
  }

  async function deleteByToken(){
    loading.value = true;
    const {$api} = useNuxtApp();
    return await $api.delete('/user')
    .then((resp) => {
      toastSuccess(resp.data.message);
      return true
    })
    .catch(() => false)
  }

  return {
    loading,
    registerUser,
    user,
    getByToken,
    entity,
    compareOwner,
    deleteByToken,
    update
  }

});