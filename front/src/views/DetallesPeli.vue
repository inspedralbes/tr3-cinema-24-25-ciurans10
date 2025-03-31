<template>
  <div v-if="movie" class="movie-details">
    <div class="movie-container">
      <img 
        :src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`" 
        :alt="`Pòster de ${movie.title}`" 
        class="movie-poster"
      >
      
      <div class="movie-info">
        <h2 class="movie-title">{{ movie.title }}</h2>
        
        <div class="movie-meta">
          <p class="release-date">
            <strong>Data d'estrena:</strong> {{ formatDate(movie.release_date) }}
          </p>
          <p class="rating">
            <strong>Valoració:</strong> ⭐ {{ movie.vote_average }}/10
          </p>
        </div>

        <div class="movie-overview">
          <h3>Descripció</h3>
          <p>{{ movie.overview || "No hi ha descripció disponible." }}</p>
        </div>
        
        <div class="sessions-section">
          <h3>Horaris disponibles:</h3>
          <ul class="sessions-list">
            <li 
              v-for="(session, index) in sessions" 
              :key="index" 
              @click="selectSession(session)"
              class="session-item"
            >
              {{ session }}
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  
  <div v-else class="loading">
    Carregant detalls de la pel·lícula...
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { get } from '@/services/CommunicationManager';

const route = useRoute();
const router = useRouter();

const movieId = route.params.movieId;
const movie = ref(null);
const sessions = ref(["16:00", "18:30", "21:00"]);
const isLoading = ref(true);

const fetchMovieDetails = async () => {
  try {
    const data = await get(`/pelicula/${movieId}`);
    movie.value = data;
  } catch (error) {
    console.error('Error:', error);
  } finally {
    isLoading.value = false;
  }
};

const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(dateString).toLocaleDateString('ca-ES', options);
};

const selectSession = (session) => {
  router.push({
    name: 'Butacas',
    params: {
      movieId,
      sessionTime: session,
      selectedDate: route.params.selectedDate
    }
  });
};

onMounted(fetchMovieDetails);
</script>

<style scoped>
.movie-details {
  padding: 15px;
  color: white;
  background-color: #1c2b36;
}

.movie-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
  max-width: 1200px;
  margin: 0 auto;
}

.movie-poster {
  width: 100%;
  max-width: 300px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

.movie-info {
  width: 100%;
}

.movie-title {
  font-size: 1.8rem;
  margin-bottom: 15px;
  color: #ffcc00;
  text-align: center;
}

.movie-meta {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-bottom: 20px;
  background: rgba(255, 255, 255, 0.1);
  padding: 15px;
  border-radius: 8px;
}

.movie-overview {
  margin-bottom: 25px;
}

.movie-overview h3 {
  font-size: 1.3rem;
  margin-bottom: 10px;
  color: #ffcc00;
}

.movie-overview p {
  line-height: 1.6;
}

.sessions-section {
  margin-top: 25px;
}

.sessions-section h3 {
  font-size: 1.3rem;
  margin-bottom: 15px;
  color: #ffcc00;
  text-align: center;
}

.sessions-list {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 12px;
  padding: 0;
  list-style: none;
}

.session-item {
  background: #007BFF;
  color: white;
  padding: 12px 20px;
  border-radius: 25px;
  cursor: pointer;
  font-size: 1rem;
  transition: all 0.2s ease;
  min-width: 80px;
  text-align: center;
}

.session-item:hover {
  background: #0056b3;
  transform: scale(1.05);
}

.loading {
  color: white;
  text-align: center;
  padding: 50px;
  font-size: 1.2rem;
}

@media (min-width: 600px) {
  .movie-container {
    flex-direction: row;
    align-items: flex-start;
  }
  
  .movie-poster {
    max-width: 250px;
  }
  
  .movie-meta {
    flex-direction: row;
    justify-content: space-between;
  }
}

@media (min-width: 900px) {
  .movie-details {
    padding: 30px;
  }
  
  .movie-poster {
    max-width: 300px;
  }
  
  .movie-title {
    font-size: 2.2rem;
    text-align: left;
  }
  
  .sessions-list {
    gap: 15px;
  }
  
  .session-item {
    padding: 15px 25px;
    font-size: 1.1rem;
  }
}
</style>