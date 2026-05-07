<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('nome');
            $table->string('raca');
            $table->string('cor');
            $table->string('vacina');
            $table->string('doenca');
            $table->date('nascimento');
            $table->date('dtconsulta');
            $table->time('hora');
            $table->string('observacao');
            $table->string('password');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pets');
    }
}
