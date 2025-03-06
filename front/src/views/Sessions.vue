<template>
  <div class="container">
    <h1>📅 Properes Sessions</h1>

    <div class="date-picker">
      <label for="sessionDate">Selecciona una data:</label>
      <input type="date" id="sessionDate" v-model="selectedDate">
    </div>

    <div v-if="movies.length" class="movies-grid">
      <div v-for="movie in movies" :key="movie.id" class="movie-card">
        <img :src="'https://image.tmdb.org/t/p/w500' + movie.poster_path" :alt="movie.title" class="movie-image">
        <h2>{{ movie.title }}</h2>
        <h3>Horaris:</h3>
        <ul>
          <li v-for="session in movie.sessions" :key="session" @click="selectSession(movie, session)">
            ⏰ {{ session }}
          </li>
        </ul>
      </div>
    </div>

    <p v-else>Cargando películas...</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      movies: [],
      selectedDate: new Date().toISOString().split('T')[0]
    };
  },
  methods: {
    async fetchMoviesFromDatabase() {
      try {
        const response = await fetch('http://localhost:8000/api/peliculas');
        if (!response.ok) {
          throw new Error('Error al obtener las películas desde la base de datos');
        }

        const data = await response.json();
      
        this.movies = data.slice(0, 9).map(movie => ({
          ...movie,
          sessions: this.generateSessions()
        }));
      } catch (error) {
        console.error('Error al obtener las películas:', error);
        alert('Hubo un error al obtener las películas. Verifica la consola.');
      }
    },
    generateSessions() {
      return ["16:00", "18:00", "20:00"];
    },
    selectSession(movie, session) {
      this.$router.push({
        name: 'Butacas', 
        params: {
          movieId: movie.id,  
          title: movie.title,  
          sessionTime: session,
          selectedDate: this.selectedDate,
          posterPath: movie.poster_path
        }
      });
    }
  },
  mounted() {
    this.fetchMoviesFromDatabase();
  }
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
  color: #2c3e50;
  font-size: 2.5rem;
  margin-bottom: 20px;
}

.date-picker {
  margin-bottom: 20px;
}

label {
  font-size: 1.2rem;
  margin-right: 10px;
  font-weight: bold;
}

input[type="date"] {
  padding: 10px;
  font-size: 1.1rem;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.movies-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr); /* Ahora 3 películas por fila */
  gap: 30px;
}

.movie-card {
  background: #ffffff;
  border-radius: 15px;
  padding: 20px;
  text-align: center;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
  transition: transform 0.3s ease-in-out;
}

.movie-card:hover {
  transform: scale(1.07);
}

.movie-image {
  max-width: 200px; /* Imagen más grande */
  border-radius: 12px;
}

h2 {
  font-size: 1.5rem;
  color: #333;
  margin-top: 10px;
}

h3 {
  color: #007BFF;
  font-size: 1.2rem;
  margin-top: 10px;
}

ul {
  list-style: none;
  padding: 0;
}

li {
  display: inline-block;
  margin: 8px;
  padding: 10px 14px;
  background: #007BFF;
  color: white;
  border-radius: 25px;
  cursor: pointer;
  transition: background 0.3s, transform 0.2s;
  font-size: 1rem;
}

li:hover {
  background: #0056b3;
  transform: scale(1.1);
}
</style>
