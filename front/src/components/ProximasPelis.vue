<template>
    <div class="upcoming-movies">
      <h1>Próximos Estrenos</h1>
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
    padding: 20px;
    background-color: #1c2b36;
    color: white;
    width: 100%;
    text-align: center;
  }
  
  .upcoming-movies h1 {
    margin-bottom: 20px;
    font-size: 2em;
  }
  
  .movies-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr); 
    gap: 20px; 
    max-width: 1200px;
    margin: 0 auto;
  }
  
  .movie-card {
    background: #2c3e50;
    border-radius: 10px;
    padding: 15px;
    text-align: center;
  }
  
  .movie-card img {
    width: 100%;
    max-width: 300px;
    height: auto;
    border-radius: 10px;
  }
  
  .movie-card h3 {
    margin-top: 10px;
    font-size: 1.5em;
    color: #ffcc00;
  }
  
  .movie-card p {
    margin-top: 5px;
    font-size: 1em;
    color: #ccc;
  }
  </style>