<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::create(['name' => 'Administrador']);
        $almacen = Role::create(['name' => 'Encargado de Almacen']);
        $activo = Role::create(['name' => 'Encargado de Activo']);
        $agente_servicio = Role::create(['name' => 'Agente de Servicio']);

        //Inicio Lista
        Permission::create([
            'name' => 'admin.home',
            'description' => 'Ver Inicio'
        ])->syncRoles([$admin, $almacen, $activo]);

        //Usuarios Lista
        Permission::create([
            'name' => 'admin.users.index',
            'description' => 'Lista Usuarios'
        ])->syncRoles([$admin]);

        //Usuarios Crear
        Permission::create([
            'name' => 'admin.users.create',
            'description' => 'Crear Usuario'
        ])->syncRoles([$admin]);

        //Usuarios Editar
        Permission::create([
            'name' => 'admin.users.edit',
            'description' => 'Editar Usuario'
        ])->syncRoles([$admin]);

        //Usuarios Rol Usuario
        Permission::create([
            'name' => 'admin.users.rol',
            'description' => 'Rol Usuario'
        ])->syncRoles([$admin]);

        //Usuarios Estado
        Permission::create([
            'name' => 'admin.users.state',
            'description' => 'Estado usuario'
        ])->syncRoles([$admin]);

        //Roles Lista
        Permission::create([
            'name' => 'admin.rol.index',
            'description' => 'Lista Roles'
        ])->syncRoles([$admin]);

        //Roles Crear
        Permission::create([
            'name' => 'admin.rol.create',
            'description' => 'Crear Rol'
        ])->syncRoles([$admin]);

        //Roles Editar
        Permission::create([
            'name' => 'admin.rol.edit',
            'description' => 'Editar Rol'
        ])->syncRoles([$admin]);

        //Roles Eliminar
        Permission::create([
            'name' => 'admin.rol.delete',
            'description' => 'Eliminar Rol'
        ])->syncRoles([$admin]);

        //Proyecto Lista
        Permission::create([
            'name' => 'admin.project.index',
            'description' => 'Lista Proyectos'
        ])->syncRoles([$admin]);

        //Proyecto Crear
        Permission::create([
            'name' => 'admin.project.create',
            'description' => 'Crear Proyecto'
        ])->syncRoles([$admin]);

        //Proyecto Editar
        Permission::create([
            'name' => 'admin.project.edit',
            'description' => 'Editar Proyecto'
        ])->syncRoles([$admin]);

        //Proyecto Estado
        Permission::create([
            'name' => 'admin.project.state',
            'description' => 'Estado Proyecto'
        ])->syncRoles([$admin]);

        //Sucursal Lista
        Permission::create([
            'name' => 'admin.branch.index',
            'description' => 'Lista Sucursales'
        ])->syncRoles([$admin, $almacen]);

        //Sucursal Crear
        Permission::create([
            'name' => 'admin.branch.create',
            'description' => 'Crear Sucursal'
        ])->syncRoles([$admin]);

        //Sucursal Editar
        Permission::create([
            'name' => 'admin.branch.edit',
            'description' => 'Editar Sucursal'
        ])->syncRoles([$admin]);

        //Sucursal Estado
        Permission::create([
            'name' => 'admin.branch.state',
            'description' => 'Encargado Sucursal'
        ])->syncRoles([$admin]);

        //Inventario Lista 
        Permission::create([
            'name' => 'admin.inventory.index',
            'description' => 'Lista Inventario Almacen'
        ])->syncRoles([$admin, $almacen]);

        //Inventario Lista 
        Permission::create([
            'name' => 'admin.inventory.index_activo',
            'description' => 'Lista Inventario Activo'
        ])->syncRoles([$admin, $activo]);

        //Inventario Ver
        Permission::create([
            'name' => 'admin.inventory.see',
            'description' => 'Ver Inventario'
        ])->syncRoles([$admin, $almacen, $activo]);

        //NO MOSTRAR -- Actualizar Imagen
        Permission::create([
            'name' => 'admin.inventory.image',
            'description' => 'Actualizar Imagen'
        ])->syncRoles([$admin]);

        //Inventario Pdf
        Permission::create([
            'name' => 'admin.inventory.pdf',
            'description' => 'Pdf Inventario'
        ])->syncRoles([$admin, $almacen, $activo]);

        //Solicitud Lista Almacen
        Permission::create([
            'name' => 'admin.request.index',
            'description' => 'Lista Solicitudes'
        ])->syncRoles([$admin, $almacen]);

        //Solicitud Lista Activo
        Permission::create([
            'name' => 'admin.request.index_activo',
            'description' => 'Lista Solicitudes'
        ])->syncRoles([$admin, $activo]);

        //Solicitud Crear
        Permission::create([
            'name' => 'admin.request.create',
            'description' => 'Crear Solicitud'
        ])->syncRoles([$almacen, $activo]);

        //Solicitud Ver
        Permission::create([
            'name' => 'admin.request.see',
            'description' => 'Ver Solicitud'
        ])->syncRoles([$admin, $almacen, $activo]);

        //Solicitud Pdf
        Permission::create([
            'name' => 'admin.request.pdf',
            'description' => 'Pdf Solicitud'
        ])->syncRoles([$admin, $almacen, $activo]);

        //NO MOSTRAR -- Solicitud Editar
        Permission::create([
            'name' => 'admin.request.edit',
            'description' => 'Editar Solicitud'
        ])->syncRoles([$almacen, $activo]);

        //NO MOSTRAR -- Solicitud Correciones Solicitud
        Permission::create([
            'name' => 'admin.request.send',
            'description' => 'Correciones Solicitud'
        ])->syncRoles([$almacen, $activo]);

        //NO MOSTRAR -- Solicitud Enviar Solicitud
        Permission::create([
            'name' => 'admin.request.accept',
            'description' => 'Enviar Solicitud'
        ])->syncRoles([$admin]);

        //NO MOSTRAR -- Solicitud Anular Solicitud
        Permission::create([
            'name' => 'admin.request.update',
            'description' => 'Anular Solicitud'
        ])->syncRoles([$almacen, $activo]);

        //Retirados Lista Almacen
        Permission::create([
            'name' => 'admin.retired.index',
            'description' => 'Lista Retirados'
        ])->syncRoles([$admin, $almacen]);

         //Retirados Lista Activo
         Permission::create([
            'name' => 'admin.retired.index_activo',
            'description' => 'Lista Retirados'
        ])->syncRoles([$admin, $activo]);

        //Retirados Crear
        Permission::create([
            'name' => 'admin.retired.create',
            'description' => 'Crear Retirados'
        ])->syncRoles([$almacen, $activo]);

        //Retirados Ver
        Permission::create([
            'name' => 'admin.retired.see',
            'description' => 'Ver Retirados'
        ])->syncRoles([$admin, $almacen, $activo]);

        //Retirados pdf
        Permission::create([
            'name' => 'admin.retired.pdf',
            'description' => 'Pdf Retirados'
        ])->syncRoles([$admin, $almacen, $activo]);

        //Enviar Transferencia Lista
        Permission::create([
            'name' => 'admin.transfer-sent.index',
            'description' => 'Lista Transferencias'
        ])->syncRoles([$admin, $almacen]);

        //Enviar Transferencia Crear
        Permission::create([
            'name' => 'admin.transfer-sent.create',
            'description' => 'Crear Transferencia'
        ])->syncRoles([$almacen]);

        //Enviar Transferencia Ver
        Permission::create([
            'name' => 'admin.transfer-sent.see',
            'description' => 'Ver Transferencia'
        ])->syncRoles([$admin, $almacen]);

        //Enviar Transferencia Pdf
        Permission::create([
            'name' => 'admin.transfer-sent.pdf',
            'description' => 'Pdf Transferencia'
        ])->syncRoles([$admin, $almacen]);

        //Recibir Transferencia Lista
        Permission::create([
            'name' => 'admin.transfer-receive.index',
            'description' => 'Lista Transferencia Recibidas'
        ])->syncRoles([$admin, $almacen]);

        //Recibir Transferencia Ver
        Permission::create([
            'name' => 'admin.transfer-receive.see',
            'description' => 'Ver Transferencia Recibida'
        ])->syncRoles([$admin, $almacen]);

        //Recibir Transferencia Editar
        Permission::create([
            'name' => 'admin.transfer-receive.edit',
            'description' => 'Editar Transferencia Recibida'
        ])->syncRoles([$almacen]);

        //Recibir Transferencia pdf
        Permission::create([
            'name' => 'admin.transfer-receive.pdf',
            'description' => 'Pdf Transferencia Recibida'
        ])->syncRoles([$admin, $almacen]);

        //Movimientos Lista
        Permission::create([
            'name' => 'admin.movement.index',
            'description' => 'Lista Movimientos'
        ])->syncRoles([$admin, $almacen]);

        //Movimientos Crear
        Permission::create([
            'name' => 'admin.movement.create',
            'description' => 'Crear Movimiento'
        ])->syncRoles([$almacen]);

        //Movimientos Editar
        Permission::create([
            'name' => 'admin.movement.edit',
            'description' => 'Editar Movimiento'
        ])->syncRoles([$almacen]);

        //Movimientos Ver
        Permission::create([
            'name' => 'admin.movement.see',
            'description' => 'Ver Movimiento'
        ])->syncRoles([$admin, $almacen]);

        //Movimientos pdf
        Permission::create([
            'name' => 'admin.movement.pdf',
            'description' => 'Pdf Movimiento '
        ])->syncRoles([$admin, $almacen]);

        //NO MOSTRAR -- Movimientos Aceptar Solicitud o Rechazar
        Permission::create([
            'name' => 'admin.movement.accept',
            'description' => 'Aceptar Movimiento'
        ])->syncRoles([$almacen]);

        //NO MOSTRAR -- Asignar Aceptar Solicitud o Rechazar
        Permission::create([
            'name' => 'admin.movement.refused',
            'description' => 'Aceptar Asignar'
        ])->syncRoles([$admin]);

        //NO MOSTRAR -- Ver select de Sucursales
        Permission::create([
            'name' => 'admin.inventory.select',
            'description' => 'Selecionar Sucursal Inventario'
        ])->syncRoles([$admin, $almacen]);

        //NO MOSTRAR -- Ver Links de Encargado de Almacen
        Permission::create([
            'name' => 'admin.Link.Admin',
            'description' => 'Lista de Links Admin'
        ])->syncRoles([$admin]);

        //NO MOSTRAR -- Ver Links de Encargado de Almacen
        Permission::create([
            'name' => 'admin.Link.store',
            'description' => 'Lista de Links Almacen'
        ])->syncRoles([$almacen]);

        //NO MOSTRAR -- Ver Links de Encargado de Activo
        Permission::create([
            'name' => 'admin.Link.active',
            'description' => 'Lista de Links Activos'
        ])->syncRoles([$activo]);




        //NO MOSTRAR -- Ver Inicio Card Almacen
        Permission::create([
            'name' => 'admin.index.almacen',
            'description' => 'Lista de Links Activos'
        ])->syncRoles([$admin, $almacen]);

        //NO MOSTRAR -- Ver Inicio Card Activo
        Permission::create([
            'name' => 'admin.index.activo',
            'description' => 'Lista de Links Activos'
        ])->syncRoles([$admin, $activo]);


        //Asignar Lista
        Permission::create([
            'name' => 'admin.assign.index',
            'description' => 'Lista Asignar'
        ])->syncRoles([$admin, $activo]);

        //Asignar Crear
        Permission::create([
            'name' => 'admin.assign.create',
            'description' => 'Crear Asignar'
        ])->syncRoles([$activo]);

        //Asignar Editar
        Permission::create([
            'name' => 'admin.assign.edit',
            'description' => 'Editar Asignar'
        ])->syncRoles([$activo]);

        //Asignar Ver
        Permission::create([
            'name' => 'admin.assign.see',
            'description' => 'Ver Asignar'
        ])->syncRoles([$admin, $activo]);

        //Asignar pdf
        Permission::create([
            'name' => 'admin.assign.pdf',
            'description' => 'Pdf Asignar '
        ])->syncRoles([$admin, $activo]);

        //NO MOSTRAR -- Asignar Aceptar Solicitud o Rechazar
        Permission::create([
            'name' => 'admin.assign.accept',
            'description' => 'Aceptar Asignar'
        ])->syncRoles([$activo]);

        //NO MOSTRAR -- Asignar Aceptar Solicitud o Rechazar
        Permission::create([
            'name' => 'admin.assign.refused',
            'description' => 'Aceptar Asignar'
        ])->syncRoles([$admin]);


        //Trabajadores Lista
        Permission::create([
            'name' => 'admin.workers.index',
            'description' => 'Lista Trabajadores'
        ])->syncRoles([$admin, $activo]);

        //Trabajadores Crear
        Permission::create([
            'name' => 'admin.workers.create',
            'description' => 'Crear Trabajador'
        ])->syncRoles([$admin, $activo]);

        //Trabajadores Editar
        Permission::create([
            'name' => 'admin.workers.edit',
            'description' => 'Editar Trabajador'
        ])->syncRoles([$admin, $activo]);


    }
}