<template>
  <div class="bg-slate-100 min-h-screen">

    <!-- ── Page Header Hero ── -->
    <section class="agencies-hero">
      <div class="absolute inset-0 hero-gradient"></div>
      <div class="relative z-10 max-w-6xl mx-auto px-8 py-12 text-center">
        <span class="badge">🌍 Nationwide Network</span>
        <h1 class="sora text-5xl font-bold text-white mt-3 mb-3 tracking-tight" style="text-shadow: 0 2px 16px rgba(0,0,0,0.3);">
          Our Partner Agencies
        </h1>
        <p class="sora text-teal-100 text-lg mb-8 font-medium">
          Find trusted rental agencies near you — verified, rated, and ready to serve.
        </p>

        <!-- Search + Filter Bar -->
        <div class="search-panel">
          <!-- Search input -->
          <div class="search-input-wrap flex-1">
            <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search by city or agency name..."
              class="sora search-input"
            />
          </div>

          <!-- City filter -->
          <div class="filter-wrap">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
            </svg>
            <select v-model="selectedCity" class="sora filter-select">
              <option value="">All Cities</option>
              <option v-for="city in cities" :key="city" :value="city">{{ city }}</option>
            </select>
          </div>

          <!-- Sort -->
          <div class="filter-wrap">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
              <path d="M3 6h18M7 12h10M11 18h2"/>
            </svg>
            <select v-model="sortBy" class="sora filter-select">
              <option value="rating">Top Rated</option>
              <option value="fleet">Largest Fleet</option>
              <option value="name">A–Z</option>
            </select>
          </div>

          <!-- Search btn -->
          <button class="sora btn-search-hero">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            Search
          </button>
        </div>
      </div>
    </section>

    <!-- ── Stats Bar ── -->
    <div class="stats-bar">
      <div class="stat-item" v-for="stat in globalStats" :key="stat.label">
        <span class="sora stat-number">{{ stat.value }}</span>
        <span class="sora stat-label">{{ stat.label }}</span>
      </div>
    </div>

    <!-- ── Main Content: Cards + Map ── -->
    <div class="max-w-6xl mx-auto px-8 py-8">

      <!-- Results count -->
      <div class="flex items-center justify-between mb-5">
        <p class="sora text-sm text-slate-500 font-medium">
          Showing <span class="text-teal-600 font-bold">{{ filteredAgencies.length }}</span> agencies
        </p>
        <!-- View toggle -->
        <div class="flex gap-1 bg-white rounded-lg p-1 shadow-sm">
          <button @click="view = 'grid'" :class="['view-btn', view === 'grid' ? 'view-btn-active' : '']">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
              <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
              <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
            </svg>
          </button>
          <button @click="view = 'list'" :class="['view-btn', view === 'list' ? 'view-btn-active' : '']">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- Agency Cards Grid -->
      <div :class="view === 'grid' ? 'grid grid-cols-3 gap-5 mb-10' : 'flex flex-col gap-4 mb-10'">
        <div
          v-for="agency in filteredAgencies"
          :key="agency.id"
          :class="['agency-card', view === 'list' ? 'agency-card-list' : '']"
        >
          <!-- Cover image -->
          <div class="agency-cover" :style="{ backgroundImage: `url(${agency.cover})` }">
            <span :class="['badge-verified', agency.verified ? 'badge-green' : 'badge-gray']">
              {{ agency.verified ? '✓ Verified' : 'Pending' }}
            </span>
          </div>

          <!-- Logo + name -->
          <div class="agency-header">
            <div class="agency-logo" :style="{ background: agency.color }">
              {{ agency.initials }}
            </div>
            <div class="flex-1 min-w-0">
              <h3 class="sora font-bold text-slate-900 text-base leading-tight truncate">{{ agency.name }}</h3>
              <div class="flex items-center gap-1 mt-0.5">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2">
                  <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                </svg>
                <span class="sora text-xs text-slate-400">{{ agency.city }}</span>
              </div>
            </div>
            <!-- Rating -->
            <div class="rating-badge">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="#f59e0b">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
              </svg>
              <span class="sora text-xs font-bold text-slate-700">{{ agency.rating }}</span>
            </div>
          </div>

          <!-- Stats row -->
          <div class="agency-stats">
            <div class="agency-stat">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                <rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/>
                <circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/>
              </svg>
              <span class="sora text-xs text-slate-600 font-medium">{{ agency.fleet }} vehicles</span>
            </div>
            <div class="agency-stat">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
              </svg>
              <span class="sora text-xs text-slate-600 font-medium">{{ agency.clients }}+ clients</span>
            </div>
            <div class="agency-stat">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
              </svg>
              <span class="sora text-xs text-slate-600 font-medium">Since {{ agency.since }}</span>
            </div>
          </div>

          <!-- Categories pills -->
          <div class="flex flex-wrap gap-1.5 px-4 pb-3">
            <span v-for="cat in agency.categories" :key="cat" class="cat-pill">{{ cat }}</span>
          </div>

          <!-- Actions -->
          <div class="agency-actions">
            <button class="sora btn-view-agency">View Agency</button>
            <button class="sora btn-contact">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.63A2 2 0 012 .18h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 14.92z"/>
              </svg>
              Contact
            </button>
          </div>
        </div>
      </div>

      <!-- ── Map Section ── -->
      <section class="map-section">
        <div class="map-header">
          <div>
            <h2 class="sora text-2xl font-bold text-slate-900 tracking-tight">Agency Locations</h2>
            <p class="sora text-sm text-slate-500 mt-1">All partner agencies across Morocco</p>
          </div>
          <button class="sora btn-open-map">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/>
            </svg>
            Open Full Map
          </button>
        </div>

        <!-- Stylized map placeholder -->
        <div class="map-container">
          <div class="map-bg">
            <!-- Grid lines -->
            <svg class="absolute inset-0 w-full h-full opacity-10" preserveAspectRatio="none">
              <defs>
                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                  <path d="M 40 0 L 0 0 0 40" fill="none" stroke="#0d9488" stroke-width="0.5"/>
                </pattern>
              </defs>
              <rect width="100%" height="100%" fill="url(#grid)"/>
            </svg>

            <!-- Map pins -->
            <div
              v-for="agency in agencies"
              :key="'pin-' + agency.id"
              class="map-pin"
              :style="{ left: agency.mapX + '%', top: agency.mapY + '%' }"
              @mouseenter="hoveredPin = agency.id"
              @mouseleave="hoveredPin = null"
            >
              <div :class="['pin-dot', hoveredPin === agency.id ? 'pin-dot-active' : '']">
                <div class="pin-inner"></div>
              </div>
              <div v-if="hoveredPin === agency.id" class="pin-tooltip">
                <p class="sora text-xs font-bold text-slate-900">{{ agency.name }}</p>
                <p class="sora text-xs text-slate-500">{{ agency.city }} · ⭐ {{ agency.rating }}</p>
              </div>
            </div>

            <!-- Morocco outline hint -->
            <div class="absolute bottom-4 left-4 flex items-center gap-2">
              <div class="w-3 h-3 rounded-full bg-teal-500 animate-ping opacity-60"></div>
              <span class="sora text-xs text-teal-700 font-semibold">{{ agencies.length }} agencies active</span>
            </div>

            <!-- Legend -->
            <div class="map-legend">
              <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-teal-500 border-2 border-white shadow"></div>
                <span class="sora text-xs text-slate-600">Verified Agency</span>
              </div>
              <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-slate-400 border-2 border-white shadow"></div>
                <span class="sora text-xs text-slate-600">Pending</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ── CTA: Register Agency ── -->
      <section class="register-cta">
        <div class="register-cta-inner">
          <div class="register-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8">
              <path d="M12 5v14M5 12h14"/>
            </svg>
          </div>
          <div>
            <h3 class="sora text-xl font-bold text-white mb-1">Own a Rental Agency?</h3>
            <p class="sora text-teal-100 text-sm">Join our network and reach thousands of customers across Morocco.</p>
          </div>
          <button class="sora btn-register-agency">Register Your Agency →</button>
        </div>
      </section>

    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const searchQuery = ref('')
