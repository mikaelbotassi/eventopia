import { defineStore } from 'pinia'
import type GetRegistration from '~/models/registration/GetRegistration';
import type CreateRegistration from '~/models/registration/CreateRegistration';

export const useRegistrationStore = defineStore('registration', () => {
  const loading = ref(false);
  const entities = ref(new Array<GetRegistration>());
  const userRegistrations = ref(new Array<GetRegistration>());
  const qtt = ref(0);
  const filteredEntities = ref(new Array<GetRegistration>());
  const entity = ref(new Object() as GetRegistration);
  const url = '/registration/';

  async function create(obj:CreateRegistration){
    const {confirmPassword} = useUserStore();
    if(!(await confirmPassword())) return false;
    const {$api} = useNuxtApp();
    return await $api.post(url, obj)
    .then((resp) => {
      toastSuccess(resp.data.message);
      return true
    })
    .catch(() => false)
  }

  async function compareOwner(){
    const {me} = useAuthStore();
    const user = await me();
    if(user.id === entity.value?.user?.id) return true;
    return false;
  }
  
  async function getAllByFilters(filters:[]){
    loading.value = true;
    let succcess = false;
    const {$api} = useNuxtApp();
    await $api.post(url + 'filter', filters)
    .then((resp) => {
      entities.value = resp.data.data;
      qtt.value = resp.data.qtt;
      succcess = true
    })
    .finally(() => {
      loading.value = false;
    });
    return succcess
  }
  
  async function getAllByToken(){
    loading.value = true;
    let succcess = false;
    const {$api} = useNuxtApp();
    await $api.get(url + 'auth')
    .then((resp) => {
      userRegistrations.value = resp.data.data;
      qtt.value = resp.data.qtt;
      succcess = true
    })
    .finally(() => {
      loading.value = false;
    });
    return succcess
  }
  
  async function deleteById(id:string|number){
    loading.value = true;
    const {$api} = useNuxtApp();
    return await $api.delete(url + id)
    .then((resp) => {
      toastSuccess(resp.data.message);
      getAllByToken();
      return true
    })
    .catch(() => false)
    .finally(() => loading.value = false)
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

  return {
    loading,
    create,
    entities,
    entity,
    getAllByFilters,
    filteredEntities,
    getById,
    getAllByToken,
    compareOwner,
    deleteById,
    userRegistrations,
    qtt
  }

})
