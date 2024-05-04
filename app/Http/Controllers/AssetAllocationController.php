<?php

namespace App\Http\Controllers;

use App\Models\AssetAllocation;
use App\Models\AssetHistory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AssetAllocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.assign.index')->only('index');
        $this->middleware('can:admin.assign.create')->only('create');
    }

    public function index()
    {
        return view('admin.assign.index');
    }
    public function create()
    {
        return view('admin.assign.create');
    }
    public function pdf(Request $request)
    {
        $id_worker = request('movement_receipt_number');
        $state = request('state');
        $state_create = request('state_create');

        $date_create = AssetAllocation::where('id_worker', $id_worker)->value('departure_date');

        $pdf = PDF::setPaper('letter')->loadView('livewire.asignar.report-asset', [
            'movements' =>
                AssetAllocation::join('inventories', 'inventories.id', '=', 'asset_allocations.id_inventory')
                    ->join('workers', 'workers.id', '=', 'asset_allocations.id_worker')
                    ->join('users', 'users.id', '=', 'asset_allocations.auth')
                    ->join('branches', 'branches.id', '=', 'asset_allocations.branch_id')
                    ->select(
                        'inventories.id',
                        'inventories.name_equipment',
                        'inventories.bar_Code',
                        'inventories.brand',
                        'inventories.branch_id',
                        'inventories.unit_measure',
                        'inventories.type',
                        'inventories.price',
                        'asset_allocations.id as id_movements',
                        'asset_allocations.missing_amount',
                        'asset_allocations.return_amount',
                        'asset_allocations.receipt_number',
                        'asset_allocations.created_at',                        
                        'users.name as user_name',
                        'users.company_position as user_company_position',
                        'users.phone_number as user_phone_number',
                        'branches.name as branch_branch',
                        'branches.direction as branch_direction',
                        'workers.name as worker_name',
                        'workers.last_name as worker_last_name',
                        'workers.ci as worker_ci',
                        'workers.ubication as worker_ubication',
                        'workers.phone_number as worker_phone_number',
                        'workers.company_position as worker_company_position'
                    )
                    ->where('asset_allocations.id_worker', $id_worker)
                    ->where('asset_allocations.state', $state)
                    ->get(),
            'movements_histories' => AssetHistory::select()->get(),
            'state_create' => $state_create
        ]);

        return $pdf->stream('Comprobante_' . $id_worker . '_' . $date_create . '.pdf');
    }
}
