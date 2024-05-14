<?php

namespace App\Http\Controllers;

use App\Models\Movements;
use App\Models\MovementHistory;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MovementController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.movement.index')->only('index');
        $this->middleware('can:admin.movement.create')->only('create');
    }

    public function index()
    {
        return view('admin.movement.index');
    }
    public function create()
    {
        return view('admin.movement.create');
    }
    public function download(Request $request)
    {
        $id_project = request('movement_receipt_number');
        $state = request('state');
        $state_create = request('state_create');
        $date_create = Movements::where('receipt_number', request('movement_receipt_number'))->value('departure_date');
        $pdf = PDF::setPaper('letter')->loadView('livewire.movimientos.report-movements', [
            'movements' =>
                Movements::join('inventories', 'inventories.id', '=', 'movements.id_inventory')
                    ->join('projects', 'projects.id', '=', 'movements.id_project')
                    ->join('users as users_project', 'users_project.id', '=', 'projects.id_user')
                    ->join('users as manager_store', 'manager_store.id', '=', 'movements.auth')
                    ->join('branches', 'branches.id', '=', 'movements.branch_id')
                    ->select(
                        'inventories.id',
                        'inventories.name_equipment',
                        'inventories.bar_Code',
                        'inventories.brand',
                        'inventories.branch_id',
                        'inventories.unit_measure',
                        'inventories.type',
                        'inventories.price',
                        'movements.id as id_movements',
                        'movements.missing_amount',
                        'movements.return_amount',
                        'movements.receipt_number',
                        'movements.departure_date',
                        'movements.departure_time',
                        'users_project.name',
                        'users_project.company_position',
                        'manager_store.name as manager_name',
                        'manager_store.company_position as manager_company_position',
                        'projects.object',
                        'projects.entity',
                        'projects.ubi_entity',
                        'branches.name as branch_branch',
                        'branches.direction as branch_direction'
                    )
                     ->where('movements.id_project', $id_project)
                    ->where('movements.state', $state)
                    ->get(),
                    'movements_histories' => MovementHistory::select()->get(),
                    'state_create' => $state_create
        ]);

        return $pdf->stream('Comprobante_' . request('movement_receipt_number') . '_' . $date_create . '.pdf');
    }
}

