<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->enum('method', [
                'tarjeta_credito',
                'tarjeta_debito',
                'transferencia',
                'mercadopago',
                'efectivo',
            ]);
            $table->enum('status', [
                'pendiente',
                'aprobado',
                'rechazado',
                'reembolsado',
            ])->default('pendiente');
            $table->decimal('amount', 10, 2);
            $table->string('transaction_id')->nullable();    // ID externo del procesador
            $table->json('gateway_response')->nullable();   // respuesta cruda del gateway
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
