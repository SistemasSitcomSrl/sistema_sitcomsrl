<div>
    <div>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Proyectos') }}
            </h2>
        </x-slot>

        {{-- Inicio - Lista de proyecto --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <h2 class="py-1 text-lg font-bold leading-tight tracking-tight text-dark-900 md:text-2xl dark:text-dark">
                Lista de Proyectos
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

                    <x-input class="flex-1 mx-2" placeholder="Buscador Nombre de Proyecto" type="text"
                        wire:model.live="search" />
                    @can('admin.project.create')
                        <x-secondary-button wire:click="save">
                            <i class="fa-solid fa-plus"></i> &nbsp;Crear Proyecto
                        </x-secondary-button>
                    @endcan
                </div>

                @if ($projects->count())
                    <table class="table-fixed min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 static top-0">
                            <tr>
                                <th scope="col"
                                    class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    wire:click="order('id')">

                                    @if ($sort == 'id')
                                        @if ($direction == 'asc')
                                            <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Nro
                                        @else
                                            <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Nro
                                        @endif
                                    @else
                                        <i class= "fas fa-sort ">&nbsp;</i>Nro
                                    @endif

                                </th>
                                <th scope="col"
                                    class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    wire:click="order('object')">

                                    @if ($sort == 'object')
                                        @if ($direction == 'asc')
                                            <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Nombre del proyecto
                                        @else
                                            <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Nombre del proyecto
                                        @endif
                                    @else
                                        <i class= "fas fa-sort ">&nbsp;</i>Nombre del proyecto
                                    @endif

                                </th>
                                <th scope="col"
                                    class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    wire:click="order('entity')">

                                    @if ($sort == 'entity')
                                        @if ($direction == 'asc')
                                            <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Entidad
                                        @else
                                            <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Entidad
                                        @endif
                                    @else
                                        <i class= "fas fa-sort ">&nbsp;</i>Entidad
                                    @endif
                                </th>
                                <th scope="col"
                                    class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    wire:click="order('name_user')">

                                    @if ($sort == 'name_user')
                                        @if ($direction == 'asc')
                                            <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Gestor Proyecto
                                        @else
                                            <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Gestor Proyecto
                                        @endif
                                    @else
                                        <i class= "fas fa-sort ">&nbsp;</i>Gestor Proyecto
                                    @endif
                                </th>
                                <th scope="col"
                                    class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    wire:click="order('cuce')">

                                    @if ($sort == 'cuce')
                                        @if ($direction == 'asc')
                                            <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Cuce
                                        @else
                                            <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Cuce
                                        @endif
                                    @else
                                        <i class= "fas fa-sort ">&nbsp;</i>Cuce
                                    @endif
                                </th>
                                <th scope="col"
                                    class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    wire:click="order('ubi_projects')">

                                    @if ($sort == 'ubi_projects')
                                        @if ($direction == 'asc')
                                            <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Ciudad de Trabajo
                                        @else
                                            <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Ciudad de Trabajo
                                        @endif
                                    @else
                                        <i class= "fas fa-sort ">&nbsp;</i>Ciudad de Trabajo
                                    @endif
                                </th>
                                <th scope="col"
                                    class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    wire:click="order('state')">

                                    @if ($sort == 'state')
                                        @if ($direction == 'asc')
                                            <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Estado
                                        @else
                                            <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Estado
                                        @endif
                                    @else
                                        <i class= "fas fa-sort ">&nbsp;</i>Estado
                                    @endif
                                </th>

                                @php
                                    $can = Gate::allows('admin.project.edit') || Gate::allows('admin.project.state');
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
                            @foreach ($projects as $project)
                                <tr wire:key="project-{{ $project->id }}">
                                    <td class="px-1 py-1 text-center">
                                        <div class="text-sm text-gray-900">
                                            {{ $project->id }}
                                        </div>
                                    </td>
                                    <td class="px-1 py-1">
                                        <div class="text-sm text-gray-900">
                                            {{ $project->object }}
                                        </div>
                                    </td>
                                    <td class="px-1 py-1">
                                        <div class="text-sm text-gray-900">
                                            {{ $project->entity }}
                                        </div>
                                    </td>
                                    <td class="px-1 py-1">
                                        <div class="text-sm text-gray-900">
                                            {{ $project->name_user }}
                                        </div>
                                    </td>
                                    <td class="px-1 py-1">
                                        <div class="text-sm text-gray-900">
                                            {{ $project->cuce }}
                                        </div>
                                    </td>
                                    <td class="px-1 py-1">
                                        <div class="text-sm text-gray-900">
                                            {{ $project->ubi_projects }}
                                        </div>
                                    </td>
                                    @if ($project->state)
                                        <td class="px-1 text-center"
                                            style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                            <span
                                                class="inline-flex items-center bg-green-100 text-green-900 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-300 dark:text-green-900">
                                                <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                                Habilitado
                                            </span>
                                        </td>
                                    @else
                                        <td class="px-1 text-center"
                                            style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                            <span
                                                class="inline-flex items-center bg-red-100 text-red-500 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-500 dark:text-white">
                                                <span class="w-2 h-2 me-1 bg-red-600 rounded-full"></span>
                                                Inhabilitado
                                            </span>
                                        </td>
                                    @endif

                                    <td class="py-1 flex text-left text-sm font-medium">
                                        @can('admin.project.edit')
                                            <div class="px-0.5 pt-0.5">
                                                <button wire:click="edit({{ $project->id }})"
                                                    class= "inline-flex items-center px-3 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-offset-2 transition ease-in-out duration-150">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                            </div>
                                        @endcan
                                        @can('admin.project.state')
                                            <div class="px-0.5 pt-0.5">
                                                <button wire:click="$dispatch('stateProject',{{ $project->id }})"
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

                @if ($projects->hasPages(2))
                    <div class="px-6 py-3">
                        {{ $projects->links() }}
                    </div>
                @endif
            </x-table>
        </div>
        {{-- Fin - Lista de Proyecto --}}


    </div>

    {{-- Inicio - Modal Crear Proyecto --}}
    @if ($openCreate)
        <div class="bg-gray-800 bg-opacity-25 fixed inset-0 ">
            <div class="pt-6">
                <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 lg:py-16">
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex">
                            <p class="font-bold text-base align-middle m-0  ">
                                Crear Proyecto
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
                        <form class="space-y-4 md:space-y-6" wire:submit.prevent="create">
                            <div class="grid grid-cols-3 gap-4 my-2">
                                <div>
                                    <x-label class="my-2" value="Nombre de la Entidad: *" />
                                    <x-input wire:model="create_entity" placeholder="Ingrese Nombre Entidad" type="text" class="w-full" />
                                    <x-input-error for="create_entity" />
                                </div>
                                <div>
                                    <x-label class="my-2" value="Cuce: *" />
                                    <x-input wire:model="create_cuce" placeholder="Ingrese Cuce" type="text" class="w-full" />
                                    <x-input-error for="create_cuce" />
                                </div>
                                <div>
                                    <x-label class="my-2" value="Descripción: *" />
                                    <x-input wire:model="create_object" placeholder="Ingrese Descripción" type="text" class="w-full" />
                                    <x-input-error for="create_object" />
                                </div>

                            </div>
                            <div class="grid grid-cols-3 gap-4 my-2">
                                <div>
                                    <x-label class="my-2" value="Ciudad Entrega: *" />
                                    <select wire:model.live="create_selectedDepartment"
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
                                    <x-input-error for="create_selectedDepartment" />
                                </div>
                                <div>
                                    <x-label class="my-2" value="Ciudad Trabajo: *" />
                                    <x-input wire:model="create_ubi_entity" placeholder="Ingrese Ciudad de Trabajo" type="text" class="w-full" />
                                    <x-input-error for="create_ubi_entity" />
                                </div>
                                <div>
                                    <x-label class="my-2" value="Gestor de Proyecto: *" />
                                    <select wire:model="selectUser"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="" disabled selected>Seleccione un Encargado</option>
                                        @foreach ($users as $user)
                                            <option wire:key="selectUser-{{ $user->id }}"
                                                value="{{ $user->id }}">{{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="selectUser" />
                                </div>
                            </div>

                            <div class="grid grid-cols-4 gap-4 my-2">
                                <div>
                                    <x-label class="my-2" value="Fecha Apertura: *" />
                                    <x-input wire:model="create_date_opening" type="date" class="w-full" />
                                    <x-input-error for="create_date_opening" />
                                </div>
                                <div>
                                    <x-label class="my-2" value="Fecha Abjudicación: *" />
                                    <x-input wire:model="create_date_notification" type="date" class="w-full" />
                                    <x-input-error for="create_date_notification" />
                                </div>
                                <div>
                                    <x-label class="my-2" value="Precio Referencial: *" />
                                    <x-input wire:model="create_reference_price" placeholder="Ingrese Precio" type="number" class="w-full" />
                                    <x-input-error for="create_reference_price" />
                                </div>
                                <div>
                                    <x-label class="my-2" value="Tipo Licitación: *" />
                                    <x-input wire:model="create_type" placeholder="Ingrese Tipo Licitación" type="text" class="w-full" />
                                    <x-input-error for="create_type" />
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
    {{-- Fin - Modal Crear Proyecto --}}

    {{-- Inicio - Modal Editar Proyecto --}}
    @if ($openUpdate)
        <div class="bg-gray-800 bg-opacity-25 fixed inset-0 ">
            <div class="pt-6">
                <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 lg:py-16">
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex">
                            <p class="font-bold text-base align-middle m-0  ">
                                Editar Proyecto
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
                        <form class="space-y-4 md:space-y-6" wire:submit.prevent="update({{ $tool_id }})">
                            <div class="grid grid-cols-3 gap-4 my-2">
                                <div>
                                    <x-label class="my-2" value="Nombre de la Entidad:" />
                                    <x-input wire:model="toolForm.edit_entity" placeholder="Ingrese Nombre Entidad" type="text" class="w-full" />
                                    <x-input-error for="toolForm.edit_entity" />
                                </div>
                                <div>
                                    <x-label class="my-2" value="Cuce:" />
                                    <x-input wire:model="toolForm.edit_cuce" placeholder="Ingrese Cuce" type="text" class="w-full" />
                                    <x-input-error for="toolForm.edit_cuce" />
                                </div>
                                <div>
                                    <x-label class="my-2" value="Descripción:" />
                                    <x-input wire:model="toolForm.edit_object" placeholder="Ingrese Descripción" type="text" class="w-full" />
                                    <x-input-error for="toolForm.edit_object" />
                                </div>

                            </div>
                            <div class="grid grid-cols-3 gap-4 my-2">
                                <div>
                                    <x-label class="my-2" value="Ciudad Entrega:" />
                                    <select wire:model.live="toolForm.edit_selectedDepartment"
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
                                    <x-input-error for="toolForm.edit_selectedDepartment" />
                                </div>
                                <div>
                                    <x-label class="my-2" value="Ciudad Trabajo:" />
                                    <x-input wire:model="toolForm.edit_ubi_entity" placeholder="Ingrese Ciudad de Trabajo" type="text" class="w-full" />
                                    <x-input-error for="toolForm.edit_ubi_entity" />
                                </div>
                                <div>
                                    <x-label class="my-2" value="Gestor de Proyecto:" />
                                    <select wire:model="toolForm.edit_selectUser"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="" disabled selected>Seleccione un Encargado</option>
                                        @foreach ($users as $user)
                                            <option wire:key="toolForm.edit_selectUser-{{ $user->id }}"
                                                value="{{ $user->id }}">{{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="toolForm.edit_selectUser" />
                                </div>
                            </div>

                            <div class="grid grid-cols-4 gap-4 my-2">
                                <div>
                                    <x-label class="my-2" value="Fecha Apertura:" />
                                    <x-input wire:model="toolForm.edit_date_opening" type="date" class="w-full" />
                                    <x-input-error for="toolForm.edit_date_opening" />
                                </div>
                                <div>
                                    <x-label class="my-2" value="Fecha Abjudicación:" />
                                    <x-input wire:model="toolForm.edit_date_notification" type="date"
                                        class="w-full" />
                                    <x-input-error for="toolForm.edit_date_notification" />
                                </div>
                                <div>
                                    <x-label class="my-2" value="Precio Referencial:" />
                                    <x-input wire:model="toolForm.edit_reference_price" placeholder="Ingrese Precio" type="number"
                                        class="w-full" />
                                    <x-input-error for="toolForm.edit_reference_price" />
                                </div>
                                <div>
                                    <x-label class="my-2" value="Tipo Licitación:" />
                                    <x-input wire:model="toolForm.edit_type" placeholder="Ingrese Tipo Licitación" type="text" class="w-full" />
                                    <x-input-error for="toolForm.edit_type" />
                                </div>
                            </div>
                            <div class="text-right ">
                                <x-danger-button wire:click="$set('openUpdate',false)" class="mr-2">
                                    <i class="fa-solid fa-xmark fa-lg"></i>&nbsp;Cancelar
                                </x-danger-button>
                                <x-secondary-button type="submit" wire:loading.attr="disabled" wire:target="save"
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
    {{-- Fin - Modal Editar Proyecto --}}

    {{-- Inicio -  Alerta de confirmar de eliminar --}}
    @push('js')
        <script>
            Livewire.on('stateProject', project_id => {
                Swal.fire({
                    title: "Estas seguro de cambiar de estado?",
                    text: "No podrás revertir esto!",
                    icon: "warning",
                    cancelButtonText: 'Cancelar',
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, Cambiar!"

                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.dispatchTo('proyectos.show-projects', 'projectState', [project_id]);

                        Swal.fire({
                            title: "Operacion Exitosa!",
                            text: "A sido cambiado de estado con exito.",
                            icon: "success"
                        });
                    }
                });
            });
        </script>
    @endpush
    {{-- Fin -  Alerta de confirmar de eliminar --}}

</div>
