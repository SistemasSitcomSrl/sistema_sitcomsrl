<?php

namespace App\Livewire\Herramientas;

use Livewire\Component;
use App\Models\Inventory;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class ShowPosts extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $name_equipment, $bar_Code, $brand, $color, $amount, $location, $unit_measure, $price, $image_path, $type, $state = true;
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $open = false;
    public $postEditId = '';
    public $cant = '10';
    public $rutaActual;
    public $selectBranch;
    public $create_image, $update_image;
    public $imageTool = false;
    public $searchKey, $canthKey, $select;
    protected $queryString = [
        'sort' => ['except' => 'id'],
        'cant' => ['except' => '10'],
        'direction' => ['except' => 'desc'],
        'search' => ['except' => '']
    ];
    public $postForm = [
        'name_equipment' => '',
        'bar_Code' => '',
        'brand' => '',
        'color' => '',
        'amount' => '',
        'location' => '',
        'unit_measure' => '',
        'price' => '',
        'image_path' => '',
        'select' => '',
        'type' => ''
    ];
    protected $listeners = [
        'render',
        'destroy',
    ];
    protected $validationAttributes = [
        'update_image' => 'imagen',
    ];
    public function edit($postId)
    {
        $this->reset('update_image');
        $this->resetValidation();
        $this->open = true;
        $this->postEditId = $postId;
        $post = Inventory::find($postId);
        $this->postForm['name_equipment'] = $post->name_equipment;
        $this->postForm['bar_Code'] = $post->bar_Code;
        $this->postForm['brand'] = $post->brand;
        $this->postForm['color'] = $post->color;
        $this->postForm['amount'] = $post->amount;
        $this->postForm['location'] = $post->location;
        $this->postForm['unit_measure'] = $post->unit_measure;
        $this->postForm['price'] = $post->price;
        $this->postForm['type'] = $post->type;
        $this->imageTool = $post->image_path;
    }
    public function update()
    {
        $this->validate([
            'update_image' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $post = Inventory::find($this->postEditId);
        if ($this->update_image) {
            if ($post->image_path) {
                Storage::delete($post->image_path);
            }
            $post->image_path = $this->update_image->store('tool');
            $post->save();
        }
        $this->reset(['postEditId', 'postForm', 'open']);
        $this->dispatch('alert', 'Actualizado con Exito');
    }
    public function resetInput()
    {
        $this->search = null;
        $this->resetPage();
        $this->sort = 'inventories.id';
        $this->direction = 'desc';
        $this->cant = '10';
        $this->searchKey = rand();
        $this->canthKey = rand();
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
    public function mount()
    {
        $this->rutaActual = request()->route()->getName();
    }

    public function render()
    {
        //Obtener la ruta actual
        $rutaActual = $this->rutaActual;

        //Obtener los id de las sucursales que tienen el rol encargado de activo
        $activo_rol_branch = Branch::join('model_has_roles', 'branches.user_id', '=', 'model_has_roles.model_id')
            ->where('model_has_roles.role_id', 3)
            ->pluck('branches.id')
            ->toArray() ?: [];

        //Obtener el nombre de la sucursal para mostrarlo en la vista
        $branch_name = Branch::where('user_id', Auth::user()->id)->value('name');

        // En caso de que no haya sucursal, se asigna el valor de "Todas las Sucursales"
        if ($branch_name == null) {
            $branch_name = "Todas las Sucursales";
        }

        $this->postForm['select'] = $branch_id = Branch::where('user_id', Auth::user()->id)->value('id');

        // Si se selecciona una sucursal, se asigna el valor de la sucursal seleccionada
        if ($this->selectBranch != null) {
            if ($this->selectBranch == 0) {
                $branch_id = null;
                $branch_name = "Todas las Sucursales";
            } else {
                $branch_id = $this->selectBranch;
                $branch_name = Branch::where('id', $this->selectBranch)->value('name');
            }
        }
        //Obtener las sucursales para mostrarlas en el select sin la sucursal activo fijo
        $inputBranch = Branch::select('id', 'name')->where('id', '!=', 1)->get();

        //Mostar los datos segun el rol
        $rol = Role::join('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('model_has_roles.model_id', Auth::user()->id)
            ->value('roles.name');

        // El switch se encarga de mostrar los datos segun el rol
        switch ($rol) {
            case 'Encargado de Activo':
                // Si el rol es Encargado de Activo, solo se muestran los datos de la sucursal a la que pertenece
                $posts = Inventory::join('branches', 'inventories.branch_id', '=', 'branches.id')
                    ->select('inventories.*', 'branches.name as name_branch')
                    ->where('inventories.branch_id', $branch_id)
                    ->where('inventories.name_equipment', 'like', '%' . $this->search . '%')
                    ->where('state', 1)
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->cant);
                break;

            case 'Administrador':
                $branch_ids = $rutaActual == 'admin.inventory_asset.index' ? $activo_rol_branch : array_diff(Branch::pluck('id')->toArray(), $activo_rol_branch);
                $posts = Inventory::join('branches', 'inventories.branch_id', '=', 'branches.id')
                    ->select('inventories.*', 'branches.name as name_branch')
                    ->whereIn('inventories.branch_id', $branch_ids)
                    ->where('inventories.name_equipment', 'like', '%' . $this->search . '%')
                    ->where('state', 1)
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->cant);

                break;
            default:
                // Si el rol es diferente de Encargado de Activo, se muestran los datos de todas las sucursales menos la de activo fijo
                $posts = Inventory::join('branches', 'inventories.branch_id', '=', 'branches.id')
                    ->select('inventories.*', 'branches.name as name_branch')
                    ->where(function ($query) use ($branch_id) {
                        // Si $branch_id es null, no aplicamos la condición
                        if ($branch_id !== null) {
                            $query->where('inventories.branch_id', $branch_id);
                        } else {
                            $query->where('inventories.branch_id', '!=', 1);
                        }
                    })
                    ->where('inventories.name_equipment', 'like', '%' . $this->search . '%')
                    ->where('state', 1)
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->cant);
                break;
        }
        return view('livewire.herramientas.show-posts', compact('posts', 'branch_name', 'inputBranch'));
    }

}
