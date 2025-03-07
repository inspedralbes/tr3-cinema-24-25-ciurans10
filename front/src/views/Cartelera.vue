<template>
  <div>
    <h2 class="title">Películas</h2>
    <div v-if="movies.length" class="movie-grid">
      <div v-for="movie in movies" :key="movie.id" class="movie-card">
        <router-link :to="`/pelicula/${movie.id}`" class="movie-link">
          <div class="movie-image-container">
            <img :src="movie.poster_path" alt="Poster de la película" class="movie-poster">
            <div class="overlay">
              <h3>{{ movie.title }}</h3>
              <p>{{ movie.showtime }}</p>
            </div>
          </div>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const movies = ref([]);

const fetchMoviesFromDatabase = async () => {
  try {
    const response = await fetch('http://localhost:8000/api/peliculas');
    if (!response.ok) {
      throw new Error('Error al obtener las películas desde la base de datos');
    }

    const data = await response.json();
    movies.value = data;
  } catch (error) {
    console.error('Error al obtener las películas:', error);
    alert('Hubo un error al obtener las películas. Verifica la consola.');
  }
};

onMounted(fetchMoviesFromDatabase);
</script>

<style scoped>
.title {
  text-align: center;
  font-size: 2rem;
  font-weight: bold;
  color: white;
  text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
  margin-bottom: 30px;
}

.movie-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr); 
  gap: 20px;
  margin-top: 20px;
  padding: 0 20px;
}

.movie-card {
  position: relative;
  overflow: hidden;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.movie-card:hover {
  transform: translateY(-10px); 
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5); 
}

.movie-link {
  display: block;
  color: inherit;
  text-decoration: none;
}

.movie-image-container {
  position: relative;
  overflow: hidden;
  border-radius: 12px;
}

.movie-poster {
  width: 100%;
  height: auto;
  max-height: 400px;
  object-fit: cover; 
  transition: transform 0.3s ease;
}

.movie-card:hover .movie-poster {
  transform: scale(1.1); 
}

.overlay {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  color: white;
  opacity: 0;
  transition: opacity 0.3s ease;
  width: 100%;
}

.overlay h3 {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 10px;
}

.overlay p {
  font-size: 18px;
}

.overlay h3, .overlay p {
  transition: opacity 0.3s ease, transform 0.3s ease;
}

.movie-card:hover .overlay h3, .movie-card:hover .overlay p {
  transform: translateY(0);
  opacity: 1;
}
</style>
