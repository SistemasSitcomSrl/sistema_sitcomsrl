<?php

namespace App\Livewire\Asignar;

use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AssetAllocation;
use App\Models\AssetHistory;
use App\Models\Workers;

class ViewAsset extends Component
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
    public $name_worker;
    public $state_receipt;
    public $selectedProducts = [null];
    public $selectedValues = [];
    public $imageTool;
    public $checkBoxKey;
    public $stateSelect = true;
    public $ultimo_fecha;
    public $messageForm = ['message' => ''];
    public function editar($idToll)
    {
        $this->openImagen = true;
        $this->imageTool = Inventory::find($idToll);
    }
    public function open()
    {
        $this->reset('openUpdate', 'cant');
        $this->dispatch('render-view-asset');
        $this->resetPage();
        $this->openUpdate = true;
    }
    public function close()
    {
        $this->resetPage();
        $this->reset('openUpdate', 'cant');
        $this->dispatch('render-view-asset');
    }

    public function save()
    {
        //Retornar valor True si todos los select estan seleccionados.
        foreach ($this->selectedValues as $index => $value) {
            if ($this->selectedValues[$index] == "") {
                $this->stateSelect = false;
                break;
            } else {
                $this->stateSelect = true;
            }
        }

        //Código que se ejecuta si select estan selecionado todos.
        if ($this->stateSelect) {
            //seguridad si esta rechazado estado 3
            if (AssetAllocation::where('id_worker', $this->receipt_number)->where('asset_allocations.state', $this->state_receipt)->value('state_create') == 3) {

                //Funcion para actualizar el ultimo registro de asignación de activos cuando es rechazo la solicitud para corregirlo
                foreach ($this->selectedValues as $id_Movements => $amount) {

                    //volvemos array todos los ids de este recibo ['1,'4','3,]
                    $accept_request = AssetAllocation::where('id_worker', $this->receipt_number)->where('asset_allocations.state', $this->state_receipt)->where('return_amount', '>', 0)->pluck('id');
                    $accept_request_ids = $accept_request->toArray();

                    //Obtengo la ultima fecha del array = ['1,'4','3,]
                    $lastUpdatedAt = AssetHistory::whereIn('id_movements', $accept_request_ids)
                        ->latest('updated_at')
                        ->value('updated_at');

                    //Disminuir la cantidad total con el ulitmo valor de la tabla AssetHistory
                    $decrement = AssetHistory::where('id_movements', $id_Movements)->orderBy('id', 'desc')->value('return_amount');

                    //Si tiene una cantidad anterior se le disminuye en caso contrario no
                    if ($decrement) {
                        AssetAllocation::whereKey($id_Movements)->decrement('return_amount', $decrement);
                    }

                    //Actualizamos los ultimos datos de la tabla AssetHistory
                    $lastRecord = AssetHistory::where('id_movements', $id_Movements)->latest('updated_at')->first();

                    //Actualizamos si existe lastRecord en caso contrario creamos una devolución
                    if ($lastRecord) {
                        $lastRecord->return_amount = $amount;
                        $lastRecord->return_date = date('Y-m-d');
                        $lastRecord->return_time = date('H:i:s');
                        $lastRecord->timestamps = false;
                        $lastRecord->save();

                    } else {
                        AssetHistory::create(
                            [
                                'id_movements' => $id_Movements,
                                'return_date' => date('Y-m-d'),
                                'return_time' => date('H:i:s'),
                                'return_amount' => $amount,
                                'auth' => Auth::user()->id,
                                'updated_at' => $lastUpdatedAt
                            ]
                        );
                    }

                    //Incrementarmos con el ultimo valor
                    AssetAllocation::whereKey($id_Movements)->increment('return_amount', $amount);

                    //Cambiamos de estado del Recibo a "Corregido"
                    AssetAllocation::where('id_worker', $this->receipt_number)->where('asset_allocations.state', $this->state_receipt)->update([
                        'state_create' => 4,
                    ]);
                }

                //Renderizamos y reseteamos los valores
                $this->dispatch('render-view-asset');
                $this->reset('selectedProducts', 'selectedValues', 'openUpdate');

            } else {
                //Crear una nueva solucitud 
                foreach ($this->selectedValues as $id_Movements => $amount) {
                    if ($amount != 0) {
                        $movementsProducts = AssetAllocation::whereKey($id_Movements)->select('id_inventory', 'missing_amount', 'return_amount')->first();
                        if ($movementsProducts->missing_amount != $movementsProducts->return_amount && $movementsProducts->missing_amount >= $movementsProducts->return_amount) {
                            $total = $movementsProducts->return_amount + $amount;
                            if ($movementsProducts->missing_amount >= $total) {

                                AssetAllocation::where('id_worker', $this->receipt_number)->where('asset_allocations.state', $this->state_receipt)->update([
                                    'state_create' => 5,
                                ]);
                                AssetHistory::create(
                                    [
                                        'id_movements' => $id_Movements,
                                        'return_date' => date('Y-m-d'),
                                        'return_time' => date('H:i:s'),
                                        'return_amount' => $amount,
                                        'auth' => Auth::user()->id,
                                    ]
                                );

                                AssetAllocation::whereKey($id_Movements)->increment('return_amount', $amount);
                                $this->dispatch('alert4', 'Solicitud Enviado Con Exito');
                            }
                        }
                    }
                }
                $this->dispatch('render-view-asset');
                $this->reset('selectedProducts', 'selectedValues', 'openUpdate');
            }
            $this->checkBoxKey = rand();
        } else {
            $this->dispatch('alert5', 'Selecione una Opción');
        }
    }
    //funcion para aceptar la solicitud de parte del administrador
    public function acceptRequest()
    {
        //volvemos array todos los ids de este recibo ['1,'4','3,]
        $accept_request = AssetAllocation::where('id_worker', $this->receipt_number)->where('asset_allocations.state', $this->state_receipt)->where('return_amount', '>', 0)->pluck('id');
        $accept_request_ids = $accept_request->toArray();

        //Obtengo la ultima fecha del array = ['1,'4','3,]
        $lastUpdatedAt = AssetHistory::whereIn('id_movements', $accept_request_ids)
            ->latest('updated_at')
            ->value('updated_at');

        //Consulta de tabla movimientos
        $movements = AssetAllocation::where('id_worker', $this->receipt_number)->where('asset_allocations.state', $this->state_receipt)->get();

        //Obtenemos las correciones o ultimos valores actualizados o agregar del recibo para incrementar en la tabla de inventario
        foreach ($movements as $movement) {
            $amount = AssetHistory::where('id_movements', $movement->id)->where('updated_at', $lastUpdatedAt)->first();

            if ($amount) {
                Inventory::whereKey($movement->id_inventory)->increment('amount', $amount->return_amount);
            }
        }
        AssetAllocation::where('id_worker', $this->receipt_number)->where('asset_allocations.state', $this->state_receipt)->update([
            'state_create' => 0,
        ]);

        //Verificar si esta completo todas las devoluciones
        $column_return_amount = AssetAllocation::where('id_worker', $this->receipt_number)->where('asset_allocations.state', $this->state_receipt)->pluck('return_amount');
        $array_return_amount = $column_return_amount->toArray();
        $column_missing_amount = AssetAllocation::where('id_worker', $this->receipt_number)->where('asset_allocations.state', $this->state_receipt)->pluck('missing_amount');
        $array_missing_amount = $column_missing_amount->toArray();
        $sumA = array_sum($array_return_amount);
        $sumB = array_sum($array_missing_amount);
        if ($sumA === $sumB) {
            AssetAllocation::where('id_worker', $this->receipt_number)->where('asset_allocations.state', $this->state_receipt)->update([
                'state_create' => 1,
                'state' => 1,
            ]);
            $this->dispatch('alert', 'Solicitud Enviado Con Exito');
            return redirect()->route('admin.assign.index');
        }

        $this->dispatch('alert4', 'Solicitud Enviado Con Exito');
        $this->dispatch('render-view-asset');
        $this->reset('selectedProducts', 'selectedValues', 'openUpdate');
    }
    public function inputEnable($id)
    {
        $this->selectedValues[$id] = "";

        //Ordenar selectedValues y selectedCategory de acuerdo a su index
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
        AssetAllocation::where('id_worker', $this->receipt_number)->where('asset_allocations.state', $this->state_receipt)->update([
            'debline_text' => $this->textDecline,
            'state_create' => 3,

        ]);
        $this->reset('textDecline', 'openDecline', 'cant', 'openUpdate');
        $this->resetValidation('textDecline');
        $this->dispatch('alert4', 'Solicitud Enviado Con Exito');
        $this->dispatch('render-view-asset');
    }
    public function openMessage()
    {
        $this->openRequestMessage = true;
        $this->messageForm['message'] = AssetAllocation::where('id_worker', $this->receipt_number)->where('asset_allocations.state', $this->state_receipt)->value('debline_text');
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        //volvemos array todos los ids de este recibo ['1,'4','3,]
        $accept_request = AssetAllocation::where('id_worker', $this->receipt_number)->where('asset_allocations.state', $this->state_receipt)->where('return_amount', '>', 0)->pluck('id');
        $accept_request_ids = $accept_request->toArray();

        //Obtengo la ultima fecha del array = ['1,'4','3,]
        $lastUpdatedAt = AssetHistory::whereIn('id_movements', $accept_request_ids)
            ->latest('updated_at')
            ->value('updated_at');

        $this->ultimo_fecha = $lastUpdatedAt;
        $inventories = AssetAllocation::join('inventories', 'inventories.id', '=', 'asset_allocations.id_inventory')
            ->select('asset_allocations.*', 'asset_allocations.id as id_movements', 'inventories.*', )
            ->where('asset_allocations.id_worker', $this->receipt_number)
            ->where('asset_allocations.state', $this->state_receipt)
            ->where('name_equipment', 'like', '%' . $this->search . '%')
            ->orderByRaw("CAST(SUBSTRING_INDEX(receipt_number, 'a-1.', -1) AS DECIMAL(10,2)) DESC")
            ->paginate($this->cant);

        $movements_histories = AssetHistory::select()->get();
        $this->name_worker = Workers::where('id', $this->receipt_number)->value('ci');
        $this->stateButton = AssetAllocation::where('id_worker', $this->receipt_number)->where('asset_allocations.state', $this->state_receipt)->value('state_create');
        return view('livewire.asignar.view-asset', compact('inventories', 'movements_histories'));
    }
}
