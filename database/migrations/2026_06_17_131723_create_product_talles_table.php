<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_talles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('talle', 10); // XS, S, M, L, XL, XXL
            $table->unsignedInteger('stock')->default(0);
            $table->timestamps();

            // Un producto no puede tener el mismo talle dos veces
            $table->unique(['product_id', 'talle']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_talles');
    }
};