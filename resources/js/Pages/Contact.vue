<template>
  <div class="min-h-screen bg-slate-100" style="font-family:Sora,sans-serif;">

    <Navbar />

    <div class="h-24"/>

    <section class="max-w-3xl mx-auto px-6 py-16">
      <div class="text-center mb-12">
        <span class="inline-block text-[10px] font-bold tracking-[0.3em] uppercase text-teal-600 border border-teal-200 bg-teal-50 rounded-full px-4 py-1.5 mb-4">Get In Touch</span>
        <h1 class="font-black text-4xl text-gray-900 tracking-tight mb-3" style="font-family:Sora,sans-serif;">Contact Us</h1>
        <p class="text-slate-500 text-lg" style="font-family:Sora,sans-serif;">We are here to help you with any questions about Atlas Drive.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-10">
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm text-center hover:shadow-teal-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
          <div class="w-12 h-12 rounded-2xl bg-teal-50 border border-teal-100 flex items-center justify-center mx-auto mb-4">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.63A2 2 0 012 .18h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6z"/></svg>
          </div>
          <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Phone 1</p>
          <a href="tel:0767633342" class="text-lg font-bold text-gray-900 no-underline hover:text-teal-600 transition-colors">0767 633 342</a>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm text-center hover:shadow-teal-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
          <div class="w-12 h-12 rounded-2xl bg-teal-50 border border-teal-100 flex items-center justify-center mx-auto mb-4">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.63A2 2 0 012 .18h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6z"/></svg>
          </div>
          <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Phone 2</p>
          <a href="tel:0767135293" class="text-lg font-bold text-gray-900 no-underline hover:text-teal-600 transition-colors">0767 135 293</a>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm text-center hover:shadow-teal-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
          <div class="w-12 h-12 rounded-2xl bg-teal-50 border border-teal-100 flex items-center justify-center mx-auto mb-4">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          </div>
          <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Email</p>
          <a href="mailto:atlasdrive@gmail.com" class="text-base font-bold text-gray-900 no-underline hover:text-teal-600 transition-colors">atlasdrive@gmail.com</a>
        </div>
      </div>

      <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
        <h2 class="font-bold text-xl text-gray-900 mb-6">Send us a message</h2>
        <div class="flex flex-col gap-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="text-xs font-bold text-slate-500 block mb-1.5">Full Name</label>
              <input type="text" placeholder="Your name" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-teal-500 transition-colors"/>
            </div>
            <div>
              <label class="text-xs font-bold text-slate-500 block mb-1.5">Email</label>
              <input type="email" placeholder="your@email.com" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-teal-500 transition-colors"/>
            </div>
          </div>
          <div>
            <label class="text-xs font-bold text-slate-500 block mb-1.5">Subject</label>
            <input type="text" placeholder="How can we help?" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-teal-500 transition-colors"/>
          </div>
          <div>
            <label class="text-xs font-bold text-slate-500 block mb-1.5">Message</label>
            <textarea rows="5" placeholder="Write your message here..." class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-teal-500 transition-colors resize-none"></textarea>
          </div>
          <button class="w-full bg-teal-600 hover:bg-teal-700 active:scale-95 text-white font-bold text-sm py-3 rounded-xl border-none cursor-pointer transition-all duration-200 shadow-md shadow-teal-200">Send Message</button>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue'
</script>
