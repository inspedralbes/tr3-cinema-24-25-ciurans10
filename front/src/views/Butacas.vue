<template>
  <div class="contenedor">
    <div class="butacas-container">
      <h1>Selecciona les teves butaques</h1>

      <div class="butacas-grid">
        <div
          v-for="butaca in butacas"
          :key="butaca.label"
          :class="[ 'butaca', butaca.status, { 'seleccionada': selectedSeats.includes(butaca.label) }, { 'vip': butaca.fila === 6 } ]"
          @click="selectSeat(butaca)"
        >
          {{ butaca.label }}
        </div>
      </div>

      <p class="seleccionadas-info">
        Butaques seleccionades: {{ selectedSeats.length }} / 10
      </p>

      <button 
        :disabled="selectedSeats.length === 0" 
        @click="confirmSelection"
      >
        Confirmar selecció
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: ['title', 'selectedDate', 'sessionTime', 'posterPath'],  

  data() {
    return {
      butacas: this.generateSeats(),
      selectedSeats: [] 
    };
  },

  methods: {
    generateSeats() {
      let seats = [];
      const rows = 'ABCDEFGHIJKL'.split('');
      for (let i = 0; i < rows.length; i++) {
        for (let j = 1; j <= 10; j++) {
          seats.push({
            label: `${rows[i]}${j}`,
            fila: i + 1,
            status: 'disponible',  
          });
        }
      }
      return seats;
    },

    selectSeat(butaca) {
      if (butaca.status === 'ocupada') return;

      if (this.selectedSeats.includes(butaca.label)) {
        this.selectedSeats = this.selectedSeats.filter(seat => seat !== butaca.label);
      } else {
        if (this.selectedSeats.length < 10) {
          this.selectedSeats.push(butaca.label);
        }
      }
    },

    confirmSelection() {
      alert(`Butaques seleccionades: ${this.selectedSeats.join(', ')}`);
    },
  }
};
</script>

<style scoped>

.contenedor {
  display: flex;
  max-width: 1100px;
  margin: auto;
  gap: 40px;
  align-items: flex-start;
  justify-content: center;
  position: relative; 
}

.butacas-container {
  flex: 1;
  text-align: center;
}

.butacas-grid {
  display: grid;
  grid-template-columns: repeat(10, 1fr);
  gap: 10px;
  margin: 20px 0;
}

.butaca {
  padding: 15px;
  font-size: 1rem;
  text-align: center;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.butaca.disponible {
  background-color: #808080;
  color: white;
}

.butaca.ocupada {
  background-color: #ff4d4d;
  color: white;
  cursor: not-allowed;
}

.butaca.seleccionada {
  background-color: #28a745;
  color: white;
}

.butaca.vip {
  background-color: #ffd700;
  color: white;
}

.butaca:hover {
  transform: scale(1.1);
}

.seleccionadas-info {
  font-size: 1.1rem;
  margin-top: 20px;
}

button {
  padding: 10px 20px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-top: 20px;
}

button:disabled {
  background-color: #cccccc;
  cursor: not-allowed;
}
</style>
