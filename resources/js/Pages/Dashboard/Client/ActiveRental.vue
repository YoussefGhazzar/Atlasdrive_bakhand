<template>
  <DashbordClient title="Active Rental" subtitle="Your current rental" :client="client">

    <!-- Active rental exists -->
    <div v-if="activeRental" class="grid grid-cols-1 lg:grid-cols-2 gap-5">

      <!-- Left: Car card -->
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <img :src="activeRental.image" class="w-full h-52 object-cover"/>
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

      <!-- Right: Progress + Contact + Checklist -->
      <div class="flex flex-col gap-4">

        <!-- Progress -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
          <h3 class="text-sm font-bold text-slate-800 mb-4">Rental Progress</h3>
          <div class="flex justify-between text-xs text-slate-400 mb-2">
            <span>{{ activeRental.startDate }}</span>
            <span class="text-teal-600 font-bold">Today</span>
            <span>{{ activeRental.returnDate }}</span>
          </div>
          <div class="w-full bg-slate-100 rounded-full h-3 mb-3">
            <div class="h-3 bg-teal-500 rounded-full transition-all"
              :style="{ width: activeRental.progress + '%' }"></div>
          </div>
          <p class="text-xs text-slate-400 text-center">{{ activeRental.progress }}% of rental period used</p>
        </div>

        <!-- Agency contact -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
          <h3 class="text-sm font-bold text-slate-800 mb-3">Agency Contact</h3>
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-teal-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
              CA
            </div>
            <div>
              <p class="text-sm font-bold text-slate-800">{{ activeRental.agency }}</p>
              <p class="text-xs text-slate-400">{{ activeRental.city }}</p>
            </div>
          </div>
          <div class="flex gap-2">
            <button class="flex-1 flex items-center justify-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold py-2.5 rounded-xl border-none cursor-pointer transition-colors"
              style="font-family:'Sora',sans-serif;">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.63A2 2 0 012 .18h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z"/>
              </svg>
              Call Agency
            </button>
            <button class="flex-1 flex items-center justify-center gap-2 border border-slate-200 hover:border-teal-500 text-slate-600 hover:text-teal-600 text-xs font-bold py-2.5 rounded-xl bg-white cursor-pointer transition-all"
              style="font-family:'Sora',sans-serif;">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                <polyline points="22,6 12,13 2,6"/>
              </svg>
              Send Email
            </button>
          </div>
        </div>

        <!-- Return checklist -->
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

    <!-- No active rental -->
    <div v-else class="flex flex-col items-center justify-center py-24 bg-white rounded-2xl border border-slate-200">
      <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.2">
        <rect x="2" y="9" width="20" height="9" rx="2"/>
        <path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/>
        <circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/>
      </svg>
      <p class="text-slate-400 font-semibold mt-4">No active rental right now</p>
      <Link :href="route('fleet')"
        class="mt-3 bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold px-5 py-2.5 rounded-xl no-underline transition-colors"
        style="font-family:'Sora',sans-serif;">
        Browse Fleet
      </Link>
    </div>

  </DashbordClient>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import DashbordClient from '@/Layouts/DashbordClient.vue'

defineProps({
  client:       { type: Object, required: true },
  activeRental: { type: Object, default: null  },
})

const checklist = [
  'Full fuel tank',
  'No new scratches or damage',
  'All personal belongings removed',
  'Return keys to agency',
]
</script>