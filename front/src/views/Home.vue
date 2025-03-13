<template>
  <div class="home">
    <MovieCarousel />
    <UpcomingMovies />
  </div>
</template>

<script setup>
import MovieCarousel from '@/components/MovieCarousel.vue'; 
import UpcomingMovies from '@/components/UpcomingMovies.vue'; 
</script>

<style scoped>
.home {
  padding: 20px;
  max-width: 1200px;
  margin: 0 auto;
}
</style>