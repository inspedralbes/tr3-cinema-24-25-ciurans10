<template>
  <div class="contenedor">
    <h1>Selecciona les teves butaques</h1>
    <div v-for="(fila, index) in filas" :key="index" class="fila">
      <span class="fila-label">{{ fila }}</span>
      <div v-for="butaca in butacasPorFila" :key="butaca" class="butaca" 
           :class="{
             seleccionada: butaquesSeleccionades.includes(fila + butaca),
             'butaca-amarilla': fila === 'F' 
           }"
           @click="toggleButaca(fila, butaca)">
        {{ butaca }}
      </div>
    </div>
    
    <div class="info-seleccio">
      Butaques seleccionades: {{ butaquesSeleccionades.join(', ') }}
      <br/><br>
      Preu total: {{ precioTotal }}€
    </div>
    
    <button 
      :disabled="butaquesSeleccionades.length === 0" 
      @click="checkPreviousPurchase">
      Confirmar selecció
    </button>
    
    <div v-if="mostrarFormulario" class="formulario">
      <h2>Introdueix les teves dades</h2>
      <label>Nom:</label>
      <input type="text" v-model="nombre" placeholder="El teu nom" />
      <label>Cognom:</label>
      <input type="text" v-model="apellido" placeholder="El teu cognom" />
      <label>Email:</label>
      <input type="email" v-model="email" placeholder="El teu email" />
      <button @click="enviarDatos">Enviar</button>
    </div>

    <div v-if="errorMessage" class="error-message">
      <p>{{ errorMessage }}</p>
      <div v-if="previousPurchase">
        <h3>Compra anterior:</h3>
        <p>Butaques: {{ previousPurchase.seats.join(', ') }}</p>
        <p>Nom: {{ previousPurchase.nombre }} {{ previousPurchase.apellido }}</p>
        <p>Email: {{ previousPurchase.email }}</p> 
      </div>
    </div>
  </div>
</template>

<script>
import { useRoute, useRouter } from 'vue-router';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      filas: ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'],
      butacasPorFila: 10,
      butaquesSeleccionades: [],
      precioTotal: 0, 
      mostrarFormulario: false,
      nombre: '',
      apellido: '',
      email: '',
      errorMessage: '',
      previousPurchase: null,
      usuarioAutenticado: false, 
    };
  },
  setup() {
    const route = useRoute();
    const router = useRouter();

    return {
      route,
      router,
    };
  },
  computed: {
    peliculaId() {
      return this.route.params.movieId;
    },
    sessionTime() {
      return this.route.params.sessionTime;
    },
    selectedDate() {
      return this.route.params.selectedDate;
    }
  },
  created() {
    this.verificarSesion();
  },
  methods: {
    verificarSesion() {
      const token = localStorage.getItem('token');
      this.usuarioAutenticado = !!token; 
    },
    toggleButaca(fila, butaca) {
      if (!this.usuarioAutenticado) {
        Swal.fire({
          icon: 'warning',
          title: 'Inicia sesión',
          text: 'Debes iniciar sesión para seleccionar butacas.',
        });
        return;
      }

      const precio = fila === 'F' ? 8 : 6; 

      if (this.butaquesSeleccionades.length >= 10 && !this.butaquesSeleccionades.includes(fila + butaca)) {
        alert('Només pots seleccionar fins a 10 butaques.');
        return;
      }
      const index = this.butaquesSeleccionades.indexOf(fila + butaca);
      if (index === -1) {
        this.butaquesSeleccionades.push(fila + butaca);
        this.precioTotal += precio; 
      } else {
        this.butaquesSeleccionades.splice(index, 1);
        this.precioTotal -= precio; 
      }
    },
    checkPreviousPurchase() {
      let storedPurchases = JSON.parse(sessionStorage.getItem('ticketData')) || [];

      if (!Array.isArray(storedPurchases)) {
        storedPurchases = [storedPurchases];
      }

      const existingPurchase = storedPurchases.find(purchase => 
        purchase.peliculaId === this.peliculaId && purchase.sessionTime === this.sessionTime
      );

      if (existingPurchase) {
        this.errorMessage = 'Ja tens entrades per aquesta sessió.';
        this.previousPurchase = existingPurchase;
      } else {
        this.errorMessage = '';
        this.previousPurchase = null;
        this.mostrarFormulario = true;
      }
    },
    async enviarDatos() {
      if (!this.nombre || !this.apellido || !this.email) {
        alert('Si us plau, omple tots els camps.');
        return;
      }

      const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      if (!emailRegex.test(this.email)) {
        this.errorMessage = 'L\'email introduït no és vàlid.';
        return;
      } else {
        this.errorMessage = ''; 
      }

      const fechaHora = new Date().toLocaleString();

      const ticketData = {
        peliculaId: this.peliculaId,
        sessionTime: this.sessionTime,
        selectedDate: this.selectedDate,
        nombre: this.nombre,
        apellido: this.apellido,
        email: this.email,
        seats: this.butaquesSeleccionades,
        total: this.precioTotal, 
        fechaHora: fechaHora,
      };

      try {
        const response = await fetch('http://localhost:8000/api/entradas', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(ticketData),
        });

        if (response.ok) {
          Swal.fire({
            icon: 'success',
            title: '¡Entrada comprada correctamente!',
            text: 'Tu compra se ha realizado con éxito.',
            confirmButtonText: 'Aceptar',
          }).then(() => {
            this.router.push('/');
          });

          let storedPurchases = JSON.parse(sessionStorage.getItem('ticketData')) || [];
          storedPurchases.push(ticketData);
          sessionStorage.setItem('ticketData', JSON.stringify(storedPurchases));
        } else {
          this.errorMessage = 'Error al guardar la entrada en la base de datos.';
        }
      } catch (error) {
        console.error('Error en la solicitud:', error);
        this.errorMessage = 'Hubo un problema al enviar los datos.';
      }
    }
  }
};
</script>

<style scoped>
.contenedor {
  text-align: center;
  padding: 20px;
}

h1 {
  color: white;
}

.fila {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 10px;
  color: white;
}

.fila-label {
  margin-right: 10px;
  font-weight: bold;
}

.butaca {
  width: 30px;
  height: 30px;
  margin: 5px;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #f0f0f0;
  cursor: pointer;
  border: 1px solid #ccc;
  color: black;
}

.butaca-amarilla {
  background-color: yellow; 
}

.butaca.seleccionada {
  background-color: #4CAF50;
  color: white;
}

.info-seleccio {
  margin-top: 20px;
  font-size: 18px;
  color: white;
}

button {
  padding: 12px 24px;
  background-color: #FFD700;
  color: #000;
  font-size: 1.2rem;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  margin-top: 20px;
}

button:disabled {
  background-color: #cccccc;
  cursor: not-allowed;
}

button:hover {
  background-color: #FFC107;
}

.formulario {
  background: rgba(0, 0, 0, 0.8);
  padding: 20px;
  border-radius: 10px;
  margin-top: 20px;
  color: white;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.formulario label {
  margin-top: 10px;
}

.formulario input {
  padding: 10px;
  margin-top: 5px;
  border-radius: 5px;
  border: none;
}

.error-message {
  background-color: #f8d7da;
  padding: 20px;
  color: #721c24;
  border-radius: 10px;
  margin-top: 20px;
}
</style>
