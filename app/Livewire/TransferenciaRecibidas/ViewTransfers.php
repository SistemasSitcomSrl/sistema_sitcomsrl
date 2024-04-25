<?php

namespace App\Livewire\TransferenciaRecibidas;

use App\Models\Inventory;
use App\Models\TransferHistory;
use App\Models\Trasnfer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ViewTransfers extends Component
{
    use WithPagination;
    public $search = '';
    public $orderSort = 'id_inventory';
    public $orderDirection = 'asc';
    public $cant = '10';
    public $openUpdate = false;
    public $openImagen = false;
    public $receipt_number;
    public $selectedProducts = [null];
    public $selectedValues = [];
    public $imageTool;

    public function editar($idToll)
    {
        $this->openImagen = true;
        $this->imageTool = Inventory::find($idToll);
    }
    public function open()
    {
        $this->resetPage();
        $this->openUpdate = true;
    }
    public function save()
    {
        foreach ($this->selectedValues as $id_Movements => $amount) {
            if ($amount != 0) {
                $movementsProducts = Trasnfer::whereKey($id_Movements)->select('id_inventory', 'missing_amount', 'return_amount', 'branch_to_id')->first();
                if ($movementsProducts->missing_amount != $movementsProducts->return_amount && $movementsProducts->missing_amount >= $movementsProducts->return_amount) {
                    $total = $movementsProducts->return_amount + $amount;
                    if ($movementsProducts->missing_amount >= $total) {
                        if ($total == $movementsProducts->missing_amount) {
                            Trasnfer::whereKey($id_Movements)->update([
                                'return_date' => date('Y-m-d'),
                                'return_time' => date('H:i:s'),
                                'state' => true
                            ]);
                        }
                        TransferHistory::create(
                            [
                                'transfer_id' => $id_Movements,
                                'return_date' => date('Y-m-d'),
                                'return_time' => date('H:i:s'),
                                'return_amount' => $amount,
                                'auth' => Auth::user()->id
                            ]
                        );
                        Trasnfer::whereKey($id_Movements)->increment('return_amount', $amount);

                        $bar_code = Inventory::whereKey($movementsProducts->id_inventory)->value('bar_Code');

                        $productoOriginal = Inventory::find($movementsProducts->id_inventory);

                        $AllBarCode = Inventory::where('branch_id', $movementsProducts->branch_to_id)
                            ->where('bar_Code', $bar_code)->exists();

                        if ($AllBarCode) {
                            Inventory::where('branch_id', $movementsProducts->branch_to_id)->where('bar_Code', $bar_code)->increment('amount', $amount);
                        } else {
                            $nuevoProducto = $productoOriginal->replicate();
                            $nuevoProducto->amount = $amount;
                            $nuevoProducto->branch_id = $movementsProducts->branch_to_id;
                            $nuevoProducto->save();
                        }
                        $this->selectedProducts[$id_Movements] = false;
                        $this->dispatch('alert4', 'Solicitud Enviado Con Exito');
                    }
                }
            }
        }

        $this->dispatch('render-view-trasnfers');
        $this->reset('selectedProducts', 'selectedValues');
    }
    public function inputEnable()
    {
        //Ordenar selectedValues de acuerdo a su index
        ksort($this->selectedValues);

        //Realizar ciclo para verificar el estado si esta "Tickeado".
        //Destickeado elimina el valor de las dos variables de acuerdo a su index($id_movement)
        foreach ($this->selectedProducts as $id_movement => $state) {
            if ($id_movement != 0) {
                if ($state == false) {
                    unset($this->selectedProducts[$id_movement]);
                    unset($this->selectedValues[$id_movement]);
                }
            }
        }
    }
    public function inputValidate()
    {
        //Ordenar selectedValues de acuerdo a su index
        ksort($this->selectedValues);

        //Eliminar los valores "0" de selectedValues
        foreach ($this->selectedValues as $index => $value) {
            if ($value == "0") {
                unset($this->selectedValues[$index]);
            }
        }
    }
    public function order($orderSort)
    {
        if ($this->orderSort == $orderSort) {

            if ($this->orderDirection == 'desc') {
                $this->orderDirection = 'asc';
            } else {
                $this->orderDirection = 'desc';
            }
        } else {
            $this->orderSort = $orderSort;
        }
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $inventories = Trasnfer::join('inventories', 'inventories.id', '=', 'trasnfers.id_inventory')
            ->select('trasnfers.*', 'trasnfers.id as id_trasnfers', 'trasnfers.state as state_trasnfers', 'inventories.*', )
            ->where('receipt_number', $this->receipt_number)
            ->where('name_equipment', 'like', '%' . $this->search . '%')
            ->orderBy($this->orderSort, $this->orderDirection)
            ->paginate($this->cant);

        $movements_histories = TransferHistory::select()->get();

        return view('livewire.transferenciaRecibidas.view-transfers', compact('inventories', 'movements_histories'));
    }
}
