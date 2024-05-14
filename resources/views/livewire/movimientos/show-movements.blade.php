<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <h2 class="py-1 text-lg font-bold leading-tight tracking-tight text-dark-900 md:text-2xl dark:text-dark">
        Lista de Movimientos de Herramientas
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
            @can('admin.movement.create')
                <a href="{{ Route('admin.movement.create') }}">
                    <x-secondary-button>
                        <i class="fa-solid fa-plus"></i> &nbsp;Prestar Herramienta
                    </x-secondary-button>
                </a>
            @endcan
        </div>

        @if ($movements->count())
            <table class="table-fixed min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 sticky top-0">
                    <tr>
                        <th scope="col"
                            class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            wire:click="order('receipt_number')">

                            @if ($sort == 'receipt_number')
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
                            wire:click="order('name_project')">

                            @if ($sort == 'name_project')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Nombre del Proyecto
                                @else
                                    <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Nombre del Proyecto
                                @endif
                            @else
                                <i class= "fas fa-sort ">&nbsp;</i>Nombre del Proyecto
                            @endif

                        </th>
                        <th scope="col"
                            class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            wire:click="order('entity_project')">

                            @if ($sort == 'entity_project')
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
                                    <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Encargado Recibir
                                @else
                                    <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Encargado Recibir
                                @endif
                            @else
                                <i class= "fas fa-sort ">&nbsp;</i>Encargado Recibir
                            @endif
                        </th>
                        <th scope="col"
                            class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            wire:click="order('name_auth')">

                            @if ($sort == 'name_auth')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Encargado Entregar
                                @else
                                    <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Encargado Entregar
                                @endif
                            @else
                                <i class= "fas fa-sort ">&nbsp;</i>Encargado Entregar
                            @endif
                        </th>
                        <th scope="col"
                            class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            wire:click="order('created_at')">
                            @if ($sort == 'created_at')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Fecha
                                @else
                                    <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Fecha
                                @endif
                            @else
                                <i class= "fas fa-sort ">&nbsp;</i>Fecha
                            @endif
                        </th>
                        <th scope="col"
                            class="px-1 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                            wire:click="order('state_create')">

                            @if ($sort == 'state_create')
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
                            $can = Gate::allows('admin.movement.see') || Gate::allows('admin.movement.pdf');
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
                    @foreach ($movements as $movement)
                        <tr wire:key="movement-{{ $movement->created_at->toString() }}">
                            <td class="px-1 py-2 text-center">
                                <div class="text-sm text-gray-900">
                                    {{ $movement->receipt_number }}
                                </div>
                            </td>
                            <td class="px-1 py-2">
                                <div class="text-sm text-gray-900">
                                    {{ $movement->name_project }}
                                </div>
                            </td>
                            <td class="px-1 py-2">
                                <div class="text-sm text-gray-900">
                                    {{ $movement->entity_project }}
                                </div>
                            </td>
                            <td class="px-1 py-2">
                                <div class="text-sm text-gray-900">
                                    {{ $movement->name_user }}
                                </div>
                            </td>
                            <td class="px-1 py-2">
                                <div class="text-sm text-gray-900">
                                    {{ $movement->name_auth }}
                                </div>
                            </td>
                            <td class="px-1 py-2">
                                <div class="text-sm text-gray-900">
                                    {{ $movement->created_at }}
                                </div>
                            </td>

                            @switch($movement->state_create)
                                @case('0')
                                    <td class="px-1 py-2 text-center">
                                        <span
                                            class="inline-flex items-center bg-stone-400 text-white text-xs font-medium px-2.5 py-0.5 rounded-full ">
                                            <span class="w-2 h-2 me-1 bg-stone-600 rounded-full"></span>
                                            Pendiente | Encdo.
                                        </span>
                                    </td>
                                @break

                                @case('1')
                                    <td class="px-1 py-2 text-center">
                                        <span
                                            class="inline-flex items-center bg-green-300 text-green-900 text-xs font-medium px-2.5 py-0.5 rounded-full ">
                                            <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                            Completado
                                        </span>
                                    </td>
                                @break

                                @case('2')
                                    <td class="px-1 py-2 text-center">
                                        <span
                                            class="inline-flex items-center bg-green-300 text-green-900 text-xs font-medium px-2.5 py-0.5 rounded-full ">
                                            <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                            Aceptado
                                        </span>
                                    </td>
                                @break

                                @case('3')
                                    <td class="px-1 py-2 text-center">
                                        <span
                                            class="inline-flex items-center bg-red-500 text-white text-xs font-medium px-2.5 py-0.5 rounded-full ">
                                            <span class="w-2 h-2 me-1 bg-red-600 rounded-full"></span>
                                            Rechazado | Encdo.
                                        </span>

                                    </td>
                                @break

                                @case('4')
                                    <td class="px-1 py-2 text-center">
                                        <span
                                            class="inline-flex items-center bg-blue-500 text-white text-xs font-medium px-2.5 py-0.5 rounded-full ">
                                            <span class="w-2 h-2 me-1 bg-blue-600 rounded-full"></span>
                                            Corregido | Admin.
                                        </span>
                                    </td>
                                @break

                                @case('5')
                                    <td class="px-1 py-2 text-center">
                                        <span
                                            class="inline-flex items-center bg-indigo-500 text-white text-xs font-medium px-2.5 py-0.5 rounded-full ">
                                            <span class="w-2 h-2 me-1 bg-indigo-100 rounded-full"></span>
                                            En Espera | Admin.
                                        </span>
                                    </td>
                                @break
                            @endswitch
                            <td class="flex px-1 py-2 pt-1 text-left text-sm font-medium ">
                                @can('admin.movement.see')
                                    <div>
                                        @livewire('movimientos.view-movements', ['receipt_number' => $movement->id_project, 'state_receipt' => $movement->state, 'created_at_receipt' => $movement->created_at->toString()], key($movement->created_at->toString()))
                                    </div>
                                @endcan

                                @if ($movement->state_create != 3)
                                    @can('admin.movement.pdf')
                                        <div class="pl-1">
                                            <form method="POST" action="{{ route('admin.movement.download') }}">
                                                @csrf
                                                <div>
                                                    <input type="text" name="state_create"
                                                        value="{{ $movement->state_create }}" hidden>
                                                    <input type="text" name="state" value="{{ $movement->state }}"
                                                        hidden>
                                                    <button type="submit" value="{{ $movement->id_project }}"
                                                        name="movement_receipt_number"
                                                        class= "inline-flex items-center px-2 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-offset-2 transition ease-in-out duration-150">
                                                        <i class="fa-solid fa-file-pdf fa-lg"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    @endcan
                                @endif

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

        @if ($movements->hasPages(2))
            <div class="px-3 py-2">
                {{ $movements->links() }}
            </div>
        @endif
    </x-table>
</div>
