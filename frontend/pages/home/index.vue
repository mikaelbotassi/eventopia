<template>
    <div class="w-full bg-primary p-3 rounded-xl">
        <template v-if="!loading">
            <div class="grid grid-cols-2 gap-4" v-if="entities.length > 0">
                <events-event-card
                v-for="(entity,i) in entities" :key="i"
                :id="entity.id"
                :title="entity.title"
                :event_date="entity.event_date"
                :localization="entity.localization"
                :description="entity.localization"
                />
            </div>
            <div class="bg-secondary/25 border p-3 rounded-lg border-secondary text-secondary" :closable="false" v-else >
                <h2 class="text-2xl font-bold">Ops...</h2>
                <p>Nenhum evento cadastrado até o momento, tente novamente mais tarde</p>
            </div>
        </template>
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