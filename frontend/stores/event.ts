import { defineStore } from 'pinia'
import { ListEvent, type CreateEvent } from '~/models/event/Event';

export const useEventStore = defineStore('event', () => {
  const loading = ref(false);
  const events = ref(new Array<ListEvent>());

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
  
  async function getAll(){
    loading.value = true;
    let succcess = false;
    const {$api} = useNuxtApp();
    await $api.get('/event')
    .then((resp) => {
      events.value = resp.data.data;
      succcess = true
    })
    .finally(() => {
      loading.value = false;
    });
    return succcess
  }

  return {
    loading,
    create
  }

})
