<template>
  <div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-blue-400 to-purple-500">
    <div class="w-full max-w-lg bg-white shadow-2xl rounded-xl p-8 transform transition duration-300 hover:scale-105">
      <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Confirmació d'entrada</h2>
      
      <div v-if="ticket" class="space-y-4 text-gray-700 text-lg">
        <p><strong>Nom:</strong> <span class="text-gray-900">{{ ticket.nombre }}</span></p>
        <p><strong>Cognom:</strong> <span class="text-gray-900">{{ ticket.apellido }}</span></p>
        <p><strong>Telèfon:</strong> <span class="text-gray-900">{{ ticket.telefono }}</span></p>
        <p><strong>Asiento:</strong> <span class="font-semibold text-blue-600">{{ ticket.seats.join(", ") }}</span></p>
        <p><strong>Data:</strong> <span class="text-gray-900">{{ ticket.selectedDate }}</span></p>
        <p><strong>Horari:</strong> <span class="text-gray-900">{{ ticket.sessionTime }}</span></p>
        <p><strong>Preu:</strong> <span class="text-gray-900">{{ ticket.total }}€</span></p>
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
  const storedPurchases = JSON.parse(sessionStorage.getItem('ticketData')) || [];
  
  if (Array.isArray(storedPurchases) && storedPurchases.length > 0) {
    const lastPurchase = storedPurchases[storedPurchases.length - 1]; 
    ticket.value = lastPurchase || null;
  } else {
    console.error('No se encontró el ticket en sessionStorage');
  }
});

const confirm = async () => {
  try {
    
    if (!ticket.value || !ticket.value.nombre || !ticket.value.apellido) {
      console.error('Faltan datos del ticket');
      return;
    }

    console.log("Entrada confirmada:", ticket.value);

    const ticketData = {
      nombre: ticket.value.nombre,
      apellido: ticket.value.apellido,
      telefono: ticket.value.telefono,
      seats: ticket.value.seats,
      selectedDate: ticket.value.selectedDate,
      sessionTime: ticket.value.sessionTime,
      total: ticket.value.total
    };

    const response = await fetch('http://localhost:8000/api/entradas', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify(ticketData)
});


    if (response.ok) {
      const responseData = await response.json();
      console.log('Entrada guardada en la base de datos:', responseData);
      alert("¡Entrada comprada correctamente!");
    } else {
      console.error('Error al guardar la entrada:', response.status);
    }
  } catch (error) {
    console.error('Error en la solicitud fetch:', error);
  }
};

const cancel = () => {
  let storedPurchases = JSON.parse(sessionStorage.getItem('ticketData')) || [];
  storedPurchases.pop(); 
  sessionStorage.setItem('ticketData', JSON.stringify(storedPurchases));
  router.push({ path: "/butacas" });
};
</script>

<style scoped>
h2 {
  color: white;
}

p {
  color: white;
}
</style>