const selectedCity = ref('')
const sortBy = ref('rating')
const view = ref('grid')
const hoveredPin = ref(null)

const cities = ['Casablanca', 'Marrakech', 'Rabat', 'Fès', 'Tanger', 'Agadir']

const globalStats = [
  { value: '48+', label: 'Partner Agencies' },
  { value: '1,200+', label: 'Vehicles Available' },
  { value: '12,000+', label: 'Happy Clients' },
  { value: '4.8★', label: 'Average Rating' },
]

const agencies = ref([
  {
    id: 1,
    name: 'Casablanca Premium Cars',
    city: 'Casablanca',
    initials: 'CP',
    color: '#0d9488',
    cover: 'https://images.unsplash.com/photo-1486325212027-8081e485255e?w=600&q=80',
    rating: 4.9,
    fleet: 85,
    clients: 3200,
    since: 2015,
    verified: true,
    categories: ['Luxury', 'SUV', 'Electric'],
    mapX: 28, mapY: 52,
  },
  {
    id: 2,
    name: 'Marrakech Drive',
    city: 'Marrakech',
    initials: 'MD',
    color: '#d97706',
    cover: 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80',
    rating: 4.7,
    fleet: 62,
    clients: 2100,
    since: 2017,
    verified: true,
    categories: ['Economy', 'Family', 'SUV'],
    mapX: 35, mapY: 68,
  },
  {
    id: 3,
    name: 'Rabat Royal Fleet',
    city: 'Rabat',
    initials: 'RR',
    color: '#7c3aed',
    cover: 'https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=600&q=80',
    rating: 4.8,
    fleet: 74,
    clients: 2800,
    since: 2014,
    verified: true,
    categories: ['Luxury', 'Electric', 'SUV'],
    mapX: 22, mapY: 40,
  },
  {
    id: 4,
    name: 'Fès Heritage Rentals',
    city: 'Fès',
    initials: 'FH',
    color: '#dc2626',
    cover: 'https://images.unsplash.com/photo-1543465077-db45d34b88a5?w=600&q=80',
    rating: 4.5,
    fleet: 41,
    clients: 1400,
    since: 2019,
    verified: false,
    categories: ['Economy', 'Family'],
    mapX: 48, mapY: 38,
  },
  {
    id: 5,
    name: 'Tanger Bay Motors',
    city: 'Tanger',
    initials: 'TB',
    color: '#0891b2',
    cover: 'https://images.unsplash.com/photo-1506521781263-d8422e82f27a?w=600&q=80',
    rating: 4.6,
    fleet: 53,
    clients: 1900,
    since: 2018,
    verified: true,
    categories: ['SUV', 'Economy', 'Luxury'],
    mapX: 30, mapY: 18,
  },
  {
    id: 6,
    name: 'Agadir Sun Rentals',
    city: 'Agadir',
    initials: 'AS',
    color: '#16a34a',
    cover: 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=600&q=80',
    rating: 4.7,
    fleet: 58,
    clients: 2300,
    since: 2016,
    verified: true,
    categories: ['Family', 'Electric', 'Economy'],
    mapX: 20, mapY: 78,
  },
])

