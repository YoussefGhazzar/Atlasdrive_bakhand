<template>
  <div class="min-h-screen bg-slate-100" style="font-family:'Sora',sans-serif;">

    <!-- ── Floating Pill Navbar ── -->
    <div class="fixed top-4 left-0 right-0 z-50 flex justify-center px-4 pointer-events-none">
      <nav class="pointer-events-auto w-full max-w-5xl bg-white/80 backdrop-blur-xl border border-white/60 shadow-xl rounded-2xl px-5 h-14 flex items-center justify-between"
        style="box-shadow: 0 8px 32px rgba(13,148,136,0.10), 0 2px 8px rgba(0,0,0,0.08);">

        <!-- Brand -->
        <Link :href="route('home')" class="flex items-center gap-2 no-underline">
          <svg width="26" height="26" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 20L10 8L16 16L20 10L24 20" stroke="#0d9488" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M2 14L6 10" stroke="#0d9488" stroke-width="2" stroke-linecap="round"/>
          </svg>
          <span class="font-bold text-lg text-slate-900 tracking-tight" style="font-family:'Sora',sans-serif;">
            Atlas<span class="text-teal-600">Drive</span>
          </span>
        </Link>

        <!-- Nav Links -->
        <ul class="flex items-center gap-1 list-none m-0 p-0">
          <li v-for="link in navLinks" :key="link.label">
            <Link
              :href="route(link.route)"
              class="text-slate-500 hover:text-slate-900 no-underline text-sm font-medium px-3.5 py-1.5 rounded-xl transition-all duration-200 hover:bg-slate-100"
              :class="{ 'text-teal-600 font-semibold bg-teal-50 hover:bg-teal-50 hover:text-teal-600': $page.url === route(link.route) }"
            >
              {{ link.label }}
            </Link>
          </li>
        </ul>

        <!-- Auth Buttons -->
        <div class="flex items-center gap-2">
          <Link
            :href="route('login')"
            class="text-slate-600 hover:text-teal-600 font-semibold text-sm px-4 py-1.5 rounded-xl no-underline transition-colors duration-200 hover:bg-slate-100"
          >
            Log In
          </Link>
          <Link
            :href="route('register.client')"
            class="bg-teal-600 hover:bg-teal-700 active:translate-y-px text-white font-semibold text-sm px-4 py-1.5 rounded-xl no-underline transition-all duration-150"
          >
            Sign Up
          </Link>
        </div>
      </nav>
    </div>

    <!-- ── Hero Section ── -->
    <section class="relative overflow-hidden min-h-[560px] flex items-center justify-center">
      <!-- Background image -->
      <div class="absolute inset-0"
        style="background: url('/storage/images/background.png') center/cover no-repeat;"></div>
      <!-- Light overlay to keep text readable -->
      <div class="absolute inset-0" style="background: rgba(0,0,0,0);"></div>

      <div class="relative z-10 text-center w-full max-w-4xl mx-auto px-6 pt-20 pb-14">
        <!-- Badge -->
        <span class="inline-block text-xs font-semibold text-teal-100 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 backdrop-blur-sm tracking-wide mb-4">
          🇲🇦 Morocco's #1 Car Rental Platform
        </span>

        <h1 class="text-5xl md:text-6xl font-bold text-white mb-4 tracking-tight leading-tight"
          style="font-family:'Plus Jakarta Sans',sans-serif; text-shadow:0 2px 20px rgba(0,0,0,0.35);">
          Find Your<br/>
          <span class="text-teal-400">Perfect Drive</span>
        </h1>
        <p class="text-teal-100 text-lg font-medium mb-8 max-w-xl mx-auto">
          Browse hundreds of vehicles from verified agencies across Morocco. Book in minutes, drive with confidence.
        </p>

        <!-- Search Bar -->
        <div class="flex items-end gap-3 bg-white rounded-2xl px-5 py-4 shadow-2xl max-w-3xl mx-auto">
          <!-- Location -->
          <div class="flex flex-col gap-1.5 flex-1">
            <label class="text-xs font-semibold text-gray-500 text-left uppercase tracking-wide">Pick-up</label>
            <div class="flex items-center border border-gray-200 rounded-xl px-3 py-2 gap-2 focus-within:border-teal-500 transition-colors bg-white">
              <svg class="text-teal-500 shrink-0" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
              </svg>
              <input v-model="form.location" type="text" placeholder="City or airport"
                class="border-none outline-none text-sm text-gray-700 bg-transparent w-full placeholder-gray-400"
                style="font-family:'Sora',sans-serif;" />
            </div>
          </div>

          <!-- Dates -->
          <div class="flex flex-col gap-1.5 flex-1">
            <label class="text-xs font-semibold text-gray-500 text-left uppercase tracking-wide">Dates</label>
            <div class="flex items-center border border-gray-200 rounded-xl px-3 py-2 gap-1.5 focus-within:border-teal-500 transition-colors bg-white">
              <svg class="text-teal-500 shrink-0" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
              </svg>
              <input v-model="form.dateFrom" type="text" placeholder="From"
                class="border-none outline-none text-sm text-gray-700 bg-transparent w-[60px] min-w-0 placeholder-gray-400" style="font-family:'Sora',sans-serif;" />
              <span class="text-gray-300">—</span>
              <input v-model="form.dateTo" type="text" placeholder="To"
                class="border-none outline-none text-sm text-gray-700 bg-transparent w-[60px] min-w-0 placeholder-gray-400" style="font-family:'Sora',sans-serif;" />
            </div>
          </div>

          <!-- Type -->
          <div class="flex flex-col gap-1.5 flex-1">
            <label class="text-xs font-semibold text-gray-500 text-left uppercase tracking-wide">Type</label>
            <div class="flex items-center border border-gray-200 rounded-xl px-3 py-2 gap-2 focus-within:border-teal-500 transition-colors bg-white">
              <svg class="text-teal-500 shrink-0" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/>
              </svg>
              <select v-model="form.vehicleType" class="border-none outline-none text-sm text-gray-700 bg-transparent w-full cursor-pointer" style="font-family:'Sora',sans-serif;">
                <option value="">Any type</option>
                <option>Luxury</option><option>SUV</option><option>Economy</option><option>Electric</option><option>Family</option>
              </select>
            </div>
          </div>

          <!-- CTA -->
          <button @click="search"
            class="bg-teal-600 hover:bg-teal-700 active:translate-y-px text-white font-bold text-sm px-7 h-10 rounded-xl whitespace-nowrap transition-all duration-150 flex items-center gap-2 shrink-0 border-none cursor-pointer">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            Search
          </button>
        </div>

        <!-- Quick stats -->
        <div class="flex items-center justify-center gap-8 mt-8">
          <div v-for="stat in heroStats" :key="stat.label" class="flex items-center gap-2">
            <span class="text-teal-400 font-bold text-base">{{ stat.value }}</span>
            <span class="text-white/60 text-sm">{{ stat.label }}</span>
          </div>
        </div>
      </div>
    </section>

    <!-- ── Trust Bar ── -->
    <div class="bg-white border-b border-slate-100 shadow-sm">
      <div class="max-w-5xl mx-auto px-6 py-3 flex items-center justify-center gap-10 flex-wrap">
        <div v-for="trust in trustItems" :key="trust.text" class="flex items-center gap-2">
          <span v-html="trust.icon" class="text-teal-600"></span>
          <span class="text-xs font-semibold text-slate-500 whitespace-nowrap">{{ trust.text }}</span>
        </div>
      </div>
    </div>

    <!-- ── Categories Section ── -->
    <section class="max-w-5xl mx-auto px-6 pt-12 pb-6">
      <div class="flex items-center justify-between mb-6">
        <div>
          <p class="text-xs font-bold text-teal-600 uppercase tracking-widest mb-1">Browse by type</p>
          <h2 class="font-bold text-slate-900 text-2xl tracking-tight" style="font-family:'Plus Jakarta Sans',sans-serif;">
            Our Categories
          </h2>
        </div>
        <Link :href="route('fleet')" class="text-sm font-semibold text-teal-600 hover:text-teal-700 no-underline flex items-center gap-1 transition-colors">
          View all fleet
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </Link>
      </div>

      <div style="display:flex; flex-direction:row; gap:14px; width:100%; flex-wrap:nowrap;">
        <a
          v-for="cat in categories"
          :key="cat.name"
          :href="route('fleet')"
          style="flex:1; min-width:0; background:white; border-radius:16px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.08); text-decoration:none; display:block;"
        >
          <div style="width:100%; height:160px; overflow:hidden;">
            <img :src="cat.image" :alt="cat.name" style="width:100%; height:100%; object-fit:cover; display:block;" />
          </div>
          <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 12px;">
            <div>
              <span style="font-weight:700; color:#0f172a; font-size:14px; display:block;">{{ cat.name }}</span>
              <span style="font-size:11px; color:#94a3b8;">{{ cat.count }} vehicles</span>
            </div>
            <span style="color:#0d9488;" v-html="cat.icon" />
          </div>
        </a>
      </div>
    </section>

    <!-- ── How It Works ── -->
    <section class="max-w-5xl mx-auto px-6 py-12">
      <div class="text-center mb-8">
        <p class="text-xs font-bold text-teal-600 uppercase tracking-widest mb-1">Simple process</p>
        <h2 class="font-bold text-slate-900 text-2xl tracking-tight" style="font-family:'Plus Jakarta Sans',sans-serif;">
          Book in 3 Easy Steps
        </h2>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div v-for="(step, i) in steps" :key="step.title"
          class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:border-teal-200 hover:shadow-teal-100 hover:shadow-md transition-all duration-200 relative overflow-hidden">
          <div class="absolute top-3 right-4 text-[3rem] font-black text-slate-50 select-none leading-none" style="font-family:'Plus Jakarta Sans',sans-serif;">
            {{ String(i+1).padStart(2,'0') }}
          </div>
          <div class="w-11 h-11 rounded-xl bg-teal-50 flex items-center justify-center mb-4 relative z-10">
            <span v-html="step.icon" class="text-teal-600"></span>
          </div>
          <h3 class="font-bold text-slate-900 text-base mb-1.5 relative z-10" style="font-family:'Plus Jakarta Sans',sans-serif;">{{ step.title }}</h3>
          <p class="text-sm text-slate-500 leading-relaxed relative z-10">{{ step.desc }}</p>
        </div>
      </div>
    </section>

    <!-- ── CTA Cards — Register ── -->
    <section class="max-w-5xl mx-auto px-6 pb-12 grid grid-cols-1 md:grid-cols-2 gap-4">

      <!-- Client Card -->
      <div class="relative overflow-hidden bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:border-teal-200 hover:shadow-md transition-all duration-200">
        <div class="absolute top-0 right-0 w-32 h-32 opacity-5"
          style="background: radial-gradient(circle, #0d9488 0%, transparent 70%); transform: translate(30%, -30%);"></div>
        <div class="flex items-start gap-4 mb-4">
          <div class="w-12 h-12 rounded-xl bg-teal-50 flex items-center justify-center shrink-0">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="1.8">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
          </div>
          <div>
            <h3 class="font-bold text-slate-900 text-lg leading-tight mb-1" style="font-family:'Plus Jakarta Sans',sans-serif;">Ready to Rent?</h3>
            <p class="text-sm text-slate-500 leading-snug">Access top vehicles, instant booking, and exclusive member deals.</p>
          </div>
        </div>
        <ul class="flex flex-col gap-1.5 mb-5">
          <li v-for="b in clientBenefits" :key="b" class="flex items-center gap-2 text-sm text-slate-600">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
            {{ b }}
          </li>
        </ul>
        <Link :href="route('register.client')"
          class="w-full text-center bg-teal-600 hover:bg-teal-700 active:translate-y-px text-white font-semibold text-sm py-2.5 px-4 rounded-xl transition-all duration-150 block no-underline">
          Create Client Account
        </Link>
      </div>

      <!-- Agency Card -->
      <div class="relative overflow-hidden bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-6 shadow-sm border border-slate-700 hover:shadow-lg hover:shadow-teal-900/20 transition-all duration-200">
        <div class="absolute top-0 right-0 w-40 h-40 opacity-10"
          style="background: radial-gradient(circle, #0d9488 0%, transparent 70%); transform: translate(20%, -20%);"></div>
        <div class="flex items-start gap-4 mb-4">
          <div class="w-12 h-12 rounded-xl bg-teal-600/20 flex items-center justify-center shrink-0 border border-teal-500/30">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2dd4bf" stroke-width="1.8">
              <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>
            </svg>
          </div>
          <div>
            <span class="inline-block text-[0.65rem] font-bold text-teal-400 bg-teal-400/10 border border-teal-400/20 rounded-full px-2 py-0.5 mb-1 uppercase tracking-wider">Partner Program</span>
            <h3 class="font-bold text-white text-lg leading-tight" style="font-family:'Plus Jakarta Sans',sans-serif;">List Your Fleet</h3>
            <p class="text-sm text-slate-400 leading-snug mt-0.5">Grow your rental business with our platform.</p>
          </div>
        </div>
        <ul class="flex flex-col gap-1.5 mb-5">
          <li v-for="b in agencyBenefits" :key="b" class="flex items-center gap-2 text-sm text-slate-300">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2dd4bf" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
            {{ b }}
          </li>
        </ul>
        <Link :href="route('agency.register')"
          class="w-full text-center bg-teal-500 hover:bg-teal-400 active:translate-y-px text-slate-900 font-bold text-sm py-2.5 px-4 rounded-xl transition-all duration-150 block no-underline">
          Register Your Agency
        </Link>
      </div>

    </section>

    <Footer />

  </div>
