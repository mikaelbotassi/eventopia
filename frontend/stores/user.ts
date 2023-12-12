import { defineStore } from "pinia";
import type { CreateUser, UpdateUser } from "~/models/user/User";
import { type OwnerUser } from '~/models/user/User';

export const useUserStore = defineStore('user', () => {
  const user = ref(false);
  const loading = ref(false);
  const entity = ref(new Object() as OwnerUser);
  const url = "/user/";

  async function registerUser(user:CreateUser) {
    loading.value = true;
    const {$api} = useNuxtApp();
    return await $api.post(url, user)
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
    if(!(await confirmPassword())) return false;
    loading.value = true;
    const {$api} = useNuxtApp();
    return await $api.put(url, user)
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

  async function confirmPassword(){
    const {$swal} :any = useNuxtApp();
    const {validatePassword} = useAuthStore();
    return $swal.fire({
      title: "Confirme sua senha",
      icon:"warning",
      text: "Para realizar esta operação é necessário confirmar sua senha!",
      input: "password",
      showCancelButton: true,
      confirmButtonText: "Confirmar",
      confirmButtonColor: "var(--secondary)",
      cancelButtonText: "Cancelar",
      cancelButtonColor: "#bb2124",
      showLoaderOnConfirm: true,
      preConfirm: async (password:string) => {
          return await validatePassword(password);
      },
      allowOutsideClick: () => !$swal.isLoading()
    }).then((result:any) => {
      if (result.isConfirmed) return true;
      return false;
    });
  }

  async function getByToken(){
    const {me} = useAuthStore();
    loading.value = true;
    entity.value = await me().finally(() => loading.value = false);
  }
  
  async function getById(id:string|number){
    loading.value = true;
    const {$api} = useNuxtApp();
    return await $api.get(url + id)
    .then((resp) => {
      entity.value = resp.data.data;
      return true
    })
    .catch(() => false)
    .finally(() => {
      loading.value = false;
    });
  }

  async function compareOwner(){
    loading.value = true;
    const {me} = useAuthStore();
    const user = await me().finally(() => loading.value = false);
    if(user.id === entity.value?.id) return true;
    return false;
  }

  async function deleteByToken(){
    if(!(await confirmPassword())) return false;
    loading.value = true;
    const {$api} = useNuxtApp();
    return await $api.delete(url)
    .then((resp) => {
      toastSuccess(resp.data.message);
      return true
    })
    .catch(() => false)
  }

  async function me(){
    const {$api} = useNuxtApp();
    const resp:any = await $api.get(`${url}me`);
    return resp.data.data as OwnerUser
  }

  return {
    loading,
    registerUser,
    user,
    getByToken,
    getById,
    entity,
    compareOwner,
    deleteByToken,
    update,
    confirmPassword,
    me
  }

});