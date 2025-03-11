<template>
  <div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-blue-400 to-purple-500">
    <div class="w-full max-w-lg bg-white shadow-2xl rounded-xl p-8 transform transition duration-300 hover:scale-105">
      <h2 class="text-3xl font-bold text-center text-gray-800 mb-6"> Confirmació d'entrada</h2>
      
      <div v-if="ticket" class="space-y-4 text-gray-700 text-lg">
        <p><strong> Nom:</strong> <span class="text-gray-900">{{ ticket.nombre }}</span></p>
        <p><strong> Cognom:</strong> <span class="text-gray-900">{{ ticket.apellido }}</span></p>
        <p><strong> Telèfon:</strong> <span class="text-gray-900">{{ ticket.telefono }}</span></p>
        <p><strong> Asientos:</strong> <span class="font-semibold text-blue-600">{{ ticket.seats.join(", ") }}</span></p>
      </div>
      
      <div v-else class="text-gray-500 text-center text-lg">Cargando información...</div>
      
      <div v-if="ticket" class="flex justify-between mt-6">
        <button @click="confirm" class="w-1/2 bg-green-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-green-600 transform transition hover:scale-105">
           Confirmar
        </button>
        <button @click="cancel" class="w-1/2 bg-red-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-red-600 transform transition hover:scale-105 ml-4">
           Cancelar
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const ticket = ref(null);

onMounted(() => {
 
  const storedTicket = sessionStorage.getItem('ticketData');
  if (storedTicket) {
    ticket.value = JSON.parse(storedTicket);
  } else {
    console.error('No se encontró el ticket en sessionStorage');
  }
});

const confirm = () => {
  console.log("Entrada confirmada:", ticket.value);
};

const cancel = () => {
  console.log("Reserva cancelada");
  router.push({ path: "/butacas" });
};

</script>

<style scoped>
h2{
  color: white;
}

p{
  color:white;
}
</style>
