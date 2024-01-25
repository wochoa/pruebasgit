<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTramTipodocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tram_tipodocumento', function (Blueprint $table) {
            $table->id('idtdoc');
            $table->text('tdoc_descripcion');
            $table->string('tdoc_abreviado', 20);
            $table->integer('tdoc_correlativo');
            $table->decimal('tdoc_mpv', 1, 0)->default(0);
            $table->string('nombre_archivo')->nullable();// ubucacion y nombre del archivo
            $table->timestamps();

            $table->index('idtdoc', 'tram_tipodocumento_idtdoc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tram_tipodocumento');
    }
}
