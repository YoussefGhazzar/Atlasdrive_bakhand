import { createRouter, createWebHashHistory } from 'vue-router'

import home            from '../pages/home.vue'
import Agencies        from '../pages/Agencies.vue'
import Fleet           from '../pages/Fleet.vue'
import AgencyDashboard from '../pages/AgencyDashboard.vue'
import ClientDashboard from '../pages/ClientDashboard.vue'
import AdminDashboard  from '../pages/AdminDashboard.vue'

const routes = [
  { path: '/',                 name: 'Home',            component: home            },
  { path: '/fleet',            name: 'Fleet',           component: Fleet           },
  { path: '/agencies',         name: 'Agencies',        component: Agencies        },
  { path: '/dashboard/client', name: 'ClientDashboard', component: ClientDashboard },
  { path: '/dashboard/agency', name: 'AgencyDashboard', component: AgencyDashboard },
  { path: '/dashboard/admin',  name: 'AdminDashboard',  component: AdminDashboard  },

  // Catch-all 404
  { path: '/:pathMatch(.*)*',  redirect: '/' },
]



const router = createRouter({
  history: createWebHashHistory(),
  routes,
  scrollBehavior() {
    return { top: 0 }
  },
})

export default router