<?php

namespace App\Livewire\SolicitudRetiro;

use Livewire\Component;

use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use App\Models\TransferRequired;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class ShowInventoryRetired extends Component
{
    use WithPagination;
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
    public function render()
    {
        $branch_id = Branch::where('user_id', Auth::user()->id)->value('id');

        $movements = TransferRequired::select(
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
            ->where(function ($query) use ($branch_id) {
                // Si $branch_id es null, no aplicamos la condición
                if (Auth::user()->id != 1) {
                    $query->where('transfer_requireds.branch_id', $branch_id);
                }
            })
            ->where('transfer_requireds.receipt_number', 'like', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);
        return view('livewire.solicitudRetiro.show-inventory-retired', compact('movements'));
    }
}
