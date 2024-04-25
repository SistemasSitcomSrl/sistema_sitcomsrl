<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Inventory;
use App\Models\TransfersInventories;
use App\Models\Trasnfer;
use App\Models\TransferHistory;
use App\Models\TransferRequired;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.inventory.index')->only('index');
        $this->middleware('can:admin.transfer-receive.index')->only('transferReceived');
        $this->middleware('can:admin.transfer-sent.index')->only('transferSent');
        $this->middleware('can:admin.transfer-sent.create')->only('createTransfer');
        $this->middleware('can:admin.request.index')->only('requestInventory');

    }
    public function index()
    {
        return view('admin.inventory.index');
    }
    public function transferReceived()
    {
        return view('admin.inventory.transfer');
    }
    public function transferSent()
    {
        return view('admin.inventory.transfer-sent');
    }
    public function createTransfer()
    {
        return view('admin.inventory.create');
    }
    public function create()
    {
        return view('admin.inventory.create-inventory');
    }
    public function requestInventory()
    {
        return view('admin.inventory.request');
    }
    public function retiredInventory()
    {
        return view('admin.inventory.retired');
    }
    public function createRetired()
    {
        return view('admin.inventory.show-retired');
    }
    public function downloadTransferSent(Request $request)
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
    public function downloadResquestCreate(Request $request)
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
    public function downloadInventoryRetired(Request $request)
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
    public function downloadInventory(Request $request)
    {
        if (request('branch_inventory') != 0) {
            $tools = Inventory::where('branch_id', request('branch_inventory'))->get();
            $name = Branch::where('id', request('branch_inventory'))->value('name');

        } else {
            $tools = Inventory::all();
            $name = "Todas las Sucursales";
        }
        $pdf = PDF::setPaper('letter')->loadView('livewire.herramientas.report-inventory', [
            'movements' => $tools,
            'nameBranch' => $name
        ]);
        return $pdf->stream('Inventario_' . $name . '_' . date('Y-m-d H:i:s') . '.pdf');


    }

}
