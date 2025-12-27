<?php

namespace App\Http\Controllers;

use App\Models\TransferRequired;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TransferRequiredController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.retired.index')->only('index');
        $this->middleware('can:admin.retired.index_activo')->only('index_activo');
        $this->middleware('can:admin.retired.create')->only('create');
    }
    public function index()
    {
        return view('admin.inventory.retired');
    }
    public function index_activo()
    {
        return view('admin.inventory.retired');
    }
    public function create()
    {
        return view('admin.inventory.show-retired');
    }

    public function download(Request $request)
    {
        $date_create = TransferRequired::where('receipt_number', request('retired_receipt_number'))->value('created_at');
        $fecha = $date_create->toDateString(); // Obtener solo la fecha en formato 'YYYY-MM-DD'
        $hora = $date_create->toTimeString(); // Obtener solo la hora en formato 'HH:MM:SS'

        $pdf = PDF::setPaper('letter')->loadView('livewire.solicitudRetiro.report-inventory-retired', [
            'movements' =>
                TransferRequired::join('users', 'transfer_requireds.auth', 'users.id')
                    ->join('branches', 'transfer_requireds.branch_id', 'branches.id')
                    ->join('inventories', 'transfer_requireds.id_inventory', 'inventories.id')
                    ->select(
                        'branches.name as branch_name',
                        'branches.department as branch_department',
                        'branches.direction as branch_direction',
                        'users.name as user_name',
                        'users.company_position as user_company_position',
                        'users.phone_number as user_phone_number',
                        'inventories.name_equipment',
                        'inventories.bar_Code',
                        'inventories.brand',
                        'inventories.type',
                        'inventories.unit_measure',
                        'inventories.location',
                        'inventories.price',
                        'transfer_requireds.message',
                        'transfer_requireds.message_request',
                        'transfer_requireds.receipt_number',
                    )
                    ->where('receipt_number', request('retired_receipt_number'))
                    ->orderBy('message_request', 'asc')
                    ->get(),
            'date' => $fecha,
            'time' => $hora
        ]);
        return $pdf->stream('Retirados_' . request('retired_receipt_number') . '_' . $fecha . '.pdf');
    }
}
