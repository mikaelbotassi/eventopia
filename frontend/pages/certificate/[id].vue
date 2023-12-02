<template>
  <div class="flex items-center justify-center mb-5">
      <el-button @click="printDoc('certificate')" color="var(--secondary)" class="text-dark" plain size="large" :icon="ElIconPrinter">Imprimir</el-button>
  </div>
  <div id="certificate">
    <section class="bg-dark w-full overflow-hidden p-5 relative">
      <div v-if="!loading">
        <div class="container bg-white text-dark p-10 flex flex-col items-center">
          <h1 class="text-secondary font-bold text-5xl mb-20">CERTIFICADO</h1>
          <h2 class="text-xl mb-20">De participação de evento</h2>
    
          <div class="text-sm text-center mb-20">
            Certificamos que o Sr(a). {{ entity.registration?.user?.name }}, participou do(a) "{{ entity.registration?.event?.title }}", organizado por "{{ entity.registration?.event?.owner_obj?.name }}" e se concretizou no dia {{ formater.dateFriendlyFormat(entity.registration?.event?.event_date) }}.
          </div>
    
          <div class="text-sm text-center mb-20">
            <h5 class="text-lg mb-10">O mencionado evento se encaixa nas seguintes categorias e/ou trata dos seguintes assuntos:</h5>
            <p>
              <span v-for="(category, index) in entity.registration?.event?.categories" :key="category?.id">{{ (index == 0 ? category?.name : ', ' + category?.name) }}</span>
            </p>
          </div>
    
          <h2 class="text-sm mb-5"><strong>Código de autenticação: </strong>{{ entity.code }}</h2>
          <h3 class="text-xs">Consulte a autenticidade do código no link: <span class="underline">{{ baseFrontUrl + '/certificate/search' }}</span></h3>
    
        </div>
      </div>
      <div class="flex items-center justify-center p-5" v-else>
          <LoadersCubeLoader />
      </div>
      <div class="absolute top-[-30px] shadow-2xl overflow-hidden right-[-30px] p-3 rounded-circle bg-dark w-[75px] h-[75px] sm:w-[100px] sm:h-[100px] md:w-[150px] md:h-[150px]">
        <div class="bg-white rounded-circle w-full h-full flex items-center justify-center">
          <img src="~/assets/img/brand.png" class="w-2/3" />
        </div>
      </div>
    </section>
  </div>
</template>
<script setup lang="ts">
  definePageMeta({
      layout:'side-nav',
      middleware:'auth'
  })

  import Utils from '~/models/formaters/Utils';
  const formater = new Utils();

  const baseFrontUrl = useRuntimeConfig().public.baseFrontUrl;

  const route = useRoute();

  const {$swal} = useNuxtApp();

  const {getById} = useCertificateStore();

  const {entity, loading} = storeToRefs(useCertificateStore());

  const asyncExecuted = ref(false);

  useAsyncData(
      'getCertificate',
      async () => {
          asyncExecuted.value = true;
          await getById(Number(route.params.id));
      }
  );

  onMounted(async () => {
      if(asyncExecuted.value){
        asyncExecuted.value = false;
        return true
      };
      await getById(Number(route.params.id));
  })

</script>
<style>
* {
    -webkit-print-color-adjust: exact !important;   /* Chrome, Safari 6 – 15.3, Edge */
    color-adjust: exact !important;                 /* Firefox 48 – 96 */
    print-color-adjust: exact !important;           /* Firefox 97+, Safari 15.4+ */
  }
  @media print{
      body{
          font-size:12px !important;
      }

      .no-printable{ display:none !important }
  }
</style>