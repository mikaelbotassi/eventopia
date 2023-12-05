<template>
  <modal>
    <form @submit.prevent="formSave()">
      <modal-header>
        <h4>Criar novo evento</h4>
        <button type="button" @click="closeModal"><icons-xmark/></button>
      </modal-header>
      <modal-body>
        <div class="flex flex-wrap">

          <div class="w-full p-3">
            <h2 class="text-xl font-bold mb-5">Fotos do evento</h2>
            <gallery-file-upload
            model="event"
            @saved="insertIntoEvent"
            :multiple="true"
            @removed="removeImage"
            :loadedFiles="eventGallery"
            />
          </div>

          <el-form-item class="w-full p-3" label="Título do evento">
            <el-input v-model="obj.title" size="large" placeholder="Insira o título do evento" type="text" name="title"/>
          </el-form-item>

          <el-form-item class="w-full lg:w-1/2 p-3" label="Local do evento">
            <el-input v-model="obj.localization" size="large" placeholder="Insira a localização do evento" name="localization" type="text"/>
          </el-form-item>

          <el-form-item class="w-full lg:w-1/2 p-3" label="Link do maps para o local do evento">
            <el-input v-model="obj.urlLocalization" size="large" placeholder="Insira o link do maps com o local" name="urlLocalization" type="text"/>
          </el-form-item>

          <el-form-item class="w-full p-3" label="Descrição do evento">
            <el-input :autosize="{ minRows: 4 }" name="description" v-model="obj.description" size="large" placeholder="Insira a descrição do evento" type="textarea"/>
          </el-form-item>

          <el-form-item class="w-full md:w-1/3 p-3" label="Carga Horária">
            <el-input-number :autosize="{ minRows: 4 }" name="worload" v-model="obj.workload" class="w-full" size="large" placeholder="Insira a carga horária do evento" type="textarea"/>
          </el-form-item>

          <el-form-item class="w-full md:w-1/3 p-3" label="Dia do evento">
            <el-date-picker
              v-model="obj.event_date"
              class="w-full"
              size="large"
              name="event_date"
              type="datetime"
              placeholder="dd/mm/YYYY HH:mm"
              format="DD/MM/YYYY HH:mm"
              value-format="YYYY-MM-DD HH:mm"
              date-format="DD MMM, YYYY"
              time-format="HH:mm"
            />
          </el-form-item>

          <el-form-item class="w-full md:w-1/3 p-3" label="Data máxima para inscrição">
            <el-date-picker
              v-model="obj.registration_validity"
              class="w-full"
              size="large"
              name="registratino_valiity"
              type="datetime"
              placeholder="dd/mm/YYYY HH:mm"
              format="DD/MM/YYYY HH:mm"
              value-format="YYYY-MM-DD HH:mm"
              date-format="DD MMM, YYYY"
              time-format="HH:mm"
            />
          </el-form-item>
          <div class="col-span-2 my-5">
              <h2 class="font-bold text-2xl text-white">Categorias</h2>
              <h3 class="text-sm text-white/50 mb-5">Selecione as categorias que o evento se encaixa.</h3>
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

  import { CreateEvent, UpdateEvent } from '~/models/event/Event';
  import GetCategories from '~/models/category/GetCategories';
  import GetGallery from '~/models/gallery/GetGallery';
  import { cast } from '~/utils/index.ts'

  const props = defineProps({
    entityId:{
      type: Number,
      required: false,
      default: 0
    }
  });

  const { create, update, getById } = useEventStore();
  const {loading,entity} = storeToRefs(useEventStore());

  const { getAll } = useCategoryStore();
  const { loading:loadingCategories, entities } = storeToRefs(useCategoryStore());

  const emit = defineEmits(['save','close']);

  const categories = ref([]);

  const baseApiUrl = useRuntimeConfig().public.baseApiUrl;

  const eventGallery = ref([]);

  const obj = props.entityId <= 0 ? reactive(new CreateEvent()) : reactive(cast(new UpdateEvent(), entity.value));
  
  obj.categories?.forEach((val) => categories.value.push(val.id))

  const closeModal = () => emit('close')

  const castToCategories = () => {
    obj.categories = [];
    if(!categories.value) return false;
    categories.value.forEach((val) => {
        const newCategory = new GetCategories;
        newCategory.id = val;
        obj.categories.push(newCategory)
    });
  }

  const insertIntoEvent = (file) => {
    obj.gallery = file
  }

  const removeImage = (id:number) => {
    obj.gallery = obj.gallery.filter(gallery => gallery.id !== id);
    eventGallery.value = eventGallery.value.filter(gallery => gallery.id !== id);
    entity.value.gallery = entity.value.gallery.filter(gallery => gallery.id !== id);
  }

  onMounted(() => {
    getAll();
    if(obj.gallery){
      if(obj.gallery.length > 0){
        obj.gallery.forEach((el) => {
          eventGallery.value.push({
            id:el?.id,
            src:`${baseApiUrl}/gallery/${el?.path}/${el?.filename}`
          });
        })
      }
    }
  })
  
  function formSave(){
    castToCategories();
    (async function() {
      if(props.entityId > 0){
        if(await update(obj, props.entityId)) emit('save')
      }else{
        if(await create(obj)) emit('save')
      }
    })();
  }

</script>

<style>

</style>