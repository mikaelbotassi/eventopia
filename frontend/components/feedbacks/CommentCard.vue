<template>
    <article class="p-5 border-t border-white/25" ref="card" v-loading="loading">
        <div class="flex items-center gap-5">
            <div class="w-[50px] h-[50px] mb-3 overflow-hidden rounded-circle flex-none">
                <img src="https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" alt="" class="w-full h-full object-cover" />
            </div>
            <div class="flex flex-col w-full items-start">
                <h3>{{ comment.author?.name }}</h3>
                <h5 class="uppercase font-bold text-xs mb-3">{{ comment.author?.email }}</h5>
            </div>
        </div>
        <p class="text-left text-xs" v-if="!isEdit">
            {{ description }}
        </p>
        <form class="rounded-3 rounded-xl" v-else>
            <div class="p-3">
                <textarea v-model="description" class="form-control w-full border border-white bg-transparent p-3 focus-visible:outline-0 rounded-xl" rows="3">
                    {{ description }}
                </textarea>
            </div>
            <div class="pb-3 px-3 flex items-center justify-end">
                <el-button size="small" @click="cancelEdit()"
                class="bg-transparent border hover:fill-gray-800 text-red-400 hover:text-gray-800 hover:bg-red-400 fill-white ease-in-out duration-200 border-red-400 px-2 py-1"
                type="danger" plain dark :icon="ElIconClose">
                    Cancelar
                </el-button>
                <el-button size="small" @click="saveEdit()" class="bg-transparent border hover:fill-gray-800 text-white hover:text-gray-800 hover:bg-white fill-white ease-in-out duration-200 border-white px-2 py-1" :icon="ElIconPromotion" :loading="loading">
                    Salvar
                </el-button>
            </div>
        </form>
        <div class="flex items-center justify-end" v-if="isOwner() && !isEdit">
            <el-button size="small" @click="changeToEdit()" class="bg-transparent border hover:fill-gray-800 text-white hover:text-gray-800 hover:bg-white fill-white ease-in-out duration-200 border-white px-2 py-1" :icon="ElIconEditPen">
                Editar
            </el-button>
            <el-button size="small" @click="deleteComment()"
            class="bg-transparent border hover:fill-gray-800 text-red-400 hover:text-gray-800 hover:bg-red-400 fill-white ease-in-out duration-200 border-red-400 px-2 py-1"
            type="danger" plain dark :icon="ElIconDelete">
                Deletar
            </el-button>
        </div>
    </article>
</template>
<script setup lang="ts">

    const props = defineProps({
        comment:{
            type:Object,
            required:true
        },
        ownerUser:{
            type:Object,
            required:true
        }
    });

    const description = ref(props.comment.description || '');

    const isEdit = ref(false);
    const card = ref(null);

    const loading = ref(false);

    const {deleteById, update} = useFeedbackStore();

    const oldComment = ref('');

    function changeToEdit(){
        oldComment.value = description.value;
        isEdit.value = true;
    }
    
    function cancelEdit(){
        description.value = oldComment.value;
        isEdit.value = false;
    }

    function saveEdit(){
        loading.value = true
        update({description:description.value},props.comment.id)
        .catch(()=>{
            description.value = oldComment.value
            oldComment.value = '';
        }).finally(() => {
            loading.value = false;
            isEdit.value = false;
        })
    }

    function deleteComment(){
        loading.value = true;
        deleteById(props.comment.id).then(() => {
            fadeOut(card.value)
        }).finally(() => loading.value = false)
    }

    const isOwner = () => props.ownerUser.id == props.comment.author?.id;

</script>