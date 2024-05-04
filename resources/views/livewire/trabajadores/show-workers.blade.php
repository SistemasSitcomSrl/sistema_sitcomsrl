<div>
    {{-- Inicio - Lista de Trabajadores --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <h2 class="py-1 text-lg font-bold leading-tight tracking-tight text-dark-900 md:text-2xl dark:text-dark">
            Lista de Trabajadores
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

                <x-input class="flex-1 mx-2" placeholder="Buscador Nombre de Personal" type="text"
                    wire:model.live="search" />
                @can('admin.workers.create')
                    <x-secondary-button wire:click="openCreateModal">
                        <i class="fa-solid fa-plus"></i> &nbsp;Crear Personal
                    </x-secondary-button>
                @endcan
            </div>

            @if ($users->count())
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
                                class="px-1 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('ci')">

                                @if ($sort == 'ci')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Carnet
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Carnet
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Carnet
                                @endif

                            </th>
                            <th scope="col"
                                class="px-1 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('name')">

                                @if ($sort == 'name')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Nombres
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Nombres
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Nombres
                                @endif

                            </th>
                            <th scope="col"
                                class="px-1 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('last_name')">

                                @if ($sort == 'last_name')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-arrow-down-1-9">&nbsp;</i>apellido
                                    @else
                                        <i class="fas fa-arrow-up-9-1">&nbsp;</i>apellido
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>apellido
                                @endif
                            </th>
                            <th scope="col"
                                class="px-1 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('phone_number')">

                                @if ($sort == 'phone_number')
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
                                class="px-1 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('ubication')">

                                @if ($sort == 'ubication')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Ubicación
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Ubicación
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Ubicación
                                @endif
                            </th>
                            <th scope="col"
                                class="px-1 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('company_position')">

                                @if ($sort == 'company_position')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Cargo Empresa
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Cargo Empresa
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Cargo Empresa
                                @endif
                            </th>
                            @php
                                $can = Gate::allows('admin.workers.edit') || Gate::allows('admin.workers.state');
                            @endphp

                            @if ($can)
                                <th scope="col"
                                    class="px-1 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Opcion
                                </th>
                            @endif
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($users as $user)
                            <tr wire:key="user-{{ $user->id }}">
                                <td class="px-1 py-2">
                                    <div class="text-sm text-center text-gray-900">
                                        {{ $user->id }}
                                    </div>
                                </td>
                                <td class="px-1 py-2">
                                    <div class="text-sm text-gray-900">
                                        {{ $user->ci }}
                                    </div>
                                </td>
                                <td class="px-1 py-2">
                                    <div class="text-sm text-gray-900">
                                        {{ $user->name }}
                                    </div>
                                </td>
                                <td class="px-1 py-2">
                                    <div class="text-sm text-gray-900">
                                        {{ $user->last_name }}
                                    </div>
                                </td>
                                <td class="px-1 py-2">
                                    <div class="text-sm text-gray-900">
                                        {{ $user->phone_number }}
                                    </div>
                                </td>
                                <td class="px-1 py-2">
                                    <div class="text-sm text-gray-900">
                                        {{ $user->ubication }}
                                    </div>
                                </td>
                                <td class="px-1 py-2">
                                    <div class="text-sm text-gray-900">
                                        {{ $user->company_position }}
                                    </div>
                                </td>
                                <td class="text-center px-1 py-2  ">
                                    @can('admin.workers.edit')
                                        <div class="pt-0.5 pr-1 ">
                                            <button wire:click="edit({{ $user->id }})"
                                                class= "inline-flex px-3 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-offset-2 transition ease-in-out duration-150">
                                                <i class="fa-solid fa-pen-to-square"></i>
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

            @if ($users->hasPages(2))
                <div class="px-6 py-3">
                    {{ $users->links() }}
                </div>
            @endif
        </x-table>
    </div>
    {{-- Fin - Lista de Trabajadores --}}

    {{-- Inicio - Modal Crear Personal --}}
    @if ($openCreate)
        <div class="bg-gray-800 bg-opacity-25 fixed inset-0 flex items-center justify-center"
            wire:click="$set('openCreate',false)">
            <div class="m-auto w-1/2" wire:click.stop>
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex">
                        <p class="font-bold text-base align-middle m-0  ">
                            Crear Personal
                        </p>
                        <button type="button" wire:click="$set('openCreate',false)"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-red-500 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center  dark:hover:bg-gray-400 dark:hover:text-red"
                            data-modal-hide="static-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <form class="space-y-4 md:space-y-6" wire:submit.prevent="save">
                        <div class="grid grid-cols-2 gap-4 my-2">
                            <div>
                                <x-label value="Nombre: *" />
                                <x-input wire:model="name" placeholder="Ingrese Nombre del Personal" type="text"
                                    class="w-full" />
                                <x-input-error for="name" />
                            </div>
                            <div>

                                <x-label value="Apellido: *" />
                                <x-input wire:model="last_name" placeholder="Ingrese Apellido del Personal"
                                    type="text" class="w-full" />
                                <x-input-error for="last_name" />
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
                                <x-label value="Carnet de Identidad: *" />
                                <x-input wire:model="ci" placeholder="Ingrese Carnet de Identidad" type="text"
                                    class="w-full" />
                                <x-input-error for="ci" />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 my-2">
                            <div>
                                <x-label value="Cargo de la Empresa: *" />
                                <x-input wire:model="company_position" placeholder="Ingrese Cargo" type="text"
                                    class="w-full" />
                                <x-input-error for="company_position" />
                            </div>
                            <div>
                                <x-label value="Numero de Celular: *" />
                                <x-input wire:model="phone_number" placeholder="Ej: 75617798" type="text"
                                    class="w-full" />
                                <x-input-error for="phone_number" />
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
    @endif
    {{-- Fin - Modal Crear Personal --}}

    {{-- Inicio - Modal Actualizar Personal --}}
    @if ($openUpdate)
        <div class="bg-gray-800 bg-opacity-25 fixed inset-0 flex items-center justify-center"
            wire:click="$set('openUpdate',false)">
            <div class="m-auto w-1/2" wire:click.stop>
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex">
                        <p class="font-bold text-base align-middle m-0  ">
                            Editar Personal
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
                    <form class="space-y-4 md:space-y-6" wire:submit.prevent="udpate({{ $workersEditId }})">

                        <div class="grid grid-cols-2 gap-4 my-2">
                            <div>
                                <x-label value="Nombre: *" />
                                <x-input wire:model="postForm.name" placeholder="Ingrese Nombre del Personal"
                                    type="text" class="w-full" />
                                <x-input-error for="postForm.name" />
                            </div>
                            <div>

                                <x-label value="Apellido: *" />
                                <x-input wire:model="postForm.last_name" placeholder="Ingrese Apellido del Personal"
                                    type="text" class="w-full" />
                                <x-input-error for="postForm.last_name" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 my-2">
                            <div>
                                <x-label value="Departamento: *" />
                                <select wire:model="postForm.selectedDepartment"
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
                                <x-input-error for="postForm.selectedDepartment" />
                            </div>
                            <div>
                                <x-label value="Carnet de Identidad: *" />
                                <x-input wire:model="postForm.ci" placeholder="Ingrese Carnet de Identidad"
                                    type="text" class="w-full" />
                                <x-input-error for="postForm.ci" />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 my-2">
                            <div>
                                <x-label value="Cargo de la Empresa: *" />
                                <x-input wire:model="postForm.company_position" placeholder="Ingrese Cargo"
                                    type="text" class="w-full" />
                                <x-input-error for="postForm.company_position" />
                            </div>
                            <div>
                                <x-label value="Numero de Celular: *" />
                                <x-input wire:model="postForm.phone_number" placeholder="Ej: 75617798" type="text"
                                    class="w-full" />
                                <x-input-error for="postForm.phone_number" />
                            </div>
                        </div>

                        <div class="text-right ">
                            <x-danger-button wire:click="$set('openUpdate',false)" class="mr-2">
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
    @endif
    {{-- Fin - Modal Actualizar Personal --}}
</div>
