<template>
    <div class="flex items-center justify-center p-5">
        <LoadersCubeLoader />
    </div>
</template>
<script setup lang="ts">

    const {searchCertificate} = useCertificateStore();

    const asyncExecuted = ref(false);

    const route = useRoute();

    useAsyncData(
        'confirm-presence',
        () => {
            asyncExecuted.value = true;
            searchCertificate();
        }
    );

    onMounted(() => {
        if(asyncExecuted.value){
            asyncExecuted.value = false;
            return true
        };
        searchCertificate();
    })

</script>