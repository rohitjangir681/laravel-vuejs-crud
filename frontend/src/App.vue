<script setup>
import { RouterLink, RouterView } from 'vue-router'
import Nav from '@/components/Nav.vue';


</script>

<template>
  <header class="bg-white">
    <Nav />
  </header>

  <div class="max-w-7xl mx-auto p-6 lg:px-8">
    <RouterView />
  </div>

</template>
