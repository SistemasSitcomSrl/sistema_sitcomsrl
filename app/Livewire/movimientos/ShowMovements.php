<?php

namespace App\Livewire\Movimientos;

use App\Models\Movements;
use App\Models\Branch;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\MovementHistory;

class ShowMovements extends Component
{
    use WithPagination;
    public $search = '';
    public $sort = 'created_at';
    public $direction = 'desc';
    public $cant = '10';
    public $inventories;
    protected $listeners = ['render-view-movements' => 'render'];

    protected $queryString = [
        'sort' => ['except' => 'id'],
        'cant' => ['except' => '10'],
        'direction' => ['except' => 'desc'],

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
    public function render()
    {
        $branch_id = Branch::where('user_id', Auth::user()->id)->value('id');
        $movements = Movements::select(
            'movements.receipt_number',
            'movements.created_at',
            'movements.state_create',
            'movements.debline_text',
            'projects.object as name_project',
            'projects.entity as entity_project',
            'user_projects.name as name_user',
            'user_auth.name as name_auth',
        )
            ->join('projects', 'movements.id_project', '=', 'projects.id')
            ->join('users as user_projects', 'projects.id_user', '=', 'user_projects.id')
            ->join('users as user_auth', 'movements.auth', '=', 'user_auth.id')
            ->groupBy(
                'movements.receipt_number',
                'movements.created_at',
                'movements.state_create',
                'movements.debline_text',
                'projects.object',
                'projects.entity',
                'user_projects.name',
                'user_auth.name'
            )
            ->havingRaw('COUNT(receipt_number) >= 1')
            ->where(function ($query) use ($branch_id) {
                // Si $branch_id es null, no aplicamos la condición
                if (Auth::user()->id != 1) {
                    $query->where('branch_id', $branch_id);
                }
            })
            ->where('movements.receipt_number', 'like', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);
            
        return view('livewire.movimientos.show-movements', compact('movements'));
    }
}
