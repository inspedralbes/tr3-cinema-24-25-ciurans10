<template>
  <div v-if="movie" class="movie-details">
    <div class="movie-container">
      <img :src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`" alt="Poster de la película" class="movie-poster">
      <div class="movie-info">
        <h2 class="movie-title">{{ movie.title }}</h2>
        <p><strong>Descripción:</strong> {{ movie.overview }}</p>

        <div class="movie-details-header">
          <p><strong>Fecha de estreno:</strong> {{ movie.release_date }}</p>
        </div>

        <p><strong>Promedio de votos:</strong> {{ movie.vote_average }}</p>
        
        <h3>Horarios:</h3>
        <ul>
          <li v-for="session in sessions" :key="session" @click="selectSession(session)">
            {{ session }}
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();

const movieId = route.params.movieId;
const title = decodeURIComponent(route.params.title);
const selectedDate = route.params.selectedDate;
const movie = ref(null);
const sessions = ref(["16:00"]);

const fetchMovieDetails = async () => {
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

const selectSession = (session) => {
  
  router.push({
    name: 'Butacas',
    params: {
      movieId,
      sessionTime: session,
      selectedDate 
    }
  });
};

onMounted(fetchMovieDetails);
</script>

<style scoped>
.movie-details {
  padding: 20px;
  text-align: center;
  color: white;
}

.movie-container {
  display: flex;
  align-items: flex-start;
  justify-content: center;
  gap: 20px;
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

h3 {
  color: #ffffff;
  font-size: 1.2rem;
  margin-top: 10px;
}

ul {
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
  font-size: 1rem;
}

li:hover {
  background: #0056b3;
  transform: scale(1.1);
}
</style>