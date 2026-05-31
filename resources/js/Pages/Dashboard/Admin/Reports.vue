<template>
  <AdminDashboardLayout title="Reports" subtitle="Analytics & insights">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

      <!-- Revenue by city -->
      <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
        <h3 class="text-sm font-bold text-slate-800 mb-4">Revenue by City</h3>
        <div class="flex flex-col gap-3">
          <div v-for="c in revenueByCity" :key="c.name">
            <div class="flex items-center justify-between mb-1">
              <span class="text-sm text-slate-600">{{ c.name }}</span>
              <span class="text-sm font-bold text-slate-700">${{ c.value }}k</span>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-2.5">
              <div class="h-2.5 rounded-full bg-teal-500 transition-all duration-700"
                :style="{ width: c.pct + '%' }"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Platform health -->
      <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
        <h3 class="text-sm font-bold text-slate-800 mb-4">Platform Health</h3>
        <div class="flex flex-col gap-0">
          <div v-for="m in platformMetrics" :key="m.label"
            class="flex items-center justify-between py-2.5 border-b border-slate-50 last:border-b-0">
            <span class="text-sm text-slate-600">{{ m.label }}</span>
            <span :class="['text-sm font-bold', m.good ? 'text-emerald-600' : 'text-red-500']">
              {{ m.value }}
            </span>
          </div>
        </div>
      </div>

    </div>

  </AdminDashboardLayout>
</template>

<script setup>
import AdminDashboardLayout from '@/Layouts/AdminDashboardLayout.vue'

defineProps({
  revenueByCity:    { type: Array, default: () => [] },
  platformMetrics:  { type: Array, default: () => [] },
})

const revenueByCity = [
  { name: 'Casablanca', value: 58, pct: 82 },
  { name: 'Marrakech',  value: 28, pct: 40 },
  { name: 'Rabat',      value: 35, pct: 50 },
  { name: 'Tanger',     value: 22, pct: 31 },
  { name: 'Agadir',     value: 24, pct: 34 },
]

const platformMetrics = [
  { label: 'Uptime this month',       value: '99.9%', good: true  },
  { label: 'Avg booking completion',  value: '87%',   good: true  },
  { label: 'Dispute rate',            value: '2.1%',  good: true  },
  { label: 'Agency approval rate',    value: '74%',   good: true  },
  { label: 'Cancelled bookings rate', value: '11%',   good: false },
  { label: 'Avg response time',       value: '1.8h',  good: true  },
]
</script>