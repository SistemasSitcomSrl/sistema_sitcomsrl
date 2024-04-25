<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;


class ShowRoles extends Component
{
    use WithPagination;
    public $search = '';
    public $sort = 'id';
    public $direction = 'asc';
    public $cant = '10';
    public $openRol = false;
    public $openUpdate = false;
    public $permissions;
    public $name;
    public $roleId;
    public $role_has_permissions;
    public $create_selectedPermission = [];
    public $edit_selectedPermission = [];
    protected $listeners = ['destroy'];
    protected $queryString = [
        'sort' => ['except' => 'id'],
        'cant' => ['except' => '10'],
        'direction' => ['except' => 'desc'],
        'search' => ['except' => '']
    ];
    protected $validationAttributes = [
        'name' => 'nombre del rol',
        'create_selectedPermission' => 'permiso',
        'rolForm.name' => 'nombre del rol',
        'rolForm.edit_selectedPermission' => 'permiso'

    ];
    public $rolForm = [
        'name' => '',
        'edit_selectedPermission' => []
    ];
    public function save()
    {
        $this->reset();
        $this->resetValidation();
        $this->openRol = true;
        $this->permissions = Permission::all();
    }
    public function create()
    {
        $this->validate([
            'name' => 'required|max:255|unique:roles',
            'create_selectedPermission' => 'required',
        ]);
        $role = Role::create(['name' => $this->name]);
        $role->permissions()->sync($this->create_selectedPermission);
        $this->reset();
        $this->dispatch('alert', 'Creado con Exito');
    }
    public function edit(Role $role)
    {
        $this->openUpdate = true;
        $this->resetValidation();
        $this->roleId = $role->id;

        $this->permissions = Permission::all();
        $role_has_permissions = DB::table('roles')
            ->select('role_has_permissions.permission_id')
            ->join('role_has_permissions', 'roles.id', '=', 'role_has_permissions.role_id')
            ->where('role_has_permissions.role_id', $role->id)
            ->pluck('role_has_permissions.permission_id')
            ->toArray();
        $this->rolForm['name'] = $role->name;
        $this->rolForm['edit_selectedPermission'] = $role_has_permissions;

    }
    public function update(Role $role)
    {
        $this->validate([
            'rolForm.edit_selectedPermission' => 'required',
        ]);
        $role->update([
            'name' => $this->rolForm['name'],
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $edit_selectedPermission = $this->rolForm['edit_selectedPermission'];
        $role->permissions()->sync($edit_selectedPermission);
        $this->reset();
        $this->dispatch('alert', 'Actualizado con Exito');
    }

    public function destroy(Role $roleId)
    {
        $roleId->delete();
    }
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
        $roles = Role::where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.roles.show-roles', compact('roles'));
    }
}
