<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComunicacionInternasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comunicacion_interna', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_solicitante')->nullable()->unsigned();
            $table->string('sustento', 300)->nullable();
            $table->string('imagen', 255)->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->integer('estado')->nullable()->unsigned();
            $table->text('url')->nullable();
            $table->text('depe_publicacion')->nullable();
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
        Schema::dropIfExists('comunicacion_interna');
    }
}
