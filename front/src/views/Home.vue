<template>
  <div class="home">
    <CarruselPelis />
    <ProximasPelis />
  </div>
</template>

<script setup>
import CarruselPelis from '@/components/CarruselPelis.vue'; 
import ProximasPelis from '@/components/ProximasPelis.vue'; 
</script>

<style scoped>
.home {
  padding: 10px;
  max-width: 1200px;
  margin: 0 auto;
}

@media (max-width: 768px) {
  .home {
    padding: 5px;
  }
}
</style>