<template>
    <template v-if="!loading">
        <article class="bg-white w-full text-dark relative shadow-lg rounded-xl overflow-hidden">
            <header class="bg-secondary p-10 flex gap-10">
                <div class="aspect-square overflow-hidden flex items-center justify-center w-[150px] h-[150px] rounded-full">
                    <img src="https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="w-full object-cover " alt="profile picture" />
                </div>
                <div class="flex flex-col justify-center">
                    <h1 class="text-3xl font-bold uppercase mb-3">{{ entity?.name }}</h1>
                    <h2 class="mb-0">{{ entity?.email }}</h2>
                    <h3 class="mb-0">{{ entity?.cpf_cnpj }}</h3>
                    <h3 class="mb-5">{{ entity?.birth }}</h3>
                    <el-dropdown trigger="click">
                        <button class="el-dropdown-link bg-dark border-2 text-white border-white px-3 py-2 rounded-full">
                            Configurações
                        </button>
                        <template #dropdown>
                        <el-dropdown-menu>
                            <el-dropdown-item @click.prevent="openUpdate=true" class="fill-white flex items-center gap-3">
                                <icons-pencil />
                                Editar
                            </el-dropdown-item>
                            <el-dropdown-item @click.prevent="deleteEntity()" class="fill-white flex items-center gap-3">
                                <icons-trash />
                                Deletar
                            </el-dropdown-item>
                        </el-dropdown-menu>
                        </template>
                    </el-dropdown>
                </div>
            </header>
            <users-tabs-user v-if="entity.id" :userId="entity.id" />
        </article>
    </template>
    <div class="flex items-center justify-center p-5" v-else>
        <LoadersCubeLoader />
    </div>
    <!-- <component :entityId="entity.id" :is="openUpdate ? eventUpdate : 'div'" @save="openUpdate = false" @close="openUpdate = false" /> -->
    
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

    const userStore = useUserStore();

    const {compareOwner, getByToken, deleteByToken} = userStore;

    const {entity, loading} = storeToRefs(userStore);

    const deleteEntity = () => {
        $swal.fire({
            title: "Deseja realmente deletar o evento?",
            showCancelButton: true,
            confirmButtonText: "Sim, deletar",
            confirmButtonColor: "#10d38d",
            denyButtonText: `Cancelar`
        }).then(async (result) => {
            if (result.isConfirmed) {
                if(await deleteByToken()) router.push('/logout');
            }
        });
    }

    isOwner.value = await useAsyncData(
        'owner',
        async () => await compareOwner()
    );

    onMounted(() => {
        getByToken();
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