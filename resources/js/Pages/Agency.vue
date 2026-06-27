<template>
  <div class="bg-slate-100 min-h-screen">
    <Navbar />

    <!-- ── Hero ── -->
    <section class="relative overflow-hidden"
      style="background: linear-gradient(135deg, #0f2027 0%, #0d4f47 50%, #0d9488 100%)">
      <div class="absolute inset-0"
        style="background: url('https://images.unsplash.com/photo-1486325212027-8081e485255e?w=1400&q=60') center/cover no-repeat; opacity: 0.08"></div>
      <div class="absolute inset-0"
        style="background: linear-gradient(135deg, rgba(15,32,39,0.85) 0%, rgba(13,79,71,0.8) 60%, rgba(13,148,136,0.7) 100%)"></div>

      <div class="relative z-10 max-w-6xl mx-auto px-8 py-12 text-center">
        <span class="inline-block text-xs font-semibold text-teal-100 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 backdrop-blur-sm tracking-wide"
          style="font-family:'Sora',sans-serif;">
          🌍 Nationwide Network
        </span>
        <h1 class="text-5xl font-bold text-white mt-3 mb-3 tracking-tight"
          style="font-family:'Sora',sans-serif; text-shadow:0 2px 16px rgba(0,0,0,0.3);">
          Our Partner Agencies
        </h1>
        <p class="text-teal-100 text-lg mb-8 font-medium" style="font-family:'Sora',sans-serif;">
          Find trusted rental agencies near you — verified, rated, and ready to serve.
        </p>

        <!-- Search + Filter Bar -->
        <div class="flex items-center gap-2.5 bg-white rounded-2xl px-3 py-3 shadow-2xl flex-wrap">
          <!-- Search -->
          <div class="flex items-center gap-2 flex-1 min-w-[200px]">
            <svg class="text-gray-400 shrink-0" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input v-model="searchQuery" type="text" placeholder="Search by city or agency name..."
              class="border-none outline-none text-sm text-gray-700 bg-transparent w-full placeholder-gray-400"
              style="font-family:'Sora',sans-serif;" />
          </div>
          <!-- City -->
          <div class="flex items-center gap-1.5 border border-gray-200 rounded-lg px-3 py-2 focus-within:border-teal-500 transition-colors">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
            </svg>
            <select v-model="selectedCity" class="border-none outline-none text-xs font-medium text-gray-700 bg-transparent cursor-pointer"
              style="font-family:'Sora',sans-serif;">
              <option value="">All Cities</option>
              <option v-for="city in cities" :key="city" :value="city">{{ city }}</option>
            </select>
          </div>
          <!-- Sort -->
          <div class="flex items-center gap-1.5 border border-gray-200 rounded-lg px-3 py-2 focus-within:border-teal-500 transition-colors">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
              <path d="M3 6h18M7 12h10M11 18h2"/>
            </svg>
            <select v-model="sortBy" class="border-none outline-none text-xs font-medium text-gray-700 bg-transparent cursor-pointer"
              style="font-family:'Sora',sans-serif;">
              <option value="rating">Top Rated</option>
              <option value="fleet">Largest Fleet</option>
              <option value="name">A–Z</option>
            </select>
          </div>
          <!-- Button -->
          <button class="flex items-center gap-1.5 bg-teal-600 hover:bg-teal-700 active:translate-y-px text-white text-sm font-semibold px-5 py-2 rounded-lg transition-all whitespace-nowrap"
            style="font-family:'Sora',sans-serif;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            Search
          </button>
        </div>
      </div>
    </section>

    <!-- ── Stats Bar ── -->
    <div class="flex justify-center bg-white border-b border-slate-200 shadow-sm">
      <div v-for="stat in globalStats" :key="stat.label"
        class="flex flex-col items-center px-12 py-4 border-r border-slate-100 last:border-r-0 hover:bg-teal-50 transition-colors cursor-default">
        <span class="text-2xl font-extrabold text-teal-600 leading-none tracking-tight" style="font-family:'Sora',sans-serif;">{{ stat.value }}</span>
        <span class="text-[0.7rem] text-slate-500 font-medium mt-1 uppercase tracking-wide" style="font-family:'Sora',sans-serif;">{{ stat.label }}</span>
      </div>
    </div>

    <!-- ── Main Content ── -->
    <div class="max-w-6xl mx-auto px-8 py-8">

      <!-- Results header + view toggle -->
      <div class="flex items-center justify-between mb-5">
        <p class="text-sm text-slate-500 font-medium" style="font-family:'Sora',sans-serif;">
          Showing <span class="text-teal-600 font-bold">{{ filteredAgencies.length }}</span> agencies
        </p>
        <div class="flex gap-1 bg-white rounded-lg p-1 shadow-sm">
          <button @click="view = 'grid'"
            :class="['flex items-center justify-center w-8 h-8 rounded-md border-none cursor-pointer transition-all',
              view === 'grid' ? 'bg-teal-600 text-white' : 'bg-transparent text-slate-400 hover:bg-slate-100 hover:text-slate-600']">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
              <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
              <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
            </svg>
          </button>
          <button @click="view = 'list'"
            :class="['flex items-center justify-center w-8 h-8 rounded-md border-none cursor-pointer transition-all',
              view === 'list' ? 'bg-teal-600 text-white' : 'bg-transparent text-slate-400 hover:bg-slate-100 hover:text-slate-600']">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- Agency Cards -->
      <div :class="[view === 'grid' ? 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5' : 'flex flex-col gap-4', 'mb-10']">
        <div v-for="agency in filteredAgencies" :key="agency.id"
          :class="['bg-white rounded-2xl overflow-hidden shadow-sm hover:-translate-y-1 hover:shadow-teal-100 hover:shadow-lg transition-all duration-200 flex',
            view === 'list' ? 'flex-row items-stretch' : 'flex-col']">

          <!-- Cover -->
          <div class="relative bg-cover bg-center flex-shrink-0"
            :class="view === 'list' ? 'w-40' : 'h-32'"
            :style="{ backgroundImage: `url(${agency.cover})` }">
            <span :class="['absolute top-2.5 right-2.5 text-[0.68rem] font-bold px-2 py-0.5 rounded-full', agency.verified ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-500']"
              style="font-family:'Sora',sans-serif;">
              {{ agency.verified ? '✓ Verified' : 'Pending' }}
            </span>
          </div>

          <!-- Body -->
          <div class="flex flex-col flex-1">
            <!-- Header -->
            <div class="flex items-center gap-3 px-4 pt-3.5 pb-2">
              <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-extrabold text-sm flex-shrink-0"
                :style="{ background: agency.color }" style="font-family:'Sora',sans-serif; letter-spacing:-0.02em">
                {{ agency.initials }}
              </div>
              <div class="flex-1 min-w-0">
                <h3 class="font-bold text-slate-900 text-base leading-tight truncate" style="font-family:'Sora',sans-serif;">{{ agency.name }}</h3>
                <div class="flex items-center gap-1 mt-0.5">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                  </svg>
                  <span class="text-xs text-slate-400" style="font-family:'Sora',sans-serif;">{{ agency.city }}</span>
                </div>
              </div>
              <div class="flex items-center gap-1 bg-yellow-50 border border-yellow-200 rounded-lg px-2 py-1 flex-shrink-0">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="#f59e0b">
                  <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                <span class="text-xs font-bold text-slate-700" style="font-family:'Sora',sans-serif;">{{ agency.rating }}</span>
              </div>
            </div>

            <!-- Stats row -->
            <div class="flex flex-wrap gap-3 px-4 pb-2.5">
              <div class="flex items-center gap-1.5">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                  <rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/>
                  <circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/>
                </svg>
                <span class="text-xs text-slate-600 font-medium" style="font-family:'Sora',sans-serif;">{{ agency.fleet }} vehicles</span>
              </div>
              <div class="flex items-center gap-1.5">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                </svg>
                <span class="text-xs text-slate-600 font-medium" style="font-family:'Sora',sans-serif;">{{ agency.clients }}+ clients</span>
              </div>
              <div class="flex items-center gap-1.5">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                  <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
                <span class="text-xs text-slate-600 font-medium" style="font-family:'Sora',sans-serif;">Since {{ agency.since }}</span>
              </div>
            </div>

            <!-- Category pills -->
            <div class="flex flex-wrap gap-1.5 px-4 pb-3">
              <span v-for="cat in agency.categories" :key="cat"
                class="text-[0.65rem] font-semibold text-teal-600 bg-teal-50 border border-teal-200 rounded-full px-2 py-0.5"
                style="font-family:'Sora',sans-serif;">
                {{ cat }}
              </span>
            </div>

            <!-- Actions -->
            <div class="flex gap-2.5 px-4 py-3 border-t border-slate-100 mt-auto">
              <Link "
                class="flex-1 text-center bg-teal-600 hover:bg-teal-700 active:translate-y-px text-white text-xs font-semibold py-2 rounded-lg transition-all no-underline"
                style="font-family:'Sora',sans-serif;">
                View Agency
              </Link>
              <button class="flex items-center gap-1.5 border border-slate-200 hover:border-teal-500 hover:text-teal-600 hover:bg-teal-50 text-slate-500 text-xs font-semibold px-3 py-2 rounded-lg transition-all bg-white"
                style="font-family:'Sora',sans-serif;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.63A2 2 0 012 .18h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 14.92z"/>
                </svg>
                Contact
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- ── Map Section ── -->
      <section class="bg-white rounded-2xl overflow-hidden shadow-sm mb-8">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
          <div>
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight" style="font-family:'Sora',sans-serif;">Agency Locations</h2>
            <p class="text-sm text-slate-500 mt-0.5" style="font-family:'Sora',sans-serif;">All partner agencies across Morocco</p>
          </div>
          <button class="flex items-center gap-1.5 border border-slate-200 hover:border-teal-500 hover:bg-teal-50 text-teal-600 text-xs font-semibold px-4 py-2 rounded-lg transition-all bg-white"
            style="font-family:'Sora',sans-serif;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/>
            </svg>
            Open Full Map
          </button>
        </div>

        <!-- Map placeholder -->
        <div class="relative h-80 overflow-hidden"
          style="background: linear-gradient(135deg, #e0f2fe 0%, #f0fdfa 40%, #d1fae5 100%)">
          <!-- Grid lines -->
          <svg class="absolute inset-0 w-full h-full opacity-10" preserveAspectRatio="none">
            <defs>
              <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                <path d="M 40 0 L 0 0 0 40" fill="none" stroke="#0d9488" stroke-width="0.5"/>
              </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)"/>
          </svg>

          <!-- Pins -->
          <div v-for="agency in agencies" :key="'pin-' + agency.id"
            class="absolute -translate-x-1/2 -translate-y-1/2 cursor-pointer z-10"
            :style="{ left: agency.mapX + '%', top: agency.mapY + '%' }"
            @mouseenter="hoveredPin = agency.id"
            @mouseleave="hoveredPin = null">
            <div :class="['relative w-4 h-4 rounded-full bg-teal-600 border-2 border-white shadow-md transition-all duration-200 flex items-center justify-center',
              hoveredPin === agency.id ? 'scale-150 bg-teal-700' : '']">
              <div class="w-1.5 h-1.5 rounded-full bg-white"></div>
              <div class="absolute w-7 h-7 rounded-full bg-teal-500/20 animate-ping"></div>
            </div>
            <Transition name="fade-down">
              <div v-if="hoveredPin === agency.id"
                class="absolute bottom-[calc(100%+10px)] left-1/2 -translate-x-1/2 bg-white rounded-xl px-3 py-2 shadow-lg border border-slate-200 whitespace-nowrap z-20 pointer-events-none">
                <p class="text-xs font-bold text-slate-900" style="font-family:'Sora',sans-serif;">{{ agency.name }}</p>
                <p class="text-xs text-slate-500" style="font-family:'Sora',sans-serif;">{{ agency.city }} · ⭐ {{ agency.rating }}</p>
                <div class="absolute top-full left-1/2 -translate-x-1/2 border-[5px] border-transparent border-t-white"></div>
              </div>
            </Transition>
          </div>

          <!-- Active count -->
          <div class="absolute bottom-4 left-4 flex items-center gap-2">
            <div class="w-3 h-3 rounded-full bg-teal-500 animate-ping opacity-60"></div>
            <span class="text-xs text-teal-700 font-semibold" style="font-family:'Sora',sans-serif;">{{ agencies.length }} agencies active</span>
          </div>

          <!-- Legend -->
          <div class="absolute bottom-3 right-3 bg-white rounded-lg px-3 py-2 flex flex-col gap-1.5 shadow-sm border border-slate-200">
            <div class="flex items-center gap-2">
              <div class="w-3 h-3 rounded-full bg-teal-500 border-2 border-white shadow"></div>
              <span class="text-xs text-slate-600" style="font-family:'Sora',sans-serif;">Verified Agency</span>
            </div>
            <div class="flex items-center gap-2">
              <div class="w-3 h-3 rounded-full bg-slate-400 border-2 border-white shadow"></div>
              <span class="text-xs text-slate-600" style="font-family:'Sora',sans-serif;">Pending</span>
            </div>
          </div>
        </div>
      </section>

      <!-- ── Register CTA ── -->
      <section class="relative rounded-2xl overflow-hidden mb-8"
        style="background: linear-gradient(135deg, #0d4f47 0%, #0d9488 100%)">
        <div class="absolute inset-0 opacity-[0.06]"
          style="background: url('https://images.unsplash.com/photo-1486325212027-8081e485255e?w=800&q=40') center/cover"></div>
        <div class="relative flex items-center gap-6 px-10 py-8 flex-wrap">
          <div class="w-14 h-14 bg-white/15 rounded-2xl flex items-center justify-center flex-shrink-0 backdrop-blur-sm">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8">
              <path d="M12 5v14M5 12h14"/>
            </svg>
          </div>
          <div>
            <h3 class="text-xl font-bold text-white mb-1" style="font-family:'Sora',sans-serif;">Own a Rental Agency?</h3>
            <p class="text-teal-100 text-sm" style="font-family:'Sora',sans-serif;">Join our network and reach thousands of customers across Morocco.</p>
          </div>
          <Link :href="route('agency.register')"
            class="ml-auto bg-white hover:bg-teal-50 text-teal-600 font-bold text-sm px-6 py-3 rounded-xl transition-all hover:-translate-y-0.5 hover:shadow-lg no-underline whitespace-nowrap"
            style="font-family:'Sora',sans-serif;">
            Register Your Agency →
          </Link>
        </div>
      </section>

    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import Navbar from '@/Components/Navbar.vue'

