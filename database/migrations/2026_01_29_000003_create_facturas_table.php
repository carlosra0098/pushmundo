<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('facturas')) {
            Schema::create('facturas', function (Blueprint $table) {
                $table->id();
                $table->string('numero', 50)->unique();
                $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
                $table->decimal('total', 12, 2)->default(0);
                $table->timestamp('fecha')->nullable();
                $table->string('estado', 50)->default('pendiente');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
