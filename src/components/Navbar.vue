<template>
  <nav class="sticky top-0 z-50 flex items-center justify-between px-8 h-16 bg-white border-b border-gray-200 font-['Sora',sans-serif]">

    <!-- Brand -->
    <RouterLink to="/" class="flex items-center gap-2 no-underline">
      <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
        <path d="M4 20L10 8L16 16L20 10L24 20" stroke="#0d9488" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M2 14L6 10" stroke="#0d9488" stroke-width="2" stroke-linecap="round"/>
      </svg>
      <span class="font-bold text-xl text-slate-900 tracking-tight">Atlas Drive</span>
    </RouterLink>

    <!-- Nav Links -->
    <ul class="flex items-center gap-8 list-none m-0 p-0">
      <li>
        <RouterLink to="/" class="text-sm font-medium text-slate-500 hover:text-teal-600 no-underline transition-colors" active-class="text-teal-600" exact>Home</RouterLink>
      </li>
      <li>
        <RouterLink to="/fleet" class="text-sm font-medium text-slate-500 hover:text-teal-600 no-underline transition-colors" active-class="text-teal-600">Fleet</RouterLink>
      </li>
      <li>
        <RouterLink to="/agencies" class="text-sm font-medium text-slate-500 hover:text-teal-600 no-underline transition-colors" active-class="text-teal-600">Agencies</RouterLink>
      </li>
      <li>
        <RouterLink to="/pricing" class="text-sm font-medium text-slate-500 hover:text-teal-600 no-underline transition-colors" active-class="text-teal-600">Pricing</RouterLink>
      </li>
    </ul>

    <!-- Right side -->
    <div class="flex items-center gap-3 relative">

      <!-- Dashboard Dropdown -->
      <div class="relative">
        <button
          @click="dropdownOpen = !dropdownOpen"
          class="flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-teal-600 bg-slate-50 hover:bg-teal-50 border border-slate-200 hover:border-teal-300 px-4 py-2 rounded-lg cursor-pointer transition-all duration-200 border-none"
          style="border:1.5px solid #e2e8f0;"
        >
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
            <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
          </svg>
          Dashboard
          <svg :class="['w-3.5 h-3.5 transition-transform duration-200', dropdownOpen ? 'rotate-180' : '']"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="6 9 12 15 18 9"/>
          </svg>
        </button>

        <!-- Dropdown Menu -->
        <div v-if="dropdownOpen"
          class="absolute right-0 top-full mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden z-50">

          <div class="px-4 py-2.5 border-b border-slate-100">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Access Dashboard</p>
          </div>

          <div class="p-2">
            <!-- Client -->
            <RouterLink to="/dashboard/client"
              @click="dropdownOpen=false"
              class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-teal-50 no-underline transition-colors group">
              <div class="w-8 h-8 rounded-lg bg-teal-100 flex items-center justify-center flex-shrink-0 group-hover:bg-teal-200 transition-colors">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
              </div>
              <div>
                <p class="text-sm font-bold text-slate-800">Client Dashboard</p>
                <p class="text-xs text-slate-400">My bookings & rentals</p>
              </div>
            </RouterLink>

            <!-- Agency -->
            <RouterLink to="/dashboard/agency"
              @click="dropdownOpen=false"
              class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-purple-50 no-underline transition-colors group">
              <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center flex-shrink-0 group-hover:bg-purple-200 transition-colors">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2">
                  <rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                </svg>
              </div>
              <div>
                <p class="text-sm font-bold text-slate-800">Agency Dashboard</p>
                <p class="text-xs text-slate-400">Manage fleet & bookings</p>
              </div>
            </RouterLink>

            <!-- Admin -->
            <RouterLink to="/dashboard/admin"
              @click="dropdownOpen=false"
              class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 no-underline transition-colors group">
              <div class="w-8 h-8 rounded-lg bg-slate-200 flex items-center justify-center flex-shrink-0 group-hover:bg-slate-300 transition-colors">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#374151" stroke-width="2">
                  <circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                </svg>
              </div>
              <div>
                <p class="text-sm font-bold text-slate-800">Admin Panel</p>
                <p class="text-xs text-slate-400">Platform management</p>
              </div>
            </RouterLink>
          </div>
        </div>
      </div>

      <!-- Login Button -->
      <RouterLink to="/login"
        class="bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-5 py-2 rounded-lg no-underline transition-all duration-200 hover:-translate-y-px">
        Log In
      </RouterLink>
    </div>

    <!-- Click outside to close -->
    <div v-if="dropdownOpen" @click="dropdownOpen=false" class="fixed inset-0 z-40"></div>
    <!-- Login Button -->
    <RouterLink to="/login" class="sora bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-5 py-2 rounded-lg border-none cursor-pointer transition-all duration-200 hover:-translate-y-px">
      Log In
    </RouterLink>

  </nav>
</template>

<script setup>
import { ref } from 'vue'

const dropdownOpen = ref(false)
</script>