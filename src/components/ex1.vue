<template>
  <nav class="sticky top-0 z-50 flex items-center justify-between px-8 h-16 bg-white border-b border-gray-200">

    <!-- Brand -->
    <RouterLink to="/" class="flex items-center gap-2" style="text-decoration: none;">
      <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M4 20L10 8L16 16L20 10L24 20" stroke="#0d9488" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M2 14L6 10" stroke="#0d9488" stroke-width="2" stroke-linecap="round"/>
      </svg>
      <span class="font-bold text-xl text-slate-900 tracking-tight sora">Atlas Drive</span>
    </RouterLink>

    <!-- Nav Links -->
    <ul class="flex items-center gap-8 list-none m-0 p-0">
      <li>
        <RouterLink to="/" class="nav-link" active-class="active" exact>Home</RouterLink>
      </li>
      <li>
        <RouterLink to="/fleet" class="nav-link" active-class="active">Fleet</RouterLink>
      </li>
      <li>
        <RouterLink to="/agencies" class="nav-link" active-class="active">Agencies</RouterLink>
      </li>
      <li>
        <RouterLink to="/pricing" class="nav-link" active-class="active">Pricing</RouterLink>
      </li>
    </ul>

    <!-- Login Button -->
    <button class="sora bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-5 py-2 rounded-lg border-none cursor-pointer transition-all duration-200 hover:-translate-y-px">
      Log In
    </button>

  </nav>
</template>

<script setup>
</script>

<style scoped>
.sora { font-family: 'Sora', sans-serif; }

.nav-link {
  font-family: 'Sora', sans-serif;
  font-size: 0.95rem;
  font-weight: 500;
  color: #64748b;
  text-decoration: none;
  transition: color 0.2s;
}
.nav-link:hover,
.nav-link.active {
  color: #0d9488;
}
</style>