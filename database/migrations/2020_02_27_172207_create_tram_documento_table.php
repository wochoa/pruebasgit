<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTramDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tram_documento', function (Blueprint $table) {
            $table->increments('iddocumento');
            $table->decimal('docu_origen',1 ,0);//1: interno, 2 externo
            $table->integer('docu_tipo')->nullable();//0: representante oficina  1: personal
            $table->integer('docu_idprioridad');// 1:normal, 2:urgente, 3:documento MINEDU,4: DRE
            $table->decimal('docu_forma', 1, 0);//0: ORIGINAL, 2:copia
            $table->decimal('docu_digital', 1, 0)->default(0);//0: si no genera con el sistema 1: documento generado y firmado digitalmente
            $table->integer('docu_iddependencia')->unsigned();// 2: usuario que pertenece a una dependencia

            $table->string('docu_ruc', 11)->nullable();
            $table->string('docu_detalle', 60)->nullable();
            $table->string('docu_firma', 60);
            $table->string('docu_cargo', 70)->nullable();
            $table->integer('docu_idtipodocumento')->unsigned();// tipo documento de la tabla tram_tipodocumento

            $table->date('docu_fecha_doc');// fecha documento p.e: 12/09/2023
            $table->integer('docu_numero_doc')->nullable()->unsigned();// informe n°15-2023-gore cusco... =15
            $table->string('docu_siglas_doc', 65)->nullable();//gorecusco-grppm-sgmti
            $table->string('docu_proyectado', 10)->nullable();//null
            $table->integer('docu_idrecepcion');//1:directa, 2:fax defecto es 1
            $table->integer('docu_folios')->nullable();// cantidad de hojas de doc.(p.e =5)
            $table->string('docu_asunto', 1001)->nullable();// asunto de documento

            $table->integer('docu_relacionado')->nullable();// 0
            $table->integer('docu_idusuario')->unsigned();// id del usuario que crea el doc.

            $table->integer('docu_idusuariodependencia');//es un atributo de la tabla dependencia (id_usu)
            $table->string('docu_emailorigen', 80)->nullable();// correo de usuario externo por MPV
            $table->text('docu_archivo')->nullable();//null
            $table->integer('docu_estado');//1 defaul
            $table->decimal('docu_clastupa', 1, 0); // defecto 9 como clasificador
            $table->integer('docu_diasatencion')->nullable();// dias de atencion
            $table->string('docu_idtdoc', 1)->nullable();//null
            $table->string('docu_numtdoc', 15)->nullable();//expo_numtdoc
            $table->integer('docu_idtupa')->nullable();//NUL
            $table->integer('docu_idexma')->nullable();//nro expediente id del tabla tran_documentmain
            $table->string('docu_domic', 150)->nullable();// domicilio del usuario extreno ingresado por MPV
            $table->string('docu_dni', 8)->nullable();//dni
            $table->string('docu_telef', 15)->nullable();// telefono cunado el tramite ha sido por MPV
            $table->integer('docu_doc_generado')->nullable();// defecto null
            $table->decimal('docu_firma_electronica', 1, 0)->nullable();// 1 se si van hacer firma digital,0 no
            $table->string('docu_contrasenia', 8)->nullable();//contraseña doc, defecto null
            $table->string('docu_token', 50)->nullable();//tocken del doc, defecto null
            $table->text('docu_referencias')->nullable();

            $table->timestamps();

            //index
            //$table->index(['docu_detalle', 'docu_firma', 'docu_siglas_doc', 'docu_asunto', 'docu_dni'],'tram_documento_docu_filter');//USING gin
            $table->index('docu_iddependencia', 'tram_documento_docu_iddependencia_foreign');
            $table->index('docu_idexma', 'tram_documento_docu_idexma');
            $table->index('docu_idtipodocumento', 'tram_documento_docu_idtipodocumento_foreign');
            $table->index(['iddocumento', 'docu_iddependencia', 'docu_idtipodocumento'], 'tram_operacion_iddocumento');
            $table->index(['iddocumento', 'docu_idtipodocumento'], 'tram_operacion_indx1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tram_documento');
    }
}
