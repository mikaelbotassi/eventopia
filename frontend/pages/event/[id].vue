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
            <div class="p-4 pt-2 text-center event-card-body relative rounded-4" style="z-index:1">
                <h1 class="font-bold text-3xl mb-10">{{ entity.title }}</h1>
                <div class="flex justify-center items-center gap-3 mb-10">
                    <el-tag v-for="category in entity?.categories" :key="category.id">
                        {{ category.name }}
                    </el-tag>
                </div>
                <div class="flex items-center justify-center flex-wrap gap-5 mb-10">
                    <div class="flex flex-col items-center relative rounded-xl p-3 w-[200px] h-[200px] bg-secondary/50  justify-center fill-white leading-none gap-1 mb-3">
                        <icons-pin class="mb-5 text-xl"/>
                        <small class="text-white">Localização</small>
                        {{ entity.localization }}
                        <a href="{{ entity.urlLocalization }}" target="_blank" class="absolute inset-0"></a>
                    </div>
                    <div class="flex flex-col items-center relative rounded-xl p-3 w-[200px] h-[200px] bg-primary/50 justify-center fill-white leading-none gap-2 mb-2">
                        <icons-schedule class="mb-5 text-xl"/>
                        <small>Data e Hora</small>
                        {{ formater?.dateTimeFormat(entity.event_date) }}
                    </div>
                    <div class="flex flex-col col-span-2 md:col-span-1 items-center relative rounded-xl p-3 w-[200px] h-[200px] bg-red-500 leading-none justify-center fill-white gap-2 mb-2">
                        <icons-calendar-xmark class="mb-5 text-xl"/>
                        <small>Inscrições até</small>
                        {{ formater?.dateTimeFormat(entity.registration_validity) }}
                    </div>
                </div>
                <h2 class="font-bold text-2xl mb-0">Sobre</h2>
                <p class="mb-10">{{ entity.description }}</p>
                <registrations-button-register/>
                <h2 class="font-bold mt-10 text-2xl mb-5">Comentários({{ `${qtt}` }})</h2>
                <feedbacks-comments-panel/>
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

    import Utils from '~/models/formaters/Utils';
    const formater = new Utils();

    const isOwner = ref(false);
    const route = useRoute();
    const router = useRouter();

    const {$swal} = useNuxtApp();

    const eventUpdate = shallowRef(resolveComponent('EventsEventModalForm'));

    const openUpdate = ref(false);

    const eventStore = useEventStore();

    const {getById, compareOwner, deleteById} = eventStore;

    const {getAll} = useFeedbackStore();
    const {qtt} = storeToRefs(useFeedbackStore());

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

    const asyncExecuted = ref(false);

    useAsyncData(
        'owner',
        async () => {
            asyncExecuted.value = true;
            await getById(Number(route.params.id));
            await compareOwner().then((resp) => isOwner.value = resp);
            await getAll();
        }
    );

    onMounted(async () => {
        if(asyncExecuted.value) return true;
        await getById(Number(route.params.id));
        await compareOwner().then((resp) => isOwner.value = resp);
        await getAll();
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