<template>
  <AdminDashboardLayout title="Agencies" subtitle="Manage partner agencies">

    <div class="flex gap-2 mb-5 flex-wrap">
      <button v-for="f in ['All','Verified','Pending','Suspended']" :key="f"
        @click="activeFilter = f"
        :class="[
          'text-xs font-bold px-4 py-2 rounded-xl border-none cursor-pointer transition-all',
          activeFilter === f
            ? 'bg-teal-600 text-white'
            : 'bg-white text-slate-500 hover:bg-slate-50 border border-slate-200'
        ]">
        {{ f }}
        <span v-if="f === 'Pending'" class="ml-1 bg-amber-400 text-white text-xs px-1.5 rounded-full">
          {{ agencies.filter(a => a.status === 'Pending').length }}
        </span>
      </button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      <table class="w-full">
        <thead class="bg-slate-50">
          <tr>
            <th v-for="h in ['Agency','City','Fleet','Rating','Revenue','Status','Actions']" :key="h"
              class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">{{ h }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="a in filteredAgencies" :key="a.id"
            class="border-t border-slate-50 hover:bg-slate-50 transition-colors">
            <td class="px-5 py-3">
              <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                  :style="{ background: a.color }">{{ a.initials }}</div>
                <div>
                  <p class="text-sm font-bold text-slate-800">{{ a.name }}</p>
                  <p class="text-xs text-slate-400">{{ a.email }}</p>
                </div>
              </div>
            </td>
            <td class="px-5 py-3 text-sm text-slate-600">{{ a.city }}</td>
            <td class="px-5 py-3 text-sm font-semibold text-slate-700">{{ a.fleet }}</td>
            <td class="px-5 py-3">
              <div class="flex items-center gap-1">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="#f59e0b">
                  <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                <span class="text-sm font-bold text-slate-700">{{ a.rating }}</span>
              </div>
            </td>
            <td class="px-5 py-3 text-sm font-bold text-slate-700">{{ a.revenue }}k DH</td>
            <td class="px-5 py-3">
              <span :class="['text-xs font-bold px-2.5 py-1 rounded-full', agencyStatusClass(a.status)]">
                {{ a.status }}
              </span>
            </td>
            <td class="px-5 py-3">
              <div class="flex items-center gap-2">
                <button v-if="a.status === 'Pending'"
                  @click="a.status = 'Verified'"
                  class="text-xs font-bold text-emerald-600 hover:text-emerald-700 bg-transparent border-none cursor-pointer">
                  Approve
                </button>
                <button v-if="a.status === 'Pending'"
                  @click="a.status = 'Suspended'"
                  class="text-xs font-bold text-red-400 hover:text-red-500 bg-transparent border-none cursor-pointer">
                  Reject
                </button>
                <button v-if="a.status === 'Verified'"
                  @click="a.status = 'Suspended'"
                  class="text-xs font-bold text-red-400 hover:text-red-500 bg-transparent border-none cursor-pointer">
                  Suspend
                </button>
                <button v-if="a.status === 'Suspended'"
                  @click="a.status = 'Verified'"
                  class="text-xs font-bold text-teal-600 hover:text-teal-700 bg-transparent border-none cursor-pointer">
                  Restore
                </button>
              </div>
            </td>
          </tr>
          <tr v-if="filteredAgencies.length === 0">
            <td colspan="7" class="text-center py-10 text-slate-400 text-sm">No agencies found.</td>
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
  agencies: { type: Array, default: () => [] },
})

const activeFilter = ref('All')

const agencies = ref(props.agencies)

const filteredAgencies = computed(() =>
  activeFilter.value === 'All'
    ? agencies.value
    : agencies.value.filter(a => a.status === activeFilter.value)
)

function agencyStatusClass(s) {
  switch (s) {
    case 'Verified':  return 'bg-emerald-50 text-emerald-700'
    case 'Pending':   return 'bg-yellow-50 text-yellow-600'
    case 'Suspended': return 'bg-red-50 text-red-500'
    default:          return 'bg-slate-100 text-slate-500'
  }
}
</script>