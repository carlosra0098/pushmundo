<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasTable('productos')) {
            Schema::create('productos', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');
                $table->text('descripcion')->nullable();
                $table->decimal('precio', 12, 2)->default(0);
                $table->unsignedBigInteger('proveedor_id')->nullable();
                $table->integer('stock')->default(0);
                $table->softDeletes();
                $table->timestamps();

                $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('set null');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('productos')) {
            Schema::dropIfExists('productos');
        }
    }
};
