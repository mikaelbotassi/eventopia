<template>
  <div class="flex justify-between">
    <el-menu
      default-active="2"
      class="bg-primary border-0 text-white min-h-[100vh] py-5"
      :collapse="isCollapse"
      @open="handleOpen"
      @close="handleClose"
    >
      <el-menu-item class="group border-primary text-white hover:text-primary" index="2">
        <el-icon class="fill-white group-hover:fill-primary"><icons-house /></el-icon>
        <template #title>Home</template>
      </el-menu-item>
      <el-menu-item class="group border-primary text-white hover:text-primary" index="2">
        <el-icon class="fill-white group-hover:fill-primary"><icons-plus-square /></el-icon>
        <template #title>Adicionar</template>
      </el-menu-item>
      <el-menu-item class="group border-primary text-white hover:text-primary" index="2">
        <el-icon class="fill-white group-hover:fill-primary"><icons-plus-square /></el-icon>
        <template #title>Adicionar</template>
      </el-menu-item>
    </el-menu>
    <div class="container py-5 mx-auto flex flex-col items-center justify-center w-full">
      <header class="mb-5 w-full flex items-center justify-center">
        <div class="w-full flex items-center justify-between">
          <div class="flex items-center gap-10">
            <button @click="toggleSidebar()" class="text-4xl fill-white">
              <icons-bars-staggered/>
            </button>
            <div>
              <img src="../assets/img/brand.png" class="w-[75px]" />
            </div>
          </div>
          <div class="text-white font-bold text-3xl">
            Home
          </div>
          <div>
            <el-dropdown>
              <span class="el-dropdown-divnk flex items-center">
                <el-icon class="text-4xl fill-white">
                  <icons-circle-user />
                </el-icon>
                <el-icon class="el-icon--right fill-white">
                  <icons-sort-down />
                </el-icon>
              </span>
              <template #dropdown>
                <el-dropdown-menu>
                  <el-dropdown-item>
                    <el-icon>
                      <icons-user/>
                    </el-icon>
                    Ver perfil
                  </el-dropdown-item>
                  <el-dropdown-item>
                    <el-icon>
                      <icons-arrow-right-from-bracket/>
                    </el-icon>
                    Sair
                  </el-dropdown-item>
                </el-dropdown-menu>
              </template>
            </el-dropdown>
          </div>
        </div>
      </header>
      <slot></slot>
    </div>
  </div>
</template>

<script setup lang="ts">
  let isCollapse = ref(true)
  const handleOpen = (key: string, keyPath: string[]) => {
    console.log(key, keyPath)
  }
  const toggleSidebar = () => {
    isCollapse.value = !isCollapse.value
    console.log("🚀 ~ file: side-nav.vue:72 ~ toggleSidebar ~ isCollapse:", isCollapse)
  }
  const handleClose = (key: string, keyPath: string[]) => {
    console.log(key, keyPath)
  }
</script>

<style scoped>
  :root{
    --el-menu-bg-color:#000;
  }
</style>