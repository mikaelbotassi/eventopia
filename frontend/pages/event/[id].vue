<template>
    <div>
        <article class="bg-gray-700 text-white relative shadow-lg rounded-xl overflow-hidden">
            <div class="aspect-video">
                <img src="https://cdn.wallpapersafari.com/41/36/EwIcFb.jpg" alt="..." class="object-fit-cover" />
            </div>
            <div class="p-4 pt-2 event-card-body relative rounded-4" style="z-index:1">
                <h1 class="font-bold text-xl mb-3">{{ entity.title }}</h1>
                <div class="flex items-center justify-start gap-2 text-opacity-75 mb-2">
                    <span class="fill-white bg-white/25 px-2 py-1 rounded-lg">
                        <icons-pin/>
                    </span>
                    {{ entity.localization }}
                </div>
                <div class="flex items-center justify-start gap-2 mb-3">
                    <span class="bg-white/25 fill-white px-2 py-1 rounded-lg">
                        <icons-schedule/>
                    </span>
                    {{ entity.event_date }}
                </div>
                <p class="font-bold mb-0">Sobre</p>
                <p class="mb-3">{{ entity.description }}</p>
            </div>
        </article>
    </div>
</template>
<script setup lang="ts">
    definePageMeta({
        layout:'side-nav',
        middleware:'auth'
    })
    const route = useRoute();
    const {getById} = useEventStore();
    const {entity} = storeToRefs(useEventStore());
    onMounted(() => {
        getById(route.params.id)
    });
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