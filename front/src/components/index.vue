<script setup>
import { ref, onMounted } from 'vue';

const movies = ref([]);

const randomMovieIds = [
    'tt0111161', 
    'tt0068646', 
    'tt0071562', 
    'tt0468569',
    'tt0050083', 
    'tt0108052', 
    'tt0167260', 
    'tt0110912', 
    'tt0137523', 
    'tt1375666'  
];

const fetchRandomMovies = async () => {
    try {
        const randomIds = [];
        while (randomIds.length < 4) {
            const randomMovieId = randomMovieIds[Math.floor(Math.random() * randomMovieIds.length)];
         
            if (!randomIds.includes(randomMovieId)) {
                randomIds.push(randomMovieId);
            }
        }

        const movieRequests = randomIds.map(id =>
            fetch(`http://www.omdbapi.com/?i=${id}&apikey=fa7a736b`).then(response => response.json())
        );

        const movieData = await Promise.all(movieRequests);

        movies.value = movieData;

        saveMoviesToDatabase(movieData);  

    } catch (error) {
        console.error('Error al obtener las películas:', error);
    }
};

const saveMoviesToDatabase = async (movieData) => {
    for (const movie of movieData) {
        try {
            const response = await fetch('http://localhost:8000/api/pelis', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    title: movie.Title,
                    poster: movie.Poster
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

onMounted(fetchRandomMovies);
</script>
