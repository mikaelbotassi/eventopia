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
          <div class="col-span-2 my-5">
              <h2 class="font-bold text-2xl text-white">Categorias</h2>
              <h3 class="text-sm text-white/50 mb-5">Selecione as categorias de eventos que você tem preferência.</h3>
              <el-checkbox-group v-if="!loadingCategories" v-model="categories" size="large">
                  <el-checkbox-button v-for="category in entities" :key="category.id" :label="category.id">
                      {{ category.name }}
                  </el-checkbox-button>
              </el-checkbox-group>
              <div class="flex items-center justify-center p-5" v-else>
                  <LoadersCubeLoader />
              </div>
          </div>
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
  import GetCategories from '~/models/category/GetCategories';
  import { cast } from '~/utils/index.ts'

  const emit = defineEmits(['save','close']);

  const entity = ref(new UpdateUser())
  const categories = ref([]);

  const {me} = useUserStore();

  const {update} = useUserStore();
  const {loading} = storeToRefs(useAuthStore());

  const { getAll } = useCategoryStore();
  const { loading:loadingCategories, entities } = storeToRefs(useCategoryStore());

  const closeModal = () => emit('close')

  function formSave(){
    castToCategories();
    (async function() {
      if(await update(entity.value)) emit('save')
    })();
  }

  const castToCategories = () => {
      entity.value.categories = [];
      if(!categories.value) return false;
      categories.value.forEach((val) => {
          const newCategory = new GetCategories;
          newCategory.id = val;
          entity.value.categories.push(newCategory)
      });
  }

  useAsyncData(
    'user',
    async () => await me().then((resp) => {
      cast(entity.value, resp)
      entity.value.categories.forEach((val) => categories.value.push(val.id))
    })
  );

  onMounted(getAll);

</script>

<style>

</style>