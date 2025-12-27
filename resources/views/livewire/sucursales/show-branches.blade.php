<div>
    {{-- Inicio - Lista de Sucursales --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <h2 class="py-1 text-lg font-bold leading-tight tracking-tight text-dark-900 md:text-2xl dark:text-dark">
            Lista de Sucursales
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

                <x-input class="flex-1 mx-2" placeholder="Buscador Nombre de Sucursal" type="text"
                    wire:model.live="search" />
                @can('admin.branch.create')
                    <x-secondary-button wire:click="openCreateModal">
                        <i class="fa-solid fa-plus"></i> &nbsp;Crear Sucursal
                    </x-secondary-button>
                @endcan
            </div>

            @if ($branches->count())
                <table class="table-fixed min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 sticky top-0">
                        <tr>
                            <th scope="col"
                                class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
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
                                class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('name')">

                                @if ($sort == 'name')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Nombre Sucursal
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Nombre Sucursal
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Nombre Sucursal
                                @endif

                            </th>
                            <th scope="col"
                                class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('department')">

                                @if ($sort == 'department')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Departamento
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Departamento
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Departamento
                                @endif

                            </th>
                            <th scope="col"
                                class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('direction')">

                                @if ($sort == 'direction')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-arrow-down-1-9">&nbsp;</i>Direccion
                                    @else
                                        <i class="fas fa-arrow-up-9-1">&nbsp;</i>Direccion
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Direccion
                                @endif
                            </th>
                            <th scope="col"
                                class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('number_phone')">

                                @if ($sort == 'number_phone')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Nro. Telefono
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Nro. Telefono
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Nro. Telefono
                                @endif
                            </th>
                            <th scope="col"
                                class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('name_user')">

                                @if ($sort == 'name_user')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Encargado
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Encargado
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Encargado
                                @endif
                            </th>
                            <th scope="col"
                                class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('rol')">

                                @if ($sort == 'rol')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Rol
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Rol
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Rol
                                @endif
                            </th>
                            @php
                                $can = Gate::allows('admin.branch.edit') || Gate::allows('admin.branch.state');
                            @endphp

                            @if ($can)
                                <th scope="col"
                                    class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Opciones
                                </th>
                            @endif
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($branches as $branch)
                            <tr wire:key="branch-{{ $branch->id }}">
                                <td class="px-1 py-2 text-center">
                                    <div class="text-sm text-gray-900">
                                        {{ $branch->id }}
                                    </div>
                                </td>
                                <td class="px-1 py-2 text-left">
                                    <div class="text-sm text-gray-900">
                                        {{ $branch->name }}
                                    </div>
                                </td>
                                <td class="px-1 py-2 text-left">
                                    <div class="text-sm text-gray-900">
                                        {{ $branch->department }}
                                    </div>
                                </td>
                                <td class="px-1 py-2 text-left">
                                    <div class="text-sm text-gray-900">
                                        {{ $branch->direction }}
                                    </div>
                                </td>
                                <td class="px-1 py-2 text-center">
                                    <div class="text-sm text-gray-900">
                                        {{ $branch->number_phone }}
                                    </div>
                                </td>
                                <td class="px-1 py-2 text-left">
                                    <div class="text-sm text-gray-900">
                                        {{ $branch->name_user }}
                                    </div>
                                </td>
                                <td class="px-1 py-2 text-left">
                                    <div class="text-sm text-gray-900">
                                        {{ $branch->rol }}
                                    </div>
                                </td>
                                <td class="flex px-1 py-2  ">
                                    @can('admin.branch.edit')
                                        <div class="pt-0.5 pr-1">
                                            <button wire:click="edit({{ $branch->id }})"
                                                class= "inline-flex items-center px-3 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-offset-2 transition ease-in-out duration-150">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        </div>
                                    @endcan
                                    @can('admin.branch.state')
                                        <div class="pt-0.5">
                                            <button wire:click="rotate({{ $branch->id }})"
                                                class= "inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:bg-green-600 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 transition ease-in-out duration-150">
                                                <i class="fa-solid fa-rotate"></i>
                                            </button>
                                        </div>
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

            @if ($branches->hasPages(2))
                <div class="px-6 py-3">
                    {{ $branches->links() }}
                </div>
            @endif
        </x-table>
    </div>
    {{-- Fin - Lista de Sucursales --}}

    {{-- Inicio - Modal Crear Sucursal --}}
    @if ($openCreate)
        <div class="bg-gray-800 bg-opacity-25 fixed inset-0 ">
            <div class="pt-6">
                <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 lg:py-16">
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex">
                            <p class="font-bold text-base align-middle m-0  ">
                                Crear Sucursal
                            </p>
                            <button type="button" wire:click="$set('openCreate',false)"
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
                        <form class="space-y-4 md:space-y-6" wire:submit.prevent="save">
                            <div class="grid grid-cols-1 gap-4 my-2">
                                <div>

                                    <x-label value="Nombre de Sucursal: *" />
                                    <x-input wire:model="create_branch"
                                        placeholder="Ingrese Nombre de Sucursal" type="text"
                                        class="w-full" />
                                    <x-input-error for="create_branch" />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 my-2">
                                <div>
                                    <x-label value="Departamento: *" />
                                    <select wire:model="selectedDepartment"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="" disabled selected>Seleccione un Departamento</option>
                                        <option value="Santa Cruz">Santa Cruz
                                        </option>
                                        <option value="Pando">Pando
                                        </option>
                                        <option value="Beni">Beni
                                        </option>
                                        <option value="Tarija">Tarija
                                        </option>
                                        <option value="Potosí">Potosí
                                        </option>
                                        <option value="Oruro">Oruro
                                        </option>
                                        <option value="Cochabamba">Cochabamba
                                        </option>
                                        <option value="La Paz">La Paz
                                        </option>
                                        <option value="Chuquisaca">Chuquisaca
                                        </option>
                                    </select>
                                    <x-input-error for="selectedDepartment" />
                                </div>
                                <div>
                                    <div>
                                        <x-label value="Nombre Encargado:" />
                                        <select wire:model="selectedUser"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option value="" disabled selected>Seleccione un Encargado</option>
                                            @foreach ($users as $user)
                                                <option wire:key="selectUser-{{ $user->id }}"
                                                    value="{{ $user->id }}">{{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error for="selectedUser" />
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 my-2">
                                <div>
                                    <x-label value="Dirección: *" />
                                    <x-input wire:model="create_direction" placeholder="Ingrese Dirección" type="text" class="w-full" />
                                    <x-input-error for="create_direction" />
                                </div>
                                <div>
                                    <x-label value="Numero de Telefono: *" />
                                    <x-input wire:model="create_number_phone" placeholder="Ej: 75617798" type="text" class="w-full" />
                                    <x-input-error for="create_number_phone" />
                                </div>
                            </div>

                            <div class="text-right ">
                                <x-danger-button wire:click="$set('openCreate',false)" class="mr-2">
                                    <i class="fa-solid fa-xmark fa-lg"></i>&nbsp;Cancelar
                                </x-danger-button>
                                <x-secondary-button type="submit" wire:loading.attr="disabled" wire:target="save"
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
    {{-- Fin - Modal Crear Sucursal --}}

    {{-- Inicio - Modal Actualizar Herramienta --}}
    @if ($openEdit)
        <div class="bg-gray-800 bg-opacity-25 fixed inset-0 ">
            <div class="pt-6">
                <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 lg:py-16">
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex">
                            <p class="font-bold text-base align-middle m-0  ">
                                Editar Sucursal
                            </p>
                            <button type="button" wire:click="$set('openEdit',false)"
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
                        <form class="space-y-4 md:space-y-6" wire:submit.prevent="udpate">

                            <div class="grid grid-cols-2 gap-4 my-2">
                                <div>

                                    <x-label value="Nombre de Sucursal: *" />
                                    <x-input wire:model.live="postForm.edit_branch" placeholder="Ingrese Nombre de Sucursal" type="text" class="w-full" />
                                    <x-input-error for="postForm.edit_branch" />
                                </div>
                                <div>

                                    <x-label value="Departamento:" />
                                    <select wire:model.live="postForm.edit_selectedDepartment"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="" disabled selected>Seleccione un Departamento</option>

                                        <option value="Santa Cruz">Santa Cruz
                                        </option>
                                        <option value="Pando">Pando
                                        </option>
                                        <option value="Beni">Beni
                                        </option>
                                        <option value="Tarija">Tarija
                                        </option>
                                        <option value="Potosí">Potosí
                                        </option>
                                        <option value="Oruro">Oruro
                                        </option>
                                        <option value="Cochabamba">Cochabamba
                                        </option>
                                        <option value="La Paz">La Paz
                                        </option>
                                        <option value="Chuquisaca">Chuquisaca
                                        </option>
                                    </select>
                                    <x-input-error for="postForm.edit_selectedDepartment" />
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 my-2">
                                <div>
                                    <x-label value="Direccion:" />
                                    <x-input wire:model.live="postForm.edit_direction" placeholder="Ingrese Dirección" type="text"
                                        class="w-full" />
                                    <x-input-error for="postForm.edit_direction" />
                                </div>
                                <div>
                                    <x-label value="Numero de Telefono:" />
                                    <x-input wire:model.live="postForm.edit_number_phone" placeholder="Ej: 75617798" type="text"
                                        class="w-full" />
                                    <x-input-error for="postForm.edit_number_phone" />
                                </div>
                            </div>

                            <div class="text-right ">
                                <x-danger-button wire:click="$set('openEdit',false)" class="mr-2">
                                    <i class="fa-solid fa-xmark fa-lg"></i>&nbsp;Cancelar
                                </x-danger-button>
                                <x-secondary-button type="submit" wire:loading.attr="disabled" wire:target="save"
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
    {{-- Fin - Modal Actualizar Herramienta --}}

    {{-- Inicio Modal Seleciona Nuevo Encargado --}}
    @if ($openRotate)
        <div class="bg-gray-800 bg-opacity-25 fixed inset-0 ">
            <div class="pt-6">
                <div class="max-w-xl mx-auto sm:px-6 lg:px-8 lg:py-16">
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex">
                            <p class="font-bold text-base align-middle m-0  ">
                                {{ $nameBranch->name }}
                            </p>
                            <button type="button" wire:click="$set('openRotate',false)"
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
                        <form class="space-y-4 md:space-y-6" wire:submit.prevent="submitForm({{ $nameBranch->id }})">
                            <div>
                                <x-label value="Nombre Encargado:" />
                                <select wire:model.live="selectedInput"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500">

                                    <option value="" disabled selected>Seleccione un Encargado</option>

                                    @foreach ($users as $user)
                                        <option wire:key="selectedInput-{{ $user->id }}"
                                            value="{{ $user->id }}">{{ $user->name }} -
                                            {{ $user->company_position }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error for="selectedInput" />
                            </div>
                            <div class="text-right ">
                                <x-danger-button wire:click="$set('openRotate',false)" class="mr-2">
                                    <i class="fa-solid fa-xmark fa-lg"></i>&nbsp; Cancelar
                                </x-danger-button>
                                <x-secondary-button type="submit">
                                    <i class="fa-solid fa-floppy-disk fa-lg"></i>&nbsp; Actualizar
                                </x-secondary-button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- Fin Modal Seleciona Nuevo Encargado --}}
</div>
