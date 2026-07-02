<template>
  <div class="fixed bottom-6 right-6 z-50" style="font-family:'Sora',sans-serif;">

    <!-- ── Chat Panel ── -->
    <Transition name="chat-pop">
      <div v-if="isOpen"
        class="absolute bottom-16 right-0 w-[360px] h-[520px] bg-white rounded-2xl shadow-2xl border border-slate-200 flex flex-col overflow-hidden">

        <!-- Header -->
        <div class="flex items-center justify-between px-5 py-4 flex-shrink-0"
          style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);">
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <rect x="3" y="11" width="18" height="10" rx="2"/>
                <circle cx="12" cy="5" r="2"/>
                <path d="M12 7v4"/>
              </svg>
            </div>
            <div>
              <p class="text-sm font-bold text-white leading-none">Atlas Drive Assistant</p>
              <p class="text-xs text-teal-100 mt-1 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                Online
              </p>
            </div>
          </div>
          <button @click="isOpen = false"
            class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 border-none cursor-pointer transition-colors">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
              <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
          </button>
        </div>

        <!-- Messages -->
        <div ref="messagesRef" class="flex-1 overflow-y-auto px-4 py-4 bg-slate-50">
          <ChatMessage
            v-for="(msg, i) in messages"
            :key="i"
            :message="msg"
            :user-name="userName"
            @select-suggestion="handleSuggestion"
          />
        </div>

        <!-- Input -->
        <ChatInput :disabled="isTyping" @send="handleSend" />
      </div>
    </Transition>

    <!-- ── Floating bubble button ── -->
    <button
      @click="toggleChat"
      class="w-14 h-14 rounded-full flex items-center justify-center border-none cursor-pointer shadow-lg hover:shadow-xl transition-all duration-200 hover:scale-105 relative"
      style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);">

      <Transition name="icon-fade" mode="out-in">
        <svg v-if="!isOpen" key="chat" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
          <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
        </svg>
        <svg v-else key="close" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </Transition>

      <!-- Unread badge -->
      <span v-if="unreadCount > 0 && !isOpen"
        class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-[0.65rem] font-bold rounded-full flex items-center justify-center">
        {{ unreadCount }}
      </span>
    </button>
  </div>
</template>

<script setup>
import { ref, nextTick, watch } from 'vue'
import { usePage } from '@inertiajs/vue3'
import ChatMessage from '@/Components/ChatBot/Chatmessage.vue'
import ChatInput from '@/Components/ChatBot/Chatinput.vue'
import { sendMessage } from "@/api/chatbot";
const page = usePage()
const userName = page.props.auth?.user
  ? `${page.props.auth.user.prenom ?? ''} ${page.props.auth.user.nom ?? ''}`.trim()
  : 'Guest'

const isOpen      = ref(false)
const isTyping    = ref(false)
const unreadCount = ref(0)
const messagesRef = ref(null)

const messages = ref([
  {
    from: 'bot',
    text: `Hi${userName !== 'Guest' ? ' ' + userName.split(' ')[0] : ''}! 👋 I'm the Atlas Drive assistant. How can I help you today?`,
    time: formatTime(),
    suggestions: ['Find a car', 'Track my booking', 'Pricing plans', 'Contact support'],
  },
])

function formatTime() {
  return new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })
}

function toggleChat() {
  isOpen.value = !isOpen.value
  if (isOpen.value) unreadCount.value = 0
}

function scrollToBottom() {
  nextTick(() => {
    if (messagesRef.value) {
      messagesRef.value.scrollTop = messagesRef.value.scrollHeight
    }
  })
}

function handleSuggestion(text) {
  handleSend(text)
}

async function handleSend(text) {
  messages.value.push({ from: 'user', text, time: formatTime() })
  scrollToBottom()

  isTyping.value = true
  messages.value.push({ from: 'bot', typing: true })
  scrollToBottom()

  try {
const response = await sendMessage(text)

console.log("Response:", response)
    messages.value.pop() // remove typing indicator
    messages.value.push({
    from: "bot",
    text: response.response,
    time: formatTime(),
})
  } catch (e) {
    messages.value.pop()
    messages.value.push({
      from: 'bot',
      text: "Sorry, I couldn't process that. Please try again or contact support.",
      time: formatTime(),
    })
  } finally {
    isTyping.value = false
    scrollToBottom()
    if (!isOpen.value) unreadCount.value++
  }
}



watch(isOpen, (open) => {
  if (open) scrollToBottom()
})
</script>

<style scoped>
.chat-pop-enter-active { animation: chatPop .25s cubic-bezier(.34,1.56,.64,1); }
.chat-pop-leave-active { transition: opacity .15s, transform .15s; }
.chat-pop-leave-to     { opacity: 0; transform: scale(.92) translateY(8px); }
@keyframes chatPop {
  from { opacity: 0; transform: scale(.92) translateY(8px); }
  to   { opacity: 1; transform: scale(1) translateY(0); }
}
.icon-fade-enter-active, .icon-fade-leave-active { transition: opacity .15s, transform .15s; }
.icon-fade-enter-from, .icon-fade-leave-to { opacity: 0; transform: rotate(-45deg); }
</style>