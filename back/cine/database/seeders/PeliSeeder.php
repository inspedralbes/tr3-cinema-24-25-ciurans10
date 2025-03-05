<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Peli;

class PeliSeeder extends Seeder
{
    public function run(): void
    {
        $apiKey = 'fdf961e48b3b6bc9aa35095abb5a8d86';  
        $url = "https://api.themoviedb.org/3/movie/popular?api_key={$apiKey}&language=es-ES&page=1"; 

        $response = Http::withOptions(['verify' => false])->get($url); 
        $movies = $response->json()['results'] ?? [];  

        foreach ($movies as $movie) {
            Peli::create([
                'title' => $movie['title'],  
                'poster_path' => "https://image.tmdb.org/t/p/w500" . $movie['poster_path'], 
                'overview' => $movie['overview'] ?? 'Sin descripción disponible',  
                'release_date' => $movie['release_date'] ?? null,  
                'vote_average' => $movie['vote_average'] ?? 0,  
                'price' => rand(5, 8),  
            ]);
        }
    }
}
