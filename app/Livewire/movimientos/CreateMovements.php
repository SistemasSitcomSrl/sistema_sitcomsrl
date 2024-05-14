<?php

namespace App\Livewire\Movimientos;

use App\Models\Branch;
use Livewire\Component;
use App\Models\Projects;
use App\Models\Inventory;
use App\Models\Movements;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\WithPagination;

class CreateMovements extends Component
{
    use WithPagination;
    public $orderAmount = '';
    public $amount, $id;
    public $search = '';
    public $sort = 'id';
    public $direction = 'asc';
    public $cant = '13';
    public $openCreate = false;
    public $openBranch = false;
    public $openImagen = false;
    public $imageTool;
    public $botonDeshabilitado = false;
    public $selectedInput = '';
    public $inventoryEditId = '';
    public $selectedTool = [null];
    public $selectedAll = [null];
    public $idInventory, $idToll, $amountTool, $projects, $test, $branches;
    public $searchArray;
    protected $queryString = [
        'sort' => ['except' => 'id'],
        'cant' => ['except' => '10'],
        'direction' => ['except' => 'desc'],
        'search' => ['except' => ''],
    ];
    public $inventoryEdit = [
        'inventoryEdit.name_equipment' => '',
        'inventoryEdit.amount' => '',
        'inventoryEdit.color' => '',
        'inventoryEdit.price' => '',
        'inventoryEdit.brand' => '',
        'inventoryEdit.location' => '',
        'inventoryEdit.unit_measure' => '',
        'inventoryEdit.bar_Code' => '',
        'inventoryEdit.type' => '',
    ];
    //Regla de Validacion Numerica
    protected $rules = [
        'orderAmount' => 'required',
    ];
    //Cambiar Nombre a los atributos
    public $validationAttributes = [
        'orderAmount' => 'numero'
    ];
    //Seleccionar Proyecto   
    public function projectName()
    {
        $this->openCreate = true;
        //volvemos array todos los ci de esta tabla a ['1,'4','3,]
        $ci_array = Projects::select('projects.id')
            ->join('movements', 'projects.id', '=', 'movements.id_project')
            ->groupBy('projects.id')
            ->where('movements.state', 0)
            ->whereIn('movements.state_create', [2, 3, 4, 5])
            ->pluck('projects.id');
        $array_ci = $ci_array->toArray();

        $this->projects = Projects::select('id', 'object')->where('state', true)->whereNotIn('id', $array_ci)->get();
    }

    //Eliminar elemento de la lista
    public function deleteItemTool($idItemTool)
    {
        $searchArray = array_search($idItemTool, $this->selectedTool);
        unset($this->selectedTool[$searchArray]);
        unset($this->selectedAll[$searchArray]);
    }
    //Retornar a la anterior vista
    public function returnShow_movements()
    {
        return redirect('prestar');
    }
    //Crear Recibo en Base de Datos
    public function create()
    {
        $branch_id = Branch::where('user_id', Auth::user()->id)->value('id');
        $countAll = count($this->selectedAll);
        if ($countAll > 1) {
            if ($this->selectedInput != null) {

                $idMax = Movements::where('branch_id', $branch_id)->where('id_project', $this->selectedInput)->get()->max(function ($item) {
                    // Dividir la cadena en letras y números              
                    $idMax = explode(".", $item->receipt_number);
                    // Obtener el número
                    return $idMax[1];
                });
                $idMax++;
                $counterReceipt = 'M-' . $branch_id . '.' . $idMax;

                unset($this->selectedTool[0]);
                unset($this->selectedAll[0]);

                foreach ($this->selectedTool as $key => $value) {

                    $amountTool = Inventory::where('id', $value)->value('amount');
                    $amountTool = $amountTool - $this->selectedAll[$key];
                    $inventoryId = Inventory::find($this->selectedTool[$key]);

                    $inventoryId->update([
                        'amount' => $amountTool
                    ]);
                    $branch_id = Branch::where('user_id', Auth::user()->id)->value('id');

                    Movements::create([
                        'receipt_number' => $counterReceipt,
                        'id_project' => $this->selectedInput,
                        'id_inventory' => $this->selectedTool[$key],
                        'movement_type' => 'trabajo',
                        'departure_date' => date('Y-m-d'),
                        'departure_time' => date('H:i:s'),
                        'return_date' => null,
                        'retur_time' => null,
                        'missing_amount' => $this->selectedAll[$key],
                        'state' => 0,
                        'auth' => Auth::user()->id,
                        'branch_id' => $branch_id,
                    ]);
                }

                $this->dispatch('alert', 'Creado con Exito');
                return redirect('prestar');
            } else {
                $this->dispatch('alert2', 'Seleccione un Proyecto');
            }
        } else {
            $this->dispatch('alert2', 'Seleccione una Herramienta');
        }
    }

