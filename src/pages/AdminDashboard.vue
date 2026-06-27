<template>
  <div class="flex h-screen bg-slate-100 font-['Sora',sans-serif] overflow-hidden">

    <!-- ── Sidebar ── -->
    <aside :class="['flex flex-col border-r border-slate-800 transition-all duration-300 flex-shrink-0', sidebarOpen ? 'w-60' : 'w-16']"
      style="background:#0f172a">
      <div class="flex items-center gap-3 px-4 py-5 border-b border-slate-700">
        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
          <path d="M4 20L10 8L16 16L20 10L24 20" stroke="#0d9488" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M2 14L6 10" stroke="#0d9488" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <div v-if="sidebarOpen">
          <p class="font-bold text-white text-sm tracking-tight whitespace-nowrap">Atlas Drive</p>
          <p class="text-xs text-slate-400">Admin Panel</p>
        </div>
      </div>

      <nav class="flex-1 py-4 flex flex-col gap-1 px-2 overflow-y-auto">
        <button v-for="item in navItems" :key="item.key"
          @click="activeTab=item.key"
          :class="['flex items-center gap-3 px-3 py-2.5 rounded-xl border-none cursor-pointer transition-all text-left w-full',
            activeTab===item.key ? 'bg-teal-600 text-white' : 'bg-transparent text-slate-400 hover:bg-slate-800 hover:text-white']">
          <span class="flex-shrink-0" v-html="item.icon"></span>
          <span v-if="sidebarOpen" class="text-sm font-semibold whitespace-nowrap">{{ item.label }}</span>
          <span v-if="sidebarOpen && item.badge" class="ml-auto text-xs font-bold bg-red-500 text-white px-1.5 py-0.5 rounded-full">{{ item.badge }}</span>
        </button>
      </nav>

      <button @click="sidebarOpen=!sidebarOpen"
        class="flex items-center justify-center py-4 border-t border-slate-700 bg-transparent border-none cursor-pointer text-slate-500 hover:text-teal-400 transition-colors">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path v-if="sidebarOpen" d="M15 18l-6-6 6-6"/><path v-else d="M9 18l6-6-6-6"/>
        </svg>
      </button>
    </aside>

    <!-- ── Main ── -->
    <div class="flex-1 flex flex-col overflow-hidden">

      <!-- Topbar -->
      <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-slate-200 flex-shrink-0">
        <div>
          <h1 class="text-lg font-bold text-slate-900">{{ currentTab.label }}</h1>
          <p class="text-xs text-slate-400 mt-0.5">{{ currentTab.subtitle }}</p>
        </div>
        <div class="flex items-center gap-3">
          <button class="relative w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 hover:bg-slate-100 border-none cursor-pointer">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
          </button>
          <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white text-sm font-bold" style="background:#0f172a">AD</div>
            <div v-if="sidebarOpen">
              <p class="text-sm font-bold text-slate-800 leading-none">Super Admin</p>
              <p class="text-xs text-slate-400 mt-0.5">Full Access</p>
            </div>
          </div>
        </div>
      </header>

      <main class="flex-1 overflow-y-auto p-6">

        <!-- ── OVERVIEW ── -->
        <div v-if="activeTab==='overview'">
          <div class="grid grid-cols-4 gap-4 mb-6">
            <div v-for="stat in stats" :key="stat.label"
              class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
              <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" :style="{ background: stat.color+'18' }">
                  <span v-html="stat.icon" :style="{ color: stat.color }"></span>
                </div>
                <span :class="['text-xs font-bold px-2 py-0.5 rounded-full', stat.up ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-500']">{{ stat.change }}</span>
              </div>
              <p class="text-2xl font-extrabold text-slate-900 leading-none mb-1">{{ stat.value }}</p>
              <p class="text-xs text-slate-400 font-medium">{{ stat.label }}</p>
            </div>
          </div>

          <!-- Revenue + Pending agencies -->
          <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="col-span-2 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-800">Platform Revenue</h3>
                <span class="text-xs font-bold text-teal-600 bg-teal-50 px-2 py-1 rounded-lg">+24% this year</span>
              </div>
              <div class="flex items-end gap-2 h-36">
                <div v-for="(bar, i) in revenueChart" :key="i" class="flex-1 flex flex-col items-center gap-1">
                  <span class="text-xs text-slate-400 font-medium">{{ bar.label }}</span>
                  <div class="w-full rounded-t-lg transition-all duration-500"
                    :style="{ height: (bar.value/maxRevenue*100)+'%', background: i===5 ? '#0d9488' : '#e0f7f5' }"></div>
                  <span class="text-xs text-slate-500 font-semibold">${{ bar.value }}k</span>
                </div>
              </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
              <h3 class="text-sm font-bold text-slate-800 mb-4">Quick Actions</h3>
              <div class="flex flex-col gap-2.5">
                <button @click="activeTab='agencies'" class="flex items-center gap-3 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-xl px-3 py-2.5 cursor-pointer transition-colors text-left w-full border-none font-['Sora',sans-serif]">
                  <span class="w-7 h-7 rounded-lg bg-amber-400 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">3</span>
                  <span class="text-xs font-semibold text-amber-700">Agencies pending approval</span>
                </button>
                <button @click="activeTab='bookings'" class="flex items-center gap-3 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-xl px-3 py-2.5 cursor-pointer transition-colors text-left w-full border-none font-['Sora',sans-serif]">
                  <span class="w-7 h-7 rounded-lg bg-blue-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">8</span>
                  <span class="text-xs font-semibold text-blue-700">Disputed bookings</span>
                </button>
                <button @click="activeTab='users'" class="flex items-center gap-3 bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-xl px-3 py-2.5 cursor-pointer transition-colors text-left w-full border-none font-['Sora',sans-serif]">
                  <span class="w-7 h-7 rounded-lg bg-purple-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">5</span>
                  <span class="text-xs font-semibold text-purple-700">New users today</span>
                </button>
                <button @click="activeTab='reports'" class="flex items-center gap-3 bg-teal-50 hover:bg-teal-100 border border-teal-200 rounded-xl px-3 py-2.5 cursor-pointer transition-colors text-left w-full border-none font-['Sora',sans-serif]">
                  <span class="w-7 h-7 rounded-lg bg-teal-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">↗</span>
                  <span class="text-xs font-semibold text-teal-700">View full reports</span>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- ── AGENCIES ── -->
        <div v-else-if="activeTab==='agencies'">
          <!-- Filter tabs -->
          <div class="flex gap-2 mb-5">
            <button v-for="f in ['All','Verified','Pending','Suspended']" :key="f"
              @click="agencyFilter=f"
              :class="['text-xs font-bold px-4 py-2 rounded-xl border-none cursor-pointer transition-all font-[\'Sora\',sans-serif]',
                agencyFilter===f ? 'bg-teal-600 text-white' : 'bg-white text-slate-500 hover:bg-slate-50 border border-slate-200']">
              {{ f }}
              <span v-if="f==='Pending'" class="ml-1 bg-amber-400 text-white text-xs px-1.5 rounded-full">3</span>
            </button>
          </div>

          <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full">
              <thead class="bg-slate-50">
                <tr>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Agency</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">City</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Fleet</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Rating</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Revenue</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Status</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="a in filteredAgencies" :key="a.id" class="border-t border-slate-50 hover:bg-slate-50 transition-colors">
                  <td class="px-5 py-3">
                    <div class="flex items-center gap-2.5">
                      <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white text-xs font-bold flex-shrink-0" :style="{ background: a.color }">{{ a.initials }}</div>
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
                      <svg width="12" height="12" viewBox="0 0 24 24" fill="#f59e0b"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                      <span class="text-sm font-bold text-slate-700">{{ a.rating }}</span>
                    </div>
                  </td>
                  <td class="px-5 py-3 text-sm font-bold text-slate-700">${{ a.revenue }}k</td>
                  <td class="px-5 py-3">
                    <span :class="['text-xs font-bold px-2.5 py-1 rounded-full', agencyStatusClass(a.status)]">{{ a.status }}</span>
                  </td>
                  <td class="px-5 py-3">
                    <div class="flex items-center gap-2">
                      <button v-if="a.status==='Pending'"
                        @click="a.status='Verified'"
                        class="text-xs font-bold text-emerald-600 hover:text-emerald-700 bg-transparent border-none cursor-pointer font-['Sora',sans-serif]">Approve</button>
                      <button v-if="a.status==='Pending'"
                        @click="a.status='Suspended'"
                        class="text-xs font-bold text-red-400 hover:text-red-500 bg-transparent border-none cursor-pointer font-['Sora',sans-serif]">Reject</button>
                      <button v-if="a.status==='Verified'"
                        @click="a.status='Suspended'"
                        class="text-xs font-bold text-red-400 hover:text-red-500 bg-transparent border-none cursor-pointer font-['Sora',sans-serif]">Suspend</button>
                      <button v-if="a.status==='Suspended'"
                        @click="a.status='Verified'"
                        class="text-xs font-bold text-teal-600 hover:text-teal-700 bg-transparent border-none cursor-pointer font-['Sora',sans-serif]">Restore</button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- ── USERS ── -->
        <div v-else-if="activeTab==='users'">
          <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-3 py-2 w-64 shadow-sm">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
              <input v-model="userSearch" type="text" placeholder="Search users..." class="flex-1 border-none outline-none text-sm text-slate-700 bg-transparent placeholder-slate-400 font-['Sora',sans-serif]"/>
            </div>
          </div>
          <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full">
              <thead class="bg-slate-50">
                <tr>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">User</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">City</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Bookings</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Total Spent</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Joined</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Status</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="u in filteredUsers" :key="u.id" class="border-t border-slate-50 hover:bg-slate-50 transition-colors">
                  <td class="px-5 py-3">
                    <div class="flex items-center gap-2.5">
                      <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs font-bold flex-shrink-0" :style="{ background: u.color }">{{ u.initials }}</div>
                      <div>
                        <p class="text-sm font-semibold text-slate-700">{{ u.name }}</p>
                        <p class="text-xs text-slate-400">{{ u.email }}</p>
                      </div>
                    </div>
                  </td>
                  <td class="px-5 py-3 text-sm text-slate-500">{{ u.city }}</td>
                  <td class="px-5 py-3 text-sm font-semibold text-slate-700">{{ u.bookings }}</td>
                  <td class="px-5 py-3 text-sm font-bold text-slate-700">${{ u.spent }}</td>
                  <td class="px-5 py-3 text-xs text-slate-400">{{ u.joined }}</td>
                  <td class="px-5 py-3">
                    <span :class="['text-xs font-bold px-2.5 py-1 rounded-full', u.active ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-500']">
                      {{ u.active ? 'Active' : 'Banned' }}
                    </span>
                  </td>
                  <td class="px-5 py-3">
                    <button @click="u.active=!u.active"
                      :class="['text-xs font-bold bg-transparent border-none cursor-pointer font-[\'Sora\',sans-serif]', u.active ? 'text-red-400 hover:text-red-500' : 'text-teal-600 hover:text-teal-700']">
                      {{ u.active ? 'Ban' : 'Restore' }}
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- ── BOOKINGS ── -->
        <div v-else-if="activeTab==='bookings'">
          <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full">
              <thead class="bg-slate-50">
                <tr>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">#</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Client</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Agency</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Vehicle</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Dates</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Total</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="b in allBookings" :key="b.id" class="border-t border-slate-50 hover:bg-slate-50 transition-colors">
                  <td class="px-5 py-3 text-xs text-slate-400 font-mono">#{{ b.id }}</td>
                  <td class="px-5 py-3 text-sm font-semibold text-slate-700">{{ b.client }}</td>
                  <td class="px-5 py-3 text-sm text-slate-500">{{ b.agency }}</td>
                  <td class="px-5 py-3 text-sm text-slate-600">{{ b.vehicle }}</td>
                  <td class="px-5 py-3 text-xs text-slate-500">{{ b.dates }}</td>
                  <td class="px-5 py-3 text-sm font-bold text-slate-800">${{ b.total }}</td>
                  <td class="px-5 py-3"><span :class="['text-xs font-bold px-2.5 py-1 rounded-full', statusClass(b.status)]">{{ b.status }}</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- ── REPORTS ── -->
        <div v-else-if="activeTab==='reports'">
          <div class="grid grid-cols-2 gap-5">
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
              <h3 class="text-sm font-bold text-slate-800 mb-4">Revenue by City</h3>
              <div class="flex flex-col gap-3">
                <div v-for="c in revenueByCity" :key="c.name">
                  <div class="flex items-center justify-between mb-1">
                    <span class="text-sm text-slate-600">{{ c.name }}</span>
                    <span class="text-sm font-bold text-slate-700">${{ c.value }}k</span>
                  </div>
                  <div class="w-full bg-slate-100 rounded-full h-2.5">
                    <div class="h-2.5 rounded-full bg-teal-500" :style="{ width: c.pct+'%' }"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
              <h3 class="text-sm font-bold text-slate-800 mb-4">Platform Health</h3>
              <div class="flex flex-col gap-3">
                <div v-for="m in platformMetrics" :key="m.label" class="flex items-center justify-between py-2 border-b border-slate-50 last:border-b-0">
                  <span class="text-sm text-slate-600">{{ m.label }}</span>
                  <span :class="['text-sm font-bold', m.good ? 'text-emerald-600' : 'text-red-500']">{{ m.value }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>

      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const sidebarOpen  = ref(true)
const activeTab    = ref('overview')
const agencyFilter = ref('All')
const userSearch   = ref('')

const navItems = [
  { key:'overview', label:'Overview',  subtitle:'Platform at a glance',
    icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>` },
  { key:'agencies', label:'Agencies',  subtitle:'Manage partner agencies', badge:'3',
    icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>` },
  { key:'users',    label:'Users',     subtitle:'All client accounts',
    icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>` },
  { key:'bookings', label:'Bookings',  subtitle:'All platform bookings',
    icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>` },
  { key:'reports',  label:'Reports',   subtitle:'Analytics & insights',
    icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>` },
]

const currentTab = computed(() => navItems.find(n => n.key === activeTab.value) || navItems[0])

const stats = [
  { label:'Total Revenue',   value:'$142k',  change:'+24%', up:true,  color:'#0d9488', icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>` },
  { label:'Partner Agencies',value:'48',      change:'+6',   up:true,  color:'#6366f1', icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>` },
  { label:'Registered Users',value:'3,241',   change:'+18%', up:true,  color:'#f59e0b', icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>` },
  { label:'Total Bookings',  value:'1,842',   change:'+31%', up:true,  color:'#ec4899', icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>` },
]

const revenueChart = [
  { label:'Nov', value:18 }, { label:'Dec', value:26 }, { label:'Jan', value:22 },
  { label:'Feb', value:30 }, { label:'Mar', value:28 }, { label:'Apr', value:36 },
]
const maxRevenue = computed(() => Math.max(...revenueChart.map(r => r.value)))

const agencies = ref([
  { id:1, name:'Casablanca Premium',  initials:'CP', color:'#0d9488', email:'contact@cpremium.ma',  city:'Casablanca', fleet:85, rating:4.9, revenue:42,  status:'Verified'   },
  { id:2, name:'Marrakech Drive',     initials:'MD', color:'#d97706', email:'info@mkdrive.ma',       city:'Marrakech',  fleet:62, rating:4.7, revenue:28,  status:'Verified'   },
  { id:3, name:'Rabat Royal Fleet',   initials:'RR', color:'#7c3aed', email:'rabat@royalfleet.ma',   city:'Rabat',      fleet:74, rating:4.8, revenue:35,  status:'Verified'   },
  { id:4, name:'Fès Heritage',        initials:'FH', color:'#dc2626', email:'fes@heritage.ma',       city:'Fès',        fleet:41, rating:4.5, revenue:18,  status:'Pending'    },
  { id:5, name:'Tanger Bay Motors',   initials:'TB', color:'#0891b2', email:'tanger@baymotors.ma',   city:'Tanger',     fleet:53, rating:4.6, revenue:22,  status:'Verified'   },
  { id:6, name:'Oujda Fast Rentals',  initials:'OF', color:'#be185d', email:'oujda@fastrentals.ma',  city:'Oujda',      fleet:28, rating:3.8, revenue:9,   status:'Pending'    },
  { id:7, name:'Meknes Classic Cars', initials:'MC', color:'#92400e', email:'meknes@classic.ma',     city:'Meknès',     fleet:19, rating:3.5, revenue:6,   status:'Pending'    },
  { id:8, name:'Agadir Sun Rentals',  initials:'AS', color:'#16a34a', email:'agadir@sunrentals.ma',  city:'Agadir',     fleet:58, rating:4.7, revenue:24,  status:'Suspended'  },
])

const filteredAgencies = computed(() =>
  agencyFilter.value === 'All' ? agencies.value : agencies.value.filter(a => a.status === agencyFilter.value)
)

const users = ref([
  { id:1, name:'Ahmed Khalil',   initials:'AK', color:'#0d9488', email:'ahmed@email.com',  city:'Casablanca', bookings:12, spent:3240,  joined:'Jan 2024', active:true  },
  { id:2, name:'Sara El Fassi',  initials:'SF', color:'#6366f1', email:'sara@email.com',   city:'Rabat',      bookings:8,  spent:1820,  joined:'Feb 2024', active:true  },
  { id:3, name:'Youssef Ouali',  initials:'YO', color:'#f59e0b', email:'youssef@email.com',city:'Marrakech',  bookings:5,  spent:980,   joined:'Mar 2024', active:true  },
  { id:4, name:'Nadia Chraibi',  initials:'NC', color:'#ec4899', email:'nadia@email.com',  city:'Fès',        bookings:3,  spent:620,   joined:'Apr 2024', active:false },
  { id:5, name:'Karim Mansouri', initials:'KM', color:'#8b5cf6', email:'karim@email.com',  city:'Tanger',     bookings:15, spent:4500,  joined:'Dec 2023', active:true  },
  { id:6, name:'Fatima Zahra',   initials:'FZ', color:'#0891b2', email:'fatima@email.com', city:'Agadir',     bookings:7,  spent:1540,  joined:'Feb 2024', active:true  },
])

const filteredUsers = computed(() => {
  const q = userSearch.value.toLowerCase()
  return users.value.filter(u => !q || u.name.toLowerCase().includes(q) || u.email.toLowerCase().includes(q))
})

const allBookings = [
  { id:101, client:'Ahmed Khalil',   agency:'Casa Premium', vehicle:'BMW 5 Series',     dates:'May 5–10',   total:900,  status:'Active'    },
  { id:102, client:'Sara El Fassi',  agency:'Rabat Royal',  vehicle:'Tesla Model 3',    dates:'May 3–8',    total:800,  status:'Confirmed' },
  { id:103, client:'Youssef Ouali',  agency:'Casa Premium', vehicle:'Mercedes E-Class', dates:'May 6–7',    total:400,  status:'Pending'   },
  { id:104, client:'Nadia Chraibi',  agency:'Agadir Sun',   vehicle:'Toyota Corolla',   dates:'Apr 28–30',  total:144,  status:'Cancelled' },
  { id:105, client:'Karim Mansouri', agency:'Casa Premium', vehicle:'Audi A6',          dates:'May 7–12',   total:975,  status:'Confirmed' },
  { id:106, client:'Fatima Zahra',   agency:'Tanger Bay',   vehicle:'Honda CR-V',       dates:'May 2–4',    total:345,  status:'Completed' },
]

const revenueByCity = [
  { name:'Casablanca', value:58,  pct:82 },
  { name:'Marrakech',  value:28,  pct:40 },
  { name:'Rabat',      value:35,  pct:50 },
  { name:'Tanger',     value:22,  pct:31 },
  { name:'Agadir',     value:24,  pct:34 },
]

const platformMetrics = [
  { label:'Uptime this month',       value:'99.9%',  good:true  },
  { label:'Avg booking completion',  value:'87%',    good:true  },
  { label:'Dispute rate',            value:'2.1%',   good:true  },
  { label:'Agency approval rate',    value:'74%',    good:true  },
  { label:'Cancelled bookings rate', value:'11%',    good:false },
  { label:'Avg response time',       value:'1.8h',   good:true  },
]

function statusClass(s) {
  if (s==='Active')    return 'bg-teal-50 text-teal-700'
  if (s==='Confirmed') return 'bg-emerald-50 text-emerald-700'
  if (s==='Completed') return 'bg-slate-100 text-slate-600'
  if (s==='Cancelled') return 'bg-red-50 text-red-500'
  if (s==='Pending')   return 'bg-yellow-50 text-yellow-600'
  return 'bg-slate-100 text-slate-500'
}

function agencyStatusClass(s) {
  if (s==='Verified')  return 'bg-emerald-50 text-emerald-700'
  if (s==='Pending')   return 'bg-yellow-50 text-yellow-600'
  if (s==='Suspended') return 'bg-red-50 text-red-500'
  return 'bg-slate-100 text-slate-500'
}
</script>