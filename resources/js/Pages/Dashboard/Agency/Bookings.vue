<template>
  <AgencyDashboardLayout title="Bookings" subtitle="All reservations" :agency="agency">

    <div class="flex gap-2 mb-5 flex-wrap">
      <button v-for="f in ['All','Confirmed','Pending','Cancelled']" :key="f"
        @click="activeFilter = f"
        :class="[
          'text-xs font-bold px-4 py-2 rounded-xl border-none cursor-pointer transition-all',
          activeFilter === f
            ? 'bg-teal-600 text-white'
            : 'bg-white text-slate-500 hover:bg-slate-50 border border-slate-200'
        ]">
        {{ f }}
        <span v-if="f !== 'All'" class="ml-1 opacity-60">({{ bookings.filter(b => b.status === f).length }})</span>
      </button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      <table class="w-full">
        <thead class="bg-slate-50">
          <tr>
            <th v-for="h in ['#','Client','Vehicle','Pick-up','Return','Days','Total','Status']" :key="h"
              class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">{{ h }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="b in filteredBookings" :key="b.id"
            class="border-t border-slate-50 hover:bg-slate-50 transition-colors">
            <td class="px-5 py-3 text-xs text-slate-400 font-mono">#{{ b.id }}</td>
            <td class="px-5 py-3">
              <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                  :style="{ background: b.avatarColor }">{{ b.initials }}</div>
                <span class="text-sm font-semibold text-slate-700">{{ b.client }}</span>
              </div>
            </td>
            <td class="px-5 py-3 text-sm text-slate-600">{{ b.vehicle }}</td>
            <td class="px-5 py-3 text-xs text-slate-500">{{ b.pickup }}</td>
            <td class="px-5 py-3 text-xs text-slate-500">{{ b.return }}</td>
            <td class="px-5 py-3 text-sm font-semibold text-slate-700">{{ b.days }}d</td>
            <td class="px-5 py-3 text-sm font-bold text-slate-800">${{ b.total }}</td>
            <td class="px-5 py-3">
              <span :class="['text-xs font-bold px-2.5 py-1 rounded-full', statusClass(b.status)]">{{ b.status }}</span>
            </td>
          </tr>
          <tr v-if="filteredBookings.length === 0">
            <td colspan="8" class="text-center py-12 text-slate-400 text-sm">No bookings found.</td>
          </tr>
        </tbody>
      </table>
    </div>

  </AgencyDashboardLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import AgencyDashboardLayout from '@/Layouts/Agencydashboard.vue'

const props = defineProps({
  agency:   { type: Object, required: true },
  bookings: { type: Array,  default: () => [] },
})

const activeFilter = ref('All')

const filteredBookings = computed(() =>
  activeFilter.value === 'All'
    ? props.bookings
    : props.bookings.filter(b => b.status === activeFilter.value)
)

function statusClass(status) {
  switch (status) {
    case 'Confirmed': return 'bg-emerald-50 text-emerald-700'
    case 'Pending':   return 'bg-yellow-50 text-yellow-600'
    case 'Cancelled': return 'bg-red-50 text-red-500'
    default:          return 'bg-slate-100 text-slate-500'
  }
}
</script>