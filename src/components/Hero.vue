<template>
  <section class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <h1 class="hero-title">Find Your Perfect Drive</h1>
      <div class="search-bar">
        <div class="search-field" >
          <label>Pick-up Location</label>
          <div class="input-wrapper">
            <svg class="input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" placeholder="Pick-up Location" />
          </div>
        </div>

        <div class="search-field">
          <label>Dates</label>
          <div class="input-wrapper date-range">
            <svg class="input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <input type="text" placeholder="Da-Aoné" class="date-input" />
            <span class="date-sep">–</span>
            <svg class="input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <input type="text" placeholder="Da-Dour" class="date-input" />
          </div>
        </div>

        <div class="search-field">
          <label>Vehicle Type</label>
          <div class="input-wrapper">
            <select>
              <option value="">Vehicle Type</option>
              <option>Luxury</option>
              <option>SUV</option>
              <option>Economy</option>
              <option>Electric</option>
              <option>Family</option>
            </select>
          </div>
        </div>

        <button class="btn-search">Search</button>
      </div>
    </div>
  </section>
</template>

<script setup>
</script>

<style scoped>
.hero {
  position: relative;
  height: 300px;
  background: url('https://images.unsplash.com/photo-1485291571150-772bcfc10da5?w=1400&q=80') center/cover no-repeat;
  display: flex;
  align-items: center;
  justify-content: center;
}

.hero-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to bottom, rgba(0,0,0,0.25), rgba(0,0,0,0.35));
}

.hero-content {
  position: relative;
  z-index: 1;
  text-align: center;
  width: 100%;
  max-width: 900px;
  padding: 0 1.5rem;
}

.hero-title {
  font-family: 'Sora', sans-serif;
  font-size: 2.4rem;
  font-weight: 700;
  color: white;
  margin-bottom: 1.5rem;
  text-shadow: 0 2px 8px rgba(0,0,0,0.3);
  letter-spacing: -0.02em;
}

.search-bar {
  display: flex;
  align-items: flex-end;
  gap: 0.75rem;
  background: white;
  border-radius: 14px;
  padding: 1.25rem 1.25rem;
  box-shadow: 0 8px 32px rgba(0,0,0,0.18);
}

.search-field {
  display: flex;
  flex-direction: column;
  gap: 0.35rem;
  flex: 1;
}

.search-field label {
  font-family: 'Sora', sans-serif;
  font-size: 0.75rem;
  font-weight: 600;
  color: #374151;
  text-align: left;
}

.input-wrapper {
  display: flex;
  align-items: center;
  border: 1.5px solid #e5e7eb;
  border-radius: 8px;
  padding: 0.5rem 0.75rem;
  gap: 0.5rem;
  background: white;
  transition: border-color 0.2s;
}

.input-wrapper:focus-within {
  border-color: #0d9488;
}

.input-wrapper.date-range {
  gap: 0.35rem;
}

.input-icon {
  color: #9ca3af;
  flex-shrink: 0;
}

.input-wrapper input,
.input-wrapper select {
  border: none;
  outline: none;
  font-family: 'Sora', sans-serif;
  font-size: 0.85rem;
  color: #374151;
  background: transparent;
  width: 100%;
}

.input-wrapper select {
  cursor: pointer;
}

.date-input {
  width: 70px !important;
  min-width: 0;
}

.date-sep {
  color: #9ca3af;
  font-size: 0.9rem;
}

.btn-search {
  background: #0d9488;
  color: white;
  border: none;
  padding: 0.6rem 1.6rem;
  border-radius: 8px;
  font-family: 'Sora', sans-serif;
  font-size: 0.95rem;
  font-weight: 600;
  cursor: pointer;
  white-space: nowrap;
  height: 40px;
  transition: background 0.2s, transform 0.1s;
}

.btn-search:hover {
  background: #0f766e;
  transform: translateY(-1px);
}
</style>