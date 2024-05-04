<?php

namespace App\Livewire\SolicitudRetiro;

use Livewire\Component;

use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use App\Models\TransferRequired;
use Livewire\WithPagination;

class ShowInventoryRetired extends Component
{
    use WithPagination;
    public $rutaActual;
    public $search = '';
    public $sort = 'transfer_requireds.created_at';
    public $direction = 'desc';
    public $cant = '10';
    protected $listeners = ['render-view-inventory-retired' => 'render'];
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
    public function render()
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

        $query = TransferRequired::select(
            'transfer_requireds.receipt_number',
            'transfer_requireds.branch_id',
            'transfer_requireds.created_at',
            'branches.name as name_from_branches',
            'users.name as name_from_user',
            'transfer_requireds.state'
        )
            ->join('branches', 'transfer_requireds.branch_id', '=', 'branches.id')
            ->join('users', 'transfer_requireds.auth', '=', 'users.id')
            ->groupBy(
                'transfer_requireds.receipt_number',
                'transfer_requireds.branch_id',
                'transfer_requireds.created_at',
                'branches.name',
                'users.name',
                'transfer_requireds.state'
            )
            ->havingRaw('COUNT(transfer_requireds.receipt_number) >= 1')
            ->where('transfer_requireds.receipt_number', 'like', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction);

        // Filtrar por sucursal según el rol y la ruta
        switch ($rol) {
            case 'Administrador':
                $branch_ids = $rutaActual == 'admin.retired.index' ? $activo_rol_branch : array_diff(Branch::pluck('id')->toArray(), $activo_rol_branch);
                $query->whereIn('transfer_requireds.branch_id', $branch_ids);
                break;

            case 'Encargado de Activo':
            case 'Encargado de Almacen':
                // Mostrar solo datos de la sucursal a la que pertenece
                $query->where('transfer_requireds.branch_id', $branch_id);
                break;
        }
        // Paginar
        $movements = $query->paginate($this->cant);

        return view('livewire.solicitudRetiro.show-inventory-retired', compact('movements'));
    }
}
