import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import Cartelera from '../views/Cartelera.vue';
import DetallesPeli from '../views/DetallesPeli.vue';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import Butacas from '../views/Butacas.vue';
import Sessions from '../views/Sessions.vue';
import Perfil from '../views/Perfil.vue';

const routes = [
  { path: '/', component: Home },
  { path: '/cartelera', component: Cartelera },
  { 
    path: '/pelicula/:movieId/:title/:posterPath/:selectedDate?', 
    name: 'DetallesPeli', 
    component: DetallesPeli,
    props: route => ({
      movieId: route.params.movieId,
      title: decodeURIComponent(route.params.title), 
      posterPath: decodeURIComponent(route.params.posterPath),  
      selectedDate: route.params.selectedDate,
    })
  },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/butacas', component: Butacas },
  {
    path: '/butacas/:movieId/:title/:sessionTime/:selectedDate',
    name: 'Butacas',
    component: Butacas,
    props: true 
  },
  { path: '/sessions', component: Sessions },
  { path: '/perfil', component: Perfil },
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
