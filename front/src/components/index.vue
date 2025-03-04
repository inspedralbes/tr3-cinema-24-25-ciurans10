<script setup>
import { ref, onMounted } from 'vue';

const movies = ref([]);

const fetchMoviesFromDatabase = async () => {
    try {
        const response = await fetch('http://localhost:8000/api/pelis'); 
        if (!response.ok) {
            throw new Error('Error al obtener las películas desde la base de datos');
        }

        const data = await response.json();
        movies.value = data; 

    } catch (error) {
        console.error('Error al obtener las películas:', error);
    }
};

onMounted(fetchMoviesFromDatabase);
</script>

<template>
    <div>
        <h2>Películas Populares</h2>

        <div v-if="movies.length" class="movie-grid">
            <div v-for="movie in movies" :key="movie.id" class="movie-card">
                <h3>{{ movie.title }}</h3>
                <img :src="movie.poster" alt="Poster de la película" class="movie-poster">
            </div>
        </div>

        <p v-else>No se encontraron películas</p>
    </div>
</template>

<style scoped>
.movie-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr); 
    gap: 16px;
    margin-top: 20px;
}

.movie-card {
    background-color: #f8f8f8;
    padding: 16px;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.movie-poster {
    width: 100%;
    height: auto;
    max-width: 150px;
    margin-top: 8px;
}
</style>
