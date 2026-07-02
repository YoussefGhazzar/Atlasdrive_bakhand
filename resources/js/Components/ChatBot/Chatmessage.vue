<template>
  <div :class="['flex gap-2.5 mb-3', isBot ? 'justify-start' : 'justify-end']">

    <!-- Bot avatar -->
    <div v-if="isBot"
      class="w-8 h-8 rounded-xl bg-teal-600 flex items-center justify-center text-white flex-shrink-0">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="11" width="18" height="10" rx="2"/>
        <circle cx="12" cy="5" r="2"/>
        <path d="M12 7v4"/>
        <line x1="8" y1="16" x2="8" y2="16"/>
        <line x1="16" y1="16" x2="16" y2="16"/>
      </svg>
    </div>

    <div :class="['flex flex-col gap-1 max-w-[75%]', isBot ? 'items-start' : 'items-end']">
      <!-- Bubble -->
      <div :class="[
        'px-4 py-2.5 rounded-2xl text-sm leading-relaxed',
        isBot
          ? 'bg-slate-100 text-slate-700 rounded-tl-sm'
          : 'bg-teal-600 text-white rounded-tr-sm'
      ]" style="font-family:'Sora',sans-serif;">

        <!-- Typing indicator -->
        <div v-if="message.typing" class="flex items-center gap-1 py-1">
          <span class="w-1.5 h-1.5 rounded-full bg-slate-400 animate-bounce" style="animation-delay: 0ms"></span>
          <span class="w-1.5 h-1.5 rounded-full bg-slate-400 animate-bounce" style="animation-delay: 150ms"></span>
          <span class="w-1.5 h-1.5 rounded-full bg-slate-400 animate-bounce" style="animation-delay: 300ms"></span>
        </div>

        <!-- Text content -->
        <p v-else class="whitespace-pre-wrap">{{ message.text }}</p>
      </div>

      <!-- Quick reply chips -->
      <div v-if="message.suggestions?.length" class="flex flex-wrap gap-1.5 mt-1">
        <button
          v-for="suggestion in message.suggestions"
          :key="suggestion"
          @click="$emit('select-suggestion', suggestion)"
          class="text-xs font-semibold text-teal-600 bg-teal-50 hover:bg-teal-100 border border-teal-200 rounded-full px-3 py-1.5 cursor-pointer transition-colors"
          style="font-family:'Sora',sans-serif;">
          {{ suggestion }}
        </button>
      </div>

      <!-- Timestamp -->
      <span v-if="!message.typing" class="text-[0.65rem] text-slate-400 px-1">
        {{ message.time }}
      </span>
    </div>

    <!-- User avatar -->
    <div v-if="!isBot"
      class="w-8 h-8 rounded-xl bg-slate-700 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
      {{ userInitials }}
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  message: {
    type: Object,
    required: true,
    // shape: { from: 'bot' | 'user', text: String, time: String, typing: Boolean, suggestions: Array }
  },
  userName: { type: String, default: 'You' },
})

defineEmits(['select-suggestion'])

const isBot = computed(() => props.message.from === 'bot')

const userInitials = computed(() =>
  props.userName.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2)
)
</script>