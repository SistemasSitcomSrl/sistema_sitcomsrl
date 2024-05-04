<?php

namespace App\Livewire\SolicitudCrear;

use Livewire\Component;

use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use App\Models\TransfersInventories;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class ShowInventoryTransfer extends Component
{
    use WithPagination;
    public $rutaActual;
    public $search = '';
    public $sort = 'transfers_inventories.created_at';
    public $direction = 'desc';
    public $cant = '10';
    protected $listeners = ['render-view-inventory-transfer' => 'render'];
    protected $queryString = [
        'sort' => ['except' => 'id'],
        'cant' => ['except' => '10'],
        'direction' => ['except' => 'desc']
    ];
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
    public function mount()
    {
        $this->rutaActual = request()->route()->getName();
    }
    public function render(Request $request)
    {
        //Obtener la ruta actual
        $rutaActual = $this->rutaActual;

        //Obtener el rol del usuario
        $rol = Auth::user()->roles->first()->name ?? 'default';

        //Obtener el id de la sucursal para mostrarlo en la vista por defecto
        $branch_id = Branch::where('user_id', Auth::user()->id)->value('id');

        //Obtener los id de las sucursales que tienen el rol encargado de activo
        $activo_rol_branch = Branch::join('model_has_roles', 'branches.user_id', '=', 'model_has_roles.model_id')
            ->where('model_has_roles.role_id', 3)
            ->pluck('branches.id')
            ->toArray() ?: [];

        //Generar consulta base para movimientos
        $query = TransfersInventories::select(
            'transfers_inventories.receipt_number',
            'transfers_inventories.departure_date',
            'transfers_inventories.departure_time',
            'transfers_inventories.branch_id',
            'transfers_inventories.state_create',
            'transfers_inventories.created_at',
            'transfers_inventories.updated_at',
            'branches.name as name_from_branches',
            'users.name as name_from_user',
        )
            ->join('branches', 'transfers_inventories.branch_id', '=', 'branches.id')
            ->join('users', 'branches.user_id', '=', 'users.id')
            ->groupBy(
                'transfers_inventories.receipt_number',
                'transfers_inventories.departure_date',
                'transfers_inventories.departure_time',
                'transfers_inventories.branch_id',
                'transfers_inventories.state_create',
                'transfers_inventories.created_at',
                'transfers_inventories.updated_at',
                'branches.name',
                'users.name',
            )
            ->havingRaw('COUNT(transfers_inventories.receipt_number) >= 1')
            ->where('transfers_inventories.receipt_number', 'like', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction);

        // Filtrar por sucursal según el rol y la ruta
        switch ($rol) {
            case 'Administrador':
                $branch_ids = $rutaActual == 'admin.request.index' ? $activo_rol_branch : array_diff(Branch::pluck('id')->toArray(), $activo_rol_branch);
                $query->whereIn('transfers_inventories.branch_id', $branch_ids);
                break;

            case 'Encargado de Activo':
            case 'Encargado de Almacen':
                // Mostrar solo datos de la sucursal a la que pertenece
                $query->where('transfers_inventories.branch_id', $branch_id);
                break;
        }

        // Paginar
        $movements = $query->paginate($this->cant);
        return view('livewire.solicitudCrear.show-inventory-transfer', compact('movements'));
    }
}
