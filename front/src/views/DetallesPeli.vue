<template>
    <div class="movie-detail">
      <h2>{{ movie.title }}</h2>
      <img :src="movie.poster_path" alt="Poster de la película" class="movie-poster">
      <p>{{ movie.description }}</p>
      <button @click="buyTickets">Comprar Entradas</button>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { useRoute } from 'vue-router'; 
  
  const route = useRoute();
  const movie = ref({});
  
  const fetchMovieDetails = async () => {
    try {
      const response = await fetch(`http://localhost:8000/api/pelis/${route.params.id}`);
      if (!response.ok) {
        throw new Error('Error al obtener los detalles de la película');
      }
  
      const data = await response.json();
      movie.value = data;
    } catch (error) {
      console.error('Error al obtener los detalles:', error);
    }
  };
  
  onMounted(fetchMovieDetails);
  
  const buyTickets = () => {
    alert('Redirigiendo a la compra de entradas');
  };
  </script>
  
  <style scoped>
  .movie-detail {
    text-align: center;
  }
  
  .movie-poster {
    max-width: 300px;
    height: auto;
    margin-top: 20px;
  }
  
  button {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    margin-top: 20px;
    font-size: 18px;
  }
  
  button:hover {
    background-color: #218838;
  }
  </style>
  