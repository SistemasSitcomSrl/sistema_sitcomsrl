<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AssetAllocation;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Inventory;
use App\Models\User;
use App\Models\Projects;
use App\Models\Movements;
use App\Models\Workers;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        User::create([
            'id' => '1',
            'ci' => '7706841',
            'name' => 'Administrador',
            'email' => 'sitcomsrl.sistemas@gmail.com',
            'password' => Hash::make('*Sit*24*'),
            'company_position' => 'Administrador',
            'phone_number' => '75617797',
        ])->assignRole('Administrador');

        User::create([
            'id' => '2',
            'ci' => '6302878',
            'name' => 'Rocky Keoma Rojas Vidal',
            'email' => 'encargado.activo.scz@gmail.com',
            'password' => Hash::make('*Sit*24*'),
            'company_position' => 'Encargado de Activo',
            'phone_number' => '73131938',
        ])->assignRole('Encargado de Activo');

        User::create([
            'id' => '3',
            'ci' => '5857568',
            'name' => 'Roly Flores Montaño',
            'email' => 'encargado.almacen.scz@gmail.com',
            'password' => Hash::make('*Sit*24*'),
            'company_position' => 'Encargado de Almacen',
            'phone_number' => '74636352',
        ])->assignRole('Encargado de Almacen');

        Branch::create([
            'id' => '1',
            'name' => 'Activo Fijos',
            'department' => 'Santa Cruz',
            'direction' => 'Dir. Av. Mariscal Santa Cruz # 6350',
            'number_phone' => '73131938',
            'user_id' => '2'
        ]);
        Branch::create([
            'id' => '2',
            'name' => 'Sucursal Santa Cruz',
            'department' => 'Santa Cruz',
            'direction' => 'Dir. Av. Mariscal Santa Cruz # 6350',
            'number_phone' => '74636352',
            'user_id' => '3'
        ]);    

        Projects::create([
            'cuce' => '4651-4542-4242A',
            'type' => 'LP',
            'object' => 'Mantenimiento Control de Acceso Gestion 2023',
            'entity' => 'YPFB',
            'ubi_entity' => 'Santa Cruz',
            'ubi_projects' => 'Santa Cruz',
            'date_opening' => '12-09-12',
            'date_notification' => '12-09-12',
            'reference_price' => '150000',
            'id_user' => 2,
        ]);
        // Inventory::factory(100)->create();

        // Workers::create([
        //     'ci' => '8178854',
        //     'name' => 'Juan',
        //     'last_name' => 'Perez',
        //     'phone_number' => '73131938',
        //     'ubication' => 'Santa Cruz',
        //     'company_position' => 'Encargado de Activo',  
        // ]);
        // Workers::create([
        //     'ci' => '81819556',
        //     'name' => 'Pedro',
        //     'last_name' => 'Gonzalez',
        //     'phone_number' => '123456789',
        //     'ubication' => 'La Paz',
        //     'company_position' => 'Empleado',          
        // ]);

        // AssetAllocation::create([
        //     'receipt_number'=> 'A-1.1',
        //     'movement_type'=> 'trabajo',
        //     'departure_date'=> '2024-04-30',
        //     'departure_time'=> '10:00:58',
        //     'return_date'=> null,
        //     'return_time'=> null,
        //     'missing_amount'=> 10,
        //     'state'=> 0,
        //     'state_create'=> 0,
        //     'branch_id'=> 1,
        //     'auth'=> 2,
        //     'id_worker'=> 1,
        //     'id_inventory'=> 100,
        // ]);

        // AssetAllocation::create([
        //     'receipt_number'=> 'A-1.1',
        //     'movement_type'=> 'trabajo',
        //     'departure_date'=> '2024-04-30',
        //     'departure_time'=> '10:00:58',
        //     'return_date'=> null,
        //     'return_time'=> null,
        //     'missing_amount'=> 10,
        //     'state'=> 0,
        //     'state_create'=> 0,
        //     'branch_id'=> 1,
        //     'auth'=> 2,
        //     'id_worker'=> 1,
        //     'id_inventory'=> 99,
        // ]);

        // AssetAllocation::create([
        //     'receipt_number'=> 'A-1.2',
        //     'movement_type'=> 'trabajo',
        //     'departure_date'=> '2024-04-30',
        //     'departure_time'=> '10:00:58',
        //     'return_date'=> null,
        //     'return_time'=> null,
        //     'missing_amount'=> 10,
        //     'state'=> 0,
        //     'state_create'=> 0,
        //     'branch_id'=> 1,
        //     'auth'=> 2,
        //     'id_worker'=> 1,
        //     'id_inventory'=> 98,
        // ]);

        // AssetAllocation::create([
        //     'receipt_number'=> 'A-1.3',
        //     'movement_type'=> 'trabajo',
        //     'departure_date'=> '2024-04-30',
        //     'departure_time'=> '10:00:58',
        //     'return_date'=> null,
        //     'return_time'=> null,
        //     'missing_amount'=> 10,
        //     'state'=> 0,
        //     'state_create'=> 0,
        //     'branch_id'=> 1,
        //     'auth'=> 2,
        //     'id_worker'=> 1,
        //     'id_inventory'=> 96,
        // ]);
        // AssetAllocation::create([
        //     'receipt_number'=> 'A-1.3',
        //     'movement_type'=> 'trabajo',
        //     'departure_date'=> '2024-04-30',
        //     'departure_time'=> '10:00:58',
        //     'return_date'=> null,
        //     'return_time'=> null,
        //     'missing_amount'=> 10,
        //     'state'=> 0,
        //     'state_create'=> 0,
        //     'branch_id'=> 1,
        //     'auth'=> 2,
        //     'id_worker'=> 1,
        //     'id_inventory'=> 98,
        // ]);  
        // Projects::create([
        //     'cuce' => '4651-4542-4242A',
        //     'type' => 'LP',
        //     'object' => 'Mantenimiento Aires Acondicionados',
        //     'entity' => 'YPFB',
        //     'ubi_entity' => 'Santa Cruz',
        //     'ubi_projects' => 'Santa Cruz',
        //     'date_opening' => '12-09-12',
        //     'date_notification' => '12-09-12',
        //     'reference_price' => '150000',
        //     'id_user' => 2,
        // ]);   

        // Movements::create([
        //     'receipt_number' => 'M-1.1',
        //     'movement_type' => 'trabajo',
        //     'departure_date' => '2024-04-30',
        //     'departure_time' => '10:00:58',
        //     'return_date' => null,
        //     'return_time' => null,
        //     'missing_amount' => 10,
        //     'state' => 0,
        //     'state_create' => 0,
        //     'branch_id' => 2,
        //     'auth' => 3,
        //     'id_project' => 1,
        //     'id_inventory' => 100,
        // ]);

        // Movements::create([
        //     'receipt_number' => 'M-1.1',
        //     'movement_type' => 'trabajo',
        //     'departure_date' => '2024-04-30',
        //     'departure_time' => '10:00:58',
        //     'return_date' => null,
        //     'return_time' => null,
        //     'missing_amount' => 10,
        //     'state' => 0,
        //     'state_create' => 0,
        //     'branch_id' => 2,
        //     'auth' => 3,
        //     'id_project' => 1,
        //     'id_inventory' => 99,
        // ]);

        // Movements::create([
        //     'receipt_number' => 'M-1.2',
        //     'movement_type' => 'trabajo',
        //     'departure_date' => '2024-04-30',
        //     'departure_time' => '10:00:58',
        //     'return_date' => null,
        //     'return_time' => null,
        //     'missing_amount' => 10,
        //     'state' => 0,
        //     'state_create' => 0,
        //     'branch_id' => 2,
        //     'auth' => 3,
        //     'id_project' => 1,
        //     'id_inventory' => 98,
        // ]);

        // Movements::create([
        //     'receipt_number' => 'M-1.3',
        //     'movement_type' => 'trabajo',
        //     'departure_date' => '2024-04-30',
        //     'departure_time' => '10:00:58',
        //     'return_date' => null,
        //     'return_time' => null,
        //     'missing_amount' => 10,
        //     'state' => 0,
        //     'state_create' => 0,
        //     'branch_id' => 2,
        //     'auth' => 3,
        //     'id_project' => 1,
        //     'id_inventory' => 96,
        // ]);
        // Movements::create([
        //     'receipt_number' => 'M-1.3',
        //     'movement_type' => 'trabajo',
        //     'departure_date' => '2024-04-30',
        //     'departure_time' => '10:00:58',
        //     'return_date' => null,
        //     'return_time' => null,
        //     'missing_amount' => 10,
        //     'state' => 0,
        //     'state_create' => 0,
        //     'branch_id' => 2,
        //     'auth' => 3,
        //     'id_project' => 1,
        //     'id_inventory' => 98,
        // ]);

    }
}
