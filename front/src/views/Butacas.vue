<template>
  <div class="contenedor">
    <div class="butacas-container">
      <h1>Selecciona les teves butaques</h1>

      <div class="estado-butacas">
        <div class="leyenda-item">
          <span class="vip"></span> VIP
        </div>
        <div class="leyenda-item">
          <span class="disponible"></span> Disponible
        </div>
        <div class="leyenda-item">
          <span class="seleccionada"></span> Seleccionada
        </div>
        <div class="leyenda-item">
          <span class="ocupada"></span> Ocupada
        </div>
      </div>

      <div class="butacas-grid">
        <div
          v-for="butaca in butacas"
          :key="butaca.label"
          :class="[
            'butaca',
            { 
              'seleccionada': selectedSeats.includes(butaca.label),
              'vip': butaca.vip,
              'ocupada': butaca.ocupada
            }
          ]"
          @click="selectSeat(butaca)"
        >
          {{ butaca.label }}
        </div>
      </div>

      <div class="info-seleccion">
        <p>Butaques seleccionades: {{ selectedSeats.length }} / 10</p>
        <div class="detalles-extra">
          <span v-if="selectedVipCount > 0">VIP: {{ selectedVipCount }}</span>
        </div>
      </div>

      <button 
        :disabled="selectedSeats.length === 0" 
        @click="confirmSelection">
        Confirmar selecció
      </button>
    </div>

    <div class="notario-section" v-if="codigoNotario">
      <h3>Codi de reserva:</h3>
      <p class="codigo-notario">{{ codigoNotario }}</p>
    </div>
  </div>
</template>

<script>
import { useRouter } from 'vue-router';

export default {
  data() {
    return {
      butacas: this.generateSeats(),
      selectedSeats: [],
      pelicula: {
        movie: "Nombre de la película",
        date: "2025-03-10",
        time: "20:00"
      }
    };
  },

  computed: {
    selectedVipCount() {
      return this.butacas.filter(b => 
        this.selectedSeats.includes(b.label) && b.vip
      ).length;
    }
  },

  methods: {
    generateSeats() {
      const rows = 'ABCDEFGHIJKL'.split('');
      return rows.flatMap((row, index) => 
        Array.from({length: 10}, (_, i) => ({
          label: `${row}${i + 1}`,
          fila: index + 1,
          vip: index === 5, 
        }))
      );
    },

    selectSeat(butaca) {
      if (butaca.ocupada || (this.selectedSeats.length >= 10 && !this.selectedSeats.includes(butaca.label))) return;

      this.selectedSeats = this.selectedSeats.includes(butaca.label)
        ? this.selectedSeats.filter(seat => seat !== butaca.label)
        : [...this.selectedSeats, butaca.label];
    },

    confirmSelection() {
    if (this.selectedSeats.length === 0) return;

    const ticketData = {
      ...this.pelicula,
      seats: this.selectedSeats
    };

    this.$router.push({ name: 'entradas', query: { ticket: JSON.stringify(ticketData) } });
  }

  }
};
</script>


<style scoped>
.contenedor {
  max-width: 1200px;
  margin: 2rem auto;
  padding: 20px;
}

.butacas-container {
  background: #d0e1f2;
  padding: 2rem;
  border-radius: 12px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.estado-butacas {
  display: flex;
  gap: 1.5rem;
  justify-content: center;
  margin: 1rem 0 2rem;
}

.leyenda-item span {
  display: inline-block;
  width: 20px;
  height: 20px;
  margin-right: 8px;
  border-radius: 3px;
}

.vip {
  background: #FFC107;
}

.disponible {
  background: gray;
}

.seleccionada {
  background: #0ddd2f;
}

.ocupada {
  background: red;
  cursor: not-allowed;
}

.butacas-grid {
  display: grid;
  grid-template-columns: repeat(10, 1fr);
  gap: 8px;
  margin: 2rem 0;
}

.butaca {
  padding: 12px;
  text-align: center;
  border-radius: 4px;
  cursor: pointer;
  transition: transform 0.2s;
  background: gray;
  color: white;
}

.butaca.vip {
  background: #FFC107;
}

.butaca.ocupada {
  background: red;
  cursor: not-allowed;
}

.butaca.seleccionada {
  background: #0ddd2f;
  transform: scale(1.1);
}

.info-seleccion {
  margin: 1.5rem 0;
  font-size: 1.1rem;
}

.detalles-extra {
  margin-top: 0.5rem;
  display: flex;
  gap: 1rem;
  justify-content: center;
  color: #666;
}

button {
  background: #673AB7;
  padding: 12px 30px;
  font-size: 1.1rem;
  transition: all 0.3s;
}

button:hover:not(:disabled) {
  background: #512DA8;
  transform: translateY(-2px);
}

.codigo-notario {
  word-break: break-all;
  background: #eee;
  padding: 1rem;
  border-radius: 6px;
  font-family: monospace;
}
</style>