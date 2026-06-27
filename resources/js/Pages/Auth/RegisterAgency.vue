<template>
  <div class="min-h-screen bg-gray-50">
    <Navbar />

    <div class="flex min-h-screen pt-16">

      <!-- ── Left Panel ── -->
      <div
        class="relative hidden lg:flex flex-col justify-end w-1/2 flex-shrink-0 overflow-hidden px-14 pb-16 pt-14"
        style="background: linear-gradient(145deg, #f0fdfb 0%, #e0f7f4 40%, #c8f0eb 100%)"
      >
        <div class="pointer-events-none absolute -top-28 -right-28 w-[480px] h-[480px] rounded-full"
          style="background: radial-gradient(circle, rgba(27,168,154,.15) 0%, transparent 70%)"></div>
        <div class="pointer-events-none absolute -bottom-20 -left-20 w-80 h-80 rounded-full"
          style="background: radial-gradient(circle, rgba(27,168,154,.1) 0%, transparent 70%)"></div>
        <div class="pointer-events-none absolute inset-0 opacity-60"
          style="background-image: radial-gradient(circle, rgba(27,168,154,.18) 1px, transparent 1px); background-size: 28px 28px"></div>

        <div class="relative z-10">
          <div class="inline-flex items-center gap-2 mb-5 px-4 py-1.5 rounded-full border text-[11px] font-semibold uppercase"
            style="background: rgba(27,168,154,.1); border-color: rgba(27,168,154,.25); color: #148a7e; letter-spacing: 1.8px">
            <span class="w-1.5 h-1.5 rounded-full bg-[#1BA89A] animate-pulse"></span>
            Partner Agency Portal
          </div>

          <div class="font-extrabold leading-[1.1] tracking-tight text-gray-900 mb-4"
            style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(36px, 4vw, 52px)">
            Grow<br><span style="color:#1BA89A">your fleet.</span>
          </div>

          <p class="text-[15px] leading-relaxed text-gray-500 max-w-sm mb-10">
            Join our partner agency network and reach thousands of customers.
          </p>

          <div class="grid grid-cols-3 gap-3 mb-8">
            <div v-for="s in stats" :key="s.val"
              class="bg-white rounded-[14px] px-3.5 py-4 shadow-sm"
              style="border: 1px solid rgba(27,168,154,.15)">
              <div class="text-[26px] font-extrabold text-[#1BA89A] leading-none mb-1"
                style="font-family: 'Plus Jakarta Sans', sans-serif">{{ s.val }}</div>
              <div class="text-[11px] font-medium text-gray-400 uppercase tracking-wide">{{ s.lbl }}</div>
            </div>
          </div>

          <div class="flex flex-wrap gap-2">
            <div v-for="pill in pills" :key="pill"
              class="flex items-center gap-1.5 bg-white border border-gray-200 rounded-full px-3.5 py-1.5 text-[12.5px] font-medium text-gray-700 shadow-sm">
              <span class="text-[#1BA89A] font-bold">✓</span> {{ pill }}
            </div>
          </div>
        </div>
      </div>

      <!-- ── Right Panel ── -->
      <div class="flex flex-1 items-start justify-center overflow-y-auto bg-white border-l border-gray-200 px-10 py-12 lg:px-10 md:px-6 sm:px-4">
        <div class="w-full max-w-[430px]" style="animation: slideIn .45s cubic-bezier(.4,0,.2,1) both">

          <!-- Role Tabs -->
          <div class="grid grid-cols-2 gap-1 bg-gray-100 border border-gray-200 rounded-[14px] p-1 mb-5">
            <!-- Link to Client page -->
            <Link
              :href="route('register.client')"
              class="flex items-center justify-center gap-2 py-[11px] px-3.5 rounded-[10px] text-[13.5px] font-medium text-gray-400 hover:text-gray-600 hover:bg-white/50 no-underline transition-all duration-200"
              style="font-family: 'Outfit', sans-serif"
            >
              <span class="text-[15px]">👤</span> Customer
            </Link>
            <!-- Active: Agency -->
            <button
              class="flex items-center justify-center gap-2 py-[11px] px-3.5 rounded-[10px] text-[13.5px] font-semibold bg-white text-gray-900 shadow-sm border-none cursor-default"
              style="font-family: 'Outfit', sans-serif"
            >
              <span class="text-[15px]">🏢</span> Agency
            </button>
          </div>

          <!-- Alert -->
          <Transition name="fade-down">
            <div v-if="page.props.flash?.success || Object.keys(page.props.errors ?? {}).length"
              :class="[
                'flex items-center gap-2 px-3.5 py-2.5 rounded-[10px] text-[13px] border mb-4',
                page.props.flash?.success
                  ? 'bg-emerald-50 border-emerald-200 text-emerald-800'
                  : 'bg-red-50 border-red-200 text-red-800'
              ]">
              {{ page.props.flash?.success ?? '❌ Please correct the errors below.' }}
            </div>
          </Transition>

          <!-- Heading -->
          <div class="text-[24px] font-extrabold text-gray-900 mb-1"
            style="font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -.4px">
            Become a Partner
          </div>
          <div class="text-[13.5px] text-gray-400 mb-5 leading-relaxed">
            Join our network and grow your business.
          </div>

          <!-- Fields -->
          <div class="flex flex-col gap-3.5">

            <!-- Last / First Name -->
            <div class="grid grid-cols-2 gap-3.5">
              <div class="flex flex-col gap-1.5">
                <label class="text-[11px] font-semibold uppercase text-gray-400" style="letter-spacing:1.2px">Last Name</label>
                <div class="relative flex items-center">
                  <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">✦</span>
                  <input type="text" placeholder="Ghazzar" v-model="form.nom"
                    :class="inputClass(form.errors.nom)" style="font-family:'Outfit',sans-serif" />
                </div>
                <p v-if="form.errors.nom" class="text-[11.5px] text-red-600 pl-0.5">{{ form.errors.nom }}</p>
              </div>
              <div class="flex flex-col gap-1.5">
                <label class="text-[11px] font-semibold uppercase text-gray-400" style="letter-spacing:1.2px">First Name</label>
                <div class="relative flex items-center">
                  <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">✦</span>
                  <input type="text" placeholder="Youssef" v-model="form.prenom"
                    :class="inputClass(form.errors.prenom)" style="font-family:'Outfit',sans-serif" />
                </div>
                <p v-if="form.errors.prenom" class="text-[11.5px] text-red-600 pl-0.5">{{ form.errors.prenom }}</p>
              </div>
            </div>

            <!-- Agency Name -->
            <div class="flex flex-col gap-1.5">
              <label class="text-[11px] font-semibold uppercase text-gray-400" style="letter-spacing:1.2px">Agency Name</label>
              <div class="relative flex items-center">
                <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">🏢</span>
                <input type="text" placeholder="Mon Agence Immobiliere" v-model="form.nom_agence"
                  :class="inputClass(form.errors.nom_agence)" style="font-family:'Outfit',sans-serif" />
              </div>
              <p v-if="form.errors.nom_agence" class="text-[11.5px] text-red-600 pl-0.5">{{ form.errors.nom_agence }}</p>
            </div>

            <!-- Professional Email -->
            <div class="flex flex-col gap-1.5">
              <label class="text-[11px] font-semibold uppercase text-gray-400" style="letter-spacing:1.2px">Professional Email</label>
              <div class="relative flex items-center">
                <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">✉</span>
                <input type="email" placeholder="youssef25@agence.com" v-model="form.email"
                  :class="inputClass(form.errors.email)" style="font-family:'Outfit',sans-serif" />
              </div>
              <p v-if="form.errors.email" class="text-[11.5px] text-red-600 pl-0.5">{{ form.errors.email }}</p>
            </div>

            <!-- Phone / City -->
            <div class="grid grid-cols-2 gap-3.5">
              <div class="flex flex-col gap-1.5">
                <label class="text-[11px] font-semibold uppercase text-gray-400" style="letter-spacing:1.2px">Phone</label>
                <div class="relative flex items-center">
                  <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">📱</span>
                  <input type="text" placeholder="0713524393" v-model="form.telephone"
                    :class="inputClass(form.errors.telephone)" style="font-family:'Outfit',sans-serif" />
                </div>
                <p v-if="form.errors.telephone" class="text-[11.5px] text-red-600 pl-0.5">{{ form.errors.telephone }}</p>
              </div>
              <div class="flex flex-col gap-1.5">
                <label class="text-[11px] font-semibold uppercase text-gray-400" style="letter-spacing:1.2px">Main City</label>
                <div class="relative flex items-center">
                  <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">📍</span>
                  <select v-model="form.ville" :class="selectClass()" style="font-family:'Outfit',sans-serif">
                    <option value="">Select...</option>
                    <option v-for="c in CITIES" :key="c" :value="c">{{ c }}</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Address -->
            <div class="flex flex-col gap-1.5">
              <label class="text-[11px] font-semibold uppercase text-gray-400" style="letter-spacing:1.2px">Address</label>
              <div class="relative flex items-center">
                <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">🏠</span>
                <input type="text" placeholder="Mesnana, Tanger" v-model="form.address"
                  :class="inputClass(form.errors.address)" style="font-family:'Outfit',sans-serif" />
              </div>
              <p v-if="form.errors.address" class="text-[11.5px] text-red-600 pl-0.5">{{ form.errors.address }}</p>
            </div>

            <!-- Password -->
            <div class="flex flex-col gap-1.5">
              <label class="text-[11px] font-semibold uppercase text-gray-400" style="letter-spacing:1.2px">Password</label>
              <div class="relative flex items-center">
                <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">🔒</span>
                <input :type="showPass ? 'text' : 'password'" placeholder="Min. 6 characters" v-model="form.password"
                  :class="inputClass(form.errors.password) + ' pr-10'" style="font-family:'Outfit',sans-serif" />
                <button type="button" @click="showPass = !showPass"
                  class="absolute right-3 bg-transparent border-none text-gray-400 cursor-pointer text-sm p-0 hover:text-gray-700 transition-colors">
                  {{ showPass ? '🙈' : '👁' }}
                </button>
              </div>
              <p v-if="form.errors.password" class="text-[11.5px] text-red-600 pl-0.5">{{ form.errors.password }}</p>
            </div>

            <!-- Confirm Password -->
            <div class="flex flex-col gap-1.5">
              <label class="text-[11px] font-semibold uppercase text-gray-400" style="letter-spacing:1.2px">Confirm Password</label>
              <div class="relative flex items-center">
                <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">🔒</span>
                <input :type="showPass ? 'text' : 'password'" placeholder="••••••••" v-model="form.confirm_password"
                  :class="inputClass(form.errors.confirm_password)" style="font-family:'Outfit',sans-serif" />
              </div>
              <p v-if="form.errors.confirm_password" class="text-[11.5px] text-red-600 pl-0.5">{{ form.errors.confirm_password }}</p>
            </div>

            <!-- Terms -->
            <div class="flex flex-col gap-1">
              <div class="flex items-start gap-2.5 text-[12.5px] text-gray-500 leading-relaxed">
                <input type="checkbox" id="terms" v-model="form.terms"
                  class="mt-0.5 flex-shrink-0 w-3.5 h-3.5 accent-[#1BA89A] cursor-pointer" />
                <label for="terms">
                  I agree to the
                  <a href="#" class="text-[#1BA89A] font-medium hover:underline">partner terms</a>
                  of Atlas Drive.
                </label>
              </div>
              <p v-if="form.errors.terms" class="text-[11.5px] text-red-600 pl-0.5">{{ form.errors.terms }}</p>
            </div>

          </div>

          <!-- Submit -->
          <button
            @click="handleSubmit"
            :disabled="form.processing"
            class="relative w-full mt-[18px] px-5 py-[13px] bg-[#1BA89A] hover:bg-[#148a7e] text-white rounded-[14px] text-[15px] font-bold flex items-center justify-center gap-2 overflow-hidden cursor-pointer border-none transition-all duration-200 active:scale-[.98] disabled:opacity-50 disabled:cursor-not-allowed"
            style="font-family: 'Plus Jakarta Sans', sans-serif; box-shadow: 0 4px 16px rgba(27,168,154,.3)"
          >
            <span v-if="form.processing"
              class="w-4 h-4 flex-shrink-0 rounded-full animate-spin"
              style="border: 2.5px solid rgba(255,255,255,.3); border-top-color: #fff"></span>
            <span>{{ form.processing ? 'Registering...' : '→ Create Partner Account' }}</span>
          </button>

          <!-- Login link -->
          <div class="mt-[18px] text-center text-[13.5px] text-gray-400">
            Already have an account?
            <Link :href="route('login')" class="text-[#1BA89A] font-semibold hover:underline no-underline">
              Sign In
            </Link>
          </div>

          <!-- Trust badges -->
          <div class="flex justify-center flex-wrap gap-5 mt-6 pt-5 border-t border-gray-100">
            <div v-for="badge in trustBadges" :key="badge"
              class="flex items-center gap-1.5 text-[11.5px] text-gray-300">
              {{ badge }}
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link, useForm, usePage } from '@inertiajs/vue3'
import Navbar from '@/Components/Navbar.vue'

