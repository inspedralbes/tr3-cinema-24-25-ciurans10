<script setup>
import { ref, onMounted } from 'vue';

const movies = ref([]);

const apiUrl = "https://api.themoviedb.org/3/movie/popular?api_key=fdf961e48b3b6bc9aa35095abb5a8d86&language=es-ES&page=1";

const fetchPopularMovies = async () => {
    try {
        const response = await fetch(apiUrl);
        const data = await response.json();

        movies.value = data.results;

    } catch (error) {
        console.error('Error al obtener las películas populares:', error);
    }
};

const saveMoviesToDatabase = async () => {
    for (const movie of movies.value) {
        try {
            const response = await fetch('http://localhost:8000/api/pelis', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    title: movie.title,   
                    poster: `https://image.tmdb.org/t/p/w500${movie.poster_path}`, 
                    price: movie.vote_average ? parseFloat(movie.vote_average) : 0 
                }),
            });

            if (!response.ok) {
                throw new Error('Error al guardar la película');
            }

            const data = await response.json();
            console.log('Película guardada:', data);
        } catch (error) {
            console.error('Error al guardar la película:', error);
        }
    }
};

onMounted(fetchPopularMovies);
</script>

<template>
    <div>
        <h2>Películas Populares</h2>

        <button @click="saveMoviesToDatabase">Guardar películas</button>

        <div v-if="movies.length" class="movie-grid">
            <div v-for="movie in movies" :key="movie.id" class="movie-card">
                <h3>{{ movie.title }} ({{ movie.release_date.split('-')[0] }})</h3>
                <img :src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`" alt="Poster de la película" class="movie-poster">
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
