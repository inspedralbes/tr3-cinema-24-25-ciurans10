<template>
  <div class="w-screen h-screen flex items-center justify-center bg-gray-900 bg-cover login-background">
    <div class="login-container">
      <h2 class="login-title">Iniciar sesión</h2>
      <input v-model="email" type="email" placeholder="Correo" class="login-input">
      <input v-model="password" type="password" placeholder="Contraseña" class="login-input">
      <button @click="login" class="login-button">Entrar</button>

      <p class="register-link">¿No tienes una cuenta? <span @click="goToRegister" class="text-yellow-500 cursor-pointer">Regístrate aquí</span></p>
    </div>
  </div>
</template>

<script>
import { useRouter } from 'vue-router'; 

export default {
  setup() {
    const router = useRouter(); 

    return { router };
  },
  data() {
    return { email: '', password: '' };
  },
  methods: {
    async login() {
      try {
        const res = await fetch('http://localhost:8000/api/login', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ email: this.email, password: this.password })
        });

        if (!res.ok) {
          throw new Error('Error en la autenticación');
        }

        const data = await res.json();
        localStorage.setItem('token', data.token);

        this.$router.push('/'); 
      } catch (error) {
        alert(error.message);
      }
    },
    
    goToRegister() {
      this.$router.push('/register');
    }
  }
}
</script>

<style scoped>
.login-container {
  margin-top: 100px;
  background: rgba(255, 255, 255, 0.9);
  padding: 2rem;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
  border: 2px solid #FFD700;
  width: 400px;
  text-align: center;
}

.login-title {
  font-size: 2rem;
  font-weight: bold;
  color: #FFD700;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
  margin-bottom: 1rem;
}

.login-input {
  width: 100%;
  padding: 12px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 1rem;
  transition: all 0.3s ease-in-out;
}

.login-input:focus {
  outline: none;
  border-color: #FFD700;
  box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
}

.login-button {
  width: 100%;
  padding: 12px;
  background: #FFD700;
  color: #000;
  font-weight: bold;
  border: none;
  border-radius: 8px;
  font-size: 1.2rem;
  cursor: pointer;
  transition: all 0.3s ease-in-out;
}

.login-button:hover {
  background: #FFC107;
  transform: scale(1.05);
}

.register-link {
  margin-top: 10px;
  font-size: 1rem;
  
}

.register-link span {
  text-decoration: underline;
  font-weight: bold;
  cursor: pointer;
}
</style>
