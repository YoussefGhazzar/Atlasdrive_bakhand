<template>
  <div class="page">
    
    <section class="categories-section">
      <h2 class="section-title">Our Categories</h2>
      <div class="categories-grid">
        <div
          v-for="cat in categories"
          :key="cat.name"
          class="category-card"
        >
          <img :src="cat.image" :alt="cat.name" class="category-img" />
          <div class="category-label">
            <span class="category-name">{{ cat.name }}</span>
            <span class="category-icon" v-html="cat.icon"></span>
          </div>
        </div>
      </div>
    </section>

    <section class="cta-section " >
      <div class="cta-card">
        <div class="cta-icon">
          <svg width="52" height="52" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle  cx="26" cy="26" r="26" fill="#f0fdfa"/>
            <path d="M18 28l4-4 4 4 6-8" stroke="#0d9488" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="20" cy="32" r="3" stroke="#0d9488" stroke-width="2"/>
            <path d="M32 22c1.1 0 2 .9 2 2v4h-4v-4c0-1.1.9-2 2-2z" stroke="#0d9488" stroke-width="2"/>
            <path d="M16 20l3-5 1 3h3l-2.5 3.5" stroke="#0d9488" stroke-width="1.5" stroke-linecap="round"/>
          </svg>
        </div>
        <div class="cta-content">
          <h3>Ready to Rent?</h3>
          <p class="cta-subtitle">Create Client Account (User)</p>
          <p class="cta-benefits">Benefits: changulices and friends</p>
        </div>
        <RouterLink to="/register" class="btn-cta">Create Client Account (User)</RouterLink>
      </div>

      <div class="cta-card">
        <div class="cta-icon">
          <svg width="52" height="52" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="26" cy="26" r="26" fill="#f0fdfa"/>
            <rect x="16" y="18" width="20" height="16" rx="2" stroke="#0d9488" stroke-width="2"/>
            <path d="M20 24h12M20 28h8" stroke="#0d9488" stroke-width="2" stroke-linecap="round"/>
            <path d="M26 18v-3M23 15h6" stroke="#0d9488" stroke-width="1.5" stroke-linecap="round"/>
          </svg>
        </div>
        <div class="cta-content">
          <h3>Partner with Us?</h3>
          <p class="cta-subtitle">Register Your Agency (Agence)</p>
          <p class="cta-benefits">Benefits: building profits, and corporates</p>
        </div>
        <RouterLink to="/register" class="btn-cta">Register Your Agency (Agence)</RouterLink>
      </div>
    </section>

    
    <footer class="footer">
      <div class="footer-left">
        <span>Partners: Atlas Drive, - Opportunities</span>
      </div>
      <div class="footer-logos">
        <span class="partner-logo amazon">amazon</span>
        <span class="partner-logo croncat">🌿 croncat</span>
        <span class="partner-logo atlasdrive">✦ Atlas Drive</span>
        <span class="partner-logo mc">🔴🟠</span>
        <span class="partner-logo paypal">PayPal</span>
        <span class="partner-logo visa">VISA</span>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { RouterLink } from 'vue-router';
const categories = [
  {
    name: 'Luxury',
    image: 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=400&q=80',
    icon: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/></svg>`
  },
  {
    name: 'SUV',
    image: 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=400&q=80',
    icon: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>`
  },
  {
    name: 'Economy',
    image: 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?w=400&q=80',
    icon: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="10" width="20" height="8" rx="2"/><path d="M5 10V8a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>`
  },
  {
    name: 'Electric',
    image: 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?w=400&q=80',
    icon: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>`
  },
  {
    name: 'Family',
    image: 'https://images.unsplash.com/photo-1609521263047-f8f205293f24?w=400&q=80',
    icon: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>`
  },
]
</script>

<style scoped>
.page {
  background: #f1f5f9;
  min-height: calc(100vh - 64px);
}


.categories-section {
  padding: 2.5rem 2rem 1.5rem;
  max-width: 1200px;
  margin: 0 auto;
}

.section-title {
  font-family: 'Sora', sans-serif;
  font-size: 1.4rem;
  font-weight: 700;
  color: #0f172a;
  text-align: center;
  margin-bottom: 1.25rem;
  letter-spacing: -0.01em;
}

.categories-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 1rem;
}

.category-card {
  border-radius: 12px;
  overflow: hidden;
  cursor: pointer;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  transition: transform 0.2s, box-shadow 0.2s;
  background: #fff;
}

.category-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(13,148,136,0.18);
}

.category-img {
  width: 100%;
  height: 130px;
  object-fit: cover;
  display: block;
}

.category-label {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0.65rem 0.85rem;
  background: white;
}

.category-name {
  font-family: 'Sora', sans-serif;
  font-size: 0.95rem;
  font-weight: 700;
  color: #0f172a;
}

.category-icon {
  color: #0d9488;
  display: flex;
  align-items: center;
}


.cta-section {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.25rem;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0.5rem 2rem 2rem;
}

.cta-card {
  background: white;
  border-radius: 14px;
  padding: 1.5rem 1.5rem 1.25rem;
  display: grid;
  grid-template-columns: 60px 1fr;
  grid-template-rows: auto auto;
  gap: 0.5rem 1rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.06);
  align-items: start;
}

.cta-icon {
  grid-row: 1;
  grid-column: 1;
  display: flex;
  align-items: center;
  justify-content: center;
}

.cta-content {
  grid-row: 1;
  grid-column: 2;
}

.cta-content h3 {
  font-family: 'Sora', sans-serif;
  font-size: 1.1rem;
  font-weight: 700;
  color: #0f172a;
  margin: 0 0 0.2rem;
}

.cta-subtitle {
  font-family: 'Sora', sans-serif;
  font-size: 0.82rem;
  font-weight: 600;
  color: #374151;
  margin: 0 0 0.15rem;
}

.cta-benefits {
  font-family: 'Sora', sans-serif;
  font-size: 0.78rem;
  color: #64748b;
  margin: 0;
}

.btn-cta {
  grid-column: 1 / -1;
  background: #0d9488;
  color: white;
  border: none;
  padding: 0.7rem 1rem;
  border-radius: 8px;
  font-family: 'Sora', sans-serif;
  font-size: 0.9rem;
  font-weight: 600;
  cursor: pointer;
  width: 100%;
  transition: background 0.2s, transform 0.1s;
  margin-top: 0.5rem;
}

.btn-cta:hover {
  background: #0f766e;
  transform: translateY(-1px);
}


.footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1rem 2rem;
  background: #f1f5f9;
  border-top: 1px solid #e2e8f0;
  max-width: 1200px;
  margin: 0 auto;
}

.footer-left span {
  font-family: 'Sora', sans-serif;
  font-size: 0.82rem;
  color: #64748b;
}

.footer-logos {
  display: flex;
  align-items: center;
  gap: 1.2rem;
}

.partner-logo {
  font-family: 'Sora', sans-serif;
  font-size: 0.82rem;
  font-weight: 700;
  color: #374151;
  letter-spacing: -0.01em;
}

.amazon { color: #f90; }
.paypal { color: #003087; }
.visa { color: #1a1f71; font-style: italic; font-size: 1rem; }
</style>