<template>
  <AgencyDashboardLayout title="Settings" subtitle="Profile & preferences" :agency="agency">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

      <!-- Agency Profile -->
      <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
        <h3 class="text-sm font-bold text-slate-800 mb-4">Agency Profile</h3>

        <Transition name="fade-down">
          <div v-if="saved"
            class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-2.5 rounded-xl mb-4">
            ✅ Changes saved successfully!
          </div>
        </Transition>

        <div class="flex flex-col gap-3">
          <div class="flex flex-col gap-1.5">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Agency Name</label>
            <input v-model="form.name" type="text"
              class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors"/>
            <p v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</p>
          </div>
          <div class="flex flex-col gap-1.5">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Email</label>
            <input v-model="form.email" type="email"
              class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors"/>
          </div>
          <div class="flex flex-col gap-1.5">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Phone</label>
            <input v-model="form.phone" type="tel"
              class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors"/>
          </div>
          <div class="flex flex-col gap-1.5">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">City</label>
            <input v-model="form.city" type="text"
              class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors"/>
          </div>
          <div class="flex flex-col gap-1.5">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Address</label>
            <input v-model="form.address" type="text"
              class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors"/>
          </div>
          <button @click="handleSave" :disabled="form.processing"
            class="w-full bg-teal-600 hover:bg-teal-700 disabled:opacity-50 text-white font-bold text-sm py-2.5 rounded-xl border-none cursor-pointer transition-colors mt-2 flex items-center justify-center gap-2">
            <span v-if="form.processing"
              class="w-4 h-4 rounded-full animate-spin flex-shrink-0"
              style="border:2px solid rgba(255,255,255,.3);border-top-color:#fff"></span>
            {{ form.processing ? 'Saving...' : 'Save Changes' }}
          </button>
        </div>
      </div>

      <!-- Subscription -->
      <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
        <h3 class="text-sm font-bold text-slate-800 mb-4">Subscription Plan</h3>
        <div class="bg-teal-50 border border-teal-200 rounded-xl p-4 mb-4">
          <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-bold text-teal-700 capitalize">{{ agency.plan ?? 'Starter' }} Plan</span>
            <span class="text-xs font-bold text-teal-600 bg-teal-100 px-2 py-0.5 rounded-full">Active</span>
          </div>
          <p class="text-xs text-teal-600">${{ planPrice }}/month · Renews {{ renewalDate }}</p>
        </div>
        <Link :href="route('agency.select-plan')"
          class="block w-full text-center border border-slate-200 hover:border-teal-500 text-slate-600 hover:text-teal-600 font-bold text-sm py-2.5 rounded-xl bg-white cursor-pointer transition-all no-underline">
          Change Plan
        </Link>
      </div>

    </div>

  </AgencyDashboardLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'
import AgencyDashboardLayout from '@/Layouts/Agencydashboard.vue'

const props = defineProps({
  agency: { type: Object, required: true },
})

const saved = ref(false)

const planPriceMap = { starter: 29, professional: 79, enterprise: 199 }
const planPrice    = computed(() => planPriceMap[props.agency?.plan] ?? 29)
const renewalDate  = computed(() => {
  const d = new Date()
  d.setMonth(d.getMonth() + 1)
  return d.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })
})

const form = useForm({
  name:    props.agency?.name    ?? '',
  email:   props.agency?.email   ?? '',
  phone:   props.agency?.phone   ?? '',
  city:    props.agency?.city    ?? '',
  address: props.agency?.address ?? '',
})

function handleSave() {
  form.patch(route('agence.settings.update'), {
    onSuccess: () => {
      saved.value = true
      setTimeout(() => { saved.value = false }, 3000)
    },
  })
}
</script>

<style scoped>
.fade-down-enter-active { animation: fadeDown .3s ease; }
.fade-down-leave-active { transition: opacity .2s; }
.fade-down-leave-to     { opacity: 0; }
@keyframes fadeDown {
  from { opacity: 0; transform: translateY(-6px); }
  to   { opacity: 1; }
}
</style>