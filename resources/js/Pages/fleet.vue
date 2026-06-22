<template>
  <div class="bg-slate-100 min-h-screen font-['Sora',sans-serif]">

    <!-- ── Hero ── -->
    <section class="relative overflow-hidden" style="background:linear-gradient(135deg,#0f2027 0%,#0d4f47 50%,#0d9488 100%)">
      <div class="absolute inset-0" style="background:url('https://images.unsplash.com/photo-1486325212027-8081e485255e?w=1400&q=50') center/cover no-repeat;opacity:0.07"></div>
      <div class="absolute inset-0" style="background:linear-gradient(135deg,rgba(15,32,39,0.82) 0%,rgba(13,79,71,0.78) 100%)"></div>
      <div class="relative z-10 text-center max-w-4xl mx-auto px-8 py-14">
        <span class="inline-block text-xs font-semibold text-teal-100 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 backdrop-blur-sm">🚗 Premium Vehicle Collection</span>
        <h1 class="text-5xl font-bold text-white mt-4 mb-3 tracking-tight" style="text-shadow:0 2px 16px rgba(0,0,0,0.3)">Our Fleet</h1>
        <p class="text-teal-100 text-lg font-medium mb-8">Browse our curated selection of vehicles — luxury, family, electric and more.</p>
        <div class="flex items-center gap-3 bg-white rounded-2xl px-5 py-3.5 shadow-2xl max-w-xl mx-auto">
          <svg class="text-gray-400 shrink-0" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
          <input v-model="searchQuery" type="text" placeholder="Search by model, brand or category..."
            class="flex-1 border-none outline-none text-sm text-gray-700 bg-transparent placeholder-gray-400 font-['Sora',sans-serif]"/>
          <button class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-5 py-2 rounded-lg border-none cursor-pointer transition-colors whitespace-nowrap font-['Sora',sans-serif]">Search</button>
        </div>
      </div>
    </section>

    <!-- ── Main Content ── -->
    <div class="max-w-screen-xl mx-auto px-8 py-8">
      <div class="flex gap-6 items-start">

        <!-- ── Sidebar ── -->
        <aside class="w-56 flex-shrink-0 sticky top-20">

          <div class="bg-white rounded-xl p-4 mb-3 border border-slate-200 shadow-sm">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Category</h3>
            <div class="flex flex-col gap-2">
              <label v-for="cat in categories" :key="cat.value" class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" :value="cat.value" v-model="selectedCategories" class="accent-teal-600 w-3.5 h-3.5 cursor-pointer"/>
                <span class="text-sm text-slate-600 flex-1">{{ cat.label }}</span>
                <span class="text-xs text-slate-400 font-semibold">{{ cat.count }}</span>
              </label>
            </div>
          </div>

          <div class="bg-white rounded-xl p-4 mb-3 border border-slate-200 shadow-sm">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Price / day</h3>
            <div class="flex justify-between mb-1.5">
              <span class="text-xs text-teal-600 font-bold">${{ priceRange[0] }}</span>
              <span class="text-xs text-teal-600 font-bold">${{ priceRange[1] }}</span>
            </div>
            <input type="range" min="20" max="600" v-model="priceRange[1]" class="w-full accent-teal-600 mb-3"/>
            <div class="flex gap-2">
              <div class="flex-1 border border-slate-200 rounded-lg px-2 py-1.5 flex flex-col">
                <span class="text-xs text-slate-400">Min</span>
                <input type="number" v-model="priceRange[0]" class="border-none outline-none text-xs text-slate-700 bg-transparent w-full font-['Sora',sans-serif]"/>
              </div>
              <div class="flex-1 border border-slate-200 rounded-lg px-2 py-1.5 flex flex-col">
                <span class="text-xs text-slate-400">Max</span>
                <input type="number" v-model="priceRange[1]" class="border-none outline-none text-xs text-slate-700 bg-transparent w-full font-['Sora',sans-serif]"/>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-xl p-4 mb-3 border border-slate-200 shadow-sm">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Fuel Type</h3>
            <div class="flex flex-col gap-2">
              <label v-for="fuel in fuelTypes" :key="fuel" class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" :value="fuel" v-model="selectedFuels" class="accent-teal-600 w-3.5 h-3.5 cursor-pointer"/>
                <span class="text-sm text-slate-600">{{ fuel }}</span>
              </label>
            </div>
          </div>

          <div class="bg-white rounded-xl p-4 mb-3 border border-slate-200 shadow-sm">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Transmission</h3>
            <div class="flex flex-col gap-2">
              <label v-for="t in transmissions" :key="t" class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" :value="t" v-model="selectedTransmissions" class="accent-teal-600 w-3.5 h-3.5 cursor-pointer"/>
                <span class="text-sm text-slate-600">{{ t }}</span>
              </label>
            </div>
          </div>

          <div class="bg-white rounded-xl p-4 mb-3 border border-slate-200 shadow-sm">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Availability</h3>
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" v-model="onlyAvailable" class="accent-teal-600 w-3.5 h-3.5 cursor-pointer"/>
              <span class="text-sm text-slate-600">Available now only</span>
            </label>
          </div>

          <button @click="resetFilters"
            class="w-full border border-slate-200 hover:border-teal-500 hover:text-teal-600 hover:bg-teal-50 bg-white text-slate-500 text-xs font-bold py-2.5 rounded-xl cursor-pointer transition-all font-['Sora',sans-serif]">
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
              <div class="flex items-center gap-1.5 border border-slate-200 rounded-lg px-3 py-2 bg-white focus-within:border-teal-500 transition-colors">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><path d="M3 6h18M7 12h10M11 18h2"/></svg>
                <select v-model="sortBy" class="border-none outline-none text-xs text-gray-700 bg-transparent cursor-pointer font-semibold font-['Sora',sans-serif]">
                  <option value="price-asc">Price: Low → High</option>
                  <option value="price-desc">Price: High → Low</option>
                  <option value="rating">Top Rated</option>
                  <option value="name">A–Z</option>
                </select>
              </div>
              <div class="flex gap-1 bg-white rounded-lg p-1 border border-slate-200 shadow-sm">
                <button @click="view='grid'" :class="['flex items-center justify-center w-8 h-8 rounded-md border-none cursor-pointer transition-all', view==='grid' ? 'bg-teal-600 text-white' : 'bg-transparent text-slate-400 hover:bg-slate-100']">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                </button>
                <button @click="view='list'" :class="['flex items-center justify-center w-8 h-8 rounded-md border-none cursor-pointer transition-all', view==='list' ? 'bg-teal-600 text-white' : 'bg-transparent text-slate-400 hover:bg-slate-100']">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Active filter pills -->
          <div v-if="activeFilters.length" class="flex flex-wrap gap-2 mb-4">
            <span v-for="f in activeFilters" :key="f.key"
              class="inline-flex items-center text-xs font-semibold text-teal-600 bg-teal-50 border border-teal-200 rounded-full px-3 py-1">
              {{ f.label }}
              <button @click="removeFilter(f)" class="ml-1.5 opacity-60 hover:opacity-100 bg-transparent border-none cursor-pointer text-teal-600 text-xs">✕</button>
            </span>
          </div>

          <!-- Empty state -->
          <div v-if="filteredCars.length===0" class="flex flex-col items-center justify-center py-24 bg-white rounded-2xl">
            <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <p class="text-slate-400 font-semibold mt-4">No vehicles match your filters</p>
            <button @click="resetFilters" class="text-teal-600 text-sm font-semibold mt-2 underline bg-transparent border-none cursor-pointer font-['Sora',sans-serif]">Clear all filters</button>
          </div>

          <!-- ── Grid View ── -->
          <div v-else-if="view==='grid'" class="grid grid-cols-3 gap-5">
            <div v-for="car in filteredCars" :key="car.id"
              class="bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm transition-all duration-200 hover:-translate-y-1.5 hover:shadow-xl hover:border-teal-400 flex flex-col">

              <!-- Image -->
              <div class="relative h-48 overflow-hidden bg-slate-100">
                <img :src="car.image" :alt="car.name" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"/>
                <div class="absolute inset-0" style="background:linear-gradient(to top,rgba(0,0,0,0.2) 0%,transparent 55%)"></div>
                <span :class="['absolute top-2.5 left-2.5 text-xs font-bold px-2 py-0.5 rounded-full', car.available ? 'bg-emerald-100/95 text-emerald-800' : 'bg-red-100/95 text-red-800']">
                  {{ car.available ? '● Available' : '● Rented' }}
                </span>
                <button @click="toggleWishlist(car.id)"
                  class="absolute top-2 right-2 w-8 h-8 rounded-full bg-white shadow-md border-none flex items-center justify-center cursor-pointer transition-transform duration-200 hover:scale-110">
                  <svg width="15" height="15" viewBox="0 0 24 24" :fill="wishlist.includes(car.id)?'#ef4444':'none'" stroke="#ef4444" stroke-width="2.2">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                  </svg>
                </button>
                <span class="absolute bottom-2.5 right-2.5 text-xs font-bold text-white bg-black/40 backdrop-blur-sm px-2 py-0.5 rounded-full">{{ car.category }}</span>
              </div>

              <!-- Body -->
              <div class="p-4 flex flex-col flex-1">
                <div class="flex items-center justify-between mb-0.5">
                  <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ car.brand }}</span>
                  <div class="flex items-center gap-1 bg-yellow-50 border border-yellow-200 rounded-lg px-1.5 py-0.5">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="#f59e0b"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <span class="text-xs font-bold text-slate-700">{{ car.rating }}</span>
                    <span class="text-xs text-slate-400">({{ car.reviews }})</span>
                  </div>
                </div>
                <h3 class="font-extrabold text-slate-900 text-base leading-tight mb-0.5">{{ car.name }}</h3>
                <p class="text-xs text-slate-400 mb-3">{{ car.year }} · {{ car.transmission }}</p>

                <!-- Specs 2x2 -->
                <div class="grid grid-cols-2 gap-2 mb-4">
                  <div class="flex items-center gap-1.5 bg-slate-50 rounded-lg px-2.5 py-2">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    <span class="text-xs text-slate-500 font-semibold">{{ car.seats }} Seats</span>
                  </div>
                  <div class="flex items-center gap-1.5 bg-slate-50 rounded-lg px-2.5 py-2">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                    <span class="text-xs text-slate-500 font-semibold">{{ car.fuel }}</span>
                  </div>
                  <div class="flex items-center gap-1.5 bg-slate-50 rounded-lg px-2.5 py-2">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>
                    <span class="text-xs text-slate-500 font-semibold">{{ car.doors }} Doors</span>
                  </div>
                  <div class="flex items-center gap-1.5 bg-slate-50 rounded-lg px-2.5 py-2">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                    <span class="text-xs text-slate-500 font-semibold">{{ car.ac ? 'A/C' : 'No A/C' }}</span>
                  </div>
                </div>

                <!-- Price + Book -->
                <div class="flex items-center justify-between pt-3 border-t border-slate-100 mt-auto">
                  <div>
                    <span class="text-2xl font-extrabold text-slate-900">${{ car.pricePerDay }}</span>
                    <span class="text-xs text-slate-400">/day</span>
                  </div>
                  <RouterLink v-if="car.available" :to="`/fleet/${car.id}`"
                    class="text-sm font-bold px-4 py-2 rounded-lg bg-teal-600 hover:bg-teal-700 text-white transition-all duration-200 no-underline hover:-translate-y-px">
                    Book Now
                  </RouterLink>
                  <span v-else class="text-sm font-bold px-4 py-2 rounded-lg bg-slate-100 text-slate-400 cursor-not-allowed">
                    Unavailable
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- ── List View ── -->
          <div v-else class="flex flex-col gap-4">
            <div v-for="car in filteredCars" :key="car.id"
              class="bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm flex transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg hover:border-teal-400">

              <!-- Image -->
              <div class="relative w-56 flex-shrink-0">
                <img :src="car.image" :alt="car.name" class="w-full h-full object-cover"/>
                <span :class="['absolute top-2.5 left-2.5 text-xs font-bold px-2 py-0.5 rounded-full', car.available ? 'bg-emerald-100/95 text-emerald-800' : 'bg-red-100/95 text-red-800']">
                  {{ car.available ? '● Available' : '● Rented' }}
                </span>
              </div>

              <!-- Details -->
              <div class="flex-1 p-5 min-w-0">
                <div class="flex items-start justify-between mb-1">
                  <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ car.brand }}</span>
                    <h3 class="text-lg font-extrabold text-slate-900 leading-tight">{{ car.name }}</h3>
                    <p class="text-xs text-slate-400">{{ car.year }} · {{ car.category }} · {{ car.transmission }}</p>
                  </div>
                  <div class="flex items-center gap-1 bg-yellow-50 border border-yellow-200 rounded-lg px-2 py-1 flex-shrink-0 ml-3">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="#f59e0b"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <span class="text-sm font-bold text-slate-700">{{ car.rating }}</span>
                    <span class="text-xs text-slate-400">({{ car.reviews }})</span>
                  </div>
                </div>
                <div class="flex items-center gap-4 mt-3 flex-wrap">
                  <div class="flex items-center gap-1.5">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    <span class="text-sm text-slate-500">{{ car.seats }} seats</span>
                  </div>
                  <div class="flex items-center gap-1.5">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                    <span class="text-sm text-slate-500">{{ car.fuel }}</span>
                  </div>
                  <div class="flex items-center gap-1.5">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>
                    <span class="text-sm text-slate-500">{{ car.doors }} doors</span>
                  </div>
                  <div class="flex items-center gap-1.5">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                    <span class="text-sm text-slate-500">{{ car.ac ? 'Air Conditioning' : 'No A/C' }}</span>
                  </div>
                </div>
              </div>

              <!-- Price -->
              <div class="flex flex-col items-end justify-between p-5 border-l border-slate-100 min-w-36">
                <div class="text-right">
                  <div>
                    <span class="text-3xl font-extrabold text-slate-900">${{ car.pricePerDay }}</span>
                    <span class="text-xs text-slate-400">/day</span>
                  </div>
                  <p class="text-xs text-slate-400 mt-0.5">${{ car.pricePerDay * 7 }}/week</p>
                </div>
                <RouterLink v-if="car.available" :to="`/fleet/${car.id}`"
                  class="w-full text-center text-sm font-bold px-4 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white transition-all duration-200 no-underline mt-4 block hover:-translate-y-px">
                  Book Now
                </RouterLink>
                <span v-else class="w-full text-center text-sm font-bold px-4 py-2.5 rounded-xl bg-slate-100 text-slate-400 cursor-not-allowed mt-4 block">
                  Unavailable
                </span>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="max-w-screen-xl mx-auto px-8 py-4 flex items-center justify-between border-t border-slate-200 mt-4">
      <span class="text-xs text-slate-500">Partners: Atlas Drive, - Opportunities</span>
      <div class="flex items-center gap-5">
        <span class="text-sm font-bold text-amber-400">amazon</span>
        <span class="text-sm font-bold text-gray-700">🌿 croncat</span>
        <span class="text-sm font-bold text-gray-700">✦ Atlas Drive</span>
        <span class="text-sm">🔴🟠</span>
        <span class="text-sm font-bold text-blue-900">PayPal</span>
        <span class="text-base font-bold italic text-blue-950">VISA</span>
      </div>
    </footer>

  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const view = ref('grid')
