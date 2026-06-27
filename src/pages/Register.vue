<template>
  <div class="min-h-screen bg-gray-50">
    <Navbar />

    <div class="flex min-h-screen pt-16">

      <!-- ── Panneau gauche ── -->
      <div
        class="relative hidden lg:flex flex-col justify-end w-1/2 flex-shrink-0 overflow-hidden px-14 pb-16 pt-14"
        style="background: linear-gradient(145deg, #f0fdfb 0%, #e0f7f4 40%, #c8f0eb 100%)"
      >
        <div class="pointer-events-none absolute -top-28 -right-28 w-[480px] h-[480px] rounded-full"
          style="background: radial-gradient(circle, rgba(27,168,154,.15) 0%, transparent 70%)"></div>
        <div class="pointer-events-none absolute -bottom-20 -left-20 w-80 h-80 rounded-full"
          style="background: radial-gradient(circle, rgba(27,168,154,.1) 0%, transparent 70%)"></div>
        <div class="pointer-events-none absolute inset-0 opacity-60"
          style="background-image: radial-gradient(circle, rgba(27,168,154,.18) 1px, transparent 1px); background-size: 28px 28px"></div>

        <div class="relative z-10">
          <!-- Badge -->
          <div class="inline-flex items-center gap-2 mb-5 px-4 py-1.5 rounded-full border text-[11px] font-semibold uppercase"
            style="background: rgba(27,168,154,.1); border-color: rgba(27,168,154,.25); color: #148a7e; letter-spacing: 1.8px">
            <span class="w-1.5 h-1.5 rounded-full bg-[#1BA89A] animate-pulse"></span>
            {{ role === 'agency' ? 'Espace Agence Partenaire' : 'Espace Client' }}
          </div>

          <!-- Titre -->
          <div class="font-extrabold leading-[1.1] tracking-tight text-gray-900 mb-4"
            style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(36px, 4vw, 52px)"
            v-html="headline">
          </div>

          <p class="text-[15px] leading-relaxed text-gray-500 max-w-sm mb-10">{{ desc }}</p>

          <!-- Stats -->
          <div class="grid grid-cols-3 gap-3 mb-8">
            <div v-for="s in stats" :key="s.val"
              class="bg-white rounded-[14px] px-3.5 py-4 shadow-sm"
              style="border: 1px solid rgba(27,168,154,.15)">
              <div class="text-[26px] font-extrabold text-[#1BA89A] leading-none mb-1"
                style="font-family: 'Plus Jakarta Sans', sans-serif">{{ s.val }}</div>
              <div class="text-[11px] font-medium text-gray-400 uppercase tracking-wide">{{ s.lbl }}</div>
            </div>
          </div>

          <!-- Pills -->
          <div class="flex flex-wrap gap-2">
            <div v-for="pill in pills" :key="pill"
              class="flex items-center gap-1.5 bg-white border border-gray-200 rounded-full px-3.5 py-1.5 text-[12.5px] font-medium text-gray-700 shadow-sm">
              <span class="text-[#1BA89A] font-bold">✓</span> {{ pill }}
            </div>
          </div>
        </div>
      </div>

      <!-- ── Panneau droit ── -->
      <div class="flex flex-1 items-start justify-center overflow-y-auto bg-white border-l border-gray-200 px-10 py-12 lg:px-10 md:px-6 sm:px-4">
        <div class="w-full max-w-[430px]" style="animation: slideIn .45s cubic-bezier(.4,0,.2,1) both">

          <!-- Onglets rôle -->
          <div class="grid grid-cols-2 gap-1 bg-gray-100 border border-gray-200 rounded-[14px] p-1 mb-5">
            <button
              v-for="tab in tabs" :key="tab.key"
              @click="switchRole(tab.key)"
              :class="[
                'flex items-center justify-center gap-2 py-[11px] px-3.5 rounded-[10px] text-[13.5px] font-medium cursor-pointer border-none transition-all duration-200',
                role === tab.key
                  ? 'bg-white text-gray-900 font-semibold shadow-sm'
                  : 'bg-transparent text-gray-400 hover:text-gray-600 hover:bg-white/50'
              ]"
              style="font-family: 'Outfit', sans-serif"
            >
              <span class="text-[15px]">{{ tab.icon }}</span> {{ tab.label }}
            </button>
          </div>

          <!-- Alerte -->
          <Transition name="fade-down">
            <div v-if="alert.show"
              :class="[
                'flex items-center gap-2 px-3.5 py-2.5 rounded-[10px] text-[13px] border mb-4',
                alert.type === 'success'
                  ? 'bg-emerald-50 border-emerald-200 text-emerald-800'
                  : 'bg-red-50 border-red-200 text-red-800'
              ]">
              {{ alert.message }}
            </div>
          </Transition>

          <!-- Titre formulaire -->
          <div class="text-[24px] font-extrabold text-gray-900 mb-1"
            style="font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -.4px">
            {{ role === 'agency' ? 'Devenir partenaire' : 'Créer un compte' }}
          </div>
          <div class="text-[13.5px] text-gray-400 mb-5 leading-relaxed">
            {{ role === 'agency'
              ? 'Intégrez notre réseau et développez votre activité.'
              : 'Rejoignez des milliers de clients satisfaits.' }}
          </div>

          <!-- ─ Champs ─ -->
          <Transition name="form-in" mode="out-in">
            <div :key="role" class="flex flex-col gap-3.5">

              <!-- CLIENT -->
              <template v-if="role === 'client'">
                <div class="grid grid-cols-2 gap-3.5">
                  <div class="flex flex-col gap-1.5">
                    <label class="text-[11px] font-semibold uppercase text-gray-400" style="letter-spacing:1.2px">Prénom</label>
                    <div class="relative flex items-center">
                      <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">✦</span>
                      <input type="text" placeholder="Amine" v-model="form.firstName"
                        :class="inputClass(errors.firstName)" style="font-family:'Outfit',sans-serif" />
                    </div>
                    <p v-if="errors.firstName" class="text-[11.5px] text-red-600 pl-0.5">{{ errors.firstName }}</p>
                  </div>
                  <div class="flex flex-col gap-1.5">
                    <label class="text-[11px] font-semibold uppercase text-gray-400" style="letter-spacing:1.2px">Nom</label>
                    <div class="relative flex items-center">
                      <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">✦</span>
                      <input type="text" placeholder="Tazi" v-model="form.lastName"
                        :class="inputClass(errors.lastName)" style="font-family:'Outfit',sans-serif" />
                    </div>
                    <p v-if="errors.lastName" class="text-[11.5px] text-red-600 pl-0.5">{{ errors.lastName }}</p>
                  </div>
                </div>

                <div class="flex flex-col gap-1.5">
                  <label class="text-[11px] font-semibold uppercase text-gray-400" style="letter-spacing:1.2px">Adresse email</label>
                  <div class="relative flex items-center">
                    <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">✉</span>
                    <input type="email" placeholder="amine@gmail.com" v-model="form.email"
                      :class="inputClass(errors.email)" style="font-family:'Outfit',sans-serif" />
                  </div>
                  <p v-if="errors.email" class="text-[11.5px] text-red-600 pl-0.5">{{ errors.email }}</p>
                </div>

                <div class="grid grid-cols-2 gap-3.5">
                  <div class="flex flex-col gap-1.5">
                    <label class="text-[11px] font-semibold uppercase text-gray-400" style="letter-spacing:1.2px">Téléphone</label>
                    <div class="relative flex items-center">
                      <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">📱</span>
                      <input type="text" placeholder="+212 6XX XXX" v-model="form.phone"
                        :class="inputClass(errors.phone)" style="font-family:'Outfit',sans-serif" />
                    </div>
                    <p v-if="errors.phone" class="text-[11.5px] text-red-600 pl-0.5">{{ errors.phone }}</p>
                  </div>
                  <div class="flex flex-col gap-1.5">
                    <label class="text-[11px] font-semibold uppercase text-gray-400" style="letter-spacing:1.2px">Ville</label>
                    <div class="relative flex items-center">
                      <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">📍</span>
                      <select v-model="form.city" :class="selectClass()" style="font-family:'Outfit',sans-serif">
                        <option value="">Choisir...</option>
                        <option v-for="c in CITIES" :key="c" :value="c">{{ c }}</option>
                      </select>
                    </div>
                  </div>
                </div>
              </template>

              <!-- AGENCY -->
              <template v-else>
                <div class="flex flex-col gap-1.5">
                  <label class="text-[11px] font-semibold uppercase text-gray-400" style="letter-spacing:1.2px">Nom de l'agence</label>
                  <div class="relative flex items-center">
                    <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">🏢</span>
                    <input type="text" placeholder="AutoLoc Maroc" v-model="form.agencyName"
                      :class="inputClass(errors.agencyName)" style="font-family:'Outfit',sans-serif" />
                  </div>
                  <p v-if="errors.agencyName" class="text-[11.5px] text-red-600 pl-0.5">{{ errors.agencyName }}</p>
                </div>

                <div class="grid grid-cols-2 gap-3.5">
                  <div class="flex flex-col gap-1.5">
                    <label class="text-[11px] font-semibold uppercase text-gray-400" style="letter-spacing:1.2px">N° Registre Commercial</label>
                    <div class="relative flex items-center">
                      <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">📋</span>
                      <input type="text" placeholder="RC-123456" v-model="form.regNumber"
                        :class="inputClass(errors.regNumber)" style="font-family:'Outfit',sans-serif" />
                    </div>
                    <p v-if="errors.regNumber" class="text-[11.5px] text-red-600 pl-0.5">{{ errors.regNumber }}</p>
                  </div>
                  <div class="flex flex-col gap-1.5">
                    <label class="text-[11px] font-semibold uppercase text-gray-400" style="letter-spacing:1.2px">Taille de la flotte</label>
                    <div class="relative flex items-center">
                      <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">🚘</span>
                      <input type="number" placeholder="ex: 12" v-model="form.fleetSize"
                        :class="inputClass(null)" style="font-family:'Outfit',sans-serif" />
                    </div>
                  </div>
                </div>

                <div class="flex flex-col gap-1.5">
                  <label class="text-[11px] font-semibold uppercase text-gray-400" style="letter-spacing:1.2px">Email professionnel</label>
                  <div class="relative flex items-center">
                    <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">✉</span>
                    <input type="email" placeholder="contact@agence.ma" v-model="form.email"
                      :class="inputClass(errors.email)" style="font-family:'Outfit',sans-serif" />
                  </div>
                  <p v-if="errors.email" class="text-[11.5px] text-red-600 pl-0.5">{{ errors.email }}</p>
                </div>

                <div class="grid grid-cols-2 gap-3.5">
                  <div class="flex flex-col gap-1.5">
                    <label class="text-[11px] font-semibold uppercase text-gray-400" style="letter-spacing:1.2px">Téléphone</label>
                    <div class="relative flex items-center">
                      <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">📱</span>
                      <input type="text" placeholder="+212 5XX XXX" v-model="form.phone"
                        :class="inputClass(null)" style="font-family:'Outfit',sans-serif" />
                    </div>
                  </div>
                  <div class="flex flex-col gap-1.5">
                    <label class="text-[11px] font-semibold uppercase text-gray-400" style="letter-spacing:1.2px">Ville principale</label>
                    <div class="relative flex items-center">
                      <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">📍</span>
                      <select v-model="form.city" :class="selectClass()" style="font-family:'Outfit',sans-serif">
                        <option value="">Choisir...</option>
                        <option v-for="c in CITIES" :key="c" :value="c">{{ c }}</option>
                      </select>
                    </div>
                  </div>
                </div>
              </template>

              <!-- Mot de passe (commun) -->
              <div class="flex flex-col gap-1.5">
                <label class="text-[11px] font-semibold uppercase text-gray-400" style="letter-spacing:1.2px">Mot de passe</label>
                <div class="relative flex items-center">
                  <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">🔒</span>
                  <input :type="showPass ? 'text' : 'password'" placeholder="Min. 6 caractères" v-model="form.password"
                    :class="inputClass(errors.password) + ' pr-10'" style="font-family:'Outfit',sans-serif" />
                  <button type="button" @click="showPass = !showPass"
                    class="absolute right-3 bg-transparent border-none text-gray-400 cursor-pointer text-sm p-0 hover:text-gray-700 transition-colors">
                    {{ showPass ? '🙈' : '👁' }}
                  </button>
                </div>
                <p v-if="errors.password" class="text-[11.5px] text-red-600 pl-0.5">{{ errors.password }}</p>
              </div>

              <div class="flex flex-col gap-1.5">
                <label class="text-[11px] font-semibold uppercase text-gray-400" style="letter-spacing:1.2px">Confirmer mot de passe</label>
                <div class="relative flex items-center">
                  <span class="absolute left-3 text-gray-400 text-sm pointer-events-none z-10">🔒</span>
                  <input :type="showPass ? 'text' : 'password'" placeholder="••••••••" v-model="form.confirm"
                    :class="inputClass(errors.confirm)" style="font-family:'Outfit',sans-serif" />
                </div>
                <p v-if="errors.confirm" class="text-[11.5px] text-red-600 pl-0.5">{{ errors.confirm }}</p>
              </div>

              <!-- Checkbox CGU -->
              <div class="flex flex-col gap-1">
                <div class="flex items-start gap-2.5 text-[12.5px] text-gray-500 leading-relaxed">
                  <input type="checkbox" id="terms" v-model="form.terms"
                    class="mt-0.5 flex-shrink-0 w-3.5 h-3.5 accent-[#1BA89A] cursor-pointer" />
                  <label for="terms">
                    J'accepte les
                    <a href="#" class="text-[#1BA89A] font-medium hover:underline">
                      {{ role === 'agency' ? 'conditions partenaire' : "conditions d'utilisation" }}
                    </a>
                    <template v-if="role === 'client'">
                      et la <a href="#" class="text-[#1BA89A] font-medium hover:underline">politique de confidentialité</a>
                    </template>
                    d'Atlas Drive.
                  </label>
                </div>
                <p v-if="errors.terms" class="text-[11.5px] text-red-600 pl-0.5">{{ errors.terms }}</p>
              </div>

            </div>
          </Transition>

          <!-- Bouton soumettre -->
          <button
            @click="handleSubmit"
            :disabled="loading"
            class="relative w-full mt-[18px] px-5 py-[13px] bg-[#1BA89A] hover:bg-[#148a7e] text-white rounded-[14px] text-[15px] font-bold flex items-center justify-center gap-2 overflow-hidden cursor-pointer border-none transition-all duration-200 active:scale-[.98] disabled:opacity-50 disabled:cursor-not-allowed disabled:pointer-events-none"
            style="font-family: 'Plus Jakarta Sans', sans-serif; box-shadow: 0 4px 16px rgba(27,168,154,.3)"
          >
            <span v-if="loading"
              class="w-4 h-4 flex-shrink-0 rounded-full animate-spin"
              style="border: 2.5px solid rgba(255,255,255,.3); border-top-color: #fff"></span>
            <span>{{ loading ? 'Inscription...' : '→ Créer mon compte' }}</span>
          </button>

          <!-- Lien connexion -->
          <div class="mt-[18px] text-center text-[13.5px] text-gray-400">
            Déjà un compte ?
            <router-link to="/login" class="text-[#1BA89A] font-semibold hover:underline no-underline">
              Se connecter
            </router-link>
          </div>

          <!-- Trust badges -->
          <div class="flex justify-center flex-wrap gap-5 mt-6 pt-5 border-t border-gray-100">
            <div v-for="badge in trustBadges" :key="badge"
              class="flex items-center gap-1.5 text-[11.5px] text-gray-300">
              {{ badge }}
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import NavBar from '../components/Navbar.vue'

