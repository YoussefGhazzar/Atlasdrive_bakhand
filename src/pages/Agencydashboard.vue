<template>
  <div class="flex h-screen bg-slate-100 font-['Sora',sans-serif] overflow-hidden">

    <!-- ── Sidebar ── -->
    <aside :class="['flex flex-col bg-white border-r border-slate-200 transition-all duration-300 flex-shrink-0', sidebarOpen ? 'w-60' : 'w-16']">
      <!-- Logo -->
      <div class="flex items-center gap-3 px-4 py-5 border-b border-slate-100">
        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" flex-shrink-0>
          <path d="M4 20L10 8L16 16L20 10L24 20" stroke="#0d9488" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M2 14L6 10" stroke="#0d9488" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <span v-if="sidebarOpen" class="font-bold text-slate-900 text-base tracking-tight whitespace-nowrap">Atlas Drive</span>
      </div>

      <!-- Nav -->
      <nav class="flex-1 py-4 flex flex-col gap-1 px-2 overflow-y-auto">
        <button v-for="item in navItems" :key="item.key"
          @click="activeTab = item.key"
          :class="['flex items-center gap-3 px-3 py-2.5 rounded-xl border-none cursor-pointer transition-all duration-150 text-left w-full',
            activeTab === item.key
              ? 'bg-teal-50 text-teal-600'
              : 'bg-transparent text-slate-500 hover:bg-slate-50 hover:text-slate-700']">
          <span class="flex-shrink-0" v-html="item.icon"></span>
          <span v-if="sidebarOpen" class="text-sm font-semibold whitespace-nowrap">{{ item.label }}</span>
        </button>
      </nav>

      <!-- Toggle -->
      <button @click="sidebarOpen=!sidebarOpen"
        class="flex items-center justify-center py-4 border-t border-slate-100 bg-transparent border-none cursor-pointer text-slate-400 hover:text-teal-600 transition-colors">
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
          <!-- Notification bell -->
          <button class="relative w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 hover:bg-slate-100 border-none cursor-pointer transition-colors">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
              <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
          </button>
          <!-- Avatar -->
          <div class="flex items-center gap-2.5 cursor-pointer">
            <div class="w-9 h-9 rounded-xl bg-teal-600 flex items-center justify-center text-white text-sm font-bold">CA</div>
            <div v-if="sidebarOpen">
              <p class="text-sm font-bold text-slate-800 leading-none">Casa Agency</p>
              <p class="text-xs text-slate-400 mt-0.5">Premium Partner</p>
            </div>
          </div>
        </div>
      </header>

      <!-- Content -->
      <main class="flex-1 overflow-y-auto p-6">

        <!-- ── OVERVIEW ── -->
        <div v-if="activeTab==='overview'">
          <!-- Stat cards -->
          <div class="grid grid-cols-4 gap-4 mb-6">
            <div v-for="stat in stats" :key="stat.label"
              class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
              <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" :style="{ background: stat.color+'18' }">
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

          <!-- Charts row -->
          <div class="grid grid-cols-3 gap-4 mb-6">
            <!-- Revenue chart (bar) -->
            <div class="col-span-2 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
              <div class="flex items-center justify-between mb-4">
                <div>
                  <h3 class="text-sm font-bold text-slate-800">Monthly Revenue</h3>
                  <p class="text-xs text-slate-400">Last 6 months</p>
                </div>
                <span class="text-xs font-bold text-teal-600 bg-teal-50 px-2 py-1 rounded-lg">+18% vs last year</span>
              </div>
              <div class="flex items-end gap-2 h-36">
                <div v-for="(bar, i) in revenueChart" :key="i" class="flex-1 flex flex-col items-center gap-1">
                  <span class="text-xs text-slate-400 font-medium">{{ bar.label }}</span>
                  <div class="w-full rounded-t-lg transition-all duration-500 hover:opacity-80"
                    :style="{ height: (bar.value/maxRevenue*100)+'%', background: i===5 ? '#0d9488' : '#e0f7f5' }"></div>
                  <span class="text-xs text-slate-500 font-semibold">${{ bar.value }}k</span>
                </div>
              </div>
            </div>

            <!-- Bookings donut -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
              <h3 class="text-sm font-bold text-slate-800 mb-1">Bookings Status</h3>
              <p class="text-xs text-slate-400 mb-4">This month</p>
              <div class="flex flex-col gap-2.5">
                <div v-for="s in bookingStatus" :key="s.label">
                  <div class="flex items-center justify-between mb-1">
                    <span class="text-xs text-slate-600 font-medium">{{ s.label }}</span>
                    <span class="text-xs font-bold text-slate-700">{{ s.count }}</span>
                  </div>
                  <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="h-2 rounded-full transition-all duration-700" :style="{ width: s.pct+'%', background: s.color }"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Recent bookings -->
          <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
              <h3 class="text-sm font-bold text-slate-800">Recent Bookings</h3>
              <button @click="activeTab='bookings'" class="text-xs text-teal-600 font-bold hover:underline bg-transparent border-none cursor-pointer font-['Sora',sans-serif]">View all →</button>
            </div>
            <table class="w-full">
              <thead class="bg-slate-50">
                <tr>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Client</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Vehicle</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Dates</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Amount</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="b in recentBookings" :key="b.id" class="border-t border-slate-50 hover:bg-slate-50 transition-colors">
                  <td class="px-5 py-3">
                    <div class="flex items-center gap-2.5">
                      <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs font-bold flex-shrink-0" :style="{ background: b.avatarColor }">{{ b.initials }}</div>
                      <span class="text-sm font-semibold text-slate-700">{{ b.client }}</span>
                    </div>
                  </td>
                  <td class="px-5 py-3 text-sm text-slate-600">{{ b.vehicle }}</td>
                  <td class="px-5 py-3 text-xs text-slate-500">{{ b.dates }}</td>
                  <td class="px-5 py-3 text-sm font-bold text-slate-800">${{ b.amount }}</td>
                  <td class="px-5 py-3">
                    <span :class="['text-xs font-bold px-2.5 py-1 rounded-full', statusClass(b.status)]">{{ b.status }}</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- ── FLEET ── -->
        <div v-else-if="activeTab==='fleet'">
          <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-3 py-2 w-72 shadow-sm">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
              <input v-model="fleetSearch" type="text" placeholder="Search vehicles..." class="flex-1 border-none outline-none text-sm text-slate-700 bg-transparent placeholder-slate-400 font-['Sora',sans-serif]"/>
            </div>
            <button class="flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold px-4 py-2.5 rounded-xl border-none cursor-pointer transition-colors font-['Sora',sans-serif]">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
              Add Vehicle
            </button>
          </div>

          <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full">
              <thead class="bg-slate-50">
                <tr>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Vehicle</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Category</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Price/day</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Status</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Bookings</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="car in filteredFleet" :key="car.id" class="border-t border-slate-50 hover:bg-slate-50 transition-colors">
                  <td class="px-5 py-3">
                    <div class="flex items-center gap-3">
                      <img :src="car.image" :alt="car.name" class="w-12 h-9 object-cover rounded-lg flex-shrink-0"/>
                      <div>
                        <p class="text-sm font-bold text-slate-800">{{ car.name }}</p>
                        <p class="text-xs text-slate-400">{{ car.year }}</p>
                      </div>
                    </div>
                  </td>
                  <td class="px-5 py-3"><span class="text-xs font-semibold text-teal-600 bg-teal-50 border border-teal-100 px-2 py-0.5 rounded-full">{{ car.category }}</span></td>
                  <td class="px-5 py-3 text-sm font-bold text-slate-700">${{ car.pricePerDay }}</td>
                  <td class="px-5 py-3">
                    <span :class="['text-xs font-bold px-2.5 py-1 rounded-full', car.available ? 'bg-emerald-50 text-emerald-700' : 'bg-orange-50 text-orange-600']">
                      {{ car.available ? 'Available' : 'Rented' }}
                    </span>
                  </td>
                  <td class="px-5 py-3 text-sm text-slate-600">{{ car.totalBookings }}</td>
                  <td class="px-5 py-3">
                    <div class="flex items-center gap-2">
                      <button class="text-xs font-bold text-teal-600 hover:text-teal-700 bg-transparent border-none cursor-pointer font-['Sora',sans-serif]">Edit</button>
                      <span class="text-slate-200">|</span>
                      <button class="text-xs font-bold text-red-400 hover:text-red-500 bg-transparent border-none cursor-pointer font-['Sora',sans-serif]">Remove</button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- ── BOOKINGS ── -->
        <div v-else-if="activeTab==='bookings'">
          <!-- Filter tabs -->
          <div class="flex gap-2 mb-5">
            <button v-for="tab in ['All','Confirmed','Pending','Cancelled']" :key="tab"
              @click="bookingFilter=tab"
              :class="['text-xs font-bold px-4 py-2 rounded-xl border-none cursor-pointer transition-all font-[\'Sora\',sans-serif]',
                bookingFilter===tab ? 'bg-teal-600 text-white' : 'bg-white text-slate-500 hover:bg-slate-50 border border-slate-200']">
              {{ tab }}
            </button>
          </div>

          <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full">
              <thead class="bg-slate-50">
                <tr>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">#</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Client</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Vehicle</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Pick-up</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Return</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Days</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Total</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="b in filteredBookings" :key="b.id" class="border-t border-slate-50 hover:bg-slate-50 transition-colors">
                  <td class="px-5 py-3 text-xs text-slate-400 font-mono">#{{ b.id }}</td>
                  <td class="px-5 py-3">
                    <div class="flex items-center gap-2">
                      <div class="w-7 h-7 rounded-lg flex items-center justify-center text-white text-xs font-bold flex-shrink-0" :style="{ background: b.avatarColor }">{{ b.initials }}</div>
                      <span class="text-sm font-semibold text-slate-700">{{ b.client }}</span>
                    </div>
                  </td>
                  <td class="px-5 py-3 text-sm text-slate-600">{{ b.vehicle }}</td>
                  <td class="px-5 py-3 text-xs text-slate-500">{{ b.pickup }}</td>
                  <td class="px-5 py-3 text-xs text-slate-500">{{ b.return }}</td>
                  <td class="px-5 py-3 text-sm font-semibold text-slate-700">{{ b.days }}d</td>
                  <td class="px-5 py-3 text-sm font-bold text-slate-800">${{ b.total }}</td>
                  <td class="px-5 py-3"><span :class="['text-xs font-bold px-2.5 py-1 rounded-full', statusClass(b.status)]">{{ b.status }}</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- ── EARNINGS ── -->
        <div v-else-if="activeTab==='earnings'">
          <div class="grid grid-cols-3 gap-4 mb-6">
            <div v-for="e in earningCards" :key="e.label" class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
              <p class="text-xs text-slate-400 font-medium mb-1">{{ e.label }}</p>
              <p class="text-3xl font-extrabold text-slate-900">${{ e.value }}</p>
              <p :class="['text-xs font-bold mt-1', e.up ? 'text-emerald-600' : 'text-red-400']">{{ e.change }} vs last month</p>
            </div>
          </div>

          <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm mb-4">
            <h3 class="text-sm font-bold text-slate-800 mb-4">Revenue by Category</h3>
            <div class="flex flex-col gap-3">
              <div v-for="cat in revenueByCategory" :key="cat.name">
                <div class="flex items-center justify-between mb-1">
                  <span class="text-sm text-slate-600 font-medium">{{ cat.name }}</span>
                  <span class="text-sm font-bold text-slate-700">${{ cat.revenue }}</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2.5">
                  <div class="h-2.5 rounded-full" :style="{ width: cat.pct+'%', background: cat.color }"></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ── SETTINGS ── -->
        <div v-else-if="activeTab==='settings'">
          <div class="grid grid-cols-2 gap-5">
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
              <h3 class="text-sm font-bold text-slate-800 mb-4">Agency Profile</h3>
              <div class="flex flex-col gap-3">
                <div v-for="field in profileFields" :key="field.label">
                  <label class="text-xs font-bold text-slate-500 block mb-1">{{ field.label }}</label>
                  <input :type="field.type || 'text'" :value="field.value"
                    class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 transition-colors font-['Sora',sans-serif]"/>
                </div>
                <button class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold text-sm py-2.5 rounded-xl border-none cursor-pointer transition-colors mt-2 font-['Sora',sans-serif]">Save Changes</button>
              </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
              <h3 class="text-sm font-bold text-slate-800 mb-4">Subscription Plan</h3>
              <div class="bg-teal-50 border border-teal-200 rounded-xl p-4 mb-4">
                <div class="flex items-center justify-between mb-2">
                  <span class="text-sm font-bold text-teal-700">Professional Plan</span>
                  <span class="text-xs font-bold text-teal-600 bg-teal-100 px-2 py-0.5 rounded-full">Active</span>
                </div>
                <p class="text-xs text-teal-600">$79/month · Renews May 15, 2026</p>
              </div>
              <button class="w-full border border-slate-200 hover:border-teal-500 text-slate-600 hover:text-teal-600 font-bold text-sm py-2.5 rounded-xl bg-white cursor-pointer transition-all font-['Sora',sans-serif]">Upgrade to Enterprise</button>
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
const fleetSearch  = ref('')
const bookingFilter = ref('All')

