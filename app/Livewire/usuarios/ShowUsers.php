<?php

namespace App\Livewire\Usuarios;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;

class ShowUsers extends Component
{
    use WithPagination;
    public $name, $ci, $email, $password, $passwordConfirmation, $phone_number, $company_position, $nameRol, $roles, $idUserRol, $userId, $selectedRol;
    public $search = '';
    public $sort = 'id';
    public $direction = 'asc';
    public $openUpdate = false;
    public $openRol = false;
    public $userEditId = '';
    public $cant = '10';
    protected $queryString = [
        'sort' => ['except' => 'id'],
        'cant' => ['except' => '10'],
        'direction' => ['except' => 'asc'],
        'search' => ['except' => '']
    ];
    public $userEdit = [
        'name' => '',
        'ci' => '',
        'email' => '',
        'phone_number' => '',
        'company_position' => '',
        'password' => '',
        'passwordConfirmation' => ''
    ];
    public $rolForm = [
        'selectedRol' => []
    ];
    protected $listeners = ['render', 'destroy'];
    public $validationAttributes = [
        'userEdit.name' => 'nombre completo',
        'userEdit.ci' => 'nro carnet',
        'userEdit.password' => 'contraseña',
        'userEdit.passwordConfirmation'=>'repetir contraseña',
        'userEdit.phone_number' => 'numero',
        'userEdit.company_position' => 'cargo',
        'rolForm.selectedRol' => 'rol',
    ];
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatedSelectedRol()
    {
        $this->reset('selectedRol');
    }
    public function editar($userId)
    {
        $this->resetValidation();
        $this->openUpdate = true;
        $this->userEditId = $userId;
        $user = User::find($userId);
        $this->userEdit['name'] = $user->name;
        $this->userEdit['ci'] = $user->ci;
        $this->userEdit['email'] = $user->email;
        $this->userEdit['phone_number'] = $user->phone_number;
        $this->userEdit['company_position'] = $user->company_position;
    }
    public function update()
    {
        if ($this->userEdit['password'] == "" && $this->userEdit['passwordConfirmation'] == "") {
            $this->validate([
                'userEdit.name' => 'required|max:255',            
                'userEdit.phone_number' => 'required|numeric|min:10',
                'userEdit.company_position' => 'required|max:255|string',
            ]);
        } else {
            $this->validate([
                'userEdit.name' => 'required|max:255',
                'userEdit.password' => 'required|min:8',
                'userEdit.passwordConfirmation' => 'required|same:userEdit.password',          
                'userEdit.phone_number' => 'required|numeric|min:10',
                'userEdit.company_position' => 'required|max:255|string',
            ]);
        }
        $user = User::find($this->userEditId);
        if ($this->userEdit['password'] == "") {
            $user->update([
                'name' => $this->userEdit['name'],
                'phone_number' => $this->userEdit['phone_number'],
                'company_position' => $this->userEdit['company_position'],

            ]);
        } else {
            $user->update([
                'name' => $this->userEdit['name'],
                'password' => Hash::make($this->userEdit['password']),
                'phone_number' => $this->userEdit['phone_number'],
                'company_position' => $this->userEdit['company_position'],
            ]);
        }
        $this->reset(['userEditId', 'userEdit', 'openUpdate']);
        //Aletar despues de crear
        $this->dispatch('alert', 'Actualizado con Exito');
    }
    public function rol(User $users)
    {
        $this->openRol = true;
        $this->idUserRol = $users;
        $this->userId = $users->id;
        $roles = Role::all();
        $role_has_permissions = DB::table('users')
            ->select('model_has_roles.role_id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.role_id')
            ->where('model_has_roles.model_id', $users->id)
            ->pluck('model_has_roles.role_id')
            ->toArray();
        $this->rolForm['selectedRol'] = $role_has_permissions;

        $this->roles = $roles;
        $this->nameRol = $users->name;
    }
    public function assignRole(User $user)
    {
        $selectedRole = $this->rolForm['selectedRol'];
        $user->roles()->sync($selectedRole);

        $this->reset();
        //Aletar despues de crear
        $this->dispatch('alert', 'Actualizado con Exito');

    }
    public function destroy($userId)
    {
        $user = User::find($userId);
        if ($user->state) {
            $user->update([
                'state' => false
            ]);
        } else {
            $user->update([
                'state' => true
            ]);
        }
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

        $users = User::where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.usuarios.show-users', compact('users'));
    }
}
