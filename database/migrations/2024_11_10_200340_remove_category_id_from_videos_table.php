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
        Schema::table('videos', function (Blueprint $table) {
            // Eliminar la clave foránea antes de eliminar la columna
            $table->dropForeign(['category_id']);
            // Luego eliminar la columna
            $table->dropColumn('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            // En caso de revertir, agregar de nuevo la columna 'category_id'
            $table->unsignedBigInteger('category_id')->nullable();
            // Y restaurar la clave foránea
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }
};
