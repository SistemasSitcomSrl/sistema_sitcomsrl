<?php

namespace App\Livewire\Proyectos;

use Livewire\Component;
use App\Models\Projects;
use App\Models\User;
use Livewire\WithPagination;

class ShowProjects extends Component
{
    use WithPagination;
    public $create_entity, $create_cuce, $create_ubi_entity, $create_object, $create_date_opening, $create_date_notification, $create_reference_price, $create_type;
    public $selectUser = '';
    public $create_selectedDepartment = '';
    public $edit_entity, $edit_cuce, $edit_ubi_entity, $edit_object, $edit_date_opening, $edit_date_notification, $edit_reference_price, $edit_type;
    public $edit_selectUser = '';
    public $edit_selectedDepartment = '';
    public $tool_id, $project_id;
    public $search = '';
    public $sort = 'projects.id';
    public $direction = 'desc';
    public $openUpdate = false;
    public $cant = '10';
    public $openCreate = false;
    protected $listeners = ['render', 'projectState'];
    protected $queryString = [
        'sort' => ['except' => 'id'],
        'cant' => ['except' => '10'],
        'direction' => ['except' => 'desc'],
        'search' => ['except' => '']
    ];
    public $toolForm = [
        'edit_entity' => '',
        'edit_cuce' => '',
        'edit_ubi_entity' => '',
        'edit_object' => '',
        'edit_date_opening' => '',
        'edit_date_notification' => '',
        'edit_reference_price' => '',
        'edit_selectedDepartment' => '',
        'edit_selectUser' => ''
    ];
    protected $validationAttributes = [
        'create_entity' => 'entidad',
        'create_cuce' => 'cuce',
        'create_ubi_entity' => 'ciudad trabajo',
        'create_object' => 'descripción',
        'create_date_opening' => 'fecha apertura',
        'create_date_notification' => 'fecha de adjudicación',
        'create_reference_price' => 'precio referencial',
        'create_selectedDepartment' => 'departamento',
        'create_type' => 'tipo',
        'selectUser' => 'encargado',

        'toolForm.edit_entity' => 'entidad',
        'toolForm.edit_cuce' => 'cuce',
        'toolForm.edit_ubi_entity' => 'ciudad trabajo',
        'toolForm.edit_object' => 'descripción',
        'toolForm.edit_date_opening' => 'fecha apertura',
        'toolForm.edit_date_notification' => 'fecha de adjudicación',
        'toolForm.edit_reference_price' => 'precio referencial',
        'toolForm.edit_selectedDepartment' => 'departamento',
        'toolForm.edit_type' => 'tipo',
        'toolForm.edit_selectUser' => 'encargado',
    ];
    public function save()
    {
        $this->resetValidation();
        $this->reset();
        $this->openCreate = true;
    }
    public function create()
    {
        $this->resetValidation();
        $this->validate([
            'create_entity' => 'required',
            'create_cuce' => 'required',
            'create_object' => 'required',
            'create_ubi_entity' => 'required',
            'create_date_opening' => 'required',
            'create_date_notification' => 'required',
            'create_reference_price' => 'required',
            'create_selectedDepartment' => 'required',
            'create_type' => 'required',
            'selectUser' => 'required',
        ]);

        Projects::create([
            'entity' => $this->create_entity,
            'cuce' => $this->create_cuce,
            'ubi_entity' => $this->create_ubi_entity,
            'ubi_projects' => $this->create_selectedDepartment,
            'object' => $this->create_object,
            'date_opening' => $this->create_date_opening,
            'date_notification' => $this->create_date_notification,
            'reference_price' => $this->create_reference_price,
            'type' => $this->create_type,
            'id_user' => $this->selectUser
        ]);
        $this->dispatch('alert', 'Creado con Exito');
        $this->reset();
    }
    public function edit($id)
    {
        $this->resetValidation();
        $this->openUpdate = true;
        $this->tool_id = $id;
        $tool = Projects::find($id);
        $this->toolForm['edit_entity'] = $tool->entity;
        $this->toolForm['edit_cuce'] = $tool->cuce;
        $this->toolForm['edit_ubi_entity'] = $tool->ubi_entity;
        $this->toolForm['edit_object'] = $tool->object; 
        $this->toolForm['edit_date_opening'] = $tool->date_opening;
        $this->toolForm['edit_date_notification'] = $tool->date_notification;
        $this->toolForm['edit_reference_price'] = $tool->reference_price;       
        $this->toolForm['edit_selectedDepartment'] = $tool->ubi_projects;
        $this->toolForm['edit_type'] = $tool->type;
        $this->toolForm['edit_selectUser'] = $tool->id_user;
    }
    public function update($id)
    {
        $this->resetValidation();
        $this->validate([
            'toolForm.edit_entity' => 'required',
            'toolForm.edit_cuce' => 'required',
            'toolForm.edit_ubi_entity' => 'required',
            'toolForm.edit_object' => 'required',            
            'toolForm.edit_date_opening' => 'required',
            'toolForm.edit_date_notification' => 'required',
            'toolForm.edit_reference_price' => 'required',
            'toolForm.edit_selectedDepartment' => 'required',
            'toolForm.edit_type' => 'required',
            'toolForm.edit_selectUser' => 'required',
        ]);
        Projects::where('id', $id)->update([
            'entity' => $this->toolForm['edit_entity'],
            'cuce' => $this->toolForm['edit_cuce'],
            'ubi_entity' => $this->toolForm['edit_ubi_entity'],
            'object' => $this->toolForm['edit_object'],            
            'date_opening' => $this->toolForm['edit_date_opening'],
            'date_notification' => $this->toolForm['edit_date_notification'],
            'reference_price' => $this->toolForm['edit_reference_price'],          
            'ubi_projects' => $this->toolForm['edit_selectedDepartment'],
            'type' => $this->toolForm['edit_type'],
            'id_user' => $this->toolForm['edit_selectUser'],
        ]);
        $this->dispatch('alert', 'Actualizado con Exito');
        $this->reset();
    }
    public function projectState($project_id)
    {
        $project = Projects::find($project_id);
        if ($project->state) {
            $project->update([
                'state' => 0
            ]);
        } else {
            $project->update([
                'state' => true
            ]);
        }
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
        $projects = Projects::join('users', 'projects.id_user', '=', 'users.id')
            ->select('projects.*', 'users.name as name_user')
            ->where('projects.object', 'like', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        $users = User::where('id', '<>', 1)->where('state', true)->get();

        return view('livewire.proyectos.show-projects', compact('projects', 'users'));
    }
}
