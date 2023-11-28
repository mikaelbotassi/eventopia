import { defineStore } from "pinia";
import type { CreateUser } from "~/models/user/User";
import { type OwnerUser } from '~/models/user/User';

export const useUserStore = defineStore('user', () => {
  const user = ref(false);
  const loading = ref(false);
  const entity = ref(new Object() as OwnerUser);

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

  async function getByToken(){
    const {me} = useAuthStore();
    loading.value = true;
    entity.value = await me().finally(() => loading.value = false);
    console.log("🚀 ~ file: user.ts:26 ~ getByToken ~ entity.value:", entity.value)
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
    .then(() => true)
    .catch(() => false)
    .finally(() => {
      loading.value = false;
    });
  }

  return {
    loading,
    registerUser,
    user,
    getByToken,
    entity,
    compareOwner,
    deleteByToken
  }

});