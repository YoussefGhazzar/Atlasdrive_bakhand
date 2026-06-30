<template>
  <div class="fixed top-4 left-0 right-0 z-50 flex justify-center px-4 pointer-events-none">
    <nav class="pointer-events-auto w-full max-w-5xl bg-white/80 backdrop-blur-xl border border-white/60 shadow-xl rounded-2xl px-5 h-14 flex items-center justify-between"
      style="box-shadow:0 8px 32px rgba(13,148,136,0.10),0 2px 8px rgba(0,0,0,0.08);">
      <Link :href="route('home')" class="flex items-center gap-2 no-underline">
        <svg width="26" height="26" viewBox="0 0 28 28" fill="none">
          <path d="M4 20L10 8L16 16L20 10L24 20" stroke="#0d9488" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M2 14L6 10" stroke="#0d9488" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <span class="font-bold text-lg text-slate-900 tracking-tight" style="font-family:'Sora',sans-serif;">Atlas<span class="text-teal-600">Drive</span></span>
      </Link>
      <ul class="flex items-center gap-1 list-none m-0 p-0">
        <li v-for="link in navLinks" :key="link.label">
          <Link :href="route(link.route)"
            class="text-slate-500 hover:text-slate-900 no-underline text-sm font-medium px-3.5 py-1.5 rounded-xl transition-all duration-200 hover:bg-slate-100"
            :class="{ 'text-teal-600 font-semibold bg-teal-50 hover:bg-teal-50 hover:text-teal-600': $page.url === route(link.route) }">
            {{ link.label }}
          </Link>
        </li>
      </ul>
      <div class="flex items-center gap-2">
        <Link :href="route('login')" class="text-slate-600 hover:text-teal-600 font-semibold text-sm px-4 py-1.5 rounded-xl no-underline transition-colors duration-200 hover:bg-slate-100">Log In</Link>
        <Link :href="route('register.client')" class="bg-teal-600 hover:bg-teal-700 active:translate-y-px text-white font-semibold text-sm px-4 py-1.5 rounded-xl no-underline transition-all duration-150">Sign Up</Link>
      </div>
    </nav>
  </div>
</template>

<script setup>
import { Link, usePage } from "@inertiajs/vue3"
const $page = usePage()
const navLinks = [
  { label: "Home",     route: "home"     },
  { label: "Fleet",    route: "fleet"    },
  { label: "Services", route: "services" },
  { label: "Contact",  route: "contact"  },
]
</script>
