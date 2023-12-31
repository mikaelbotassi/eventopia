<template>
    <template v-if="!loading">
        <article class="bg-white w-full text-dark relative shadow-lg rounded-xl overflow-hidden">
            <header class="bg-secondary p-10 flex gap-10">
                <div class="aspect-square overflow-hidden flex items-center justify-center w-[150px] h-[150px] rounded-full">
                    <img v-if="entity.img" :src="`${baseApiUrl}/gallery/${entity.img?.path}/${entity.img?.filename}`" class="w-full object-cover " alt="profile picture" />
                    <div class="bg-white w-full h-full flex items-end justify-center" v-else>
                        <icons-user class="w-3/4 h-3/4"/>
                    </div>
                </div>
                <div class="flex flex-col justify-center">
                    <h1 class="text-3xl font-bold uppercase mb-3">{{ entity?.name }}</h1>
                    <h2 class="mb-0">{{ entity?.email }}</h2>
                    <h3 class="mb-0">{{ formater?.getMaskedDoc(entity?.cpf_cnpj) }}</h3>
                    <h3 class="mb-5">{{ formater?.dateFormat(entity?.birth) }}</h3>
                    <el-dropdown trigger="click">
                        <button class="el-dropdown-link bg-dark border-2 text-white border-white px-3 py-2 rounded-full">
                            Configurações
                        </button>
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
            </header>
            <users-tabs-user v-if="entity.id" :showSubscriptions="true" :userId="entity.id" />
        </article>
    </template>
    <div class="flex items-center justify-center p-5" v-else>
        <LoadersCubeLoader />
    </div>
    <component :is="openUpdate ? userUpdate : 'div'" @imageRemoved="entity.img = null" @save="openUpdate = false" @close="openUpdate = false" />
    
</template>
<script setup lang="ts">
    definePageMeta({
        layout:'side-nav',
        middleware:'auth'
    })

    import Utils from '~/models/formaters/Utils';

    const router = useRouter();

    const formater = new Utils();

    const baseApiUrl = useRuntimeConfig().public.baseApiUrl;

    const {$swal} = useNuxtApp();

    const userUpdate = shallowRef(resolveComponent('UsersUserModal'));

    const openUpdate = ref(false);

    const userStore = useUserStore();

    const {compareOwner, getByToken, deleteByToken} = userStore;

    const {entity, loading} = storeToRefs(userStore);

    const deleteEntity = () => {
        $swal.fire({
            title: "Deseja realmente excluir sua conta?",
            showCancelButton: true,
            confirmButtonText: "Sim, excluir",
            confirmButtonColor: "#10d38d",
            denyButtonText: `Cancelar`
        }).then(async (result:any) => {
            if (result.isConfirmed) {
                if(await deleteByToken()) router.push('/logout');
            }
        });
    }

    const asyncExecuted = ref(false);

    useAsyncData(
        'owner',
        async () => {
            asyncExecuted.value = true;
            
            await getByToken();
        }
    );

    onMounted(() => {
        if(asyncExecuted.value) return true;
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