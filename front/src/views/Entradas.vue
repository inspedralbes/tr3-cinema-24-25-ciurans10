<template>
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg p-6">
      <h2 class="text-xl font-bold mb-4">Confirmación de Entradas</h2>
      <div v-if="ticket">
        <p><strong>Pelicula:</strong> {{ ticket.movie }}</p>
        <p><strong>Fecha:</strong> {{ ticket.date }}</p>
        <p><strong>Hora:</strong> {{ ticket.time }}</p>
        <p><strong>Asientos:</strong> {{ ticket.seats.join(", ") }}</p>
        <div class="flex justify-between mt-4">
          <button @click="confirm" class="bg-green-500 text-white px-4 py-2 rounded">Confirmar</button>
          <button @click="cancel" class="bg-red-500 text-white px-4 py-2 rounded">Cancelar</button>
        </div>
      </div>
      <p v-else class="text-gray-500">Cargando información...</p>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();
const ticket = ref(null);

onMounted(() => {
  if (route.query.ticket) {
    try {
      ticket.value = JSON.parse(route.query.ticket);
    } catch (error) {
      console.error("Error al analizar los datos del ticket:", error);
    }
  }
});

const confirm = () => {
  console.log("Entrada confirmada:", ticket.value);
};

const cancel = () => {
  console.log("Reserva cancelada");
  router.push({ name: "butacas" }); 
};
  </script>
  
  <style scoped>
  </style>
  