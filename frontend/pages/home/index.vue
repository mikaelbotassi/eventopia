<template>
    <div class="w-full bg-primary p-3 rounded-xl">
        <template v-if="!loading">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4" v-if="entities.length > 0">
                <events-event-card
                v-for="(entity,i) in entities" :key="i"
                :id="entity.id"
                :img="entity.gallery.length > 0 ? `${baseApiUrl}/gallery/${entity.gallery[0]?.path}/${entity.gallery[0]?.filename}` : null"
                :title="entity.title"
                :event_date="formater?.dateTimeFormat(entity.event_date)"
                :localization="entity.localization"
                :description="entity.localization"
                />
            </div>
            <shared-empty-records v-else/>
        </template>
        <div class="flex items-center justify-center p-5" v-else>
            <LoadersCubeLoader />
        </div>
    </div>
</template>

<script setup lang="ts">
    definePageMeta({
        layout:'side-nav',
        path:'/'
    })

    import Utils from '~/models/formaters/Utils';
    const formater = new Utils();

    const baseApiUrl = useRuntimeConfig().public.baseApiUrl;

    const {getAll} = useEventStore();
    const {entities,loading} = storeToRefs(useEventStore());

    const asyncExecuted = ref(false);

    useAsyncData('getAll', async () => {
        asyncExecuted.value = true;
        await getAll()
    })

    onMounted(async () => {
        if(asyncExecuted.value) return true;
        await getAll();
    })

</script>

<style>
</style>