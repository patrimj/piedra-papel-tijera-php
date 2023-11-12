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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('partidas_ganadas')->default(0);
            $table->integer('partidas_jugadas')->default(0);
            $table->tinyInteger('rol')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');

    }
};
