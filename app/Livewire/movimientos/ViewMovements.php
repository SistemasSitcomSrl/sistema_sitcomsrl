<?php
namespace App\Livewire\Movimientos;

use App\Models\Movements;
use App\Models\Inventory;
use App\Models\MovementHistory;
use App\Models\Projects;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ViewMovements extends Component
{
    use WithPagination;
    public $search = '';
    public $cant = '10';
    public $openUpdate = false;
    public $openImagen = false;
    public $openRequestMessage = false;
    public $openDecline;
    public $textDecline;
    public $stateButton;
    public $receipt_number;
    public $state_receipt;
    public $selectedProducts = [null];
    public $selectedValues = [];
    public $selectedCategory = [];
    public $imageTool;
    public $checkBoxKey;
    public $name_project;
    public $ultimo_fecha;
    public $stateSelect = true;
    public $messageForm = ['message' => ''];
    public function editar($idToll)
    {
        $this->openImagen = true;
        $this->imageTool = Inventory::find($idToll);
    }
    public function open()
    {
        $this->reset('openUpdate', 'cant');
        $this->dispatch('render-view-movements');
        $this->resetPage();
        $this->openUpdate = true;
    }
    public function close()
    {
        $this->resetPage();
        $this->reset('openUpdate', 'cant');
        $this->dispatch('render-view-movements');
    }

    public function save()
    {
        //Retornar valor True si todos los select estan seleccionados.
        foreach ($this->selectedValues as $index => $value) {
            if ($this->selectedValues[$index] == "" || $this->selectedCategory[$index] == "") {
                $this->stateSelect = false;
                break;
            } else {
                $this->stateSelect = true;
            }
        }

        //Código que se ejecuta si select estan selecionado todos.
        if ($this->stateSelect) {
            if (Movements::where('id_project', $this->receipt_number)->where('state', $this->state_receipt)->value('state_create') == 3) {

                //Funcion para actualizar el ultimo registro de movimiento cuando es rechazo la solicitud para corregirlo
                foreach ($this->selectedValues as $id_Movements => $amount) {

                    //volvermos array todos los ids de este recibo ['1,'4','3,]
                    $accept_request = Movements::where('id_project', $this->receipt_number)->where('state', $this->state_receipt)->where('return_amount', '>', 0)->pluck('id');
                    $accept_request_ids = $accept_request->toArray();

                    //Obetengo la ultima fecha del array = ['1,'4','3,]
                    $lastUpdatedAt = MovementHistory::whereIn('id_movements', $accept_request_ids)
                        ->latest('updated_at')
                        ->value('updated_at');

                    //Disminuir la cantidad total con el ulitmo valor de la tabala MovementHistory
                    $decrement = MovementHistory::where('id_movements', $id_Movements)->orderBy('id', 'desc')->value('return_amount');

                    //Si tiene una cantidad anterior se le disminuye en caso contrario no
                    if ($decrement) {
                        Movements::whereKey($id_Movements)->decrement('return_amount', $decrement);
                    }

                    //Actualizamos los ultimos datos de la tabla MovementHistory
                    $lastRecord = MovementHistory::where('id_movements', $id_Movements)->latest('updated_at')->first();

                    //Actualizamos si existe lastRecord en caso contrario creamos una devolución
                    if ($lastRecord) {
                        $lastRecord->return_amount = $amount;
                        $lastRecord->category = $this->selectedCategory[$id_Movements];
                        $lastRecord->return_date = date('Y-m-d');
                        $lastRecord->return_time = date('H:i:s');
                        $lastRecord->timestamps = false;
                        $lastRecord->save();

                    } else {
                        MovementHistory::create(
                            [
                                'id_movements' => $id_Movements,
                                'return_date' => date('Y-m-d'),
                                'return_time' => date('H:i:s'),
                                'return_amount' => $amount,
                                'category' => $this->selectedCategory[$id_Movements],
                                'auth' => Auth::user()->id,
                                'updated_at' => $lastUpdatedAt
                            ]
                        );
                    }

                    //Incrementarmos con el ultimo valor
                    Movements::whereKey($id_Movements)->increment('return_amount', $amount);

                    //Cambiamos de estado del Recibo a "Corregido"
                    Movements::where('id_project', $this->receipt_number)->where('state', $this->state_receipt)->update([
                        'state_create' => 4,
                    ]);
                }

                //Renderizamos y reseteamos los valores
                $this->dispatch('render-view-movements');
                $this->reset('selectedProducts', 'selectedValues', 'selectedCategory', 'openUpdate');

            } else {

                //Crear una nueva solucitud 
                foreach ($this->selectedValues as $id_Movements => $amount) {
                    if ($amount != 0) {
                        $movementsProducts = Movements::whereKey($id_Movements)->select('id_inventory', 'missing_amount', 'return_amount')->first();
                        if ($movementsProducts->missing_amount != $movementsProducts->return_amount && $movementsProducts->missing_amount >= $movementsProducts->return_amount) {
                            $total = $movementsProducts->return_amount + $amount;
                            if ($movementsProducts->missing_amount >= $total) {

                                Movements::where('id_project', $this->receipt_number)->where('state', $this->state_receipt)->update([
                                    'state_create' => 5,
                                ]);
                                MovementHistory::create(
                                    [
                                        'id_movements' => $id_Movements,
                                        'return_date' => date('Y-m-d'),
                                        'return_time' => date('H:i:s'),
                                        'return_amount' => $amount,
                                        'category' => $this->selectedCategory[$id_Movements],
                                        'auth' => Auth::user()->id,
                                    ]
                                );

                                Movements::whereKey($id_Movements)->increment('return_amount', $amount);
                                $this->dispatch('alert4', 'Solicitud Enviado Con Exito');
                            }
                        }
                    }
                }
                $this->dispatch('render-view-movements');
                $this->reset('selectedProducts', 'selectedValues', 'selectedCategory', 'openUpdate');
            }
            $this->checkBoxKey = rand();

        } else {
            $this->dispatch('alert5', 'Selecione una Opción');
        }


    }
    //funcion para aceptar la solicitud de parte del administrador
    public function acceptRequest()
    {
        //volvermos array todos los ids de este recibo ['1,'4','3,]
        $accept_request = Movements::where('id_project', $this->receipt_number)->where('state', $this->state_receipt)->where('return_amount', '>', 0)->pluck('id');
        $accept_request_ids = $accept_request->toArray();

        //Obetengo la ultima fecha del array = ['1,'4','3,]
        $lastUpdatedAt = MovementHistory::whereIn('id_movements', $accept_request_ids)
            ->latest('updated_at')
            ->value('updated_at');

        //Consulta de tabla movimientos
        $movements = Movements::where('id_project', $this->receipt_number)->where('state', $this->state_receipt)->get();

        //Obtenemos las correciones o ultimos valores actualizados o agregar del recibo para incrementar en la tabla de inventario
        foreach ($movements as $movement) {
            $amount = MovementHistory::where('id_movements', $movement->id)->where('updated_at', $lastUpdatedAt)->first();

            if ($amount) {
                if ($amount->category != 'Obra') {
                    Inventory::whereKey($movement->id_inventory)->increment('amount', $amount->return_amount);
                }
            }
        }
        Movements::where('id_project', $this->receipt_number)->where('state', $this->state_receipt)->update([
            'state_create' => 0,
        ]);

        //Verificar si esta completo todas las devoluciones
        $column_return_amount = Movements::where('id_project', $this->receipt_number)->where('state', $this->state_receipt)->pluck('return_amount');
        $array_return_amount = $column_return_amount->toArray();
        $column_missing_amount = Movements::where('id_project', $this->receipt_number)->where('state', $this->state_receipt)->pluck('missing_amount');
        $array_missing_amount = $column_missing_amount->toArray();
        $sumA = array_sum($array_return_amount);
        $sumB = array_sum($array_missing_amount);
        if ($sumA === $sumB) {
            Movements::where('id_project', $this->receipt_number)->where('state', $this->state_receipt)->update([
                'state_create' => 1,
                'state' => 1,
            ]);
            $this->dispatch('alert', 'Solicitud Enviado Con Exito');
            return redirect()->route('admin.movement.index');
        }

        $this->dispatch('alert4', 'Solicitud Enviado Con Exito');
        $this->dispatch('render-view-movements');
        $this->reset('selectedProducts', 'selectedValues', 'selectedCategory', 'openUpdate');

    }
    public function inputEnable($id)
    {
        $this->selectedValues[$id] = "";
        $this->selectedCategory[$id] = "";

        //Ordenar selectedValues de acuerdo a su index
        ksort($this->selectedValues);
        ksort($this->selectedCategory);

        //Realizar ciclo para verificar el estado si esta "Tickeado".
        //Destickeado elimina el valor de las dos variables de acuerdo a su index($id_movement)
        foreach ($this->selectedProducts as $id_movement => $state) {
            if ($id_movement != 0) {
                if ($state == false) {
                    unset($this->selectedProducts[$id_movement]);
                    unset($this->selectedValues[$id_movement]);
                    unset($this->selectedCategory[$id_movement]);
                }
            }
        }
    }
    public function inputValidate()
    {
        //Ordenar selectedValues de acuerdo a su index
        ksort($this->selectedValues);
        ksort($this->selectedCategory);
    }
    public function decline()
    {
        $this->openDecline = true;
        $this->reset('textDecline');
        $this->resetValidation('textDecline');
    }
    public function declineRequest()
    {
        $this->validate([
            'textDecline' => 'required|min:5',
        ]);
        Movements::where('id_project', $this->receipt_number)->where('state', $this->state_receipt)->update([
            'debline_text' => $this->textDecline,
            'state_create' => 3,

        ]);
        $this->reset('textDecline', 'openDecline', 'cant', 'openUpdate');
        $this->resetValidation('textDecline');
        $this->dispatch('alert4', 'Solicitud Enviado Con Exito');
        $this->dispatch('render-view-movements');
    }
    public function openMessage()
    {
        $this->openRequestMessage = true;
        $this->messageForm['message'] = Movements::where('id_project', $this->receipt_number)->where('state', $this->state_receipt)->value('debline_text');
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        //volvemos array todos los ids de este recibo ['1,'4','3,]
        $accept_request = Movements::where('id_project', $this->receipt_number)->where('state', $this->state_receipt)->where('return_amount', '>', 0)->pluck('id');
        $accept_request_ids = $accept_request->toArray();

        //Obtengo la ultima fecha del array = ['1,'4','3,]
        $lastUpdatedAt = MovementHistory::whereIn('id_movements', $accept_request_ids)
            ->latest('updated_at')
            ->value('updated_at');

        $this->ultimo_fecha = $lastUpdatedAt;

        $inventories = Movements::join('inventories', 'inventories.id', '=', 'movements.id_inventory')
            ->select('movements.*', 'movements.id as id_movements', 'inventories.*')
            ->where('movements.id_project', $this->receipt_number)
            ->where('movements.state', $this->state_receipt)
            ->where('name_equipment', 'like', '%' . $this->search . '%')
          
            ->paginate($this->cant);
        
        $movements_histories = MovementHistory::select()->get();
        $this->name_project = Projects::where('id', $this->receipt_number)->value('object');
        $this->stateButton = Movements::where('id_project', $this->receipt_number)->where('state', $this->state_receipt)->value('state_create');
        return view('livewire.movimientos.view-movements', compact('inventories', 'movements_histories'));
    }
}