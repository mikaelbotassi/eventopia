<template>
  <article class="bg-gray-700 text-white relative shadow-lg rounded-xl overflow-hidden">
      <div class="aspect-video">
          <img :src="img ? img : `@/assets/img/empty.jpg`" alt="..." class="w-full h-full object-cover" v-if="img" />
          <img v-else src="@/assets/img/empty.jpg" alt="..." class="w-full h-full object-cover" />
      </div>
      <div class="p-4 pt-2 event-card-body relative rounded-4" style="z-index:1">
        <h5 class="fw-bold mb-3">{{ title }}</h5>
        <div class="flex items-center justify-start gap-2 text-xs text-opacity-75 mb-2">
            <span class="fill-white bg-white/25 px-2 py-1 rounded-lg">
                <icons-pin/>
            </span>
            {{ localization }}
        </div>
        <div class="flex items-center justify-start gap-2 text-xs mb-3">
            <span class="bg-white/25 fill-white px-2 py-1 rounded-lg">
                <icons-schedule/>
            </span>
            {{ event_date }}
        </div>
        <p class="font-bold mb-0">Sobre</p>
        <p class="mb-3">{{ description }}</p>
      </div>
      <NuxtLink class="absolute left-0 bottom-0 top-0 right-0" :to="'/event/' + id" />
  </article>
</template>

<script lang="ts" setup>
  const props = defineProps({
    id: Number,
    title: String,
    event_date: String,
    localization: String,
    description: String,
    img: String
  })

</script>

<style scoped>
.event-card-body::after{
  content:"";
  position:absolute;
  width:100%;
  height:16px;
  background-color:rgb(55 65 81 / 1) !important;
  top:-1rem;
  left:0;
  border-top-left-radius:1.5rem;
  border-top-right-radius:1.5rem;
}
</style>