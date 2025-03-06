<template>
  <div id="app">
    <header v-if="!isLoginPage && !isRegisterPage && !isButacasPage">
      <nav>
        <ul>
          <li><router-link to="/">Inicio</router-link></li>
          <li><router-link to="/cartelera">Cartelera</router-link></li>
          <li><router-link to="/sessions">Sessions</router-link></li>
          <li><router-link to="/login">Inicia Sesión</router-link></li>
          <li><router-link to="/register">Regístrate</router-link></li>
        </ul>
      </nav>
    </header>

    <main>
      <router-view></router-view>
    </main>

    <footer v-if="!isLoginPage && !isRegisterPage && !isButacasPage">
      <p>&copy; 2025 Mi Cine. Todos los derechos reservados.</p>
    </footer>
  </div>
</template>

<script>
import { computed } from "vue";
import { useRoute } from "vue-router";

export default {
  setup() {
    const route = useRoute();

    const isLoginPage = computed(() => route.path === "/login");

    const isRegisterPage = computed(() => route.path === "/register");
    const isButacasPage = computed(() => route.path === "/butacas");

    return { isLoginPage, isRegisterPage, isButacasPage};
  }
};
</script>

<style>

html, body {
  margin: 0;
  padding: 0;
  height: 100%;
  width: 100%;
  box-sizing: border-box;
}

#app {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  margin: 0; 
}

header {
  background-color: #333;
  color: white;
  padding: 10px 0;
  text-align: center;
}

header nav ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

header nav ul li {
  display: inline-block;
  margin: 0 20px;
}

header nav ul li a {
  text-decoration: none;
  color: white;
  font-size: 18px;
}

header nav ul li a:hover {
  text-decoration: underline;
}

main {
  flex-grow: 1;
  padding: 20px;
}

footer {
  background-color: #333;
  color: white;
  text-align: center;
  padding: 10px;
}
</style>
