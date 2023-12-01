<template>
    <div class="flex items-center justify-center p-5">
        <LoadersCubeLoader />
    </div>
</template>
<script setup lang="ts">

    const {confirmPresence} = useRegistrationStore();

    const asyncExecuted = ref(false);

    const route = useRoute();

    useAsyncData(
        'confirm-presence',
        () => {
            asyncExecuted.value = true;
            confirmPresence(route.params.token);
        }
    );

    onMounted(() => {
        if(asyncExecuted.value){
            asyncExecuted.value = false;
            return true
        };
        confirmPresence(route.params.token);
    })

</script>