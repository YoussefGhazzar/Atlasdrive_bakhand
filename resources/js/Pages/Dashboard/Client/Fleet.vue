<template>
    <DashbordClient :client="props.client" title="Fleet" subtitle="Available Cars">
  <div class="min-h-screen bg-slate-50" style="font-family:'Sora',sans-serif;">

    <!-- ── Header ── -->
    <div class="bg-white border-b border-slate-200 px-6 py-8">
      <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-extrabold text-slate-900 mb-1"
          style="font-family:'Plus Jakarta Sans',sans-serif;">
          Available Cars
        </h1>
        <p class="text-slate-500 text-sm">{{ filteredCars.length }} vehicles available</p>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8 flex gap-6">

      <!-- ── Sidebar Filters ── -->
      <aside class="w-56 flex-shrink-0 hidden lg:block">

        <!-- Search -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 mb-4 shadow-sm">
          <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-3">Search</p>
          <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2">
              <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input v-model="search" type="text" placeholder="Search cars..."
              class="flex-1 border-none outline-none text-sm text-slate-700 bg-transparent placeholder-slate-400"/>
          </div>
        </div>

        <!-- Category -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 mb-4 shadow-sm">
          <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-3">Category</p>
          <div class="flex flex-col gap-1.5">
            <button
              v-for="cat in ['All', ...categories.map(c => c.name)]" :key="cat"
              @click="selectedCategory = cat"
              :class="[
                'text-left text-sm px-3 py-2 rounded-xl border-none cursor-pointer transition-all',
                selectedCategory === cat
                  ? 'bg-teal-600 text-white font-bold'
                  : 'bg-transparent text-slate-600 hover:bg-slate-50 font-medium'
              ]">
              {{ cat }}
            </button>
          </div>
        </div>

        <!-- Price range -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 mb-4 shadow-sm">
          <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-3">Max Price/day</p>
          <input v-model="maxPrice" type="range" min="50" max="500" step="10"
            class="w-full accent-teal-600"/>
          <div class="flex justify-between text-xs text-slate-500 mt-1">
            <span>50DH</span>
            <span class="font-bold text-teal-600">{{ maxPrice }}DH</span>
            <span>500DH</span>
          </div>
        </div>

        <!-- Transmission -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 mb-4 shadow-sm">
          <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-3">Transmission</p>
          <div class="flex flex-col gap-1.5">
            <button v-for="t in ['All','manuelle','automatique']" :key="t"
              @click="selectedTransmission = t"
              :class="[
                'text-left text-sm px-3 py-2 rounded-xl border-none cursor-pointer transition-all capitalize',
                selectedTransmission === t
                  ? 'bg-teal-600 text-white font-bold'
                  : 'bg-transparent text-slate-600 hover:bg-slate-50 font-medium'
              ]">
              {{ t === 'All' ? 'All' : t === 'manuelle' ? 'Manual' : 'Automatic' }}
            </button>
          </div>
        </div>

        <!-- Reset -->
        <button @click="resetFilters"
          class="w-full py-2.5 rounded-xl border border-slate-200 text-slate-500 text-sm font-semibold bg-white hover:bg-slate-50 cursor-pointer transition-all">
          Reset Filters
        </button>
      </aside>

      <!-- ── Car Grid ── -->
      <div class="flex-1">

        <!-- Sort bar -->
        <div class="flex items-center justify-between mb-5">
          <p class="text-sm text-slate-500">
            Showing <span class="font-bold text-slate-800">{{ filteredCars.length }}</span> vehicles
          </p>
          <select v-model="sortBy"
            class="text-sm border border-slate-200 rounded-xl px-3 py-2 outline-none bg-white text-slate-700 cursor-pointer">
            <option value="price_asc">Price: Low to High</option>
            <option value="price_desc">Price: High to Low</option>
            <option value="name_asc">Name A–Z</option>
          </select>
        </div>

        <!-- Empty state -->
        <div v-if="filteredCars.length === 0"
          class="flex flex-col items-center justify-center py-24 bg-white rounded-2xl border border-slate-200">
          <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.2">
            <rect x="2" y="9" width="20" height="9" rx="2"/>
            <path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/>
            <circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/>
          </svg>
          <p class="text-slate-400 font-semibold mt-4">No cars match your filters</p>
          <button @click="resetFilters"
            class="mt-3 text-sm text-teal-600 font-bold hover:underline bg-transparent border-none cursor-pointer">
            Clear filters
          </button>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
          <div v-for="car in filteredCars" :key="car.id"
            class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hover:border-teal-300 hover:shadow-md transition-all duration-200 flex flex-col">

            <!-- Image -->
            <div class="relative">
              <img
                :src="car.image || 'https://via.placeholder.com/400x300?text=No+Image'"
                :alt="car.marque + ' ' + car.modele"
                class="w-full h-44 object-cover"/>
              <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm text-teal-700 text-xs font-bold px-2.5 py-1 rounded-full border border-teal-100">
                {{ car.category?.name ?? 'Car' }}
              </span>
              <span v-if="!car.disponible"
                class="absolute top-3 right-3 bg-red-500 text-white text-xs font-bold px-2.5 py-1 rounded-full">
                Unavailable
              </span>
            </div>

            <!-- Info -->
            <div class="p-4 flex flex-col flex-1">
              <h3 class="text-base font-extrabold text-slate-900 mb-0.5"
                style="font-family:'Plus Jakarta Sans',sans-serif;">
                {{ car.marque }} {{ car.modele }}
              </h3>
              <p class="text-xs text-slate-400 mb-3">{{ car.annee }} · {{ car.agency?.name ?? '' }}</p>

              <!-- Specs -->
              <div class="grid grid-cols-2 gap-2 mb-4">
                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                  </svg>
                  {{ car.nb_places }} seats
                </div>
                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 8v4l3 3"/>
                  </svg>
                  {{ car.transmission === 'manuelle' ? 'Manual' : 'Auto' }}
                </div>
                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                    <path d="M3 22V8l9-6 9 6v14"/>
                    <path d="M9 22V12h6v10"/>
                  </svg>
                  {{ car.city ?? '' }}
                </div>
                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                  </svg>
                  {{ car.carburant }}
                </div>
              </div>

              <!-- Price + CTA -->
              <div class="flex items-center justify-between mt-auto pt-3 border-t border-slate-100">
                <div>
                  <span class="text-2xl font-extrabold text-slate-900">{{ car.prix_par_jour }}DH</span>
                  <span class="text-xs text-slate-400">/day</span>
                </div>
                <Link
                  v-if="car.disponible"
                  :href="`/cars/${car.id}`"
                  class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl no-underline transition-colors">
                  Book Now
                </Link>
                <span v-else
                  class="text-xs font-bold text-slate-400 px-4 py-2.5 rounded-xl bg-slate-100">
                  Unavailable
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    </DashbordClient>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import DashbordClient from '@/Layouts/DashbordClient.vue'
const props = defineProps({
  cars:       { type: Array, default: () => [] },
  categories: { type: Array, default: () => [] },
})