const role     = ref('client')
const showPass = ref(false)
const loading  = ref(false)

const CITIES = ['Casablanca','Rabat','Marrakech','Fès','Tanger','Agadir','Meknès','Oujda','Tétouan','El Jadida','Kenitra','Laâyoune']

const form = reactive({
  email: '', password: '', confirm: '',
  firstName: '', lastName: '', phone: '', city: '',
  agencyName: '', regNumber: '', fleetSize: '',
  terms: false
})
const errors = reactive({})
const alert  = reactive({ show: false, type: '', message: '' })

const tabs = [
  { key: 'client', icon: '👤', label: 'Client' },
  { key: 'agency', icon: '🏢', label: 'Agence' },
]
const stats = [
  { val: '500+', lbl: 'Véhicules' },
  { val: '50+',  lbl: 'Agences'   },
  { val: '15',   lbl: 'Villes'    },
]
const CLIENT_PILLS = ['Réservation instantanée', 'Sans frais cachés', 'Annulation flexible', 'Assurance incluse']
const AGENCY_PILLS = ['Tableau de bord avancé', 'Tracking GPS', 'Gestion des réservations', 'Paiements automatisés']
const trustBadges  = ['🔒 SSL sécurisé', '🛡 Données protégées', '📍 Maroc & International']

