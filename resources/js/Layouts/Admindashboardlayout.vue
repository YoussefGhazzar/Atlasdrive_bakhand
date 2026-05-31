<template>
  <div class="flex h-screen bg-slate-100 overflow-hidden" style="font-family:'Sora',sans-serif;">

    <!-- ── Sidebar ── -->
    <aside :class="[
      'flex flex-col border-r border-slate-800 transition-all duration-300 flex-shrink-0',
      sidebarOpen ? 'w-60' : 'w-16'
    ]" style="background:#0f172a">

      <div class="flex items-center gap-3 px-4 py-5 border-b border-slate-700">
        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" class="flex-shrink-0">
          <path d="M4 20L10 8L16 16L20 10L24 20" stroke="#0d9488" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M2 14L6 10" stroke="#0d9488" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <Transition name="fade">
          <div v-if="sidebarOpen">
            <p class="font-bold text-white text-sm tracking-tight whitespace-nowrap">Atlas Drive</p>
            <p class="text-xs text-slate-400">Admin Panel</p>
          </div>
        </Transition>
      </div>

      <nav class="flex-1 py-4 flex flex-col gap-1 px-2 overflow-y-auto">
        <Link v-for="item in navItems" :key="item.href"
          :href="item.href"
          :class="[
            'flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 no-underline',
            page.url.startsWith(item.match)
              ? 'bg-teal-600 text-white'
              : 'bg-transparent text-slate-400 hover:bg-slate-800 hover:text-white'
          ]">
          <span class="flex-shrink-0" v-html="item.icon"></span>
          <Transition name="fade">
            <span v-if="sidebarOpen" class="text-sm font-semibold whitespace-nowrap flex-1">{{ item.label }}</span>
          </Transition>
          <Transition name="fade">
            <span v-if="sidebarOpen && item.badge"
              class="ml-auto text-xs font-bold bg-red-500 text-white px-1.5 py-0.5 rounded-full">
              {{ item.badge }}
            </span>
          </Transition>
        </Link>
      </nav>

      <!-- Logout -->
      <div class="px-2 pb-2">
        <Link :href="route('logout')" method="post" as="button"
          class="flex items-center gap-3 px-3 py-2.5 rounded-xl w-full text-left border-none cursor-pointer bg-transparent text-red-400 hover:bg-slate-800 hover:text-red-300 transition-all">
          <svg class="flex-shrink-0" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
            <polyline points="16 17 21 12 16 7"/>
            <line x1="21" y1="12" x2="9" y2="12"/>
          </svg>
          <Transition name="fade">
            <span v-if="sidebarOpen" class="text-sm font-semibold whitespace-nowrap">Logout</span>
          </Transition>
        </Link>
      </div>

      <button @click="sidebarOpen = !sidebarOpen"
        class="flex items-center justify-center py-4 border-t border-slate-700 bg-transparent border-none cursor-pointer text-slate-500 hover:text-teal-400 transition-colors">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path v-if="sidebarOpen" d="M15 18l-6-6 6-6"/>
          <path v-else d="M9 18l6-6-6-6"/>
        </svg>
      </button>
    </aside>

    <!-- ── Main ── -->
    <div class="flex-1 flex flex-col overflow-hidden">

      <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-slate-200 flex-shrink-0">
        <div>
          <h1 class="text-lg font-bold text-slate-900">{{ title }}</h1>
          <p class="text-xs text-slate-400 mt-0.5">{{ subtitle }}</p>
        </div>
        <div class="flex items-center gap-3">
          <button class="relative w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 hover:bg-slate-100 border-none cursor-pointer transition-colors">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
              <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
              <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
          </button>
          <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white text-sm font-bold flex-shrink-0"
              style="background:#0f172a">AD</div>
            <Transition name="fade">
              <div v-if="sidebarOpen">
                <p class="text-sm font-bold text-slate-800 leading-none">Super Admin</p>
                <p class="text-xs text-slate-400 mt-0.5">Full Access</p>
              </div>
            </Transition>
          </div>
        </div>
      </header>

      <main class="flex-1 overflow-y-auto p-6">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

defineProps({
  title:    { type: String, default: 'Dashboard' },
  subtitle: { type: String, default: ''          },
})

const page        = usePage()
const sidebarOpen = ref(true)

const navItems = [
  { label: 'Overview',  href: '/admin/overview',  match: '/admin/overview',
    icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>` },
  { label: 'Agencies',  href: '/admin/agencies',  match: '/admin/agencies',  badge: '3',
    icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>` },
  { label: 'Users',     href: '/admin/users',     match: '/admin/users',
    icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>` },
  { label: 'Bookings',  href: '/admin/bookings',  match: '/admin/bookings',
    icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>` },
  { label: 'Reports',   href: '/admin/reports',   match: '/admin/reports',
    icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>` },
]
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity .15s; }
.fade-enter-from, .fade-leave-to       { opacity: 0; }
</style>