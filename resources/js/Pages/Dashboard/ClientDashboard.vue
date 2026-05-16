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
        <span v-if="sidebarOpen" class="font-bold text-slate-900 text-base tracking-tight whitespace-nowrap">Atlas Drive</span>
      </div>

      <!-- Nav -->
      <nav class="flex-1 py-4 flex flex-col gap-1 px-2">
        <button
          v-for="item in navItems" :key="item.key"
          @click="activeTab = item.key"
          :class="[
            'flex items-center gap-3 px-3 py-2.5 rounded-xl border-none cursor-pointer transition-all text-left w-full',
            activeTab === item.key
              ? 'bg-teal-50 text-teal-600'
              : 'bg-transparent text-slate-500 hover:bg-slate-50 hover:text-slate-700'
          ]"
        >
          <span class="flex-shrink-0" v-html="item.icon"></span>
          <span v-if="sidebarOpen" class="text-sm font-semibold whitespace-nowrap">{{ item.label }}</span>
        </button>
      </nav>

      <!-- Logout -->
      <div class="px-2 pb-2">
        <Link
          :href="route('logout')"
          method="post"
          as="button"
          class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all w-full text-left border-none cursor-pointer bg-transparent text-red-400 hover:bg-red-50 hover:text-red-600"
        >
          <svg class="flex-shrink-0" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
            <polyline points="16 17 21 12 16 7"/>
            <line x1="21" y1="12" x2="9" y2="12"/>
          </svg>
          <span v-if="sidebarOpen" class="text-sm font-semibold whitespace-nowrap">Logout</span>
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
          <h1 class="text-lg font-bold text-slate-900">{{ currentTab.label }}</h1>
          <p class="text-xs text-slate-400 mt-0.5">{{ currentTab.subtitle }}</p>
        </div>
        <div class="flex items-center gap-3">
          <button class="relative w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 hover:bg-slate-100 border-none cursor-pointer transition-colors">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
              <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
              <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
          </button>
          <div class="flex items-center gap-2.5 cursor-pointer">
            <div class="w-9 h-9 rounded-xl bg-teal-600 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
              {{ initials }}
            </div>
            <div v-if="sidebarOpen">
              <p class="text-sm font-bold text-slate-800 leading-none">{{ client.name }}</p>
              <p class="text-xs text-slate-400 mt-0.5">Client Account</p>
            </div>
          </div>
        </div>
      </header>

      <main class="flex-1 overflow-y-auto p-6">

        <!-- ── OVERVIEW ── -->
        <div v-if="activeTab === 'overview'">
          <!-- Stats -->
          <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div v-for="stat in stats" :key="stat.label"
              class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
              <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3"
                :style="{ background: stat.color + '18' }">
                <span v-html="stat.icon" :style="{ color: stat.color }"></span>
              </div>
              <p class="text-2xl font-extrabold text-slate-900 leading-none mb-1">{{ stat.value }}</p>
              <p class="text-xs text-slate-400 font-medium">{{ stat.label }}</p>
            </div>
          </div>

          <!-- Active Rental Banner -->
          <div v-if="activeRental"
            class="bg-gradient-to-r from-teal-600 to-teal-500 rounded-2xl p-5 mb-6 relative overflow-hidden">
            <div class="flex items-center justify-between relative z-10">
              <div>
                <span class="text-xs font-bold text-teal-100 uppercase tracking-widest">🚗 Active Rental</span>
                <h3 class="text-xl font-extrabold text-white mt-1">{{ activeRental.car }}</h3>
                <p class="text-teal-100 text-sm mt-0.5">
                  Return by <span class="font-bold text-white">{{ activeRental.returnDate }}</span>
                </p>
              </div>
              <div class="bg-white/20 rounded-xl px-4 py-2 backdrop-blur-sm text-right">
                <p class="text-xs text-teal-100">Days remaining</p>
                <p class="text-3xl font-extrabold text-white">{{ activeRental.daysLeft }}</p>
              </div>
            </div>
            <div class="mt-4">
              <div class="flex justify-between text-xs text-teal-100 mb-1">
                <span>{{ activeRental.startDate }}</span>
                <span>{{ activeRental.returnDate }}</span>
              </div>
              <div class="w-full bg-white/20 rounded-full h-2">
                <div class="h-2 bg-white rounded-full" :style="{ width: activeRental.progress + '%' }"></div>
              </div>
            </div>
          </div>

          <!-- Recent Bookings -->
          <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
              <h3 class="text-sm font-bold text-slate-800">Recent Bookings</h3>
              <button @click="activeTab = 'bookings'"
                class="text-xs text-teal-600 font-bold hover:underline bg-transparent border-none cursor-pointer">
                View all →
              </button>
            </div>
            <div v-if="bookings.length === 0" class="px-5 py-10 text-center text-slate-400 text-sm">
              No bookings yet.
            </div>
            <table v-else class="w-full">
              <thead class="bg-slate-50">
                <tr>
                  <th v-for="h in ['Vehicle','Agency','Dates','Total','Status']" :key="h"
                    class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">
                    {{ h }}
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="b in bookings.slice(0,4)" :key="b.id"
                  class="border-t border-slate-50 hover:bg-slate-50 transition-colors">
                  <td class="px-5 py-3">
                    <div class="flex items-center gap-3">
                      <img v-if="b.image" :src="b.image" class="w-12 h-9 object-cover rounded-lg flex-shrink-0"/>
                      <span class="text-sm font-bold text-slate-800">{{ b.car }}</span>
                    </div>
                  </td>
                  <td class="px-5 py-3 text-sm text-slate-500">{{ b.agency }}</td>
                  <td class="px-5 py-3 text-xs text-slate-500">{{ b.dates }}</td>
                  <td class="px-5 py-3 text-sm font-bold text-slate-800">${{ b.total }}</td>
                  <td class="px-5 py-3">
                    <span :class="['text-xs font-bold px-2.5 py-1 rounded-full', statusClass(b.status)]">
                      {{ b.status }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- ── BOOKINGS ── -->
        <div v-else-if="activeTab === 'bookings'">
          <div class="flex gap-2 mb-5 flex-wrap">
            <button v-for="f in ['All','Active','Confirmed','Completed','Cancelled']" :key="f"
              @click="bookingFilter = f"
              :class="[
                'text-xs font-bold px-4 py-2 rounded-xl border-none cursor-pointer transition-all',
                bookingFilter === f
                  ? 'bg-teal-600 text-white'
                  : 'bg-white text-slate-500 hover:bg-slate-50 border border-slate-200'
              ]">
              {{ f }}
            </button>
          </div>

          <div v-if="filteredBookings.length === 0"
            class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl border border-slate-200">
            <p class="text-slate-400 font-semibold">No bookings found</p>
          </div>

          <div class="flex flex-col gap-4">
            <div v-for="b in filteredBookings" :key="b.id"
              class="bg-white rounded-2xl border border-slate-200 shadow-sm flex overflow-hidden hover:border-teal-300 transition-all">
              <img v-if="b.image" :src="b.image" class="w-44 object-cover flex-shrink-0"/>
              <div class="flex-1 p-5">
                <div class="flex items-start justify-between mb-2">
                  <div>
                    <h3 class="text-base font-extrabold text-slate-900">{{ b.car }}</h3>
                    <p class="text-xs text-slate-400 mt-0.5">{{ b.agency }} · {{ b.city }}</p>
                  </div>
                  <span :class="['text-xs font-bold px-3 py-1 rounded-full', statusClass(b.status)]">
                    {{ b.status }}
                  </span>
                </div>
                <div class="flex items-center gap-5 mt-3 flex-wrap text-xs text-slate-500">
                  <span>📅 {{ b.dates }}</span>
                  <span>⏱ {{ b.days }} days</span>
                  <span>📍 {{ b.city }}</span>
                </div>
              </div>
              <div class="flex flex-col items-end justify-between p-5 border-l border-slate-100 min-w-[8rem]">
                <div class="text-right">
                  <p class="text-2xl font-extrabold text-slate-900">${{ b.total }}</p>
                  <p class="text-xs text-slate-400">{{ b.days }} days</p>
                </div>
                <button v-if="b.status === 'Completed'"
                  class="text-xs font-bold text-teal-600 hover:underline bg-transparent border-none cursor-pointer">
                  Leave Review
                </button>
                <button v-else-if="b.status === 'Confirmed'"
                  class="text-xs font-bold text-red-400 hover:underline bg-transparent border-none cursor-pointer">
                  Cancel
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- ── ACTIVE RENTAL ── -->
        <div v-else-if="activeTab === 'active'">
          <div v-if="activeRental" class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
              <img v-if="activeRental.image" :src="activeRental.image" class="w-full h-52 object-cover"/>
              <div class="p-5">
                <h2 class="text-xl font-extrabold text-slate-900 mb-0.5">{{ activeRental.car }}</h2>
                <p class="text-sm text-slate-400 mb-4">{{ activeRental.agency }} · {{ activeRental.city }}</p>
                <div class="grid grid-cols-2 gap-3">
                  <div class="bg-slate-50 rounded-xl p-3">
                    <p class="text-xs text-slate-400 mb-0.5">Pick-up</p>
                    <p class="text-sm font-bold text-slate-800">{{ activeRental.startDate }}</p>
                  </div>
                  <div class="bg-slate-50 rounded-xl p-3">
                    <p class="text-xs text-slate-400 mb-0.5">Return</p>
                    <p class="text-sm font-bold text-slate-800">{{ activeRental.returnDate }}</p>
                  </div>
                  <div class="bg-slate-50 rounded-xl p-3">
                    <p class="text-xs text-slate-400 mb-0.5">Days left</p>
                    <p class="text-sm font-bold text-teal-600">{{ activeRental.daysLeft }} days</p>
                  </div>
                  <div class="bg-slate-50 rounded-xl p-3">
                    <p class="text-xs text-slate-400 mb-0.5">Total paid</p>
                    <p class="text-sm font-bold text-slate-800">${{ activeRental.total }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex flex-col gap-4">
              <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                <h3 class="text-sm font-bold text-slate-800 mb-4">Rental Progress</h3>
                <div class="w-full bg-slate-100 rounded-full h-3 mb-2">
                  <div class="h-3 bg-teal-500 rounded-full" :style="{ width: activeRental.progress + '%' }"></div>
                </div>
                <p class="text-xs text-slate-400 text-center">{{ activeRental.progress }}% of rental period used</p>
              </div>
              <div class="bg-teal-50 border border-teal-100 rounded-2xl p-5">
                <h3 class="text-sm font-bold text-teal-700 mb-3">📋 Return Checklist</h3>
                <div class="flex flex-col gap-2">
                  <label v-for="item in checklist" :key="item" class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" class="accent-teal-600 w-3.5 h-3.5"/>
                    <span class="text-xs text-teal-700">{{ item }}</span>
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="flex flex-col items-center justify-center py-24 bg-white rounded-2xl border border-slate-200">
            <p class="text-slate-400 font-semibold mt-4">No active rental right now</p>
          </div>
        </div>

        <!-- ── PROFILE ── -->
        <div v-else-if="activeTab === 'profile'">
          <div class="max-w-lg">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
              <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
                <div class="w-16 h-16 rounded-2xl bg-teal-600 flex items-center justify-center text-white text-2xl font-extrabold">
                  {{ initials }}
                </div>
                <div>
                  <h2 class="text-lg font-bold text-slate-900">{{ client.name }}</h2>
                  <p class="text-sm text-slate-400">Client Account</p>
                </div>
              </div>

              <Transition name="fade-down">
                <div v-if="saved"
                  class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-2.5 rounded-xl mb-4">
                  ✅ Profile updated successfully!
                </div>
              </Transition>

              <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-1.5">
                  <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Full Name</label>
                  <input v-model="profileForm.name" type="text"
                    class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors"/>
                </div>
                <div class="flex flex-col gap-1.5">
                  <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Email</label>
                  <input v-model="profileForm.email" type="email"
                    class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors"/>
                </div>
                <div class="flex flex-col gap-1.5">
                  <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Phone</label>
                  <input v-model="profileForm.phone" type="tel"
                    class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors"/>
                </div>
                <div class="flex flex-col gap-1.5">
                  <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">City</label>
                  <input v-model="profileForm.city" type="text"
                    class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors"/>
                </div>
                <button @click="handleSave" :disabled="profileForm.processing"
                  class="w-full bg-teal-600 hover:bg-teal-700 disabled:opacity-50 text-white font-bold text-sm py-3 rounded-xl border-none cursor-pointer transition-colors mt-2">
                  {{ profileForm.processing ? 'Saving...' : 'Save Changes' }}
                </button>
              </div>
            </div>
          </div>
        </div>

      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'

// ── Props from Laravel controller ──────────────────────────
const props = defineProps({
  client:       { type: Object, default: () => ({}) },
  bookings:     { type: Array,  default: () => []   },
  activeRental: { type: Object, default: null        },
  stats:        { type: Array,  default: () => []    },
})

// ── State ──────────────────────────────────────────────────
const sidebarOpen   = ref(true)
const activeTab     = ref('overview')
const bookingFilter = ref('All')
const saved         = ref(false)

// ── Computed ───────────────────────────────────────────────
const initials = computed(() =>
  (props.client?.name ?? 'U')
    .split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2)
)

