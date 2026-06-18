<template>
  <AgencyDashboardLayout title="Fleet" subtitle="Manage your vehicles" :agency="agency">

    <div class="flex items-center justify-between mb-5">
      <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-3 py-2 w-72 shadow-sm">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2">
          <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
        </svg>
        <input v-model="fleetSearch" type="text" placeholder="Search vehicles..."
          class="flex-1 border-none outline-none text-sm text-slate-700 bg-transparent placeholder-slate-400"/>
      </div>
      <button @click="openAddModal"
        class="flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold px-4 py-2.5 rounded-xl border-none cursor-pointer transition-colors">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Add Vehicle
      </button>
    </div>

    <!-- Fleet table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      <table class="w-full">
        <thead class="bg-slate-50">
          <tr>
            <th v-for="h in ['Vehicle','Category','Price/day','Status','Bookings','Actions']" :key="h"
              class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest px-5 py-3">{{ h }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="car in filteredFleet" :key="car.id"
            class="border-t border-slate-50 hover:bg-slate-50 transition-colors">
            <td class="px-5 py-3">
              <div class="flex items-center gap-3">
                <img :src="car.image || placeholderImg" :alt="car.marque" class="w-12 h-9 object-cover rounded-lg flex-shrink-0"/>
                <div>
                  <p class="text-sm font-bold text-slate-800">{{ car.marque }} {{ car.modele }}</p>
                  <p class="text-xs text-slate-400">{{ car.annee }}</p>
                </div>
              </div>
            </td>
            <td class="px-5 py-3">
              <span class="text-xs font-semibold text-teal-600 bg-teal-50 border border-teal-100 px-2 py-0.5 rounded-full">
                {{ car.category?.name ?? '—' }}
              </span>
            </td>
            <td class="px-5 py-3 text-sm font-bold text-slate-700">${{ car.prix_par_jour }}</td>
            <td class="px-5 py-3">
              <span :class="['text-xs font-bold px-2.5 py-1 rounded-full', car.disponible ? 'bg-emerald-50 text-emerald-700' : 'bg-orange-50 text-orange-600']">
                {{ car.disponible ? 'Available' : 'Rented' }}
              </span>
            </td>
            <td class="px-5 py-3 text-sm text-slate-600">{{ car.reservations_count ?? 0 }}</td>
            <td class="px-5 py-3">
              <div class="flex items-center gap-2">
                <button @click="openEditModal(car)"
                  class="text-xs font-bold text-teal-600 hover:text-teal-700 bg-transparent border-none cursor-pointer">Edit</button>
                <span class="text-slate-200">|</span>
                <button @click="confirmDelete(car)"
                  class="text-xs font-bold text-red-400 hover:text-red-500 bg-transparent border-none cursor-pointer">Remove</button>
              </div>
            </td>
          </tr>
          <tr v-if="filteredFleet.length === 0">
            <td colspan="6" class="text-center py-12 text-slate-400 text-sm">No vehicles found.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- ── Add / Edit Vehicle Modal ── -->
    <Transition name="modal-fade">
      <div v-if="showModal"
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center z-50 p-4"
        @click.self="closeModal">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">

          <!-- Modal header -->
          <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 sticky top-0 bg-white rounded-t-2xl">
            <h3 class="text-lg font-bold text-slate-900">
              {{ isEditing ? 'Edit Vehicle' : 'Add New Vehicle' }}
            </h3>
            <button @click="closeModal"
              class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 hover:bg-slate-100 border-none cursor-pointer transition-colors">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
              </svg>
            </button>
          </div>

          <!-- Modal body -->
          <div class="px-6 py-5 flex flex-col gap-4">

            <!-- Marque + Modele -->
            <div class="grid grid-cols-2 gap-4">
              <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Brand</label>
                <input v-model="form.marque" type="text" placeholder="BMW"
                  class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors"/>
                <p v-if="form.errors.marque" class="text-xs text-red-500">{{ form.errors.marque }}</p>
              </div>
              <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Model</label>
                <input v-model="form.modele" type="text" placeholder="5 Series"
                  class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors"/>
                <p v-if="form.errors.modele" class="text-xs text-red-500">{{ form.errors.modele }}</p>
              </div>
            </div>

            <!-- Annee + Immatriculation -->
            <div class="grid grid-cols-2 gap-4">
              <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Year</label>
                <input v-model="form.annee" type="number" placeholder="2023" min="1990" :max="currentYear + 1"
                  class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors"/>
                <p v-if="form.errors.annee" class="text-xs text-red-500">{{ form.errors.annee }}</p>
              </div>
              <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Plate Number</label>
                <input v-model="form.immatriculation" type="text" placeholder="AB-123-CD"
                  class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors"/>
                <p v-if="form.errors.immatriculation" class="text-xs text-red-500">{{ form.errors.immatriculation }}</p>
              </div>
            </div>

            <!-- Category -->
            <div class="flex flex-col gap-1.5">
              <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Category</label>
              <select v-model="form.category_id"
                class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors appearance-none cursor-pointer">
                <option value="" disabled>Select category...</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
              </select>
              <p v-if="form.errors.category_id" class="text-xs text-red-500">{{ form.errors.category_id }}</p>
            </div>

            <!-- Price + Seats -->
            <div class="grid grid-cols-2 gap-4">
              <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Price/day ($)</label>
                <input v-model="form.prix_par_jour" type="number" min="0" step="0.01" placeholder="180"
                  class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors"/>
                <p v-if="form.errors.prix_par_jour" class="text-xs text-red-500">{{ form.errors.prix_par_jour }}</p>
              </div>
              <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Seats</label>
                <input v-model="form.nb_places" type="number" min="1" max="9" placeholder="5"
                  class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors"/>
              </div>
            </div>

            <!-- Transmission + Fuel -->
            <div class="grid grid-cols-2 gap-4">
              <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Transmission</label>
                <select v-model="form.transmission"
                  class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors appearance-none cursor-pointer">
                  <option value="manuelle">Manual</option>
                  <option value="automatique">Automatic</option>
                </select>
              </div>
              <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Fuel</label>
                <select v-model="form.carburant"
                  class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors appearance-none cursor-pointer">
                  <option value="essence">Petrol</option>
                  <option value="diesel">Diesel</option>
                  <option value="electrique">Electric</option>
                  <option value="hybride">Hybrid</option>
                </select>
              </div>
            </div>

            <!-- Color -->
            <div class="flex flex-col gap-1.5">
              <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Color</label>
              <input v-model="form.couleur" type="text" placeholder="Black"
                class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors"/>
            </div>

            <!-- Image upload -->
            <div class="flex flex-col gap-1.5">
              <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Photo</label>
              <div class="flex items-center gap-3">
                <img v-if="imagePreview" :src="imagePreview" class="w-16 h-12 object-cover rounded-lg border border-slate-200"/>
                <label class="flex-1 border border-dashed border-slate-300 rounded-xl px-3 py-2.5 text-xs text-slate-400 text-center cursor-pointer hover:border-teal-400 hover:text-teal-500 transition-colors">
                  {{ imagePreview ? 'Change photo' : 'Upload photo' }}
                  <input type="file" accept="image/*" class="hidden" @change="handleImageUpload"/>
                </label>
              </div>
              <p v-if="form.errors.image" class="text-xs text-red-500">{{ form.errors.image }}</p>
            </div>

            <!-- Available toggle -->
            <label class="flex items-center gap-3 cursor-pointer">
              <input v-model="form.disponible" type="checkbox" class="accent-teal-600 w-4 h-4"/>
              <span class="text-sm text-slate-700 font-medium">Available for booking</span>
            </label>

          </div>

          <!-- Modal footer -->
          <div class="flex gap-3 px-6 py-5 border-t border-slate-100 sticky bottom-0 bg-white rounded-b-2xl">
            <button @click="closeModal"
              class="flex-1 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-bold bg-white hover:bg-slate-50 cursor-pointer transition-all">
              Cancel
            </button>
            <button @click="handleSubmit" :disabled="form.processing"
              class="flex-1 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 disabled:opacity-50 text-white text-sm font-bold border-none cursor-pointer transition-colors flex items-center justify-center gap-2">
              <span v-if="form.processing"
                class="w-4 h-4 rounded-full animate-spin flex-shrink-0"
                style="border:2px solid rgba(255,255,255,.3);border-top-color:#fff"></span>
              {{ form.processing ? 'Saving...' : (isEditing ? 'Save Changes' : 'Add Vehicle') }}
            </button>
          </div>

        </div>
      </div>
    </Transition>

    <!-- ── Delete confirmation ── -->
    <Transition name="modal-fade">
      <div v-if="deleteTarget"
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center z-50 p-4"
        @click.self="deleteTarget = null">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6">
          <h3 class="text-base font-bold text-slate-900 mb-2">Remove vehicle?</h3>
          <p class="text-sm text-slate-500 mb-5">
            "{{ deleteTarget.marque }} {{ deleteTarget.modele }}" will be permanently removed from your fleet.
          </p>
          <div class="flex gap-3">
            <button @click="deleteTarget = null"
              class="flex-1 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-bold bg-white hover:bg-slate-50 cursor-pointer transition-all">
              Cancel
            </button>
            <button @click="handleDelete"
              class="flex-1 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-bold border-none cursor-pointer transition-colors">
              Remove
            </button>
          </div>
        </div>
      </div>
    </Transition>

  </AgencyDashboardLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AgencyDashboardLayout from '@/Layouts/Agencydashboard.vue'

