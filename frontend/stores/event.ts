import { defineStore } from 'pinia'
import { type ListEvent, type CreateEvent, type OneEvent, type UpdateEvent } from '~/models/event/Event';

export const useEventStore = defineStore('event', () => {
  const loading = ref(false);
  const entities = ref(new Array<ListEvent>());
  const filteredEntities = ref(new Array<ListEvent>());
  const entity = ref(new Object() as OneEvent);

  async function create(obj:CreateEvent){
    loading.value = true;
    const {$api} = useNuxtApp();
    return await $api.post('/event', obj)
    .then((resp) => {
      toastSuccess(resp.data.message);
      getAll();
      return true
    })
    .catch(() => false)
    .finally(() => {
      loading.value = false;
    });
  }

  async function update(obj:UpdateEvent, id:string|number){
    loading.value = true;
    const {$api} = useNuxtApp();
    return await $api.put('/event/' + id, obj)
    .then((resp) => {
      toastSuccess(resp.data.message);
      getById(id);
      return true;
    })
    .catch(() => false)
    .finally(() => {
      loading.value = false;
    });
  }

  async function compareOwner(){
    const {me} = useAuthStore();
    const user = await me();
    if(user.id === entity.value?.ownerObj?.id) return true;
    return false;
  }
  
  async function getAll(){
    loading.value = true;
    let succcess = false;
    const {$api} = useNuxtApp();
    await $api.get('/event')
    .then((resp) => {
      entities.value = resp.data.data;
      succcess = true
    })
    .finally(() => {
      loading.value = false;
    });
    return succcess
  }

  async function getAllByFilter(filter:[]){
    loading.value = true;
    const {$api} = useNuxtApp();
    return await $api.post('/event/filter', filter)
    .then((resp) => {
      filteredEntities.value = resp.data.data;
      return true
    })
    .catch(() => false)
    .finally(() => {
      loading.value = false;
    });
  }
  
  async function deleteById(id:string|number){
    loading.value = true;
    const {$api} = useNuxtApp();
    return await $api.delete('/event/' + id)
    .then((resp) => {
      toastSuccess(resp.data.message);
      return true
    })
    .catch(() => false)
    .finally(() => {
      loading.value = false;
    });
  }

  async function getById(id:string|number){
    loading.value = true;
    const {$api} = useNuxtApp();
    return await $api.get('/event/' + id)
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
    getAll,
    getAllByFilter,
    filteredEntities,
    getById,
    compareOwner,
    update,
    deleteById
  }

})
