<template>
  <div v-if="movie" class="movie-details">
    <div class="movie-container">
      <img :src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`" alt="Poster de la película" class="movie-poster">
      <div class="movie-info">
        <h2 class="movie-title">{{ movie.title }}</h2>
        <p><strong>Descripción:</strong> {{ movie.overview }}</p>
        <p><strong>Fecha de estreno:</strong> {{ movie.release_date }}</p>
        <p><strong>Promedio de votos:</strong> {{ movie.vote_average }}</p>
      
        <router-link :to="`/butacas`">
          <button class="buy-button">🎟️ Comprar entradas</button>
        </router-link>
      </div>
    </div>

    <router-link to="/cartelera" class="back-link">Volver a la cartelera</router-link>
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
  width: 200px; 
  height: auto;
  max-width: 100%;
  object-fit: cover; 
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

.buy-button {
  padding: 12px 24px;
  background-color: #FFD700;
  color: #000;
  font-size: 1.2rem;
  font-weight: bold;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  margin-top: 20px;
  transition: background-color 0.3s ease;
}

.buy-button:hover {
  background-color: #FFC107;
}

.back-link {
  display: inline-block;
  margin-top: 20px;
  text-decoration: none;
  color: #007bff;
}

.loading {
  font-size: 18px;
  text-align: center;
}
</style>