const headline = computed(() =>
  role.value === 'client'
    ? 'Votre route,<br><span style="color:#1BA89A">vos règles.</span>'
    : 'Développez<br><span style="color:#1BA89A">votre flotte.</span>'
)
const desc = computed(() =>
  role.value === 'client'
    ? "Accédez à plus de 500 véhicules dans toutes les grandes villes du Maroc."
    : "Rejoignez notre réseau d'agences partenaires et atteignez des milliers de clients."
)
const pills = computed(() => role.value === 'client' ? CLIENT_PILLS : AGENCY_PILLS)

// Classes utilitaires partagées
function inputClass(error) {
  const base = 'w-full pl-9 pr-3 py-2.5 rounded-[10px] text-[14px] text-gray-900 outline-none transition-all duration-200'
  return error
    ? `${base} border-[1.5px] border-red-500 bg-red-50 focus:ring-2 focus:ring-red-200`
    : `${base} border-[1.5px] border-gray-200 bg-gray-50 focus:border-[#1BA89A] focus:bg-white focus:ring-2 focus:ring-[#1BA89A]/10`
}
function selectClass() {
  return 'w-full pl-9 pr-3 py-2.5 rounded-[10px] text-[14px] text-gray-900 outline-none transition-all duration-200 border-[1.5px] border-gray-200 bg-gray-50 focus:border-[#1BA89A] focus:bg-white focus:ring-2 focus:ring-[#1BA89A]/10 appearance-none cursor-pointer'
}

