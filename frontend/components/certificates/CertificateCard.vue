<template>

    <div class="bg-secondary relative p-3">
        <div class="bg-dark flex flex-col items-center justify-center gap-5 p-5">
            <img src="~/assets/img/brand.png" alt="logo eventopia" class="w-[75px] h-[75px] object-contain"/>
            <h1 class="font-bold text-lg text-secondary text-center">{{ title }}</h1>
            <h2 class="text-white uppercase">{{owner}}</h2>
            <h3 class="bg-secondary/50 text-xs text-white py-2 px-3 rounded-full">{{ formater?.dateTimeFormat(eventDate) }}</h3>
        </div>
        <NuxtLink :to="'/certificate/' + entityId" class="inset-0 absolute"/>
    </div>

</template>

<script setup lang="ts">

    const props = defineProps({
        entityId:Number,
        title:String,
        owner:String,
        eventDate:String
    })

    import Utils from '~/models/formaters/Utils';
    const formater = new Utils();

</script>