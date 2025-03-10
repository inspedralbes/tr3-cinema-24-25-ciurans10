<template>
  <div class="contenedor">
      <h1>Selecciona les teves butaques</h1>

     
  </div>
</template>

<script>
import { useRouter } from 'vue-router';


</script>


<style scoped>
.contenedor {
  max-width: 1200px;
  margin: 2rem auto;
  padding: 20px;
}

.butacas-container {
  background: #d0e1f2;
  padding: 2rem;
  border-radius: 12px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.estado-butacas {
  display: flex;
  gap: 1.5rem;
  justify-content: center;
  margin: 1rem 0 2rem;
}

.leyenda-item span {
  display: inline-block;
  width: 20px;
  height: 20px;
  margin-right: 8px;
  border-radius: 3px;
}

.vip {
  background: #FFC107;
}

.disponible {
  background: gray;
}

.seleccionada {
  background: #0ddd2f;
}

.ocupada {
  background: red;
  cursor: not-allowed;
}

.butacas-grid {
  display: grid;
  grid-template-columns: repeat(10, 1fr);
  gap: 8px;
  margin: 2rem 0;
}

.butaca {
  padding: 12px;
  text-align: center;
  border-radius: 4px;
  cursor: pointer;
  transition: transform 0.2s;
  background: gray;
  color: white;
}

.butaca.vip {
  background: #FFC107;
}

.butaca.ocupada {
  background: red;
  cursor: not-allowed;
}

.butaca.seleccionada {
  background: #0ddd2f;
  transform: scale(1.1);
}

.info-seleccion {
  margin: 1.5rem 0;
  font-size: 1.1rem;
}

.detalles-extra {
  margin-top: 0.5rem;
  display: flex;
  gap: 1rem;
  justify-content: center;
  color: #666;
}

button {
  background: #673AB7;
  padding: 12px 30px;
  font-size: 1.1rem;
  transition: all 0.3s;
}

button:hover:not(:disabled) {
  background: #512DA8;
  transform: translateY(-2px);
}

.codigo-notario {
  word-break: break-all;
  background: #eee;
  padding: 1rem;
  border-radius: 6px;
  font-family: monospace;
}
</style>