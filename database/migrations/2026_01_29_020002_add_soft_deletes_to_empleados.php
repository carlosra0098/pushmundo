<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasColumn('empleados', 'deleted_at')) {
            Schema::table('empleados', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('empleados', 'deleted_at')) {
            Schema::table('empleados', function (Blueprint $table) {
                $table->dropColumn('deleted_at');
            });
        }
    }
};