const searchQuery = ref('')
const selectedCategories = ref([])
const selectedFuels = ref([])
const selectedTransmissions = ref([])
const onlyAvailable = ref(false)
const priceRange = ref([20, 600])
const sortBy = ref('price-asc')
const wishlist = ref([])

const categories   = [
  { label:'Luxury',   value:'Luxury',   count:4 },
  { label:'SUV',      value:'SUV',      count:4 },
  { label:'Economy',  value:'Economy',  count:4 },
  { label:'Electric', value:'Electric', count:3 },
  { label:'Family',   value:'Family',   count:3 },
]
const fuelTypes     = ['Petrol','Diesel','Electric','Hybrid']
const transmissions = ['Automatic','Manual']

const cars = ref([
  { id:1,  name:'BMW 5 Series 530i',       brand:'BMW',         year:2023, category:'Luxury',   pricePerDay:180, seats:5, fuel:'Petrol',   transmission:'Automatic', doors:4, rating:4.9, reviews:128, available:true,  ac:true, image:'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=700&q=85' },
  { id:2,  name:'Mercedes-Benz E-Class',   brand:'Mercedes-Benz',year:2023,category:'Luxury',   pricePerDay:200, seats:5, fuel:'Diesel',   transmission:'Automatic', doors:4, rating:4.8, reviews:94,  available:true,  ac:true, image:'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?w=700&q=85' },
  { id:3,  name:'Audi A6 Quattro',         brand:'Audi',        year:2023, category:'Luxury',   pricePerDay:195, seats:5, fuel:'Petrol',   transmission:'Automatic', doors:4, rating:4.8, reviews:87,  available:false, ac:true, image:'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?w=700&q=85' },
  { id:4,  name:'Porsche Cayenne GTS',     brand:'Porsche',     year:2023, category:'Luxury',   pricePerDay:380, seats:5, fuel:'Petrol',   transmission:'Automatic', doors:4, rating:4.9, reviews:52,  available:true,  ac:true, image:'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=700&q=85' },
  { id:5,  name:'Toyota Land Cruiser',     brand:'Toyota',      year:2023, category:'SUV',      pricePerDay:175, seats:7, fuel:'Diesel',   transmission:'Automatic', doors:5, rating:4.9, reviews:211, available:true,  ac:true, image:'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=700&q=85' },
  { id:6,  name:'Honda CR-V Hybrid',       brand:'Honda',       year:2023, category:'SUV',      pricePerDay:115, seats:5, fuel:'Hybrid',   transmission:'Automatic', doors:5, rating:4.7, reviews:199, available:true,  ac:true, image:'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?w=700&q=85' },
  { id:7,  name:'Dacia Duster 4x4',        brand:'Dacia',       year:2022, category:'SUV',      pricePerDay:65,  seats:5, fuel:'Diesel',   transmission:'Manual',    doors:5, rating:4.3, reviews:184, available:true,  ac:true, image:'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?w=700&q=85' },
  { id:8,  name:'Hyundai Tucson N Line',   brand:'Hyundai',     year:2023, category:'SUV',      pricePerDay:95,  seats:5, fuel:'Petrol',   transmission:'Automatic', doors:5, rating:4.5, reviews:143, available:false, ac:true, image:'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=700&q=85' },
  { id:9,  name:'Toyota Corolla 1.6',      brand:'Toyota',      year:2022, category:'Economy',  pricePerDay:48,  seats:5, fuel:'Petrol',   transmission:'Manual',    doors:4, rating:4.5, reviews:318, available:true,  ac:true, image:'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?w=700&q=85' },
  { id:10, name:'Volkswagen Polo TSI',     brand:'Volkswagen',  year:2022, category:'Economy',  pricePerDay:42,  seats:5, fuel:'Petrol',   transmission:'Manual',    doors:4, rating:4.4, reviews:265, available:true,  ac:true, image:'https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=700&q=85' },
  { id:11, name:'Renault Clio RS Line',    brand:'Renault',     year:2022, category:'Economy',  pricePerDay:38,  seats:5, fuel:'Petrol',   transmission:'Automatic', doors:4, rating:4.3, reviews:201, available:true,  ac:true, image:'https://images.unsplash.com/photo-1609521263047-f8f205293f24?w=700&q=85' },
  { id:12, name:'Peugeot 208 Active',      brand:'Peugeot',     year:2023, category:'Economy',  pricePerDay:40,  seats:5, fuel:'Petrol',   transmission:'Manual',    doors:4, rating:4.4, reviews:178, available:false, ac:true, image:'https://images.unsplash.com/photo-1571127236794-81c0bbfe1ce3?w=700&q=85' },
  { id:13, name:'Tesla Model 3 LR',        brand:'Tesla',       year:2024, category:'Electric', pricePerDay:160, seats:5, fuel:'Electric', transmission:'Automatic', doors:4, rating:4.9, reviews:215, available:true,  ac:true, image:'https://images.unsplash.com/photo-1560958089-b8a1929cea89?w=700&q=85' },
  { id:14, name:'Renault Zoe R135',        brand:'Renault',     year:2023, category:'Electric', pricePerDay:78,  seats:5, fuel:'Electric', transmission:'Automatic', doors:4, rating:4.5, reviews:140, available:true,  ac:true, image:'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=700&q=85' },
  { id:15, name:'Peugeot e-2008',          brand:'Peugeot',     year:2023, category:'Electric', pricePerDay:95,  seats:5, fuel:'Electric', transmission:'Automatic', doors:5, rating:4.6, reviews:89,  available:false, ac:true, image:'https://images.unsplash.com/photo-1486325212027-8081e485255e?w=700&q=85' },
  { id:16, name:'Volkswagen Touran',       brand:'Volkswagen',  year:2022, category:'Family',   pricePerDay:110, seats:7, fuel:'Diesel',   transmission:'Automatic', doors:5, rating:4.6, reviews:162, available:true,  ac:true, image:'https://images.unsplash.com/photo-1506521781263-d8422e82f27a?w=700&q=85' },
  { id:17, name:'Ford S-MAX Titanium',     brand:'Ford',        year:2022, category:'Family',   pricePerDay:105, seats:7, fuel:'Diesel',   transmission:'Automatic', doors:5, rating:4.5, reviews:134, available:true,  ac:true, image:'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=700&q=85' },
  { id:18, name:'Citroën Berlingo XL',     brand:'Citroën',     year:2023, category:'Family',   pricePerDay:88,  seats:7, fuel:'Petrol',   transmission:'Manual',    doors:5, rating:4.4, reviews:97,  available:false, ac:true, image:'https://images.unsplash.com/photo-1543465077-db45d34b88a5?w=700&q=85' },
])

