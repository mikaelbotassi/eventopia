<template>
    <div class="bg-gray-800 rounded-xl h-[400px] overflow-auto">
        <div class="p-5">
            <div class="flex items-center gap-5">
                <div class="w-[50px] h-[50px] mb-3 overflow-hidden rounded-circle flex-none">
                    <img v-if="user.img" :src="`${baseApiUrl}/gallery/${user.img?.path}/${user.img?.filename}`" class="w-full h-full object-cover" alt="profile picture" />
                    <div class="bg-white w-full h-full flex items-end justify-center" v-else>
                        <icons-user class="w-3/4 h-3/4"/>
                    </div>
                </div>
                <div class="flex flex-col w-full items-start">
                    <h3>{{ user.name }}</h3>
                    <h5 class="uppercase font-bold text-xs mb-3">{{user.email}}</h5>
                </div>
            </div>
            <form class="rounded-3 bg-gray-900 rounded-xl" id="commentForm">
                <div class="p-3">
                    <textarea v-model="obj.description" class="form-control w-full border border-white bg-transparent p-3 focus-visible:outline-0 rounded-xl" rows="6"></textarea>
                </div>
                <div class="pb-3 px-3 flex items-center justify-end">
                    <el-button size="large" @click="saveComment()" class="bg-transparent border hover:fill-gray-800 text-white hover:text-gray-800 hover:bg-white fill-white ease-in-out duration-200 border-white px-2 py-1 rounded-lg" :icon="ElIconPromotion" :loading="loadSubmit">
                        Comentar
                    </el-button>
                </div>
            </form>
        </div>

        <template v-if="!loading">
            <feedbacks-comment-card v-for="comment in entities" :key="comment.id" :comment="comment" :ownerUser="user"/>
        </template>
        <div class="flex items-center justify-center p-5" v-else>
            <LoadersCubeLoader />
        </div>
    </div>
</template>

<script setup lang="ts">

    import {OwnerUser} from '~/models/user/User'

    const {loading,entities} = storeToRefs(useFeedbackStore());
    const baseApiUrl = useRuntimeConfig().public.baseApiUrl;
    const {me} = useAuthStore();
    const {create} = useFeedbackStore();
    const route = useRoute();
    import CreateFeedback from '~/models/feedback/CreateFeedback'
    const obj = reactive(new CreateFeedback)
    const description = ref('');
    const loadSubmit = ref(false);

    const user = ref(new OwnerUser);

    const saveComment = () => {
        obj.event_id = Number(route.params.id);
        loadSubmit.value = true;
        create(obj).finally(() => {
            obj.description = '';
            loadSubmit.value = false
        });
    }

    const asyncData = ref(false);

    useAsyncData('commentUser', async () => {
        asyncData.value = true;
        user.value = await me()
    })

    onMounted(async () => {
        if(asyncData.value) return true;
        user.value = await me()
    });

</script>