<template>
    <div id="ticket" class="container bg-white" v-if="!loading">
        <el-card class="box-card">
            <template #header>
            <div class="card-header text-center flex gap-3 items-center justify-center">
                <h1 class="text-dark font-bold text-3xl">{{ entity?.event?.title }}</h1>
                <el-button @click="printTicket()" :icon="ElIconPrinter" color="var(--secondary)" class="no-printable" size="small" dark plain>Imprimir</el-button>
            </div>
            </template>
            <div class="flex flex-col items-center">
                <h2 class="font-bold text-xl mb-3">Dados do inscrito</h2>
                <div class="flex flex-wrap gap-5 mb-5">
                    <div class="flex border border-dark/25 p-3 flex-col">
                        <span>NOME</span>
                        <span class="font-bold">{{ entity?.user?.name }}</span>
                    </div>
                    <div class="flex border border-dark/25 p-3 flex-col">
                        <span>E-MAIL</span>
                        <span class="font-bold">{{ entity?.user?.email }}</span>
                    </div>
                    <div class="flex border border-dark/25 p-3 flex-col">
                        <span>CPF/CNPJ</span>
                        <span class="font-bold">{{ formater?.getMaskedDoc(entity?.user?.cpf_cnpj) }}</span>
                    </div>
                    <div class="flex border border-dark/25 p-3 flex-col">
                        <span>Data de nascimento</span>
                        <span class="font-bold">{{ formater?.dateFormat(entity?.user?.birth) }}</span>
                    </div>
                </div>
                <h2 class="font-bold text-xl mb-3">Dados do evento</h2>
                <div class="flex flex-wrap gap-5 mb-5">
                    <div class="flex border border-dark/25 p-3 flex-col">
                        <span>TÍTULO</span>
                        <span class="font-bold">{{ entity?.event?.title }}</span>
                    </div>
                    <div class="flex border border-dark/25 p-3 flex-col">
                        <span>DATA DE REALIZAÇÃO</span>
                        <span class="font-bold">{{ formater?.dateTimeFormat(entity?.event?.event_date) }}</span>
                    </div>
                    <div class="flex border border-dark/25 p-3 flex-col">
                        <span>CARGA HORÁRIA TOTAL</span>
                        <span class="font-bold">{{ entity?.event?.workload }}</span>
                    </div>
                    <div class="flex border border-dark/25 p-3 flex-col">
                        <span>LOCAL DO EVENTO</span>
                        <span class="font-bold">{{ entity?.event?.localization }}</span>
                    </div>
                </div>
                <h2 class="font-bold text-xl mb-3">Dados do organizador</h2>
                <div class="flex flex-wrap gap-5 mb-5">
                    <div class="flex border border-dark/25 p-3 flex-col">
                        <span>NOME</span>
                        <span class="font-bold">{{ entity?.event?.ownerObj?.name }}</span>
                    </div>
                    <div class="flex border border-dark/25 p-3 flex-col">
                        <span>E-MAIL</span>
                        <span class="font-bold">{{ entity?.event?.ownerObj?.email }}</span>
                    </div>
                    <div class="flex border border-dark/25 p-3 flex-col">
                        <span>CPF/CNPJ</span>
                        <span class="font-bold">{{ formater?.getMaskedDoc(entity?.event?.ownerObj?.cpf_cnpj) }}</span>
                    </div>
                </div>
                <h2 class="font-bold text-xl">QRCode para confirmação de inscrição</h2>
                <template v-if="!loadingQrCode">
                    <img :src="`http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=${absolutePath + qrCode}`" />
                </template>
                <div class="flex items-center justify-center p-5" v-else>
                    <LoadersCubeLoader />
                </div>
                <div class="flex flex-col items-center no-printable" v-if="isOwner">
                    <h5 class="mb-3">Ou confirme a presença clicando no botão abaixo:</h5>
                    <el-button size="large" type="success" :icon="ElIconCheck">
                        <NuxtLink :to="`${absolutePath}${qrCode}`">Confirmar presença</NuxtLink>
                    </el-button>
                </div>
                <div class="border-t border-dark/25 pt-5 mt-10 flex items-center gap-5">
                    <img src="~/assets/img/brand.png" alt="logo seuEvento.com" class="w-[100px]" />
                    <div>
                        <strong>Aviso:</strong> Esta página não deve ser modificada, muito menos impressa por qualquer outra fonte a não ser da Rede SeuEvento.com.
                    </div>
                </div>
            </div>
        </el-card>
    </div>
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

    const absolutePath = ref('');

    const isOwner = ref(false);
    
    const route = useRoute();
    const router = useRouter();

    const loadingQrCode = ref(true);

    const {getById, getConfirmPresenceLink} = useRegistrationStore();

    const {entity, loading} = storeToRefs(useRegistrationStore());

    const qrCode = ref();

    const asyncExecuted = ref(false);

    function printTicket(){
        printDoc('ticket');
    }

    useAsyncData(
        'getRegistration',
        async () => {
            const token = useCookie('token');
            asyncExecuted.value = true;
            await getById(Number(route.params.id)).finally(() => isOwner.value = token.value?.user_id === entity.value.event?.owner)
            await getConfirmPresenceLink(Number(route.params.id))
            .then((resp) => {
                loadingQrCode.value = false;
                qrCode.value = resp
            })
            .finallly(() => loadingQrCode.value = false);
        }
    );

    onMounted(async () => {
        absolutePath.value = window.location.origin
        if(asyncExecuted.value){
            asyncExecuted.value = false;
            return true
        };
        const token = useCookie('token');
        await getById(Number(route.params.id)).finally(() => isOwner.value = token.value?.user_id === entity.value.event?.owner);
        qrCode.value = await getConfirmPresenceLink(Number(route.params.id)).finally(() => loadingQrCode.value = false);
    })

</script>

<style>
    @media print{
        body{
            font-size:12px !important;
        }

        .no-printable{ display:none !important }

    }
</style>