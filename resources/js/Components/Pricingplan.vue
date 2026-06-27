<template>
  <div
    @click="$emit('select', { id, planType, title, price, period })"
    :class="[
      'relative flex flex-col bg-white rounded-2xl p-7 cursor-pointer transition-all duration-200 border-2 w-72',
      selected
        ? 'border-teal-500 shadow-xl shadow-teal-100 scale-[1.03]'
        : isPopular
          ? 'border-teal-200 shadow-md hover:border-teal-400 hover:-translate-y-1 hover:shadow-lg'
          : 'border-slate-200 shadow-sm hover:border-teal-300 hover:-translate-y-1 hover:shadow-md'
    ]"
  >
    <!-- Popular badge -->
    <div v-if="isPopular"
      class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-teal-600 text-white text-[0.7rem] font-bold px-4 py-1 rounded-full whitespace-nowrap"
      style="font-family:'Sora',sans-serif;">
      ⭐ Most Popular
    </div>

    <!-- Selected checkmark -->
    <Transition name="pop">
      <div v-if="selected"
        class="absolute top-4 right-4 w-6 h-6 rounded-full bg-teal-600 flex items-center justify-center shadow-md">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3">
          <polyline points="20 6 9 17 4 12"/>
        </svg>
      </div>
    </Transition>

    <!-- Title -->
    <div class="mb-5">
      <h3 class="text-xl font-extrabold text-slate-900 mb-1" style="font-family:'Plus Jakarta Sans',sans-serif;">
        {{ title }}
      </h3>
      <p class="text-sm text-slate-500" style="font-family:'Sora',sans-serif;">{{ description }}</p>
    </div>

    <!-- Price -->
    <div class="mb-6">
      <div class="flex items-end gap-1">
        <span class="text-4xl font-extrabold text-slate-900" style="font-family:'Plus Jakarta Sans',sans-serif;">
          {{ price }}
        </span>
        <span v-if="period" class="text-sm text-slate-400 mb-1.5" style="font-family:'Sora',sans-serif;">
          {{ period }}
        </span>
      </div>
    </div>

    <!-- Features -->
    <ul class="flex flex-col gap-2.5 mb-8 flex-1">
      <li v-for="feature in features" :key="feature" class="flex items-center gap-2.5">
        <span class="w-4 h-4 rounded-full bg-teal-100 text-teal-600 flex items-center justify-center flex-shrink-0">
          <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5">
            <polyline points="20 6 9 17 4 12"/>
          </svg>
        </span>
        <span class="text-sm text-slate-600" style="font-family:'Sora',sans-serif;">{{ feature }}</span>
      </li>
    </ul>

    <!-- Button -->
    <button
      :class="[
        'w-full py-3 rounded-xl text-sm font-bold border-none cursor-pointer transition-all duration-150 mt-auto',
        selected
          ? 'bg-teal-600 text-white shadow-md'
          : isPopular
            ? 'bg-teal-600 hover:bg-teal-700 text-white'
            : 'bg-slate-100 hover:bg-slate-200 text-slate-700'
      ]"
      style="font-family:'Sora',sans-serif;">
      {{ selected ? '✓ Selected' : buttonText }}
    </button>
  </div>
</template>

<script setup>
defineProps({
  id:          { type: Number,  required: true },
  title:       { type: String,  required: true },
  price:       { type: String,  required: true },
  period:      { type: String,  default:  ''   },
  description: { type: String,  required: true },
  features:    { type: Array,   required: true },
  buttonText:  { type: String,  required: true },
  isPopular:   { type: Boolean, default:  false },
  planType:    { type: String,  required: true },
  selected:    { type: Boolean, default:  false },
})

defineEmits(['select'])
</script>

<style scoped>
.pop-enter-active { animation: pop .25s cubic-bezier(.4,0,.2,1); }
.pop-leave-active { transition: opacity .15s, transform .15s; }
.pop-leave-to     { opacity: 0; transform: scale(.7); }
@keyframes pop {
  from { opacity: 0; transform: scale(.5); }
  to   { opacity: 1; transform: scale(1);  }
}
</style>