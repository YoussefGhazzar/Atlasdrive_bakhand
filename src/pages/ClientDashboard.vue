<template>
  <div class="flex h-screen bg-slate-100 font-['Sora',sans-serif] overflow-hidden">

    <!-- ── Sidebar ── -->
    <aside :class="['flex flex-col bg-white border-r border-slate-200 transition-all duration-300 flex-shrink-0', sidebarOpen ? 'w-60' : 'w-16']">
      <div class="flex items-center gap-3 px-4 py-5 border-b border-slate-100">
        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
          <path d="M4 20L10 8L16 16L20 10L24 20" stroke="#0d9488" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M2 14L6 10" stroke="#0d9488" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <span v-if="sidebarOpen" class="font-bold text-slate-900 text-base tracking-tight whitespace-nowrap">Atlas Drive</span>
      </div>

      <nav class="flex-1 py-4 flex flex-col gap-1 px-2">
        <button v-for="item in navItems" :key="item.key"
          @click="activeTab = item.key"
          :class="['flex items-center gap-3 px-3 py-2.5 rounded-xl border-none cursor-pointer transition-all text-left w-full',
            activeTab === item.key ? 'bg-teal-50 text-teal-600' : 'bg-transparent text-slate-500 hover:bg-slate-50 hover:text-slate-700']">
          <span class="flex-shrink-0" v-html="item.icon"></span>
          <span v-if="sidebarOpen" class="text-sm font-semibold whitespace-nowrap">{{ item.label }}</span>
        </button>
      </nav>

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
          <button class="relative w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 hover:bg-slate-100 border-none cursor-pointer transition-colors">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
              <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
          </button>
          <div class="flex items-center gap-2.5 cursor-pointer">
            <div class="w-9 h-9 rounded-xl bg-teal-600 flex items-center justify-center text-white text-sm font-bold">AK</div>
            <div v-if="sidebarOpen">
              <p class="text-sm font-bold text-slate-800 leading-none">Ahmed Khalil</p>
              <p class="text-xs text-slate-400 mt-0.5">Client Account</p>
            </div>
          </div>
        </div>
      </header>

      <main class="flex-1 overflow-y-auto p-6">

        <!-- ── OVERVIEW ── -->
        <div v-if="activeTab==='overview'">
          <!-- Stats -->
          <div class="grid grid-cols-4 gap-4 mb-6">
            <div v-for="stat in stats" :key="stat.label"
              class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
              <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3" :style="{ background: stat.color+'18' }">
                <span v-html="stat.icon" :style="{ color: stat.color }"></span>
              </div>
              <p class="text-2xl font-extrabold text-slate-900 leading-none mb-1">{{ stat.value }}</p>
              <p class="text-xs text-slate-400 font-medium">{{ stat.label }}</p>
            </div>
          </div>

          <!-- Active Rental Banner -->
          <div v-if="activeRental" class="bg-gradient-to-r from-teal-600 to-teal-500 rounded-2xl p-5 mb-6 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-48 h-full opacity-10">
              <svg viewBox="0 0 200 100" fill="white"><rect x="2" y="30" width="160" height="55" rx="12"/><path d="M20 30V22a16 16 0 0116-16h80a16 16 0 0116 16v8"/><circle cx="40" cy="85" r="14"/><circle cx="130" cy="85" r="14"/></svg>
            </div>
            <div class="flex items-center justify-between relative z-10">
              <div>
                <span class="text-xs font-bold text-teal-100 uppercase tracking-widest">🚗 Active Rental</span>
                <h3 class="text-xl font-extrabold text-white mt-1">{{ activeRental.car }}</h3>
                <p class="text-teal-100 text-sm mt-0.5">Return by <span class="font-bold text-white">{{ activeRental.returnDate }}</span></p>
              </div>
              <div class="text-right">
                <div class="bg-white/20 rounded-xl px-4 py-2 backdrop-blur-sm">
                  <p class="text-xs text-teal-100">Days remaining</p>
                  <p class="text-3xl font-extrabold text-white">{{ activeRental.daysLeft }}</p>
                </div>
              </div>
            </div>
            <!-- Progress bar -->
            <div class="mt-4">
              <div class="flex justify-between text-xs text-teal-100 mb-1">
                <span>{{ activeRental.startDate }}</span>
                <span>{{ activeRental.returnDate }}</span>
              </div>
              <div class="w-full bg-white/20 rounded-full h-2">
                <div class="h-2 bg-white rounded-full transition-all" :style="{ width: activeRental.progress+'%' }"></div>
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
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Vehicle</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Agency</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Dates</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Total</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="b in bookings.slice(0,4)" :key="b.id" class="border-t border-slate-50 hover:bg-slate-50 transition-colors">
                  <td class="px-5 py-3">
                    <div class="flex items-center gap-3">
                      <img :src="b.image" class="w-12 h-9 object-cover rounded-lg flex-shrink-0"/>
                      <span class="text-sm font-bold text-slate-800">{{ b.car }}</span>
                    </div>
                  </td>
                  <td class="px-5 py-3 text-sm text-slate-500">{{ b.agency }}</td>
                  <td class="px-5 py-3 text-xs text-slate-500">{{ b.dates }}</td>
                  <td class="px-5 py-3 text-sm font-bold text-slate-800">${{ b.total }}</td>
                  <td class="px-5 py-3"><span :class="['text-xs font-bold px-2.5 py-1 rounded-full', statusClass(b.status)]">{{ b.status }}</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- ── BOOKINGS ── -->
        <div v-else-if="activeTab==='bookings'">
          <div class="flex gap-2 mb-5">
            <button v-for="f in ['All','Active','Confirmed','Completed','Cancelled']" :key="f"
              @click="bookingFilter=f"
              :class="['text-xs font-bold px-4 py-2 rounded-xl border-none cursor-pointer transition-all font-[\'Sora\',sans-serif]',
                bookingFilter===f ? 'bg-teal-600 text-white' : 'bg-white text-slate-500 hover:bg-slate-50 border border-slate-200']">
              {{ f }}
            </button>
          </div>

          <div class="flex flex-col gap-4">
            <div v-for="b in filteredBookings" :key="b.id"
              class="bg-white rounded-2xl border border-slate-200 shadow-sm flex overflow-hidden hover:border-teal-300 transition-all">
              <img :src="b.image" class="w-44 object-cover flex-shrink-0"/>
              <div class="flex-1 p-5">
                <div class="flex items-start justify-between mb-2">
                  <div>
                    <h3 class="text-base font-extrabold text-slate-900">{{ b.car }}</h3>
                    <p class="text-xs text-slate-400 mt-0.5">{{ b.agency }} · {{ b.city }}</p>
                  </div>
                  <span :class="['text-xs font-bold px-3 py-1 rounded-full', statusClass(b.status)]">{{ b.status }}</span>
                </div>
                <div class="flex items-center gap-5 mt-3 flex-wrap">
                  <div class="flex items-center gap-1.5">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <span class="text-xs text-slate-500">{{ b.dates }}</span>
                  </div>
                  <div class="flex items-center gap-1.5">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <span class="text-xs text-slate-500">{{ b.days }} days</span>
                  </div>
                  <div class="flex items-center gap-1.5">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span class="text-xs text-slate-500">{{ b.city }}</span>
                  </div>
                </div>
              </div>
              <div class="flex flex-col items-end justify-between p-5 border-l border-slate-100 min-w-32">
                <div class="text-right">
                  <p class="text-2xl font-extrabold text-slate-900">${{ b.total }}</p>
                  <p class="text-xs text-slate-400">{{ b.days }} days</p>
                </div>
                <button v-if="b.status==='Completed'" class="text-xs font-bold text-teal-600 hover:underline bg-transparent border-none cursor-pointer font-['Sora',sans-serif]">Leave Review</button>
                <button v-else-if="b.status==='Confirmed'" class="text-xs font-bold text-red-400 hover:underline bg-transparent border-none cursor-pointer font-['Sora',sans-serif]">Cancel</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ── ACTIVE RENTAL ── -->
        <div v-else-if="activeTab==='active'">
          <div v-if="activeRental" class="grid grid-cols-2 gap-5">
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
                  <div class="h-3 bg-teal-500 rounded-full transition-all" :style="{ width: activeRental.progress+'%' }"></div>
                </div>
                <p class="text-xs text-slate-400 text-center">{{ activeRental.progress }}% of rental period used</p>
              </div>

              <!-- Agency contact -->
              <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                <h3 class="text-sm font-bold text-slate-800 mb-3">Agency Contact</h3>
                <div class="flex items-center gap-3 mb-4">
                  <div class="w-10 h-10 rounded-xl bg-teal-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">CA</div>
                  <div>
                    <p class="text-sm font-bold text-slate-800">{{ activeRental.agency }}</p>
                    <p class="text-xs text-slate-400">{{ activeRental.city }}</p>
                  </div>
                </div>
                <div class="flex gap-2">
                  <button class="flex-1 flex items-center justify-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold py-2.5 rounded-xl border-none cursor-pointer transition-colors font-['Sora',sans-serif]">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.63A2 2 0 012 .18h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z"/></svg>
                    Call Agency
                  </button>
                  <button class="flex-1 flex items-center justify-center gap-2 border border-slate-200 hover:border-teal-500 text-slate-600 hover:text-teal-600 text-xs font-bold py-2.5 rounded-xl bg-white cursor-pointer transition-all font-['Sora',sans-serif]">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    Send Email
                  </button>
                </div>
              </div>

              <!-- Tips -->
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

          <div v-else class="flex flex-col items-center justify-center py-24 bg-white rounded-2xl border border-slate-200">
            <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.2"><rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>
            <p class="text-slate-400 font-semibold mt-4">No active rental right now</p>
            <button class="mt-3 bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold px-5 py-2.5 rounded-xl border-none cursor-pointer transition-colors font-['Sora',sans-serif]">Browse Fleet</button>
          </div>
        </div>

        <!-- ── PROFILE ── -->
        <div v-else-if="activeTab==='profile'">
          <div class="max-w-lg">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
              <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
                <div class="w-16 h-16 rounded-2xl bg-teal-600 flex items-center justify-center text-white text-2xl font-extrabold">AK</div>
                <div>
                  <h2 class="text-lg font-bold text-slate-900">Ahmed Khalil</h2>
                  <p class="text-sm text-slate-400">Client since January 2024</p>
                </div>
              </div>
              <div class="flex flex-col gap-4">
                <div v-for="field in profileFields" :key="field.label">
                  <label class="text-xs font-bold text-slate-500 block mb-1">{{ field.label }}</label>
                  <input :type="field.type||'text'" :value="field.value"
                    class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 transition-colors font-['Sora',sans-serif]"/>
                </div>
                <button class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold text-sm py-3 rounded-xl border-none cursor-pointer transition-colors mt-2 font-['Sora',sans-serif]">Save Changes</button>
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
const bookingFilter = ref('All')

