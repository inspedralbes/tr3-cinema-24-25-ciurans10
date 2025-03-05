<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pelis', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('poster_path');
            $table->text('overview')->default('Sin descripción disponible')->change();  
            $table->date('release_date'); 
            $table->decimal('vote_average', 3, 2)->default(0.00); 
            $table->decimal('price', 8, 2)->default(0.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelis');
    }
};
