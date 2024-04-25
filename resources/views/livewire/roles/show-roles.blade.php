<div>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <h2 class="py-1 text-lg font-bold leading-tight tracking-tight text-dark-900 md:text-2xl dark:text-dark">
            Lista de Roles
        </h2>
        <x-table>
            <div class="px-3 py-3 flex items-center">
                <div wire:model.live="cant" class="flex items-center">
                    <span>Mostrar</span>
                    <select class="mx-2 form-control">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100&nbsp;&nbsp;&nbsp;&nbsp;</option>
                    </select>
                    <span>Entradas</span>
                </div>
                <x-input class="flex-1 mx-2" placeholder="Buscador Nombre del Rol" type="text"
                    wire:model.live="search" />

                @can('admin.rol.create')
                    <x-secondary-button wire:click="save">
                        <i class="fa-solid fa-plus"></i> &nbsp;Crear Rol
                    </x-secondary-button>
                @endcan

            </div>

            @if ($roles->count())
                <table class="table-fixed min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 sticky top-0">
                        <tr>
                            <th scope="col"
                                class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('id')">

                                @if ($sort == 'id')
                                    @if ($direction == 'asc')
                                        <i class="fa-solid fa-arrow-down-1-9">&nbsp;</i>Nro
                                    @else
                                        <i class="fa-solid fa-arrow-up-9-1">&nbsp;</i>Nro
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Nro
                                @endif

                            </th>
                            <th scope="col"
                                class="px-1 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('name')">

                                @if ($sort == 'name')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Nombre
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Nombre
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Nombre
                                @endif

                            </th>
                            <th scope="col"
                                class="px-1 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('created_at')">

                                @if ($sort == 'created_at')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Fecha Creacion
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Fecha Creacion
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Fecha Creacion
                                @endif
                            </th>
                            <th scope="col"
                                class="px-1 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('updated_at')">

                                @if ($sort == 'updated_at')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Fecha Actualizada
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Fecha Actualizada
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Fecha Actualizada
                                @endif
                            </th>

                            @php
                                $can = Gate::allows('admin.rol.edit') || Gate::allows('admin.rol.delete');
                            @endphp

                            @if ($can)
                                <th scope="col"
                                    class="px-1 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Opciones
                                </th>
                            @endif
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($roles as $role)
                            <tr wire:key="role-{{ $role->id }}">
                                <td class="px-1 text-center" style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                    <div class="text-sm text-gray-900">
                                        {{ $role->id }}
                                    </div>
                                </td>
                                <td class="px-1 text-center "
                                    style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                    <div class="text-sm text-gray-900">
                                        {{ $role->name }}
                                    </div>
                                </td>
                                <td class="px-1 text-center "
                                    style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                    <div class="text-sm text-gray-900">
                                        {{ $role->created_at }}
                                    </div>
                                </td>
                                <td class="px-1 text-center" style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                    <div class="text-sm text-gray-900">
                                        {{ $role->updated_at }}
                                    </div>
                                </td>
                                <td class=" pt-1 text-center"
                                    style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                    @can('admin.rol.edit')
                                        <button wire:click="edit({{ $role->id }})"
                                            class= "inline-flex items-center px-3 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-offset-2 transition ease-in-out duration-150">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                    @endcan

                                    @can('admin.rol.delete')
                                        <button wire:click="$dispatch('deleteRole',{{ $role->id }})"
                                            class= "inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-700 focus:ring-offset-2 transition ease-in-out duration-150">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-6 py-4">
                    No existe ningun registro coincidente: {{ $search }}
                </div>
            @endif

            @if ($roles->hasPages(2))
                <div class="px-3 py-2">
                    {{ $roles->links() }}
                </div>
            @endif
        </x-table>
    </div>
    {{-- Fin - Lista de Roles --}}


    {{-- Inicio - Lista de Permisos --}}
    @if ($openRol)
        <div class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 bg-gray-900 bg-opacity-25 ">
            <div class="pt-6">
                <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 lg:py-6">
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex">
                            <p class="font-bold text-base align-middle m-0  ">
                                Crear Rol
                            </p>
                            <button type="button" wire:click="$set('openRol',false)"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-red-500 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center  dark:hover:bg-gray-400 dark:hover:text-red"
                                data-modal-hide="static-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <form wire:submit="create">

                            <div>
                                <x-label value="Nombre del Rol: *" />
                                <x-input wire:model="name" type="text" class="w-full" />
                                <x-input-error for="name" />
                            </div>

                            <x-label class="py-1" value="Lista de Roles: *" />
                            {{-- Inicio Tabla Movimientos --}}
                            <table class="table-fixed border w-full">
                                <thead class="bg-slate-200 static top-0 border border-neutral-950 ">
                                    <tr class="px-1 py-1 text-center text-sm font-bold text-gray-900 ">
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                            Ver
                                        </th>
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-stone-100 text-center">
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                                Inicio
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="1"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </td>
                                        <td class="px-1 py-1">
                                        </td>
                                        <td class="px-1 py-1">
                                        </td>
                                        <td class="px-1 py-1">
                                        </td>
                                        <td class="px-1 py-1">
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            {{-- Final Tabla Movimientos --}}
                            {{-- Inicio Tabla Usuario --}}
                            <table class="table-fixed border w-full">
                                <thead class="bg-slate-200 static top-0 border border-neutral-950 ">
                                    <tr class="px-1 py-1 text-center text-sm font-bold text-gray-900 ">
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                            Lista
                                        </th>
                                        <th scope="col">
                                            Crear
                                        </th>
                                        <th scope="col">
                                            Editar
                                        </th>
                                        <th scope="col">
                                            Rol
                                        </th>
                                        <th scope="col">
                                            Estado
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg-stone-100 text-center">
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                                Usuario
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="2"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="3"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="4"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="5"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="6"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            {{-- Final Tabla Usuarios --}}

                            {{-- Inicio Tabla Roles --}}
                            <table class="table-fixed border w-full">
                                <thead class="bg-slate-200 static top-0 border border-neutral-950 ">
                                    <tr class="px-1 py-1 text-center text-sm font-bold text-gray-900 ">
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                            Lista
                                        </th>
                                        <th scope="col">
                                            Crear
                                        </th>
                                        <th scope="col">
                                            Editar
                                        </th>
                                        <th scope="col">
                                            Eliminar
                                        </th>
                                        <th scope="col">

                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg-stone-100 text-center">
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                                Roles
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="7"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="8"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="9"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="10"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            {{-- Final Tabla Roles --}}

                            {{-- Inicio Tabla Proyecto --}}
                            <table class="table-fixed border w-full">
                                <thead class="bg-slate-200 static top-0 border border-neutral-950 ">
                                    <tr class="px-1 py-1 text-center text-sm font-bold text-gray-900 ">
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                            Lista
                                        </th>
                                        <th scope="col">
                                            Crear
                                        </th>
                                        <th scope="col">
                                            Editar
                                        </th>
                                        <th scope="col">
                                            Estado
                                        </th>
                                        <th scope="col">

                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg-stone-100 text-center">
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                                Proyectos
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="11"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="12"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="13"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="14"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            {{-- Final Tabla Proyecto --}}

                            {{-- Inicio Tabla Sucursal --}}
                            <table class="table-fixed border w-full">
                                <thead class="bg-slate-200 static top-0 border border-neutral-950 ">
                                    <tr class="px-1 py-1 text-center text-sm font-bold text-gray-900 ">
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                            Lista
                                        </th>
                                        <th scope="col">
                                            Crear
                                        </th>
                                        <th scope="col">
                                            Editar
                                        </th>
                                        <th scope="col">
                                            Estado
                                        </th>
                                        <th scope="col">
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg-stone-100 text-center">
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                                Sucursales
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="15"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="16"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="17"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="18"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            {{-- Final Tabla Sucursal --}}

                            {{-- Inicio Tabla Herramienta --}}
                            <table class="table-fixed border w-full">
                                <thead class="bg-slate-200 static top-0 border border-neutral-950 ">
                                    <tr class="px-1 py-1 text-center text-sm font-bold text-gray-900 ">
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                            Lista
                                        </th>
                                        <th scope="col">
                                            Ver
                                        </th>
                                        <th scope="col">
                                            Act. Imagen
                                        </th>
                                        <th scope="col">
                                            Pdf
                                        </th>
                                        <th scope="col">
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg-stone-100 text-center">
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                                Inventario
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="19"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="20"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="21"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="22"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            {{-- Final Tabla Herramienta --}}

                            {{-- Inicio Tabla Solicitud --}}
                            <table class="table-fixed border w-full">
                                <thead class="bg-slate-200 static top-0 border border-neutral-950 ">
                                    <tr class="px-1 py-1 text-center text-sm font-bold text-gray-900 ">
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                            Lista
                                        </th>
                                        <th scope="col">
                                            Crear
                                        </th>
                                        <th scope="col">
                                            Ver
                                        </th>
                                        <th scope="col">
                                            Pdf
                                        </th>
                                        <th scope="col">
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg-stone-100 text-center">
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                                Solicitud
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="23"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="24"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="25"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="26"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            {{-- Final Tabla Solicitud --}}

                            {{-- Inicio Tabla Retirados --}}
                            <table class="table-fixed border w-full">
                                <thead class="bg-slate-200 static top-0 border border-neutral-950 ">
                                    <tr class="px-1 py-1 text-center text-sm font-bold text-gray-900 ">
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                            Lista
                                        </th>
                                        <th scope="col">
                                            Crear
                                        </th>
                                        <th scope="col">
                                            Ver
                                        </th>
                                        <th scope="col">
                                            Pdf
                                        </th>
                                        <th scope="col">
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg-stone-100 text-center">
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                                Retirados
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="31"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="32"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="33"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="34"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            {{-- Final Tabla Solicitud --}}

                            {{-- Inicio Tabla Transferencias Enviadas --}}
                            <table class="table-fixed border w-full">
                                <thead class="bg-slate-200 static top-0 border border-neutral-950 ">
                                    <tr class="px-1 py-1 text-center text-sm font-bold text-gray-900 ">
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                            Lista
                                        </th>
                                        <th scope="col">
                                            Crear
                                        </th>
                                        <th scope="col">
                                            Ver
                                        </th>
                                        <th scope="col">
                                            Pdf
                                        </th>
                                        <th scope="col">
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg-stone-100 text-center">
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                                Transf. Enviadas
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="35"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="36"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="37"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="38"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            {{-- Final Tabla Transferencias Enviadas --}}

                            {{-- Inicio Tabla Transferencias Recibidas --}}
                            <table class="table-fixed border w-full">
                                <thead class="bg-slate-200 static top-0 border border-neutral-950 ">
                                    <tr class="px-1 py-1 text-center text-sm font-bold text-gray-900 ">
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                            Lista
                                        </th>
                                        <th scope="col">
                                            Ver
                                        </th>
                                        <th scope="col">
                                            Editar
                                        </th>
                                        <th scope="col">
                                            Pdf
                                        </th>
                                        <th scope="col">
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg-stone-100 text-center">
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                                Transf. Recibidas
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="39"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="40"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="41"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="42"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            {{-- Final Tabla Transferencias Enviadas --}}

                            {{-- Inicio Tabla Movimientos --}}
                            <table class="table-fixed border w-full">
                                <thead class="bg-slate-200 static top-0 border border-neutral-950 ">
                                    <tr class="px-1 py-1 text-center text-sm font-bold text-gray-900 ">
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                            Lista
                                        </th>
                                        <th scope="col">
                                            Crear
                                        </th>
                                        <th scope="col">
                                            Editar
                                        </th>
                                        <th scope="col">
                                            Ver
                                        </th>
                                        <th scope="col">
                                            Pdf
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg-stone-100 text-center">
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                                Movimientos
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="43"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="44"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="45"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="46"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="47"
                                                    wire:model="create_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            {{-- Final Tabla Movimientos --}}
                            <div class="text-right pt-4">
                                <x-danger-button wire:click="$set('openRol',false)" class="mr-2">
                                    <i class="fa-solid fa-xmark fa-lg"></i>&nbsp;Cancelar
                                </x-danger-button>
                                <x-secondary-button type="submit" wire:loading.attr="disabled" wire:target="update"
                                    class="disabled:opacity-55">
                                    <i class="fa-solid fa-floppy-disk fa-lg"></i>&nbsp; Guardar
                                </x-secondary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- Fin - Lista de Permisos --}}

    {{-- Inicio - Editar Lista de Permisos --}}
    @if ($openUpdate)
        <div class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 bg-gray-900 bg-opacity-25 ">
            <div class="pt-6">
                <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 lg:py-6">
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex">
                            <p class="font-bold text-base align-middle m-0  ">
                                Editar Rol
                            </p>
                            <button type="button" wire:click="$set('openUpdate',false)"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-red-500 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center  dark:hover:bg-gray-400 dark:hover:text-red"
                                data-modal-hide="static-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <form wire:submit="update({{ $roleId }})">

                            <div>
                                <x-label value="Nombre del Rol:" />
                                <x-input wire:model="rolForm.name" type="text" class="w-full" disabled />
                            </div>

                            <x-label class="py-1" value="Lista de Roles:" />

                            {{-- Inicio Tabla Movimientos --}}
                            <table class="table-fixed border w-full">
                                <thead class="bg-slate-200 static top-0 border border-neutral-950 ">
                                    <tr class="px-1 py-1 text-center text-sm font-bold text-gray-900 ">
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                            Ver
                                        </th>
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-stone-100 text-center">
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                                Inicio
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="1"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </td>
                                        <td class="px-1 py-1">
                                        </td>
                                        <td class="px-1 py-1">
                                        </td>
                                        <td class="px-1 py-1">
                                        </td>
                                        <td class="px-1 py-1">
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            {{-- Final Tabla Movimientos --}}
                            {{-- Inicio Tabla Usuario --}}
                            <table class="table-fixed border w-full">
                                <thead class="bg-slate-200 static top-0 border border-neutral-950 ">
                                    <tr class="px-1 py-1 text-center text-sm font-bold text-gray-900 ">
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                            Lista
                                        </th>
                                        <th scope="col">
                                            Crear
                                        </th>
                                        <th scope="col">
                                            Editar
                                        </th>
                                        <th scope="col">
                                            Rol
                                        </th>
                                        <th scope="col">
                                            Estado
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg-stone-100 text-center">
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                                Usuario
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="2"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="3"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="4"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="5"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="6"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            {{-- Final Tabla Usuarios --}}

                            {{-- Inicio Tabla Roles --}}
                            <table class="table-fixed border w-full">
                                <thead class="bg-slate-200 static top-0 border border-neutral-950 ">
                                    <tr class="px-1 py-1 text-center text-sm font-bold text-gray-900 ">
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                            Lista
                                        </th>
                                        <th scope="col">
                                            Crear
                                        </th>
                                        <th scope="col">
                                            Editar
                                        </th>
                                        <th scope="col">
                                            Eliminar
                                        </th>
                                        <th scope="col">

                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg-stone-100 text-center">
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                                Roles
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="7"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="8"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="9"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="10"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            {{-- Final Tabla Roles --}}

                            {{-- Inicio Tabla Proyecto --}}
                            <table class="table-fixed border w-full">
                                <thead class="bg-slate-200 static top-0 border border-neutral-950 ">
                                    <tr class="px-1 py-1 text-center text-sm font-bold text-gray-900 ">
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                            Lista
                                        </th>
                                        <th scope="col">
                                            Crear
                                        </th>
                                        <th scope="col">
                                            Editar
                                        </th>
                                        <th scope="col">
                                            Estado
                                        </th>
                                        <th scope="col">

                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg-stone-100 text-center">
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                                Proyectos
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="11"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="12"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="13"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="14"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            {{-- Final Tabla Proyecto --}}

                            {{-- Inicio Tabla Sucursal --}}
                            <table class="table-fixed border w-full">
                                <thead class="bg-slate-200 static top-0 border border-neutral-950 ">
                                    <tr class="px-1 py-1 text-center text-sm font-bold text-gray-900 ">
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                            Lista
                                        </th>
                                        <th scope="col">
                                            Crear
                                        </th>
                                        <th scope="col">
                                            Editar
                                        </th>
                                        <th scope="col">
                                            Estado
                                        </th>
                                        <th scope="col">
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg-stone-100 text-center">
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                                Sucursales
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="15"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="16"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="17"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="18"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            {{-- Final Tabla Sucursal --}}

                            {{-- Inicio Tabla Herramienta --}}
                            <table class="table-fixed border w-full">
                                <thead class="bg-slate-200 static top-0 border border-neutral-950 ">
                                    <tr class="px-1 py-1 text-center text-sm font-bold text-gray-900 ">
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                            Lista
                                        </th>
                                        <th scope="col">
                                            Ver
                                        </th>
                                        <th scope="col">
                                            Act. Imagen
                                        </th>
                                        <th scope="col">
                                            Pdf
                                        </th>
                                        <th scope="col">
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg-stone-100 text-center">
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                                Inventario
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="19"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="20"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="21"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input type="checkbox" value="22"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            {{-- Final Tabla Herramienta --}}

                            {{-- Inicio Tabla Solicitud --}}
                            <table class="table-fixed border w-full">
                                <thead class="bg-slate-200 static top-0 border border-neutral-950 ">
                                    <tr class="px-1 py-1 text-center text-sm font-bold text-gray-900 ">
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                            Lista
                                        </th>
                                        <th scope="col">
                                            Crear
                                        </th>
                                        <th scope="col">
                                            Ver
                                        </th>
                                        <th scope="col">
                                            Pdf
                                        </th>
                                        <th scope="col">
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg-stone-100 text-center">
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                                Solicitud
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="23"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="24"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="25"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="26"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            {{-- Final Tabla Solicitud --}}

                            {{-- Inicio Tabla Retirados --}}
                            <table class="table-fixed border w-full">
                                <thead class="bg-slate-200 static top-0 border border-neutral-950 ">
                                    <tr class="px-1 py-1 text-center text-sm font-bold text-gray-900 ">
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                            Lista
                                        </th>
                                        <th scope="col">
                                            Crear
                                        </th>
                                        <th scope="col">
                                            Ver
                                        </th>
                                        <th scope="col">
                                            Pdf
                                        </th>
                                        <th scope="col">
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg-stone-100 text-center">
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                                Retirados
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="31"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="32"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="33"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="34"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            {{-- Final Tabla Solicitud --}}

                            {{-- Inicio Tabla Transferencias Enviadas --}}
                            <table class="table-fixed border w-full">
                                <thead class="bg-slate-200 static top-0 border border-neutral-950 ">
                                    <tr class="px-1 py-1 text-center text-sm font-bold text-gray-900 ">
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                            Lista
                                        </th>
                                        <th scope="col">
                                            Crear
                                        </th>
                                        <th scope="col">
                                            Ver
                                        </th>
                                        <th scope="col">
                                            Pdf
                                        </th>
                                        <th scope="col">
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg-stone-100 text-center">
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                                Transf. Enviadas
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="35"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="36"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="37"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="38"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            {{-- Final Tabla Transferencias Enviadas --}}

                            {{-- Inicio Tabla Transferencias Recibidas --}}
                            <table class="table-fixed border w-full">
                                <thead class="bg-slate-200 static top-0 border border-neutral-950 ">
                                    <tr class="px-1 py-1 text-center text-sm font-bold text-gray-900 ">
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                            Lista
                                        </th>
                                        <th scope="col">
                                            Ver
                                        </th>
                                        <th scope="col">
                                            Editar
                                        </th>
                                        <th scope="col">
                                            Pdf
                                        </th>
                                        <th scope="col">
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg-stone-100 text-center">
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                                Transf. Recibidas
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="39"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="40"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="41"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="42"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            {{-- Final Tabla Transferencias Enviadas --}}

                            {{-- Inicio Tabla Movimientos --}}
                            <table class="table-fixed border w-full">
                                <thead class="bg-slate-200 static top-0 border border-neutral-950 ">
                                    <tr class="px-1 py-1 text-center text-sm font-bold text-gray-900 ">
                                        <th scope="col">
                                        </th>
                                        <th scope="col">
                                            Lista
                                        </th>
                                        <th scope="col">
                                            Crear
                                        </th>
                                        <th scope="col">
                                            Editar
                                        </th>
                                        <th scope="col">
                                            Ver
                                        </th>
                                        <th scope="col">
                                            Pdf
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg-stone-100 text-center">
                                        <td class="px-1 py-1">
                                            <div class="text-sm text-left text-gray-900 ">
                                                Movimientos
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="43"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="44"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="45"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="46"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                        <td class="px-1 py-1">
                                            <div class="text-sm">
                                                <input checked type="checkbox" value="47"
                                                    wire:model="rolForm.edit_selectedPermission"
                                                    class="w-4 h-4  text-blue-600 bg-gray-200 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <x-input-error for="rolForm.edit_selectedPermission" />
                            <div class="text-right pt-4">
                                <x-danger-button wire:click="$set('openUpdate',false)" class="mr-2">
                                    <i class="fa-solid fa-xmark fa-lg"></i>&nbsp;Cancelar
                                </x-danger-button>

                                <x-secondary-button type="submit" wire:loading.attr="disabled" wire:target="update"
                                    class="disabled:opacity-55">
                                    <i class="fa-solid fa-floppy-disk fa-lg"></i>&nbsp; Actualizar
                                </x-secondary-button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- Fin - Editar Lista de Permisos --}}

    {{-- Inicio -  Alerta de confirmar de eliminar --}}
    @push('js')
        <script>
            Livewire.on('deleteRole', roleId => {
                Swal.fire({
                    title: "Estas seguro de eliminar?",
                    text: "No podrás revertir esto!",
                    icon: "warning",
                    cancelButtonText: 'Cancelar',
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, eliminar!"

                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.dispatchTo('roles.show-roles', 'destroy', [roleId]);

                        Swal.fire({
                            title: "Eliminado!",
                            text: "A sido eliminado con exito.",
                            icon: "success"
                        });
                    }
                });
            });
        </script>
    @endpush
    {{-- Fin -  Alerta de confirmar de eliminar --}}
</div>
