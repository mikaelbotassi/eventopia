<template>
    <div class="w-full bg-primary p-3 rounded-xl">
        <div class="grid grid-cols-2 gap-4" v-if="!loading">
            <events-event-card
            v-for="entity in entities" :key="entity.id"
            :id="entity.id"
            :title="entity.title"
            :event_date="entity.event_date"
            :localization="entity.localization"
            :description="entity.localization"
            />
        </div>
        <div class="flex items-center justify-center p-5" v-else>
            <LoadersCubeLoader />
        </div>
    </div>
</template>

<script setup lang="ts">
    definePageMeta({
        layout:'side-nav',
        path:'/',
        middleware:'auth'
    })

    const {getAll} = useEventStore();
    const {entities,loading} = storeToRefs(useEventStore());

    onMounted(getAll)


</script>

<style>
</style>