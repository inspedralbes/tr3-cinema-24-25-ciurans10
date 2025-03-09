import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import Cartelera from '../views/Cartelera.vue';
import DetallesPeli from '../views/DetallesPeli.vue';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import Butacas from '../views/Butacas.vue';
import Sessions from '../views/Sessions.vue';
import Entradas from '../views/Entradas.vue';

const routes = [
  { path: '/', component: Home },
  { path: '/cartelera', component: Cartelera },
  { path: '/pelicula/:id', component: DetallesPeli },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/butacas', component: Butacas },
  {
    path: '/butacas/:movieId/:sessionTime/:selectedDate',
    name: 'Butacas',
    component: Butacas,
    props: true 
  },
  { path: '/sessions', component: Sessions },
  { path: '/entradas', component: Entradas }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
