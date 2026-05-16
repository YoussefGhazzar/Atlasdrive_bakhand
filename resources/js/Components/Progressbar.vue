<template>
  <div class="flex items-center justify-center mb-14">
    <div v-for="(step, i) in steps" :key="i" class="flex items-center">
      <!-- Step circle + label -->
      <div class="flex flex-col items-center gap-1.5">
        <div :class="[
          'w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300 border-2',
          step.done
            ? 'bg-teal-600 border-teal-600 text-white'
            : step.active
              ? 'bg-white border-teal-500 text-teal-600'
              : 'bg-white border-slate-200 text-slate-400'
        ]" style="font-family:'Sora',sans-serif;">
          <svg v-if="step.done" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
            <polyline points="20 6 9 17 4 12"/>
          </svg>
          <span v-else>{{ i + 1 }}</span>
        </div>
        <span :class="[
          'text-[11px] font-semibold whitespace-nowrap',
          step.active ? 'text-teal-600' : step.done ? 'text-slate-600' : 'text-slate-400'
        ]" style="font-family:'Sora',sans-serif;">
          {{ step.label }}
        </span>
      </div>

      <!-- Connector line -->
      <div v-if="i < steps.length - 1"
        :class="['w-24 h-0.5 mx-3 mb-5 rounded-full transition-colors duration-500', step.done ? 'bg-teal-500' : 'bg-slate-200']">
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  steps: {
    type: Array,
    default: () => [
      { label: 'Account', done: true,  active: false },
      { label: 'Plan',    done: false, active: true  },
      { label: 'Payment', done: false, active: false },
    ],
  },
})
</script>