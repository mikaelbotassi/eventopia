import { defineStore } from 'pinia'
import type GetCertificate from '~/models/certificate/GetCertificate';

export const useCertificateStore = defineStore('certificate', () => {
  const loading = ref(false);
  const entities = ref(new Array<GetCertificate>());
  const qtt = ref(0);
  const filteredEntities = ref(new Array<GetCertificate>());
  const entity = ref(new Object() as GetCertificate);
  const url = '/certificate/';
  
  async function getAll(){
    loading.value = true;
    const {$api} = useNuxtApp();
    return await $api.get(url + 'auth')
    .then((resp) => {
      entities.value = resp.data.data;
      qtt.value = resp.data.qtt;
      return true
    })
    .catch(() => false)
    .finally(() => {
      loading.value = false;
    });
  }

  async function getAllByFilter(filter:[]){
    loading.value = true;
    const {$api} = useNuxtApp();
    return await $api.post(`${url}filter`, filter)
    .then((resp) => {
      filteredEntities.value = resp.data.data;
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

  async function getByCode(code:string|number){
    loading.value = true;
    const {$api} = useNuxtApp();
    return await $api.get(url + 'code/' + code)
    .then((resp) => {
      entity.value = resp.data.data;
      return true
    })
    .catch(() => false)
    .finally(() => {
      loading.value = false;
    });
  }

  async function searchCertificate(){
    const {$swal} :any = useNuxtApp();
    const router = useRouter();
    return $swal.fire({
      title: "Digite o código do certificado",
      icon:"warning",
      text: "Digite o código presente na parte inferior do certificado",
      input: "text",
      showCancelButton: true,
      confirmButtonText: "Confirmar",
      confirmButtonColor: "var(--secondary)",
      cancelButtonText: "Cancelar",
      cancelButtonColor: "#bb2124",
      showLoaderOnConfirm: true,
      preConfirm: async (code:string) => {
          await getByCode(code).then(() => {
            router.push('/certificate/' + entity.value.id);
          })
      },
      allowOutsideClick: () => !$swal.isLoading()
    }).then((result:any) => {
      if (result.isConfirmed) return true;
      router.push('/')
      return false;
    });
  }



  return {
    loading,
    entities,
    entity,
    getAll,
    getAllByFilter,
    filteredEntities,
    searchCertificate,
    getById,
    qtt
  }

})