// ── Filters ────────────────────────────────────────────────
const search              = ref('')
const selectedCategory    = ref('All')
const selectedTransmission = ref('All')
const maxPrice            = ref(500)
const sortBy              = ref('price_asc')

const filteredCars = computed(() => {
  let list = props.cars

  if (search.value)
    list = list.filter(c =>
      (c.marque + ' ' + c.modele).toLowerCase().includes(search.value.toLowerCase())
    )

  if (selectedCategory.value !== 'All')
    list = list.filter(c => c.category?.name === selectedCategory.value)

  if (selectedTransmission.value !== 'All')
    list = list.filter(c => c.transmission === selectedTransmission.value)

  list = list.filter(c => c.prix_par_jour <= maxPrice.value)

  if (sortBy.value === 'price_asc')  list = [...list].sort((a, b) => a.prix_par_jour - b.prix_par_jour)
  if (sortBy.value === 'price_desc') list = [...list].sort((a, b) => b.prix_par_jour - a.prix_par_jour)
  if (sortBy.value === 'name_asc')   list = [...list].sort((a, b) => a.marque.localeCompare(b.marque))

  return list
})

function resetFilters() {
  search.value               = ''
  selectedCategory.value     = 'All'
  selectedTransmission.value = 'All'
  maxPrice.value             = 500
  sortBy.value               = 'price_asc'
}
</script>