const props = defineProps({
  agency:     { type: Object, required: true },
  fleet:      { type: Array,  default: () => [] },
  categories: { type: Array,  default: () => [] },
})

const placeholderImg = 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?w=200&q=80'
const currentYear     = new Date().getFullYear()

// ── Search ─────────────────────────────────────────────────
const fleetSearch = ref('')
const filteredFleet = computed(() => {
  const q = fleetSearch.value.toLowerCase()
  return props.fleet.filter(c =>
    !q || `${c.marque} ${c.modele}`.toLowerCase().includes(q) || c.category?.name?.toLowerCase().includes(q)
  )
})

// ── Modal state ────────────────────────────────────────────
const showModal     = ref(false)
const isEditing      = ref(false)
const editingId      = ref(null)
const imagePreview   = ref(null)
const deleteTarget   = ref(null)

const form = useForm({
  marque:          '',
  modele:          '',
  annee:           currentYear,
  immatriculation: '',
  category_id:     '',
  prix_par_jour:   '',
  nb_places:       5,
  transmission:    'manuelle',
  carburant:       'essence',
  couleur:         '',
  image:           null,
  disponible:      true,
})

function openAddModal() {
  isEditing.value     = false
  editingId.value     = null
  imagePreview.value  = null
  form.reset()
  form.clearErrors()
  showModal.value = true
}

