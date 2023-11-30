<template>
    <div class="w-full bg-primary p-3 rounded-xl">
        <template v-if="!loading">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4" v-if="entities.length > 0">
                <events-event-card
                v-for="(entity,i) in entities" :key="i"
                :id="entity.id"
                :title="entity.title"
                :event_date="formater?.dateTimeFormat(entity.event_date)"
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
        path:'/'
    })

    import Utils from '~/models/formaters/Utils';
    const formater = new Utils();

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