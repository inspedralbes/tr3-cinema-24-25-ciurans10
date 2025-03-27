<template>
  <div class="w-screen h-screen flex items-center justify-center bg-gray-900 bg-cover login-background">
    <div class="login-container">
      <h2 class="login-title">🎬 Registre</h2>
      <input v-model="name" type="text" placeholder="Nom" class="login-input" :class="{'input-error': nameError}" @input="validateName(name)">
      <input v-model="email" type="email" placeholder="Correu" class="login-input" :class="{'input-error': emailError}" @input="validateEmail(email)">
      <input v-model="password" type="password" placeholder="Contrasenya" class="login-input" :class="{'input-error': passwordError}" @input="validatePassword(password)">
      <input v-model="confirmPassword" type="password" placeholder="Confirmar Contrasenya" class="login-input" :class="{'input-error': confirmPasswordError}" @input="validateConfirmPassword(confirmPassword)">
      
      <p v-if="nameError" class="error-message">El nom és obligatori.</p>
      <p v-if="emailError" class="error-message">Si us plau, introdueix un correu vàlid.</p>
      <p v-if="confirmPasswordError" class="error-message">Les contrasenyes no coincideixen.</p>

      <button @click="register" class="login-button" :disabled="hasErrors">🎟️ Registrar-se</button>

      <p class="login-link">Ja tens un compte? <span @click="goToLogin" class="text-yellow-500 cursor-pointer">Inicia sessió aquí</span></p>
    </div>
  </div>
</template>

<script>
import { communicationManager } from '@/services/CommunicationManager';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      confirmPassword: '',
      nameError: false,
      emailError: false,
      passwordError: false,
      confirmPasswordError: false
    };
  },
  computed: {
    hasErrors() {
      return this.nameError || this.emailError || this.passwordError || this.confirmPasswordError;
    }
  },
  methods: {
    validateName(name) {
      this.nameError = !name.trim(); 
    },

    validateEmail(email) {
      const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      this.emailError = !emailPattern.test(email); 
    },

    validatePassword(password) {
      this.passwordError = password.length < 6; 
    },

    validateConfirmPassword(confirmPassword) {
      this.confirmPasswordError = confirmPassword !== this.password;
    },

    async register() {
      
      this.validateName(this.name);
      this.validateEmail(this.email);
      this.validatePassword(this.password);
      this.validateConfirmPassword(this.confirmPassword);

      if (this.hasErrors) {
        return;
      }

      try {
        const data = await communicationManager.post('/register', {
          name: this.name,
          email: this.email,
          password: this.password
        });

        localStorage.setItem('token', data.token);
        this.$router.push('/');
      } catch (error) {
        alert(error.message || 'Error en el registre');
      }
    },

    goToLogin() {
      this.$router.push('/login');
    }
  }
}
</script>

<style scoped>
.login-container {
  margin-top: 80px;
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
  width: 93%;
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

.input-error {
  border-color: red;
  box-shadow: 0 0 10px rgba(255, 0, 0, 0.5);
}

.error-message {
  color: red;
  font-size: 0.9rem;
  margin-top: 5px;
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

.login-button:disabled {
  background: #ccc;
  cursor: not-allowed;
}

.login-link {
  margin-top: 10px;
  font-size: 1rem;
}

.login-link span {
  text-decoration: underline;
  font-weight: bold;
  cursor: pointer;
}

@media (max-width: 450px) {
  .login-container {
    width: 90%;
    padding: 1.5rem;
  }
  .login-title {
    font-size: 1.5rem;
  }
  .login-input {
    font-size: 0.9rem;
    padding: 10px;
  }
  .login-button {
    font-size: 1rem;
    padding: 10px;
  }
}
</style>
