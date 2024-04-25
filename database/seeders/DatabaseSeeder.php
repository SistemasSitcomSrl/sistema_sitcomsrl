<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Inventory;
use App\Models\User;
use App\Models\Projects;
use App\Models\Movements;

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
            'ci' => '5857568',
            'name' => 'Roly Flores Montaño',
            'email' => 'encargado.almacen.scz@gmail.com',
            'password' => Hash::make('*Sit*24*'),
            'company_position' => 'Encargado de Almacen',
            'phone_number' => '75617913',
        ])->assignRole('Encargado de Almacen');

        Branch::create([
            'id' => '1',
            'name' => 'Sucursal Santa Cruz',
            'department' => 'Santa Cruz',
            'direction' => 'Dir. Av. Mariscal Santa Cruz # 6350',
            'number_phone' => '74636352',
            'user_id' => '2'
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

        // Movements::create([
        //     'receipt_number' => 'M-1.1',
        //     'movement_type' => 'trabajo',
        //     'departure_date' => '2024-04-23',
        //     'departure_time' => '11:00:41',
        //     'return_date' => null,
        //     'return_time' => null,
        //     'missing_amount' => '10',
        //     'state' => '0',
        //     'state_create' => '0',
        //     'branch_id' => '1',
        //     'auth' => '2',
        //     'id_project' => '1',
        //     'id_inventory' => '1',
        // ]);
        // Movements::create([
        //     'receipt_number' => 'M-1.1',
        //     'movement_type' => 'trabajo',
        //     'departure_date' => '2024-04-23',
        //     'departure_time' => '11:00:41',
        //     'return_date' => null,
        //     'return_time' => null,
        //     'missing_amount' => '10',
        //     'state' => '0',
        //     'state_create' => '0',
        //     'branch_id' => '1',
        //     'auth' => '2',
        //     'id_project' => '1',
        //     'id_inventory' => '2',
        // ]);
        // Movements::create([
        //     'receipt_number' => 'M-1.1',
        //     'movement_type' => 'trabajo',
        //     'departure_date' => '2024-04-23',
        //     'departure_time' => '11:00:41',
        //     'return_date' => null,
        //     'return_time' => null,
        //     'missing_amount' => '10',
        //     'state' => '0',
        //     'state_create' => '0',
        //     'branch_id' => '1',
        //     'auth' => '2',
        //     'id_project' => '1',
        //     'id_inventory' => '3',
        // ]);
    }
}
