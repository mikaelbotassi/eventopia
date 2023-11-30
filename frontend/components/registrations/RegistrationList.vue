<template>
    <div class="p-5 border border-white" v-if="!loading">
      <el-table :data="userRegistrations" dark>
        <el-table-column label="Título do evento">
          <template #default="props">
            <NuxtLink class="underline underline-offset-2" :to="'/event/' + props.row.event?.id">{{ props.row.event?.title }}</NuxtLink>
          </template>
        </el-table-column>
        <el-table-column label="Data do evento">
          <template #default="props">
            {{ formater?.dateTimeFormat(props.row.event?.event_date) }}
          </template>
        </el-table-column>
        <el-table-column label="Presente">
          <template #default="props">
            <el-tag type="success" v-if="props.row?.presence_date">
              {{ formater?.dateTimeFormat(props.row?.presence_date) }}
            </el-tag>
            <el-tag class="no-style" type="danger" effect="dark" v-else>Não confirmado</el-tag>
          </template>
        </el-table-column>
        <el-table-column label="Ações" width="75px">
          <template #default="props">
            <el-dropdown trigger="click" class="w-full">
              <div class="el-dropdown-link w-full flex flex-col items-center justify-center">
                <icons-ellipsis-vertical class="fill-white text-xl"/>
              </div>
              <template #dropdown>
                <el-dropdown-menu>
                  <el-dropdown-item :icon="ElIconPrinter">Baixar QrCode</el-dropdown-item>
                  <el-dropdown-item :icon="ElIconClose">Cancelar Inscrição</el-dropdown-item>
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

  const {getAllByToken} = useRegistrationStore();
  const {userRegistrations, loading} = storeToRefs(useRegistrationStore());

  const isAsync = ref(false)

  import Utils from '~/models/formaters/Utils';
  const formater = new Utils();

  useAsyncData(
  'userRgistrations',
  async () => {
    isAsync.value = true;
    await getAllByToken();
  });

  onMounted(async () => {
    if(isAsync.value){
      isAsync.value = false;
      return true;
    }
    await getAllByToken();
  })

</script>

<style>

</style>