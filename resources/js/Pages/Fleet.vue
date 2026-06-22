<template>
  <div class="bg-slate-100 min-h-screen" style="font-family:'Sora',sans-serif;">
    <navbar />
    <!-- ── Hero ── -->
    <section class="relative overflow-hidden"
      style="background: linear-gradient(135deg, #0f2027 0%, #0d4f47 50%, #0d9488 100%);">
      <div class="absolute inset-0 opacity-[0.07]"
        style="background: url('https://images.unsplash.com/photo-1486325212027-8081e485255e?w=1400&q=50') center/cover no-repeat;"></div>
      <div class="absolute inset-0"
        style="background: linear-gradient(135deg, rgba(15,32,39,0.82) 0%, rgba(13,79,71,0.78) 100%);"></div>

      <div class="relative z-10 text-center max-w-4xl mx-auto px-8 py-14">
        <span class="inline-block text-xs font-semibold text-teal-100 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 backdrop-blur-sm">
          🚗 Premium Vehicle Collection
        </span>
        <h1 class="text-5xl font-bold text-white mt-4 mb-3 tracking-tight"
          style="text-shadow:0 2px 16px rgba(0,0,0,0.3); font-family:'Plus Jakarta Sans',sans-serif;">
          Our Fleet
        </h1>
        <p class="text-teal-100 text-lg font-medium mb-8">
          Browse our curated selection of vehicles — luxury, family, electric and more.
        </p>

        <div class="flex items-center gap-3 bg-white rounded-2xl px-5 py-3.5 shadow-2xl max-w-xl mx-auto">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" class="flex-shrink-0">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
          </svg>
          <input v-model="searchQuery" type="text"
            placeholder="Search by model, brand or category..."
            class="flex-1 border-none outline-none text-sm text-slate-700 bg-transparent placeholder-slate-400"/>
          <button class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-5 py-2 rounded-lg border-none cursor-pointer transition-colors whitespace-nowrap">
            Search
          </button>
        </div>
      </div>
    </section>

    <!-- ── Main Layout ── -->
    <div class="max-w-7xl mx-auto px-8 py-8">
      <div class="flex gap-6 items-start">

        <!-- ── Sidebar ── -->
        <aside class="w-60 flex-shrink-0 sticky top-20 hidden lg:block">

          <!-- Category -->
          <div class="bg-white rounded-xl p-4 mb-3 border border-slate-200 shadow-sm">
            <h3 class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest mb-3">Category</h3>
            <div class="flex flex-col gap-2">
              <label v-for="cat in categories" :key="cat.value" class="flex items-center gap-2.5 cursor-pointer py-0.5">
                <input type="checkbox" :value="cat.value" v-model="selectedCategories"
                  class="accent-teal-600 w-3.5 h-3.5 cursor-pointer flex-shrink-0"/>
                <span class="text-sm text-slate-600 flex-1">{{ cat.label }}</span>
                <span class="text-xs text-slate-400 font-semibold">{{ cat.count }}</span>
              </label>
            </div>
          </div>

          <!-- Price -->
          <div class="bg-white rounded-xl p-4 mb-3 border border-slate-200 shadow-sm">
            <h3 class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest mb-3">Price per day</h3>
            <div class="flex justify-between mb-2">
              <span class="text-xs font-bold text-teal-600">${{ priceRange[0] }}</span>
              <span class="text-xs font-bold text-teal-600">${{ priceRange[1] }}</span>
            </div>
            <input type="range" min="20" max="600" v-model="priceRange[1]"
              class="w-full accent-teal-600 mb-3"/>
            <div class="flex gap-2">
              <div class="flex-1 border border-slate-200 rounded-lg px-2.5 py-1.5 flex flex-col">
                <span class="text-[0.7rem] text-slate-400">Min</span>
                <input type="number" v-model="priceRange[0]"
                  class="border-none outline-none text-sm text-slate-700 bg-transparent w-full"/>
              </div>
              <div class="flex-1 border border-slate-200 rounded-lg px-2.5 py-1.5 flex flex-col">
                <span class="text-[0.7rem] text-slate-400">Max</span>
                <input type="number" v-model="priceRange[1]"
                  class="border-none outline-none text-sm text-slate-700 bg-transparent w-full"/>
              </div>
            </div>
          </div>

          <!-- Fuel -->
          <div class="bg-white rounded-xl p-4 mb-3 border border-slate-200 shadow-sm">
            <h3 class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest mb-3">Fuel Type</h3>
            <div class="flex flex-col gap-2">
              <label v-for="fuel in fuelTypes" :key="fuel" class="flex items-center gap-2.5 cursor-pointer py-0.5">
                <input type="checkbox" :value="fuel" v-model="selectedFuels"
                  class="accent-teal-600 w-3.5 h-3.5 cursor-pointer flex-shrink-0"/>
                <span class="text-sm text-slate-600">{{ fuel }}</span>
              </label>
            </div>
          </div>

          <!-- Transmission -->
          <div class="bg-white rounded-xl p-4 mb-3 border border-slate-200 shadow-sm">
            <h3 class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest mb-3">Transmission</h3>
            <div class="flex flex-col gap-2">
              <label v-for="t in transmissions" :key="t" class="flex items-center gap-2.5 cursor-pointer py-0.5">
                <input type="checkbox" :value="t" v-model="selectedTransmissions"
                  class="accent-teal-600 w-3.5 h-3.5 cursor-pointer flex-shrink-0"/>
                <span class="text-sm text-slate-600">{{ t }}</span>
              </label>
            </div>
          </div>

          <!-- Availability -->
          <div class="bg-white rounded-xl p-4 mb-3 border border-slate-200 shadow-sm">
            <h3 class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest mb-3">Availability</h3>
            <label class="flex items-center gap-2.5 cursor-pointer">
              <input type="checkbox" v-model="onlyAvailable" class="accent-teal-600 w-3.5 h-3.5 cursor-pointer flex-shrink-0"/>
              <span class="text-sm text-slate-600">Available now only</span>
            </label>
          </div>

          <button @click="resetFilters"
            class="w-full border border-slate-200 bg-white text-slate-500 hover:border-teal-500 hover:text-teal-600 hover:bg-teal-50 py-2.5 rounded-xl text-sm font-semibold cursor-pointer transition-all">
            ↺ Reset all filters
          </button>
        </aside>

        <!-- ── Results ── -->
        <div class="flex-1 min-w-0">

          <!-- Toolbar -->
          <div class="flex items-center justify-between mb-5 flex-wrap gap-3">
            <p class="text-sm text-slate-500">
              Showing <span class="text-teal-600 font-bold">{{ filteredCars.length }}</span> vehicles
            </p>
            <div class="flex items-center gap-3">
              <div class="flex items-center gap-1.5 border border-slate-200 rounded-lg px-3 py-2 bg-white">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                  <path d="M3 6h18M7 12h10M11 18h2"/>
                </svg>
                <select v-model="sortBy" class="border-none outline-none text-sm text-slate-700 bg-transparent cursor-pointer font-medium">
                  <option value="price-asc">Price: Low → High</option>
                  <option value="price-desc">Price: High → Low</option>
                  <option value="rating">Top Rated</option>
                  <option value="name">A–Z</option>
                </select>
              </div>
              <div class="flex gap-0.5 bg-white rounded-lg p-0.5 border border-slate-200">
                <button @click="view = 'grid'"
                  :class="['flex items-center justify-center w-[30px] h-[30px] rounded-md border-none cursor-pointer transition-all',
                    view === 'grid' ? 'bg-teal-600 text-white' : 'bg-transparent text-slate-400 hover:bg-slate-100 hover:text-slate-600']">
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                    <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                  </svg>
                </button>
                <button @click="view = 'list'"
                  :class="['flex items-center justify-center w-[30px] h-[30px] rounded-md border-none cursor-pointer transition-all',
                    view === 'list' ? 'bg-teal-600 text-white' : 'bg-transparent text-slate-400 hover:bg-slate-100 hover:text-slate-600']">
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Active pills -->
          <div v-if="activeFilters.length" class="flex flex-wrap gap-2 mb-4">
            <span v-for="f in activeFilters" :key="f.key"
              class="inline-flex items-center text-xs font-semibold text-teal-600 bg-teal-50 border border-teal-200 rounded-full px-3 py-1">
              {{ f.label }}
              <button @click="removeFilter(f)"
                class="ml-1.5 opacity-60 hover:opacity-100 cursor-pointer bg-transparent border-none text-xs">✕</button>
            </span>
          </div>

          <!-- Empty -->
          <div v-if="filteredCars.length === 0"
            class="flex flex-col items-center justify-center py-20 px-8 bg-white rounded-2xl">
            <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.2">
              <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <p class="text-slate-400 font-semibold mt-4">No vehicles match your filters</p>
            <button @click="resetFilters"
              class="text-teal-600 text-sm font-semibold mt-2 bg-transparent border-none cursor-pointer underline">
              Clear all filters
            </button>
          </div>

          <!-- ── GRID VIEW ── -->
          <div v-else-if="view === 'grid'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <div v-for="car in filteredCars" :key="car.id"
              class="bg-white rounded-2xl overflow-hidden border-[1.5px] border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1.5 hover:border-teal-500 transition-all duration-200 flex flex-col group">

              <!-- Image -->
              <div class="relative h-48 overflow-hidden bg-slate-100">
                <img :src="car.image" :alt="car.name"
                  class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(0,0,0,0.25) 0%, transparent 60%);"></div>

                <span :class="['absolute top-2.5 left-2.5 text-[0.65rem] font-bold px-2.5 py-1 rounded-full',
                  car.available ? 'bg-emerald-100/95 text-emerald-800' : 'bg-red-100/95 text-red-800']">
                  {{ car.available ? '● Available' : '● Rented' }}
                </span>

                <button @click="toggleWishlist(car.id)" title="Save"
                  class="absolute top-2 right-2 w-8 h-8 rounded-full bg-white border-none cursor-pointer flex items-center justify-center shadow-md hover:scale-110 transition-transform">
                  <svg width="15" height="15" viewBox="0 0 24 24"
                    :fill="wishlist.includes(car.id) ? '#ef4444' : 'none'"
                    stroke="#ef4444" stroke-width="2.2">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                  </svg>
                </button>

                <span class="absolute bottom-2.5 right-2.5 text-[0.65rem] font-bold text-white bg-black/45 backdrop-blur-sm px-2.5 py-1 rounded-full">
                  {{ car.category }}
                </span>
              </div>

              <!-- Card Body -->
              <div class="p-4 flex flex-col flex-1">
                <div class="flex items-center justify-between mb-1">
                  <span class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-wider">{{ car.brand }}</span>
                  <div class="flex items-center gap-1">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="#f59e0b">
                      <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    <span class="text-sm font-bold text-slate-700">{{ car.rating }}</span>
                    <span class="text-xs text-slate-400">({{ car.reviews }})</span>
                  </div>
                </div>

                <h3 class="text-base font-extrabold text-slate-900 leading-tight mb-0.5">{{ car.name }}</h3>
                <p class="text-xs text-slate-400 mb-3.5">{{ car.year }} · {{ car.transmission }}</p>

                <!-- Specs -->
                <div class="grid grid-cols-2 gap-2 mb-4">
                  <div class="flex items-center gap-1.5 bg-slate-50 rounded-md px-2 py-1.5">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                      <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                    </svg>
                    <span class="text-xs text-slate-600 font-semibold">{{ car.seats }} Seats</span>
                  </div>
                  <div class="flex items-center gap-1.5 bg-slate-50 rounded-md px-2 py-1.5">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                      <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                    </svg>
                    <span class="text-xs text-slate-600 font-semibold">{{ car.fuel }}</span>
                  </div>
                  <div class="flex items-center gap-1.5 bg-slate-50 rounded-md px-2 py-1.5">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                      <rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/>
                      <circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/>
                    </svg>
                    <span class="text-xs text-slate-600 font-semibold">{{ car.doors }} Doors</span>
                  </div>
                  <div class="flex items-center gap-1.5 bg-slate-50 rounded-md px-2 py-1.5">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                      <circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/>
                    </svg>
                    <span class="text-xs text-slate-600 font-semibold">{{ car.ac ? 'A/C' : 'No A/C' }}</span>
                  </div>
                </div>

                <!-- Price + Book -->
                <div class="flex items-center justify-between mt-auto pt-3.5 border-t border-slate-100">
                  <div>
                    <span class="text-2xl font-extrabold text-slate-900">${{ car.pricePerDay }}</span>
                    <span class="text-xs text-slate-400 ml-0.5">/day</span>
                  </div>
                  <Link v-if="car.available" :href="`/cars/${car.id}`"
                    class="bg-teal-600 hover:bg-teal-700 hover:-translate-y-0.5 text-white text-xs font-bold px-4 py-2 rounded-lg no-underline transition-all">
                    Book Now
                  </Link>
                  <span v-else class="bg-slate-100 text-slate-400 text-xs font-bold px-4 py-2 rounded-lg cursor-not-allowed">
                    Unavailable
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- ── LIST VIEW ── -->
          <div v-else class="flex flex-col gap-4">
            <div v-for="car in filteredCars" :key="car.id"
              class="bg-white rounded-2xl overflow-hidden border-[1.5px] border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-0.5 hover:border-teal-500 transition-all duration-200 flex flex-col sm:flex-row">

              <div class="relative w-full sm:w-60 flex-shrink-0 h-48 sm:h-auto">
                <img :src="car.image" :alt="car.name" class="w-full h-full object-cover"/>
                <span :class="['absolute top-2.5 left-2.5 text-[0.65rem] font-bold px-2.5 py-1 rounded-full',
                  car.available ? 'bg-emerald-100/95 text-emerald-800' : 'bg-red-100/95 text-red-800']">
                  {{ car.available ? '● Available' : '● Rented' }}
                </span>
              </div>

              <div class="flex-1 p-5 min-w-0">
                <div class="flex items-start justify-between mb-1 flex-wrap gap-2">
                  <div>
                    <span class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-wider">{{ car.brand }}</span>
                    <h3 class="text-lg font-extrabold text-slate-900 leading-tight my-0.5">{{ car.name }}</h3>
                    <p class="text-xs text-slate-400">{{ car.year }} · {{ car.category }} · {{ car.transmission }}</p>
                  </div>
                  <div class="flex items-center gap-1 bg-yellow-50 border border-yellow-200 px-2 py-1 rounded-lg">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="#f59e0b">
                      <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    <span class="text-sm font-bold text-slate-700">{{ car.rating }}</span>
                    <span class="text-xs text-slate-400">({{ car.reviews }})</span>
                  </div>
                </div>

                <div class="flex gap-3 sm:gap-6 mt-4 flex-wrap">
                  <div class="flex items-center gap-1.5 bg-slate-50 rounded-md px-2 py-1.5">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                      <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                    </svg>
                    <span class="text-xs text-slate-600 font-semibold">{{ car.seats }} Seats</span>
                  </div>
                  <div class="flex items-center gap-1.5 bg-slate-50 rounded-md px-2 py-1.5">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                      <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                    </svg>
                    <span class="text-xs text-slate-600 font-semibold">{{ car.fuel }}</span>
                  </div>
                  <div class="flex items-center gap-1.5 bg-slate-50 rounded-md px-2 py-1.5">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                      <rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/>
                      <circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/>
                    </svg>
                    <span class="text-xs text-slate-600 font-semibold">{{ car.doors }} Doors</span>
                  </div>
                  <div class="flex items-center gap-1.5 bg-slate-50 rounded-md px-2 py-1.5">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                      <circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/>
                    </svg>
                    <span class="text-xs text-slate-600 font-semibold">{{ car.ac ? 'Air Conditioning' : 'No A/C' }}</span>
                  </div>
                </div>
              </div>

              <div class="flex sm:flex-col items-center sm:items-end justify-between p-5 border-t sm:border-t-0 sm:border-l border-slate-100 sm:min-w-[150px]">
                <div class="text-right">
                  <div>
                    <span class="text-2xl sm:text-[1.75rem] font-extrabold text-slate-900">${{ car.pricePerDay }}</span>
                    <span class="text-xs text-slate-400">/day</span>
                  </div>
                  <p class="text-[0.72rem] text-slate-400 mt-0.5">${{ car.pricePerDay * 7 }}/week</p>
                </div>
                <Link v-if="car.available" :href="`/cars/${car.id}`"
                  class="sm:w-full sm:mt-4 bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold px-4 py-2.5 rounded-lg no-underline text-center transition-colors">
                  Book Now
                </Link>
                <span v-else class="sm:w-full sm:mt-4 bg-slate-100 text-slate-400 text-sm font-bold px-4 py-2.5 rounded-lg text-center cursor-not-allowed">
                  Unavailable
                </span>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Footer -->
    <Footer />

  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import navbar from '@/Components/Navbar.vue'
