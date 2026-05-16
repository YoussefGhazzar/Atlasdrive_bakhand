<template>
  <div class="flex h-screen bg-slate-100 overflow-hidden" style="font-family:'Sora',sans-serif;">

    <!-- ── Sidebar ── -->
    <aside :class="[
      'flex flex-col bg-white border-r border-slate-200 transition-all duration-300 flex-shrink-0',
      sidebarOpen ? 'w-60' : 'w-16'
    ]">
      <!-- Brand -->
      <div class="flex items-center gap-3 px-4 py-5 border-b border-slate-100">
        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" class="flex-shrink-0">
          <path d="M4 20L10 8L16 16L20 10L24 20" stroke="#0d9488" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M2 14L6 10" stroke="#0d9488" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <Transition name="fade">
          <span v-if="sidebarOpen" class="font-bold text-slate-900 text-base tracking-tight whitespace-nowrap">
            Atlas Drive
          </span>
        </Transition>
      </div>

      <!-- Nav -->
      <nav class="flex-1 py-4 flex flex-col gap-1 px-2">
        <Link
          v-for="item in navItems" :key="item.route"
          :href="route(item.route)"
          :class="[
            'flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all no-underline',
            isActive(item.route)
              ? 'bg-teal-50 text-teal-600'
              : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700'
          ]"
        >
          <span class="flex-shrink-0" v-html="item.icon"></span>
          <Transition name="fade">
            <span v-if="sidebarOpen" class="text-sm font-semibold whitespace-nowrap">{{ item.label }}</span>
          </Transition>
        </Link>
      </nav>

      <!-- Logout -->
      <div class="px-2 pb-2">
        <Link
          :href="route('logout')"
          method="post"
          as="button"
          :class="[
            'flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all w-full text-left border-none cursor-pointer bg-transparent text-red-400 hover:bg-red-50 hover:text-red-600'
          ]"
        >
          <svg class="flex-shrink-0" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
          </svg>
          <Transition name="fade">
            <span v-if="sidebarOpen" class="text-sm font-semibold whitespace-nowrap">Logout</span>
          </Transition>
        </Link>
      </div>

      <!-- Toggle -->
      <button
        @click="sidebarOpen = !sidebarOpen"
        class="flex items-center justify-center py-4 border-t border-slate-100 bg-transparent border-none cursor-pointer text-slate-400 hover:text-teal-600 transition-colors"
      >
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path v-if="sidebarOpen" d="M15 18l-6-6 6-6"/>
          <path v-else d="M9 18l6-6-6-6"/>
        </svg>
      </button>
    </aside>

    <!-- ── Main ── -->
    <div class="flex-1 flex flex-col overflow-hidden">

      <!-- Topbar -->
      <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-slate-200 flex-shrink-0">
        <div>
          <h1 class="text-lg font-bold text-slate-900">{{ title }}</h1>
          <p class="text-xs text-slate-400 mt-0.5">{{ subtitle }}</p>
        </div>
        <div class="flex items-center gap-3">
          <!-- Notification bell -->
          <button class="relative w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 hover:bg-slate-100 border-none cursor-pointer transition-colors">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
              <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
              <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
          </button>

          <!-- Avatar -->
          <div class="flex items-center gap-2.5 cursor-pointer">
            <div class="w-9 h-9 rounded-xl bg-teal-600 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
              {{ initials }}
            </div>
            <Transition name="fade">
              <div v-if="sidebarOpen">
                <p class="text-sm font-bold text-slate-800 leading-none">{{ client.name }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Client Account</p>
              </div>
            </Transition>
          </div>
        </div>
      </header>

      <!-- Page content injected here -->
      <main class="flex-1 overflow-y-auto p-6">
        <slot />
      </main>

    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const props = defineProps({
  title:    { type: String, default: 'Dashboard' },
  subtitle: { type: String, default: ''          },
  client:   { type: Object, default: () => ({})  },
})

const page        = usePage()
const sidebarOpen = ref(true)

const initials = computed(() => {
  const name = props.client?.name ?? ''
  return name.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2)
})

function isActive(routeName) {
  return page.url.startsWith(route(routeName).replace(window.location.origin, ''))
}

const navItems = [
  {
    route: 'client.dashboard',
    label: 'Overview',
    icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>`,
  },
  {
    route: 'client.active',
    label: 'Active Rental',
    icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>`,
  },
  {
    route: 'client.bookings',
    label: 'My Bookings',
    icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>`,
  },
  
]
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity .15s; }
.fade-enter-from, .fade-leave-to       { opacity: 0; }
</style>