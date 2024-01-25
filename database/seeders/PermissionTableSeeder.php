<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionTableSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // PERMISOS A MESA DE PARTES VIRTUAL
        Permission::create(['name' => 'dashboard']);
        Permission::create(['name' => 'index_tramite']);//menu tramite
        Permission::create(['name' => 'nuevo_tramite']);
        Permission::create(['name' => 'despacho_tramite']);
        Permission::create(['name' => 'recepcion_tramite']);
        Permission::create(['name' => 'archivados_tramite']);
        Permission::create(['name' => 'oficina_tramite']);
        Permission::create(['name' => 'personal_tramite']);
        Permission::create(['name' => 'catalogo_archivador']);
        Permission::create(['name' => 'index_mesapartes']);//menu mesa de partes
        Permission::create(['name' => 'mesapartes_fisico']);
        Permission::create(['name' => 'mesapartes_virtual']);
        Permission::create(['name' => 'interoperabilidad']);//menu interoperabilidad
        Permission::create(['name' => 'index_administracion']);//menu administracion
        Permission::create(['name' => 'index_entidadexterna']);
        Permission::create(['name' => 'index_unidadorganica']);
        Permission::create(['name' => 'index_unidadorganicaxdepe']);
        Permission::create(['name' => 'index_dependencia']);
        Permission::create(['name' => 'index_tipodocumento']);
        Permission::create(['name' => 'index_correlativo']);
        Permission::create(['name' => 'index_usuarios']);
        Permission::create(['name' => 'index_anuncios']);
        Permission::create(['name' => 'index_reportes']);
        Permission::create(['name' => 'index_atenderfoliosasuntos']);
        Permission::create(['name' => 'index_roles']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'SUPERADMIN']);
        $role1->givePermissionTo('dashboard');
        $role1->givePermissionTo('index_tramite');
        $role1->givePermissionTo('nuevo_tramite');
        $role1->givePermissionTo('despacho_tramite');
        $role1->givePermissionTo('recepcion_tramite');
        $role1->givePermissionTo('archivados_tramite');
        $role1->givePermissionTo('oficina_tramite');
        $role1->givePermissionTo('personal_tramite');
        $role1->givePermissionTo('catalogo_archivador');
        $role1->givePermissionTo('index_mesapartes');
        $role1->givePermissionTo('mesapartes_fisico');
        $role1->givePermissionTo('mesapartes_virtual');
        $role1->givePermissionTo('interoperabilidad');
        $role1->givePermissionTo('index_administracion');
        $role1->givePermissionTo('index_entidadexterna');
        $role1->givePermissionTo('index_unidadorganica');
        $role1->givePermissionTo('index_unidadorganicaxdepe');
        $role1->givePermissionTo('index_dependencia');
        $role1->givePermissionTo('index_tipodocumento');
        $role1->givePermissionTo('index_correlativo');
        $role1->givePermissionTo('index_usuarios');
        $role1->givePermissionTo('index_anuncios');
        $role1->givePermissionTo('index_reportes');
        $role1->givePermissionTo('index_atenderfoliosasuntos');
        $role1->givePermissionTo('index_roles');


        $role2 = Role::create(['name' => 'ADMINISTRADOR']);
        $role2->givePermissionTo('dashboard');
        $role2->givePermissionTo('index_tramite');
        $role2->givePermissionTo('nuevo_tramite');
        $role2->givePermissionTo('despacho_tramite');
        $role2->givePermissionTo('recepcion_tramite');
        $role2->givePermissionTo('archivados_tramite');
        $role2->givePermissionTo('oficina_tramite');
        $role2->givePermissionTo('personal_tramite');
        $role2->givePermissionTo('catalogo_archivador');
        $role2->givePermissionTo('index_administracion');
        $role2->givePermissionTo('index_entidadexterna');
        $role2->givePermissionTo('index_unidadorganicaxdepe');
        $role2->givePermissionTo('index_tipodocumento');
        $role2->givePermissionTo('index_correlativo');
        $role2->givePermissionTo('index_usuarios');
        $role2->givePermissionTo('index_anuncios');
        $role2->givePermissionTo('index_reportes');
        $role2->givePermissionTo('index_atenderfoliosasuntos');
        


        $role3 = Role::create(['name' => 'PERSONA']);
        $role3->givePermissionTo('dashboard');
        $role3->givePermissionTo('index_tramite');
        $role3->givePermissionTo('nuevo_tramite');
        $role3->givePermissionTo('despacho_tramite');
        $role3->givePermissionTo('recepcion_tramite');
        $role3->givePermissionTo('archivados_tramite');
        $role3->givePermissionTo('personal_tramite');
        $role3->givePermissionTo('catalogo_archivador');
        $role3->givePermissionTo('index_reportes');


        $role4 = Role::create(['name' => 'OFICINA']);
        $role4->givePermissionTo('dashboard');
        $role4->givePermissionTo('index_tramite');
        $role4->givePermissionTo('nuevo_tramite');
        $role4->givePermissionTo('despacho_tramite');
        $role4->givePermissionTo('recepcion_tramite');
        $role4->givePermissionTo('archivados_tramite');
        $role4->givePermissionTo('oficina_tramite');
        $role4->givePermissionTo('personal_tramite');
        $role4->givePermissionTo('catalogo_archivador');
        $role4->givePermissionTo('index_reportes');

        $role5 = Role::create(['name' => 'JEFE']);
        $role5->givePermissionTo('dashboard');
        $role5->givePermissionTo('index_tramite');
        $role5->givePermissionTo('nuevo_tramite');
        $role5->givePermissionTo('despacho_tramite');
        $role5->givePermissionTo('recepcion_tramite');
        $role5->givePermissionTo('archivados_tramite');
        $role5->givePermissionTo('oficina_tramite');
        $role5->givePermissionTo('personal_tramite');
        $role5->givePermissionTo('catalogo_archivador');
        $role5->givePermissionTo('index_reportes');

        $role6 = Role::create(['name' => 'SECRETARIAS']);
        $role6->givePermissionTo('dashboard');
        $role6->givePermissionTo('index_tramite');
        $role6->givePermissionTo('nuevo_tramite');
        $role6->givePermissionTo('despacho_tramite');
        $role6->givePermissionTo('recepcion_tramite');
        $role6->givePermissionTo('archivados_tramite');
        $role6->givePermissionTo('oficina_tramite');
        $role6->givePermissionTo('personal_tramite');
        $role6->givePermissionTo('catalogo_archivador');
        $role6->givePermissionTo('index_reportes');

        $role7 = Role::create(['name' => 'MESAPARTES']);
        $role7->givePermissionTo('index_mesapartes');
        $role7->givePermissionTo('mesapartes_fisico');
        $role7->givePermissionTo('index_reportes');

        $role8 = Role::create(['name' => 'MESAVIRTUAL']);
        $role8->givePermissionTo('index_mesapartes');
        $role8->givePermissionTo('mesapartes_virtual');

        $role9 = Role::create(['name' => 'INTEROPERABILIDAD']);
        $role9->givePermissionTo('interoperabilidad');

        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'adm_name' => 'SUPERADMIN',
            'adm_lastname' => 'SUPERADMIN',
            'adm_inicial' => 'SUPERADMIN',
            'adm_vigencia' => '2023-12-31',
            'adm_estado' => '1',
            'adm_email' => 'SUPERADMIN',
        ]);
        $user->assignRole($role1);

        // create demo users
        $user2 = \App\Models\User::factory()->create([
            'adm_name' => 'WILMER',
            'adm_lastname' => 'OCHOA ALVARADO',
            'adm_inicial' => 'WOA',
            'adm_vigencia' => '2023-12-31',
            'adm_estado' => '1',
            'adm_email' => 'WOCHOA',
        ]);
        $user2->assignRole($role2);

        
    }
}