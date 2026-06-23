<template>
  <div class="min-h-screen bg-slate-100 text-gray-900 font-sans overflow-x-hidden">

    <!-- ── Floating Pill Navbar ── -->
    <div class="fixed top-4 left-0 right-0 z-50 flex justify-center px-4 pointer-events-none">
      <nav class="pointer-events-auto w-full max-w-5xl bg-white/80 backdrop-blur-xl border border-white/60 shadow-xl rounded-2xl px-5 h-14 flex items-center justify-between"
        style="box-shadow: 0 8px 32px rgba(13,148,136,0.10), 0 2px 8px rgba(0,0,0,0.08);">

        <!-- Brand -->
        <a href="/" class="flex items-center gap-2 no-underline">
          <svg width="26" height="26" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 20L10 8L16 16L20 10L24 20" stroke="#0d9488" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M2 14L6 10" stroke="#0d9488" stroke-width="2" stroke-linecap="round"/>
          </svg>
          <span class="font-bold text-lg text-slate-900 tracking-tight" style="font-family:'Sora',sans-serif;">
            Atlas<span class="text-teal-600">Drive</span>
          </span>
        </a>

        <!-- Nav Links -->
        <ul class="flex items-center gap-1 list-none m-0 p-0">
          <li v-for="link in navLinks" :key="link.label">
            <a
              :href="link.href"
              class="text-slate-500 hover:text-slate-900 no-underline text-sm font-medium px-3.5 py-1.5 rounded-xl transition-all duration-200 hover:bg-slate-100"
              :class="{ 'text-teal-600 font-semibold bg-teal-50 hover:bg-teal-50 hover:text-teal-600': link.active }"
            >
              {{ link.label }}
            </a>
          </li>
        </ul>

        <!-- Auth Buttons -->
        <div class="flex items-center gap-2">
          <a href="/login"
            class="text-slate-600 hover:text-teal-600 font-semibold text-sm px-4 py-1.5 rounded-xl no-underline transition-colors duration-200 hover:bg-slate-100">
            Log In
          </a>
          <a href="/register"
            class="bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-4 py-1.5 rounded-xl no-underline transition-all duration-150">
            Sign Up
          </a>
        </div>
      </nav>
    </div>

    <div class="h-24"/>

    <!-- ╔══════════════════════════════════════════╗
         ║  HERO                                   ║
         ╚══════════════════════════════════════════╝ -->
    <section class="relative max-w-6xl mx-auto px-6 pt-10 pb-16 text-center">
      <div class="pointer-events-none absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[260px] rounded-full opacity-40 bg-teal-200 blur-[100px]" aria-hidden="true"/>
      <div class="relative">
        <span class="inline-block text-[10px] font-bold tracking-[0.3em] uppercase text-teal-600 border border-teal-200 bg-teal-50 rounded-full px-4 py-1.5 mb-4">
          Everything You Need
        </span>
        <h1 class="font-black text-4xl sm:text-5xl tracking-tight text-gray-900 mb-4 leading-[1.05]">
          Our <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-600 to-teal-400">Services</span>
        </h1>
        <p class="text-slate-500 text-lg max-w-lg mx-auto leading-relaxed">
          From daily rentals to long-term leases — we cover every need with verified agencies across Morocco.
        </p>
      </div>
    </section>

    <!-- ╔══════════════════════════════════════════╗
         ║  SERVICES GRID                          ║
         ╚══════════════════════════════════════════╝ -->
    <section class="max-w-6xl mx-auto px-6 pb-16">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <div v-for="service in services" :key="service.title"
          class="group bg-white rounded-2xl p-6 border border-slate-200 shadow-sm
                 hover:shadow-lg hover:shadow-teal-100 hover:-translate-y-1
                 transition-all duration-300 flex flex-col">
          <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-4 transition-colors duration-300"
               :style="{ background: service.bg, border: `1px solid ${service.border}` }">
            <span :style="{ color: service.iconColor }" v-html="service.icon"></span>
          </div>
          <span v-if="service.badge"
            class="self-start text-[10px] font-bold tracking-[0.15em] uppercase px-2.5 py-1 rounded-full mb-3"
            :style="{ background: service.bg, color: service.iconColor, border: `1px solid ${service.border}` }">
            {{ service.badge }}
          </span>
          <h3 class="font-bold text-gray-900 text-lg mb-2 leading-tight">{{ service.title }}</h3>
          <p class="text-slate-500 text-sm leading-relaxed flex-1">{{ service.desc }}</p>
          <ul class="mt-4 flex flex-col gap-1.5">
            <li v-for="f in service.features" :key="f" class="flex items-center gap-2 text-xs text-slate-600">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" :stroke="service.iconColor" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12"/>
              </svg>
              {{ f }}
            </li>
          </ul>
          <a :href="service.href"
             class="mt-5 flex items-center gap-1.5 text-sm font-bold no-underline transition-colors duration-200"
             :style="{ color: service.iconColor }">
            Learn more
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
          </a>
        </div>
      </div>
    </section>

    <!-- ╔══════════════════════════════════════════╗
         ║  HOW IT WORKS                           ║
         ╚══════════════════════════════════════════╝ -->
    <section class="max-w-6xl mx-auto px-6 pb-16">
      <div class="flex flex-col items-center mb-12 gap-2">
        <span class="text-[10px] font-bold tracking-[0.25em] uppercase text-teal-600 border border-slate-200 rounded-full px-4 py-1 bg-white">Simple Process</span>
        <h2 class="font-bold text-2xl text-gray-900 tracking-tight">How It Works</h2>
        <p class="text-slate-500 text-sm max-w-md text-center">Book your perfect car in minutes — no paperwork, no stress.</p>
      </div>
      <div class="relative">
        <div class="hidden lg:block absolute top-10 left-[calc(12.5%+24px)] right-[calc(12.5%+24px)] h-px bg-gradient-to-r from-teal-200 via-teal-400 to-teal-200 z-0"></div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative z-10">
          <div v-for="(step, i) in steps" :key="step.title" class="flex flex-col items-center text-center">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4 shadow-md relative"
                 :style="{ background: i === activeStep ? '#0d9488' : 'white', border: '2px solid ' + (i === activeStep ? '#0d9488' : '#e2e8f0') }"
                 @mouseenter="activeStep = i" @mouseleave="activeStep = 0">
              <span :style="{ color: i === activeStep ? 'white' : '#0d9488' }" v-html="step.icon"></span>
              <div class="absolute -top-2 -right-2 w-5 h-5 rounded-full bg-teal-600 text-white text-[10px] font-black flex items-center justify-center">
                {{ i + 1 }}
              </div>
            </div>
            <h3 class="font-bold text-gray-900 text-base mb-1.5">{{ step.title }}</h3>
            <p class="text-slate-500 text-xs leading-relaxed max-w-[180px]">{{ step.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ╔══════════════════════════════════════════╗
         ║  STATS BANNER                           ║
         ╚══════════════════════════════════════════╝ -->
    <section class="max-w-6xl mx-auto px-6 pb-16">
      <div class="relative rounded-3xl overflow-hidden p-8 md:p-12" style="background:linear-gradient(135deg,#0d4f47 0%,#0d9488 100%)">
        <div class="absolute inset-0 opacity-[0.05]"
             style="background-image:linear-gradient(#fff 1px,transparent 1px),linear-gradient(90deg,#fff 1px,transparent 1px);background-size:36px 36px;" aria-hidden="true"/>
        <div class="absolute inset-0 bg-gradient-to-br from-white/10 via-transparent to-black/20 pointer-events-none" aria-hidden="true"/>
        <div class="relative grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
          <div v-for="stat in platformStats" :key="stat.label">
            <p class="text-3xl font-extrabold text-white leading-none mb-1">{{ stat.value }}</p>
            <p class="text-teal-200 text-xs uppercase tracking-widest font-semibold">{{ stat.label }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ╔══════════════════════════════════════════╗
         ║  BOOKING SECTION                        ║
         ╚══════════════════════════════════════════╝ -->
    <section class="max-w-6xl mx-auto px-6 pb-16">
      <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2">
          <div class="p-8 md:p-10 flex flex-col justify-between">
            <div>
              <span class="inline-block text-[10px] font-bold tracking-[0.25em] uppercase text-teal-600 border border-teal-200 bg-teal-50 rounded-full px-3 py-1 mb-4">Book Now</span>
              <h2 class="font-black text-2xl md:text-3xl text-gray-900 tracking-tight mb-3 leading-tight">
                Ready to hit<br/>the road?
              </h2>
              <p class="text-slate-500 text-sm leading-relaxed mb-6">
                Choose your vehicle, pick your dates, and confirm your booking in under 2 minutes. No hidden fees, free cancellation.
              </p>
              <ul class="flex flex-col gap-3">
                <li v-for="perk in bookingPerks" :key="perk" class="flex items-center gap-3">
                  <div class="w-7 h-7 rounded-lg bg-teal-50 border border-teal-100 flex items-center justify-center flex-shrink-0">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                  </div>
                  <span class="text-sm text-slate-700 font-medium">{{ perk }}</span>
                </li>
              </ul>
            </div>
            <div class="mt-8 flex gap-3">
              <a href="/fleet" class="flex-1 text-center bg-teal-600 hover:bg-teal-700 text-white font-bold text-sm py-3 rounded-xl no-underline shadow-md shadow-teal-200 flex items-center justify-center gap-2">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>
                Browse Fleet
              </a>
              <a href="/register" class="flex-1 text-center border border-slate-200 hover:border-teal-400 hover:bg-teal-50 text-slate-700 hover:text-teal-700 font-bold text-sm py-3 rounded-xl no-underline flex items-center justify-center gap-2">
                Create Account
              </a>
            </div>
          </div>
          <div class="bg-slate-50 p-8 md:p-10 border-l border-slate-200 flex flex-col justify-center">
            <h3 class="font-bold text-gray-900 text-lg mb-5">Quick Booking</h3>
            <div class="flex flex-col gap-3">
              <div>
                <label class="text-xs font-bold text-slate-500 block mb-1.5">Pick-up City</label>
                <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-3 py-2.5 focus-within:border-teal-500 transition-colors">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                  <select v-model="bookingCity" class="flex-1 border-none outline-none text-sm text-gray-700 bg-transparent cursor-pointer">
                    <option value="">Select a city</option>
                    <option v-for="city in cities" :key="city" :value="city">{{ city }}</option>
                  </select>
                </div>
              </div>
              <div class="grid grid-cols-2 gap-3">
                <div>
                  <label class="text-xs font-bold text-slate-500 block mb-1.5">Pick-up Date</label>
                  <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-3 py-2.5 focus-within:border-teal-500 transition-colors">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <input v-model="pickupDate" type="date" class="flex-1 border-none outline-none text-xs text-gray-700 bg-transparent"/>
                  </div>
                </div>
                <div>
                  <label class="text-xs font-bold text-slate-500 block mb-1.5">Return Date</label>
                  <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-3 py-2.5 focus-within:border-teal-500 transition-colors">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <input v-model="returnDate" type="date" class="flex-1 border-none outline-none text-xs text-gray-700 bg-transparent"/>
                  </div>
                </div>
              </div>
              <div>
                <label class="text-xs font-bold text-slate-500 block mb-1.5">Vehicle Category</label>
                <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-3 py-2.5 focus-within:border-teal-500 transition-colors">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>
                  <select v-model="bookingCategory" class="flex-1 border-none outline-none text-sm text-gray-700 bg-transparent cursor-pointer">
                    <option value="">All categories</option>
                    <option>Luxury</option><option>SUV</option><option>Economy</option><option>Electric</option><option>Family</option>
                  </select>
                </div>
              </div>
              <div v-if="totalDays > 0" class="bg-teal-50 border border-teal-100 rounded-xl p-3 mt-1">
                <div class="flex items-center justify-between text-xs text-slate-600 mb-1">
                  <span>Estimated duration</span>
                  <span class="font-bold text-teal-700">{{ totalDays }} days</span>
                </div>
                <div class="flex items-center justify-between text-xs text-slate-600">
                  <span>Starting from</span>
                  <span class="font-extrabold text-teal-700 text-sm">${{ totalDays * 38 }} <span class="font-normal text-slate-400">/ Economy</span></span>
                </div>
              </div>
              <a href="/fleet" class="w-full text-center bg-teal-600 hover:bg-teal-700 text-white font-bold text-sm py-3 rounded-xl no-underline shadow-md shadow-teal-200 flex items-center justify-center gap-2 mt-2">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                Search Available Cars
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ╔══════════════════════════════════════════╗
         ║  WHY ATLAS DRIVE                        ║
         ╚══════════════════════════════════════════╝ -->
    <section class="max-w-6xl mx-auto px-6 pb-16">
      <div class="flex flex-col items-center mb-10 gap-2">
        <span class="text-[10px] font-bold tracking-[0.25em] uppercase text-teal-600 border border-slate-200 rounded-full px-4 py-1 bg-white">Why Us</span>
        <h2 class="font-bold text-2xl text-gray-900 tracking-tight">Why Choose Atlas Drive</h2>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div v-for="reason in whyUs" :key="reason.title"
          class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-teal-100 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
          <div class="w-10 h-10 rounded-xl bg-teal-50 border border-teal-100 flex items-center justify-center mb-3">
            <span class="text-teal-600" v-html="reason.icon"></span>
          </div>
          <h3 class="font-bold text-gray-900 text-sm mb-1.5">{{ reason.title }}</h3>
          <p class="text-slate-500 text-xs leading-relaxed">{{ reason.desc }}</p>
        </div>
      </div>
    </section>

    <!-- ╔══════════════════════════════════════════╗
         ║  FINAL CTA                              ║
         ╚══════════════════════════════════════════╝ -->
    <section class="max-w-6xl mx-auto px-6 pb-16">
      <div class="relative rounded-3xl overflow-hidden text-center px-8 py-14" style="background:linear-gradient(135deg,#0f2027 0%,#0d4f47 50%,#0d9488 100%)">
        <div class="absolute inset-0 opacity-[0.05]"
             style="background-image:radial-gradient(circle at 20% 50%,rgba(255,255,255,0.3) 0%,transparent 60%),radial-gradient(circle at 80% 20%,rgba(255,255,255,0.2) 0%,transparent 50%)"/>
        <div class="relative">
          <p class="text-teal-200 text-xs font-bold tracking-[0.3em] uppercase mb-3">Start Today</p>
          <h2 class="font-black text-3xl md:text-4xl text-white tracking-tight mb-3 leading-tight">
            Your next adventure<br/>starts here.
          </h2>
          <p class="text-teal-100 text-base mb-8 max-w-md mx-auto">
            Join 12,000+ happy customers who trust Atlas Drive for their rentals across Morocco.
          </p>
          <div class="flex items-center justify-center gap-4 flex-wrap">
            <a href="/fleet" class="bg-white hover:bg-teal-50 text-teal-700 font-bold text-sm px-8 py-3.5 rounded-xl no-underline transition-all duration-200 hover:-translate-y-0.5 hover:shadow-xl flex items-center gap-2">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>
              Browse Fleet
            </a>
            <a href="/register" class="text-white font-bold text-sm px-8 py-3.5 rounded-xl no-underline transition-all duration-200 hover:-translate-y-0.5 flex items-center gap-2"
               style="border: 2px solid rgba(255,255,255,0.35)">
              Create Free Account →
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-white">
      <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between gap-3">
        <span class="text-xs text-slate-500">Partners: Atlas Drive – Opportunities</span>
        <div class="flex items-center gap-4">
          <a href="#" class="text-xs text-slate-500 hover:text-teal-600 transition-colors no-underline">Privacy</a>
          <a href="#" class="text-xs text-slate-500 hover:text-teal-600 transition-colors no-underline">Terms</a>
        </div>
      </div>
    </footer>

  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const activeStep      = ref(0)
const bookingCity     = ref('')
const pickupDate      = ref('')
const returnDate      = ref('')
const bookingCategory = ref('')

const navLinks = [
  { label: 'Home',     href: '/',         active: false },
  { label: 'Fleet',    href: '/fleet',    active: false },
  { label: 'Services', href: '/services', active: true  },
]

const cities = ['Casablanca', 'Marrakech', 'Rabat', 'Fès', 'Tanger', 'Agadir', 'Meknès', 'Oujda']

const totalDays = computed(() => {
  if (!pickupDate.value || !returnDate.value) return 0
  const diff = new Date(returnDate.value) - new Date(pickupDate.value)
  return Math.max(0, Math.ceil(diff / (1000 * 60 * 60 * 24)))
})

const services = [
  { title: 'Daily Car Rental', desc: 'Rent any vehicle for a day or more. Perfect for city trips, business meetings, or weekend getaways across Morocco.', badge: 'Most Popular', bg: '#f0fdfa', border: '#99f6e4', iconColor: '#0d9488', href: '/fleet', features: ['Flexible pickup times', 'Unlimited mileage available', 'Insurance included'], icon: `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>` },
  { title: 'Long-Term Lease', desc: 'Need a car for a month or more? Get the best rates with our long-term rental packages — ideal for expats and businesses.', badge: 'Best Value', bg: '#eff6ff', border: '#bfdbfe', iconColor: '#3b82f6', href: '/fleet', features: ['Up to 40% discount', 'Monthly billing', 'Vehicle swap option'], icon: `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>` },
  { title: 'Airport Transfer', desc: 'Start your trip stress-free. Pick up your rental directly at the airport and drop it off when you land back.', badge: null, bg: '#fdf4ff', border: '#e9d5ff', iconColor: '#9333ea', href: '/fleet', features: ['All major airports', 'Flight tracking', 'Meet & greet service'], icon: `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.63A2 2 0 012 .18h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6z"/></svg>` },
  { title: 'Electric Vehicles', desc: 'Go green without compromise. Choose from our growing fleet of electric cars — Teslas, Renault Zoe, Peugeot e-2008 and more.', badge: '🌱 Eco', bg: '#f0fdf4', border: '#bbf7d0', iconColor: '#16a34a', href: '/fleet', features: ['Zero emissions', 'Charging support', 'Tesla Model 3 available'], icon: `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>` },
  { title: 'Luxury Experience', desc: 'Arrive in style. Our luxury fleet includes BMW, Mercedes, Audi and Porsche — perfect for weddings, events and VIP clients.', badge: '⭐ Premium', bg: '#fffbeb', border: '#fde68a', iconColor: '#d97706', href: '/fleet', features: ['BMW, Mercedes, Porsche', 'Chauffeur available', 'Event packages'], icon: `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/></svg>` },
  { title: 'Family & Group', desc: 'Travelling with family? Our 7-seat MPVs and minivans make group travel comfortable and affordable for everyone.', badge: null, bg: '#fff1f2', border: '#fecdd3', iconColor: '#e11d48', href: '/fleet', features: ['7-seat vehicles', 'Child seat available', 'Large trunk space'], icon: `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>` },
]

const steps = [
  { title: 'Choose Your Car', desc: 'Browse our full fleet filtered by category, city, price or fuel type.', icon: `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>` },
  { title: 'Pick Your Dates', desc: 'Select pick-up and return dates. Get an instant price breakdown.', icon: `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>` },
  { title: 'Confirm Booking', desc: 'Create your account or sign in, then confirm your reservation instantly.', icon: `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="20 6 9 17 4 12"/></svg>` },
  { title: 'Hit the Road', desc: 'Pick up your car from the agency and enjoy your drive across Morocco.', icon: `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>` },
]

const platformStats = [
  { value: '180+',    label: 'Partner Agencies' },
  { value: '1,200+', label: 'Vehicles'          },
  { value: '12,000+',label: 'Happy Clients'     },
  { value: '4.9★',   label: 'Average Rating'    },
]

const bookingPerks = [
  'Free cancellation up to 24h before pickup',
  'No hidden fees — price shown is price paid',
  'Basic insurance included in every rental',
  'Verified agencies only — no surprises',
  'Support available 7 days a week',
]

const whyUs = [
  { title: 'Verified Agencies', desc: 'Every agency on Atlas Drive is manually reviewed and verified before listing.', icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>` },
  { title: 'Instant Confirmation', desc: 'No waiting — your booking is confirmed the moment you submit.', icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>` },
  { title: 'Best Price Guarantee', desc: 'We compare prices across agencies so you always get the best deal.', icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>` },
  { title: '7-Day Support', desc: 'Our team is available every day of the week to help you with anything.', icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.63A2 2 0 012 .18h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6z"/></svg>` },
]
</script>