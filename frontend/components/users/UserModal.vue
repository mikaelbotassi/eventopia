<template>
  <modal>
    <form @submit.prevent="formSave()">
      <modal-header>
        <h4>Editar perfil</h4>
        <button type="button" @click="closeModal"><icons-xmark/></button>
      </modal-header>
      <modal-body>
        <div class="grid w-full grid-cols-2 gap-4 mb-5">
          <el-input v-model="entity.name" class="col-span-2" size="large" placeholder="Insira seu nome completo" type="text" name="fullname"/>
          <el-input v-model="entity.cpf_cnpj" v-mask="['###.###.###-##', '##.###.###/####-##']" size="large" placeholder="Insira seu CPF ou CNPJ" type="text"/>
          <el-input v-model="entity.email" size="large" placeholder="Insira seu E-mail" type="email" name="email"/>
          <el-input v-model="entity.password" size="large" placeholder="Insira sua senha" type="password" name="password" show-password/>
          <el-date-picker
              v-model="entity.birth"
              type="date"
              class="w-full"
              format="DD/MM/YYYY"
              value-format="YYYY-MM-DD"
              placeholder="Data de nascimento"
              size="large"
          />
        </div>
      </modal-body>
      <modal-footer>
        <el-button size="large" class="hover:text-dark" color="#fff" dark plain  @click="closeModal">Cancelar</el-button>
        <el-button native-type="submit" size="large" color="#10d38d" class="hover:text-dark" :loading="loading" dark plain>Salvar</el-button>
      </modal-footer>
    </form>
  </modal>
</template>

<script lang="ts" setup>

  import { UpdateUser } from '~/models/user/User';
  import { cast } from '~/utils/index.ts'

  const emit = defineEmits(['save','close']);

  const entity = ref(new UpdateUser())

  const {me} = useAuthStore();
  const {update} = useUserStore();
  const {loading} = storeToRefs(useAuthStore());

  const closeModal = () => emit('close')

  function formSave(){
    (async function() {
      if(await update(entity.value)) emit('save')
    })();
  }

  useAsyncData(
    'user',
    async () => await me().then((resp) => cast(entity.value, resp))
  );

</script>

<style>

</style>