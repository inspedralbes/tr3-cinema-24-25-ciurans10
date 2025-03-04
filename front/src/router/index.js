import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import Cartelera from '../views/Cartelera.vue';
import DetallesPeli from '../views/DetallesPeli.vue';

const routes = [
  { path: '/', component: Home },
  { path: '/cartelera', component: Cartelera },
  { path: '/pelicula/:id', component: DetallesPeli }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
