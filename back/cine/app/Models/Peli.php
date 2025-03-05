<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peli extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'poster_path', 'overview', 'release_date', 'vote_average', 'price'];
}
