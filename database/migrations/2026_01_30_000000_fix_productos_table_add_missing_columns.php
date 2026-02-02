<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Agregar columnas que faltan en productos de forma idempotente
        Schema::table('productos', function (Blueprint $table) {
            if (! Schema::hasColumn('productos', 'codigo')) {
                $table->string('codigo', 50)->nullable()->after('nombre');
                $table->unique('codigo');
            }

            if (! Schema::hasColumn('productos', 'proveedor_id')) {
                $table->unsignedBigInteger('proveedor_id')->nullable()->after('precio');
            }

            if (! Schema::hasColumn('productos', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        // Añadir la clave foránea de proveedor si no existe
        try {
            $sm = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'productos' AND COLUMN_NAME = 'proveedor_id' AND REFERENCED_TABLE_NAME = 'proveedores'");
            if (empty($sm)) {
                Schema::table('productos', function (Blueprint $table) {
                    $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('set null');
                });
            }
        } catch (\Exception $e) {
            // Ignorar si hay problemas al crear la FK (idempotente)
        }
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            if (Schema::hasColumn('productos', 'proveedor_id')) {
                try { $table->dropForeign(['proveedor_id']); } catch (\Exception $e) {}
                $table->dropColumn('proveedor_id');
            }

            if (Schema::hasColumn('productos', 'codigo')) {
                try { $table->dropUnique(['codigo']); } catch (\Exception $e) {}
                $table->dropColumn('codigo');
            }

            if (Schema::hasColumn('productos', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};