const filteredAgencies = computed(() => {
  let list = agencies.value.filter(a => {
    const q = searchQuery.value.toLowerCase()
    const matchesSearch = !q || a.name.toLowerCase().includes(q) || a.city.toLowerCase().includes(q)
    const matchesCity = !selectedCity.value || a.city === selectedCity.value
    return matchesSearch && matchesCity
  })

  if (sortBy.value === 'rating') list = [...list].sort((a, b) => b.rating - a.rating)
  else if (sortBy.value === 'fleet') list = [...list].sort((a, b) => b.fleet - a.fleet)
  else if (sortBy.value === 'name') list = [...list].sort((a, b) => a.name.localeCompare(b.name))

  return list
})
</script>

<style scoped>
.sora { font-family: 'Sora', sans-serif; }

/* ── Hero ── */
.agencies-hero {
  position: relative;
  background: linear-gradient(135deg, #0f2027 0%, #0d4f47 50%, #0d9488 100%);
  overflow: hidden;
}
.agencies-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: url('https://images.unsplash.com/photo-1486325212027-8081e485255e?w=1400&q=60') center/cover no-repeat;
  opacity: 0.08;
}
.hero-gradient {
  background: linear-gradient(135deg, rgba(15,32,39,0.85) 0%, rgba(13,79,71,0.8) 60%, rgba(13,148,136,0.7) 100%);
}

.badge {
  display: inline-block;
  font-family: 'Sora', sans-serif;
  font-size: 0.75rem;
  font-weight: 600;
  color: #ccfbf1;
  background: rgba(255,255,255,0.12);
  border: 1px solid rgba(255,255,255,0.2);
  border-radius: 999px;
  padding: 0.3rem 0.9rem;
  letter-spacing: 0.03em;
  backdrop-filter: blur(4px);
}

/* ── Search Panel ── */
.search-panel {
  display: flex;
  align-items: center;
  gap: 0.6rem;
  background: white;
  border-radius: 14px;
  padding: 0.75rem 0.75rem;
  box-shadow: 0 12px 40px rgba(0,0,0,0.25);
  flex-wrap: wrap;
}

