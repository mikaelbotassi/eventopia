import { defineStore } from 'pinia'
import type { CreateEvent } from '~/models/event/Event';

export const useEventStore = defineStore('event', () => {
  const loading = ref(false);

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

  return {
    loading,
    create
  }

})
