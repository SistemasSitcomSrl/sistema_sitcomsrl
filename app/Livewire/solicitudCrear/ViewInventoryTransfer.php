<?php

namespace App\Livewire\SolicitudCrear;

use App\Models\Inventory;
use App\Models\TransfersInventories;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class ViewInventoryTransfer extends Component
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
    public $openRequestMessage = false;
    public $openEdit = false;
    public $stateInput = false;
    public $stateInputAomunt = false;
    public $edit_name_equipment, $edit_bar_Code, $edit_brand, $edit_color, $edit_amount, $edit_location, $edit_unit_measure, $edit_price, $edit_image;
    public $select_type;
    public $state;
    public $toolEditId;
    public $update_image;
    public $textDecline;
    public $receipt_number;
    public $imageTool;
    public $messageForm = ['message' => ''];
    protected $queryString = [
        'orderSort' => ['except' => 'id'],
        'cant' => ['except' => '10'],
        'orderDirection' => ['except' => 'desc']
    ];
    protected $validationAttributes = [
        'textDecline' => 'Texto',
        'editForm.edit_name_equipment' => 'Nombre',
        'editForm.edit_bar_Code' => 'Codigo',
        'editForm.edit_brand' => 'Marca',
        'editForm.edit_color' => 'Modelo',
        'editForm.edit_amount' => 'Cantidad',
        'editForm.edit_location' => 'Ubicacion',
        'editForm.edit_unit_measure' => 'Unidad',
        'editForm.edit_price' => 'Precio',
        'editForm.edit_image' => 'Imagen',
        'editForm.select_type' => 'Tipo',
    ];
    public $editForm = [
        'editForm.edit_name_equipment' => '',
        'editForm.edit_bar_Code' => '',
        'editForm.edit_brand' => '',
        'editForm.edit_color' => '',
        'editForm.edit_amount' => '',
        'editForm.edit_location' => '',
        'editForm.edit_unit_measure' => '',
        'editForm.edit_price' => '',
        'editForm.edit_image' => '',
        'editForm.select_type' => '',
    ];
    public function edit($id_Tool)
    {
        $this->resetValidation([
            'editForm.edit_name_equipment',
            'editForm.edit_bar_Code',
            'editForm.edit_brand',
            'editForm.edit_color',
            'editForm.edit_amount',
            'editForm.edit_location',
            'editForm.edit_unit_measure',
            'editForm.edit_price',
            'editForm.edit_image',
            'editForm.select_type',
        ]);

        $this->reset([
            'editForm.edit_name_equipment',
            'editForm.edit_bar_Code',
            'editForm.edit_brand',
            'editForm.edit_color',
            'editForm.edit_amount',
            'editForm.edit_location',
            'editForm.edit_unit_measure',
            'editForm.edit_price',
            'editForm.edit_image',
            'editForm.select_type',
            'update_image',
            'edit_image'            
        ]);

        $this->openEdit = true;
        $this->toolEditId = $id_Tool;
        
        $tool = TransfersInventories::find($id_Tool);
        $this->editForm['edit_name_equipment'] = $tool->name_equipment;
        $this->editForm['edit_bar_Code'] = $tool->bar_Code;
        $this->editForm['edit_brand'] = $tool->brand;
        $this->editForm['edit_color'] = $tool->color;
        $this->editForm['edit_amount'] = $tool->amount;
        $this->editForm['edit_location'] = $tool->amount;
        $this->editForm['edit_unit_measure'] = $tool->unit_measure;
        $this->editForm['edit_price'] = $tool->price;
        $this->editForm['select_type'] = $tool->type;

        if ($tool->state_exist) {
            $this->edit_image = Inventory::where('id', $tool->id_inventory)->value('image_path');
            $this->stateInput = true;
        } else {
            $this->edit_image = $tool->image_path;
            $this->stateInput = false;
        }
    }
    public function update()
    {        
        $this->validate([
            'editForm.edit_name_equipment' => 'required|max:100',
            'editForm.edit_bar_Code' => 'numeric|required|min:1|max:999999999999',
            'editForm.edit_brand' =>'required|max:100',
            'editForm.edit_color' => 'required|max:100',
            'editForm.edit_amount' => 'numeric|required|min:1|max:99999',
            'editForm.edit_location' => 'required|max:100',
            'editForm.edit_unit_measure' => 'required|max:100',
            'editForm.edit_price' => 'numeric|required|min:1|max:999999',            
            'editForm.select_type' => 'required',            
        ]);
        
        $tool = TransfersInventories::find($this->toolEditId);
        
        $tool->update([
            'name_equipment' => $this->editForm['edit_name_equipment'],
            'bar_Code' => $this->editForm['edit_bar_Code'],
            'brand' => $this->editForm['edit_brand'],
            'color' => $this->editForm['edit_color'],
            'amount' => $this->editForm['edit_amount'],
            'location' => $this->editForm['edit_location'],
            'unit_measure' => $this->editForm['edit_unit_measure'],
            'price' => $this->editForm['edit_price'],
            'type' => $this->editForm['select_type'],
        ]); 
        TransfersInventories::where('receipt_number', $this->receipt_number)->update([         
            'updated_at' => date('Y-m-d H:i:s')
        ]);
       
        if ($this->update_image) {
            if ($tool->state_exist) {
                $inventory = Inventory::find($tool->id_inventory);
                if ($inventory->image_path) {
                    Storage::delete($inventory->image_path);
                }
                $inventory->image_path = $this->update_image->store('tool');
                $inventory->save();
                $this->update_image->delete();
            } else {
                if ($tool->image_path) {
                    Storage::delete($tool->image_path);
                }
                $tool->image_path = $this->update_image->store('tool');
                $tool->save();
                $this->update_image->delete();
            }
        }
        $this->resetValidation([
            'editForm.edit_name_equipment',
            'editForm.edit_bar_Code',
            'editForm.edit_brand',
            'editForm.edit_color',
            'editForm.edit_amount',
            'editForm.edit_location',
            'editForm.edit_unit_measure',
            'editForm.edit_price',
            'editForm.edit_image',
            'editForm.select_type',
        ]);
        $this->reset([
            'editForm.edit_name_equipment',
            'editForm.edit_bar_Code',
            'editForm.edit_brand',
            'editForm.edit_color',
            'editForm.edit_amount',
            'editForm.edit_location',
            'editForm.edit_unit_measure',
            'editForm.edit_price',
            'editForm.edit_image',
            'editForm.select_type',
            'update_image',
            'edit_image',
            'openEdit'            
        ]);
        $this->dispatch('alert4', 'Actualizado Exitosamente');
        $this->dispatch('render-view-inventory-transfer');
    }
    public function openImagenTool($idToll)
    {
        $this->openImagen = true;

        if (array_key_first($idToll) == 'id') {
            $this->imageTool = TransfersInventories::where('id', $idToll['id'])->value('image_path');
        } else {
            $this->imageTool = Inventory::where('id', $idToll['id_inventory'])->value('image_path');
        }
    }
    public function open()
    {
        $this->resetPage();
        $this->openUpdate = true;
        $this->state = TransfersInventories::where('receipt_number', $this->receipt_number)->value('state_create');
    }
    public function decline()
    {
        $this->openDecline = true;
        $this->reset('textDecline');
        $this->resetValidation();
    }
    public function declineRequest()
    {
        
        $this->validate([
            'textDecline' => 'required|min:5',
        ]);
        TransfersInventories::where('receipt_number', $this->receipt_number)->update([
            'debline_text' => $this->textDecline,
            'state_create' => 2,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        $this->reset('textDecline', 'openDecline', 'openUpdate','orderSort','orderDirection','cant');
        $this->resetValidation('textDecline');
        $this->dispatch('alert', 'Solicitud Enviado Con Exito');
        $this->dispatch('render-view-inventory-transfer');
    }
    public function acceptpApplication()
    {
        $inventories = TransfersInventories::where('receipt_number', $this->receipt_number)->get();
        foreach ($inventories as $inventory) {
            if ($inventory->state_exist) {

                Inventory::where('id', $inventory->id_inventory)->increment('amount', $inventory->amount);

                TransfersInventories::where('receipt_number',$this->receipt_number)
                ->update([
                    'state_create' => 1,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                Inventory::create([
                    'name_equipment' => $inventory->name_equipment,
                    'bar_Code' => $inventory->bar_Code,
                    'brand' => $inventory->brand,
                    'color' => $inventory->color,
                    'amount' => $inventory->amount,
                    'location' => $inventory->location,
                    'unit_measure' => $inventory->unit_measure,
                    'price' => $inventory->price,
                    'branch_id' => $inventory->branch_id,
                    'image_path' => $inventory->image_path,
                    'type' => $inventory->type
                ]);
                TransfersInventories::where('receipt_number',$this->receipt_number)->update([
                    'state_create' => 1,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
        $this->dispatch('alert', 'Creado con Exito');
        $this->reset('openUpdate','orderSort','orderDirection','cant');
        $this->dispatch('render-view-inventory-transfer');
    }
    public function acceptRequest(){
        TransfersInventories::where('receipt_number', $this->receipt_number)->update([
            'state_create' => 3,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        $this->reset('openUpdate','orderSort','orderDirection','cant');
        $this->dispatch('alert', 'Guardado con Exito');
        $this->dispatch('render-view-inventory-transfer');
    }
    public function openMessage()
    {
        $this->openRequestMessage = true;
        $this->messageForm['message'] = TransfersInventories::where('receipt_number', $this->receipt_number)->value('debline_text');
    }
    public function closeModalView(){
        $this->resetPage();
        $this->reset('openUpdate','orderSort','orderDirection','cant');
        $this->dispatch('render-view-inventory-transfer');
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
        $inventories = TransfersInventories::where('receipt_number', $this->receipt_number)
            ->where('name_equipment', 'like', '%' . $this->search . '%')
            ->orderBy($this->orderSort, $this->orderDirection)
            ->paginate($this->cant);
        $state_create = TransfersInventories::where('receipt_number', $this->receipt_number)->value('state_create');

        return view('livewire.solicitudCrear.view-inventory-transfer', compact('inventories', 'state_create'));
    }
}
