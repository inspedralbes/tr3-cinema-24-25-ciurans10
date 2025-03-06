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
          <li><router-link to="/sessions">Sesiones</router-link></li>
          <li><router-link to="/login" class="login-button">Inicia Sesió</router-link></li>
        </ul>
      </nav>
    </header>

    <main>
      <router-view></router-view>
    </main>

    <footer v-if="!isLoginPage && !isRegisterPage && !isButacasPage">
      <div class="footer-content">
        <div class="seleccionadas-info-footer">
          <p>Butaques seleccionades: {{ selectedSeats.length }} / 10</p>
          <button
            :disabled="selectedSeats.length === 0"
            @click="confirmSelection"
          >
            Confirmar selecció
          </button>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
import { computed, ref } from "vue";
import { useRoute } from "vue-router";

export default {
  setup() {
    const route = useRoute();

    const selectedSeats = ref([]);

    const isLoginPage = computed(() => route.path === "/login");
    const isRegisterPage = computed(() => route.path === "/register");
    const isButacasPage = computed(() => route.path === "/butacas");

    function selectSeat(butaca) {
      if (selectedSeats.value.includes(butaca)) {
        selectedSeats.value = selectedSeats.value.filter(seat => seat !== butaca);
      } else {
        if (selectedSeats.value.length < 10) {
          selectedSeats.value.push(butaca);
        }
      }
    }

    function confirmSelection() {
      alert(`Butaques seleccionades: ${selectedSeats.value.join(', ')}`);
    }

    return {
      isLoginPage,
      isRegisterPage,
      isButacasPage,
      selectedSeats,
      selectSeat,
      confirmSelection
    };
  }
};
</script>

<style>
#app {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
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
  background-color: #222;
  color: #fff;
  padding: 40px 0;
  margin-top: 20px;
  
}

footer .footer-content {
  display: flex;
  flex-direction: column;
  align-items: center;
}

footer p {
  margin: 10px 0;
  font-size: 20px;
  font-weight: bold;
  color: #ffcc00;
}

footer .seleccionadas-info-footer {
  text-align: center;
}

footer button {
  background-color: #ffcc00;
  padding: 15px 30px;
  border-radius: 8px;
  color: black;
  font-size: 18px;
  font-weight: bold;
  border: none;
  cursor: pointer;
  transition: background 0.3s ease, transform 0.2s ease;
}

footer button:hover {
  background-color: #ffdb4d;
  transform: scale(1.05);
}

footer button:disabled {
  background-color: #cccccc;
  cursor: not-allowed;
}
</style>
