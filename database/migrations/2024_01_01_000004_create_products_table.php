<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                  ->constrained()
                  ->restrictOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('sku', 100)->unique()->nullable(); // código de stock
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable(); // precio con descuento
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedInteger('stock_min')->default(5); // alerta de stock bajo
            $table->boolean('is_active')->default(true);
            $table->boolean('featured')->default(false);     // destacado en la home
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
