<template>
    <div class="movie-carousel">
      <h1>Pelicules Populars</h1>
      <swiper
        :slidesPerView="3"
        :spaceBetween="30"
        :pagination="{ clickable: true }"
        :navigation="true"
        :modules="modules"
        class="mySwiper"
      >
          <swiper-slide v-for="movie in movies.slice(0, 10)" :key="movie.id">
          <img :src="'https://image.tmdb.org/t/p/w500' + movie.poster_path" :alt="movie.title" />
          <h3>{{ movie.title }}</h3>
        </swiper-slide>
      </swiper>
    </div>
  </template>
  
  <script setup>
import { ref, onMounted } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/swiper-bundle.css';
import { communicationManager } from '@/services/CommunicationManager';

const movies = ref([]);
const modules = [Navigation, Pagination];

onMounted(async () => {
  try {
 
    const originalBaseUrl = communicationManager.baseUrl;
    communicationManager.baseUrl = 'https://api.themoviedb.org/3';
    
    const data = await communicationManager.get(
      '/movie/popular?api_key=fdf961e48b3b6bc9aa35095abb5a8d86&language=es-ES&page=1'
    );
    
    movies.value = data.results;
    
    communicationManager.baseUrl = originalBaseUrl;
  } catch (error) {
    console.error('Error al obtener películas populares:', error);
    
  }
});
</script>
  
  <style scoped>
  .movie-carousel {
    padding: 20px;
    background-color: #1c2b36;
    color: white;
  }
  
  .movie-carousel h2 {
    text-align: center;
    margin-bottom: 20px;
  }
  
  .swiper {
    width: 100%;
    height: 100%;
  }
  
  .swiper-slide {
    text-align: center;
    font-size: 18px;
    background: #1c2b36;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }
  
  .swiper-slide img {
    width: 100%;
    height: auto;
    border-radius: 10px;
  }
  
  .swiper-slide h3 {
    margin-top: 10px;
    font-size: 1.2em;
  }
  </style>