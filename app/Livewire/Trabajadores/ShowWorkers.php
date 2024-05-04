<?php

namespace App\Livewire\Trabajadores;

use App\Models\Workers;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class ShowWorkers extends Component
{
    use WithPagination;
    public $name, $last_name, $ci, $company_position, $phone_number, $selectedDepartment = "";
    public $search = '';
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = '10';
    public $openCreate = false;
    public $openUpdate = false;   
    public $workersEditId;
    protected $queryString = [
        'sort' => ['except' => 'id'],
        'cant' => ['except' => '10'],
        'direction' => ['except' => 'desc'],

    ];
    protected $validationAttributes = [
        'name' => 'nombre',
        'last_name' => 'apellido',
        'ci' => 'carnet',
        'selectedDepartment' => 'deparmento',
        'company_position' => 'dirección',
        'phone_number' => 'celular',

        'postForm.name' => 'nombre',
        'postForm.last_name' => 'apellido',
        'postForm.ci' => 'carnet',
        'postForm.selectedDepartment' => 'departamento',
        'postForm.company_position' => 'dirección',
        'postForm.phone_number' => 'celular',
    ];
    public $postForm = [
        'name' => 'asdf',
        'last_name' => '',
        'ci' => '',
        'selectedDepartment' => '',
        'company_position' => '',
        'phone_number' => '',
    ];
    public function openCreateModal()
    {
        $this->reset();
        $this->resetValidation();
        $this->openCreate = true;
    }
    public function save()
    {
        $this->validate([
            'ci' => 'numeric|required|unique:workers',
            'name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'selectedDepartment' => 'required',
            'company_position' => 'required|max:100',
            'phone_number' => 'numeric|required|min:1',
        ]);

        Workers::create([
            'ci' => $this->ci,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'ubication' => $this->selectedDepartment,
            'phone_number' => $this->phone_number,
            'company_position' => $this->company_position,
        ]);
        $this->dispatch('alert', 'Creado con Exito');
        $this->reset();

    }
    public function edit($idWork)
    {
        $this->resetValidation();
        $this->openUpdate = true;
        $workers = Workers::where('id', $idWork)->first();
        $this->postForm['ci'] = $workers->ci;
        $this->postForm['name'] = $workers->name;
        $this->postForm['last_name'] = $workers->last_name;
        $this->postForm['selectedDepartment'] = $workers->ubication;
        $this->postForm['company_position'] = $workers->company_position;
        $this->postForm['phone_number'] = $workers->phone_number;
        $this->workersEditId = $idWork;
    }
    public function udpate($id)
    {
        $this->validate([
            'postForm.ci' => [
                'numeric',
                'required',
                Rule::unique('workers', 'ci')->ignore($id),
            ],
            'postForm.name' => 'required|max:100',
            'postForm.last_name' => 'required|max:100',
            'postForm.selectedDepartment' => 'required',
            'postForm.company_position' => 'required|max:100',
            'postForm.phone_number' => 'numeric|required|min:1',
        ]);
        $worker = Workers::find($id);
        $worker->update([
            'ci' => $this->postForm['ci'],
            'name' => $this->postForm['name'],
            'last_name' => $this->postForm['last_name'],
            'selectedDepartment' => $this->postForm['selectedDepartment'],
            'company_position' => $this->postForm['company_position'],
            'phone_number' => $this->postForm['phone_number'],
        ]);
        $this->reset();
        $this->resetValidation();
        $this->dispatch('alert', 'Actualizado con Exito');
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
        $users = Workers::where('ci', 'like', '%' . $this->search . '%')
            ->orWhere('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.trabajadores.show-workers', compact('users'));
    }
}
