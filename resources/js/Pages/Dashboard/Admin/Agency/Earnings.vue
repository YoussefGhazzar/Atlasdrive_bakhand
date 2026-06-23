<template>
  <AgencyDashboardLayout title="Earnings" subtitle="Revenue & analytics" :agency="agency">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
      <div v-for="e in earningCards" :key="e.label"
        class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
        <p class="text-xs text-slate-400 font-medium mb-1">{{ e.label }}</p>
        <p class="text-3xl font-extrabold text-slate-900">${{ e.value }}</p>
        <p :class="['text-xs font-bold mt-1', e.up ? 'text-emerald-600' : 'text-red-400']">
          {{ e.change }} vs last month
        </p>
      </div>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
      <h3 class="text-sm font-bold text-slate-800 mb-4">Revenue by Category</h3>
      <div class="flex flex-col gap-3">
        <div v-for="cat in revenueByCategory" :key="cat.name">
          <div class="flex items-center justify-between mb-1">
            <span class="text-sm text-slate-600 font-medium">{{ cat.name }}</span>
            <span class="text-sm font-bold text-slate-700">${{ cat.revenue }}</span>
          </div>
          <div class="w-full bg-slate-100 rounded-full h-2.5">
            <div class="h-2.5 rounded-full transition-all duration-700"
              :style="{ width: cat.pct + '%', background: cat.color }"></div>
          </div>
        </div>
      </div>
    </div>

  </AgencyDashboardLayout>
</template>

<script setup>
import AgencyDashboardLayout from '@/Layouts/Agencydashboard.vue'

defineProps({
  agency:            { type: Object, required: true },
  earningCards:      { type: Array,  default: () => [] },
  revenueByCategory: { type: Array,  default: () => [] },
})
</script>