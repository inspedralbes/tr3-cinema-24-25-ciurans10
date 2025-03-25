<template>
  <div class="profile-container">
    <div class="profile-header">
      <h2>Bienvenido a tu perfil</h2>
    </div>

    <div class="profile-info">
      <p><strong>Nombre de Usuario:</strong> {{ user.username || 'No disponible' }}</p>
      <p><strong>Correo Electrónico:</strong> {{ user.email }}</p>
    </div>

    <div class="tickets-section">
      <h3>Mis Tickets</h3>
      <div v-if="tickets.length > 0">
        <table class="tickets-table">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Email</th>
              <th>Asientos</th>
              <th>Fecha</th>
              <th>Hora</th>
              <th>Precio</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="ticket in tickets" :key="ticket.id">
              <td>{{ ticket.nombre }}</td>
              <td>{{ ticket.apellido }}</td>
              <td>{{ ticket.email }}</td>
              <td>{{ ticket.seats }}</td>
              <td>{{ ticket.selectedDate }}</td>
              <td>{{ ticket.sessionTime }}</td>
              <td>{{ ticket.total }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <p v-else>No tienes tickets comprados.</p>
    </div>

    <div class="profile-actions">
      <button @click="logout" class="logout-button">Cerrar sesión</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: {
        email: '',
        username: ''
      },
      tickets: []
    };
  },
  created() {
    this.getUserInfo();
    this.getUserTickets();
  },
  methods: {
    async getUserInfo() {
      try {
        const token = localStorage.getItem('token');
        if (!token) throw new Error('No hay token disponible');

        const response = await fetch('http://localhost:8000/api/user', {
          method: 'GET',
          headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
          }
        });

        if (!response.ok) throw new Error('Error al obtener la información del usuario');

        const data = await response.json();
        this.user.email = data.email;
        this.user.username = data.name;
      } catch (error) {
        console.error('Error obteniendo la información del usuario', error);
      }
    },

    async getUserTickets() {
      try {
        const token = localStorage.getItem('token');
        if (!token) throw new Error('No hay token disponible');

        const response = await fetch('http://localhost:8000/api/entradas', {
          method: 'GET',
          headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
          }
        });

        if (!response.ok) throw new Error('Error al obtener los tickets');

        const data = await response.json();
        this.tickets = data;
      } catch (error) {
        console.error('Error obteniendo los tickets', error);
      }
    },

    async logout() {
      try {
        const token = localStorage.getItem('token');
        if (!token) return;

        const response = await fetch('http://localhost:8000/api/logout', {
          method: 'POST',
          headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
          }
        });

        if (!response.ok) throw new Error('Error al cerrar sesión');

        localStorage.removeItem('token');
        this.$router.push('/login');
      } catch (error) {
        console.error('Error al cerrar sesión', error);
      }
    }
  }
};
</script>

<style scoped>
.profile-container {
  padding: 40px;
  background-color: #2c3e50;
  border-radius: 15px;
  max-width: 800px;
  text-align: center;
  color: white;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
}

.profile-header h2 {
  font-size: 2rem;
  color: #f1c40f;
}

.profile-info {
  font-size: 1.2rem;
  color: #ecf0f1;
}

.tickets-section {
  margin-top: 30px;
}

.tickets-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}

.tickets-table th, .tickets-table td {
  border: 1px solid #ecf0f1;
  padding: 10px;
  text-align: center;
  color: white;
}

.tickets-table th {
  background-color: #f1c40f;
  color: black;
}

.profile-actions {
  margin-top: 30px;
}

.logout-button {
  background-color: #e74c3c;
  padding: 12px 20px;
  font-size: 1rem;
  color: white;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  border: none;
}

.logout-button:hover {
  background-color: #c0392b;
}
</style>
