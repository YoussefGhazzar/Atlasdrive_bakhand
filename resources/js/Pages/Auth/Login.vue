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
            Client Space
          </div>

          <div class="font-extrabold leading-[1.1] tracking-tight text-gray-900 mb-4"
            style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(36px, 4vw, 52px)">
            Your road,<br>
            <span class="text-[#1BA89A]">your rules.</span>
          </div>

          <p class="text-[15px] leading-relaxed text-gray-500 max-w-sm mb-10">
            Access over 500 vehicles across all major cities in Morocco.
            Compare, book and drive — in just a few clicks.
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
      <div class="flex flex-1 items-center justify-center overflow-y-auto bg-white border-l border-gray-200 px-10 py-12 lg:px-10 md:px-6 sm:px-4">
        <div class="w-full max-w-[430px]" style="animation: slideIn .45s cubic-bezier(.4,0,.2,1) both">

          <!-- Alert -->
          <Transition name="fade-down">
            <div v-if="alert.show"
              :class="[
                'flex items-center gap-2 px-3.5 py-2.5 rounded-[10px] text-[13px] border mb-4',
                alert.type === 'success'
                  ? 'bg-emerald-50 border-emerald-200 text-emerald-800'
                  : 'bg-red-50 border-red-200 text-red-800'
              ]">
              {{ alert.message }}
            </div>
          </Transition>

          <!-- Heading -->
          <div class="text-[24px] font-extrabold text-gray-900 mb-1"
            style="font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -.4px">
            Welcome back!
          </div>
          <div class="text-[13.5px] text-gray-400 mb-5 leading-relaxed">
            Sign in to your account and book your next vehicle.
          </div>

          <!-- Fields -->
          <div class="flex flex-col gap-3.5">

            <!-- Email -->
            <div class="flex flex-col gap-1.5">
              <label for="email"
                class="text-[11px] font-semibold uppercase text-gray-400"
                style="letter-spacing: 1.2px">Email address</label>
              <div class="relative flex items-center">
                <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">✉</span>
                <input
                  id="email"
                  type="email"
                  v-model="form.email"
                  placeholder="you@example.com"
                  :class="[
                    'w-full pl-9 pr-3 py-2.5 rounded-[10px] text-[14px] text-gray-900 outline-none transition-all duration-200',
                    form.errors.email
                      ? 'border-[1.5px] border-red-500 bg-red-50 focus:ring-2 focus:ring-red-200'
                      : 'border-[1.5px] border-gray-200 bg-gray-50 focus:border-[#1BA89A] focus:bg-white focus:ring-2 focus:ring-[#1BA89A]/10'
                  ]"
                  style="font-family: 'Outfit', sans-serif"
                />
              </div>
              <p v-if="form.errors.email" class="text-[11.5px] text-red-600 pl-0.5">{{ form.errors.email }}</p>
            </div>

            <!-- Password -->
            <div class="flex flex-col gap-1.5">
              <label for="password"
                class="text-[11px] font-semibold uppercase text-gray-400"
                style="letter-spacing: 1.2px">Password</label>
              <div class="relative flex items-center">
                <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">🔒</span>
                <input
                  id="password"
                  :type="showPass ? 'text' : 'password'"
                  v-model="form.password"
                  placeholder="••••••••"
                  :class="[
                    'w-full pl-9 pr-10 py-2.5 rounded-[10px] text-[14px] text-gray-900 outline-none transition-all duration-200',
                    form.errors.password
                      ? 'border-[1.5px] border-red-500 bg-red-50 focus:ring-2 focus:ring-red-200'
                      : 'border-[1.5px] border-gray-200 bg-gray-50 focus:border-[#1BA89A] focus:bg-white focus:ring-2 focus:ring-[#1BA89A]/10'
                  ]"
                  style="font-family: 'Outfit', sans-serif"
                />
                <button type="button" @click="showPass = !showPass"
                  class="absolute right-3 bg-transparent border-none text-gray-400 cursor-pointer text-sm p-0 hover:text-gray-700 transition-colors">
                  {{ showPass ? '🙈' : '👁' }}
                </button>
              </div>
              <p v-if="form.errors.password" class="text-[11.5px] text-red-600 pl-0.5">{{ form.errors.password }}</p>
            </div>

            <!-- Forgot password -->
            <div class="text-right -mt-1">
              <Link
                :href="route('password.request')"
                class="text-[12.5px] text-[#1BA89A] font-medium hover:underline no-underline"
              >
                Forgot your password?
              </Link>
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
            <span>{{ form.processing ? 'Signing in...' : '→ Sign In' }}</span>
          </button>

          <!-- Register link -->
          <div class="mt-[18px] text-center text-[13.5px] text-gray-400">
            Don't have an account?
            <Link
              :href="route('register.client')"
              class="text-[#1BA89A] font-semibold hover:underline no-underline"
            >
              Sign up for free
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
import { ref, reactive } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'
import Navbar from '@/Components/Navbar.vue'

const showPass = ref(false)

const form = useForm({
  email:    '',
  password: '',
})

const alert = reactive({ show: false, type: '', message: '' })

const stats = [
  { val: '500+', lbl: 'Vehicles' },
  { val: '50+',  lbl: 'Agencies' },
  { val: '15',   lbl: 'Cities'   },
]
const pills       = ['Instant Booking', 'No Hidden Fees', 'Flexible Cancellation', 'Insurance Included']
const trustBadges = ['🔒 SSL Secured', '🛡 Data Protected', '📍 Morocco & International']

function showAlertMsg(type, message) {
  alert.show    = true
  alert.type    = type
  alert.message = message
  setTimeout(() => { alert.show = false }, 5000)
}

function handleSubmit() {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
    onSuccess: () => showAlertMsg('success', '✅ Successfully signed in!'),
    onError:   () => showAlertMsg('error',   '❌ Invalid email or password.'),
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