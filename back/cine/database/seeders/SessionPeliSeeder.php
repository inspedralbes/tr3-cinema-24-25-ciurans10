<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\SessionPeli;

class SessionPeliSeeder extends Seeder
{
    public function run(): void
    {
        $apiKey = 'fdf961e48b3b6bc9aa35095abb5a8d86';
        
        $url = "https://api.themoviedb.org/3/movie/popular?api_key={$apiKey}&language=es-ES&page=1";
        
        $response = Http::withOptions(['verify' => false])->get($url);

        $allMovies = $response->json()['results'] ?? [];

        $movies = array_slice($allMovies, 0, 9); 

        $sessionTimes = ['16:00', '18:00', '20:00'];

        foreach ($movies as $movie) {

            foreach ($sessionTimes as $time) {
                SessionPeli::create([
                    'title' => $movie['title'],
                    'date' => now()->format('Y-m-d'),  
                    'time' => $time,                 
                    'poster_path' => "https://image.tmdb.org/t/p/w500" . $movie['poster_path'],       
                ]);
            }
        }
    }
}
