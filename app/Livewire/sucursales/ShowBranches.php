<?php

namespace App\Livewire\Sucursales;

use App\Models\Branch;
use App\Models\Trasnfer;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class ShowBranches extends Component
{
    use WithPagination;
    public $create_branch, $selectedUser, $selectedDepartment, $create_direction, $create_number_phone;
    public $edit_branch, $edit_selectedDepartment, $edit_direction, $edit_number_phone;
    public $search = '';
    public $sort = 'id';
    public $direction = 'asc';
    public $cant = '10';
    public $openCreate = false;
    public $openEdit = false;
    public $openRotate = false;
    public $nameBranch;
    public $selectedInput = '';
    public $branchEditId;
    protected $queryString = [
        'sort' => ['except' => 'id'],
        'cant' => ['except' => '10'],
        'direction' => ['except' => 'desc'],

    ];
    protected $validationAttributes = [
        'create_branch' => 'sucursal',
        'selectedDepartment' => 'deparmento',
        'create_direction' => 'direccion',
        'create_number_phone' => 'numero de telefono',
        'selectedUser' => 'encargado de sucursal',
        'postForm.edit_branch' => 'sucursal',
        'postForm.edit_selectedDepartment' => 'departamento',
        'postForm.edit_direction' => 'direccion',
        'postForm.edit_number_phone' => 'numero de telefono'
    ];
    public $postForm = [
        'edit_branch' => '',
        'edit_selectedDepartment' => '',
        'edit_direction' => '',
        'edit_number_phone' => ''
    ];
    protected $rules = [
        'postForm.edit_branch' => 'required|max:100',
        'postForm.edit_selectedDepartment' => 'required',
        'postForm.edit_direction' => 'required|max:100',
        'postForm.edit_number_phone' => 'numeric|required|min:1',
    ];
    public function openCreateModal()
    {
        $this->openCreate = true;
        $this->selectedDepartment = "";
        $this->selectedUser = "";
        $this->create_branch = "";
        $this->create_direction = "";
        $this->create_number_phone = "";
        $this->resetValidation();
    }
    public function save()
    {
        $this->validate([
            'create_branch' => 'required|max:100',
            'selectedDepartment' => 'required',
            'create_direction' => 'required|max:100',
            'create_number_phone' => 'numeric|required|min:1',
            'selectedUser' => 'required',
        ]);

        Branch::create([
            'name' => $this->create_branch,
            'department' => $this->selectedDepartment,
            'direction' => $this->create_direction,
            'number_phone' => $this->create_number_phone,
            'user_id' => $this->selectedUser
        ]);

        $this->dispatch('alert', 'Creado con Exito');

        $this->reset();

    }
    public function rotate($idBranch)
    {
        $this->nameBranch = Branch::find($idBranch);

        //Verificar 
        $registros = Trasnfer::select('state')->where('user_to_id', $this->nameBranch->user_id)->get();
        $sonTodosTrue = $registros->every(function ($registro) {
            return $registro->state == true;
        });
        if ($sonTodosTrue) {
            $this->openRotate = true;
        } else {
            $this->dispatch('alert2', 'Transferecias Pendientes');
        }
    }
    public function submitForm($idBranch)
    {
        $this->validate([
            'selectedInput' => 'required',
        ], [
            'selectedInput.required' => 'Seleccione un Encargado',
        ]);

 
        $branch = Branch::find($idBranch);

        //Eliminar session de usuario
        $userId = $branch->user_id;
        $userSession = DB::table('sessions')->where('user_id', $userId)->first();
        if ($userSession) {
            DB::table('sessions')->where('id', $userSession->id)->delete();
        }

        //Actualizar Encargado de Sucursal Almacen o Activo
        $branch->update([
            'user_id' => $this->selectedInput
        ]);
        $this->reset(['openRotate']);
        $this->selectedInput = '';
        $this->dispatch('alert', 'Actualizado con Exito');

    }

    public function edit($idBranch)
    {
        $this->nameBranch = Branch::find($idBranch);

        //Verificar 
        $registros = Trasnfer::select('state')->where('user_to_id', $this->nameBranch->user_id)->get();
        $sonTodosTrue = $registros->every(function ($registro) {
            return $registro->state == true;
        });
        if ($sonTodosTrue) {
            $this->openEdit = true;
            $this->branchEditId = $idBranch;
            $branch = Branch::find($idBranch);
            $this->postForm['edit_branch'] = $branch->name;
            $this->postForm['edit_selectedDepartment'] = $branch->department;
            $this->postForm['edit_direction'] = $branch->direction;
            $this->postForm['edit_number_phone'] = $branch->number_phone;
        } else {
            $this->dispatch('alert2', 'Transferecias Pendientes');
        }
    }
    public function udpate()
    {
        $this->validate();
        $post = Branch::find($this->branchEditId);
        $post->update([
            'name' => $this->postForm['edit_branch'],
            'department' => $this->postForm['edit_selectedDepartment'],
            'direction' => $this->postForm['edit_direction'],
            'number_phone' => $this->postForm['edit_number_phone'],
        ]);
        $this->resetValidation();
        $this->reset();
        $this->dispatch('alert', 'Actualizado con Exito');
    }

    public function updatedOpenRotate()
    {
        if ($this->openRotate == false) {
            $this->selectedInput = '';
            $this->resetValidation();
        }
    }
    public function updatedOpenEdit()
    {
        if ($this->openEdit == false) {
            $this->resetValidation();
            $this->reset();
        }
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function order($sort)
    {
        if ($this->sort == $sort) {

            if ($this->direction == 'asc') {
                $this->direction = 'desc';
            } else {
                $this->direction = 'asc';
            }
        } else {
            $this->sort = $sort;
        }
    }
    public function render()
    {      
        $users = User::doesntHave('branches')
            ->select('id', 'name', 'email', 'company_position')
            ->Where('id', '<>', 1)
            ->Where('state', 1)
            ->get();

        $branches = Branch::join('users', 'users.id', '=', 'branches.user_id')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('branches.*', 'users.name as name_user', 'users.company_position as company_position', 'roles.name as rol')
            ->where('branches.name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);
        return view('livewire.sucursales.show-branches', compact('branches', 'users'));
    }
}
