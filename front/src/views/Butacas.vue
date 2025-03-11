<template>
  <div class="contenedor">
    <h1>Selecciona les teves butaques</h1>
    <div v-for="(fila, index) in filas" :key="index" class="fila">
      <span class="fila-label">{{ fila }}</span>
      <div v-for="butaca in butacasPorFila" :key="butaca" class="butaca" 
           :class="{ seleccionada: butaquesSeleccionades.includes(fila + butaca) }"
           @click="toggleButaca(fila + butaca)">
        {{ butaca }}
      </div>
    </div>
    
    <div class="info-seleccio">
      Butaques seleccionades: {{ butaquesSeleccionades.join(', ') }}
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
      <label>Telèfon:</label>
      <input type="tel" v-model="telefono" placeholder="El teu telèfon" />
      <button @click="enviarDatos">Enviar</button>
    </div>

    <div v-if="errorMessage" class="error-message">
      <p>{{ errorMessage }}</p>
      <div v-if="previousPurchase">
        <h3>Compra anterior:</h3>
        <p>Butaques: {{ previousPurchase.seats.join(', ') }}</p>
        <p>Nom: {{ previousPurchase.nombre }} {{ previousPurchase.apellido }}</p>
        <p>Telèfon: {{ previousPurchase.telefono }}</p> 
      </div>
    </div>
  </div>
</template>

<script>
import { useRouter } from 'vue-router';

export default {
  data() {
    return {
      filas: ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'],
      butacasPorFila: 10,
      butaquesSeleccionades: [],
      mostrarFormulario: false,
      nombre: '',
      apellido: '',
      telefono: '',
      errorMessage: '', 
      previousPurchase: null, 
    };
  },
  setup() {
    const router = useRouter();
    return { router };
  },
  methods: {
    toggleButaca(butaca) {
      if (this.butaquesSeleccionades.length >= 10 && !this.butaquesSeleccionades.includes(butaca)) {
        alert('Només pots seleccionar fins a 10 butaques.');
        return;
      }
      const index = this.butaquesSeleccionades.indexOf(butaca);
      if (index === -1) {
        this.butaquesSeleccionades.push(butaca);
      } else {
        this.butaquesSeleccionades.splice(index, 1);
      }
    },
    checkPreviousPurchase() {
      const storedPurchase = JSON.parse(sessionStorage.getItem('ticketData'));
      
      if (storedPurchase && storedPurchase.tituloPelicula === this.tituloPelicula) {
      
        this.errorMessage = 'Ja tens entrades per aquesta sessió.';
        this.previousPurchase = storedPurchase;
      } else {
      
        this.errorMessage = '';
        this.previousPurchase = null;
        this.mostrarFormulario = true;
      }
    },
    enviarDatos() {
      if (!this.nombre || !this.apellido || !this.telefono) {
        alert('Si us plau, omple tots els camps.');
        return;
      }
      
      const ticketData = {
        nombre: this.nombre,
        apellido: this.apellido,
        telefono: this.telefono,
        seats: this.butaquesSeleccionades,
      };
      
      sessionStorage.setItem('ticketData', JSON.stringify(ticketData));
    
      this.router.push('/entradas');
    }
  }
};
</script>

<style scoped>
/* Los estilos permanecen igual */
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