const filteredCars = computed(() => {
  let list = cars.value.filter(car => {
    const q = searchQuery.value.toLowerCase()
    const matchSearch = !q || car.name.toLowerCase().includes(q) || car.brand.toLowerCase().includes(q) || car.category.toLowerCase().includes(q)
    const matchCat    = !selectedCategories.value.length || selectedCategories.value.includes(car.category)
    const matchFuel   = !selectedFuels.value.length || selectedFuels.value.includes(car.fuel)
    const matchTrans  = !selectedTransmissions.value.length || selectedTransmissions.value.includes(car.transmission)
    const matchPrice  = car.pricePerDay >= priceRange.value[0] && car.pricePerDay <= priceRange.value[1]
    const matchAvail  = !onlyAvailable.value || car.available
    return matchSearch && matchCat && matchFuel && matchTrans && matchPrice && matchAvail
  })
  if (sortBy.value==='price-asc')  list = [...list].sort((a,b) => a.pricePerDay-b.pricePerDay)
  if (sortBy.value==='price-desc') list = [...list].sort((a,b) => b.pricePerDay-a.pricePerDay)
  if (sortBy.value==='rating')     list = [...list].sort((a,b) => b.rating-a.rating)
  if (sortBy.value==='name')       list = [...list].sort((a,b) => a.name.localeCompare(b.name))
  return list
})