function openEditModal(car) {
  isEditing.value    = true
  editingId.value    = car.id
  imagePreview.value = car.image || null
  form.clearErrors()
  form.marque          = car.marque
  form.modele          = car.modele
  form.annee           = car.annee
  form.immatriculation = car.immatriculation
  form.category_id     = car.category_id ?? ''
  form.prix_par_jour    = car.prix_par_jour
  form.nb_places        = car.nb_places
  form.transmission      = car.transmission
  form.carburant         = car.carburant
  form.couleur           = car.couleur
  form.disponible        = car.disponible
  form.image             = null
  showModal.value = true
}

function closeModal() {
  showModal.value = false
  form.reset()
  form.clearErrors()
}

function handleImageUpload(e) {
  const file = e.target.files[0]
  if (!file) return
  form.image = file
  imagePreview.value = URL.createObjectURL(file)
}

function handleSubmit() {
  // Ensure boolean is sent as '1' or '0' string — FormData mishandles real booleans
  form.disponible = form.disponible ? 1 : 0
 
  if (isEditing.value) {
    form.transform(data => ({
      ...data,
      _method: 'put',
    })).post(route('agence.fleet.update', editingId.value), {
      forceFormData: true,
      onSuccess: () => closeModal(),
      onError: (errors) => console.log('Validation errors:', errors),
    })
  } else {
    form.post(route('agence.fleet.store'), {
      forceFormData: true,
      onSuccess: () => closeModal(),
      onError: (errors) => console.log('Validation errors:', errors),
    })
  }
}

function confirmDelete(car) {
  deleteTarget.value = car
}

function handleDelete() {
  useForm({}).delete(route('agence.fleet.destroy', deleteTarget.value.id), {
    onSuccess: () => { deleteTarget.value = null },
  })
}
</script>

<style scoped>
.modal-fade-enter-active, .modal-fade-leave-active { transition: opacity .2s; }
.modal-fade-enter-from, .modal-fade-leave-to        { opacity: 0; }
</style>