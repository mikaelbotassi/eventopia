<template>
  <div class="flex justify-between">
    <el-menu
      default-active="2"
      class="el-menu-side bg-primary border-secondary text-white min-h-[100vh] py-5 shadow-xl"
      :collapse="isCollapse"
    >
      <el-menu-item class="group flex flex-col py-3 h-fit gap-1 border-primary text-white hover:bg-primary hover:text-primary" index="2">
          <img src="~/assets/img/brand.png" class="w-[120px]" />
      </el-menu-item>
      <el-divider class="opacity-25 border-secondary"></el-divider>
      <el-menu-item class="group text-white hover:bg-gradient-to-r from-secondary to-primary" index="1" @click="$router.push('/')">
        <el-icon class="fill-white"><icons-house /></el-icon>
        <template #title>Home</template>
      </el-menu-item>
      <el-menu-item @click="isOpen = !isOpen" class="group text-white hover:bg-gradient-to-r from-secondary to-primary" index="2">
        <el-icon class="fill-white"><icons-plus-square /></el-icon>
        <template #title>Adicionar</template>
      </el-menu-item>
      <el-menu-item class="group text-white hover:bg-gradient-to-r from-secondary to-primary" index="1" @click="$router.push('/certificate/search')">
        <el-icon class="fill-white"><icons-magnifying-glass /></el-icon>
        <template #title>Procurar certificado</template>
      </el-menu-item>
    </el-menu>
    <div class="container mx-auto p-5 flex flex-col items-center justify-start gap-10 w-full">
      <header class="mb-5 w-full flex items-center justify-center">
        <div class="w-full flex items-center justify-between">
          <div class="flex items-center gap-10">
            <button @click="toggleSidebar()" class="text-3xl fill-secondary">
              <icons-bars-staggered/>
            </button>
          </div>
          <div>
            <el-dropdown trigger="click">
              <span class="el-dropdown-divnk flex items-center">
                <el-icon class="text-3xl fill-white">
                  <icons-circle-user />
                </el-icon>
                <el-icon class="el-icon--right fill-white">
                  <icons-sort-down />
                </el-icon>
              </span>
              <template #dropdown>
                <el-dropdown-menu>
                  <el-dropdown-item @click="$router.push('/profile')">
                    <el-icon>
                      <icons-user/>
                    </el-icon>
                    Ver perfil
                  </el-dropdown-item>
                  <el-dropdown-item @click="$router.push('/certificate/')">
                    <el-icon>
                      <icons-certificate/>
                    </el-icon>
                    Meus certificados
                  </el-dropdown-item>
                  <el-dropdown-item @click="doLogout()">
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

  <component :is="isOpen ? eventModal : 'div'" @save="isOpen = false" @close="isOpen = false" />

</template>

<script setup lang="ts">

  let isCollapse = ref(true)

  const eventModal = shallowRef(resolveComponent('EventsEventModalForm'));

  const isOpen = ref(false);

  const { logUserOut } = useAuthStore();
  const router = useRouter();

  const toggleSidebar = () => {
    isCollapse.value = !isCollapse.value
  }

  const doLogout = () => {
    logUserOut();
    router.push('/login');
  };
</script>

<style scoped>
  .el-menu-side.el-menu--collapse{
    transition:all .2s ease-in-out
  }
  .el-menu-side:not(.el-menu--collapse) {
    transition:all .2s ease-in-out;
  }
  .el-menu-item:hover {
    background-color: transparent;
    background-color: transparent;
  }
</style>