<template>
  <div class="flex items-end gap-2 px-4 py-3 border-t border-slate-100 bg-white rounded-b-2xl">

    <!-- Textarea -->
    <textarea
      ref="textareaRef"
      v-model="text"
      @keydown.enter.exact.prevent="handleSend"
      @input="autoResize"
      placeholder="Type your message..."
      rows="1"
      :disabled="disabled"
      class="flex-1 resize-none border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition-colors max-h-28 disabled:opacity-50 disabled:cursor-not-allowed"
      style="font-family:'Sora',sans-serif;"
    ></textarea>

    <!-- Send button -->
    <button
      @click="handleSend"
      :disabled="!text.trim() || disabled"
      class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center border-none cursor-pointer transition-all duration-150 disabled:opacity-40 disabled:cursor-not-allowed"
      style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);">
      <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2">
        <line x1="22" y1="2" x2="11" y2="13"/>
        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
      </svg>
    </button>
  </div>
</template>

<script setup>
import { ref, nextTick } from 'vue'

const props = defineProps({
  disabled: { type: Boolean, default: false },
})

const emit = defineEmits(['send'])

const text = ref('')
const textareaRef = ref(null)

function handleSend() {
  const trimmed = text.value.trim()
  if (!trimmed || props.disabled) return

  emit('send', trimmed)
  text.value = ''

  nextTick(() => {
    if (textareaRef.value) {
      textareaRef.value.style.height = 'auto'
    }
  })
}

function autoResize(e) {
  const el = e.target
  el.style.height = 'auto'
  el.style.height = Math.min(el.scrollHeight, 112) + 'px'
}
</script>