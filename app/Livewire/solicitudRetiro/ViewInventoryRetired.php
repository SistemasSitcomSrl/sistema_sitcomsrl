<?php

namespace App\Livewire\SolicitudRetiro;

use App\Models\Inventory;
use App\Models\TransferRequired;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ViewInventoryRetired extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $search = '';
    public $orderSort = 'custom_id';
    public $orderDirection = 'asc';
    public $cant = '10';
    public $openUpdate = false;
    public $openDecline = false;
    public $openImagen = false;
    public $openDeclineMessage = false;
    public $tool_id;
    public $stateButtom;
    public $textDecline;
    public $receipt_number;
    public $imageTool;
    protected $listeners = ['checkTool', 'render'];
    public $messageForm = [
        'message' => '',
        'messageDecline' => ''
    ];
    protected $queryString = [
        'orderSort' => ['except' => 'id'],
        'cant' => ['except' => '10'],
        'orderDirection' => ['except' => 'desc']
    ];
    protected $validationAttributes = [
        'textDecline' => ''
    ];
    public function openImagenTool($idToll)
    {
        $this->openImagen = true;
        $this->imageTool = TransferRequired::where('id', $idToll)->value('image_path');
    }
    public function open()
    {
        $this->resetPage();
        $this->openUpdate = true;
        $this->stateButtom = TransferRequired::where('receipt_number', $this->receipt_number)->value('state');       
    }
    public function openMessage($toolId)
    {
        $this->openDeclineMessage = true;
        $toolMessage = TransferRequired::where('id', $toolId)->value('message_request');
        $this->messageForm['messageDecline'] = $toolMessage;
    }
    public function cancelRequest()
    {
        $toolStates = TransferRequired::select('state')->where('receipt_number', $this->receipt_number)->get();
        $state = true;
        foreach ($toolStates as $tool) {
            if ($tool->state != 0) {
                $state = false;
                break;
            }
        }
        $this->dispatch('render');
        if ($state) {

            TransferRequired::where('receipt_number', $this->receipt_number)->update([
                'state' => 3
            ]);
            $stateTrue = TransferRequired::where('state_request', null)->where('receipt_number', $this->receipt_number)->get();

            foreach ($stateTrue as $tool) {
                Inventory::where('id', $tool->id_inventory)->increment('amount', 1);
            }
            $this->dispatch('render-view-inventory-retired');
            $this->reset('openUpdate','orderSort','orderDirection','cant','search');
            $this->dispatch('alert', 'Solcitud de Anulacion Enviado Con Exito');

        } else {
            $this->openUpdate = false;      
            $this->dispatch('alert2', 'Solicitud En Proceso, No puede Anualar');                
            $this->dispatch('render-view-inventory-retired');
        }

    }
    public function checkTool($toolId)
    {
        $stateCancel = TransferRequired::find($toolId['id']);
        if ($stateCancel->state == 3) {
            $this->openUpdate = false;
            $this->dispatch('alert2', 'Solicitud Fue anulada');
            $this->dispatch('render-view-inventory-retired');
        } else {
            $updateTool = TransferRequired::find($toolId['id']);
            $updateTool->update(['message_request' => null, 'state_request' => 1]);

            TransferRequired::where('receipt_number', $toolId['receipt_number'])->update([
                'state' => 2
            ]);

            $this->dispatch('render-view-inventory-retired');
        }
    }
    public function checkDecline($toolId)
    {
        $stateCancel = TransferRequired::find($toolId);
        if ($stateCancel->state == 3) {
            $this->openUpdate = false;
            $this->dispatch('alert2', 'Solicitud Fue anulada');
            $this->dispatch('render-view-inventory-retired');
        } else {
            $this->openDecline = true;
            $this->reset('textDecline');
            $this->resetValidation();
            $this->tool_id = $toolId;
        }
    }
    public function declineRequest()
    {
        $this->validate([
            'textDecline' => 'required|min:5',
        ]);
        TransferRequired::where('id', $this->tool_id)->update([
            'message_request' => $this->textDecline,
            'state_request' => 0
        ]);
        TransferRequired::where('receipt_number', $this->receipt_number)->update([
            'state' => 2
        ]);
        $this->dispatch('render-view-inventory-retired');
        $this->reset('textDecline', 'openDecline');
        $this->resetValidation('textDecline');
        $this->dispatch('alert', 'Solcitud Enviado Con Exito');
    }
    public function acceptpApplication()
    {
        $toolStates = TransferRequired::select('state', 'state_request')->where('receipt_number', $this->receipt_number)->get();
        $state = true;
        foreach ($toolStates as $tool) {
            $cancelState = $tool->state;
            if ($tool->state_request == null) {
                $state = null;
                break;
            }
        }

        if ($cancelState == 3) {
            $this->openUpdate = false;
            $this->dispatch('alert2', 'Solicitud Fue anulada');
            $this->dispatch('render-view-inventory-retired');
        } else {
            if ($state) {
                TransferRequired::where('receipt_number', $this->receipt_number)->update([
                    'state' => 1
                ]);
                $stateTrue = TransferRequired::where('state_request', 0)->where('receipt_number', $this->receipt_number)->get();
                foreach ($stateTrue as $tool) {
                    Inventory::where('id', $tool->id_inventory)->increment('amount', 1);
                }
                $this->dispatch('alert', 'Enviado con Exito');
                $this->reset('openUpdate','orderSort','orderDirection','cant','search');
                $this->dispatch('render-view-inventory-retired');
            } else {
                $this->dispatch('alert2', 'Solicitud Pendiente');
            }
        }
    }
    public function closeModalView(){
        $this->openUpdate = false;
        $this->dispatch('render-view-inventory-retired');
        $this->reset('orderSort','orderDirection','cant','search');
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
        $inventories = TransferRequired::select(
            'transfer_requireds.id',
            'transfer_requireds.receipt_number',
            'transfer_requireds.custom_id',
            'transfer_requireds.amount',
            'transfer_requireds.image_path',
            'transfer_requireds.state',
            'transfer_requireds.state_request',
            'transfer_requireds.auth',
            'transfer_requireds.message',
            'transfer_requireds.id_inventory',
            'transfer_requireds.branch_id',
            'inventories.name_equipment',
            'inventories.bar_Code',
            'inventories.brand',
            'inventories.color',
            'inventories.location',
            'inventories.unit_measure',
            'inventories.price',
            'inventories.type',
        )
            ->join('inventories', 'inventories.id', '=', 'transfer_requireds.id_inventory')
            ->where('transfer_requireds.receipt_number', $this->receipt_number)
            ->where('inventories.name_equipment', 'like', '%' . $this->search . '%')
            ->orderBy($this->orderSort, $this->orderDirection)
            ->paginate($this->cant);
        return view('livewire.solicitudRetiro.view-inventory-retired', compact('inventories'));
    }
}