</template>

<script setup>
import { reactive } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'
import Footer from '@/Components/Footer.vue'

const $page = usePage()

const navLinks = [
  { label: 'Home',     route: 'home'     },
  { label: 'Fleet',    route: 'fleet'    },
  { label: 'Services', route: 'services' },
]

const form = reactive({ location: '', dateFrom: '', dateTo: '', vehicleType: '' })
function search() {
  router.get(route('fleet'), form, { preserveState: true })
}

const heroStats = [
  { value: '500+', label: 'vehicles' },
  { value: '80+',  label: 'agencies' },
  { value: '12',   label: 'cities'   },
  { value: '4.8★', label: 'avg rating' },
]

const trustItems = [
  { icon: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>`, text: 'Verified Agencies' },
  { icon: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>`, text: 'Instant Booking' },
  { icon: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>`, text: 'Top Rated Fleet' },
  { icon: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg>`, text: 'Nationwide Coverage' },
  { icon: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>`, text: 'Secure Payments' },
]

const categories = [
  { name: 'Luxury',   count: 48,  image: '/storage/images/luxury.jpg',   icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/></svg>` },
  { name: 'SUV',      count: 76,  image: '/storage/images/suv.jpg',       icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>` },
  { name: 'Economy',  count: 120, image: '/storage/images/economic.jpg',  icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="10" width="20" height="8" rx="2"/><path d="M5 10V8a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>` },
  { name: 'Electric', count: 34,  image: '/storage/images/electric.jpg',  icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>` },
  { name: 'Family',   count: 62,  image: '/storage/images/family.jpg',    icon: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>` },
]

const steps = [
  {
    title: 'Search & Filter',
    desc: 'Enter your location, dates and preferred vehicle type to browse available options instantly.',
    icon: `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>`,
  },
  {
    title: 'Choose Your Car',
    desc: 'Compare vehicles across verified agencies. Read reviews, check availability and pick the best fit.',
    icon: `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>`,
  },
  {
    title: 'Book & Drive',
    desc: 'Confirm your booking securely online, get instant confirmation, and hit the road.',
    icon: `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 6L9 17l-5-5"/></svg>`,
  },
]

const clientBenefits = [
  'Instant booking confirmation',
  'Access 500+ verified vehicles',
  'Easy cancellation policy',
]

const agencyBenefits = [
  'Expand your reach nationwide',
  'Manage bookings from one dashboard',
  'Receive secure online payments',
]
</script>