<template>
  <div class="min-h-screen bg-slate-50">
    <Navbar />

    <div class="max-w-6xl mx-auto px-6 pt-16 pb-20">

      <!-- Header -->
      <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-slate-900 sm:text-5xl mb-4 mt-5 tracking-tight"
          style="font-family:'Plus Jakarta Sans',sans-serif;">
          Choose Your Plan
        </h1>
        <p class="text-lg text-slate-500 max-w-2xl mx-auto" style="font-family:'Sora',sans-serif;">
          Pick the plan that fits your needs. Upgrade or downgrade at any time.
        </p>
      </div>

      <!-- Progress Bar -->
      <ProgressBar :steps="steps" />

      <!-- Plan Cards -->
      <div class="flex justify-center gap-8 flex-wrap">
        <PricingPlan
          v-for="plan in plans"
          :key="plan.id"
          v-bind="plan"
          :selected="selectedPlanId === plan.id"
          @select="handleSelect"
        />
      </div>

      <!-- Footer info -->
      <div class="text-center mt-12 mb-4">
        <p class="text-slate-500 mb-2" style="font-family:'Sora',sans-serif;">
          All plans include a 14-day free trial. No credit card required.
        </p>
        <p class="text-sm text-slate-400" style="font-family:'Sora',sans-serif;">
          Questions?
          <a href="#" class="text-teal-600 hover:underline">Contact our sales team</a>
        </p>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import Navbar     from '@/Components/Navbar.vue'
import PricingPlan from '@/Components/PricingPlan.vue'
import ProgressBar from '@/Components/ProgressBar.vue'

const selectedPlanId = ref(null)

const steps = [
  { label: 'Account', done: true,  active: false },
  { label: 'Plan',    done: false, active: true  },
  { label: 'Payment', done: false, active: false },
]

const plans = [
  {
    id: 1,
    title: 'Starter',
    price: '$29',
    period: '/mo',
    description: 'Perfect for small agencies',
    features: [
      'Up to 10 vehicles',
      '1 agency location',
      'Basic booking management',
      'Client portal access',
      'Email support',
    ],
    buttonText: 'Select Starter',
    isPopular: false,
    planType: 'starter',
  },
  {
    id: 2,
    title: 'Professional',
    price: '$79',
    period: '/mo',
    description: 'For growing rental businesses',
    features: [
      'Up to 50 vehicles',
      '3 agency locations',
      'Advanced booking management',
      'Analytics dashboard',
      'Priority support',
      'Multi-location support',
      'Client CRM',
      'Automated reminders',
    ],
    buttonText: 'Select Professional',
    isPopular: true,
    planType: 'professional',
  },
  {
    id: 3,
    title: 'Enterprise',
    price: 'Contact us',
    period: '',
    description: 'For large-scale operations',
    features: [
      'Unlimited vehicles',
      'Unlimited locations',
      '24/7 dedicated support',
      'Custom branding',
      'API access',
      'SLA guarantee',
      'Dedicated account manager',
      'Custom contracts',
    ],
    buttonText: 'Contact Sales',
    isPopular: false,
    planType: 'enterprise',
  },
]

function handleSelect(selectedPlan) {
  selectedPlanId.value = selectedPlan.id
  router.get(route('agency.payment'), {
    plan:    selectedPlan.planType,
  })
}
</script>