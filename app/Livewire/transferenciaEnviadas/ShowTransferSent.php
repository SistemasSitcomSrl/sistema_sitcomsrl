<?php

namespace App\Livewire\TransferenciaEnviadas;

use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use App\Models\Trasnfer;
use Livewire\WithPagination;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ShowTransferSent extends Component
{
    use WithPagination;
    public $search = '';
    public $sort = 'created_at';
    public $direction = 'desc';
    public $cant = '10';
    protected $listeners = ['render-view-trasnfers' => 'render'];

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

        $movements = Trasnfer::select(
            'trasnfers.receipt_number',
            'trasnfers.created_at',
            'trasnfers.branch_to_id',
            'branches_from.name as name_from_branches',
            'branches_to.name as name_to_branches',
            'users_from.name as name_from_user',
            'users_to.name as name_to_user',
            DB::raw('CASE WHEN SUM(trasnfers.missing_amount) = SUM(trasnfers.return_amount) THEN true ELSE false END as status')
        )
            ->join('branches as branches_from', 'trasnfers.branch_from_id', '=', 'branches_from.id')
            ->join('branches as branches_to', 'trasnfers.branch_to_id', '=', 'branches_to.id')
            ->join('users as users_from', 'branches_from.user_id', '=', 'users_from.id')
            ->join('users as users_to', 'branches_to.user_id', '=', 'users_to.id')
            ->groupBy(
                'trasnfers.receipt_number',
                'trasnfers.created_at',
                'trasnfers.branch_to_id',
                'branches_from.name',
                'branches_to.name',
                'users_from.name',
                'users_to.name'
            )
            ->havingRaw('COUNT(receipt_number) >= 1')
            ->where(function ($query) use ($branch_id) {
                // Si $branch_id es null, no aplicamos la condición
                if (Auth::user()->id != 1) {
                    $query->where('trasnfers.branch_from_id', $branch_id);
                }
            })

            ->where('trasnfers.receipt_number', 'like', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);


        return view('livewire.transferenciaEnviadas.show-transfer-sent', compact('movements'));
    }
}
