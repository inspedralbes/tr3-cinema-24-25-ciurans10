<template>
  <div class="contenedor">
    <h1>Selecciona les teves butaques</h1>

    <div v-if="esDiaDelEspectador()" class="dia-espectador">
      <p>¡Avui és dia del espectador! Preus reduïts: 4€ (normals) i 6€ (VIP).</p>
    </div>

    <div class="leyenda">
      <div class="leyenda-item">
        <div class="color-box vermell"></div>
        <span>Ocupades</span>
      </div>
      <div class="leyenda-item">
        <div class="color-box gris"></div>
        <span>Disponibles</span>
      </div>
      <div class="leyenda-item">
        <div class="color-box groc"></div>
        <span>VIP</span>
      </div>
      <div class="leyenda-item">
        <div class="color-box verd"></div>
        <span>Seleccionades per l'usuari</span>
      </div>
    </div>

    <div class="butacas-info">
      <!-- Butaques -->
      <div class="butacas-container">
        <div v-for="(fila, index) in filas" :key="index" class="fila">
          <span class="fila-label">{{ fila }}</span>
          <div v-for="butaca in butacasPorFila" :key="butaca" class="butaca" 
          :class="{
  seleccionada: butaquesSeleccionades.includes(fila + butaca), 
  ocupada: butacasOcupadas.includes(fila + butaca),
  seleccionadaPorOtro: butacasSeleccionadasPorOtros.includes(fila + butaca),
  'butaca-amarilla': fila === 'F' && !butacasOcupadas.includes(fila + butaca) && !butaquesSeleccionades.includes(fila + butaca)
}"
    @click="toggleButaca(fila, butaca)">
    <svg fill="#ffffff" height="30px" width="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" stroke="#ffffff">
      <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
      <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
      <g id="SVGRepo_iconCarrier"> 
        <g> 
          <g> 
            <path d="M460.058,207.774v-89.116C460.058,53.103,406.904,0,341.349,0H170.651C105.096,0,51.942,53.103,51.942,118.658v89.115 c-27.208,0.753-49.469,23.185-49.469,50.669v235.234c0,10.246,8.306,18.323,18.551,18.323H131.76 c10.245,0,19.12-8.077,19.12-18.322v-5.176h210.242v5.176c0,10.245,8.875,18.322,19.12,18.322h110.735 c10.245,0,18.551-8.077,18.551-18.322V258.444C509.527,230.959,487.266,208.527,460.058,207.774z M113.778,474.899H39.575V258.444 c0-7.502,6.103-13.574,13.604-13.574h46.426c7.501,0,14.173,6.072,14.173,13.574V474.899z M361.121,451.401H150.879v-92.754 h210.242V451.401z M361.121,258.444v35.894H150.879v-35.894c0-27.96-23.316-50.676-51.274-50.676H89.043v-89.11 c0-45.097,36.51-81.556,81.607-81.556h170.698c45.098,0,81.608,36.46,81.608,81.556v89.11h-10.562 C384.437,207.768,361.121,230.484,361.121,258.444z M472.425,474.899h-74.203V258.444c0-7.501,6.672-13.574,14.173-13.574h46.426 c7.501,0,13.604,6.072,13.604,13.574V474.899z"></path> 
          </g> 
        </g> 
      </g>
    </svg>
</div>

        </div>
      </div>

      <!-- Informació de selecció -->
      <div class="info-seleccio">
        <h2>Informació de la compra</h2>
        <p>Butaques seleccionades: {{ butaquesSeleccionades.join(', ') }}</p>
        <p>Data: {{ selectedDate }}</p>
        <p>Hora: {{ sessionTime }}</p>
        <p>Titulo: {{ title }}</p>
        <p>Preu total: {{ precioTotal }}€</p>

        <button 
          :disabled="butaquesSeleccionades.length === 0" 
          @click="checkPreviousPurchase">
          Confirmar selecció
        </button>

        <!-- Formulari de dades -->
        <div v-if="mostrarFormulario" class="formulario"> 
          <h2>Introdueix les teves dades</h2>
          <label>Nom:</label>
          <input type="text" v-model="nombre" placeholder="El teu nom" />
          <label>Cognom:</label>
          <input type="text" v-model="apellido" placeholder="El teu cognom" />
          <label>Email:</label>
          <input type="email" v-model="email" placeholder="El teu email" />
          <button @click="enviarDatos">Enviar</button>
        </div>

        <div v-if="errorMessage" class="error-message">
          <p>{{ errorMessage }}</p>
          <div v-if="previousPurchase">
            <h3>Compra anterior:</h3>
            <p>Butaques: {{ previousPurchase.seats.join(', ') }}</p>
            <p>Nom: {{ previousPurchase.nombre }} {{ previousPurchase.apellido }}</p>
            <p>Email: {{ previousPurchase.email }}</p> 
          </div>
        </div>
      </div>
    </div>
  </div>  
