<?php

namespace App\Livewire;

use App\Models\AssetAllocation;
use App\Models\Inventory;
use App\Models\Movements;
use App\Models\Trasnfer;
use App\Models\Branch;
use App\Models\TransfersInventories;
use App\Models\TransferRequired;
use App\Models\Workers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ViewHome extends Component
{
    public function render()
    {
        //Obtener el rol del usuario
        $rol = Auth::user()->roles->first()->name ?? 'default';

        //id de la sucurusal a la que pertenece el usuario
        $branch_id = Branch::where('user_id', Auth::user()->id)->value('id');

        //ALMACEN

        //Obtener los id de las sucursales que tienen el rol encargado de activo
        $almacen_id_branch = Branch::join('model_has_roles', 'branches.user_id', '=', 'model_has_roles.model_id')
            ->where('model_has_roles.role_id', 3)
            ->pluck('branches.id')
            ->toArray() ?: [];

        switch ($rol) {
            case 'Administrador':
                $id_branch = array_diff(Branch::pluck('id')->toArray(), $almacen_id_branch);
                break;
            case 'Encargado de Activo':
            case 'Encargado de Almacen':
                // Mostrar solo datos de la sucursal a la que pertenece
                $id_branch = [$branch_id];
                break;
        }

        //Cantidad de Sucursales
        $branch_count = Branch::count();

        //Cantidad de Herramientas de almacen
        $tool_count = Inventory::whereIn('branch_id', $id_branch)->count();

        //Cantidad de Solicitudes de Inventario de almacen
        $requestInventory_count = TransfersInventories::select(
            'receipt_number',
            'state_create',
        )
            ->groupBy(
                'receipt_number',
                'state_create',
            )
            ->havingRaw('COUNT(receipt_number) >= 1')
            ->havingRaw('MIN(CAST(state_create AS INTEGER)) != 1')
            ->whereIn('branch_id', $id_branch)->count();

        //Cantidad de Solicitudes de dar de baja de almacen
        $retired_count = TransferRequired::select(
            'receipt_number',
            'state',
        )
            ->groupBy(
                'receipt_number',
                'state',
            )
            ->havingRaw('COUNT(receipt_number) >= 1')
            ->havingRaw('MIN(CAST(state AS INTEGER)) != 1')
            ->havingRaw('MIN(CAST(state AS INTEGER)) != 3')
            ->whereIn('branch_id', $id_branch)->count();

        //Cantidad de Movimientos de almacen
        $movement_count = Movements::select(
            'projects.object',
            'movements.state',
        )->join('projects', 'movements.id_project', '=', 'projects.id')
            ->groupBy(
                'projects.object',
                'movements.state',
            )
            ->havingRaw('COUNT(projects.object) >= 1')
            ->havingRaw('MIN(CAST(movements.state AS INTEGER)) = 0')
            ->whereIn('branch_id', $id_branch)->count();

        //Cantidad de Transferencias recibidas de otra sucursal
        $transfer_count = Trasnfer::select(
            'trasnfers.receipt_number',
            'trasnfers.state',
        )
            ->groupBy(
                'trasnfers.receipt_number',
                'trasnfers.state',
            )
            ->havingRaw('COUNT(trasnfers.receipt_number) >= 1')
            ->havingRaw('MIN(CAST(state AS INTEGER)) = 0')
            ->where(function ($query) use ($branch_id) {
                // Si $branch_id es null, no aplicamos la condición
                if (Auth::user()->id != 1) {
                    $query->where('trasnfers.branch_to_id', $branch_id);
                }
            })->count();

        //ACTIVO FIJO


        switch ($rol) {
            case 'Administrador':
                //Obtener los id de las sucursales que tienen el rol encargado de activo
                $activo_id_branch = Branch::join('model_has_roles', 'branches.user_id', '=', 'model_has_roles.model_id')
                    ->where('model_has_roles.role_id', 3)
                    ->pluck('branches.id')
                    ->toArray() ?: [];
                break;
            case 'Encargado de Almacen':
            case 'Encargado de Activo':
                // Mostrar solo datos de la sucursal a la que pertenece
                $activo_id_branch = [$branch_id];
                break;
        }

        //Cantidad de Trabajadores    
        $worker_count = Workers::count();

        //Cantidad de Herramientas de Activo Fijo
        $tool_count_active = Inventory::whereIn('branch_id', $activo_id_branch)->count();


        //Cantidad de Solicitudes de Inventario de Activo Fijo
        $requestInventory_count_active = TransfersInventories::select(
            'receipt_number',
            'state_create',
        )
            ->groupBy(
                'receipt_number',
                'state_create',
            )
            ->havingRaw('COUNT(receipt_number) >= 1')
            ->havingRaw('MIN(CAST(state_create AS INTEGER)) != 1')
            ->whereIn('branch_id', $activo_id_branch)->count();

        //Cantidad de Solicitudes de dar de baja de almacen
        $retired_count_active = TransferRequired::select(
            'receipt_number',
            'state',
        )
            ->groupBy(
                'receipt_number',
                'state',
            )
            ->havingRaw('COUNT(receipt_number) >= 1')
            ->havingRaw('MIN(CAST(state AS INTEGER)) != 1')
            ->havingRaw('MIN(CAST(state AS INTEGER)) != 3')
            ->whereIn('branch_id', $activo_id_branch)->count();

        //Cantidad de Asignaciones de activo fijo
        $assign_count = AssetAllocation::select(
            'workers.id',
            'asset_allocations.state',
        )->join('workers', 'asset_allocations.id_worker', '=', 'workers.id')
            ->groupBy(
                'workers.id',
                'asset_allocations.state',
            )
            ->havingRaw('COUNT(workers.id) >= 1')
            ->havingRaw('MIN(CAST(asset_allocations.state AS INTEGER)) = 0')
            ->whereIn('branch_id', $activo_id_branch)->count();


        return view('livewire.view-home', compact([
            'tool_count',
            'branch_count',
            'transfer_count',
            'movement_count',
            'requestInventory_count',
            'retired_count',
            'worker_count',
            'tool_count_active',
            'requestInventory_count_active',
            'retired_count_active',
            'assign_count',
        ]));
    }
}
