<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToConsultasTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('consultas') && !Schema::hasColumn('consultas', 'status')) {
            Schema::table('consultas', function (Blueprint $table) {
                $table->string('status', 20)->default('pendente')->after('motivo');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('consultas') && Schema::hasColumn('consultas', 'status')) {
            Schema::table('consultas', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
}
