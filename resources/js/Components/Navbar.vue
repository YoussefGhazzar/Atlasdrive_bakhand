<template>
  <nav class="sticky top-0 z-50 flex items-center justify-between px-8 h-16 bg-white border-b border-gray-200">

    <!-- Brand -->
    <Link :href="route('home')" class="flex items-center gap-2 no-underline">
      <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M4 20L10 8L16 16L20 10L24 20" stroke="#0d9488" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M2 14L6 10" stroke="#0d9488" stroke-width="2" stroke-linecap="round"/>
      </svg>
      <span class="font-bold text-xl text-slate-900 tracking-tight" style="font-family:'Sora',sans-serif;">
        Atlas Drive
      </span>
    </Link>

    <!-- Nav Links -->
    <ul class="flex items-center gap-8 list-none m-0 p-0">
      <li v-for="link in navLinks" :key="link.label">
        <Link
          :href="route(link.route)"
          class="text-slate-500 hover:text-teal-600 no-underline text-[0.95rem] font-medium transition-colors duration-200"
          :class="{ 'text-teal-600 font-semibold': $page.url === link.href }"
          style="font-family:'Sora',sans-serif;"
        >
          {{ link.label }}
        </Link>
      </li>
    </ul>

    <!-- Login Button -->
    <Link
      :href="route('login')"
      class="bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-5 py-2 rounded no-underline transition-colors duration-200"
      style="font-family:'Sora',sans-serif;"
    >
      Log In
    </Link>

  </nav>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'

const $page = usePage()

const navLinks = [
  { label: 'Home',     route: 'home',     href: '/'          },
 
]
</script>