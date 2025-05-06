import CreateEmployee from '@/components/employee/CreateEmployee.vue'
import EditEmployee from '@/components/employee/EditEmployee.vue'
import About from '@/views/About.vue'
import EmployeeView from '@/views/employee/EmployeeView.vue'
import ShowEmployee from '@/views/employee/ShowEmployee.vue'
import HomeView from '@/views/HomeView.vue'
import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
      {
        path: '/',
        name: 'home',
        component: HomeView
      },
      {
        path: '/about',
        name: 'about',
        component: About
      },
      {
        path: '/employee',
        name: 'employee',
        component: EmployeeView
      },
      {
        path: '/employee/create',
        name: 'create employee',
        component: CreateEmployee
      },
      {
        path: '/employee/:id',
        name: 'show employee',
        component: ShowEmployee
      },
      {
        path:'/employee/edit/:id',
        name: 'employee edit',
        component: EditEmployee
      }
  ],
})

export default router
