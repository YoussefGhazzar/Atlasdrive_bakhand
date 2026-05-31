<template>
  <AdminDashboardLayout title="Overview" subtitle="Platform at a glance">

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
      <div v-for="stat in stats" :key="stat.label"
        class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
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

    <!-- Revenue chart + Quick actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

      <div class="lg:col-span-2 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-bold text-slate-800">Platform Revenue</h3>
          <span class="text-xs font-bold text-teal-600 bg-teal-50 px-2 py-1 rounded-lg">+24% this year</span>
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

      <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
        <h3 class="text-sm font-bold text-slate-800 mb-4">Quick Actions</h3>
        <div class="flex flex-col gap-2.5">
          <Link href="/admin/agencies"
            class="flex items-center gap-3 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-xl px-3 py-2.5 cursor-pointer transition-colors no-underline">
            <span class="w-7 h-7 rounded-lg bg-amber-400 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">3</span>
            <span class="text-xs font-semibold text-amber-700">Agencies pending approval</span>
          </Link>
          <Link href="/admin/bookings"
            class="flex items-center gap-3 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-xl px-3 py-2.5 cursor-pointer transition-colors no-underline">
            <span class="w-7 h-7 rounded-lg bg-blue-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">8</span>
            <span class="text-xs font-semibold text-blue-700">Disputed bookings</span>
          </Link>
          <Link href="/admin/users"
            class="flex items-center gap-3 bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-xl px-3 py-2.5 cursor-pointer transition-colors no-underline">
            <span class="w-7 h-7 rounded-lg bg-purple-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">5</span>
            <span class="text-xs font-semibold text-purple-700">New users today</span>
          </Link>
          <Link href="/admin/reports"
            class="flex items-center gap-3 bg-teal-50 hover:bg-teal-100 border border-teal-200 rounded-xl px-3 py-2.5 cursor-pointer transition-colors no-underline">
            <span class="w-7 h-7 rounded-lg bg-teal-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">↗</span>
            <span class="text-xs font-semibold text-teal-700">View full reports</span>
          </Link>
        </div>
      </div>
    </div>

  </AdminDashboardLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import AdminDashboardLayout from '@/Layouts/AdminDashboardLayout.vue'

defineProps({
  stats: { type: Array, default: () => [] },
})

const revenueChart = [
  { label: 'Nov', value: 18 }, { label: 'Dec', value: 26 },
  { label: 'Jan', value: 22 }, { label: 'Feb', value: 30 },
  { label: 'Mar', value: 28 }, { label: 'Apr', value: 36 },
]
const maxRevenue = computed(() => Math.max(...revenueChart.map(r => r.value)))
</script>