<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TramDocumentomain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tram_documentomain', function (Blueprint $table) {
			$table->increments('iddocumentomain');//incremental sirve para generar el reg de expediente
            $table->integer('dmai_idusu');//id del usuario que lo crea el tramite
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
        Schema::dropIfExists('tram_documentomain');
    }
}
