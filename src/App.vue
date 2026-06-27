<template>
  <div id="app">
    <Navbar />
    <Hero v-if="isHome" />
    <RouterView />
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import Navbar from './components/Navbar.vue'
import Hero from './components/Hero.vue'

const route = useRoute()
const isHome = computed(() => route.path === '/')
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&display=swap');

*, *::before, *::after {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: 'Sora', sans-serif;
  background: #f1f5f9;
}

#app {
  min-height: 100vh;
}
</style>