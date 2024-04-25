<div>
    <button
        class=" text-center inline-flex items-center justify-center px-2 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
        wire:click="open()">
        <i class="fa-regular fa-eye "></i>
    </button>
    @if ($openUpdate)
        <div class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 bg-gray-900 bg-opacity-25 ">
            <div class="pt-6">
                <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 lg:py-6">
                    <div class="bg-white  rounded-lg ">
                        <div class="flex pt-3">
                            <h3 class="font-bold text-base align-middle m-0 px-3">
                                Nro de Recibo {{ $receipt_number }}: Transferencia de Herramientas Recibida
                            </h3>
                            <button type="button" style="cursor:pointer;" wire:click="$set('openUpdate',false)"
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

                        <div class="px-2 py-1  flex items-center">
                            <div wire:model.live="cant" class=" text-sm flex items-center">
                                <span>Mostrar</span>
                                <select style=" height: 30px; line-height: 11px; width:80px;" class="mx-2 form-control">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                </select>
                                <span>Entradas</span>
                            </div>
                            <x-input style=" height: 33px; line-height: 11px; width:80px;" class="flex-1 mx-1  text-sm"
                                placeholder="Buscador Nombre Herramienta" type="text" wire:model.live="search" />
                            @can('admin.transfer-receive.edit')
                                <x-secondary-button style=" height: 30px; line-height: 11px;" wire:click="save()"
                                    onclick="desmarcarCheckboxes()">
                                    <i class="fa-solid fa-rotate-left"></i>&nbsp; Retornar
                                    {{ count($selectedValues) }}
                                </x-secondary-button>
                            @endcan
                        </div>


                        @if ($inventories->count())
                            <table class="table-fixed min-w-full  divide-gray-200 py-1">
                                <thead class="bg-slate-200 static top-0 border border-y-neutral-950">
                                    <tr>
                                        @can('admin.transfer-receive.edit')
                                            <th scope="col"
                                                class="px-1 py-1 text-left text-sm font-medium text-gray-900 tracking-wider">
                                            </th>
                                        @endcan
                                        <th scope="col"
                                            class="px-1 py-1 text-left text-sm  font-bold text-gray-900 tracking-wider"
                                            wire:click="order('id_inventory')">

                                            @if ($orderSort == 'id_inventory')
                                                @if ($orderDirection == 'asc')
                                                    <i class="fa-solid fa-arrow-down-1-9">&nbsp;</i>Nro
                                                @else
                                                    <i class="fa-solid fa-arrow-up-9-1">&nbsp;</i>Nro
                                                @endif
                                            @else
                                                <i class= "fas fa-sort ">&nbsp;</i>Nro
                                            @endif

                                        </th>
                                        <th scope="col"
                                            class="px-1 py-1 text-left text-sm font-bold text-gray-900 tracking-wider"
                                            wire:click="order('name_equipment')">

                                            @if ($orderSort == 'name_equipment')
                                                @if ($orderDirection == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Nombre
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Nombre
                                                @endif
                                            @else
                                                <i class= "fas fa-sort ">&nbsp;</i>Nombre
                                            @endif
                                        </th>
                                        <th scope="col"
                                            class="px-1 py-1 text-left text-sm font-bold text-gray-900 tracking-wider"
                                            wire:click="order('bar_Code')">

                                            @if ($orderSort == 'bar_Code')
                                                @if ($orderDirection == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Codigo
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Codigo
                                                @endif
                                            @else
                                                <i class= "fas fa-sort ">&nbsp;</i>Codigo
                                            @endif
                                        </th>
                                        <th scope="col"
                                            class="px-1 py-1 text-left text-sm font-bold text-gray-900 tracking-wider"
                                            wire:click="order('unit_measure')">

                                            @if ($orderSort == 'unit_measure')
                                                @if ($orderDirection == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Unidad
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Unidad
                                                @endif
                                            @else
                                                <i class= "fas fa-sort ">&nbsp;</i>Unidad
                                            @endif
                                        </th>
                                        <th scope="col"
                                            class="px-1 py-1 text-left text-sm font-bold text-gray-900 tracking-wider"
                                            wire:click="order('missing_amount')">

                                            @if ($orderSort == 'missing_amount')
                                                @if ($orderDirection == 'asc')
                                                    <i class="fa-solid fa-arrow-down-1-9">&nbsp;</i>Cantidad
                                                @else
                                                    <i class="fa-solid fa-arrow-up-9-1">&nbsp;</i>Cantidad
                                                @endif
                                            @else
                                                <i class= "fas fa-sort ">&nbsp;</i>Cantidad
                                            @endif
                                        </th>
                                        <th scope="col"
                                            class="px-1 py-1 text-center text-sm font-bold text-gray-900 tracking-wider"
                                            wire:click="order('return_amount')">

                                            @if ($orderSort == 'return_amount')
                                                @if ($orderDirection == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Devuelto
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Devuelto
                                                @endif
                                            @else
                                                <i class= "fas fa-sort ">&nbsp;</i>Devuelto
                                            @endif
                                        </th>
                                        <th scope="col"
                                            class="px-1 py-1 text-center text-sm font-bold text-gray-900 tracking-wider">
                                            Fecha
                                        </th>

                                        <th scope="col"
                                            class="px-1 py-1 text-center text-sm font-bold text-gray-900 tracking-wider">
                                            Imagen
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200  border-y">
                                    @foreach ($inventories as $inventory)
                                        <tr class="bg-stone-100" wire:key="inventory-{{ $inventory->id_inventory }}">
                                            @can('admin.transfer-receive.edit')
                                                @if ($inventory->missing_amount == $inventory->return_amount)
                                                    <td class="px-1 pt-2 text-center">
                                                        <i class="fa-solid fa-square-check focus:ring-green-500 fa-lg "></i>
                                                    </td>
                                                @else
                                                    <td class="px-1 py-1 text-center">
                                                        <input id="checked-checkbox1-{{ $inventory->id_trasnfers }}"
                                                            name="2" type="checkbox" style="cursor:pointer;"
                                                            value="{{ $inventory->id_trasnfers }}"
                                                            wire:model.live="selectedProducts.{{ $inventory->id_trasnfers }}"
                                                            wire:click="inputEnable()"
                                                            class="w-4 h-4 pt-2 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-white-700 dark:border-gray-600">

                                                    </td>
                                                @endif
                                            @endcan
                                            <td class="px-1 py-1 text-center">
                                                <div class="text-sm text-gray-900 font-bold ">
                                                    {{ $inventory->id_inventory }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1 text-left">
                                                <div class="text-sm text-gray-900 font-bold">
                                                    {{ $inventory->name_equipment }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1 text-left">
                                                <div class="text-sm text-gray-900 font-bold">
                                                    {{ $inventory->bar_Code }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1 text-left">
                                                <div class="text-sm text-gray-900 font-bold">
                                                    {{ $inventory->unit_measure }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1 text-center">
                                                <div class="text-sm text-gray-900 font-bold">
                                                    {{ $inventory->missing_amount }}
                                                </div>
                                            </td>

                                            <td class="px-1 py-1 text-center">
                                                <div class="text-sm text-red font-bold ">
                                                    {{ $inventory->return_amount }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1 text-center font-bold">
                                                -
                                            </td>
                                            <td class="px-1 pt-2 text-center items-center justify-center ">
                                                <i wire:click="editar({{ $inventory->id_inventory }})"
                                                    style="cursor:pointer;" class="fa-regular fa-image fa-lg "></i>
                                            </td>
                                        </tr>
                                        @php
                                            $i = 1;
                                        @endphp

                                        @foreach ($movements_histories as $record)
                                            @if ($inventory->id_trasnfers == $record->transfer_id)
                                                <tr>
                                                    <td class="px-1 py-1 text-center">
                                                    </td>
                                                    <td class="px-1 py-1 text-center">-
                                                    </td>
                                                    <td class="px-1 py-1 text-left text-sm">Devolucion
                                                        #{{ $i++ }}
                                                    </td>
                                                    <td class="px-1 py-1 text-center">-
                                                    </td>
                                                    <td class="px-1 py-1 text-center">-
                                                    </td>
                                                    <td class="px-1 py-1 text-center">-
                                                    </td>
                                                    <td class="px-1 py-1 text-center">
                                                        <div class="text-sm text-gray-900">
                                                            {{ $record->return_amount }}
                                                        </div>
                                                    </td>

                                                    <td class="px-1 py-1 text-center">
                                                        <div class="text-sm text-gray-900">
                                                            {{ date('d-M', strtotime($record->return_time)) }}
                                                            {{ date('H:i', strtotime($record->return_time)) }}
                                                        </div>
                                                    </td>
                                                    <td class="px-1 py-1 text-center">-
                                                    </td>

                                                </tr>
                                            @endif
                                        @endforeach
                                        @if (array_search($inventory->id_trasnfers, array_keys($selectedProducts)))
                                            @if ($inventory->missing_amount != $inventory->return_amount)
                                                <tr>
                                                    <td class="px-1 py-1 text-center">
                                                    </td>
                                                    <td class="px-1 py-1 text-center">-
                                                    </td>
                                                    <td class="px-1 py-1 text-center">-
                                                    </td>
                                                    <td class="px-1 py-1 text-center">-
                                                    </td>
                                                    <td class="px-1 py-1 text-center">-
                                                    </td>
                                                    <td class="px-1 py-1 text-center">-
                                                    </td>
                                                    <td style=" height: 25px;"class=" text-center">
                                                        <select
                                                            wire:model.live="selectedValues.{{ $inventory->id_trasnfers }}"
                                                            wire:click="inputValidate()"
                                                            id="checkbox{{ $inventory->id_trasnfers }}"
                                                            style=" height: 25px; line-height: 11px; width:80px;"
                                                            class="py-0 text-sm text-center border-gray-300  focus:ring-indigo-500 rounded-md ">
                                                            <option value="0" selected>0</option>
                                                            @for ($i = 1; $i <= $inventory->missing_amount - $inventory->return_amount; $i++)
                                                                <option value="{{ $i }}">
                                                                    {{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </td>
                                                    <td class="px-1 py-1 text-center">
                                                        <div class="text-sm text-gray-900">
                                                            {{ date('d-M') }}
                                                            {{ date('H:i') }}
                                                        </div>
                                                    </td>
                                                    <td class="px-1 py-1 text-center">-
                                                    </td>
                                                </tr>
                                            @endif
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="px-6 py-4">
                                No existe ningun registro coincidente: {{ $search }}
                            </div>
                        @endif

                        @if ($inventories->hasPages(2))
                            <div class="px-6 py-3">
                                {{ $inventories->links() }}
                            </div>
                        @endif
                        <div class=" pt-3 pb-2 px-2 text-right">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Inicio Modal Seleccionar Cantidad Herramienta --}}
    @if ($openImagen)
        <div class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 bg-gray-900 bg-opacity-25 ">
            <div class="pt-6">
                <div class="max-w-lg mx-auto sm:px-6 lg:px-8 lg:py-6">
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex">
                            <p class="font-bold text-base align-middle m-0  ">
                                Imagen de la Herramienta
                            </p>
                            <button type="button" wire:click="$set('openImagen',false)"
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
                        @if ($imageTool->image_path)
                            <img style="width: 390px; height: 360px; display: block; margin: 0 auto; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                src="{{ asset('storage/' . $imageTool->image_path) }}">
                        @else
                            <x-label class="text-red" value="La Herramienta Selecionada No Tiene Imagen." />
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- Fin Modal Seleccionar Cantidad Herramienta --}}
    <script>
        function desmarcarCheckboxes() {
            // Obtener todas las casillas de verificación
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');

            // Desmarcar cada casilla de verificación
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });
        }
    </script>

</div>
