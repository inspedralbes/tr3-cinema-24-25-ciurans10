<template>
  <div class="butacas-container">
    <h1>Selecciona tus butacas</h1>
    <p>Película: {{ title }}</p>
    <p>Sesión: {{ sessionTime }}</p>
    <p>Fecha: {{ selectedDate }}</p>

    <div class="butacas-grid">
      <div
        v-for="(butaca, index) in butacas"
        :key="butaca.label"
        :class="[ 
          'butaca', 
          butaca.status, 
          { 'seleccionada': selectedButacas.includes(butaca.label) }, 
          { 'vip': butaca.fila === 6 } 
        ]"
        @click="selectButaca(butaca)"
      >
        {{ butaca.label }}
      </div>
    </div>

    <p class="seleccionadas-info">
      Butacas seleccionadas: {{ selectedButacas.length }} / 10
    </p>

    <button 
      :disabled="selectedButacas.length === 0" 
      @click="confirmSelection"
    >
      Confirmar selección
    </button>
  </div>
</template>

<script>
export default {
  props: ['movieId', 'sessionTime', 'selectedDate', 'title'],  // Recibimos los props

  data() {
    return {
      butacas: this.generateSeats(),
      selectedButacas: [],
    };
  },

  watch: {
    movieId(newMovieId) {
      this.fetchMovieTitle(newMovieId);  // Si movieId cambia, actualizamos el título
    }
  },

  methods: {
    // Función para obtener el título de la película usando movieId
    async fetchMovieTitle(movieId) {
      if (!this.title) {
        try {
          const response = await fetch(`http://localhost:8000/api/peliculas/${movieId}`);
          if (!response.ok) {
            throw new Error('Error al obtener los detalles de la película');
          }
          const movie = await response.json();
          this.title = movie.title; 
        } catch (error) {
          console.error('Error al obtener el título de la película:', error);
        }
      }
    },

    generateSeats() {
      let seats = [];
      const rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
      for (let i = 0; i < rows.length; i++) {
        for (let j = 1; j <= 10; j++) {
          seats.push({
            label: `${rows[i]}${j}`,
            fila: i + 1,
            status: 'disponible',  
          });
        }
      }

      // Hacer la fila 6 VIP
      seats.forEach(seat => {
        if (seat.fila === 6) {
          seat.status = 'disponible'; 
        }
      });
      return seats;
    },

    selectButaca(butaca) {
      if (butaca.status === 'ocupada') {
        return;
      }

      if (this.selectedButacas.includes(butaca.label)) {
        this.selectedButacas = this.selectedButacas.filter((b) => b !== butaca.label);
      } else {
        if (this.selectedButacas.length < 10) {
          this.selectedButacas.push(butaca.label);
        }
      }
    },

    confirmSelection() {
      alert(`Butacas seleccionadas: ${this.selectedButacas.join(', ')}`);
    },
  },

  mounted() {
    // Si no tenemos el título, lo buscamos usando movieId
    if (!this.title && this.movieId) {
      this.fetchMovieTitle(this.movieId);
    }
  },
};


</script>

<style scoped>
.butacas-container {
  text-align: center;
  max-width: 800px;
  margin: 0 auto;
}

.butacas-grid {
  display: grid;
  grid-template-columns: repeat(10, 1fr); /* 10 columnas */
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
  background-color: #808080; /* Gris */
  color: white;
}

.butaca.ocupada {
  background-color: #ff4d4d; /* Rojo */
  color: white;
  cursor: not-allowed;
}

.butaca.seleccionada {
  background-color: #28a745; /* Verde */
  color: white;
}

.butaca.vip {
  background-color: #ffd700; /* Dorado para VIP */
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
