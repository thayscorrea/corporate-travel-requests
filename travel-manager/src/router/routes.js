import { createRouter, createWebHistory } from 'vue-router';
import Login from '@/components/Login.vue';
import DashboardView from '@/components/DashboardView.vue';
import CreateOrder from '@/components/CreateOrder.vue';
import UpdateStatus from '@/components/UpdateStatus.vue';

const routes = [
  { path: '/', name: 'Login', component: Login },
  { path: '/dashboard', name: 'DashboardView', component: DashboardView },
  { path: '/create-order', name: 'CreateOrder', component: CreateOrder },
  { path: '/update-status', name: 'UpdateStatus', component: UpdateStatus },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;