// Props from Laravel controller (agencies can also be passed as Inertia props)
const props = defineProps({
  agenciesData: {
    type: Array,
    default: () => [],
  },
})

const searchQuery  = ref('')
const selectedCity = ref('')
const sortBy       = ref('rating')
const view         = ref('grid')
const hoveredPin   = ref(null)

const cities = ['Casablanca', 'Marrakech', 'Rabat', 'Fès', 'Tanger', 'Agadir']

const globalStats = [
  { value: '48+',    label: 'Partner Agencies'  },
  { value: '1,200+', label: 'Vehicles Available' },
  { value: '12,000+',label: 'Happy Clients'      },
  { value: '4.8★',   label: 'Average Rating'     },
]

// Use props from server if provided, otherwise fall back to local mock data
const agencies = ref(props.agenciesData.length ? props.agenciesData : [
  { id: 1, name: 'Casablanca Premium Cars', city: 'Casablanca', initials: 'CP', color: '#0d9488',
    cover: 'https://images.unsplash.com/photo-1486325212027-8081e485255e?w=600&q=80',
    rating: 4.9, fleet: 85, clients: 3200, since: 2015, verified: true,
    categories: ['Luxury', 'SUV', 'Electric'], mapX: 28, mapY: 52 },
  { id: 2, name: 'Marrakech Drive', city: 'Marrakech', initials: 'MD', color: '#d97706',
    cover: 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80',
    rating: 4.7, fleet: 62, clients: 2100, since: 2017, verified: true,
    categories: ['Economy', 'Family', 'SUV'], mapX: 35, mapY: 68 },
  { id: 3, name: 'Rabat Royal Fleet', city: 'Rabat', initials: 'RR', color: '#7c3aed',
    cover: 'https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=600&q=80',
    rating: 4.8, fleet: 74, clients: 2800, since: 2014, verified: true,
    categories: ['Luxury', 'Electric', 'SUV'], mapX: 22, mapY: 40 },
  { id: 4, name: 'Fès Heritage Rentals', city: 'Fès', initials: 'FH', color: '#dc2626',
    cover: 'https://images.unsplash.com/photo-1543465077-db45d34b88a5?w=600&q=80',
    rating: 4.5, fleet: 41, clients: 1400, since: 2019, verified: false,
    categories: ['Economy', 'Family'], mapX: 48, mapY: 38 },
  { id: 5, name: 'Tanger Bay Motors', city: 'Tanger', initials: 'TB', color: '#0891b2',
    cover: 'https://images.unsplash.com/photo-1506521781263-d8422e82f27a?w=600&q=80',
    rating: 4.6, fleet: 53, clients: 1900, since: 2018, verified: true,
    categories: ['SUV', 'Economy', 'Luxury'], mapX: 30, mapY: 18 },
  { id: 6, name: 'Agadir Sun Rentals', city: 'Agadir', initials: 'AS', color: '#16a34a',
    cover: 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=600&q=80',
    rating: 4.7, fleet: 58, clients: 2300, since: 2016, verified: true,
    categories: ['Family', 'Electric', 'Economy'], mapX: 20, mapY: 78 },
])

const filteredAgencies = computed(() => {
  let list = agencies.value.filter(a => {
    const q = searchQuery.value.toLowerCase()
    return (!q || a.name.toLowerCase().includes(q) || a.city.toLowerCase().includes(q))
      && (!selectedCity.value || a.city === selectedCity.value)
  })
  if (sortBy.value === 'rating') return [...list].sort((a, b) => b.rating - a.rating)
  if (sortBy.value === 'fleet')  return [...list].sort((a, b) => b.fleet - a.fleet)
  if (sortBy.value === 'name')   return [...list].sort((a, b) => a.name.localeCompare(b.name))
  return list
})
</script>

<style scoped>
@keyframes fadeDown {
  from { opacity: 0; transform: translateY(-6px) translateX(-50%); }
  to   { opacity: 1; transform: translateY(0)    translateX(-50%); }
}
.fade-down-enter-active { animation: fadeDown .2s ease; }
.fade-down-leave-active { transition: opacity .15s; }
.fade-down-leave-to     { opacity: 0; }
</style>