import Footer from '@/Components/Footer.vue'
// Cars now come from the Laravel controller as a prop, not a local ref
const props = defineProps({
  cars:       { type: Array, default: () => [] },
  categories: { type: Array, default: () => [] },
})

const view                  = ref('grid')
const searchQuery           = ref('')
const selectedCategories    = ref([])
const selectedFuels         = ref([])
const selectedTransmissions = ref([])
const onlyAvailable         = ref(false)
const priceRange            = ref([20, 600])
const sortBy                = ref('price-asc')
const wishlist               = ref([])

const fuelTypes     = ['Petrol', 'Diesel', 'Electric', 'Hybrid']
const transmissions  = ['Automatic', 'Manual']

const filteredCars = computed(() => {
  let list = props.cars.filter(car => {
    const q = searchQuery.value.toLowerCase()
    const matchSearch = !q
      || car.name.toLowerCase().includes(q)
      || car.brand.toLowerCase().includes(q)
      || car.category.toLowerCase().includes(q)
    const matchCat   = !selectedCategories.value.length || selectedCategories.value.includes(car.category)
    const matchFuel  = !selectedFuels.value.length || selectedFuels.value.includes(car.fuel)
    const matchTrans = !selectedTransmissions.value.length || selectedTransmissions.value.includes(car.transmission)
    const matchPrice = car.pricePerDay >= priceRange.value[0] && car.pricePerDay <= priceRange.value[1]
    const matchAvail = !onlyAvailable.value || car.available
    return matchSearch && matchCat && matchFuel && matchTrans && matchPrice && matchAvail
  })

  if (sortBy.value === 'price-asc')  list = [...list].sort((a, b) => a.pricePerDay - b.pricePerDay)
  if (sortBy.value === 'price-desc') list = [...list].sort((a, b) => b.pricePerDay - a.pricePerDay)
  if (sortBy.value === 'rating')     list = [...list].sort((a, b) => b.rating - a.rating)
  if (sortBy.value === 'name')       list = [...list].sort((a, b) => a.name.localeCompare(b.name))

  return list
})

