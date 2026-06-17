<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carritos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('products')->onDelete('cascade');
            $table->string('nombre');
            $table->decimal('precio', 10, 2);
            $table->integer('cantidad')->default(1);
            $table->string('talle', 20)->default('Único');
            $table->string('imagen', 500)->nullable();
            $table->string('sku', 100)->nullable();
            $table->timestamps();

            // Evita duplicados del mismo producto+talle por usuario
            $table->unique(['user_id', 'producto_id', 'talle'], 'carrito_unico');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carritos');
    }
};