const filteredBookings = computed(() =>
  bookingFilter.value === 'All'
    ? props.bookings
    : props.bookings.filter(b => b.status === bookingFilter.value)
)

// ── Nav ────────────────────────────────────────────────────
const navItems = [
  { key: 'overview', label: 'Overview',      subtitle: 'Your rental summary',
    icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>` },
  { key: 'active',   label: 'Active Rental', subtitle: 'Your current rental',
    icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>` },
  { key: 'bookings', label: 'My Bookings',   subtitle: 'All your reservations',
    icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>` },
  { key: 'profile',  label: 'Profile',       subtitle: 'Your account settings',
    icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>` },
]

const currentTab = computed(() => navItems.find(n => n.key === activeTab.value) ?? navItems[0])

// ── Static data fallbacks (shown when DB has no data yet) ──
const stats = computed(() =>
  props.stats.length ? props.stats : [
    { label: 'Total Bookings', value: '0',   color: '#0d9488', icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>` },
    { label: 'Total Spent',    value: '$0',  color: '#6366f1', icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>` },
    { label: 'Days Rented',    value: '0',   color: '#f59e0b', icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>` },
    { label: 'Avg Rating',     value: '—',   color: '#ec4899', icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>` },
  ]
)

const checklist = [
  'Full fuel tank',
  'No new scratches or damage',
  'All personal belongings removed',
  'Return keys to agency',
]

