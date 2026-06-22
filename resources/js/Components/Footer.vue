<template>
  <footer class="bg-slate-900 text-slate-300" style="font-family:'Sora',sans-serif;">

    <!-- ── Main footer grid ── -->
    <div class="max-w-7xl mx-auto px-6 py-14">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">

        <!-- Brand column -->
        <div class="lg:col-span-2">
          <div class="flex items-center gap-3 mb-4">
            <svg width="32" height="32" viewBox="0 0 28 28" fill="none" class="flex-shrink-0">
              <path d="M4 20L10 8L16 16L20 10L24 20" stroke="#14b8a6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M2 14L6 10" stroke="#14b8a6" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <span class="font-bold text-white text-lg tracking-tight"
              style="font-family:'Plus Jakarta Sans',sans-serif;">Atlas Drive</span>
          </div>
          <p class="text-sm text-slate-400 leading-relaxed max-w-sm mb-5">
            The multi-agency car rental platform connecting clients with trusted rental agencies across Morocco. Book in minutes, drive with confidence.
          </p>

          <!-- Social links -->
          <div class="flex items-center gap-3">
            <a v-for="social in socials" :key="social.label" :href="social.href"
              :aria-label="social.label"
              class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-teal-600 flex items-center justify-center text-slate-400 hover:text-white transition-all duration-200 no-underline">
              <span v-html="social.icon"></span>
            </a>
          </div>
        </div>

        <!-- Platform links -->
        <div>
          <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Platform</p>
          <ul class="flex flex-col gap-2.5">
            <li v-for="link in platformLinks" :key="link.label">
              <Link :href="link.href" class="text-sm text-slate-400 hover:text-teal-400 no-underline transition-colors">
                {{ link.label }}
              </Link>
            </li>
          </ul>
        </div>

        <!-- For agencies -->
        <div>
          <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">For Agencies</p>
          <ul class="flex flex-col gap-2.5">
            <li v-for="link in agencyLinks" :key="link.label">
              <Link :href="link.href" class="text-sm text-slate-400 hover:text-teal-400 no-underline transition-colors">
                {{ link.label }}
              </Link>
            </li>
          </ul>
        </div>

        <!-- Support -->
        <div>
          <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Support</p>
          <ul class="flex flex-col gap-2.5">
            <li v-for="link in supportLinks" :key="link.label">
              <Link :href="link.href" class="text-sm text-slate-400 hover:text-teal-400 no-underline transition-colors">
                {{ link.label }}
              </Link>
            </li>
          </ul>
        </div>

      </div>
    </div>

    <!-- ── Bottom bar ── -->
    <div class="border-t border-slate-800">
      <div class="max-w-7xl mx-auto px-6 py-5 flex flex-col sm:flex-row items-center justify-between gap-3">
        <p class="text-xs text-slate-500">
          © {{ currentYear }} Atlas Drive. All rights reserved.
        </p>
        <div class="flex items-center gap-5">
          <Link href="/privacy" class="text-xs text-slate-500 hover:text-teal-400 no-underline transition-colors">
            Privacy Policy
          </Link>
          <Link href="/terms" class="text-xs text-slate-500 hover:text-teal-400 no-underline transition-colors">
            Terms of Service
          </Link>
          <span class="text-xs text-slate-600 flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
            Made in Morocco 🇲🇦
          </span>
        </div>
      </div>
    </div>

  </footer>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

const currentYear = new Date().getFullYear()

const platformLinks = [
  { label: 'Browse Fleet',    href: '/fleet'    },
  { label: 'Find an Agency',  href: '/agencies' },
  { label: 'Pricing',         href: '/pricing'  },
  { label: 'How it Works',    href: '/#how-it-works' },
]

const agencyLinks = [
  { label: 'Register Your Agency', href: '/agency/register'  },
  { label: 'Agency Login',         href: '/login'             },
  { label: 'Agency Pricing',       href: '/pricing'           },
  { label: 'Partner Benefits',     href: '/#benefits'         },
]

const supportLinks = [
  { label: 'Help Center',     href: '/help'    },
  { label: 'Contact Us',      href: '/contact' },
  { label: 'FAQ',             href: '/#faq'    },
  { label: 'Safety',          href: '/safety'  },
]

const socials = [
  { label: 'Instagram', href: 'https://instagram.com',
    icon: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>' },
  { label: 'Facebook', href: 'https://facebook.com',
    icon: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>' },
  { label: 'LinkedIn', href: 'https://linkedin.com',
    icon: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>' },
  { label: 'X (Twitter)', href: 'https://x.com',
    icon: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4l16 16M20 4L4 20"/></svg>' },
]
</script>