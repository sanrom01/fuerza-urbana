<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nombre');
            $table->string('email');
            $table->string('asunto')->nullable();
            $table->text('mensaje');
            $table->enum('estado', ['pendiente', 'respondida'])->default('pendiente');
            $table->text('respuesta')->nullable();
            $table->timestamp('respondida_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};