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
      @click="confirmarSeleccion">
      Confirmar selecció
    </button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      filas: ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'], 
      butacasPorFila: 10, 
      butaquesSeleccionades: [], 
    };
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

    confirmarSeleccion() {
      alert(`Butaques seleccionades: ${this.butaquesSeleccionades.join(', ')}`);
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
</style>
