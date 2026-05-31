<template>
  <DashbordClient title="My Bookings" subtitle="All your reservations" :client="client">

    <!-- Filter tabs -->
    <div class="flex gap-2 mb-5 flex-wrap">
      <button
        v-for="f in filters" :key="f"
        @click="activeFilter = f"
        :class="[
          'text-xs font-bold px-4 py-2 rounded-xl border-none cursor-pointer transition-all',
          activeFilter === f
            ? 'bg-teal-600 text-white'
            : 'bg-white text-slate-500 hover:bg-slate-50 border border-slate-200'
        ]"
        style="font-family:'Sora',sans-serif;">
        {{ f }}
        <span v-if="f !== 'All'" class="ml-1 opacity-60">({{ countByStatus(f) }})</span>
      </button>
    </div>

    <!-- Empty state -->
    <div v-if="filteredBookings.length === 0"
      class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl border border-slate-200">
      <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.2">
        <rect x="3" y="4" width="18" height="18" rx="2"/>
        <line x1="16" y1="2" x2="16" y2="6"/>
        <line x1="8" y1="2" x2="8" y2="6"/>
        <line x1="3" y1="10" x2="21" y2="10"/>
      </svg>
      <p class="text-slate-400 font-semibold mt-4">No {{ activeFilter.toLowerCase() }} bookings</p>
    </div>

    <!-- Booking cards -->
    <div class="flex flex-col gap-4">
      <div v-for="b in filteredBookings" :key="b.id"
        class="bg-white rounded-2xl border border-slate-200 shadow-sm flex overflow-hidden hover:border-teal-300 transition-all duration-200">
        <img :src="b.image" class="w-44 object-cover flex-shrink-0"/>
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
          <div class="flex items-center gap-5 mt-3 flex-wrap">
            <div class="flex items-center gap-1.5">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
              </svg>
              <span class="text-xs text-slate-500">{{ b.dates }}</span>
            </div>
            <div class="flex items-center gap-1.5">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
              </svg>
              <span class="text-xs text-slate-500">{{ b.days }} days</span>
            </div>
            <div class="flex items-center gap-1.5">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                <circle cx="12" cy="10" r="3"/>
              </svg>
              <span class="text-xs text-slate-500">{{ b.city }}</span>
            </div>
          </div>
        </div>
        <div class="flex flex-col items-end justify-between p-5 border-l border-slate-100 min-w-[8rem]">
          <div class="text-right">
            <p class="text-2xl font-extrabold text-slate-900">${{ b.total }}</p>
            <p class="text-xs text-slate-400">{{ b.days }} days</p>
          </div>
          <button v-if="b.status === 'Completed'"
            class="text-xs font-bold text-teal-600 hover:underline bg-transparent border-none cursor-pointer"
            style="font-family:'Sora',sans-serif;">
            Leave Review
          </button>
          <button v-else-if="b.status === 'Confirmed'"
            class="text-xs font-bold text-red-400 hover:underline bg-transparent border-none cursor-pointer"
            style="font-family:'Sora',sans-serif;">
            Cancel
          </button>
        </div>
      </div>
    </div>

  </DashbordClient>
</template>

<script setup>
import { ref, computed } from 'vue'
import DashbordClient from '@/Layouts/DashbordClient.vue'

const props = defineProps({
  client:   { type: Object, required: true },
  bookings: { type: Array,  default: () => [] },
})

const filters      = ['All', 'Active', 'Confirmed', 'Completed', 'Cancelled']
const activeFilter = ref('All')

const filteredBookings = computed(() =>
  activeFilter.value === 'All'
    ? props.bookings
    : props.bookings.filter(b => b.status === activeFilter.value)
)

function countByStatus(status) {
  return props.bookings.filter(b => b.status === status).length
}

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