<template>
  <Agencydashboard title="Overview" subtitle="Your agency at a glance" :agency="agency">

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
      <div v-for="stat in stats" :key="stat.label"
        class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
          <div class="w-10 h-10 rounded-xl flex items-center justify-center" :style="{ background: stat.color + '18' }">
            <span v-html="stat.icon" :style="{ color: stat.color }"></span>
          </div>
          <span :class="['text-xs font-bold px-2 py-0.5 rounded-full', stat.up ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-500']">
            {{ stat.change }}
          </span>
        </div>
        <p class="text-2xl font-extrabold text-slate-900 leading-none mb-1">{{ stat.value }}</p>
        <p class="text-xs text-slate-400 font-medium">{{ stat.label }}</p>
      </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">

      <!-- Revenue bar chart -->
      <div class="lg:col-span-2 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between mb-4">
          <div>
            <h3 class="text-sm font-bold text-slate-800">Monthly Revenue</h3>
            <p class="text-xs text-slate-400">Last 6 months</p>
          </div>
          <span class="text-xs font-bold text-teal-600 bg-teal-50 px-2 py-1 rounded-lg">+18% vs last year</span>
        </div>
        <div class="flex items-end gap-2 h-36">
          <div v-for="(bar, i) in revenueChart" :key="i" class="flex-1 flex flex-col items-center gap-1">
            <span class="text-xs text-slate-400 font-medium">{{ bar.label }}</span>
            <div class="w-full rounded-t-lg transition-all duration-500 hover:opacity-80 cursor-pointer"
              :style="{ height: (bar.value / maxRevenue * 100) + '%', background: i === revenueChart.length - 1 ? '#0d9488' : '#e0f7f5' }">
            </div>
            <span class="text-xs text-slate-500 font-semibold">${{ bar.value }}k</span>
          </div>
        </div>
      </div>

      <!-- Booking status -->
      <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
        <h3 class="text-sm font-bold text-slate-800 mb-1">Booking Status</h3>
        <p class="text-xs text-slate-400 mb-4">This month</p>
        <div class="flex flex-col gap-3">
          <div v-for="s in bookingStatus" :key="s.label">
            <div class="flex items-center justify-between mb-1">
              <span class="text-xs text-slate-600 font-medium">{{ s.label }}</span>
              <span class="text-xs font-bold text-slate-700">{{ s.count }}</span>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-2">
              <div class="h-2 rounded-full transition-all duration-700"
                :style="{ width: s.pct + '%', background: s.color }"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent bookings -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
        <h3 class="text-sm font-bold text-slate-800">Recent Bookings</h3>
        <Link :href="route('agency.bookings')"
          class="text-xs text-teal-600 font-bold hover:underline no-underline">
          View all →
        </Link>
      </div>
      <table class="w-full">
        <thead class="bg-slate-50">
          <tr>
            <th v-for="h in ['Client','Vehicle','Dates','Amount','Status']" :key="h"
              class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">{{ h }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="b in recentBookings.slice(0,5)" :key="b.id"
            class="border-t border-slate-50 hover:bg-slate-50 transition-colors">
            <td class="px-5 py-3">
              <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                  :style="{ background: b.avatarColor }">{{ b.initials }}</div>
                <span class="text-sm font-semibold text-slate-700">{{ b.client }}</span>
              </div>
            </td>
            <td class="px-5 py-3 text-sm text-slate-600">{{ b.vehicle }}</td>
            <td class="px-5 py-3 text-xs text-slate-500">{{ b.dates }}</td>
            <td class="px-5 py-3 text-sm font-bold text-slate-800">${{ b.amount }}</td>
            <td class="px-5 py-3">
              <span :class="['text-xs font-bold px-2.5 py-1 rounded-full', statusClass(b.status)]">
                {{ b.status }}
              </span>
            </td>
          </tr>
          <tr v-if="recentBookings.length === 0">
            <td colspan="5" class="text-center py-10 text-slate-400 text-sm">No bookings yet.</td>
          </tr>
        </tbody>
      </table>
    </div>

  </Agencydashboard>
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import Agencydashboard from '@/Layouts/Agencydashboard.vue'

const props = defineProps({
  agency:         { type: Object, required: true },
  stats:          { type: Array,  default: () => [] },
  recentBookings: { type: Array,  default: () => [] },
})

// ── Chart data ─────────────────────────────────────────────
const revenueChart = [
  { label: 'Nov', value: 18 }, { label: 'Dec', value: 22 },
  { label: 'Jan', value: 16 }, { label: 'Feb', value: 24 },
  { label: 'Mar', value: 20 }, { label: 'Apr', value: 28 },
]
const maxRevenue = computed(() => Math.max(...revenueChart.map(r => r.value)))

const bookingStatus = [
  { label: 'Confirmed', count: 22, pct: 65, color: '#0d9488' },
  { label: 'Pending',   count: 8,  pct: 24, color: '#f59e0b' },
  { label: 'Cancelled', count: 4,  pct: 11, color: '#ef4444' },
]

// ── Status badge ───────────────────────────────────────────
function statusClass(status) {
  switch (status) {
    case 'Confirmed': return 'bg-emerald-50 text-emerald-700'
    case 'Pending':   return 'bg-yellow-50 text-yellow-600'
    case 'Cancelled': return 'bg-red-50 text-red-500'
    default:          return 'bg-slate-100 text-slate-500'
  }
}
</script>