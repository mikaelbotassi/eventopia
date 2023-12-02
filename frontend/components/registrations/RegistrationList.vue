<template>
    <div class="p-5 border border-white" v-loading="loadingAction" v-if="!loading">
      
        <registrations-dowload-csv-button
          :buttons="buttons"
          :eventId="$route.params.id"
        />

      <el-table :data="typeEvent ? entities : userRegistrations" dark>
        <template v-if="typeEvent">
          <el-table-column label="Nome do inscrito">
            <template #default="props">
              <NuxtLink class="underline underline-offset-2 text-secondary" :to="'/profile/' + props.row.user?.id">{{ props.row.user?.name }}</NuxtLink>
            </template>
          </el-table-column>
          <el-table-column label="Data de nascimento">
            <template #default="props">
              {{ formater?.dateFormat(props.row.user?.birth) }}
            </template>
          </el-table-column>
        </template>
        <template v-else>
          <el-table-column label="Título do evento">
            <template #default="props">
              <NuxtLink class="underline underline-offset-2 text-secondary" :to="'/event/' + props.row.event?.id">{{ props.row.event?.title }}</NuxtLink>
            </template>
          </el-table-column>
          <el-table-column label="Data do evento">
            <template #default="props">
              {{ formater?.dateTimeFormat(props.row.event?.event_date) }}
            </template>
          </el-table-column>
        </template>
        <el-table-column label="Presente">
          <template #default="props">
            <el-tag type="success" v-if="props.row?.presence_date">
              {{ formater?.dateTimeFormat(props.row?.presence_date) }}
            </el-tag>
            <el-tag class="no-style" type="danger" effect="dark" v-else>Não confirmado</el-tag>
          </template>
        </el-table-column>
        <el-table-column label="Ações" width="75">
          <template #default="props">
            <el-dropdown trigger="click" class="w-full">
              <div class="el-dropdown-link w-full flex flex-col items-center justify-center">
                <icons-ellipsis-vertical class="fill-white text-xl"/>
              </div>
              <template #dropdown>
                <el-dropdown-menu>
                  <el-dropdown-item :icon="ElIconPrinter">
                    <NuxtLink :to="'/registration/' + props.row.id">Ver QrCode</NuxtLink>
                  </el-dropdown-item>
                  <el-dropdown-item @click="cancelRegistration(props.row.id)" :icon="ElIconClose">Cancelar Inscrição</el-dropdown-item>
                </el-dropdown-menu>
              </template>
            </el-dropdown>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <div class="flex items-center justify-center p-10" v-else>
        <LoadersCubeLoader />
    </div>
</template>

<script lang="ts" setup>

  const props = defineProps({
      typeEvent: Boolean,
  })

  import CsvButton from '~/models/registration/CsvButton';

  const buttons= new Array<CsvButton>(
        new CsvButton([], 'Todos os inscritos', ElIconList),
        new CsvButton([{
          column:'presence_date',
          operator:'<>',
          value:''
        }], 'Apenas os presentes', ElIconChecked),
  );

  const {getAllByToken, getAllEventRegistrationByUrl, deleteById, getDowloadCsvLink} = useRegistrationStore();
  const {userRegistrations, loading, entities} = storeToRefs(useRegistrationStore());

  const isAsync = ref(false)
  const loadingAction = ref(false)

  const route = useRoute();

  import Utils from '~/models/formaters/Utils';
  const formater = new Utils();

  function cancelRegistration(id:any){
    loadingAction.value = true;
    deleteById(id).finally(() => loadingAction.value = false)
  } 

  useAsyncData(
  'userRgistrations',
  async () => {
    isAsync.value = true;
    if(props.typeEvent) return await getAllEventRegistrationByUrl();
    return await getAllByToken();
  });

  onMounted(async () => {
    if(isAsync.value){
      isAsync.value = false;
      return true;
    }
    if(props.typeEvent) return await getAllEventRegistrationByUrl()
    return await getAllByToken();
  })

</script>