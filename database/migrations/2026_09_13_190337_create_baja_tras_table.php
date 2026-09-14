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
    Schema::create('baja_tras', function (Blueprint $table) {
        $table->id('id_baja');
        $table->unsignedBigInteger('id_equipo');
        $table->date('fecha');
        $table->string('tecnico', 150);
        $table->decimal('años_uso', 4, 1)->nullable();
        $table->string('estado', 50);
        $table->string('solicitar_equipo', 10)->default('No');
        $table->text('descripcion')->nullable();
        $table->binary('foto')->nullable(); // Para almacenar la imagen en BLOB
        $table->timestamps();

        // Clave foránea con la tabla equipo
        $table->foreign('id_equipo')->references('id_equipo')->on('equipo')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baja_tras');
    }
};
