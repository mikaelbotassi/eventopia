import { defineStore } from "pinia";

export const useGalleryStore = defineStore('gallery', () => {
  const url = '/gallery/';
  const lastUploads = ref(new Array<number>);

  async function uploadImage(formData:FormData){
    const {$api} = useNuxtApp();
    return await $api.post(url, formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      }
    })
  }
  
  async function deleteImage(id:number){
    const {$api} = useNuxtApp();
    return await $api.delete(url + id)
    .then(() => true)
    .catch(() => false)
  }

  return {
    uploadImage,
    lastUploads,
    deleteImage
  }

});