<template>
    <div class="w-full bg-primary p-3 rounded-xl">
        <div class="grid grid-cols-2 gap-4">
            <article class="bg-gray-700 text-white position-relative shadow-lg rounded-xl overflow-hidden">
                <div class="aspect-video">
                    <img src="https://cdn.wallpapersafari.com/41/36/EwIcFb.jpg" alt="..." class="object-fit-cover" />
                </div>
                <div class="p-4 pt-2 event-card-body position-relative rounded-4" style="z-index:1">
                    <h5 class="fw-bold mb-3">Loren Ipsun</h5>
                    <div class="flex items-center justify-start gap-2 text-xs text-opacity-75 mb-2">
                        <span class="fill-white bg-white/25 px-2 py-1 rounded-lg">
                            <icons-pin/>
                        </span>
                        Rua Everaldo Rodrigues, 29, Sao Vicente, Colatina-ES
                    </div>
                    <div class="flex items-center justify-start gap-2 text-xs mb-3">
                        <span class="bg-white/25 fill-white px-2 py-1 rounded-lg">
                            <icons-schedule/>
                        </span>
                        06/06/2023 18:06
                    </div>
                    <p class="fw-bold mb-0">Sobre</p>
                    <p class="mb-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus, sapiente!</p>
                </div>
            </article>
        </div>
    </div>
</template>

<script setup lang="ts">
    definePageMeta({
        layout:'side-nav',
        path:'/',
        middleware:'auth'
    })
</script>