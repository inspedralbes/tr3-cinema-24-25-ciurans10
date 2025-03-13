<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionPelisTable extends Migration
{
    public function up()
    {
        Schema::create('session_pelis', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date');
            $table->string('time');
            $table->string('poster_path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sessions_pelis');
    }
}