.search-input-wrap {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  flex: 1;
  min-width: 200px;
}
.search-icon { color: #9ca3af; flex-shrink: 0; }
.search-input {
  border: none;
  outline: none;
  font-size: 0.9rem;
  color: #374151;
  background: transparent;
  width: 100%;
}
.search-input::placeholder { color: #9ca3af; }

.filter-wrap {
  display: flex;
  align-items: center;
  gap: 0.4rem;
  border: 1.5px solid #e5e7eb;
  border-radius: 8px;
  padding: 0.45rem 0.75rem;
  transition: border-color 0.2s;
}
.filter-wrap:focus-within { border-color: #0d9488; }
.filter-select {
  border: none;
  outline: none;
  font-size: 0.82rem;
  color: #374151;
  background: transparent;
  cursor: pointer;
  font-weight: 500;
}

.btn-search-hero {
  display: flex;
  align-items: center;
  gap: 0.4rem;
  background: #0d9488;
  color: white;
  border: none;
  padding: 0.55rem 1.2rem;
  border-radius: 8px;
  font-size: 0.88rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.2s, transform 0.1s;
  white-space: nowrap;
}
.btn-search-hero:hover { background: #0f766e; transform: translateY(-1px); }

/* ── Stats Bar ── */
.stats-bar {
  display: flex;
  justify-content: center;
  gap: 0;
  background: white;
  border-bottom: 1px solid #e2e8f0;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.stat-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 1rem 3rem;
  border-right: 1px solid #f1f5f9;
  transition: background 0.2s;
}
.stat-item:last-child { border-right: none; }
.stat-item:hover { background: #f0fdfa; }
.stat-number {
  font-size: 1.5rem;
  font-weight: 800;
  color: #0d9488;
  letter-spacing: -0.02em;
  line-height: 1;
}
.stat-label {
  font-size: 0.72rem;
  color: #64748b;
  font-weight: 500;
  margin-top: 0.2rem;
  letter-spacing: 0.02em;
  text-transform: uppercase;
}

/* ── View Toggle ── */
.view-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  border-radius: 6px;
  border: none;
  background: transparent;
  color: #94a3b8;
  cursor: pointer;
  transition: all 0.15s;
}
.view-btn:hover { background: #f1f5f9; color: #475569; }
.view-btn-active { background: #0d9488 !important; color: white !important; }

/* ── Agency Card ── */
.agency-card {
  background: white;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(0,0,0,0.06);
  transition: transform 0.2s, box-shadow 0.2s;
  display: flex;
  flex-direction: column;
}
.agency-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 32px rgba(13,148,136,0.15);
}

.agency-card-list {
  flex-direction: row;
  align-items: stretch;
}
.agency-card-list .agency-cover {
  width: 160px;
  height: auto;
  flex-shrink: 0;
  border-radius: 0;
}
.agency-card-list .agency-header,
.agency-card-list .agency-stats,
.agency-card-list .agency-actions {
  flex: 1;
}

.agency-cover {
  height: 130px;
  background-size: cover;
  background-position: center;
  position: relative;
}

.badge-verified {
  position: absolute;
  top: 10px;
  right: 10px;
  font-family: 'Sora', sans-serif;
  font-size: 0.68rem;
  font-weight: 700;
  padding: 0.2rem 0.55rem;
  border-radius: 999px;
}
.badge-green { background: #d1fae5; color: #065f46; }
.badge-gray  { background: #f1f5f9; color: #64748b; }

.agency-header {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.85rem 1rem 0.5rem;
}

.agency-logo {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Sora', sans-serif;
  font-weight: 800;
  font-size: 0.85rem;
  color: white;
  flex-shrink: 0;
  letter-spacing: -0.02em;
}

.rating-badge {
  display: flex;
  align-items: center;
  gap: 0.25rem;
  background: #fefce8;
  border: 1px solid #fde68a;
  border-radius: 8px;
  padding: 0.2rem 0.45rem;
  flex-shrink: 0;
}

.agency-stats {
  display: flex;
  gap: 0.75rem;
  padding: 0.4rem 1rem 0.6rem;
  flex-wrap: wrap;
}
.agency-stat {
  display: flex;
  align-items: center;
  gap: 0.3rem;
}

.cat-pill {
  font-family: 'Sora', sans-serif;
  font-size: 0.65rem;
  font-weight: 600;
  color: #0d9488;
  background: #f0fdfa;
  border: 1px solid #99f6e4;
  border-radius: 999px;
  padding: 0.15rem 0.55rem;
}

.agency-actions {
  display: flex;
  gap: 0.6rem;
  padding: 0.75rem 1rem;
  border-top: 1px solid #f1f5f9;
  margin-top: auto;
}

.btn-view-agency {
  flex: 1;
  background: #0d9488;
  color: white;
  border: none;
  padding: 0.55rem 0;
  border-radius: 8px;
  font-size: 0.82rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.2s, transform 0.1s;
}
.btn-view-agency:hover { background: #0f766e; transform: translateY(-1px); }

.btn-contact {
  display: flex;
  align-items: center;
  gap: 0.35rem;
  border: 1.5px solid #e2e8f0;
  background: white;
  color: #475569;
  padding: 0.55rem 0.85rem;
  border-radius: 8px;
  font-size: 0.82rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
}
.btn-contact:hover { border-color: #0d9488; color: #0d9488; background: #f0fdfa; }

/* ── Map ── */
.map-section {
  background: white;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 4px 16px rgba(0,0,0,0.06);
  margin-bottom: 2rem;
}
.map-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1.25rem 1.5rem 1rem;
  border-bottom: 1px solid #f1f5f9;
}
.btn-open-map {
  display: flex;
  align-items: center;
  gap: 0.4rem;
  border: 1.5px solid #e2e8f0;
  background: white;
  color: #0d9488;
  padding: 0.45rem 0.85rem;
  border-radius: 8px;
  font-size: 0.82rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
}
.btn-open-map:hover { background: #f0fdfa; border-color: #0d9488; }

.map-container { padding: 0; }
.map-bg {
  position: relative;
  height: 320px;
  background: linear-gradient(135deg, #e0f2fe 0%, #f0fdfa 40%, #d1fae5 100%);
  overflow: hidden;
}

/* Map pins */
.map-pin {
  position: absolute;
  transform: translate(-50%, -50%);
  cursor: pointer;
  z-index: 10;
}
.pin-dot {
  width: 16px;
  height: 16px;
  border-radius: 50%;
  background: #0d9488;
  border: 3px solid white;
  box-shadow: 0 2px 8px rgba(13,148,136,0.4);
  transition: all 0.2s;
  display: flex;
  align-items: center;
  justify-content: center;
}
.pin-dot::before {
  content: '';
  position: absolute;
  width: 28px;
  height: 28px;
  border-radius: 50%;
  background: rgba(13,148,136,0.15);
  animation: pulse 2s infinite;
}
.pin-dot-active {
  transform: scale(1.4);
  background: #0f766e;
  box-shadow: 0 4px 16px rgba(13,148,136,0.5);
}
.pin-inner {
  width: 5px;
  height: 5px;
  border-radius: 50%;
  background: white;
}

.pin-tooltip {
  position: absolute;
  bottom: calc(100% + 10px);
  left: 50%;
  transform: translateX(-50%);
  background: white;
  border-radius: 8px;
  padding: 0.4rem 0.65rem;
  box-shadow: 0 4px 16px rgba(0,0,0,0.12);
  white-space: nowrap;
  pointer-events: none;
  border: 1px solid #e2e8f0;
  z-index: 20;
}
.pin-tooltip::after {
  content: '';
  position: absolute;
  top: 100%;
  left: 50%;
  transform: translateX(-50%);
  border: 5px solid transparent;
  border-top-color: white;
}

.map-legend {
  position: absolute;
  bottom: 12px;
  right: 12px;
  background: white;
  border-radius: 8px;
  padding: 0.5rem 0.75rem;
  display: flex;
  flex-direction: column;
  gap: 0.35rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  border: 1px solid #e2e8f0;
}

@keyframes pulse {
  0%, 100% { transform: scale(1); opacity: 0.6; }
  50% { transform: scale(1.6); opacity: 0; }
}

/* ── Register CTA ── */
.register-cta {
  background: linear-gradient(135deg, #0d4f47 0%, #0d9488 100%);
  border-radius: 20px;
  overflow: hidden;
  margin-bottom: 2rem;
  position: relative;
}
.register-cta::before {
  content: '';
  position: absolute;
  inset: 0;
  background: url('https://images.unsplash.com/photo-1486325212027-8081e485255e?w=800&q=40') center/cover;
  opacity: 0.06;
}
.register-cta-inner {
  position: relative;
  display: flex;
  align-items: center;
  gap: 1.5rem;
  padding: 2rem 2.5rem;
  flex-wrap: wrap;
}
.register-icon {
  width: 56px;
  height: 56px;
  background: rgba(255,255,255,0.15);
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  backdrop-filter: blur(4px);
}
.btn-register-agency {
  margin-left: auto;
  background: white;
  color: #0d9488;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 10px;
  font-size: 0.9rem;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s;
  white-space: nowrap;
}
.btn-register-agency:hover {
  background: #f0fdfa;
  transform: translateY(-2px);
  box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}
</style>