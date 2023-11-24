<template>
</template>
<script setup lang="ts">
import { useRouter } from 'vue-router';


    definePageMeta({
        layout:'default',
    })
    
    const { logUserOut } = useAuthStore();

    logUserOut();
    useRouter().push('/login');

</script>