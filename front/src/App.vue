<template>
  <div id="app">
    <header v-if="!isLoginPage && !isRegisterPage && !isButacasPage">
      <nav>
        <div class="logo-container">
          <router-link to="/" class="logo">Mi Cine</router-link>
        </div>
        <ul>
          <li><router-link to="/">Inici</router-link></li>
          <li><router-link to="/cartelera">Películas</router-link></li>
          <li><router-link to="/sessions">Sessions</router-link></li>

          <li v-if="!isAuthenticated"><router-link to="/login" class="login-button">Inicia Sesió</router-link></li>

          <li v-if="isAuthenticated"><router-link to="/perfil" class="profile-button">Perfil</router-link></li>
        </ul>
      </nav>
    </header>

    <main>
      <router-view></router-view>
    </main>

    <footer v-if="!isLoginPage && !isRegisterPage && !isButacasPage">
      <div class="footer-container">
        <div class="footer-content">
          <p>&copy; 2025 Mi Cine. Todos los derechos reservados.</p>
          <nav class="footer-links">
            <router-link to="/about">Sobre nosotros</router-link>
            <router-link to="/contact">Contacto</router-link>
            <router-link to="/terms">Términos y condiciones</router-link>
          </nav>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
import { computed } from "vue";
import { useRoute } from "vue-router";

export default {
  setup() {
    const route = useRoute();

    // Computado para verificar si estamos en la página de login
    const isLoginPage = computed(() => route.path === "/login");
    const isRegisterPage = computed(() => route.path === "/register");
    const isButacasPage = computed(() => route.path === "/butacas");

    // Computado para verificar si el usuario está autenticado
    const isAuthenticated = computed(() => {
      return localStorage.getItem('token') !== null;
    });

    return {
      isLoginPage,
      isRegisterPage,
      isButacasPage,
      isAuthenticated
    };
  }
};
</script>

<style>
#app {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  background-color: #1c2b36;
}

header {
  background: linear-gradient(135deg, #4b79a1, #283e51);
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
  padding: 20px 0;
}

header nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1200px;
  margin: auto;
  padding: 0 20px;
}

header .logo-container {
  font-size: 1.5rem;
  font-weight: 700;
  color: #fff;
}

header .logo {
  text-decoration: none;
  color: #fff;
  transition: color 0.3s ease;
}

header .logo:hover {
  color: #ffcc00;
}

header nav ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
  display: flex;
}

header nav ul li {
  margin: 0 15px;
}

header nav ul li a {
  text-decoration: none;
  color: #fff;
  font-size: 18px;
  font-weight: 600;
  transition: color 0.3s ease;
}

header nav ul li a:hover {
  color: #ffcc00;
}

.login-button {
  background-color: #ffcc00;
  padding: 8px 15px;
  border-radius: 5px;
  color: black !important;
  transition: background 0.3s ease;
}

.login-button:hover {
  background-color: #ffdb4d;
}

main {
  flex-grow: 1;
  padding: 0px;
  max-width: 1100px;
  margin: auto;
  text-align: center;
}

footer {
  background: linear-gradient(135deg, #4b79a1, #283e51);
  color: #fff;
  padding: 20px 0;
  text-align: center;
  margin-top: 20px;
}

.footer-container {
  max-width: 1200px;
  margin: auto;
  padding: 0 20px;
}

.footer-content p {
  margin: 10px 0;
  font-size: 16px;
}

.footer-links {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin-top: 10px;
}

.footer-links a {
  text-decoration: none;
  color: #ffcc00;
  font-size: 14px;
  transition: color 0.3s ease;
}

.footer-links a:hover {
  color: #ffdb4d;
}
</style>