    public function editar($idToll)
    {
        $this->reset('orderAmount');
        $this->resetValidation();

        $this->openImagen = true;
        $this->inventoryEditId = $idToll;
        $toll = Inventory::find($idToll);
        $this->imageTool = Inventory::find($idToll);
        $this->inventoryEdit['name_equipment'] = $toll->name_equipment;
        $this->inventoryEdit['amount'] = $toll->amount;
        $this->inventoryEdit['color'] = $toll->color;
        $this->inventoryEdit['price'] = $toll->price;
        $this->inventoryEdit['brand'] = $toll->brand;
        $this->inventoryEdit['location'] = $toll->location;
        $this->inventoryEdit['unit_measure'] = $toll->unit_measure;
        $this->inventoryEdit['bar_Code'] = $toll->bar_Code;
        $this->inventoryEdit['type'] = $toll->type;
        $this->amount = $toll->amount;
        $this->id = $toll->id;
    }

    public function save($id)
    {
        $this->validate();

        $amountTool = $this->orderAmount;
        $selectedTool = $this->selectedTool;
        $searchArray = array_search($id, $selectedTool);
        $this->searchArray = $searchArray;

        if ($selectedTool != null) {
            if ($searchArray != false) {

                $totalQuantity = $this->selectedAll[$searchArray] + $amountTool;
                $amountInventoryId = Inventory::where('id', $id)->value('amount');
                if ($amountInventoryId >= $totalQuantity) {
                    $amountTool = $totalQuantity;
                    array_push($this->selectedAll, "$amountTool");
                    array_push($this->selectedTool, $id);
                    unset($this->selectedTool[$searchArray]);
                    unset($this->selectedAll[$searchArray]);
                    $this->reset(['orderAmount', 'openImagen']);
                } else {
                    $this->dispatch('alert2', 'Cantidad Maxima');
                }
            } else {
                array_push($this->selectedAll, "$amountTool");
                array_push($this->selectedTool, $id);
                $this->reset(['orderAmount', 'openImagen']);
            }
        } else {
            array_push($this->selectedAll, $amountTool);
            array_push($this->selectedTool, $id);

            $this->reset(['orderAmount', 'openImagen']);
        }
    }
    //Resetear pagina en cada 
    public function updatingSearch()
    {
        $this->resetPage();
    }
    // Funcion Ordenar las filas de la vista inventario
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
        //herramientas selecionadas
        $orderInventories = Inventory::whereKey($this->selectedTool)->get();

        //Select selecionado para mostrar sus datos del Proyecto
        $names = Projects::join('users', 'projects.id_user', '=', 'users.id')
            ->select('projects.object', 'projects.entity', 'projects.ubi_entity', 'users.name', 'users.company_position')
            ->where('projects.id', $this->selectedInput)
            ->get();

        //Mostrar las herramienta de acuerdo a su sucursal
        $branch_id = Branch::where('user_id', Auth::user()->id)->value('id');
        $movements = Inventory::where(function ($query) use ($branch_id) {
            // Si $branch_id es null, no aplicamos la condición
            if ($branch_id !== null) {
                $query->where('inventories.branch_id', $branch_id);
            }
        })
            ->where('name_equipment', 'like', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->simplePaginate($this->cant);

        return view('livewire.movimientos.create-movements', compact('movements', 'orderInventories', 'names'));
    }
}
