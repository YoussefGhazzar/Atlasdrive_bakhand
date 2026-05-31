<template>
  <AdminDashboardLayout title="Bookings" subtitle="All platform bookings">

    <div class="flex gap-2 mb-5 flex-wrap">
      <button v-for="f in ['All','Active','Confirmed','Pending','Completed','Cancelled']" :key="f"
        @click="activeFilter = f"
        :class="[
          'text-xs font-bold px-4 py-2 rounded-xl border-none cursor-pointer transition-all',
          activeFilter === f
            ? 'bg-teal-600 text-white'
            : 'bg-white text-slate-500 hover:bg-slate-50 border border-slate-200'
        ]">
        {{ f }}
      </button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      <table class="w-full">
        <thead class="bg-slate-50">
          <tr>
            <th v-for="h in ['#','Client','Agency','Vehicle','Dates','Total','Status']" :key="h"
              class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">{{ h }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="b in filteredBookings" :key="b.id"
            class="border-t border-slate-50 hover:bg-slate-50 transition-colors">
            <td class="px-5 py-3 text-xs text-slate-400 font-mono">#{{ b.id }}</td>
            <td class="px-5 py-3 text-sm font-semibold text-slate-700">{{ b.client }}</td>
            <td class="px-5 py-3 text-sm text-slate-500">{{ b.agency }}</td>
            <td class="px-5 py-3 text-sm text-slate-600">{{ b.vehicle }}</td>
            <td class="px-5 py-3 text-xs text-slate-500">{{ b.dates }}</td>
            <td class="px-5 py-3 text-sm font-bold text-slate-800">${{ b.total }}</td>
            <td class="px-5 py-3">
              <span :class="['text-xs font-bold px-2.5 py-1 rounded-full', statusClass(b.status)]">
                {{ b.status }}
              </span>
            </td>
          </tr>
          <tr v-if="filteredBookings.length === 0">
            <td colspan="7" class="text-center py-10 text-slate-400 text-sm">No bookings found.</td>
          </tr>
        </tbody>
      </table>
    </div>

  </AdminDashboardLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import AdminDashboardLayout from '@/Layouts/AdminDashboardLayout.vue'

const props = defineProps({
  bookings: { type: Array, default: () => [] },
})

const activeFilter = ref('All')

const filteredBookings = computed(() =>
  activeFilter.value === 'All'
    ? props.bookings
    : props.bookings.filter(b => b.status === activeFilter.value)
)

function statusClass(s) {
  switch (s) {
    case 'Active':    return 'bg-teal-50 text-teal-700'
    case 'Confirmed': return 'bg-emerald-50 text-emerald-700'
    case 'Completed': return 'bg-slate-100 text-slate-600'
    case 'Cancelled': return 'bg-red-50 text-red-500'
    case 'Pending':   return 'bg-yellow-50 text-yellow-600'
    default:          return 'bg-slate-100 text-slate-500'
  }
}
</script>