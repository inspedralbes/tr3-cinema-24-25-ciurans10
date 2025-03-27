<template>
  <div class="upcoming-movies">
    <h1>Proxims Estrens</h1>
    <div class="movies-grid">
      <div v-for="(movie, index) in movies.slice(0, 3)" :key="index" class="movie-card">
        <img :src="movie.image" :alt="movie.title" />
        <h3>{{ movie.title }}</h3>
        <p>{{ movie.release_date }}</p> 
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const movies = ref([
  {
    title: "Minecraft",
    image: "/minecraft.webp", 
    release_date: "04-04-2025",
  },
  {
    title: "Avatar 3",
    image: "/avatar.jpg", 
    release_date: "19-12-2025", 
  },
  {
    title: "Shrek 5",
    image: "/shrek.jpg",
    release_date: "01-07-2026",
  },
]);
</script>

<style scoped>
.upcoming-movies {
  padding: 15px;
  background-color: #1c2b36;
  color: white;
  width: 100%;
  text-align: center;
}

.upcoming-movies h1 {
  margin-bottom: 15px;
  font-size: 1.5rem;
}

.movies-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 15px;
  max-width: 1200px;
  margin: 0 auto;
}

.movie-card {
  background: #2c3e50;
  border-radius: 8px;
  padding: 10px;
  text-align: center;
}

.movie-card img {
  width: 100%;
  max-width: 100%;
  height: auto;
  border-radius: 8px;
  max-height: 300px;
  object-fit: cover;
}

.movie-card h3 {
  margin-top: 8px;
  font-size: 1.1rem;
  color: #ffcc00;
}

.movie-card p {
  margin-top: 5px;
  font-size: 0.9rem;
  color: #ccc;
}

@media (max-width: 768px) {
  .upcoming-movies {
    padding: 10px;
  }
  
  .upcoming-movies h1 {
    font-size: 1.3rem;
    margin-bottom: 10px;
  }
  
  .movies-grid {
    grid-template-columns: 1fr;
    gap: 10px;
  }
  
  .movie-card {
    max-width: 300px;
    margin: 0 auto;
  }
}

@media (max-width: 480px) {
  .upcoming-movies h1 {
    font-size: 1.2rem;
  }
  
  .movie-card h3 {
    font-size: 1rem;
  }
  
  .movie-card p {
    font-size: 0.8rem;
  }
}
</style>