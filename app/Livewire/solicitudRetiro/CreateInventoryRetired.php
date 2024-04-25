<?php
namespace App\Livewire\SolicitudRetiro;

use App\Models\Branch;
use App\Models\Inventory;
use App\Models\TransferRequired;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use Livewire\WithPagination;
use Livewire\WithFileUploads;


class CreateInventoryRetired extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $orderAmount = 1;
    public $toolEdit;
    public $search = '';
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = '13';
    public $openAdd = false;
    public $create_image;
    public $message;
    public $array_message = [];
    public $save_image = [];
    public $selectedBranch = '';
    public $array_tool_id = [];
    public $array_amount_tool = [];
    public $sumatoria;
    public $key = [];
    protected $queryString = [
        'sort' => ['except' => 'id'],
        'cant' => ['except' => '10'],
        'direction' => ['except' => 'desc'],
        'search' => ['except' => ''],
    ];
    public $inventoryEdit = [
        'name_equipment' => '',
        'bar_Code' => '',
        'brand' => '',
        'color' => '',
        'location' => '',
        'unit_measure' => '',
        'price' => '',
        'amount' => '',
        'type' => '',
    ];
    public $validationAttributes = [
        'create_image' => '',
        'message' => '',
    ];
    public function Validation()
    {
        $this->resetValidation('create_image');
    }
    public function edit($idToll)
    {
        $this->resetValidation();
        if ($this->create_image != null)
            $this->create_image->delete();

        $this->reset('orderAmount', 'create_image', 'message');
        $this->openAdd = true;
        $toll = Inventory::find($idToll);
        $this->inventoryEdit['name_equipment'] = $toll->name_equipment;
        $this->inventoryEdit['bar_Code'] = $toll->bar_Code;
        $this->inventoryEdit['brand'] = $toll->brand;
        $this->inventoryEdit['color'] = $toll->color;
        $this->inventoryEdit['price'] = $toll->price;
        $this->inventoryEdit['location'] = $toll->location;
        $this->inventoryEdit['type'] = $toll->type;
        $this->inventoryEdit['amount'] = $toll->amount;
        $this->inventoryEdit['orderAmount'] = 1;

        $this->toolEdit = $toll;
    }
    public function addTool($id_tool)
    {
        $this->validate([
            'orderAmount' => 'required|numeric|between:1,1',
            'create_image' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'message' => 'required'
        ]);
        $this->sumatoria = 0;
        $amountTool = $this->orderAmount;
        $array_tool_id = $this->array_tool_id;
        $array_amount_tool = $this->array_amount_tool;

        foreach ($array_tool_id as $key => $id) {
            if ($id == $id_tool) {
                $this->sumatoria += $array_amount_tool[$key];
            }
        }
        $totalQuantity = $amountTool + $this->sumatoria;
        $amountInventoryId = Inventory::where('id', $id_tool)->value('amount');

        if ($amountInventoryId >= $totalQuantity) {
            $image_path = $this->create_image->store('temp-images', 'public');
            array_push($this->save_image, $image_path);
            array_push($this->array_amount_tool, (int) $amountTool);
            array_push($this->array_tool_id, $id_tool);
            array_push($this->array_message, $this->message);
            $this->key = array_keys($this->array_amount_tool);

            $this->reset(['orderAmount', 'openAdd']);
        } else {
            $this->dispatch('alert2', 'La Sumatoria es: ' . $totalQuantity . ', Excede la Cantidad');
        }
    }
    public function create()
    {
        $countAll = count($this->array_amount_tool);

        if ($countAll >= 1) {

            $branch_id = Branch::where('user_id', Auth::user()->id)->value('id');

            $idMax = TransferRequired::where('branch_id', $branch_id)->get()->max(function ($item) {
                // Dividir la cadena en letras y números              
                $idMax = explode(".", $item->receipt_number);
                // Obtener el número
                return $idMax[1];
            });
            $idMax++;
            $counterReceipt = 'D-' . $branch_id . '.' . $idMax;
            $counter = 1;

            foreach ($this->array_tool_id as $key_value => $value) {

                $newPath = 'tool/' . basename($this->save_image[$key_value]);
                Storage::disk('public')->move($this->save_image[$key_value], $newPath);

                $inventory_save = Inventory::find($value);
                $stateTool = TransferRequired::create([
                    'receipt_number' => $counterReceipt,
                    'id_inventory' => $inventory_save->id,
                    'custom_id' => $counter++,
                    'image_path' => $newPath,
                    'state' => false,
                    'amount' => $this->array_amount_tool[$key_value],
                    'message' => $this->array_message[$key_value],
                    'auth' => Auth::user()->id,
                    'branch_id' => $branch_id,
                ]);
                Inventory::where('id', $inventory_save->id)->decrement('amount', 1);
            }
            $this->dispatch('alert', 'Creado con Exito');
            return redirect('retirado');
        } else {
            $this->dispatch('alert2', 'Seleccione una Herramienta');
        }
    }
    public function deleteItemTool($idItemTool)
    {
        $searchArray = array_search($idItemTool, $this->key);
        unset($this->key[$searchArray]);
        unset($this->array_message[$idItemTool]);
        unset($this->save_image[$idItemTool]);
        unset($this->array_amount_tool[$idItemTool]);
        unset($this->array_tool_id[$idItemTool]);
    }

    public function returnShow_movements()
    {
        return redirect('retirado');
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
        $orderInventories = collect(); // Inicializa $orderInventories como una colección vacía

        foreach ($this->array_tool_id as $key => $value) {
            $tool = Inventory::where('id', $value)->first(); // Utiliza first() para obtener solo un objeto en lugar de una colección
            $tool->custom_key = $key; // Agrega un atributo personalizado al objeto de inventario con el valor de la clave actual
            $orderInventories->push($tool); // Agrega el objeto a la colección $orderInventories
        }

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

        return view('livewire.solicitudRetiro.create-inventory-retired', compact('movements', 'orderInventories'));
    }
}
