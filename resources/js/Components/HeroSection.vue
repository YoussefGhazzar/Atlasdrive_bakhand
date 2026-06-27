<template>
  <section
    class="relative h-[300px] flex items-center justify-center"
    style="background: url('https://images.unsplash.com/photo-1485291571150-772bcfc10da5?w=1400&q=80') center/cover no-repeat;"
  >
    <!-- Overlay -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/25 to-black/35" />

    <!-- Content -->
    <div class="relative z-10 text-center w-full max-w-[900px] px-6">
      <h1
        class="text-[2.4rem] font-bold text-white mb-6 tracking-tight drop-shadow-md"
        style="font-family:'Sora',sans-serif; text-shadow:0 2px 8px rgba(0,0,0,0.3);"
      >
        Find Your Perfect Drive
      </h1>

      <!-- Search Bar -->
      <div class="flex items-end gap-3 bg-white rounded-2xl px-5 py-5 shadow-2xl">

        <!-- Pick-up Location -->
        <div class="flex flex-col gap-1.5 flex-1">
          <label class="text-xs font-semibold text-gray-700 text-left" style="font-family:'Sora',sans-serif;">
            Pick-up Location
          </label>
          <div class="flex items-center border border-gray-200 rounded-lg px-3 py-2 gap-2 focus-within:border-teal-500 transition-colors bg-white">
            <svg class="text-gray-400 shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input
              v-model="form.location"
              type="text"
              placeholder="Pick-up Location"
              class="border-none outline-none text-sm text-gray-700 bg-transparent w-full"
              style="font-family:'Sora',sans-serif;"
            />
          </div>
        </div>

        <!-- Dates -->
        <div class="flex flex-col gap-1.5 flex-1">
          <label class="text-xs font-semibold text-gray-700 text-left" style="font-family:'Sora',sans-serif;">
            Dates
          </label>
          <div class="flex items-center border border-gray-200 rounded-lg px-3 py-2 gap-1.5 focus-within:border-teal-500 transition-colors bg-white">
            <svg class="text-gray-400 shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
              <line x1="16" y1="2" x2="16" y2="6"/>
              <line x1="8" y1="2" x2="8" y2="6"/>
              <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <input
              v-model="form.dateFrom"
              type="text"
              placeholder="Start date"
              class="border-none outline-none text-sm text-gray-700 bg-transparent w-[70px] min-w-0"
              style="font-family:'Sora',sans-serif;"
            />
            <span class="text-gray-400 text-sm">–</span>
            <svg class="text-gray-400 shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
              <line x1="16" y1="2" x2="16" y2="6"/>
              <line x1="8" y1="2" x2="8" y2="6"/>
              <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <input
              v-model="form.dateTo"
              type="text"
              placeholder="End date"
              class="border-none outline-none text-sm text-gray-700 bg-transparent w-[70px] min-w-0"
              style="font-family:'Sora',sans-serif;"
            />
          </div>
        </div>

        <!-- Vehicle Type -->
        <div class="flex flex-col gap-1.5 flex-1">
          <label class="text-xs font-semibold text-gray-700 text-left" style="font-family:'Sora',sans-serif;">
            Vehicle Type
          </label>
          <div class="flex items-center border border-gray-200 rounded-lg px-3 py-2 gap-2 focus-within:border-teal-500 transition-colors bg-white">
            <select
              v-model="form.vehicleType"
              class="border-none outline-none text-sm text-gray-700 bg-transparent w-full cursor-pointer"
              style="font-family:'Sora',sans-serif;"
            >
              <option value="">Vehicle Type</option>
              <option>Luxury</option>
              <option>SUV</option>
              <option>Economy</option>
              <option>Electric</option>
              <option>Family</option>
            </select>
          </div>
        </div>

        <!-- Search Button -->
        <button
          @click="search"
          class="bg-teal-600 hover:bg-teal-700 active:translate-y-px text-white font-semibold text-[0.95rem]
                 px-6 h-10 rounded-lg whitespace-nowrap transition-all duration-150 shrink-0"
          style="font-family:'Sora',sans-serif;"
        >
          Search
        </button>

      </div>
    </div>
  </section>
</template>

<script setup>
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'

const form = reactive({
  location: '',
  dateFrom: '',
  dateTo: '',
  vehicleType: '',
})

function search() {
  router.get(route('fleet'), form, { preserveState: true })
}
</script>
