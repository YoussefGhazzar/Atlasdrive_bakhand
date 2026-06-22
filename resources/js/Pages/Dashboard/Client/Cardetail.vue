<template>
  <div class="min-h-screen bg-slate-50" style="font-family:'Sora',sans-serif;">
    <Navbar />

    <div class="max-w-6xl mx-auto px-6 py-10">

      <!-- Back link -->
      <Link :href="route('client.fleet')" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-teal-600 no-underline mb-6 transition-colors">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/>
        </svg>
        Back to fleet
      </Link>

      <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

        <!-- ── Left: Car info ── -->
        <div class="lg:col-span-3">

          <!-- Image -->
          <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-5">
            <img :src="car.image || placeholderImg" :alt="car.marque + ' ' + car.modele"
              class="w-full h-80 object-cover"/>
          </div>

          <!-- Title + price -->
          <div class="flex items-start justify-between mb-5">
            <div>
              <span class="text-xs font-bold text-teal-600 bg-teal-50 border border-teal-100 px-2.5 py-1 rounded-full">
                {{ car.category?.name ?? 'Car' }}
              </span>
              <h1 class="text-2xl font-extrabold text-slate-900 mt-2"
                style="font-family:'Plus Jakarta Sans',sans-serif;">
                {{ car.marque }} {{ car.modele }}
              </h1>
              <p class="text-sm text-slate-400 mt-0.5">{{ car.annee }} · {{ car.agency?.name }} · {{ car.city }}</p>
            </div>
            <div class="text-right flex-shrink-0">
              <span class="text-3xl font-extrabold text-slate-900">{{ car.prix_par_jour }}DH</span>
              <span class="text-sm text-slate-400">/day</span>
            </div>
          </div>

          <!-- Specs -->
          <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-5">
            <h3 class="text-sm font-bold text-slate-800 mb-4">Specifications</h3>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
              <div class="flex flex-col items-center gap-1.5 text-center">
                <div class="w-9 h-9 rounded-xl bg-teal-50 flex items-center justify-center">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                  </svg>
                </div>
                <p class="text-xs text-slate-500">{{ car.nb_places }} Seats</p>
              </div>
              <div class="flex flex-col items-center gap-1.5 text-center">
                <div class="w-9 h-9 rounded-xl bg-teal-50 flex items-center justify-center">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/>
                  </svg>
                </div>
                <p class="text-xs text-slate-500 capitalize">{{ car.transmission === 'manuelle' ? 'Manual' : 'Automatic' }}</p>
              </div>
              <div class="flex flex-col items-center gap-1.5 text-center">
                <div class="w-9 h-9 rounded-xl bg-teal-50 flex items-center justify-center">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                  </svg>
                </div>
                <p class="text-xs text-slate-500 capitalize">{{ car.carburant }}</p>
              </div>
              <div class="flex flex-col items-center gap-1.5 text-center">
                <div class="w-9 h-9 rounded-xl bg-teal-50 flex items-center justify-center">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                    <circle cx="13.5" cy="6.5" r=".5"/><circle cx="17.5" cy="10.5" r=".5"/>
                    <circle cx="8.5" cy="7.5" r=".5"/><circle cx="6.5" cy="12.5" r=".5"/>
                    <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10c0-.926-.42-1.7-1.1-2.1-.49-.34-1.1-.32-1.71-.05A4 4 0 0 1 17 9a3.5 3.5 0 0 1-3.5-3.5c0-.7.19-1.36.5-1.93A8.94 8.94 0 0 0 12 2z"/>
                  </svg>
                </div>
                <p class="text-xs text-slate-500">{{ car.couleur ?? '—' }}</p>
              </div>
            </div>
          </div>

          <!-- Description -->
          <div v-if="car.description" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <h3 class="text-sm font-bold text-slate-800 mb-2">About this car</h3>
            <p class="text-sm text-slate-600 leading-relaxed">{{ car.description }}</p>
          </div>
        </div>

        <!-- ── Right: Booking form ── -->
        <div class="lg:col-span-2">
          <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sticky top-6">

            <h3 class="text-base font-bold text-slate-900 mb-4">Reserve this car</h3>

            <!-- Unavailable banner -->
            <div v-if="!car.disponible"
              class="bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-xl mb-4">
              This vehicle is currently unavailable.
            </div>

            <template v-else>
              <!-- Dates -->
              <div class="grid grid-cols-2 gap-3 mb-4">
                <div class="flex flex-col gap-1.5">
                  <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Pick-up</label>
                  <input v-model="form.date_debut" type="date" :min="today"
                    class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors"/>
                  <p v-if="form.errors.date_debut" class="text-xs text-red-500">{{ form.errors.date_debut }}</p>
                </div>
                <div class="flex flex-col gap-1.5">
                  <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Return</label>
                  <input v-model="form.date_fin" type="date" :min="form.date_debut || today"
                    class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors"/>
                  <p v-if="form.errors.date_fin" class="text-xs text-red-500">{{ form.errors.date_fin }}</p>
                </div>
              </div>

              <!-- Notes -->
              <div class="flex flex-col gap-1.5 mb-4">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Notes (optional)</label>
                <textarea v-model="form.notes" rows="3" placeholder="Any special requests..."
                  class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors resize-none"></textarea>
              </div>

              <!-- Price breakdown -->
              <div v-if="numberOfDays > 0" class="bg-slate-50 rounded-xl p-4 mb-4 flex flex-col gap-2">
                <div class="flex justify-between text-sm">
                  <span class="text-slate-500">{{ car.prix_par_jour }}DH × {{ numberOfDays }} days</span>
                  <span class="font-semibold text-slate-700">{{ totalPrice }}DH</span>
                </div>
                <div class="border-t border-slate-200 pt-2 flex justify-between">
                  <span class="font-bold text-slate-900">Total</span>
                  <span class="font-extrabold text-teal-600 text-lg">{{ totalPrice }}DH</span>
                </div>
              </div>

              <!-- Submit -->
              <button @click="handleBook" :disabled="form.processing || numberOfDays <= 0"
                class="w-full py-3.5 rounded-xl text-sm font-bold text-white border-none cursor-pointer transition-all duration-200 active:scale-[.98] disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);">
                <span v-if="form.processing"
                  class="w-4 h-4 rounded-full animate-spin flex-shrink-0"
                  style="border:2.5px solid rgba(255,255,255,.3);border-top-color:#fff"></span>
                {{ form.processing ? 'Booking...' : 'Confirm Reservation' }}
              </button>

              <p class="text-xs text-slate-400 text-center mt-3">
                You won't be charged yet. Payment is collected at pick-up.
              </p>
            </template>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'
import Navbar from '@/Components/Navbar.vue'

const props = defineProps({
  car: { type: Object, required: true },
})

const placeholderImg = 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?w=800&q=80'
const today = new Date().toISOString().split('T')[0]

const form = useForm({
  voiture_id: props.car.id,
  date_debut: '',
  date_fin:   '',
  notes:      '',
})

const numberOfDays = computed(() => {
  if (!form.date_debut || !form.date_fin) return 0
  const start = new Date(form.date_debut)
  const end   = new Date(form.date_fin)
  const diff  = (end - start) / (1000 * 60 * 60 * 24)
  return diff > 0 ? diff : 0
})

const totalPrice = computed(() => numberOfDays.value * props.car.prix_par_jour)

function handleBook() {
  form.post(route('reservations.store'), {
    onSuccess: () => {},
  })
}
</script>