<?php

namespace App\Livewire\Usuarios;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUsers extends Component
{
    public $name, $ci, $email, $password, $passwordConfirmation, $phone_number, $company_position, $branch;
    public $openCreate = false;
    public $validationAttributes = [
        'name' => 'nombre completo',
        'email' => 'correo electronico',
        'password' => 'contraseña',
        'passwordConfirmation' => 'repetir contraseña',
        'phone_number' => 'numero',
        'company_position' => 'cargo',
        'branch' => 'sucursal',
    ];
    protected $listeners = ['render'];
    // regex:/^[\p{L}\p{M}\s.\-]+$/u|
    protected $rules = [
        'name' => 'required|max:255',
        'ci' => 'required|unique:users',
        'email' => 'required|string|lowercase|email|max:255|unique:users',
        'password' => 'required|min:8',
        'passwordConfirmation' => 'required|same:password',
        'phone_number' => 'required|numeric|min:10',
        'company_position' => 'required|max:255|string',

    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatingOpenCreate()
    {
        if ($this->openCreate == true) {
            $this->reset(['name', 'email', 'password', 'phone_number', 'company_position', 'branch']);
        }
    }
    public function create()
    {
        $this->validate();
        User::create([
            'name' => $this->name,
            'ci' => $this->ci,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'phone_number' => $this->phone_number,
            'company_position' => $this->company_position,
            'branch' => $this->branch
        ]);
        //Renderizar Showposts
        $this->dispatch('render')->to(ShowUsers::class);
        //Aletar despues de crear
        $this->dispatch('alert', 'Creado con Exito');
        //Cerrar Modal
        $this->reset(['name', 'ci', 'email', 'password', 'phone_number', 'company_position', 'branch', 'openCreate']);
    }
    public function save()
    {
        $this->openCreate = true;
    }
    public function render()
    {
        return view('livewire.usuarios.create-users');
    }
}
