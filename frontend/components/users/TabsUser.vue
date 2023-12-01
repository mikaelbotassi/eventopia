<template>
    <template v-if="!loading">
        <el-tabs type="border-card">
            <el-tab-pane label="Meus Eventos">
                <div class="grid grid-cols-2 gap-4" v-if="filteredEntities.length > 0">
                    <events-event-card
                    v-for="(entity,i) in filteredEntities" :key="i"
                    :id="entity.id"
                    :title="entity.title"
                    :event_date="entity.event_date"
                    :localization="entity.localization"
                    :description="entity.localization"
                    />
                </div>
                <shared-empty-records v-else/>
            </el-tab-pane>
            <el-tab-pane label="Minhas Inscrições" v-if="showSubscriptions">
                <registrations-registration-list :typeEvent="false"/>
            </el-tab-pane>
        </el-tabs>
    </template>
    <div class="flex items-center justify-center p-10" v-else>
        <LoadersCubeLoader />
    </div>
</template>

<script setup lang="ts">
    const props = defineProps({
        userId: Number,
        showSubscriptions:{
            type:Boolean,
            default:false
        },
    })

    const eventStore = useEventStore();
    const { filteredEntities, loading } = storeToRefs(eventStore);
    const { getAllByFilter } = eventStore;
    const { getAllByToken } = useRegistrationStore();

    const isAsync = ref(false);

    useAsyncData('userEvents', async () => {
        isAsync.value = true;
        await getAllByFilter([
            {
                column:"owner",
                operator:"=",
                value:props.userId
            }
        ]);
    });

    onMounted(() => {
        if(isAsync.value) return true;
        getAllByFilter([
            {
                column:"owner",
                operator:"=",
                value:props.userId
            }
        ]);
    });

</script>