const page     = usePage()
const showPass = ref(false)

const CITIES = [
  'Casablanca','Rabat','Marrakech','Fès','Tanger','Agadir',
  'Meknès','Oujda','Tétouan','El Jadida','Kenitra','Laâyoune',
]

const form = useForm({
  nom:             '',
  prenom:          '',
  email:           '',
  telephone:       '',
  ville:           '',
  address:         '',
  nom_agence:      '',
  password:        '',
  confirm_password:'',
  terms:           false,
})

const stats       = [     
  { val: '500+', lbl: 'Vehicles' },
  { val: '50+',  lbl: 'Agencies' },
  { val: '15',   lbl: 'Cities'   },
]
const pills       = ['Advanced Dashboard', 'GPS Tracking', 'Booking Management', 'Automated Payments']
const trustBadges = ['🔒 SSL Secured', '🛡 Data Protected', '📍 Morocco & International']

function inputClass(error) {
  const base = 'w-full pl-9 pr-3 py-2.5 rounded-[10px] text-[14px] text-gray-900 outline-none transition-all duration-200'
  return error
    ? `${base} border-[1.5px] border-red-500 bg-red-50 focus:ring-2 focus:ring-red-200`
    : `${base} border-[1.5px] border-gray-200 bg-gray-50 focus:border-[#1BA89A] focus:bg-white focus:ring-2 focus:ring-[#1BA89A]/10`
}
function selectClass() {
  return 'w-full pl-9 pr-3 py-2.5 rounded-[10px] text-[14px] text-gray-900 outline-none transition-all duration-200 border-[1.5px] border-gray-200 bg-gray-50 focus:border-[#1BA89A] focus:bg-white focus:ring-2 focus:ring-[#1BA89A]/10 appearance-none cursor-pointer'
}

function handleSubmit() {
  form.post(route('agency.register.store'), {
    onError: () => {},
  })
}
</script>

<style scoped>
@keyframes slideIn {
  from { opacity: 0; transform: translateX(16px); }
  to   { opacity: 1; transform: translateX(0); }
}
@keyframes fadeDown {
  from { opacity: 0; transform: translateY(-6px); }
  to   { opacity: 1; }
}
.fade-down-enter-active { animation: fadeDown .3s ease; }
.fade-down-leave-active { transition: opacity .2s; }
.fade-down-leave-to     { opacity: 0; }
</style>