<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Proveedores
        Schema::table('proveedores', function (Blueprint $table) {
            if (! Schema::hasColumn('proveedores', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        // Empleados
        Schema::table('empleados', function (Blueprint $table) {
            if (! Schema::hasColumn('empleados', 'deleted_at')) {
                $table->softDeletes();
            }
            // Asegurar que existe apellido (en caso de tabla antigua)
            if (! Schema::hasColumn('empleados', 'apellido')) {
                $table->string('apellido', 150)->nullable()->after('nombre');
            }
        });

        // Facturas
        Schema::table('facturas', function (Blueprint $table) {
            if (! Schema::hasColumn('facturas', 'deleted_at')) {
                $table->softDeletes();
            }
            if (! Schema::hasColumn('facturas', 'comentarios')) {
                $table->text('comentarios')->nullable()->after('total');
            }
        });
    }

    public function down()
    {
        Schema::table('proveedores', function (Blueprint $table) {
            if (Schema::hasColumn('proveedores', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('empleados', function (Blueprint $table) {
            if (Schema::hasColumn('empleados', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
            if (Schema::hasColumn('empleados', 'apellido')) {
                // solo eliminar columna si está vacía; para seguridad dejamos la columna en down (evitar pérdida de datos)
            }
        });

        Schema::table('facturas', function (Blueprint $table) {
            if (Schema::hasColumn('facturas', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
            // No eliminar comentarios en down para evitar pérdida de datos accidental
        });
    }
};