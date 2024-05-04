<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <h2 class="py-1 text-lg font-bold leading-tight tracking-tight text-dark-900 md:text-2xl dark:text-dark">
            Lista de Solicitudes de Equipo Anulados
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
                <x-input class="flex-1 mx-2" placeholder="Buscador Numero de Solicitud" type="text"
                    wire:model.live="search" />
                @can('admin.retired.create')
                    <a href="{{ Route('createRetired') }}">
                        <x-secondary-button>
                            <i class="fa-solid fa-plus"></i> &nbsp;Crear Solictud
                        </x-secondary-button>
                    </a>
                @endcan
            </div>

            @if ($movements->count())
                <table class="table-fixed min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 sticky top-0">
                        <tr>
                            <th scope="col"
                                class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
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
                                wire:click="order('name_from_branches')">

                                @if ($sort == 'name_from_branches')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Sucursal Origen
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Sucursal Origen
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Sucursal Origen
                                @endif

                            </th>
                            <th scope="col"
                                class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('name_from_user')">

                                @if ($sort == 'name_from_user')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Encargado De Sucrusal
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Encargado De Sucrusal
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Encargado De Sucrusal
                                @endif
                            </th>

                            <th scope="col"
                                class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
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
                                $can = Gate::allows('admin.retired.see') || Gate::allows('admin.retired.pdf');
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
                            <tr wire:key="movement-{{ $movement->receipt_number }}">
                                <td class="px-1 text-center" style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                    <div class="text-sm text-gray-900">
                                        {{ $movement->receipt_number }}
                                    </div>
                                </td>
                                <td class="px-1" style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                    <div class="text-sm text-gray-900">
                                        {{ $movement->name_from_branches }}
                                    </div>
                                </td>
                                <td class="px-1" style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                    <div class="text-sm text-gray-900">
                                        {{ $movement->name_from_user }}
                                    </div>
                                </td>
                                <td class="px-1" style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                    <div class="text-sm text-left text-gray-900">
                                        {{ $movement->created_at }}
                                    </div>
                                </td>
                                @if ($movement->state == 1)
                                    <td class="px-1 text-center"
                                        style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                        <span
                                            class="inline-flex items-center bg-green-300 text-green-900 text-xs font-medium px-2.5 py-0.5 rounded-full ">
                                            <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                            Completado
                                        </span>
                                    </td>
                                @else
                                    @if ($movement->state == 0)
                                        <td class="px-1 text-center"
                                            style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                            <span
                                                class="inline-flex items-center bg-stone-400 text-white text-xs font-medium px-2.5 py-0.5 rounded-full ">
                                                <span class="w-2 h-2 me-1 bg-stone-600 rounded-full"></span>
                                                Pendiente | Admin.
                                            </span>
                                        </td>
                                    @else
                                        @if ($movement->state == 2)
                                            <td class="px-1 text-center"
                                                style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                                <span
                                                    class="inline-flex items-center bg-blue-500 text-white text-xs font-medium px-2.5 py-0.5 rounded-full ">
                                                    <span class="w-2 h-2 me-1 bg-blue-600 rounded-full"></span>
                                                    Corregido | Admin.
                                                </span>
                                            </td>
                                        @else
                                            <td class="px-1 text-center"
                                                style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                                <span
                                                    class="inline-flex items-center bg-cyan-600 text-white text-xs font-medium px-2.5 py-0.5 rounded-full ">
                                                    <span class="w-2 h-2 me-1 bg-stone-200 rounded-full"></span>
                                                    &nbsp; Anulado | Encdo.&nbsp;
                                                </span>
                                            </td>
                                        @endif
                                    @endif
                                @endif
                                <td class="flex pt-1 " style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                    @can('admin.retired.pdf')
                                        <div>
                                            @livewire('solicitudRetiro.view-inventory-retired', ['receipt_number' => $movement->receipt_number], key($movement->receipt_number))
                                        </div>
                                    @endcan
                                    @can('admin.retired.see')
                                        @if ($movement->state == 1)
                                            <div class="pl-1">
                                                <form method="POST" action="{{ route('downloadInventoryRetired') }}">
                                                    @csrf
                                                    <div>
                                                        <button type="submit" value="{{ $movement->receipt_number }}"
                                                            name="retired_receipt_number"
                                                            class= "inline-flex items-center px-2 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-offset-2 transition ease-in-out duration-150">
                                                            <i class="fa-solid fa-file-pdf fa-lg"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
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

            @if ($movements->hasPages(2))
                <div class="px-3 py-2">
                    {{ $movements->links() }}
                </div>
            @endif
        </x-table>
    </div>
    {{-- Fin - Lista de Transferencia de Movimientos --}}
</div>
