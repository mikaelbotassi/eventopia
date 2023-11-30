<template>
    <el-button @click="register()" size="large" color="#10d38d" :icon="ElIconTicket" :loading="loadingSubmit" class="hover:bg-secondary">
        Quero me inscrever
    </el-button>
</template>

<script setup lang="ts">

    const {create} = useRegistrationStore();

    const route = useRoute();

    const loadingSubmit = ref(false);

    function register(){
        loadingSubmit.value = true;
        create({event_id:Number(route.params.id)})
        .finally(() => loadingSubmit.value = false)
    }
</script>