<?php

namespace App\Livewire\TransferenciaEnviadas;

use App\Models\Inventory;
use App\Models\TransferHistory;
use App\Models\Trasnfer;
use Livewire\Component;
use Livewire\WithPagination;

class ViewTransfersSent extends Component
{
    use WithPagination;
    public $search = '';
    public $orderSort = 'id_inventory';
    public $orderDirection = 'asc';
    public $cant = '10';
    public $openUpdate = false;
    public $openImagen = false;
    public $receipt_number;    
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
    public function close()
    {
        $this->resetPage();
        $this->reset('openUpdate','orderSort','orderDirection','cant','search');
        $this->dispatch('render-view-transfers-sent');
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
        return view('livewire.transferenciaEnviadas.view-transfers-sent', compact('inventories', 'movements_histories'));
    }
}