const activeFilters = computed(() => {
  const f = []
  selectedCategories.value.forEach(c  => f.push({ key:'cat-'+c,   label:c,              type:'cat',   value:c }))
  selectedFuels.value.forEach(v       => f.push({ key:'fuel-'+v,  label:v,              type:'fuel',  value:v }))
  selectedTransmissions.value.forEach(v => f.push({ key:'trans-'+v, label:v,            type:'trans', value:v }))
  if (onlyAvailable.value)               f.push({ key:'avail',    label:'Available only',type:'avail'         })
  return f
})
function removeFilter(f) {
  if (f.type==='cat')   selectedCategories.value    = selectedCategories.value.filter(v=>v!==f.value)
  if (f.type==='fuel')  selectedFuels.value         = selectedFuels.value.filter(v=>v!==f.value)
  if (f.type==='trans') selectedTransmissions.value = selectedTransmissions.value.filter(v=>v!==f.value)
  if (f.type==='avail') onlyAvailable.value = false
}
function resetFilters() {
  selectedCategories.value = []
  selectedFuels.value = []
  selectedTransmissions.value = []
  onlyAvailable.value = false
  priceRange.value = [20, 600]
  searchQuery.value = ''
}
function toggleWishlist(id) {
  wishlist.value = wishlist.value.includes(id)
    ? wishlist.value.filter(i=>i!==id)
    : [...wishlist.value, id]
}
</script>copose