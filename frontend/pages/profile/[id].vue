<template>
    <template v-if="!loading">
        <article class="bg-white w-full text-dark relative shadow-lg rounded-xl overflow-hidden">
            <header class="bg-secondary p-10 flex gap-10">
                <div class="aspect-square overflow-hidden flex items-center justify-center w-[150px] h-[150px] rounded-full">
                    <img v-if="entity.img" :src="`${baseApiUrl}/gallery/${entity.img?.path}/${entity.img?.filename}`" class="w-full object-cover " alt="profile picture" />
                </div>
                <div class="flex flex-col justify-center">
                    <h1 class="text-3xl font-bold uppercase mb-3">{{ entity?.name }}</h1>
                    <h2 class="mb-0">{{ entity?.email }}</h2>
                    <h3 class="mb-0">{{ formater?.getMaskedDoc(entity?.cpf_cnpj) }}</h3>
                    <h3 class="mb-5">{{ formater?.dateFormat(entity?.birth) }}</h3>
                </div>
            </header>
            <users-tabs-user v-if="entity.id" :userId="entity.id" />
        </article>
    </template>
    <div class="flex items-center justify-center p-5" v-else>
        <LoadersCubeLoader />
    </div>
    
</template>
<script setup lang="ts">
    definePageMeta({
        layout:'side-nav',
        middleware:'auth'
    })

    import Utils from '~/models/formaters/Utils';
    const formater = new Utils();

    const route = useRoute();
    const router = useRouter();

    const {$swal} = useNuxtApp();

    const {getById, compareOwner, deleteById} = useUserStore();

    const baseApiUrl = useRuntimeConfig().public.baseApiUrl;

    const {entity, loading} = storeToRefs(useUserStore());

    const asyncDataExecuted = ref(false);

    useAsyncData(
        'isOwner',
        async () => {
            asyncDataExecuted.value = true;
            await getById(Number(route.params.id));
            await compareOwner().then((resp) => { if(resp) router.push('/profile') })
        }
    );

    onMounted(async () => {
        if(asyncDataExecuted.value) return true;
        await getById(Number(route.params.id));
        await compareOwner().then((resp) => { if(resp) router.push('/profile') })
    })

</script>