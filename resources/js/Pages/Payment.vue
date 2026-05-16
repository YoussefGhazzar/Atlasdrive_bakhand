<template>
  <div class="min-h-screen bg-slate-50">
    <Navbar />

    <div class="max-w-5xl mx-auto px-6 pt-16 pb-20">

      <!-- Header -->
      <div class="text-center mb-10">
        <h1 class="text-4xl font-extrabold text-slate-900 mb-3 tracking-tight"
          style="font-family:'Plus Jakarta Sans',sans-serif;">
          Complete Your Payment
        </h1>
        <p class="text-slate-500 text-base max-w-md mx-auto" style="font-family:'Sora',sans-serif;">
          You're one step away from launching your agency on Atlas Drive.
        </p>
      </div>

      <!-- Progress Bar -->
      <ProgressBar :steps="steps" />

      <!-- Layout: Form + Summary -->
      <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

        <!-- ── Left: Payment Form ── -->
        <div class="lg:col-span-3 flex flex-col gap-5">

          <!-- Billing toggle -->
          <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-3"
              style="font-family:'Sora',sans-serif;">Billing Cycle</p>
            <div class="grid grid-cols-2 gap-2">
              <button
                v-for="cycle in ['monthly', 'yearly']" :key="cycle"
                @click="billing = cycle"
                :class="[
                  'py-3 rounded-xl text-sm font-semibold border-2 transition-all duration-150 capitalize',
                  billing === cycle
                    ? 'border-teal-500 bg-teal-50 text-teal-700'
                    : 'border-slate-200 bg-white text-slate-500 hover:border-teal-300'
                ]"
                style="font-family:'Sora',sans-serif;">
                {{ cycle }}
                <span v-if="cycle === 'yearly'"
                  class="ml-1 bg-emerald-100 text-emerald-700 text-[0.6rem] font-bold px-1.5 py-0.5 rounded-full">
                  -20%
                </span>
              </button>
            </div>
          </div>

          <!-- Card Details -->
          <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-4"
              style="font-family:'Sora',sans-serif;">Card Information</p>

            <div class="flex flex-col gap-4">

              <!-- Cardholder name -->
              <div class="flex flex-col gap-1.5">
                <label class="text-[11px] font-semibold uppercase text-slate-400"
                  style="letter-spacing:1.2px; font-family:'Sora',sans-serif;">Cardholder Name</label>
                <div class="relative flex items-center">
                  <span class="absolute left-3 text-slate-400 text-sm pointer-events-none">👤</span>
                  <input
                    v-model="form.name"
                    type="text"
                    placeholder="Youssef El Amrani"
                    :class="[
                      'w-full pl-9 pr-3 py-2.5 rounded-xl text-sm text-slate-900 outline-none transition-all border',
                      form.errors.name
                        ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-200'
                        : 'border-slate-200 bg-slate-50 focus:border-teal-500 focus:bg-white focus:ring-2 focus:ring-teal-100'
                    ]"
                    style="font-family:'Outfit',sans-serif;"
                  />
                </div>
                <p v-if="form.errors.name" class="text-[11.5px] text-red-500">{{ form.errors.name }}</p>
              </div>

              <!-- Card number -->
              <div class="flex flex-col gap-1.5">
                <label class="text-[11px] font-semibold uppercase text-slate-400"
                  style="letter-spacing:1.2px; font-family:'Sora',sans-serif;">Card Number</label>
                <div class="relative flex items-center">
                  <span class="absolute left-3 text-slate-400 text-sm pointer-events-none">💳</span>
                  <input
                    v-model="form.card_number"
                    type="text"
                    placeholder="1234 5678 9012 3456"
                    maxlength="19"
                    @input="formatCard"
                    :class="[
                      'w-full pl-9 pr-20 py-2.5 rounded-xl text-sm text-slate-900 outline-none transition-all border font-mono',
                      form.errors.card_number
                        ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-200'
                        : 'border-slate-200 bg-slate-50 focus:border-teal-500 focus:bg-white focus:ring-2 focus:ring-teal-100'
                    ]"
                  />
                  <!-- Card brand icons -->
                  <div class="absolute right-3 flex items-center gap-1">
                    <span class="text-[0.7rem] font-bold px-1.5 py-0.5 rounded bg-blue-900 text-white">VISA</span>
                    <span class="text-[0.7rem] font-bold px-1.5 py-0.5 rounded bg-red-600 text-white">MC</span>
                  </div>
                </div>
                <p v-if="form.errors.card_number" class="text-[11.5px] text-red-500">{{ form.errors.card_number }}</p>
              </div>

              <!-- Expiry + CVV -->
              <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-1.5">
                  <label class="text-[11px] font-semibold uppercase text-slate-400"
                    style="letter-spacing:1.2px; font-family:'Sora',sans-serif;">Expiry Date</label>
                  <div class="relative flex items-center">
                    <span class="absolute left-3 text-slate-400 text-sm pointer-events-none">📅</span>
                    <input
                      v-model="form.expiry"
                      type="text"
                      placeholder="MM / YY"
                      maxlength="7"
                      @input="formatExpiry"
                      :class="[
                        'w-full pl-9 pr-3 py-2.5 rounded-xl text-sm text-slate-900 outline-none transition-all border font-mono',
                        form.errors.expiry
                          ? 'border-red-400 bg-red-50'
                          : 'border-slate-200 bg-slate-50 focus:border-teal-500 focus:bg-white focus:ring-2 focus:ring-teal-100'
                      ]"
                    />
                  </div>
                  <p v-if="form.errors.expiry" class="text-[11.5px] text-red-500">{{ form.errors.expiry }}</p>
                </div>

                <div class="flex flex-col gap-1.5">
                  <label class="text-[11px] font-semibold uppercase text-slate-400"
                    style="letter-spacing:1.2px; font-family:'Sora',sans-serif;">CVV</label>
                  <div class="relative flex items-center">
                    <span class="absolute left-3 text-slate-400 text-sm pointer-events-none">🔒</span>
                    <input
                      v-model="form.cvv"
                      :type="showCvv ? 'text' : 'password'"
                      placeholder="•••"
                      maxlength="4"
                      :class="[
                        'w-full pl-9 pr-10 py-2.5 rounded-xl text-sm text-slate-900 outline-none transition-all border font-mono',
                        form.errors.cvv
                          ? 'border-red-400 bg-red-50'
                          : 'border-slate-200 bg-slate-50 focus:border-teal-500 focus:bg-white focus:ring-2 focus:ring-teal-100'
                      ]"
                    />
                    <button type="button" @click="showCvv = !showCvv"
                      class="absolute right-3 text-slate-400 hover:text-slate-600 bg-transparent border-none cursor-pointer text-sm p-0 transition-colors">
                      {{ showCvv ? '🙈' : '👁' }}
                    </button>
                  </div>
                  <p v-if="form.errors.cvv" class="text-[11.5px] text-red-500">{{ form.errors.cvv }}</p>
                </div>
              </div>

            </div>
          </div>

          <!-- Billing Address -->
          <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-4"
              style="font-family:'Sora',sans-serif;">Billing Address</p>

            <div class="flex flex-col gap-4">
              <div class="flex flex-col gap-1.5">
                <label class="text-[11px] font-semibold uppercase text-slate-400"
                  style="letter-spacing:1.2px; font-family:'Sora',sans-serif;">Full Address</label>
                <div class="relative flex items-center">
                  <span class="absolute left-3 text-slate-400 text-sm pointer-events-none">📍</span>
                  <input v-model="form.address" type="text" placeholder="123 Mohammed V Ave"
                    class="w-full pl-9 pr-3 py-2.5 rounded-xl text-sm text-slate-900 outline-none border border-slate-200 bg-slate-50 focus:border-teal-500 focus:bg-white focus:ring-2 focus:ring-teal-100 transition-all"
                    style="font-family:'Outfit',sans-serif;" />
                </div>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-1.5">
                  <label class="text-[11px] font-semibold uppercase text-slate-400"
                    style="letter-spacing:1.2px; font-family:'Sora',sans-serif;">City</label>
                  <div class="relative flex items-center">
                    <span class="absolute left-3 text-slate-400 text-sm pointer-events-none">🏙</span>
                    <select v-model="form.city"
                      class="w-full pl-9 pr-3 py-2.5 rounded-xl text-sm text-slate-900 outline-none border border-slate-200 bg-slate-50 focus:border-teal-500 focus:bg-white focus:ring-2 focus:ring-teal-100 transition-all appearance-none cursor-pointer"
                      style="font-family:'Outfit',sans-serif;">
                      <option value="">Select city...</option>
                      <option v-for="c in cities" :key="c" :value="c">{{ c }}</option>
                    </select>
                  </div>
                </div>
                <div class="flex flex-col gap-1.5">
                  <label class="text-[11px] font-semibold uppercase text-slate-400"
                    style="letter-spacing:1.2px; font-family:'Sora',sans-serif;">Postal Code</label>
                  <div class="relative flex items-center">
                    <span class="absolute left-3 text-slate-400 text-sm pointer-events-none">📮</span>
                    <input v-model="form.postal_code" type="text" placeholder="20000"
                      class="w-full pl-9 pr-3 py-2.5 rounded-xl text-sm text-slate-900 outline-none border border-slate-200 bg-slate-50 focus:border-teal-500 focus:bg-white focus:ring-2 focus:ring-teal-100 transition-all"
                      style="font-family:'Outfit',sans-serif;" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Submit -->
          <button
            @click="handleSubmit"
            :disabled="form.processing"
            class="w-full py-4 rounded-2xl text-base font-bold text-white border-none cursor-pointer transition-all duration-200 active:scale-[.98] disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
            style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%); box-shadow: 0 8px 24px rgba(13,148,136,0.3); font-family:'Sora',sans-serif;">
            <span v-if="form.processing"
              class="w-4 h-4 rounded-full animate-spin flex-shrink-0"
              style="border: 2.5px solid rgba(255,255,255,.3); border-top-color: #fff"></span>
            <span>{{ form.processing ? 'Processing...' : '🔒 Pay & Activate Plan' }}</span>
          </button>

          <!-- Security note -->
          <p class="text-center text-xs text-slate-400" style="font-family:'Sora',sans-serif;">
            🔒 256-bit SSL encryption · Your data is never stored on our servers
          </p>
        </div>

        <!-- ── Right: Order Summary ── -->
        <div class="lg:col-span-2">
          <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm sticky top-24">

            <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-5"
              style="font-family:'Sora',sans-serif;">Order Summary</p>

            <!-- Plan pill -->
            <div class="flex items-center justify-between mb-4 p-3 bg-teal-50 rounded-xl border border-teal-100">
              <div>
                <p class="font-bold text-slate-900 text-sm capitalize" style="font-family:'Sora',sans-serif;">
                  {{ planName }} Plan
                </p>
                <p class="text-xs text-slate-500 capitalize" style="font-family:'Sora',sans-serif;">
                  Billed {{ billing }}
                </p>
              </div>
              <Link :href="route('agency.select-plan')"
                class="text-xs text-teal-600 font-semibold hover:underline no-underline"
                style="font-family:'Sora',sans-serif;">
                Change
              </Link>
            </div>

            <!-- Price breakdown -->
            <div class="flex flex-col gap-2.5 mb-5">
              <div class="flex justify-between text-sm" style="font-family:'Sora',sans-serif;">
                <span class="text-slate-500">Subtotal</span>
                <span class="text-slate-700 font-semibold">${{ subtotal }}/mo</span>
              </div>
              <div v-if="billing === 'yearly'" class="flex justify-between text-sm" style="font-family:'Sora',sans-serif;">
                <span class="text-emerald-600">Yearly discount (20%)</span>
                <span class="text-emerald-600 font-semibold">-${{ discount }}/mo</span>
              </div>
              <div class="flex justify-between text-sm" style="font-family:'Sora',sans-serif;">
                <span class="text-slate-500">14-day free trial</span>
                <span class="text-teal-600 font-semibold">Included</span>
              </div>
              <div class="border-t border-slate-100 pt-3 flex justify-between" style="font-family:'Sora',sans-serif;">
                <span class="font-bold text-slate-900">Total today</span>
                <span class="font-extrabold text-teal-600 text-lg">${{ total }}/mo</span>
              </div>
            </div>

            <!-- Trust badges -->
            <div class="flex flex-col gap-2">
              <div v-for="badge in trustBadges" :key="badge.text"
                class="flex items-center gap-2.5 text-xs text-slate-500"
                style="font-family:'Sora',sans-serif;">
                <span v-html="badge.icon" class="text-teal-500 flex-shrink-0"></span>
                {{ badge.text }}
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, useForm, usePage } from '@inertiajs/vue3'
import Navbar      from '@/Components/Navbar.vue'
import ProgressBar from '@/Components/ProgressBar.vue'
import { route } from 'ziggy-js'

