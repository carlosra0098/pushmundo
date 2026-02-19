<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            if (! Schema::hasColumn('productos', 'imagen')) {
                $table->string('imagen')->nullable()->after('descripcion');
            }

            if (! Schema::hasColumn('productos', 'archivo_pdf')) {
                $table->string('archivo_pdf')->nullable()->after('imagen');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            if (Schema::hasColumn('productos', 'archivo_pdf')) {
                $table->dropColumn('archivo_pdf');
            }

            if (Schema::hasColumn('productos', 'imagen')) {
                $table->dropColumn('imagen');
            }
        });
    }
};
