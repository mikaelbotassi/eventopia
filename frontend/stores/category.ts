import { defineStore } from 'pinia'
import type GetCategories from '~/models/category/GetCategories';

export const useCategoryStore = defineStore('category', () => {
  const loading = ref(false);
  const entities = ref(new Array<GetCategories>());
  
  async function getAll(){
    loading.value = true;
    const {$api} = useNuxtApp();
    return await $api.get('/category')
    .then((resp) => {
      entities.value = resp.data.data;
      return true
    })
    .catch(() => false)
    .finally(() => {
      loading.value = false;
    });
  }

  return {
    loading,
    entities,
    getAll,
  }
})