</template>

<script>
import { useRoute, useRouter } from 'vue-router';
import Swal from 'sweetalert2';
import io from 'socket.io-client';

export default {
  data() {
    return {
      filas: ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'],
      butacasPorFila: 10,
      butaquesSeleccionades: [],
      butacasOcupadas: [],
      butacasSeleccionadasPorOtros: [], 
      precioTotal: 0,
      mostrarFormulario: false,
      nombre: '',
      apellido: '',
      email: '',
      errorMessage: '',
      previousPurchase: null,
      usuarioAutenticado: false,
      socket: null, 
    };
  },
  setup() {
    const route = useRoute();
    const router = useRouter();

    return {
      route,
      router,
    };
  },
  computed: {
    peliculaId() {
      return this.route.params.movieId;
    },
    sessionTime() {
      return this.route.params.sessionTime;
    },
    selectedDate() {
      return this.route.params.selectedDate;
    },
    title() {
    return this.route.params.title || 'Película desconocida';
  }
  },
  created() {
    this.verificarSesion();
    this.cargarButacasOcupadas();
    this.iniciarSocket();
  },
  methods: {
    iniciarSocket() {
      this.socket = io('http://localhost:3000');

      this.socket.on('butacas-actualizadas', (butacasSeleccionadas) => {
        this.butacasSeleccionadasPorOtros = butacasSeleccionadas
          .filter(([butaca, usuario]) => usuario !== this.socket.id)
          .map(([butaca]) => butaca);
      });

      this.socket.on('butaca-seleccionada', (butaca) => {
        if (!this.butaquesSeleccionades.includes(butaca)) {
          this.butaquesSeleccionades.push(butaca);
          const fila = butaca[0];
          const butacaNum = butaca.slice(1);
          const precioNormal = this.esDiaDelEspectador() ? 4 : 6;
          const precioVIP = this.esDiaDelEspectador() ? 6 : 8;
          const precio = fila === 'F' ? precioVIP : precioNormal;
          this.precioTotal += precio;
        }
      });

      this.socket.on('butaca-no-disponible', (butaca) => {
        Swal.fire({
          icon: 'error',
          title: 'Butaca no disponible',
          text: 'La butaca ya está seleccionada por otro usuario.',
        });
      });

      this.socket.on('deseleccionar-butaca', (butaca) => {
        this.butacasSeleccionadasPorOtros = this.butacasSeleccionadasPorOtros.filter(b => b !== butaca);
      });
    },
    async cargarButacasOcupadas() {
      try {
        const response = await fetch('http://localhost:8000/api/butacas-ocupadas');
        if (response.ok) {
          const data = await response.json();
          this.butacasOcupadas = data.ocupadas || [];
        } else {
          console.error('Error al cargar las butacas ocupadas');
        }
      } catch (error) {
        console.error('Error en la solicitud de butacas ocupadas:', error);
      }
    },
    verificarSesion() {
      const token = localStorage.getItem('token');
      this.usuarioAutenticado = !!token;
    },
    toggleButaca(fila, butaca) {
      const butacaId = fila + butaca;

      if (this.butacasOcupadas.includes(butacaId)) {
        return;
      }

      if (!this.usuarioAutenticado) {
        Swal.fire({
          icon: 'warning',
          title: 'Inicia sesión',
          text: 'Debes iniciar sesión para seleccionar butacas.',
        });
        return;
      }

      if (this.butaquesSeleccionades.length >= 10 && !this.butaquesSeleccionades.includes(butacaId)) {
        alert('Només pots seleccionar fins a 10 butaques.');
        return;
      }

      const index = this.butaquesSeleccionades.indexOf(butacaId);
      if (index === -1) {
        this.socket.emit('seleccionar-butaca', butacaId);
      } else {
        this.butaquesSeleccionades.splice(index, 1);
        const precioNormal = this.esDiaDelEspectador() ? 4 : 6;
        const precioVIP = this.esDiaDelEspectador() ? 6 : 8;
        const precio = fila === 'F' ? precioVIP : precioNormal;
        this.precioTotal -= precio;
        this.socket.emit('deseleccionar-butaca', butacaId);
      }
    },
    async checkPreviousPurchase() {
      try {
        const token = localStorage.getItem('token');

        if (!token) {
          Swal.fire({
            icon: 'warning',
            title: 'Inicia sesión',
            text: 'Debes iniciar sesión para seleccionar butacas.',
          });
          return;
        }

        const response = await fetch('http://localhost:8000/api/verificar-compra', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
          },
          body: JSON.stringify({
            peliculaId: this.peliculaId,
            sessionTime: this.sessionTime,
          }),
        });

        if (response.ok) {
          const data = await response.json();

          if (data.existeCompra) {
            this.errorMessage = 'Ja tens entrades per aquesta sessió.';
            
            if (typeof data.compra.seats === 'string') {
              data.compra.seats = JSON.parse(data.compra.seats);
            }

            this.previousPurchase = data.compra;
          } else {
            this.errorMessage = '';
            this.previousPurchase = null;
            this.mostrarFormulario = true;
          }
        } else {
          console.error('Error al verificar la compra en la base de datos');
        }
      } catch (error) {
        console.error('Error en la solicitud de verificación de compra:', error);
      }
    },
    async enviarDatos() {
  if (!this.nombre || !this.apellido || !this.email) {
    alert('Si us plau, omple tots els camps.');
    return;
  }

  const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  if (!emailRegex.test(this.email)) {
    this.errorMessage = 'L\'email introduït no és vàlid.';
    return;
  } else {
    this.errorMessage = '';
  }

  const fechaHora = new Date().toLocaleString();

  const ticketData = {
    peliculaId: this.peliculaId,
    title: this.title,  
    sessionTime: this.sessionTime,
    selectedDate: this.selectedDate,
    nombre: this.nombre,
    apellido: this.apellido,
    email: this.email,
    seats: this.butaquesSeleccionades,
    total: this.precioTotal,
    fechaHora: fechaHora,
  };

  const token = localStorage.getItem('token');

  if (!token) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'No estás autenticado. Por favor, inicia sesión.',
    });
    return;
  }

  try {
    const response = await fetch('http://localhost:8000/api/entradas', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
      },
      body: JSON.stringify(ticketData),
    });

    if (response.ok) {
      const emailResponse = await fetch('http://localhost:3000/enviar-correo', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          correoDestinatario: this.email,
          nombreUsuario: this.nombre,
          title: this.title, 
          fecha: this.selectedDate, 
          hora: this.sessionTime, 
          butaquesSeleccionades: this.butaquesSeleccionades,
          precioTotal: this.precioTotal,
        }),
      });

      if (emailResponse.ok) {
        Swal.fire({
          icon: 'success',
          title: '¡Entrada comprada correctamente!',
          text: 'Tu compra se ha realizado con éxito y se ha enviado un correo de confirmación.',
          confirmButtonText: 'Aceptar',
        }).then(() => {
          this.router.push('/');
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Error al enviar el correo de confirmación.',
        });
      }
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Error al guardar la entrada en la base de datos.',
      });
    }
  } catch (error) {
    console.error('Error en la solicitud:', error);
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Hubo un problema al enviar los datos.',
    });
  }
},
    esDiaDelEspectador() {
      const selectedDate = new Date(this.selectedDate);
      return selectedDate.getDay() === 3;
    },
  }
};
</script>

