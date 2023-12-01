<template>
  <section class="bg-gray-800 w-full rounded-xl">
    <h1 class="text-white fw-bold text-center text-3xl font-bold my-5">Meus Certificados</h1>
    <template v-if="!loading">
      <div class="container flex flex-wrap" v-if="entities.length > 0">
        <article class="w-full md:w-1/2 lg:w-1/3 p-3" v-for="entity in entities" :key="entity.id">
          <certificates-certificate-card
          :eventId="entity.registration?.event_id"
          :title="entity.registration?.event?.title"
          :owner="entity.registration?.event?.owner_obj?.name"
          :eventDate="entity.registration?.event?.event_date"
          />
        </article>
      </div>
      <shared-empty-records v-else/>
    </template>
    <div class="flex items-center justify-center p-5" v-else>
        <LoadersCubeLoader />
    </div>
  </section>
</template>

<script lang="ts" setup>

  definePageMeta({
      layout:'side-nav',
      middleware:'auth'
  })

  const {getAll} = useCertificateStore();
  const {entities,loading} = storeToRefs(useCertificateStore());

  const isAsync = ref(false);

  useAsyncData(
    'getCertificates',
    async () => {
      isAsync.value = true;
      return await getAll()
    }
  )

  onMounted(async () => {
    if(isAsync.value){
      isAsync.value = false;
      return true;
    }
    return await getAll()
  });

</script>

<style>

</style>