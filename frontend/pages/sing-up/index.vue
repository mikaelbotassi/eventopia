<template>
    <div class="rounded-2xl w-50 overflow-hidden">
        <div class="bg-gradient-login">
            <div class="flex flex-col justify-center p-10">
                <div class="flex items-center mb-10">
                    <img src="~/assets/img/brand.png" alt="" class="max-w-full h-[75px]">
                </div>
                <p class="text-white text-3xl mb-5">Insira seus dados abaixo.</p>
                <div class="grid w-full grid-cols-2 gap-4 mb-5">
                    <el-input v-model="user.name" class="col-span-2" size="large" placeholder="Insira seu nome completo" type="text" name="fullname"/>
                    <el-input v-model="user.cpf_cnpj" v-mask="['###.###.###-##', '##.###.###/####-##']" size="large" placeholder="Insira seu CPF ou CNPJ" type="text"/>
                    <el-input v-model="user.email" size="large" placeholder="Insira seu E-mail" type="email" name="email"/>
                    <el-input v-model="user.password" size="large" placeholder="Insira sua senha" type="password" name="password" show-password/>
                    <el-date-picker
                        v-model="user.birth"
                        type="date"
                        format="DD/MM/YYYY"
                        value-format="YYYY-MM-DD"
                        placeholder="Data de aniversário"
                        size="large"
                    />
                </div>
                <div class="flex items-center justify-between mb-5">
                    <el-link class="text-white fill-white after:border-white" href="/login">
                        Voltar
                    </el-link>
                    <el-button size="large" :loading="loading" color="#10d38d" @click="doSingUp()" dark plain>Enviar</el-button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
    import { CreateUser } from '~/models/user/User';
    definePageMeta({
        layout:'default',
    })
    
    const { registerUser } = useUserStore();
    const { loading } = storeToRefs(useUserStore());

    const user = reactive(new CreateUser());

    const doSingUp = () => {
        (async function() {
            if(await registerUser(user)) useRouter().push('/login');
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