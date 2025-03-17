<template>
  <div class="container">
    <h1>Properes Sessions</h1>

    <div class="date-picker">
      <div class="week-picker">
        <div class="week-days">
          <button
            v-for="day in weekDays"
            :key="day.date"
            :class="{ active: isSelected(day.date) }"
            @click="selectDate(day.date)"
          >
            {{ day.day }} {{ day.date.split('-')[2] }}
          </button>
        </div>
      </div>
    </div>

    <div v-if="movies.length" class="movies-grid">
      <div v-for="movie in movies" :key="movie.id" class="movie-card">
        <router-link
          :to="{
            name: 'DetallesPeli',
            params: {
              movieId: movie.id,
              title: encodeURIComponent(movie.title),
              posterPath: encodeURIComponent(movie.poster_path),
              selectedDate: selectedDate,
            },
          }"
          class="image-link"
        >
          <img
            :src="'https://image.tmdb.org/t/p/w500' + movie.poster_path"
            :alt="movie.title"
            class="movie-image"
          />
        </router-link>

        <h2>{{ movie.title }}</h2>
        <h3 v-if="isWednesday(selectedDate)">¡Es día del espectador!</h3>
      </div>
    </div>

    <p v-else>Cargando películas...</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      allMovies: [],
      movies: [],
      selectedDate: new Date().toISOString().split('T')[0],
      currentWeekStart: this.getStartOfWeek(new Date()),
    };
  },

  computed: {
    weekDays() {
      const days = [];
      for (let i = 0; i < 7; i++) {
        const date = new Date(this.currentWeekStart);
        date.setDate(date.getDate() + i);
        days.push({
          date: date.toISOString().split('T')[0],
          day: date.toLocaleDateString('es-ES', { weekday: 'short' }),
        });
      }
      return days;
    },
  },

  methods: {
    async fetchMoviesFromDatabase() {
      try {
        const response = await fetch('http://localhost:8000/api/peliculas');
        if (!response.ok) {
          throw new Error('Error al obtener las películas desde la base de datos');
        }

        const data = await response.json();
        this.allMovies = data;
        this.updateMoviesForDate();
      } catch (error) {
        console.error('Error al obtener las películas:', error);
        alert('Hubo un error al obtener las películas. Verifica la consola.');
      }
    },

    updateMoviesForDate() {
      this.movies = this.getMoviesForDate(this.selectedDate);
    },

    getMoviesForDate(date) {
      if (!this.allMovies.length) return [];

      const totalMovies = this.allMovies.length;
      const dateOffset = this.calculateDateOffset(date);
      const startIndex = (dateOffset * 3) % totalMovies;

      return this.allMovies.slice(startIndex, startIndex + 3);
    },

    calculateDateOffset(date) {
      const baseDate = new Date('2025-03-01');
      const currentDate = new Date(date);
      const diffInDays = Math.floor((currentDate - baseDate) / (1000 * 60 * 60 * 24));
      return diffInDays;
    },

    isWednesday(date) {
      const selectedDate = new Date(date);
      return selectedDate.getDay() === 3;
    },

    getStartOfWeek(date) {
      const startOfWeek = new Date(date);
      const dayOfWeek = date.getDay(); 
      const diff = dayOfWeek === 0 ? 6 : dayOfWeek - 1; 
      startOfWeek.setDate(date.getDate() - diff);
      return startOfWeek;
    },

    selectDate(date) {
      this.selectedDate = date;
      this.updateMoviesForDate();
    },

    isSelected(date) {
      return this.selectedDate === date;
    },
  },

  mounted() {
    this.fetchMoviesFromDatabase();
  },
};
</script>

<style scoped>
.container {
  max-width: 1100px;
  margin: auto;
  text-align: center;
  font-family: 'Arial', sans-serif;
}

h1 {
  color: white;
  font-size: 2.5rem;
  margin-bottom: 20px;
}

.date-picker {
  margin-bottom: 20px;
  color: white;
}

label {
  font-size: 1.2rem;
  margin-right: 10px;
  font-weight: bold;
}

.week-picker {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
}

.week-days {
  display: flex;
  gap: 10px;
}

.week-days button {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background: white;
  cursor: pointer;
}

.week-days button.active {
  background: #28a745;
  color: white;
}

.movies-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 30px;
}

.movie-card {
  background: #ffffff;
  border-radius: 15px;
  padding: 20px;
  text-align: center;
  max-height: 500px;
  transition: transform 0.3s ease-in-out;
}

.movie-card:hover {
  transform: scale(1.04);
}

.movie-image {
  max-width: 250px;
  border-radius: 12px;
}

h2 {
  font-size: 1.5rem;
  color: #333;
  margin-top: 10px;
}

h3 {
  color: #28a745;
  font-size: 1.3rem;
  margin-top: 15px;
}
</style>