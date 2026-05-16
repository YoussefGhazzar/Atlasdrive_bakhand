<template>
  <DashbordClient title="Overview" subtitle="Your rental summary" :client="client">

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
      <div class="absolute right-0 top-0 w-48 h-full opacity-10">
        <svg viewBox="0 0 200 100" fill="white">
          <rect x="2" y="30" width="160" height="55" rx="12"/>
          <path d="M20 30V22a16 16 0 0116-16h80a16 16 0 0116 16v8"/>
          <circle cx="40" cy="85" r="14"/><circle cx="130" cy="85" r="14"/>
        </svg>
      </div>
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
          <div class="h-2 bg-white rounded-full transition-all"
            :style="{ width: activeRental.progress + '%' }"></div>
        </div>
      </div>
    </div>

    <!-- Recent Bookings Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
        <h3 class="text-sm font-bold text-slate-800">Recent Bookings</h3>
        <Link :href="route('client.bookings')"
          class="text-xs text-teal-600 font-bold hover:underline no-underline"
          style="font-family:'Sora',sans-serif;">
          View all →
        </Link>
      </div>
      <table class="w-full">
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
                <img :src="b.image" class="w-12 h-9 object-cover rounded-lg flex-shrink-0"/>
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

  </DashbordClient>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import DashbordClient from '@/Layouts/DashbordClient.vue'

defineProps({
  client:       { type: Object, required: true },
  bookings:     { type: Array,  default: () => [] },
  activeRental: { type: Object, default: null },
  stats:        { type: Array,  default: () => [] },
})

// Inline statusClass — no external import needed
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