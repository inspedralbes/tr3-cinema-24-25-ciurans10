<template>
  <div v-if="movie" class="movie-details">
    <div class="movie-container">
      <img :src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`" alt="Poster de la película" class="movie-poster">
      <div class="movie-info">
        <h2 class="movie-title">{{ movie.title }}</h2>
        <p><strong>Descripción:</strong> {{ movie.overview }}</p>

        <div class="movie-details-header">
          <p><strong>Fecha de estreno:</strong> {{ movie.release_date }}</p>
          <router-link to="/cartelera" class="back-link">
            <button class="back-button">Volver a la cartelera</button>
          </router-link>
        </div>

        <p><strong>Promedio de votos:</strong> {{ movie.vote_average }}</p>
      </div>
    </div>
  </div>
  <div v-else class="loading">Cargando detalles...</div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';

const movie = ref(null);
const route = useRoute();

const fetchMovieDetails = async () => {
  const movieId = route.params.id;
  try {
    const response = await fetch(`http://localhost:8000/api/pelicula/${movieId}`);
    if (!response.ok) {
      throw new Error('Error al obtener los detalles de la película');
    }

    const data = await response.json();
    movie.value = data;
  } catch (error) {
    console.error(error);
  }
};

onMounted(fetchMovieDetails);
</script>

<style scoped>
.movie-details {
  padding: 20px;
  text-align: center;
}

.movie-container {
  display: flex;
  align-items: flex-start;
  justify-content: center;
  gap: 20px;
  margin-bottom: 20px;
}

.movie-title {
  font-size: 2rem;
  font-weight: bold;
  margin-bottom: 20px;
}

.movie-poster {
  width: 250px;
  height: auto;
  max-width: 100%;
  object-fit: cover;
  margin-top: 25px;
}

.movie-info {
  font-size: 18px;
  line-height: 1.5;
  max-width: 600px;
  text-align: left;
}

.movie-info p {
  margin: 10px 0;
}

.movie-details-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px; 
}

.back-button {
  padding: 12px 24px;
  background-color: #007bff;
  color: #fff;
  font-size: 1.2rem;
  font-weight: bold;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  margin-top: 20px; 
}

.back-button:hover {
  background-color: #0056b3;
}

.back-link {
  text-decoration: none;
}

.loading {
  font-size: 18px;
  text-align: center;
}
</style>
