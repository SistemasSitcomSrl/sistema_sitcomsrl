<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransfersInventories;
use Barryvdh\DomPDF\Facade\Pdf;

class TransfersInventoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.request.index')->only('index');
        $this->middleware('can:admin.request.index_activo')->only('index_activo');
        $this->middleware('can:admin.request.create')->only('create');
    }

    public function index()
    {
        return view('admin.inventory.request');
    }
    public function index_activo()
    {
        return view('admin.inventory.request');
    }
    public function create()
    {
        return view('admin.inventory.create-inventory');
    }
    public function download(Request $request)
    {
        $date_create = TransfersInventories::where('receipt_number', request('request_receipt_number'))->value('departure_date');
        $pdf = PDF::setPaper('letter')->loadView('livewire.solicitudCrear.report-inventory-request', [
            'movements' =>
                TransfersInventories::join('users', 'transfers_inventories.auth', 'users.id')
                    ->join('branches', 'transfers_inventories.branch_id', 'branches.id')
                    ->select(
                        'users.name as user_name',
                        'users.company_position as user_company_position',
                        'users.phone_number as user_phone_number',
                        'branches.name as branch_name',
                        'branches.department as branch_department',
                        'branches.direction as branch_direction',
                        'transfers_inventories.receipt_number',
                        'transfers_inventories.name_equipment',
                        'transfers_inventories.bar_Code',
                        'transfers_inventories.brand',
                        'transfers_inventories.color',
                        'transfers_inventories.unit_measure',
                        'transfers_inventories.location',
                        'transfers_inventories.price',
                        'transfers_inventories.type',
                        'transfers_inventories.state_exist',
                        'transfers_inventories.amount',
                        'transfers_inventories.departure_time',
                        'transfers_inventories.departure_date',
                    )
                    ->where('receipt_number', request('request_receipt_number'))->get(),
        ]);
        return $pdf->stream('Solicitud_' . request('request_receipt_number') . '_' . $date_create . '.pdf');
    }
}
