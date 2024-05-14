<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <h2 class="py-1 text-lg font-bold leading-tight tracking-tight text-dark-900 md:text-2xl dark:text-dark">
            Lista de Transferencia de Herramientas Recibidas
        </h2>
        <x-table>
            <div class="px-3 py-3 flex items-center">

                <div wire:model.live="cant" class="flex items-center">
                    <span>Mostrar</span>
                    <select class="mx-2 form-control">
                        <option value="10">10</option>
                        <option value="2">25</option>
                        <option value="50">50</option>
                        <option value="100">100&nbsp;&nbsp;&nbsp;&nbsp;</option>
                    </select>
                    <span>Entradas</span>
                </div>
                <x-input class="flex-1 mx-2" placeholder="Buscador Numero de Transferencia" type="text"
                    wire:model.live="search" />
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
                                wire:click="order('branches_from.name')">

                                @if ($sort == 'branches_from.name')
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
                                wire:click="order('name_to_branches')">

                                @if ($sort == 'name_to_branches')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Sucursal Destino
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Sucursal Destino
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Sucursal Destino
                                @endif
                            </th>
                            <th scope="col"
                                class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('name_from_user')">

                                @if ($sort == 'name_from_user')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Encargado Origen
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Encargado Origen
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Encargado Origen
                                @endif
                            </th>
                            <th scope="col"
                                class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('user_to_id')">

                                @if ($sort == 'user_to_id')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Encargado Destino
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Encargado Destino
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Encargado Destino
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
                                wire:click="order('status')">

                                @if ($sort == 'status')
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
                                    Gate::allows('admin.transfer-receive.see') ||
                                    Gate::allows('admin.transfer-receive.pdf');
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
                                        {{ $movement->name_to_branches }}
                                    </div>
                                </td>
                                <td class="px-1" style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                    <div class="text-sm text-gray-900">
                                        {{ $movement->name_from_user }}
                                    </div>
                                </td>
                                <td class="px-1" style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                    <div class="text-sm text-gray-900">
                                        {{ $movement->name_to_user }}
                                    </div>
                                </td>
                                <td class="px-1" style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                    <div class="text-sm text-gray-900">
                                        {{ $movement->created_at }}
                                    </div>
                                </td>
                                @if ($movement->status)
                                    <td class="px-1 text-center"
                                        style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                        <span
                                            class="inline-flex items-center bg-green-100 text-green-900 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-300 dark:text-green-900">
                                            <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                            Completo
                                        </span>
                                    </td>
                                @else
                                    <td class="px-1 text-center"
                                        style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                        <span
                                            class="inline-flex items-center bg-red-100 text-red-500 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-500 dark:text-white">
                                            <span class="w-2 h-2 me-1 bg-red-600 rounded-full"></span>
                                            Incompleto
                                        </span>
                                    </td>
                                @endif
                                <td class="flex pt-1 text-center"
                                    style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                    @can('admin.transfer-receive.see')
                                        <div class="text-center">
                                            @livewire('transferenciaRecibidas.view-transfers', ['receipt_number' => $movement->receipt_number], key($movement->receipt_number))
                                        </div>
                                    @endcan
                                    @can('admin.transfer-receive.pdf')
                                        <div class="pl-1">
                                            <form method="POST" action="{{ route('admin.transfer-received.download') }}">
                                                @csrf
                                                <div>
                                                    <button type="submit" value="{{ $movement->receipt_number }}"
                                                        name="transfer_receipt_number"
                                                        class= "inline-flex items-center px-2 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-offset-2 transition ease-in-out duration-150">
                                                        <i class="fa-solid fa-file-pdf fa-lg"></i>
                                                    </button>
                                                </div>
                                            </form>
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

            @if ($movements->hasPages(2))
                <div class="px-3 py-2">
                    {{ $movements->links() }}
                </div>
            @endif
        </x-table>
    </div>
    {{-- Fin - Lista de Transferencia de Movimientos --}}
</div>