const navItems = [
  { key:'overview', label:'Overview',  subtitle:'Your agency at a glance',
    icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>` },
  { key:'fleet',    label:'Fleet',     subtitle:'Manage your vehicles',
    icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>` },
  { key:'bookings', label:'Bookings',  subtitle:'All reservations',
    icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>` },
  { key:'earnings', label:'Earnings',  subtitle:'Revenue & analytics',
    icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>` },
  { key:'settings', label:'Settings',  subtitle:'Profile & preferences',
    icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>` },
]

const currentTab = computed(() => navItems.find(n => n.key === activeTab.value) || navItems[0])

const stats = [
  { label:'Total Revenue',    value:'$24,800', change:'+12%', up:true,  color:'#0d9488', icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>` },
  { label:'Active Bookings',  value:'34',      change:'+5%',  up:true,  color:'#6366f1', icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>` },
  { label:'Fleet Size',       value:'18',      change:'+2',   up:true,  color:'#f59e0b', icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>` },
  { label:'Avg Rating',       value:'4.8★',    change:'+0.2', up:true,  color:'#ec4899', icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>` },
]

const revenueChart = [
  { label:'Nov', value:18 }, { label:'Dec', value:22 }, { label:'Jan', value:16 },
  { label:'Feb', value:24 }, { label:'Mar', value:20 }, { label:'Apr', value:28 },
]
const maxRevenue = computed(() => Math.max(...revenueChart.map(r => r.value)))

const bookingStatus = [
  { label:'Confirmed', count:22, pct:65, color:'#0d9488' },
  { label:'Pending',   count:8,  pct:24, color:'#f59e0b' },
  { label:'Cancelled', count:4,  pct:11, color:'#ef4444' },
]

const recentBookings = [
  { id:1, client:'Ahmed Benali',    initials:'AB', avatarColor:'#0d9488', vehicle:'BMW 5 Series',     dates:'May 1–5',   amount:720,  status:'Confirmed',  pickup:'May 1',  return:'May 5',  days:4,  total:720  },
  { id:2, client:'Sara El Fassi',   initials:'SF', avatarColor:'#6366f1', vehicle:'Tesla Model 3',    dates:'May 3–8',   amount:800,  status:'Confirmed',  pickup:'May 3',  return:'May 8',  days:5,  total:800  },
  { id:3, client:'Youssef Ouali',   initials:'YO', avatarColor:'#f59e0b', vehicle:'Mercedes E-Class', dates:'May 6–7',   amount:400,  status:'Pending',    pickup:'May 6',  return:'May 7',  days:2,  total:400  },
  { id:4, client:'Nadia Chraibi',   initials:'NC', avatarColor:'#ec4899', vehicle:'Toyota Corolla',   dates:'Apr 28–30', amount:144,  status:'Cancelled',  pickup:'Apr 28', return:'Apr 30', days:3,  total:144  },
  { id:5, client:'Karim Mansouri',  initials:'KM', avatarColor:'#8b5cf6', vehicle:'Audi A6',          dates:'May 7–12',  amount:975,  status:'Confirmed',  pickup:'May 7',  return:'May 12', days:5,  total:975  },
]

const fleet = ref([
  { id:1,  name:'BMW 5 Series 530i',     year:2023, category:'Luxury',   pricePerDay:180, available:true,  totalBookings:42, image:'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=200&q=80' },
  { id:2,  name:'Mercedes-Benz E-Class', year:2023, category:'Luxury',   pricePerDay:200, available:false, totalBookings:38, image:'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?w=200&q=80' },
  { id:3,  name:'Tesla Model 3 LR',      year:2024, category:'Electric', pricePerDay:160, available:true,  totalBookings:55, image:'https://images.unsplash.com/photo-1560958089-b8a1929cea89?w=200&q=80' },
  { id:4,  name:'Toyota Land Cruiser',   year:2023, category:'SUV',      pricePerDay:175, available:true,  totalBookings:29, image:'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=200&q=80' },
  { id:5,  name:'Toyota Corolla 1.6',    year:2022, category:'Economy',  pricePerDay:48,  available:true,  totalBookings:87, image:'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?w=200&q=80' },
  { id:6,  name:'Volkswagen Touran',     year:2022, category:'Family',   pricePerDay:110, available:false, totalBookings:31, image:'https://images.unsplash.com/photo-1506521781263-d8422e82f27a?w=200&q=80' },
])

const filteredFleet = computed(() => {
  const q = fleetSearch.value.toLowerCase()
  return fleet.value.filter(c => !q || c.name.toLowerCase().includes(q) || c.category.toLowerCase().includes(q))
})

const allBookings = recentBookings.concat([
  { id:6, client:'Fatima Zahra',  initials:'FZ', avatarColor:'#0891b2', vehicle:'Honda CR-V',       dates:'May 2–4',   amount:345,  status:'Confirmed',  pickup:'May 2',  return:'May 4',  days:3,  total:345 },
  { id:7, client:'Omar Tazi',     initials:'OT', avatarColor:'#16a34a', vehicle:'Porsche Cayenne',  dates:'May 5–9',   amount:1520, status:'Pending',    pickup:'May 5',  return:'May 9',  days:4,  total:1520 },
])
const filteredBookings = computed(() =>
  bookingFilter.value === 'All' ? allBookings : allBookings.filter(b => b.status === bookingFilter.value)
)

const earningCards = [
  { label:'This Month',  value:'8,240',  change:'+18%', up:true  },
  { label:'Last Month',  value:'6,980',  change:'+8%',  up:true  },
  { label:'Total 2025',  value:'24,800', change:'+22%', up:true  },
]

const revenueByCategory = [
  { name:'Luxury',   revenue:'9,800', pct:40, color:'#0d9488' },
  { name:'Electric', revenue:'4,200', pct:17, color:'#6366f1' },
  { name:'SUV',      revenue:'5,600', pct:23, color:'#f59e0b' },
  { name:'Economy',  revenue:'2,400', pct:10, color:'#10b981' },
  { name:'Family',   revenue:'2,800', pct:11, color:'#8b5cf6' },
]

const profileFields = [
  { label:'Agency Name',    value:'Casablanca Premium Cars' },
  { label:'Email',          value:'contact@casapremium.ma', type:'email' },
  { label:'Phone',          value:'+212 522 001 002', type:'tel' },
  { label:'City',           value:'Casablanca' },
  { label:'Address',        value:'12 Boulevard Hassan II' },
]

function statusClass(status) {
  if (status === 'Confirmed') return 'bg-emerald-50 text-emerald-700'
  if (status === 'Pending')   return 'bg-yellow-50 text-yellow-600'
  if (status === 'Cancelled') return 'bg-red-50 text-red-500'
  return 'bg-slate-100 text-slate-500'
}
</script>