<template>
  <div class="contenedor">
    <h1>Selecciona les teves butaques</h1>

    <!-- Mensaje del día del espectador -->
    <div v-if="esDiaDelEspectador()" class="dia-espectador">
      <p>¡Avui és dia del espectador! Preus reduïts: 4€ (normals) i 6€ (VIP).</p>
    </div>

    <div class="leyenda">
      <div class="leyenda-item">
        <div class="color-box vermell"></div>
        <span>Ocupades</span>
      </div>
      <div class="leyenda-item">
        <div class="color-box gris"></div>
        <span>Disponibles</span>
      </div>
      <div class="leyenda-item">
        <div class="color-box verd"></div>
        <span>Seleccionades per l'usuari</span>
      </div>
      <div class="leyenda-item">
        <div class="color-box groc"></div>
        <span>VIP</span>
      </div>
    </div>

    <!-- Butaques -->
    <div v-for="(fila, index) in filas" :key="index" class="fila">
      <span class="fila-label">{{ fila }}</span>
      <div v-for="butaca in butacasPorFila" :key="butaca" class="butaca" 
           :class="{
             seleccionada: butaquesSeleccionades.includes(fila + butaca),
             ocupada: butacasOcupadas.includes(fila + butaca),
             'butaca-amarilla': fila === 'F' 
           }"
           @click="toggleButaca(fila, butaca)">
        {{ butaca }}
      </div>
    </div>

    <!-- Informació de selecció -->
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
    
    <!-- Formulari de dades -->
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
      butacasOcupadas: [],
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
    this.cargarButacasOcupadas();
  },
  methods: {
    async cargarButacasOcupadas() {
      try {
        const response = await fetch('http://localhost:8000/api/butacas-ocupadas');
        if (response.ok) {
          const data = await response.json();
          this.butacasOcupadas = data.ocupadas || [];
        } else {
          console.error('Error al cargar las butacas ocupadas');
        }
      } catch (error) {
        console.error('Error en la solicitud de butacas ocupadas:', error);
      }
    },
    verificarSesion() {
      const token = localStorage.getItem('token');
      this.usuarioAutenticado = !!token;
    },
    toggleButaca(fila, butaca) {
      const butacaId = fila + butaca;

      if (this.butacasOcupadas.includes(butacaId)) {
        return;
      }

      if (!this.usuarioAutenticado) {
        Swal.fire({
          icon: 'warning',
          title: 'Inicia sesión',
          text: 'Debes iniciar sesión para seleccionar butacas.',
        });
        return;
      }

      // Precios según el día del espectador
      const precioNormal = this.esDiaDelEspectador() ? 4 : 6; // 4€ si es miércoles, 6€ si no
      const precioVIP = this.esDiaDelEspectador() ? 6 : 8;   // 6€ si es miércoles, 8€ si no

      const precio = fila === 'F' ? precioVIP : precioNormal;

      if (this.butaquesSeleccionades.length >= 10 && !this.butaquesSeleccionades.includes(butacaId)) {
        alert('Només pots seleccionar fins a 10 butaques.');
        return;
      }

      const index = this.butaquesSeleccionades.indexOf(butacaId);
      if (index === -1) {
        this.butaquesSeleccionades.push(butacaId);
        this.precioTotal += precio;
      } else {
        this.butaquesSeleccionades.splice(index, 1);
        this.precioTotal -= precio;
      }
    },
    checkPreviousPurchase() {
      // Obtener las compras almacenadas en localStorage
      const storedPurchases = JSON.parse(localStorage.getItem('ticketData')) || [];

      // Buscar si ya existe una compra para esta película y sesión
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

      const token = localStorage.getItem('token');

      if (!token) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No estás autenticado. Por favor, inicia sesión.',
        });
        return;
      }

      try {
        const response = await fetch('http://localhost:8000/api/entradas', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
          },
          body: JSON.stringify(ticketData),
        });

        if (response.ok) {
          // Guardar la compra en localStorage
          const storedPurchases = JSON.parse(localStorage.getItem('ticketData')) || [];
          storedPurchases.push(ticketData);
          localStorage.setItem('ticketData', JSON.stringify(storedPurchases));

          Swal.fire({
            icon: 'success',
            title: '¡Entrada comprada correctamente!',
            text: 'Tu compra se ha realizado con éxito.',
            confirmButtonText: 'Aceptar',
          }).then(() => {
            this.router.push('/');
          });
        } else {
          this.errorMessage = 'Error al guardar la entrada en la base de datos.';
        }
      } catch (error) {
        console.error('Error en la solicitud:', error);
        this.errorMessage = 'Hubo un problema al enviar los datos.';
      }
    },
    esDiaDelEspectador() {
      const selectedDate = new Date(this.selectedDate);
      return selectedDate.getDay() === 3; // 3 = miércoles
    },
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

.leyenda {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin-bottom: 20px;
  color: white;
}

.leyenda-item {
  display: flex;
  align-items: center;
  gap: 8px;
}

.color-box {
  width: 20px;
  height: 20px;
  border: 1px solid #ccc;
}

.vermell {
  background-color: #ff4444; 
}

.gris {
  background-color: #f0f0f0; 
}

.verd {
  background-color: #4CAF50; 
}

.groc{
  background-color: yellow;
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

.butaca.ocupada{
  background-color: #ff4444 
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

.dia-espectador {
  background-color: #4CAF50;
  color: white;
  padding: 10px;
  border-radius: 5px;
  margin-bottom: 20px;
}
</style>