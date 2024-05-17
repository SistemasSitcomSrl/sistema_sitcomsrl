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
use Illuminate\Support\Facades\Storage;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Storage::deleteDirectory('livewire-tmp');
        Storage::deleteDirectory('temp-images');
        Storage::deleteDirectory('tool');

        Storage::makeDirectory('livewire-tmp');
        Storage::makeDirectory('temp-images');
        Storage::makeDirectory('tool');
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
            'name' => 'Santa Cruz',
            'department' => 'Santa Cruz',
            'direction' => 'Dir. Av. Mariscal Santa Cruz # 6350',
            'number_phone' => '73131938',
            'user_id' => '2'
        ]);
        Branch::create([
            'id' => '2',
            'name' => 'Santa Cruz',
            'department' => 'Santa Cruz',
            'direction' => 'Dir. Av. Mariscal Santa Cruz # 6350',
            'number_phone' => '74636352',
            'user_id' => '3'
        ]);    
    }
}
