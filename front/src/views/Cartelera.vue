<template>
    <div>
      <h2>Cartelera de Películas</h2>
  
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
  
      <p v-else>No se encontraron películas</p>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  
  const movies = ref([]);
  
  const fetchMoviesFromDatabase = async () => {
    try {
      const response = await fetch('http://localhost:8000/api/pelis'); 
      if (!response.ok) {
        throw new Error('Error al obtener las películas desde la base de datos');
      }
  
      const data = await response.json();
      movies.value = data; 
  
    } catch (error) {
      console.error('Error al obtener las películas:', error);
    }
  };
  
  onMounted(fetchMoviesFromDatabase);
  </script>
  
  <style scoped>
  .movie-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-top: 20px;
  }
  
  .movie-card {
    background-color: #4b4444;
    padding: 16px;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden; 
  }
  
  .movie-link {
    display: block;
    color: inherit; 
    text-decoration: none;
  }
  
  .movie-image-container {
    position: relative;
  }
  
  .movie-poster {
    width: 100%;
    height: auto;
    max-width: 150px;
    transition: opacity 0.3s ease, transform 0.3s ease;
  }
  
  .movie-card:hover .movie-poster {
    opacity: 0.7; /* Oscurece la imagen */
    transform: scale(1.05); /* Ligeramente aumenta el tamaño de la imagen */
  }
  
  .overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    text-align: center;
    font-size: 18px;
    opacity: 0;
    transition: opacity 0.3s ease;
  }
  
  .movie-card:hover .overlay {
    opacity: 1; /* Muestra la superposición con el título y horario al pasar el mouse */
  }
  
  .overlay h3 {
    font-size: 24px;
    margin: 0;
  }
  
  .overlay p {
    font-size: 16px;
  }
  </style>
  