const activeFilters = computed(() => {
  const f = []
  selectedCategories.value.forEach(c    => f.push({ key: 'cat-'   + c, label: c, type: 'cat',   value: c }))
  selectedFuels.value.forEach(v         => f.push({ key: 'fuel-'  + v, label: v, type: 'fuel',  value: v }))
  selectedTransmissions.value.forEach(v => f.push({ key: 'trans-' + v, label: v, type: 'trans', value: v }))
  if (onlyAvailable.value) f.push({ key: 'avail', label: 'Available only', type: 'avail' })
  return f
})

function removeFilter(f) {
  if (f.type === 'cat')   selectedCategories.value    = selectedCategories.value.filter(v => v !== f.value)
  if (f.type === 'fuel')  selectedFuels.value         = selectedFuels.value.filter(v => v !== f.value)
  if (f.type === 'trans') selectedTransmissions.value = selectedTransmissions.value.filter(v => v !== f.value)
  if (f.type === 'avail') onlyAvailable.value = false
}

function resetFilters() {
  selectedCategories.value    = []
  selectedFuels.value         = []
  selectedTransmissions.value = []
  onlyAvailable.value         = false
  priceRange.value            = [20, 600]
  searchQuery.value           = ''
}

function toggleWishlist(id) {
  wishlist.value = wishlist.value.includes(id)
    ? wishlist.value.filter(i => i !== id)
    : [...wishlist.value, id]
}
</script>