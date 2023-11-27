import { defineStore } from 'pinia'
import { type ListEvent, type CreateEvent, type OneEvent } from '~/models/event/Event';

export const useEventStore = defineStore('event', () => {
  const loading = ref(false);
  const entities = ref(new Array<ListEvent>());
  const entity = ref(new Object() as OneEvent);

  async function create(obj:CreateEvent){
    loading.value = true;
    let succcess = false;
    const {$api} = useNuxtApp();
    await $api.post('/event', obj)
    .then((resp) => succcess = true)
    .finally(() => {
      loading.value = false;
    });
    return succcess
  }

  async function compareOwner(){
    const {me} = useAuthStore();
    const user = await me();
    if(user.id === entity.value.id) return true;
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

  async function getById(id:string|number){
    loading.value = true;
    let succcess = false;
    const {$api} = useNuxtApp();
    await $api.get('/event/' + id)
    .then((resp) => {
      entity.value = resp.data.data;
      succcess = true
    })
    .finally(() => {
      loading.value = false;
    });
    return succcess
  }

  return {
    loading,
    create,
    entities,
    entity,
    getAll,
    getById,
    compareOwner
  }

})
