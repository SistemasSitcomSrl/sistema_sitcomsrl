<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuario') }}
        </h2>
    </x-slot>

    {{-- Inicio - Lista de usuarios --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <h2 class="py-1 text-lg font-bold leading-tight tracking-tight text-dark-900 md:text-2xl dark:text-dark">
            Lista de Usuarios
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

                <x-input class="flex-1 mx-2" placeholder="Buscador Nombre Usuario" type="text"
                    wire:model.live="search" />
                @can('admin.users.create')
                    @livewire('usuarios.create-users')
                @endcan
            </div>

            @if ($users->count())
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
                                class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('ci')">

                                @if ($sort == 'ci')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Nro Carnet
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Nro Carnet
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Nro Carnet
                                @endif

                            </th>
                            <th scope="col"
                                class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('email')">

                                @if ($sort == 'email')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Correo electronico
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Correo electronico
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Correo electronico
                                @endif
                            </th>
                            <th scope="col"
                                class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
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
                            <th scope="col"
                                class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('phone_number')">

                                @if ($sort == 'phone_number')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Celular
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Celular
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Celular
                                @endif
                            </th>
                            <th scope="col"
                                class="px-1 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
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
                                $can =
                                    Gate::allows('admin.users.edit') ||
                                    Gate::allows('admin.users.rol') ||
                                    Gate::allows('admin.users.state');
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
                        @foreach ($users as $user)
                            <tr wire:key="user-{{ $user->id }}">
                                <td class="px-1 py-1 text-center">
                                    <div class="text-sm text-gray-900">
                                        {{ $user->id }}
                                    </div>
                                </td>
                                <td class="px-1 py-1">
                                    <div class="text-sm text-gray-900">
                                        {{ $user->name }}
                                    </div>
                                </td>
                                <td class="px-1 py-1">
                                    <div class="text-sm text-center text-gray-900">
                                        {{ $user->ci }}
                                    </div>
                                </td>
                                <td class="px-1 py-1">
                                    <div class="text-sm text-gray-900">
                                        {{ $user->email }}
                                    </div>
                                </td>
                                <td class="px-1 py-1">
                                    <div class="text-sm text-gray-900">
                                        {{ $user->company_position }}
                                    </div>
                                </td>
                                <td class="px-1 py-1">
                                    <div class="text-sm text-gray-900">
                                        {{ $user->phone_number }}
                                    </div>
                                </td>
                                @if ($user->state)
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
                                    @can('admin.users.edit')
                                        <div class="px-0.5 pt-0.5">
                                            <button wire:click="editar({{ $user->id }})"
                                                class= "inline-flex items-center px-3 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-offset-2 transition ease-in-out duration-150">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        </div>
                                    @endcan
                                    @can('admin.users.rol')
                                        <div class="px-0.5 pt-0.5">
                                            <button wire:click="rol({{ $user->id }})"
                                                class= "inline-flex items-center px-3 py-2 bg-green-600  border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-600 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2 transition ease-in-out duration-150">
                                                <i class="fa-solid fa-sitemap  "></i>
                                            </button>
                                        </div>
                                    @endcan
                                    @can('admin.users.state')
                                        <div class="px-0.5 pt-0.5">
                                            <button wire:click="$dispatch('deleteUser',{{ $user->id }})"
                                                class="inline-flex items-center justify-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                <i class="fa-solid fa-user-check"></i>
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
    {{-- Fin - Lista de Usuario --}}

    {{-- Inicio - Modal Actualizar Usuario --}}
    @if ($openUpdate)
        <div class="bg-gray-800 bg-opacity-25 fixed inset-0 ">
            <div class="pt-1">
                <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 lg:py-16">
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex">
                            <p class="font-bold text-base align-middle m-0  ">
                                Actualizar Usuario
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
                        <form class="space-y-4 md:space-y-6" wire:submit="update">
                            <div class="grid grid-cols-1 gap-4 mt-2">
                                <div>
                                    <x-label value="Nombre Completo: *" />
                                    <x-input wire:model="userEdit.name" type="text"
                                        placeholder="Ingrese Nombre Completo" class="w-full" />
                                    <x-input-error for="userEdit.name" />
                                </div>                                
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-2">
                                <div>
                                    <x-label value="Carnet de Identidad: *" />
                                    <x-input wire:model="userEdit.ci" type="text" class="w-full" disabled />
                                    <x-input-error for="userEdit.ci" />
                                </div>
                                <div>
                                    <x-label value="Correo Electronico: *" />
                                    <x-input wire:model="userEdit.email" type="email" class="w-full" disabled />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-2">
                                <div>
                                    <x-label value="Cargo Empresa: *" />
                                    <x-input wire:model="userEdit.company_position"
                                        placeholder="Ingrese Cargo Empresa" type="text" class="w-full" />
                                    <x-input-error for="userEdit.company_position" />
                                </div>
                                <div>
                                    <x-label value="Numero Celular: *" />
                                    <x-input wire:model="userEdit.phone_number" placeholder="Ej: 75617798"
                                        type="text" class="w-full" />
                                    <x-input-error for="userEdit.phone_number" />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-2">
                                <div class="items-center">
                                    <x-label value="Contraseña:" />
                                    <div class="input-group">
                                        <input wire:model="userEdit.password" ID="txtPassword" type="Password"
                                            placeholder="Ingrese Contraseña"
                                            Class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                            style=" width: 83%;">
                                        <div>
                                            <button id="show_password" class="btn btn-primary " type="button"
                                                onclick="mostrarPassword()"> <span
                                                    class="fa fa-eye-slash icon"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <x-input-error for="userEdit.password" />
                                </div>
                                <div class="items-center">
                                    <x-label value="Repetir Contraseña:" />
                                    <div class="input-group">
                                        <input wire:model="userEdit.passwordConfirmation" ID="txtPasswordConfirmation"
                                            type="Password" placeholder="Repetir Contraseña"
                                            Class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                            style=" width: 83%;">
                                        <div>
                                            <button id="show_password" class="btn btn-primary " type="button"
                                                onclick="mostrarPasswordConfirmation()"> <span
                                                    class="fa fa-eye-slash iconConfirmation"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <x-input-error for="userEdit.passwordConfirmation" />
                                </div>
                            </div>

                            <div class="text-right ">
                                <x-danger-button wire:click="$set('openUpdate',false)" class="mr-2">
                                    <i class="fa-solid fa-xmark fa-lg"></i>&nbsp;Cancelar
                                </x-danger-button>

                                <x-secondary-button wire:click="update" wire:loading.attr="disabled"
                                    wire:target="update" class="disabled:opacity-55">
                                    <i class="fa-solid fa-floppy-disk fa-lg"></i>&nbsp;Actualizar
                                </x-secondary-button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- Fin - Modal Actualizar Usuario --}}

    {{-- Inicio - Modal Rol Usuario --}}
    @if ($openRol)
        <div class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 bg-gray-900 bg-opacity-25 ">
            <div class="pt-6">
                <div class="max-w-md mx-auto sm:px-6 lg:px-8 lg:py-6">
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex">
                            <p class="font-bold text-base align-middle m-0  ">
                                Asignar Roles | {{ $nameRol }}
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
                        <form class="space-y-4 md:space-y-6" wire:submit="assignRole({{ $userId }})">
                            <div>
                                @foreach ($roles as $rol)
                                    <div wire:key="rol-{{ $rol->id }}" class="flex items-center">
                                        <input id="checked-checkbox1-{{ $rol->id }}" type="checkbox"
                                            style="cursor:pointer;" value="{{ $rol->id }}"
                                            wire:model.live="rolForm.selectedRol"
                                            class="w-4 h-4  text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-white-700 dark:border-gray-600">
                                        <x-label class="px-1.5 pt-2" value="{{ $rol->name }}" />
                                    </div>
                                @endforeach
                            </div>
                            <x-input-error for="rolForm.selectedRol" />
                            <div class="text-right ">
                                <x-danger-button wire:click="$set('openRol',false)" class="mr-2">
                                    <i class="fa-solid fa-xmark fa-lg"></i>&nbsp;Cancelar
                                </x-danger-button>

                                <x-secondary-button type="submit" wire:loading.attr="disabled" wire:target="update"
                                    class="disabled:opacity-55">
                                    <i class="fa-solid fa-floppy-disk fa-lg"></i>&nbsp;Actualizar
                                </x-secondary-button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- Fin - Modal Rol Usuario --}}

    {{-- Inicio -  Alerta de confirmar de bloquear usuario --}}
    @push('js')
        <script>
            Livewire.on('deleteUser', userId => {
                Swal.fire({
                    title: "Estas seguro de cambiar de estado al usuario?",
                    icon: "warning",
                    cancelButtonText: 'Cancelar',
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, Cambiar!"

                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatchTo('usuarios.show-users', 'destroy', [userId]);
                        Swal.fire({
                            title: "Operacion Exitosa!",
                            text: "A sido cambiado de estado con exito.",
                            icon: "success"
                        });
                    }
                });
            });

            function mostrarPassword() {
                var cambio = document.getElementById("txtPassword");
                if (cambio.type == "password") {
                    cambio.type = "text";
                    $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                } else {
                    cambio.type = "password";
                    $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                }
            }

            function mostrarPasswordConfirmation() {
                var cambioConfirmation = document.getElementById("txtPasswordConfirmation");
                if (cambioConfirmation.type == "password") {
                    cambioConfirmation.type = "text";
                    $('.iconConfirmation').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                } else {
                    cambioConfirmation.type = "password";
                    $('.iconConfirmation').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                }
            }
        </script>
    @endpush
    {{-- Fin -  Alerta de confirmar de bloquear usuario --}}

</div>