<style scoped>
.contenedor {
  text-align: center;
  padding: 20px;
}

h1 {
  color: white;
}

.leyenda {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin-bottom: 20px;
  color: white;
}

.leyenda-item {
  display: flex;
  align-items: center;
  gap: 8px;
}

.color-box {
  width: 20px;
  height: 20px;
  border: 1px solid #ccc;
}

.vermell {
  background-color: #ff4444; 
}

.gris {
  background-color: #f0f0f0; 
}

.verd {
  background-color: #4CAF50; 
}

.groc{
  background-color: yellow;
}

.butaca svg {
  width: 30px;
  height: 30px;
}

.butacas-info {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-top: 20px;
}

.butacas-container {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.fila {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 10px;
  color: white;
}

.fila-label {
  margin-right: 10px;
  font-weight: bold;
}

.butaca {
  width: 30px;
  height: 30px;
  margin: 5px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  transition: fill 0.3s ease;
  color: white;
}

.butaca-amarilla svg{
  fill: yellow;
}

.butaca.seleccionada svg{
  fill: #4CAF50;
}

.butaca.ocupada svg{
  fill: #ff4444;
}

.butaca.seleccionadaPorOtro svg{
  fill: #2600ff;
}

.info-seleccio {
  margin-left: 80px;
  font-size: 18px;
  color: white;
  text-align: left;
}

button {
  padding: 12px 24px;
  background-color: #FFD700;
  color: #000;
  font-size: 1.2rem;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  margin-top: 20px;
  text-align: left;
}

button:disabled {
  background-color: #cccccc;
  cursor: not-allowed;
}

button:hover {
  background-color: #FFC107;
}

.formulario {
  background: rgba(0, 0, 0, 0.8);
  padding: 20px;
  border-radius: 10px;
  margin-top: 20px;
  color: white;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.formulario label {
  margin-top: 10px;
}

.formulario input {
  padding: 10px;
  margin-top: 5px;
  border-radius: 5px;
  border: none;
}

.error-message {
  background-color: #f8d7da;
  padding: 20px;
  color: #721c24;
  border-radius: 10px;
  margin-top: 20px;
}

.dia-espectador {
  background-color: #4CAF50;
  color: white;
  padding: 10px;
  border-radius: 5px;
  margin-bottom: 20px;
}
</style>