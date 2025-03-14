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
  padding: 20px;
  max-width: 1200px;
  margin: 0 auto;
}
</style>