<?php

namespace App\Livewire\TransferenciaEnviadas;

use App\Models\Branch;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\Trasnfer;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class CreateTransfers extends Component
{
    use WithPagination;
    public $orderAmount = '';
    public $amount, $id;
    public $search = '';
    public $sort = 'id';
    public $direction = 'asc';
    public $cant = '13';
    public $openCreate = false;
    public $openImagen = false;
    public $imageTool;
    public $selectedInput = '';
    public $inventoryEditId = '';
    public $selectedTool = [null];
    public $selectedAll = [null];
    public $idInventory, $idToll, $amountTool, $branches, $test;
    public $searchArray;
    protected $queryString = [
        'sort' => ['except' => 'id'],
        'cant' => ['except' => '10'],
        'direction' => ['except' => 'desc'],
        'search' => ['except' => ''],
    ];
    public $inventoryEdit = [
        'inventoryEdit.name_equipment' => '',
        'inventoryEdit.color' => '',
        'inventoryEdit.price' => '',
        'inventoryEdit.brand' => '',
        'inventoryEdit.location' => '',
        'inventoryEdit.unit_measure' => '',
        'inventoryEdit.bar_Code' => '',
        'inventoryEdit.type' => '',
        'inventoryEdit.amount' => '',
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
        //Obtener los id de las sucursales que tienen el rol encargado de activo
        $activo_rol_branch = Branch::join('model_has_roles', 'branches.user_id', '=', 'model_has_roles.model_id')
            ->where('model_has_roles.role_id', 3)
            ->pluck('branches.id');

        $branch_id = Branch::where('user_id', Auth::user()->id)->value('id');

        $this->branches = Branch::where('id', '!=', $branch_id)
            ->whereNotIn('id', $activo_rol_branch)
            ->get();
    }
    //Devolver el valor selecionado del Modal Proyecto
    public function dataProject()
    {
        $this->reset(['openCreate']);
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
        return redirect('/enviadas');
    }
    //Crear Recibo en Base de Datos
    public function create()
    {
        $countAll = count($this->selectedAll);
        if ($countAll > 1) {
            if ($this->selectedInput != null) {

                $branch_id = Branch::where('user_id', Auth::user()->id)->value('id');

                $idMax = Trasnfer::where('branch_from_id', $branch_id)->get()->max(function ($item) {
                    // Dividir la cadena en letras y números              
                    $idMax = explode(".", $item->receipt_number);
                    // Obtener el número
                    return $idMax[1];
                });
                $idMax++;

                $counterReceipt = 'T-' . $branch_id . '.' . $idMax;

                unset($this->selectedTool[0]);
                unset($this->selectedAll[0]);

                foreach ($this->selectedTool as $key => $value) {

                    $amountTool = Inventory::where('id', $value)->value('amount');
                    $amountTool = $amountTool - $this->selectedAll[$key];
                    $inventoryId = Inventory::find($this->selectedTool[$key]);

                    $inventoryId->update([
                        'amount' => $amountTool
                    ]);

                    $user_id = Branch::where('id', $this->selectedInput)->value('user_id');

                    Trasnfer::create([
                        'receipt_number' => $counterReceipt,
                        'branch_from_id' => $branch_id,
                        'branch_to_id' => $this->selectedInput,
                        'user_from_id' => Auth::user()->id,
                        'user_to_id' => $user_id,
                        'departure_date' => date('Y-m-d'),
                        'departure_time' => date('H:i:s'),

                        'missing_amount' => $this->selectedAll[$key],
                        'state' => 0,
                        'id_inventory' => $this->selectedTool[$key],
                    ]);
                }

                $this->dispatch('alert', 'Creado con Exito');
                return redirect('/enviadas');
            } else {
                $this->dispatch('alert2', 'Seleccione una Sucursal');
            }
        } else {
            $this->dispatch('alert2', 'Seleccione una Herramienta');
        }
    }
    //2.1 .- Abrir y Devolver Valor de Cada Herramienta
    public function editar($idToll)
    {
        $this->reset('orderAmount');
        $this->resetValidation();
        $this->openImagen = true;
        $this->inventoryEditId = $idToll;
        $toll = Inventory::find($idToll);
        $this->imageTool = Inventory::find($idToll);
        $this->inventoryEdit['name_equipment'] = $toll->name_equipment;
        $this->inventoryEdit['color'] = $toll->color;
        $this->inventoryEdit['price'] = $toll->price;
        $this->inventoryEdit['brand'] = $toll->brand;
        $this->inventoryEdit['location'] = $toll->unit_measure;
        $this->inventoryEdit['bar_Code'] = $toll->type;
        $this->inventoryEdit['amount'] = $toll->amount;
        $this->inventoryEdit['unit_measure'] = $toll->unit_measure;
        $this->amount = $toll->amount;
        $this->id = $toll->id;
    }
    //3.1- Validar datos y Selecionar Cada Herramienta
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
            dd(123);
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
        $orderInventories = Inventory::whereKey($this->selectedTool)->get();


        $names = Branch::join('users', 'users.id', '=', 'branches.user_id')
            ->select('users.name as name_user', 'users.company_position as company_position', 'branches.*')
            ->where('branches.id', $this->selectedInput)->get();

        $branch_id = Branch::where('user_id', Auth::user()->id)->value('id');

        $movements = Inventory::where('branch_id', $branch_id)
            ->where('name_equipment', 'like', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)->simplePaginate($this->cant);
        return view('livewire.transferenciaEnviadas.create-transfers', compact('movements', 'orderInventories', 'names'));
    }
}
