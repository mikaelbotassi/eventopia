<template>
    <div v-if="!loading">
        <article class="bg-gray-700 pb-10 text-white relative shadow-lg rounded-xl overflow-hidden">
            <div class="aspect-video relative">
                <img src="https://cdn.wallpapersafari.com/41/36/EwIcFb.jpg" alt="..." class="object-fit-cover" />
                <el-dropdown v-show="isOwner" class="absolute top-10 right-10" trigger="click">
                    <span class="el-dropdown-link bg-gray-700 px-4 py-2 rounded-full">
                        <icons-ellipsis-vertical class="fill-white text-xl"/>
                    </span>
                    <template #dropdown>
                        <el-dropdown-menu>
                            <el-dropdown-item @click="openUpdate=true" class="fill-white flex items-center gap-3">
                                <icons-pencil />
                                Editar
                            </el-dropdown-item>
                            <el-dropdown-item @click="deleteEntity()" class="fill-white flex items-center gap-3">
                                <icons-trash />
                                Deletar
                            </el-dropdown-item>
                        </el-dropdown-menu>
                    </template>
                </el-dropdown>
            </div>
            <div class="p-4 pt-2 event-card-body relative rounded-4" style="z-index:1">
                <h1 class="font-bold text-3xl mb-10">{{ entity.title }}</h1>
                <div class="flex items-center justify-start gap-2 mb-2 text-opacity-75">
                    <span class="fill-white bg-white/25 px-2 py-1 rounded-lg">
                        <icons-pin/>
                    </span>
                    {{ entity.localization }}
                </div>
                <div class="flex items-center justify-start gap-2 mb-10">
                    <span class="bg-white/25 fill-white px-2 py-1 rounded-lg">
                        <icons-schedule/>
                    </span>
                    {{ entity.event_date }}
                </div>
                <p class="font-bold mb-0">Sobre</p>
                <p class="mb-3">{{ entity.description }}</p>
                <h2 class="font-bold mt-10 text-2xl">Comentários</h2>
            </div>
        </article>
    </div>
    <div class="flex items-center justify-center p-5" v-else>
        <LoadersCubeLoader />
    </div>
    <component :entityId="entity.id" :is="openUpdate ? eventUpdate : 'div'" @save="openUpdate = false" @close="openUpdate = false" />
    
</template>
<script setup lang="ts">
    definePageMeta({
        layout:'side-nav',
        middleware:'auth'
    })
    const isOwner = ref(false);
    const route = useRoute();
    const router = useRouter();

    const {$swal} = useNuxtApp();

    const eventUpdate = shallowRef(resolveComponent('EventsEventModalForm'));

    const openUpdate = ref(false);

    const eventStore = useEventStore();

    const {getById, compareOwner, deleteById} = eventStore;

    const {entity, loading} = storeToRefs(eventStore);

    const deleteEntity = () => {
        $swal.fire({
            title: "Deseja realmente deletar o evento?",
            showCancelButton: true,
            confirmButtonText: "Sim, deletar",
            confirmButtonColor: "#10d38d",
            denyButtonText: `Cancelar`
        }).then(async (result:any) => {
            if (result.isConfirmed) {
                if(await deleteById(Number(route.params.id))) router.push('/');
            }
        });
    }

    useAsyncData(
        'owner',
        async () => {
            await getById(Number(route.params.id));
            await compareOwner().then((resp) => isOwner.value = resp)
        }
    );
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