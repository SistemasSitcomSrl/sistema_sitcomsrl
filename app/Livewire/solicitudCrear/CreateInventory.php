<?php

namespace App\Livewire\SolicitudCrear;

use App\Models\Branch;
use App\Models\Inventory;
use App\Models\TransfersInventories;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use Livewire\WithPagination;
use Livewire\WithFileUploads;

class CreateInventory extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $orderAmount;
    public $id;
    public $search = '';
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = '13';
    public $openAdd = false;
    public $openCreate = false;
    public $create_name_equipment, $create_bar_Code, $create_brand, $create_color, $create_amount, $create_location, $create_unit_measure, $create_price, $create_image;

    public $toolsCollection;
    public $imageTool;
    public $select_type = '';
    public $selectedBranch = '';
    public $inventoryEditId = '';
    public $array_tool_id = [null];
    public $array_amount_tool = [null];
    public $searchArray;
    public $searchArrayDelete;
    public $idItemTool;
    public $stateInput = false;
    public $searchKey;
    public $searchImageTool;
    public $search_id = 0;
    public $inventorySearch;
    public $name_equipment, $bar_Code, $brand, $color, $amount, $location, $unit_measure, $price, $image, $type;
    protected $queryString = [
        'sort' => ['except' => 'id'],
        'cant' => ['except' => '10'],
        'direction' => ['except' => 'desc'],
        'search' => ['except' => ''],
    ];
    public $inventoryEdit = [
        'inventoryEdit.name_equipment' => '',
        'inventoryEdit.bar_Code' => '',
        'inventoryEdit.brand' => '',
        'inventoryEdit.color' => '',
        'inventoryEdit.amount' => '',
        'inventoryEdit.location' => '',
        'inventoryEdit.unit_measure' => '',
        'inventoryEdit.price' => '',
        'inventoryEdit.type' => '',
    ];
    public $searchForm = [
        'searchForm.create_name_equipment' => '',
        'searchForm.create_bar_Code' => '',
        'searchForm.create_brand' => '',
        'searchForm.create_color' => '',
        'searchForm.create_amount' => '',
        'searchForm.create_location' => '',
        'searchForm.create_unit_measure' => '',
        'searchForm.create_price' => '',
        'searchForm.create_image' => '',
        'searchForm.select_type' => ''
    ];
    public $validationAttributes = [
        'orderAmount' => 'numero',
        'create_name_equipment' => 'nombre',
        'searchForm.create_bar_Code' => 'codigo',
        'searchForm.create_brand' => 'marca',
        'searchForm.create_color' => 'modelo',
        'create_amount' => 'cantidad',
        'searchForm.create_location' => 'ubicación',
        'searchForm.create_unit_measure' => 'unidad',
        'searchForm.create_price' => 'precio',
        'searchForm.create_image' => 'imagen',
        'searchForm.select_type' => 'tipo hta.'
    ];
    public function mount()
    {
        $this->toolsCollection = collect();
    }
    public function openCreateModal()
    {
        $this->reset([
            'create_name_equipment',
            'create_amount',
            'create_image',
            'searchForm.create_bar_Code',
            'searchForm.create_brand',
            'searchForm.create_color',
            'searchForm.create_location',
            'searchForm.create_unit_measure',
            'searchForm.create_price',
        ]);
        $this->stateInput = false;
        $this->searchForm['select_type'] = "";
        $this->openCreate = true;
        $this->resetValidation();

    }
    public function createTool()
    {
        if ($this->stateInput == false) {
            $this->validate([
                'create_name_equipment' => 'required|max:50',
                'searchForm.create_bar_Code' => 'numeric|required|min:1|max:999999999999',
                'searchForm.create_brand' => 'required|max:50',
                'searchForm.create_color' => 'required|max:30',
                'create_amount' => 'numeric|required|min:1|max:999',
                'searchForm.create_location' => 'required|max:10',
                'searchForm.create_unit_measure' => 'required|max:10',
                'searchForm.create_price' => 'numeric|required|min:1|max:999999',
                'create_image' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'searchForm.select_type' => 'required'
            ]);
            $branch_id = Branch::where('user_id', Auth::user()->id)->value('id');

            $this->toolsCollection->push([
                'name_equipment' => $this->create_name_equipment,
                'bar_Code' => $this->searchForm['create_bar_Code'],
                'price' => $this->searchForm['create_price'],
                'brand' => $this->searchForm['create_brand'],
                'color' => $this->searchForm['create_color'],
                'amount' => $this->create_amount,
                'location' => $this->searchForm['create_location'],
                'unit_measure' => $this->searchForm['create_unit_measure'],
                'type' => $this->searchForm['select_type'],
                'branch_id' => $branch_id,
                'image_path' => $this->create_image->store('tool')
            ]);
            $this->reset('openCreate');
        } else {
            $this->validate([
                'create_name_equipment' => 'required|max:50',
                'create_amount' => 'numeric|required|min:1|max:999',
            ]);

            $amountTool = $this->create_amount;
            $array_tool_id = $this->array_tool_id;
            $id = $this->search_id;
            $searchArray = array_search($id, $array_tool_id);
            $this->searchArray = $searchArray;

            if ($array_tool_id != null) {
                if ($searchArray != false) {

                    $totalQuantity = $this->array_amount_tool[$searchArray] + $amountTool;
                    $amountTool = $totalQuantity;

                    array_push($this->array_amount_tool, "$amountTool");
                    array_push($this->array_tool_id, $id);

                    unset($this->array_tool_id[$searchArray]);
                    unset($this->array_amount_tool[$searchArray]);

                    $this->reset(['openCreate']);
                } else {
                    array_push($this->array_amount_tool, "$amountTool");
                    array_push($this->array_tool_id, $id);
                    $this->reset(['openCreate']);
                }
            } else {
                array_push($this->array_amount_tool, $amountTool);
                array_push($this->array_tool_id, $id);

                $this->reset(['openCreate']);
            }
        }
    }
    public function edit($idToll)
    {
        $this->resetValidation();
        $this->reset('orderAmount');
        $this->openAdd = true;
        $this->inventoryEditId = $idToll;
        $toll = Inventory::find($idToll);
        $this->imageTool = Inventory::find($idToll);
        $this->inventoryEdit['name_equipment'] = $toll->name_equipment;
        $this->inventoryEdit['bar_Code'] = $toll->bar_Code;
        $this->inventoryEdit['brand'] = $toll->brand;
        $this->inventoryEdit['color'] = $toll->color;
        $this->inventoryEdit['amount'] = $toll->amount;
        $this->inventoryEdit['location'] = $toll->location;
        $this->inventoryEdit['unit_measure'] = $toll->unit_measure;
        $this->inventoryEdit['price'] = $toll->price;
        $this->inventoryEdit['type'] = $toll->type;
        $this->id = $toll->id;
    }
    public function addTool($id)
    {
        $this->validate([
            'orderAmount' => 'numeric|required|min:1|max:999999999999',
        ]);

        $amountTool = $this->orderAmount;
        $array_tool_id = $this->array_tool_id;

        $searchArray = array_search($id, $array_tool_id);
        $this->searchArray = $searchArray;

        if ($array_tool_id != null) {
            if ($searchArray != false) {

                $totalQuantity = $this->array_amount_tool[$searchArray] + $amountTool;
                $amountTool = $totalQuantity;

                array_push($this->array_amount_tool, "$amountTool");
                array_push($this->array_tool_id, $id);

                unset($this->array_tool_id[$searchArray]);
                unset($this->array_amount_tool[$searchArray]);

                $this->reset(['orderAmount', 'openAdd']);
            } else {
                array_push($this->array_amount_tool, "$amountTool");
                array_push($this->array_tool_id, $id);
                $this->reset(['orderAmount', 'openAdd']);
            }
        } else {
            array_push($this->array_amount_tool, $amountTool);
            array_push($this->array_tool_id, $id);

            $this->reset(['orderAmount', 'openAdd']);
        }
    }
    public function create()
    {
        $countAll = count($this->array_amount_tool);
        $countCollection = $this->toolsCollection->isNotEmpty();

        if ($countAll > 1 || $countCollection == true) {

            $branch_id = Branch::where('user_id', Auth::user()->id)->value('id');

            $idMax = TransfersInventories::where('branch_id', $branch_id)->get()->max(function ($item) {
                // Dividir la cadena en letras y números              
                $idMax = explode(".", $item->receipt_number);
                // Obtener el número
                return $idMax[1];
            });
            $idMax++;
            $counterReceipt = 'R-' . $branch_id . '.' . $idMax;

            unset($this->array_tool_id[0]);
            unset($this->array_amount_tool[0]);
            $counter = 1;
            foreach ($this->toolsCollection as $toolData) {
                TransfersInventories::create([
                    'receipt_number' => $counterReceipt,
                    'id_inventory' => 0,
                    'custom_id' => $counter++,
                    'name_equipment' => $toolData['name_equipment'],
                    'bar_Code' => $toolData['bar_Code'],
                    'brand' => $toolData['brand'],
                    'color' => $toolData['color'],
                    'location' => $toolData['location'],
                    'unit_measure' => $toolData['unit_measure'],
                    'price' => $toolData['price'],
                    'amount' => $toolData['amount'],
                    'type' => $toolData['type'],
                    'image_path' => $toolData['image_path'],
                    'state_exist' => false,
                    'state_create' => false,
                    'departure_date' => date('Y-m-d'),
                    'departure_time' => date('H:i:s'),
                    'return_date' => null,
                    'retur_time' => null,
                    'auth' => Auth::user()->id,
                    'branch_id' => $branch_id,
                ]);
            }
            foreach ($this->array_tool_id as $key => $value) {

                $inventory_save = Inventory::find($value);
                TransfersInventories::create([
                    'receipt_number' => $counterReceipt,
                    'id_inventory' => $inventory_save->id,
                    'custom_id' => $counter++,
                    'name_equipment' => $inventory_save->name_equipment,
                    'bar_Code' => $inventory_save->bar_Code,
                    'brand' => $inventory_save->brand,
                    'color' => $inventory_save->color,
                    'location' => $inventory_save->location,
                    'unit_measure' => $inventory_save->unit_measure,
                    'price' => $inventory_save->price,
                    'type' => $inventory_save->type,
                    'image_path' => $inventory_save->image_path,
                    'state_exist' => true,
                    'state_create' => false,
                    'departure_date' => date('Y-m-d'),
                    'departure_time' => date('H:i:s'),
                    'return_date' => null,
                    'retur_time' => null,
                    'amount' => $this->array_amount_tool[$key],
                    'auth' => Auth::user()->id,
                    'branch_id' => $branch_id,
                ]);
            }
            $this->dispatch('alert', 'Creado con Exito');
            return redirect('solicitud');

        } else {
            $this->dispatch('alert2', 'Seleccione una Herramienta');
        }
    }
    public function deleteItemTool($idItemTool)
    {
        $this->idItemTool = $idItemTool;
        $searchArrayDelete = array_search($idItemTool, $this->array_tool_id);
        $this->searchArrayDelete = $searchArrayDelete;
        unset($this->array_tool_id[$searchArrayDelete]);
        unset($this->array_amount_tool[$searchArrayDelete]);
    }
    public function buscarHerramienta()
    {
        $branch_id = Branch::where('user_id', Auth::user()->id)->value('id');
        $inventorySearch = Inventory::where('branch_id', $branch_id)
            ->where('name_equipment', $this->create_name_equipment)
            ->first();
        $this->inventorySearch = $inventorySearch;
        if ($inventorySearch) {
            $this->search_id = $inventorySearch->id;
            $this->searchForm['create_name_equipment'] = $inventorySearch->name_equipment;
            $this->searchForm['create_bar_Code'] = $inventorySearch->bar_Code;
            $this->searchForm['create_brand'] = $inventorySearch->brand;
            $this->searchForm['create_color'] = $inventorySearch->color;
            $this->searchForm['create_location'] = $inventorySearch->location;
            $this->searchForm['create_unit_measure'] = $inventorySearch->unit_measure;
            $this->searchForm['create_price'] = $inventorySearch->price;
            $this->searchForm['select_type'] = $inventorySearch->type;
            $this->searchImageTool = $inventorySearch->image_path;
            $this->stateInput = true;
            $this->searchKey = rand();
            $this->resetValidation();
        } else {
            $this->searchForm['create_name_equipment'] = '';
            $this->searchForm['create_bar_Code'] = '';
            $this->searchForm['create_brand'] = '';
            $this->searchForm['create_color'] = '';
            $this->searchForm['create_amount'] = '';
            $this->searchForm['create_location'] = '';
            $this->searchForm['create_unit_measure'] = '';
            $this->searchForm['create_price'] = '';
            $this->searchForm['select_type'] = '';
            $this->create_amount = '';
            $this->searchKey = mt_rand();
            $this->stateInput = false;
        }
    }
    public function deleteKeyTool($idCollectionTool)
    {
        $this->toolsCollection->forget($idCollectionTool);
    }
    public function returnShow_movements()
    {
        return redirect('solicitud');
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function order($sort)
    {
        if ($this->sort == $sort) {

            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
        }
    }
    public function render()
    {
        $orderInventories = Inventory::whereKey($this->array_tool_id)->get();

        $branch_id = Branch::where('user_id', Auth::user()->id)->value('id');

        $movements = Inventory::where(function ($query) use ($branch_id) {
            if ($branch_id !== null) {
                $query->where('inventories.branch_id', $branch_id);
            } else {
                $query->where('inventories.branch_id', $this->selectedBranch);
            }
        })
            ->where('name_equipment', 'like', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->simplePaginate($this->cant);

        return view('livewire.solicitudCrear.create-inventory', compact('movements', 'orderInventories'));
    }
}
