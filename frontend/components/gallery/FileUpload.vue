<template>
  <div class="large-12 medium-12 small-12 filezone">
    <input type="file" id="files" ref="inputRef" :multiple="multiple" @change="handleFiles" />
    <div class="flex h-full p-10 gap-5 flex-col items-center justify-center">
      <el-icon size="32"><UploadFilled /></el-icon>
      <p>
        Solte seus arquivos aqui <br />ou clique para pesquisar
      </p>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
    <div v-for="(file, key) in files" :key="key" class="file-listing">
      <div class="preview">
        <img :src="file.src" :ref="ref => setRef(key, ref)" />
        <span class="black-mask"></span>
      </div>
      <span class="file-name">
        {{ file?.name }}
      </span>
      <div class="remove-container">
        <a class="remove" @click="removeFile(key)">Remove</a>
      </div>
    </div>
  </div>
</template>

<script setup>

const props = defineProps({
  model:String,
  multiple:{
    type:Boolean,
    default:false
  },
  autoUpload:{
    type:Boolean,
    default:true
  },
  loadedFiles:{
    type:Array,
    default:[]
  }
})

const emit = defineEmits({
  saved: (files) => {
    if (files) return true
    else return false
  }
})

const files = ref([]);
files.value = props.loadedFiles;
const previews = ref([]);
const inputRef = ref(null);
const imagesId = ref([]);

const {uploadImage, deleteImage} = useGalleryStore();

const handleFiles = () => {
  let uploadedFiles = inputRef.value.files;

  for (let i = 0; i < uploadedFiles.length; i++) {
    files.value.push(uploadedFiles[i]);
  }
  if(uploadedFiles.length > 0 && !props.multiple) {
    files.value.splice(0, files.value.length);
    files.value.push(uploadedFiles[0]);
  }
  getImagePreviews();
  if(props.autoUpload) submitFiles();
};

const setRef = (index, refInstance) => {
  previews.value[index] = refInstance;
};

const getImagePreviews = () => {
  for (let i = 0; i < files.value.length; i++) {
    if (/\.(jpe?g|png|gif)$/i.test(files.value[i]?.name)) {
      const reader = new FileReader();
      reader.onload = function () {
        previews.value[Number(i)].src = reader.result;
      };
      reader.readAsDataURL(files.value[i]);
    } else {
      previews.value[Number(i)].src = '...';
    }
  }
};

const removeFile = (key) => {
  if(files.value[key].id > 0) {
    deleteImage(files.value[key].id).then((resp) => {
      if(resp){
        fadeOut(previews.value[key].parentElement).finally(() => {
          files.value.splice(key, 1);
        });
      }
    });
    return true;
  }
  fadeOut(previews.value[key].parentElement).finally(() => {
    files.value.splice(key, 1);
  });
};

const submitFiles = () => {
  for (let i = 0; i < files.value.length; i++) {
    if (files.value[i]?.id) {
      continue;
    }

    const formData = new FormData();
    formData.append('image', files.value[i]);
    formData.append('model', props.model);

    uploadImage(formData)
    .then((resp) =>{
      files.value[i].id = resp.data.id;
      files.value.splice(i, 1, files.value[i]);
      if(props.multiple) emit('saved', files.value);
      else emit('saved', files.value[i]);
    })
  }
};

</script>

<style scoped>
    input[type="file"]{
        opacity: 0;
        width: 100%;
        height: 200px;
        position: absolute;
        cursor: pointer;
    }
    .filezone {
        outline: 2px dashed var(--secondary);
        outline-offset: -10px;
        width:100%;
        background: var(--dark);
        border: 1px solid var(--secondary);
        color: var(--secondary);
        fill: var(--secondary);
        padding: 10px 10px;
        min-height: 200px;
        position: relative;
        cursor: pointer;
        transition:all .3s ease-in-out
    }
    .filezone:hover {
        background: rgba(var(--rgb-secondary), .1);
        transition:all .3s ease-in-out
    }

    .filezone p {
        font-size: 1.2em;
        text-align: center;
    }
    div.file-listing img{
        width:100%;
        object-fit: cover;
        height:100%;
    }
    div.file-listing div.preview{
      position: relative;
      width: 100%;
      height: 100%;
    }
    div.file-listing .black-mask{
        left:0;
        bottom:0;
        top:0;
        right:0;
        position:absolute;
        background: rgb(15,185,233);
        background: linear-gradient(180deg, rgba(15,185,233,0) 0%, rgba(0, 0, 0, 0.75) 100%);
    }

    div.file-listing .file-name{
      position:absolute;
      bottom:75px;
      left:50%;
      transform:translateX(-50%);
    }

    div.file-listing{
        width: 100%;
        padding:1rem;
        position: relative;
        aspect-ratio: 1/1;
    }

    div.success-container{
        text-align: center;
        color: green;
    }

    div.remove-container{
        text-align: center;
        padding: 0.5rem;
        background-color:#da4747
    }

    div.remove-container a{
        color: #fff;
        cursor: pointer;
    }

    a.submit-button{
        display: block;
        margin: auto;
        text-align: center;
        width: 200px;
        padding: 10px;
        text-transform: uppercase;
        background-color: #CCC;
        color: white;
        font-weight: bold;
        margin-top: 20px;
    }
</style>
