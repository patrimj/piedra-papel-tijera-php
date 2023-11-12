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
        Schema::create('partidas', function (Blueprint $table) {
            $table->id()->unique()->autoIncrement();
            $table->unsignedBigInteger('usuario_id');
            $table->boolean('finalizada')->default(0);
            $table->enum('resultado', ['ganada', 'perdida', 'empate'])->nullable();
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partidas');
    }
};
