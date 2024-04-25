<?php

namespace App\Livewire\SolicitudCrear;

use Livewire\Component;

use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use App\Models\TransfersInventories;
use Livewire\WithPagination;

class ShowInventoryTransfer extends Component
{
    use WithPagination;
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
    public function render()
    {
        $branch_id = Branch::where('user_id', Auth::user()->id)->value('id');

        $movements = TransfersInventories::select(
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
            ->where(function ($query) use ($branch_id) {
                // Si $branch_id es null, no aplicamos la condición
                if (Auth::user()->id != 1) {
                    $query->where('transfers_inventories.branch_id', $branch_id);
                }
            })
            ->where('transfers_inventories.receipt_number', 'like', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.solicitudCrear.show-inventory-transfer', compact('movements'));
    }
}
