<template>
  <div class="min-h-screen flex flex-col bg-white text-slate-800 font-sans selection:bg-blue-600 selection:text-white">
   <nav class="border-b border-gray-100 px-8 h-20 flex justify-between items-center bg-white/80 backdrop-blur-xl sticky top-0 z-50">
  <div class="flex items-center gap-3">
    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center font-black text-white shadow-lg shadow-blue-200">
      D
    </div>
    <span class="text-2xl font-bold tracking-tight text-slate-900">AtlasDrive</span>
  </div>

  <div class="flex items-center gap-10">
    <div class="hidden md:flex gap-10 text-[10px] uppercase tracking-[0.2em] font-black text-slate-400">
      <Link :href="route('welcome')" class="hover:text-blue-600 transition-colors">
        Home
      </Link>
    </div>
  </div>

  <!-- Dropdown -->
  <div class="relative group">
    <Link
      :href="route('login')"
      class="text-[10px] uppercase tracking-[0.2em] font-black bg-slate-900 text-white px-8 py-3.5 rounded-xl hover:bg-blue-600 hover:shadow-xl hover:shadow-blue-200 transition-all"
    >
      Join Now
    </Link>

    <div class="absolute right-0 mt-4 w-56 bg-white border border-gray-100 rounded-2xl shadow-2xl shadow-slate-200/50 overflow-hidden opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all z-[60]">
      <Link
        :href="route('client.register')"
        class="block px-6 py-4 text-[10px] font-black uppercase tracking-widest hover:bg-blue-50 hover:text-blue-600 transition-colors"
      >
        As Individual
      </Link>

      <Link
        :href="route('agency.register.form')"
        class="block px-6 py-4 text-[10px] font-black uppercase tracking-widest hover:bg-blue-50 hover:text-blue-600 transition-colors"
      >
        As Fleet Partner
      </Link>
    </div>
  </div>
</nav>
          

    <!-- Main Content -->
    <main class="flex-grow">
      <slot />
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-100 py-24 px-8 bg-gray-50">
      <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-16">
        <div class="col-span-1 md:col-span-2">
          <div class="text-2xl font-bold tracking-tighter text-slate-900 mb-6 uppercase">DriveLink</div>
          <p class="text-sm font-medium text-slate-500 max-w-sm leading-relaxed antialiased">
            The premium network for urban mobility. Our platform connects selected high-end fleet agencies with verified professionals and adventurers worldwide.
          </p>
        </div>
        
        <div class="grid grid-cols-2 col-span-1 md:col-span-2 gap-16">
          <div>
            <h4 class="text-[10px] uppercase tracking-[0.3em] font-black mb-8 text-slate-300">Platforms</h4>
            <ul class="space-y-4 text-[10px] uppercase tracking-widest font-black">
              <li><a href="#" class="hover:text-blue-600 transition-colors">Client Hub</a></li>
              <li><a href="#" class="hover:text-blue-600 transition-colors">Agency Portal</a></li>
              <li><a href="#" class="hover:text-blue-600 transition-colors">Admin Engine</a></li>
            </ul>
          </div>
          <div>
            <h4 class="text-[10px] uppercase tracking-[0.3em] font-black mb-8 text-slate-300">Company</h4>
            <ul class="space-y-4 text-[10px] uppercase tracking-widest font-black">
              <li><a href="#" class="hover:text-blue-600 transition-colors">Terms of Service</a></li>
              <li><a href="#" class="hover:text-blue-600 transition-colors">Privacy Shield</a></li>
              <li><a href="#" class="hover:text-blue-600 transition-colors">Verification Standards</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="max-w-7xl mx-auto mt-24 pt-12 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="text-[9px] uppercase tracking-[0.4em] font-black text-slate-300">
          © 2026 DriveLink Mobility Systems AG
        </div>
        <div class="flex gap-8 text-[9px] uppercase tracking-[0.3em] font-black text-slate-400">
           <span>ISO 27001 Certified</span>
           <span>GDPR Compliant</span>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>
