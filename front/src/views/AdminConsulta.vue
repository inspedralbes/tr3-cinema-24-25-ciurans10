<template>
    <div class="admin-container">
      <h1>Consulta Administrativa (Ocupació i Recaptació)</h1>
      
      <div class="date-picker">
        <label for="fecha">Selecciona un dia:</label>
        <input type="date" id="fecha" v-model="selectedDate" @change="cargarDatosFecha">
      </div>
      
      <div v-if="datosCargados" class="dashboard">
        <!-- Mapa de ocupación -->
        <div class="seccion">
          <h2>Mapa d'ocupació de butaques</h2>
          <div class="sala-cine">
            <div class="pantalla">Pantalla</div>
            <div class="butacas-grid">
              <div v-for="(fila, index) in filas" :key="index" class="fila">
                <span class="fila-label">{{ fila }}</span>
                <div v-for="butaca in butacasPorFila" :key="butaca" 
                     class="butaca-admin"
                     :class="{
                       'ocupada': esButacaOcupada(fila + butaca),
                       'vip': fila === 'F',
                       'ocupada-vip': fila === 'F' && esButacaOcupada(fila + butaca)
                     }">
                  {{ butaca }}
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Informe de recaudación -->
        <div class="seccion">
          <h2>Informe de recaptació</h2>
          <div class="resumen">
            <div class="resumen-item">
              <h3>Entrades Normals</h3>
              <p>Quantitat: {{ resumen.normal.cantidad }}</p>
              <p>Recaptació: {{ resumen.normal.recaudacion }}€</p>
            </div>
            <div class="resumen-item">
              <h3>Entrades VIP</h3>
              <p>Quantitat: {{ resumen.vip.cantidad }}</p>
              <p>Recaptació: {{ resumen.vip.recaudacion }}€</p>
            </div>
            <div class="resumen-total">
              <h3>Recaptació Total</h3>
              <p>{{ resumen.total }}€</p>
            </div>
          </div>
        </div>
      </div>
      
      <div v-else class="cargando">
        <p>Cargant dades per la data seleccionada...</p>
      </div>
    </div>
  </template>
  
  <script>
import { communicationManager } from '@/services/CommunicationManager';

export default {
  data() {
    return {
      selectedDate: new Date().toISOString().split('T')[0],
      datosCargados: false,
      filas: ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'],
      butacasPorFila: 10,
      butacasOcupadas: [],
      resumen: {
        normal: {
          cantidad: 0,
          recaudacion: 0
        },
        vip: {
          cantidad: 0,
          recaudacion: 0
        },
        total: 0
      }
    };
  },
  methods: {
    async cargarDatosFecha() {
      try {
        this.datosCargados = false;
        
        const butacasData = await communicationManager.getButacasOcupadasPorFecha(this.selectedDate);
        this.butacasOcupadas = butacasData.ocupadas || [];
        
        const resumenData = await communicationManager.getResumenRecaudacion(this.selectedDate);
        this.resumen = resumenData;
        
        this.datosCargados = true;
      } catch (error) {
        console.error('Error al cargar datos:', error);
        
      }
    },
    
    esButacaOcupada(butacaId) {
      return this.butacasOcupadas.includes(butacaId);
    }
  },
  mounted() {
    this.cargarDatosFecha();
  }
};
</script>
  
  <style scoped>
  .admin-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    color: #333;
  }
  
  h1 {
    text-align: center;
    margin-bottom: 30px;
    color: white;
  }
  
  .date-picker {
    margin-bottom: 30px;
    text-align: center;
    color: white;
  }
  
  .date-picker label {
    margin-right: 10px;
    font-weight: bold;
  }
  
  .date-picker input {
    padding: 8px;
    border-radius: 4px;
    border: 1px solid #ddd;
  }
  
  .dashboard {
    display: flex;
    gap: 30px;
  }
  
  .seccion {
    flex: 1;
    background: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
  
  .sala-cine {
    margin-top: 20px;
  }
  
  .pantalla {
    text-align: center;
    background: #2c3e50;
    color: white;
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 4px;
  }
  
  .butacas-grid {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  
  .fila {
    display: flex;
    margin-bottom: 8px;
    align-items: center;
  }
  
  .fila-label {
    width: 20px;
    font-weight: bold;
    margin-right: 10px;
  }
  
  .butaca-admin {
    width: 30px;
    height: 30px;
    margin: 2px;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #e0e0e0;
    border-radius: 4px;
    font-size: 12px;
  }
  
  .butaca-admin.ocupada {
    background: #ff4444;
    color: white;
  }
  
  .butaca-admin.vip {
    background: #ffeb3b;
  }

  .butaca-admin.ocupada-vip {
  background: #ff4444;
  color: white;
  }
  
  .resumen {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-top: 20px;
  }
  
  .resumen-item, .resumen-total {
    flex: 1;
    min-width: 330px;
    background: white;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
  
  .resumen-total {
    background: #2c3e50;
    color: white;
    flex-basis: 100%;
    text-align: center;
  }
  
  .resumen-total h3 {
    margin-top: 0;
  }
  
  .resumen-item h3 {
    margin-top: 0;
    color: #2c3e50;
    border-bottom: 1px solid #eee;
    padding-bottom: 8px;
  }
  
  .cargando {
    text-align: center;
    padding: 40px;
    font-size: 18px;
  }

  @media screen and (max-width: 768px) {
  .dashboard {
    flex-direction: column;
  }

  .resumen {
    flex-direction: column; 
  }

  .resumen-item, .resumen-total {
    width: 100%; 
  }
}
  </style>