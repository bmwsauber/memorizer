<template>
    <nav id="left-sidebar" class="absolute left-0 top-0 h-full z-20 bg-white p-4 shadow-2xl" :class="{ hidden : $store.state.leftSidebarHide }" style="min-width: 360px;">
        <i class="fas fa-bars" @click="$store.commit('toggleLeftSidebarState')"></i>
        <h3 class="text-center text-2xl">Setting</h3>
        <hr class="mt-3"/>
    </nav>
</template>
