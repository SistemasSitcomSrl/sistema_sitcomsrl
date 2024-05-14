<?php

namespace App\Http\Controllers;
use App\Models\Trasnfer;
use App\Models\TransferHistory;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TransferController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.transfer-sent.index')->only('index');
        $this->middleware('can:admin.transfer-receive.index')->only('index_received');
        $this->middleware('can:admin.transfer-sent.create')->only('create');
    }

    public function index()
    {
        return view('admin.inventory.transfer-sent');
    }
    public function index_received()
    {
        return view('admin.inventory.transfer');
    }
    public function create()
    {
        return view('admin.inventory.create');
    }   
    public function download(Request $request)
    {
        $date_create = Trasnfer::where('receipt_number', request('movement_receipt_number'))->value('departure_date');

        $pdf = PDF::setPaper('letter')->loadView('livewire.transferenciaEnviadas.report-transfer-sent', [
            'movements' => Trasnfer::join('branches as branch_from', 'trasnfers.branch_from_id', 'branch_from.id')
                ->join('branches as branch_to', 'trasnfers.branch_to_id', 'branch_to.id')
                ->join('users as user_from', 'trasnfers.user_from_id', 'user_from.id')
                ->join('users as user_to', 'trasnfers.user_to_id', 'user_to.id')
                ->join('inventories', 'trasnfers.id_inventory', 'inventories.id')
                ->select(
                    'branch_from.name as branch_from_name',
                    'branch_from.department as branch_from_department',
                    'branch_from.direction as branch_from_direction',
                    'branch_from.number_phone as branch_from_number_phone',
                    'branch_to.name as branch_to_name',
                    'branch_to.department as branch_to_department',
                    'branch_to.direction as branch_to_direction',
                    'branch_to.number_phone as branch_to_number_phone',
                    'user_from.name as user_from_name',
                    'user_from.company_position as user_from_company_position',
                    'user_to.name as user_to_name',
                    'user_to.company_position as user_to_company_position',
                    'trasnfers.id as id_trasnfers',
                    'trasnfers.receipt_number',
                    'trasnfers.departure_date',
                    'trasnfers.departure_time',
                    'trasnfers.missing_amount',
                    'trasnfers.return_amount',
                    'inventories.id',
                    'inventories.name_equipment',
                    'inventories.bar_Code',
                    'inventories.brand',
                    'inventories.unit_measure',
                    'inventories.type',
                    'inventories.price',
                )
                ->where('receipt_number', request('transfer_receipt_number'))->get(),
            'movements_histories' => TransferHistory::select()->get()
        ]);

        return $pdf->stream('Transferencia_' . request('movement_receipt_number') . '_' . $date_create . '.pdf');
    }
}