const navItems = [
  { key:'overview', label:'Overview',      subtitle:'Your rental summary',
    icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>` },
  { key:'active',   label:'Active Rental', subtitle:'Your current rental',
    icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>` },
  { key:'bookings', label:'My Bookings',   subtitle:'All your reservations',
    icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>` },
  { key:'profile',  label:'Profile',       subtitle:'Your account settings',
    icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>` },
]

const currentTab = computed(() => navItems.find(n => n.key === activeTab.value) || navItems[0])

const stats = [
  { label:'Total Bookings', value:'12',   color:'#0d9488', icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>` },
  { label:'Total Spent',    value:'$3,240', color:'#6366f1', icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>` },
  { label:'Days Rented',    value:'38',   color:'#f59e0b', icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>` },
  { label:'Avg Rating Given', value:'4.7★', color:'#ec4899', icon:`<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>` },
]

const activeRental = {
  car: 'BMW 5 Series 530i', agency: 'Casablanca Premium Cars', city: 'Casablanca',
  startDate: 'May 5', returnDate: 'May 10', daysLeft: 3, total: 900, progress: 40,
  image: 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=600&q=80',
}

const bookings = [
  { id:1, car:'BMW 5 Series',      agency:'Casa Premium',  city:'Casablanca', dates:'May 5–10',  days:5, total:900,  status:'Active',    image:'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=300&q=80' },
  { id:2, car:'Tesla Model 3',     agency:'Rabat Royal',   city:'Rabat',      dates:'Apr 10–15', days:5, total:800,  status:'Completed', image:'https://images.unsplash.com/photo-1560958089-b8a1929cea89?w=300&q=80' },
  { id:3, car:'Toyota Corolla',    agency:'Agadir Sun',    city:'Agadir',     dates:'Mar 20–23', days:3, total:144,  status:'Completed', image:'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?w=300&q=80' },
  { id:4, car:'Mercedes E-Class',  agency:'Casa Premium',  city:'Casablanca', dates:'Feb 14–16', days:2, total:400,  status:'Cancelled', image:'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?w=300&q=80' },
  { id:5, car:'Honda CR-V Hybrid', agency:'Tanger Bay',    city:'Tanger',     dates:'Jan 5–8',   days:3, total:345,  status:'Completed', image:'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?w=300&q=80' },
]

const filteredBookings = computed(() =>
  bookingFilter.value === 'All' ? bookings : bookings.filter(b => b.status === bookingFilter.value)
)

const checklist = [
  'Full fuel tank', 'No new scratches or damage',
  'All personal belongings removed', 'Return keys to agency',
]

const profileFields = [
  { label:'Full Name',  value:'Ahmed Khalil' },
  { label:'Email',      value:'ahmed.khalil@email.com', type:'email' },
  { label:'Phone',      value:'+212 661 234 567', type:'tel' },
  { label:'City',       value:'Casablanca' },
  { label:'ID Number',  value:'AB123456' },
]

function statusClass(s) {
  if (s==='Active')    return 'bg-teal-50 text-teal-700'
  if (s==='Confirmed') return 'bg-emerald-50 text-emerald-700'
  if (s==='Completed') return 'bg-slate-100 text-slate-600'
  if (s==='Cancelled') return 'bg-red-50 text-red-500'
  if (s==='Pending')   return 'bg-yellow-50 text-yellow-600'
  return 'bg-slate-100 text-slate-500'
}
</script>