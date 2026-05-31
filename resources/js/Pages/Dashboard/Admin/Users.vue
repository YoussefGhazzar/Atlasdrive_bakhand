<template>
  <AdminDashboardLayout title="Users" subtitle="All client accounts">

    <div class="flex items-center justify-between mb-5">
      <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-3 py-2 w-64 shadow-sm">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2">
          <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
        </svg>
        <input v-model="userSearch" type="text" placeholder="Search users..."
          class="flex-1 border-none outline-none text-sm text-slate-700 bg-transparent placeholder-slate-400"/>
      </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      <table class="w-full">
        <thead class="bg-slate-50">
          <tr>
            <th v-for="h in ['User','City','Bookings','Total Spent','Joined','Status','Actions']" :key="h"
              class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">{{ h }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="u in filteredUsers" :key="u.id"
            class="border-t border-slate-50 hover:bg-slate-50 transition-colors">
            <td class="px-5 py-3">
              <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                  :style="{ background: u.color }">{{ u.initials }}</div>
                <div>
                  <p class="text-sm font-semibold text-slate-700">{{ u.name }}</p>
                  <p class="text-xs text-slate-400">{{ u.email }}</p>
                </div>
              </div>
            </td>
            <td class="px-5 py-3 text-sm text-slate-500">{{ u.city }}</td>
            <td class="px-5 py-3 text-sm font-semibold text-slate-700">{{ u.bookings }}</td>
            <td class="px-5 py-3 text-sm font-bold text-slate-700">{{ u.spent }} DH</td>
            <td class="px-5 py-3 text-xs text-slate-400">{{ u.joined }}</td>
            <td class="px-5 py-3">
              <span :class="['text-xs font-bold px-2.5 py-1 rounded-full', u.active ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-500']">
                {{ u.active ? 'Active' : 'Banned' }}
              </span>
            </td>
            <td class="px-5 py-3">
              <button @click="u.active = !u.active"
                :class="['text-xs font-bold bg-transparent border-none cursor-pointer', u.active ? 'text-red-400 hover:text-red-500' : 'text-teal-600 hover:text-teal-700']">
                {{ u.active ? 'Ban' : 'Restore' }}
              </button>
            </td>
          </tr>
          <tr v-if="filteredUsers.length === 0">
            <td colspan="7" class="text-center py-10 text-slate-400 text-sm">No users found.</td>
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
  users: { type: Array, default: () => [] },
})

const userSearch = ref('')
const users      = ref(props.users)

const filteredUsers = computed(() => {
  const q = userSearch.value.toLowerCase()
  return users.value.filter(u =>
    !q || u.name.toLowerCase().includes(q) || u.email.toLowerCase().includes(q)
  )
})
</script>