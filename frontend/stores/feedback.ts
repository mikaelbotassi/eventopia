import { defineStore } from 'pinia'
import type Getfeedbacks from '~/models/feedback/GetFeedbacks';
import type CreateFeedback from '~/models/feedback/CreateFeedback';
import type UpdateFeedback from '~/models/feedback/UpdateFeedback';

export const useFeedbackStore = defineStore('feedback', () => {
  const loading = ref(false);
  const entities = ref(new Array<Getfeedbacks>());
  const qtt = ref(0);
  const filteredEntities = ref(new Array<Getfeedbacks>());
  const entity = ref(new Object() as Getfeedbacks);
  const url = '/feedback/';

  async function create(obj:CreateFeedback){
    loading.value = true;
    const {$api} = useNuxtApp();
    return await $api.post(url, obj)
    .then((resp) => {
      getAll();
      return true
    })
    .catch(() => false)
    .finally(() => {
      loading.value = false;
    });
  }

  async function update(obj:UpdateFeedback, id:string|number){
    const {$api} = useNuxtApp();
    return await $api.put(url + id, obj)
    .then((resp) => true)
    .catch(() => false)
  }

  async function compareOwner(){
    const {me} = useAuthStore();
    const user = await me();
    if(user.id === entity.value?.author?.id) return true;
    return false;
  }
  
  async function getAll(){
    loading.value = true;
    let succcess = false;
    const {$api} = useNuxtApp();
    await $api.post(url + 'filter', [{
      column:'event_id',
      operator:'=',
      value:Number(useRoute().params.id)
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

  async function getAllByFilter(filter:[]){
    loading.value = true;
    const {$api} = useNuxtApp();
    return await $api.post('/feedback/filter', filter)
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
    const {$api} = useNuxtApp();
    return await $api.delete(url + id)
    .then((resp) => {
      return true
    })
    .catch(() => false)
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
    getAll,
    getAllByFilter,
    filteredEntities,
    getById,
    compareOwner,
    update,
    deleteById,
    qtt
  }

})
