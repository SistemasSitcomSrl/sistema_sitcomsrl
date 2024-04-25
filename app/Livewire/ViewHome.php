<?php

namespace App\Livewire;

use App\Models\Inventory;
use App\Models\Movements;
use App\Models\Trasnfer;
use App\Models\Branch;
use App\Models\TransfersInventories;
use App\Models\TransferRequired;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ViewHome extends Component
{
    public function render()
    {
        //Cantidad de Sucursales
        $branch_count = Branch::count();

        //Cantidad de Herramientas
        $tool_count = Inventory::count();

        //id de la sucurusal a la que pertenece el usuario
        $branch_id = Branch::where('user_id', Auth::user()->id)->value('id');

        $transfer = Trasnfer::select(
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
            })
            ->get();

        $transfer_count = $transfer->filter(function ($transfer) {
            return $transfer->status == false;
        })->count();


        $movement = Movements::select(
            'movements.receipt_number',
            'movements.state',
        )
            ->groupBy(
                'movements.receipt_number',
                'movements.state',
            )
            ->havingRaw('COUNT(movements.receipt_number) >= 1')
            ->havingRaw('MIN(CAST(state AS INTEGER)) = 0')
            ->where(function ($query) use ($branch_id) {
                // Si $branch_id es null, no aplicamos la condición
                if (Auth::user()->id != 1) {
                    $query->where('branch_id', $branch_id);
                }
            })->get();
        $movement_count = $movement->filter(function ($movement) {
            return $movement->status == false;
        })->count();



        $requestInventory = TransfersInventories::select(
            'receipt_number',
            'state_create',
        )
            ->groupBy(
                'receipt_number',
                'state_create',
            )
            ->havingRaw('COUNT(receipt_number) >= 1')
            ->havingRaw('MIN(CAST(state_create AS INTEGER)) != 1')
            ->where(function ($query) use ($branch_id) {
                // Si $branch_id es null, no aplicamos la condición
                if (Auth::user()->id != 1) {
                    $query->where('branch_id', $branch_id);
                }
            })->get();

        $requestInventory_count = $requestInventory->filter(function ($requestInventory) {
            return $requestInventory->status == false;
        })->count();


        $retired = TransferRequired::select(
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
            ->where(function ($query) use ($branch_id) {
                // Si $branch_id es null, no aplicamos la condición
                if (Auth::user()->id != 1) {
                    $query->where('branch_id', $branch_id);
                }
            })->get();

        $retired_count = $retired->filter(function ($retired) {
            return $retired->status == false;
        })->count();

        return view('livewire.view-home', compact('tool_count', 'branch_count', 'transfer_count', 'movement_count', 'requestInventory_count', 'retired_count'));
    }
}
