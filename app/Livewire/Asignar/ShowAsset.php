<?php

namespace App\Livewire\Asignar;

use App\Models\AssetAllocation;
use App\Models\Branch;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowAsset extends Component
{
    use WithPagination;
    public $search = '';
    public $sort = 'created_at';
    public $direction = 'desc';
    public $cant = '10';
    public $inventories;
    protected $listeners = ['render-view-asset' => 'render'];

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
        $movements = AssetAllocation::select(
            'workers.ci',
            'asset_allocations.debline_text',
            'asset_allocations.state',
            'asset_allocations.state_create',
            'asset_allocations.id_worker',           
            'workers.name',
            'workers.last_name',
            'users.name as name_auth',
            DB::raw('MAX(asset_allocations.receipt_number) as receipt_number'),
            DB::raw('MAX(asset_allocations.created_at) as created_at')
        )
            ->join('workers', 'asset_allocations.id_worker', '=', 'workers.id')
            ->join('users', 'asset_allocations.auth', '=', 'users.id')
            ->groupBy(
                'workers.ci',
                'asset_allocations.debline_text',
                'asset_allocations.state',
                'asset_allocations.state_create',
                'asset_allocations.id_worker',
                'workers.name',
                'workers.last_name',
                'users.name',
            )
            ->havingRaw('COUNT(workers.ci) >= 1')
            ->where(function ($query) use ($branch_id) {
                // Si $branch_id es null, no aplicamos la condición
                if (Auth::user()->id != 1) {
                    $query->where('branch_id', $branch_id);
                }
            })
            ->where('workers.ci', 'like', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.asignar.show-asset', compact('movements'));
    }
}
