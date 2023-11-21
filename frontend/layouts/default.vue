<template>
    <main class="bg-gradient-animate p-0 min-h-screen flex justify-center items-center">
        <div class="container flex items-center justify-center p-0">
            <slot/>
        </div>
    </main>
</template>

<script lang="ts" setup>

</script>

<style scoped>

.bg-gradient-animate {
    background: linear-gradient(270deg, #10d38d, #212529);
    background-size: 400% 400%;

    -webkit-animation: AnimationName 30s ease infinite;
    -moz-animation: AnimationName 30s ease infinite;
    animation: AnimationName 30s ease infinite;
}

@-webkit-keyframes AnimationName {
    0%{background-position:0% 50%}
    50%{background-position:100% 50%}
    100%{background-position:0% 50%}
}
@-moz-keyframes AnimationName {
    0%{background-position:0% 50%}
    50%{background-position:100% 50%}
    100%{background-position:0% 50%}
}
@keyframes AnimationName {
    0%{background-position:0% 50%}
    50%{background-position:100% 50%}
    100%{background-position:0% 50%}
}
</style>