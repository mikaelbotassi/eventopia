<template>
  <modal>
    <form @submit.prevent="formSave()">
      <modal-header>
        <h4>Criar novo evento</h4>
        <button type="button" @click="closeModal"><icons-xmark/></button>
      </modal-header>
      <modal-body>
        <div class="flex flex-wrap">

          <el-form-item class="w-full p-3" label="Título do evento">
            <el-input v-model="obj.title" size="large" placeholder="Insira o título do evento" type="text"/>
          </el-form-item>

          <el-form-item class="w-full lg:w-1/2 p-3" label="Local do evento">
            <el-input v-model="obj.localization" size="large" placeholder="Insira a localização do evento" type="text"/>
          </el-form-item>

          <el-form-item class="w-full lg:w-1/2 p-3" label="Local do evento">
            <el-input v-model="obj.urlLocalization" size="large" placeholder="Insira o link do maps com o local" type="text"/>
          </el-form-item>

          <el-form-item class="w-full p-3" label="Descrição do evento">
            <el-input :autosize="{ minRows: 4 }" v-model="obj.description" size="large" placeholder="Insira a descrição do evento" type="textarea"/>
          </el-form-item>

          <el-form-item class="w-full md:w-1/3 p-3" label="Carga Horária">
            <el-input-number :autosize="{ minRows: 4 }" v-model="obj.workload" class="w-full" size="large" placeholder="Insira a carga horária do evento" type="textarea"/>
          </el-form-item>

          <el-form-item class="w-full md:w-1/3 p-3" label="Dia do evento">
            <el-date-picker
              v-model="obj.event_date"
              class="w-full"
              size="large"
              type="datetime"
              placeholder="dd/mm/YYYY HH:mm"
              format="DD/MM/YYYY HH:mm"
              value-format="YYYY-MM-DD HH:mm"
              date-format="DD MMM, YYYY"
              time-format="HH:mm"
            />
          </el-form-item>

          <el-form-item class="w-full lg:w-1/3 p-3" label="Data máxima para inscrição">
            <el-date-picker
              v-model="obj.registration_validity"
              class="w-full"
              size="large"
              type="datetime"
              placeholder="dd/mm/YYYY HH:mm"
              format="DD/MM/YYYY HH:mm"
              value-format="YYYY-MM-DD HH:mm"
              date-format="DD MMM, YYYY"
              time-format="HH:mm"
            />
          </el-form-item>

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
  import { cast } from '~/utils/index.ts'

  const props = defineProps({
    entityId:{
      type: Number,
      required: false,
      default: 0
    }
  });

  console.log(props.entityId);

  const { create, update, getById } = useEventStore();
  const {loading,entity} = storeToRefs(useEventStore());
  const emit = defineEmits(['save','close']);

  const obj = props.entityId <= 0 ? reactive(new CreateEvent()) : reactive(cast(new UpdateEvent(), entity.value));

  const closeModal = () => emit('close')

  function formSave(){
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