// Plan passed from SelectPlan via query param
const page    = usePage()
const planParam = page.props.ziggy?.query?.plan ?? 'starter'

const billing  = ref('monthly')
const showCvv  = ref(false)

const steps = [
  { label: 'Account', done: true,  active: false },
  { label: 'Plan',    done: true,  active: false },
  { label: 'Payment', done: false, active: true  },
]

const cities = [
  'Casablanca','Rabat','Marrakech','Fès','Tanger',
  'Agadir','Meknès','Oujda','Tétouan','Kenitra',
]

// Prices per plan (monthly)
const priceMap = { starter: 29, professional: 79, enterprise: 199 }

const planName = planParam.charAt(0).toUpperCase() + planParam.slice(1)
const subtotal = computed(() => priceMap[planParam] ?? 29)
const discount = computed(() => Math.round(subtotal.value * 0.2))
const total    = computed(() => billing.value === 'yearly'
  ? subtotal.value - discount.value
  : subtotal.value
)

const form = useForm({
  plan:        planParam,
  billing:     billing,
  name:        '',
  card_number: '',
  expiry:      '',
  cvv:         '',
  address:     '',
  city:        '',
  postal_code: '',
})

// Format card number: 1234 5678 9012 3456
function formatCard(e) {
  let v = e.target.value.replace(/\D/g, '').slice(0, 16)
  form.card_number = v.replace(/(.{4})/g, '$1 ').trim()
}

// Format expiry: MM / YY
function formatExpiry(e) {
  let v = e.target.value.replace(/\D/g, '').slice(0, 4)
  if (v.length >= 3) v = v.slice(0, 2) + ' / ' + v.slice(2)
  form.expiry = v
}

function handleSubmit() {
  form.billing = billing.value
  form.post(route('agency.payment.store'), {
    onSuccess: () => {route('agency.dashboard')},
  })
}

const trustBadges = [
  { text: 'Cancel anytime, no questions asked',
    icon: `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>` },
  { text: '14-day free trial included',
    icon: `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>` },
  { text: 'Secured by 256-bit SSL encryption',
    icon: `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>` },
  { text: 'GDPR compliant data handling',
    icon: `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>` },
]
</script>