function switchRole(r) {
  role.value = r
  Object.keys(errors).forEach(k => delete errors[k])
  alert.show = false
  Object.keys(form).forEach(k => { form[k] = k === 'terms' ? false : '' })
}

const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]+$/

function validate() {
  Object.keys(errors).forEach(k => delete errors[k])
  let ok = true
  if (!form.email)                     { errors.email    = 'Email requis.';          ok = false }
  else if (!EMAIL_RE.test(form.email)) { errors.email    = 'Email invalide.';        ok = false }
  if (!form.password)                  { errors.password = 'Mot de passe requis.';   ok = false }
  else if (form.password.length < 6)   { errors.password = 'Minimum 6 caractères.'; ok = false }
  if (form.password !== form.confirm)  { errors.confirm  = 'Les mots de passe ne correspondent pas.'; ok = false }
  if (!form.terms)                     { errors.terms    = 'Vous devez accepter les conditions.';     ok = false }
  if (role.value === 'client') {
    if (!form.firstName) { errors.firstName = 'Prénom requis.';    ok = false }
    if (!form.lastName)  { errors.lastName  = 'Nom requis.';       ok = false }
    if (!form.phone)     { errors.phone     = 'Téléphone requis.'; ok = false }
  } else {
    if (!form.agencyName) { errors.agencyName = "Nom d'agence requis."; ok = false }
    if (!form.regNumber)  { errors.regNumber  = 'N° RC requis.';        ok = false }
  }
  return ok
}

