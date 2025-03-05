<template>
    <div class="seat-selection">
      <h1>Selecciona tus butacas</h1>
      <div class="main-content">
        
        <div class="seats-container">
          <div class="row" v-for="(row, rowIndex) in seats" :key="rowIndex">
            <div
              class="seat"
              v-for="(seat, seatIndex) in row"
              :key="seatIndex"
              :class="{
                available: seat === 0,
                selected: seat === 1,
                occupied: seat === 2,
                vip: rowIndex === 5 && seat === 0
              }"
              @click="toggleSeat(rowIndex, seatIndex)"
            >
              {{ String.fromCharCode(65 + rowIndex) }}{{ seatIndex + 1 }}
            </div>
          </div>
        </div>
       
        <div class="right-sidebar">
          <div class="legend">
            <div><span class="occupied"></span> Ocupades</div>
            <div><span class="available"></span> Disponibles</div>
            <div><span class="selected"></span> Seleccionades per l'usuari</div>
          </div>
          <button class="confirm-button" @click="confirmSelection" :disabled="selectedSeats.length === 0">
            Confirmar selección
          </button>
        </div>
      </div>
      
      <div class="selected-seats">
        <h3>Butacas seleccionadas:</h3>
        <ul>
          <li v-for="(seat, index) in selectedSeats" :key="index">
            Butaca {{ seat }}
          </li>
        </ul>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const seats = ref(Array.from({ length: 12 }, () => Array(10).fill(0)));
  const selectedSeats = ref([]);
  
  const toggleSeat = (rowIndex, seatIndex) => {
    const seatNumber = `${String.fromCharCode(65 + rowIndex)}${seatIndex + 1}`;
  
    if (seats.value[rowIndex][seatIndex] === 0) {
      seats.value[rowIndex][seatIndex] = 1;
      selectedSeats.value.push(seatNumber);
    } else if (seats.value[rowIndex][seatIndex] === 1) {
      seats.value[rowIndex][seatIndex] = 0;
      const index = selectedSeats.value.indexOf(seatNumber);
      if (index !== -1) selectedSeats.value.splice(index, 1);
    }
  };
  
  const confirmSelection = () => {
    alert(`Butacas seleccionadas: ${selectedSeats.value.join(', ')}`);
  };
  </script>
  
  <style scoped>
  .seat-selection {
    padding: 20px;
    text-align: center;
    position: relative;
    min-height: 100vh;
    padding-bottom: 100px; /* Añadido para dejar espacio al contenido fijado */
  }
  
  /* Contenedor principal para flexbox */
  .main-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    flex-wrap: wrap;
  }
  
  /* Contenedor de butacas */
  .seats-container {
    display: flex;
    flex-direction: column;
    gap: 5px;
    margin: 20px 0;
    flex-wrap: wrap;
    justify-content: center;
    max-height: 500px;
    overflow-y: auto;
    width: 70%;
  }
  
  .row {
    display: flex;
    justify-content: center;
    gap: 5px;
  }
  
  .seat {
    width: 30px;
    height: 30px;
    background-color: #ccc;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
    font-size: 12px;
  }
  
  .seat.available:hover {
    background-color: #4caf50;
  }
  
  .seat.selected {
    background-color: #ffc107;
  }
  
  .seat.occupied {
    background-color: #f44336;
  }
  
  .seat.vip {
    background-color: #dceb0f;
  }
  
  /* Contenedor de la leyenda y el botón */
  .right-sidebar {
    width: 25%;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 20px;
  }
  
  .legend {
    margin-top: 20px;
    font-size: 14px;
  }
  
  .legend div {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
  }
  
  .legend span {
    width: 20px;
    height: 20px;
    display: inline-block;
    margin-right: 10px;
    border-radius: 5px;
  }
  
  .legend .occupied {
    background-color: #f44336; /* Rojo */
  }
  
  .legend .available {
    background-color: #ccc; /* Gris */
  }
  
  .legend .selected {
    background-color: #ffc107; /* Amarillo */
  }
  
  /* Estilos para las butacas seleccionadas (fijas abajo) */
  .selected-seats {
    position: fixed;
    left: 0;
    bottom: 0;
    height: 100px;
    width: 100%;
    background-color: #2c3e50;
    color: white;
    padding: 10px;
    box-shadow: 0px -2px 10px rgba(0, 0, 0, 0.1);
    font-size: 16px;
  }
  
  .selected-seats h3 {
    margin: 0;
    font-size: 18px;
  }
  
  .selected-seats ul {
    list-style-type: none;
    padding: 0;
    margin: 5px 0;
    display: flex;
    gap: 10px;
    overflow-x: auto;
  }
  
  .selected-seats li {
    font-size: 14px;
    background-color: #f39c12;
    padding: 5px;
    border-radius: 5px;
  }
  
  .confirm-button {
    padding: 10px 20px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    margin-top: 20px;
  }
  
  .confirm-button:hover {
    background-color: #218838;
  }
  
  .confirm-button:disabled {
    background-color: #d6d6d6;
    cursor: not-allowed;
  }
  </style>
  