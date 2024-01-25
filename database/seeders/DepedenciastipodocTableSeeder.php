<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DepedenciastipodocTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        //dependencia
        DB::table('tram_dependencia')->insert([
            [
                'depe_nombre'     => 'SEDE CENTRAL',
                'depe_abreviado'  => 'SEDE',
                'depe_tipo'       => 0,
                'depe_proyectado' => 0,
                'depe_estado'     => 1,
                'depe_agente'     => 0,
                'depe_ciudad'     => 'HUANUCO',
            ],
        ]);
        DB::table('tram_dependencia')->insert([
            [
                'depe_nombre'           => 'UNIDAD FUNCIONAL DE TECNOLOGIAS DE INFORMACION',
                'depe_abreviado'        => 'INFO',
                'depe_sigla'            => 'OIT',
                'depe_representante'    => 'REPRESENTANTE',
                'depe_cargo'            => 'DIRECTOR',
                'depe_dni'              => '46181970',
                'depe_depende'          => 1,
                'depe_superior'         => '{"dependencia":2,"nombre":"SUB GERENCIA DE MODERNIZACION Y TRANSFROMACION DIGITAL"}',
                'depe_tipo'             => 1,
                'depe_proyectado'       => 1,
                'depe_estado'           => 1,
                'depe_idusuario'        => 1,
                'depe_recibetramite'    => 1,
                'depe_agente'           => 0,
                'depe_mesa_virtual'     => 1,
                'depe_diasmaxenproceso' => 100,
                'depe_imagen_header'    => 'encabezado/2.png',
            ],
            [
                'depe_nombre'           => 'SUB GERENCIA DE OBRAS Y SUPERVISION',
                'depe_abreviado'        => 'GRI',
                'depe_sigla'            => 'GRI',
                'depe_representante'    => 'REPRESENTANTE',
                'depe_cargo'            => 'GERENTE',
                'depe_dni'              => '46181975',
                'depe_depende'          => 1,
                'depe_superior'         => '{"dependencia":3,"nombre":"GERENCIA REGIONAL DE INFRAESTRUCTURA"}',
                'depe_tipo'             => 1,
                'depe_proyectado'       => 1,
                'depe_estado'           => 1,
                'depe_idusuario'        => 1,
                'depe_recibetramite'    => 1,
                'depe_agente'           => 0,
                'depe_mesa_virtual'     => 0,
                'depe_diasmaxenproceso' => 100,
                'depe_imagen_header'    => 'encabezado/2.png',
            ],
        ]);
        DB::table('tram_dependencia')->insert([
            [

                'depe_nombre'           => 'PERSONA NATURAL',
                'depe_abreviado'        => 'PN',
                'depe_tipo'             => 2,
                'depe_proyectado'       => 0,
                'depe_estado'           => 1,
                'depe_idusuario'        => 1,
                'depe_recibetramite'    => 0,
                'depe_agente'           => 0,
                'depe_mesa_virtual'     => 0,
                'depe_diasmaxenproceso' => 100,
            ],
            [
                'depe_nombre'           => 'OTRAS EMPRESAS',
                'depe_abreviado'        => 'OE',
                'depe_tipo'             => 2,
                'depe_proyectado'       => 0,
                'depe_estado'           => 1,
                'depe_idusuario'        => 1,
                'depe_recibetramite'    => 0,
                'depe_agente'           => 0,
                'depe_mesa_virtual'     => 0,
                'depe_diasmaxenproceso' => 100,
            ],
            [
                'depe_nombre'           => 'OTRAS ENTIDADES',
                'depe_abreviado'        => 'OE',
                'depe_tipo'             => 2,
                'depe_proyectado'       => 0,
                'depe_estado'           => 1,
                'depe_idusuario'        => 1,
                'depe_recibetramite'    => 0,
                'depe_agente'           => 0,
                'depe_mesa_virtual'     => 0,
                'depe_diasmaxenproceso' => 100,
            ],
        ]);
        //tipo documento
        DB::table('tram_tipodocumento')->insert([
            [
                'tdoc_descripcion' => 'OFICIO',
                'tdoc_abreviado'   => 'OFI',
                'tdoc_correlativo' => 0,
                'tdoc_mpv'         => 1,
                'nombre_archivo'   => 'formatosdoc/oficio.docx',
            ],
            [
                'tdoc_descripcion' => 'OFICIO MULTIPLE',
                'tdoc_abreviado'   => 'OFI.MULT.',
                'tdoc_correlativo' => 0,
                'tdoc_mpv'         => 1,
                'nombre_archivo'   => NULL,
            ],
            [
                'tdoc_descripcion' => 'MEMO',
                'tdoc_abreviado'   => 'MEMO',
                'tdoc_correlativo' => 0,
                'tdoc_mpv'         => 0,
                'nombre_archivo'   => NULL,
            ],
            [
                'tdoc_descripcion' => 'MEMO MULTIPLE',
                'tdoc_abreviado'   => 'MEMO MULT.',
                'tdoc_correlativo' => 0,
                'tdoc_mpv'         => 0,
                'nombre_archivo'   => NULL,
            ],
            [
                'tdoc_descripcion' => 'CARTA',
                'tdoc_abreviado'   => 'CARTA',
                'tdoc_correlativo' => 0,
                'tdoc_mpv'         => 1,
                'nombre_archivo'   => NULL,
            ],
            [
                'tdoc_descripcion' => 'SOLICITUD - OTROS',
                'tdoc_abreviado'   => 'SOLIC.',
                'tdoc_correlativo' => 0,
                'tdoc_mpv'         => 0,
                'nombre_archivo'   => NULL,
            ],
            [
                'tdoc_descripcion' => 'MEMORIAL',
                'tdoc_abreviado'   => 'MEMORIAL',
                'tdoc_correlativo' => 0,
                'tdoc_mpv'         => 0,
                'nombre_archivo'   => NULL,
            ],
            [
                'tdoc_descripcion' => 'INFORME',
                'tdoc_abreviado'   => 'INF.',
                'tdoc_correlativo' => 0,
                'tdoc_mpv'         => 0,
                'nombre_archivo'   => 'formatosdoc/informe.docx',
            ],
            [
                'tdoc_descripcion' => 'RESOLUCION',
                'tdoc_abreviado'   => 'RESOL.',
                'tdoc_correlativo' => 0,
                'tdoc_mpv'         => 0,
                'nombre_archivo'   => NULL,
            ],
            [
                'tdoc_descripcion' => 'SOLICITUD PAPELETA',
                'tdoc_abreviado'   => 'PAPELETA',
                'tdoc_correlativo' => 0,
                'tdoc_mpv'         => 0,
                'nombre_archivo'         => NULL,
            ],
        ]);

        DB::table('usuario_oficinas')->insert([
            [
                'iduser' => 1,// incializa con el superadmin creado
                'idunidad'   => 2,// le indicamos que pertenece a la oficina 2, xq 1 es depedencia superior de la 2
                'userupdate' => 1,// por primera vez el que crea es el superadmin
                'acceso'         => 'SUPERADMIN',// rol por defecto en la oficina 2 es ser SUPERADMIN
                'cargo'         => 'SUPER ADMINISTRADOR DEL SISTEMA',// por defecto se le asigna el cargo
                'estado'   => 1,// por defecto se le coloca activo
            ],
            [
                'iduser' => 2,// incializa con el superadmin creado
                'idunidad'   => 2,// le indicamos que pertenece a la oficina 2, xq 1 es depedencia superior de la 2
                'userupdate' => 1,// por primera vez el que crea es el superadmin
                'acceso'         => 'ADMINISTRADOR',// rol por defecto en la oficina 2 es ser SUPERADMIN
                'cargo'         => 'ESPECIALISTA EN TI',// por defecto se le asigna el cargo
                'estado'   => 1,// por defecto se le coloca activo
            ],
        ]);


    }
}