function showAlertMsg(type, message) {
  alert.show = true; alert.type = type; alert.message = message
  setTimeout(() => { alert.show = false }, 5000)
}

async function handleSubmit() {
  if (!validate()) return
  loading.value = true
  try {
    const res  = await fetch('/api/register', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ ...form, role: role.value })
    })
    const data = await res.json()
    if (data.success) showAlertMsg('success', `✅ ${data.message}`)
    else              showAlertMsg('danger',  `❌ ${data.message}`)
  } catch {
    showAlertMsg('danger', '❌ Erreur de connexion au serveur.')
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
@keyframes slideIn {
  from { opacity: 0; transform: translateX(16px); }
  to   { opacity: 1; transform: translateX(0); }
}
@keyframes fadeDown {
  from { opacity: 0; transform: translateY(-6px); }
  to   { opacity: 1; }
}
@keyframes formIn {
  from { opacity: 0; transform: translateY(10px); }
  to   { opacity: 1; transform: translateY(0); }
}
.fade-down-enter-active  { animation: fadeDown .3s ease; }
.fade-down-leave-active  { transition: opacity .2s; }
.fade-down-leave-to      { opacity: 0; }
.form-in-enter-active    { animation: formIn .3s cubic-bezier(.4,0,.2,1); }
.form-in-leave-active    { transition: opacity .15s; }
.form-in-leave-to        { opacity: 0; }
</style>

