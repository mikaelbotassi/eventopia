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
    const {$api} = useNuxtApp();
    const {confirmPassword} = useUserStore();
    if(!(await confirmPassword())) return false;
    return await $api.post(url, obj)
    .then((resp) => {
      getAllEventRegistrationByUrl();
      getAllByToken();
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
  
  async function getAllEventRegistrationByUrl(){
    const route = useRoute();
    if(route.name !== 'event-id') return false;
    loading.value = true;
    let succcess = false;
    const {$api} = useNuxtApp();
    await $api.post(url + 'filter', [{
      column:'event_id',
      operator:"=",
      value:Number(route.params.id)
    }])
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
    const {confirmPassword} = useUserStore();
    if(!(await confirmPassword())) return false;
    loading.value = true;
    const {$api} = useNuxtApp();
    return await $api.delete(url + id)
    .then((resp) => {
      toastSuccess(resp.data.message);
      getAllEventRegistrationByUrl();
      getAllByToken();
      return true
    })
    .catch(() => false)
    .finally(() => loading.value = false)
  }

  return {
    loading,
    create,
    entities,
    entity,
    getAllByFilters,
    filteredEntities,
    getAllByToken,
    compareOwner,
    deleteById,
    userRegistrations,
    getAllEventRegistrationByUrl,
    qtt
  }

})
