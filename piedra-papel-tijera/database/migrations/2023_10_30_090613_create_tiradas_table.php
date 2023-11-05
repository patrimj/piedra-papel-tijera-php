<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tiradas', function (Blueprint $table) {
            $table->id()->unique()->autoIncrement();
            $table->unsignedBigInteger('partida_id');
            $table->unsignedBigInteger('usuario_id');
            $table->enum('tirada_jugador1', ['piedra', 'papel', 'tijera']);
            $table->enum('tirada_jugador2', ['piedra', 'papel', 'tijera']);
            $table->enum('resultado', ['ganada', 'perdida']) ->default(null);
            $table->foreign('partida_id')->references('id')->on('partidas')->onDelete('cascade'); 
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiradas');
    }
};
