<template>
    <div class="profile-container">
      <div class="profile-header">
        <h2>Bienvenido a tu perfil</h2>
      </div>
  
      <div class="profile-info">
        <p><strong>Correo Electrónico:</strong> {{ user.email }}</p>
        <p><strong>Nombre de Usuario:</strong> {{ user.username || 'No disponible' }}</p>
      </div>
  
      <div class="profile-actions">
        <button @click="logout" class="logout-button">Cerrar sesión</button>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from "vue";
  import { useRouter } from "vue-router";
  
  export default {
    setup() {
      const router = useRouter();
      const user = ref({
        email: '',
        username: ''
      });
  
      // Cargar la información del usuario (esto puede ser desde una API)
      onMounted(() => {
        // Simulando una llamada a la API para obtener la información del usuario
        const token = localStorage.getItem('token');
        
        if (token) {
          // Aquí puedes hacer una solicitud real a tu API para obtener la info del usuario
          // Ejemplo:
          // fetch('http://localhost:8000/api/user', {
          //   method: 'GET',
          //   headers: {
          //     'Authorization': `Bearer ${token}`
          //   }
          // })
          // .then(res => res.json())
          // .then(data => {
          //   user.value = data;
          // })
          // .catch(err => {
          //   console.error(err);
          // });
  
          // Aquí se simula la obtención de los datos del usuario
          user.value = {
            email: 'usuario@ejemplo.com',
            username: 'Usuario123'
          };
        } else {
          // Si no hay token, redirigimos al login
          router.push('/login');
        }
      });
  
      // Función para cerrar sesión
      function logout() {
        localStorage.removeItem('token');  // Eliminar el token
        router.push('/login');  // Redirigir al login
      }
  
      return {
        user,
        logout
      };
    }
  };
  </script>
  
  <style scoped>
  .profile-container {
    padding: 20px;
    background-color: #f4f4f4;
    border-radius: 10px;
    max-width: 600px;
    margin: auto;
    text-align: center;
  }
  
  .profile-header h2 {
    font-size: 2rem;
    color: #333;
  }
  
  .profile-info {
    margin-top: 20px;
    font-size: 1.2rem;
    color: #555;
  }
  
  .profile-info p {
    margin: 10px 0;
  }
  
  .profile-actions {
    margin-top: 30px;
  }
  
  .logout-button {
    background-color: #ffcc00;
    padding: 10px 20px;
    font-size: 1rem;
    color: black;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  .logout-button:hover {
    background-color: #ffdb4d;
  }
  </style>
  