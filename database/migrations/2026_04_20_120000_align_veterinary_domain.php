<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlignVeterinaryDomain extends Migration
{
    public function up()
    {
        $driver = Schema::getConnection()->getDriverName();

        if (Schema::hasTable('consultas')) {
            if (Schema::hasColumn('consultas', 'nomepet') || ! Schema::hasColumn('consultas', 'clinica_id')) {
                Schema::drop('consultas');
            }
        }

        if ($driver === 'mysql' && Schema::hasTable('clinicas') && Schema::hasColumn('clinicas', 'cnpj')) {
            try {
                DB::statement('ALTER TABLE clinicas MODIFY cnpj VARCHAR(14) NOT NULL');
            } catch (\Throwable $e) {
                // coluna já ajustada ou ambiente sem permissão
            }
        }

        if (Schema::hasTable('clinicas') && ! Schema::hasColumn('clinicas', 'remember_token')) {
            Schema::table('clinicas', function (Blueprint $table) {
                $table->rememberToken();
            });
        }

        if (Schema::hasTable('pets')) {
            if (! Schema::hasColumn('pets', 'user_id')) {
                Schema::table('pets', function (Blueprint $table) {
                    $table->unsignedBigInteger('user_id')->nullable()->after('id');
                });
            }

            if (! Schema::hasColumn('pets', 'data_vacina')) {
                Schema::table('pets', function (Blueprint $table) {
                    $table->date('data_vacina')->nullable()->after('vacina');
                });
            }

            if (Schema::hasColumn('pets', 'dtconsulta')) {
                Schema::table('pets', function (Blueprint $table) {
                    $table->dropColumn(['dtconsulta', 'hora']);
                });
            }

            if (Schema::hasColumn('pets', 'password') && ! Schema::hasColumn('pets', 'senha')) {
                if ($driver === 'mysql') {
                    DB::statement('ALTER TABLE pets CHANGE password senha VARCHAR(255) NOT NULL');
                }
            }

            if ($driver === 'mysql') {
                try {
                    DB::statement('ALTER TABLE pets MODIFY raca VARCHAR(255) NULL');
                    DB::statement('ALTER TABLE pets MODIFY cor VARCHAR(255) NULL');
                    DB::statement('ALTER TABLE pets MODIFY vacina VARCHAR(255) NULL');
                    DB::statement('ALTER TABLE pets MODIFY doenca VARCHAR(255) NULL');
                    DB::statement('ALTER TABLE pets MODIFY observacao VARCHAR(500) NULL');
                    DB::statement('ALTER TABLE pets MODIFY nascimento DATE NULL');
                } catch (\Throwable $e) {
                }
            }

            if (Schema::hasColumn('pets', 'user_id')) {
                try {
                    Schema::table('pets', function (Blueprint $table) {
                        $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
                    });
                } catch (\Throwable $e) {
                }
            }
        }

        if (! Schema::hasTable('consultas')) {
            Schema::create('consultas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('clinica_id')->constrained('clinicas')->cascadeOnDelete();
                $table->foreignId('pet_id')->constrained('pets')->cascadeOnDelete();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->date('data');
                $table->time('hora');
                $table->string('motivo', 500);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        //
    }
}