// ── Profile form ───────────────────────────────────────────
const profileForm = useForm({
  name:  props.client?.name  ?? '',
  email: props.client?.email ?? '',
  phone: props.client?.phone ?? '',
  city:  props.client?.city  ?? '',
})

function handleSave() {
  profileForm.patch(route('client.profile.update'), {
    onSuccess: () => {
      saved.value = true
      setTimeout(() => { saved.value = false }, 3000)
    },
  })
}

// ── Status badge ───────────────────────────────────────────
function statusClass(status) {
  switch (status) {
    case 'Active':    return 'bg-teal-50 text-teal-700'
    case 'Confirmed': return 'bg-emerald-50 text-emerald-700'
    case 'Completed': return 'bg-slate-100 text-slate-600'
    case 'Cancelled': return 'bg-red-50 text-red-500'
    case 'Pending':   return 'bg-yellow-50 text-yellow-600'
    default:          return 'bg-slate-100 text-slate-500'
  }
}
</script>

<style scoped>
.fade-down-enter-active { animation: fadeDown .3s ease; }
.fade-down-leave-active { transition: opacity .2s; }
.fade-down-leave-to     { opacity: 0; }
@keyframes fadeDown {
  from { opacity: 0; transform: translateY(-6px); }
  to   { opacity: 1; }
}
</style>