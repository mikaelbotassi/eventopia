<template>
    <a :href="link" class="hidden" id="csvButton" dowload>Baixar CSV</a>
    <el-dropdown v-loading="loading" trigger="click" class="w-full flex justify-end mb-3">
        <div class="el-dropdown-link flex gap-3 items-center justify-center bg-dark border border-white p-3 rounded">
            <h2 class="text-white">Exportar em CSV</h2>
        </div>
        <template #dropdown>
            <el-dropdown-menu>
                <el-dropdown-item v-for="button in buttons" :icon="button.icon" @click="dowloadCsv(button.filters)">{{button.label}}</el-dropdown-item>
            </el-dropdown-menu>
        </template>
    </el-dropdown>
</template>
<script setup lang="ts">

    import CsvButton from '~/models/registration/CsvButton';

    const props = defineProps({
        buttons:{
            type:Array<CsvButton>,
            required:true
        },
        eventId:Number|String
    })

    const link = ref();

    const loading = ref(false);

    const {getDowloadCsvLink} = useRegistrationStore();

    function dowloadCsv(filters:[]){
        loading.value = true;
        getDowloadCsvLink(props.eventId, filters).then((resp) => {
            clickDowload(resp);
        }).finally(() => loading.value = false)
    }

    function clickDowload(link:any){
        const aLink = document.createElement('a');
        aLink.href = link;
        
        const today = new Date();

        const formattedDate = today.toISOString().split('T')[0];

        const hours = today.getHours().toString().padStart(2, '0');
        const minutes = today.getMinutes().toString().padStart(2, '0');
        aLink.setAttribute('download', `inscritos-${formattedDate}-${hours}${minutes}.csv`);
        aLink.style.display = 'none';

        document.body.appendChild(aLink);
        aLink.click();
        document.body.removeChild(aLink);
    }

    

</script>