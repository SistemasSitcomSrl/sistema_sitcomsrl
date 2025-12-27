<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.inventory.index')->only('index');
        $this->middleware('can:admin.inventory.index_activo')->only('index_activo');

    }
    public function index()
    {
        return view('admin.inventory.index');
    }
    public function index_activo()
    {
        return view('admin.inventory.index');
    }
    public function download(Request $request)
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
