<template>
  <div class="min-h-screen bg-slate-100">
    <Navbar />
    <HeroSection />
  
    <!-- Categories Section -->
    <section class="max-w-6xl mx-auto px-6 pt-10 pb-6">
      <h2
        class="font-bold text-center text-gray-900 text-xl tracking-tight mb-5"
        style="font-family:'Sora',sans-serif;"
      >
        Our Categories
      </h2>

      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        <div
          v-for="cat in categories"
          :key="cat.name"
          class="bg-white rounded-xl overflow-hidden shadow-sm cursor-pointer
                 transition-all duration-200 hover:-translate-y-1
                 hover:shadow-teal-200 hover:shadow-lg"
        >
          <img :src="cat.image" :alt="cat.name" class="w-full h-32 object-cover block" />
          <div class="flex items-center justify-between px-3 py-2.5">
            <span class="font-bold text-gray-900 text-sm" style="font-family:'Sora',sans-serif;">
              {{ cat.name }}
            </span>
            <span class="text-teal-600 flex items-center" v-html="cat.icon" />
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="max-w-6xl mx-auto px-6 pb-8 grid grid-cols-1 md:grid-cols-2 gap-5">

      <!-- Client Card -->
      <div class="bg-white rounded-2xl p-6 shadow-sm grid grid-cols-[60px_1fr] gap-x-4 gap-y-3 items-start">
        <div class="flex items-center justify-center">
          <svg width="52" height="52" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="26" cy="26" r="26" fill="#f0fdfa"/>
            <path d="M18 28l4-4 4 4 6-8" stroke="#0d9488" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="20" cy="32" r="3" stroke="#0d9488" stroke-width="2"/>
            <path d="M32 22c1.1 0 2 .9 2 2v4h-4v-4c0-1.1.9-2 2-2z" stroke="#0d9488" stroke-width="2"/>
            <path d="M16 20l3-5 1 3h3l-2.5 3.5" stroke="#0d9488" stroke-width="1.5" stroke-linecap="round"/>
          </svg>
        </div>
        <div>
          <h3 class="font-bold text-gray-900 text-lg mb-0.5" style="font-family:'Sora',sans-serif;">
            Ready to Rent?
          </h3>
          <p class="text-sm font-semibold text-gray-700 mb-0.5" style="font-family:'Sora',sans-serif;">
            Create Client Account (User)
          </p>
          <p class="text-xs text-slate-500" style="font-family:'Sora',sans-serif;">
            Benefits: access top vehicles, easy booking &amp; more
          </p>
        </div>
        <Link
          :href="route('register.client')"
          class="col-span-2 mt-1 w-full text-center bg-teal-600 hover:bg-teal-700
                 active:translate-y-px text-white font-semibold text-sm py-2.5 px-4
                 rounded-lg transition-all duration-150 block no-underline"
          style="font-family:'Sora',sans-serif;"
        >
          Create Client Account (User)
        </Link>
      </div>

      <!-- Agency Card -->
      <div class="bg-white rounded-2xl p-6 shadow-sm grid grid-cols-[60px_1fr] gap-x-4 gap-y-3 items-start">
        <div class="flex items-center justify-center">
          <svg width="52" height="52" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="26" cy="26" r="26" fill="#f0fdfa"/>
            <rect x="16" y="18" width="20" height="16" rx="2" stroke="#0d9488" stroke-width="2"/>
            <path d="M20 24h12M20 28h8" stroke="#0d9488" stroke-width="2" stroke-linecap="round"/>
            <path d="M26 18v-3M23 15h6" stroke="#0d9488" stroke-width="1.5" stroke-linecap="round"/>
          </svg>
        </div>
        <div>
          <h3 class="font-bold text-gray-900 text-lg mb-0.5" style="font-family:'Sora',sans-serif;">
            Partner with Us?
          </h3>
          <p class="text-sm font-semibold text-gray-700 mb-0.5" style="font-family:'Sora',sans-serif;">
            Register Your Agency (Agence)
          </p>
          <p class="text-xs text-slate-500" style="font-family:'Sora',sans-serif;">
            Benefits: grow your fleet, manage bookings &amp; earn more
          </p>
        </div>
        <Link
          :href="route('agency.register')"
          class="col-span-2 mt-1 w-full text-center bg-teal-600 hover:bg-teal-700
                 active:translate-y-px text-white font-semibold text-sm py-2.5 px-4
                 rounded-lg transition-all duration-150 block no-underline"
          style="font-family:'Sora',sans-serif;"
        >
          Register Your Agency (Agence)
        </Link>
      </div>

    </section>

    <!-- Footer -->
    <footer class="max-w-6xl mx-auto px-6 py-4 flex flex-col sm:flex-row items-center
                   justify-between border-t border-slate-200 gap-3">
      <span class="text-xs text-slate-500" style="font-family:'Sora',sans-serif;">
        Partners: Atlas Drive – Opportunities
      </span>
      <div class="flex items-center gap-5 flex-wrap justify-center">
        <span class="text-sm font-bold text-yellow-400">amazon</span>
        <span class="text-sm font-bold text-gray-700">🌿 croncat</span>
        <span class="text-sm font-bold text-gray-700">✦ Atlas Drive</span>
        <span class="text-sm font-bold text-gray-700">🔴🟠</span>
        <span class="text-sm font-bold text-blue-800">PayPal</span>
        <span class="text-sm font-bold text-blue-900 italic text-base">VISA</span>
      </div>
    </footer>

  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import Navbar from '@/Components/Navbar.vue'
import HeroSection from '@/Components/HeroSection.vue'

const categories = [
  {
    name: 'Luxury',
    image: 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=400&q=80',
    icon: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/></svg>`,
  },
  {
    name: 'SUV',
    image: 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=400&q=80',
    icon: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>`,
  },
  {
    name: 'Economy',
    image: 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?w=400&q=80',
    icon: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="10" width="20" height="8" rx="2"/><path d="M5 10V8a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>`,
  },
  {
    name: 'Electric',
    image: 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?w=400&q=80',
    icon: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>`,
  },
  {
    name: 'Family',
    image: 'https://images.unsplash.com/photo-1609521263047-f8f205293f24?w=400&q=80',
    icon: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>`,
  },
]
</script>