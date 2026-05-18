<template>
  <AgencyDashboardLayout title="Fleet" subtitle="Manage your vehicles" :agency="agency">

    <div class="flex items-center justify-between mb-5">
      <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-3 py-2 w-72 shadow-sm">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2">
          <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
        </svg>
        <input v-model="fleetSearch" type="text" placeholder="Search vehicles..."
          class="flex-1 border-none outline-none text-sm text-slate-700 bg-transparent placeholder-slate-400"/>
      </div>
      <button class="flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold px-4 py-2.5 rounded-xl border-none cursor-pointer transition-colors">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Add Vehicle
      </button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      <table class="w-full">
        <thead class="bg-slate-50">
          <tr>
            <th v-for="h in ['Vehicle','Category','Price/day','Status','Bookings','Actions']" :key="h"
              class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">{{ h }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="car in filteredFleet" :key="car.id"
            class="border-t border-slate-50 hover:bg-slate-50 transition-colors">
            <td class="px-5 py-3">
              <div class="flex items-center gap-3">
                <img :src="car.image" :alt="car.name" class="w-12 h-9 object-cover rounded-lg flex-shrink-0"/>
                <div>
                  <p class="text-sm font-bold text-slate-800">{{ car.name }}</p>
                  <p class="text-xs text-slate-400">{{ car.year }}</p>
                </div>
              </div>
            </td>
            <td class="px-5 py-3">
              <span class="text-xs font-semibold text-teal-600 bg-teal-50 border border-teal-100 px-2 py-0.5 rounded-full">
                {{ car.category }}
              </span>
            </td>
            <td class="px-5 py-3 text-sm font-bold text-slate-700">${{ car.pricePerDay }}</td>
            <td class="px-5 py-3">
              <span :class="['text-xs font-bold px-2.5 py-1 rounded-full', car.available ? 'bg-emerald-50 text-emerald-700' : 'bg-orange-50 text-orange-600']">
                {{ car.available ? 'Available' : 'Rented' }}
              </span>
            </td>
            <td class="px-5 py-3 text-sm text-slate-600">{{ car.totalBookings }}</td>
            <td class="px-5 py-3">
              <div class="flex items-center gap-2">
                <button class="text-xs font-bold text-teal-600 hover:text-teal-700 bg-transparent border-none cursor-pointer">Edit</button>
                <span class="text-slate-200">|</span>
                <button class="text-xs font-bold text-red-400 hover:text-red-500 bg-transparent border-none cursor-pointer">Remove</button>
              </div>
            </td>
          </tr>
          <tr v-if="filteredFleet.length === 0">
            <td colspan="6" class="text-center py-12 text-slate-400 text-sm">No vehicles found.</td>
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
  agency: { type: Object, required: true },
  fleet:  { type: Array,  default: () => [] },
})

const fleetSearch = ref('')

const filteredFleet = computed(() => {
  const q = fleetSearch.value.toLowerCase()
  return props.fleet.filter(c =>
    !q || c.name.toLowerCase().includes(q) || c.category.toLowerCase().includes(q)
  )
})
</script>