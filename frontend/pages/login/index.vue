<template>
    <div class="rounded-2xl overflow-hidden">
        <div class="bg-gradient-login">
            <div class="lg:grid grid-cols-2">
                <div class="flex flex-col justify-center p-10">
                    <div class="flex items-center mb-10">
                        <img src="~/assets/img/brand.png" alt="" class="max-w-full h-[75px]">
                    </div>
                    <h1 class="text-secondary text-3xl mb-5 font-bold">BEM VINDO AO <span class="text-white">SEUEVENTO.COM</span>!</h1>
                    <p class="text-white mb-5">Digite seus dados abaixo.</p>
                    <form @submit.prevent="send">
                        <el-input v-model="email" size="large" placeholder="Insira seu E-mail" type="email" name="email" class="mb-5"/>
                        <el-input v-model="password" size="large" placeholder="Insira sua senha" type="password" class="mb-5" name="password" show-password/>
                        <div class="flex items-center justify-between mb-5">
                            <NuxtLink class="text-white fill-white after:border-white" :to="'/'">
                                Voltar
                            </NuxtLink>
                            <el-button size="large" native-type="submit" color="#10d38d" :loading="loading" dark plain>Entrar</el-button>
                        </div>
                        <!-- <div class="flex justify-end">
                            <el-link class="text-secondary fill-white after:border-secondary" href="/">Recuperar senha</el-link>
                        </div> -->
                        <el-divider class="my-10" content-position="center">Ou</el-divider>
                        <div class="flex justify-center">
                            <NuxtLink class="text-secondary text-lg fill-white after:border-secondary" :to="'/sign-up'">Criar conta</NuxtLink>
                        </div>
                    </form>
                </div>
                <div class="rounded-l-2xl hidden lg:block d-lg-block p-3 bg-secondary bg-opacity-50">
                        <div class="flex flex-col justify-between p-5 rounded-3 h-full">
                            <h2 class="font-bold text-white text-3xl mb-5">SeuEvento.com</h2>
                            <div class="mb-5">
                                <p class="text-primary">
                                    Descubra o SeuEvento.com, uma inovadora plataforma de eventos que conecta idealizadores, locadores de locais, fornecedores e instituições de educação. Encontre, participe e organize eventos com facilidade, promovendo uma colaboração sem precedentes.
                                </p>
                            </div>
                            <div class="bg-gradient-primary bg-opacity-50 shadow-lg rounded-3 p-3 text-white">
                                <div class="">
                                    Desfrute de uma busca intuitiva, comunicação eficiente, e gestão de documentos simplificada. SeuEvento.com redefine a experiência de eventos, criando uma comunidade envolvente que impulsiona o sucesso em todas as áreas. Conecte-se ao futuro dos eventos hoje mesmo!
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">

    definePageMeta({
        layout:'default',
        middleware: 'auth'
    })
    
    const { authenticateUser } = useAuthStore();
    const { isAuth, loading } = storeToRefs(useAuthStore());

    const router = useRouter();

    const email = ref('');
    const password = ref('');

    const send = () => {
        (async function() {
            await authenticateUser({
                email: email.value,
                password: password.value
            });
            if (isAuth) {
                router.push('/');
            }
        })();
    };

</script>
<style scoped>
.bg-gradient-login{
    background: hsla(210, 11%, 15%, 1);
    background: linear-gradient(45deg, hsla(210, 11%, 15%, 1) 0%, hsla(157, 79%, 17%, 1) 67%, hsla(158, 98%, 16%, 1) 99%);
    background: -moz-linear-gradient(45deg, hsla(210, 11%, 15%, 1) 0%, hsla(157, 79%, 17%, 1) 67%, hsla(158, 98%, 16%, 1) 99%);
    background: -webkit-linear-gradient(45deg, hsla(210, 11%, 15%, 1) 0%, hsla(157, 79%, 17%, 1) 67%, hsla(158, 98%, 16%, 1) 99%);
    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr="#212529", endColorstr="#094E34", GradientType=1 );
}
.bg-gradient-primary{
    background: hsla(159, 75%, 35%, 1);
    background: linear-gradient(45deg, hsla(159, 75%, 35%, 1) 0%, hsla(160, 66%, 29%, 1) 56%, hsla(161, 58%, 25%, 1) 74%, hsla(164, 46%, 21%, 1) 100%);
    background: -moz-linear-gradient(45deg, hsla(159, 75%, 35%, 1) 0%, hsla(160, 66%, 29%, 1) 56%, hsla(161, 58%, 25%, 1) 74%, hsla(164, 46%, 21%, 1) 100%);
    background: -webkit-linear-gradient(45deg, hsla(159, 75%, 35%, 1) 0%, hsla(160, 66%, 29%, 1) 56%, hsla(161, 58%, 25%, 1) 74%, hsla(164, 46%, 21%, 1) 100%);
    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr="#169C6E", endColorstr="#197B5B", GradientType=1 );
}
</style>