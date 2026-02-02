<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasTable('facturas')) {
            Schema::create('facturas', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('cliente_id');
                $table->date('fecha')->nullable();
                $table->decimal('total', 12, 2)->default(0);
                $table->text('comentarios')->nullable();
                $table->softDeletes();
                $table->timestamps();

                $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('facturas')) {
            Schema::dropIfExists('facturas');
        }
    }
};
