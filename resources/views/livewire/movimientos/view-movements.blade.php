<div>
    <button
        class="inline-flex items-center justify-center px-2 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
        wire:click="open()" wire:loading.attr="disabled">
        <i class="fa-regular fa-eye "></i>
    </button>
    @if ($stateButton == 3)
        <button wire:click="openMessage()" wire:loading.attr="disabled"
            class= "inline-flex items-center px-2 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-700 focus:ring-offset-2 transition ease-in-out duration-150">
            <i class="fa-regular fa-comments"></i>
        </button>
    @endif
    @if ($openUpdate)
        <div class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 bg-gray-900 bg-opacity-25 ">
            <div class="pt-6">
                <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 lg:py-6">
                    <div class="bg-white  rounded-lg ">
                        <div class="flex pt-3">
                            <h3 class="font-bold text-base align-middle m-0 px-3">
                                Lista de Movimientos de {{ $name_project }}
                            </h3>
                            <button type="button" style="cursor:pointer;" wire:click="close()"
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

                        <div class="px-2 py-1.5  flex items-center">
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
                            <x-input class="flex-1 mx-1  text-sm" placeholder="Buscador Nombre Herramienta"
                                type="text" wire:model.live="search" />
                        </div>
                        @if ($inventories->count())
                            <table class="table-fixed min-w-full  divide-gray-00 py-2">
                                <thead class="bg-slate-200 static top-0 border border-y-neutral-950">
                                    <tr>
                                        @can('admin.movement.edit')
                                            <th scope="col"
                                                class="px-1 py-1.5 text-left text-sm font-bold text-gray-900 tracking-wider">
                                            </th>
                                        @endcan
                                        <th scope="col"
                                            class="px-1 py-1.5 text-left text-sm font-bold text-gray-900 tracking-wider">
                                            Nro
                                        </th>
                                        <th scope="col"
                                            class="px-1 py-1.5 text-left text-sm font-bold text-gray-900 tracking-wider">
                                            Nro Recibo
                                        </th>
                                        <th scope="col"
                                            class="px-1 py-1.5 text-left text-sm font-bold text-gray-900 tracking-wider">
                                            Nombre
                                        </th>
                                        <th scope="col"
                                            class="px-1 py-1.5 text-left text-sm font-bold text-gray-900 tracking-wider">
                                            Codigo
                                        </th>
                                        <th scope="col"
                                            class="px-1 py-1.5 text-center text-sm font-bold text-gray-900 tracking-wider">
                                            Tipo
                                        </th>
                                        <th scope="col"
                                            class="px-1 py-1.5 text-center text-sm font-bold text-gray-900 tracking-wider">
                                            Cantidades
                                        </th>
                                        <th scope="col"
                                            class="px-1 py-1.5 text-center text-sm font-bold text-gray-900 tracking-wider">
                                            Devuelto
                                        </th>
                                        <th scope="col"
                                            class="px-1 py-1.5 text-center text-sm font-bold text-gray-900 tracking-wider">
                                            Categoria
                                        </th>
                                        <th scope="col"
                                            class="px-1 py-1.5 text-center text-sm font-bold text-gray-900 tracking-wider">
                                            Fecha
                                        </th>
                                        <th scope="col"
                                            class="px-1 py-1.5 text-center text-sm font-bold text-gray-900 tracking-wider">
                                            Imagen
                                        </th>
                                    </tr>
                                </thead>
                                @php
                                    $j = 1;
                                @endphp
                                <tbody class="divide-y divide-gray-200 border-y">
                                    @foreach ($inventories as $inventory)
                                        <tr class="bg-stone-100"
                                            wire:key="inventory-{{ $inventory->id_inventory }}-{{ $inventory->receipt_number }}">
                                            @can('admin.movement.edit')
                                                @php
                                                    $time = App\Models\MovementHistory::where(
                                                        'id_movements',
                                                        $inventory->id_movements,
                                                    )
                                                        ->where('updated_at', $ultimo_fecha)
                                                        ->exists();
                                                @endphp

                                                @switch($stateButton)
                                                    {{--  Pendiente --}}
                                                    @case('0')
                                                        @if ($inventory->missing_amount == $inventory->return_amount)
                                                            <td class="px-1 pt-2 text-center">
                                                                <i class="fa-solid fa-square-check focus:ring-green-500 fa-lg "></i>
                                                            </td>
                                                        @else
                                                            <td class="px-1 py-1.5 text-center">
                                                                <input id="checked-checkbox-{{ $inventory->id_movements }}"
                                                                    name="checked-checkbox-{{ $inventory->id_movements }}"
                                                                    type="checkbox" value="{{ $inventory->id_movements }}"
                                                                    wire:key="{{ $checkBoxKey }}"
                                                                    wire:model.live="selectedProducts.{{ $inventory->id_movements }}"
                                                                    wire:click="inputEnable({{ $inventory->id_movements }})"
                                                                    wire:loading.attr="disabled"
                                                                    class="w-4 h-4 pt-2 cursor-pointer text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-white-700 dark:border-gray-600">
                                                            </td>
                                                        @endif
                                                    @break

                                                    {{-- Completado --}}
                                                    @case('1')
                                                        <td class="px-1 pt-2 text-center">
                                                        </td>
                                                    @break

                                                    {{-- Rechazado --}}
                                                    @case('3')
                                                        @if ($inventory->missing_amount == $inventory->return_amount && $time == false)
                                                            <td class="px-1 pt-2 text-center">
                                                                <i class="fa-solid fa-square-check focus:ring-green-500 fa-lg "></i>
                                                            </td>
                                                        @else
                                                            <td class="px-1 py-1.5 text-center">
                                                                <input id="checked-update-{{ $inventory->id_movements }}"
                                                                    name="checked-update-{{ $inventory->id_movements }}"
                                                                    type="checkbox" value="{{ $inventory->id_movements }}"
                                                                    wire:key="{{ $checkBoxKey }}"
                                                                    wire:model.live="selectedProducts.{{ $inventory->id_movements }}"
                                                                    wire:click="inputEnable({{ $inventory->id_movements }})"
                                                                    wire:loading.attr="disabled"
                                                                    class="w-4 h-4 pt-2 cursor-pointer text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-white-700 dark:border-gray-600">
                                                            </td>
                                                        @endif
                                                    @break

                                                    {{-- Corregido --}}
                                                    @case('4')
                                                        <td class="px-1 pt-2 text-center">
                                                            <i class="fa-solid fa-square-check focus:ring-green-500 fa-lg "></i>
                                                        </td>
                                                    @break

                                                    {{-- En Espera --}}
                                                    @case('5')
                                                        <td class="px-1 pt-2 text-center">
                                                            <i class="fa-solid fa-square-check focus:ring-green-500 fa-lg "></i>
                                                        </td>
                                                    @break
                                                @endswitch
                                            @endcan
                                            <td class="px-1 py-1.5 text-center">
                                                <div class="text-sm text-gray-900 font-bold ">
                                                    {{ $j++ }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1.5 text-left">
                                                <div class="text-sm text-gray-900 font-bold">
                                                    {{ $inventory->receipt_number }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1.5 text-left">
                                                <div class="text-sm text-gray-900 font-bold">
                                                    {{ $inventory->name_equipment }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1.5 text-left">
                                                <div class="text-sm text-gray-900 font-bold">
                                                    {{ $inventory->bar_Code }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1.5 text-center">
                                                <div class="text-sm text-gray-900 font-bold">
                                                    {{ $inventory->type }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1.5 text-center">
                                                <div class="text-sm text-gray-900 font-bold">
                                                    {{ $inventory->missing_amount }}
                                                </div>
                                            </td>
                                            <td class="px-3 py-1.5 text-center">
                                                <div class="text-sm text-red font-bold ">
                                                    {{ $inventory->return_amount }}
                                                </div>
                                            </td>
                                            <td class="px-3 py-1.5 text-center font-bold">
                                                -
                                            </td>
                                            <td class="px-1 py-1.5 text-center font-bold">
                                                -
                                            </td>
                                            <td class="px-1 pt-2 text-center items-center justify-center ">
                                                <i wire:click="editar({{ $inventory->id_inventory }})"
                                                    style="cursor:pointer;" class="fa-regular fa-image fa-xl "></i>
                                            </td>
                                        </tr>
                                        @php
                                            $i = 1;
                                        @endphp

                                        @foreach ($movements_histories as $record)
                                            @if ($inventory->id_movements == $record->id_movements)
                                                <tr
                                                    wire:key="movements-{{ $record->id_movements }}-{{ $inventory->receipt_number }}">
                                                    @can('admin.movement.edit')
                                                        <td class="px-1 py-1.5 text-center">
                                                        </td>
                                                    @endcan
                                                    <td class="px-1 py-1.5 text-center">-
                                                    </td>
                                                    <td class="px-1 py-1.5 text-left">Devolución
                                                        #{{ $i++ }}
                                                    </td>
                                                    <td class="px-1 py-1.5 text-center">-
                                                    </td>
                                                    <td class="px-1 py-1.5 text-center">-
                                                    </td>
                                                    <td class="px-1 py-1.5 text-center">-
                                                    </td>
                                                    <td class="px-1 py-1.5 text-center">-
                                                    </td>
                                                    <td class="px-3 py-1.5 text-center">
                                                        <div class="text-sm text-gray-900">
                                                            {{ $record->return_amount }}
                                                        </div>
                                                    </td>
                                                    <td class="px-3 py-1.5 text-center">
                                                        <div class="text-sm text-gray-900">
                                                            {{ $record->category }}
                                                        </div>
                                                    </td>
                                                    <td class="px-1 py-1.5 text-center">
                                                        <div class="text-sm text-gray-900">
                                                            {{ $record->updated_at }}
                                                        </div>
                                                    </td>
                                                    <td class="px-1 py-1.5 text-center">-
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        @if (array_search($inventory->id_movements, array_keys($selectedProducts)))
                                            <tr class="bg-emerald-100"
                                                wire:key="inventory-{{ $inventory->id_movements }}-{{ $inventory->receipt_number }}">
                                                @can('admin.movement.edit')
                                                    <td class="px-1 py-1.5 text-center">
                                                    </td>
                                                @endcan
                                                <td class="px-1 py-1.5 text-center">-
                                                </td>
                                                @if ($stateButton == 3)
                                                    <td class="px-1 py-1.5 text-left">Actualizar
                                                        #{{ --$i }}
                                                    </td>
                                                @else
                                                    <td class="px-1 py-1.5 text-left">Devolución #{{ $i++ }}
                                                    </td>
                                                @endif
                                                <td class="px-1 py-1.5 text-center">-
                                                </td>
                                                <td class="px-1 py-1.5 text-center">-
                                                </td>
                                                <td class="px-3 py-1.5 text-center">-
                                                </td>
                                                <td class="px-3 py-1.5 text-center">-
                                                </td>
                                                @if ($stateButton == 3)
                                                    <td style=" height: 25px;"class=" text-center">
                                                        <select
                                                            wire:model.live="selectedValues.{{ $inventory->id_movements }}"
                                                            wire:click="inputValidate()"
                                                            id="checkbox{{ $inventory->id_movements }}" required
                                                            style=" height: 25px; line-height: 11px; width:120px;"
                                                            class="py-0 text-sm text-center border-gray-300  focus:ring-indigo-500 rounded-md ">
                                                            <option value="" disabled selected>Seleccione
                                                            </option>
                                                            @php
                                                                $return_amount_history = App\Models\MovementHistory::where(
                                                                    'id_movements',
                                                                    $inventory->id_movements,
                                                                )
                                                                    ->orderBy('id', 'desc')
                                                                    ->value('return_amount');
                                                            @endphp
                                                            @for ($i = 1; $i <= $inventory->missing_amount - $inventory->return_amount + $return_amount_history; $i++)
                                                                <option value="{{ $i }}">
                                                                    {{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </td>
                                                @else
                                                    <td style=" height: 25px;"class=" text-center">
                                                        <select
                                                            wire:model.live="selectedValues.{{ $inventory->id_movements }}"
                                                            wire:click="inputValidate()"
                                                            id="checkbox{{ $inventory->id_movements }}" required
                                                            style=" height: 25px; line-height: 11px; width:120px;"
                                                            class="py-0 text-sm text-center border-gray-300  focus:ring-indigo-500 rounded-md ">
                                                            <option value="" disabled selected>Seleccione
                                                            </option>
                                                            @for ($i = 1; $i <= $inventory->missing_amount - $inventory->return_amount; $i++)
                                                                <option value="{{ $i }}">
                                                                    {{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </td>
                                                @endif

                                                <td style=" height: 25px;"class=" text-center">
                                                    <select
                                                        wire:model="selectedCategory.{{ $inventory->id_movements }}"
                                                        wire:click="inputValidate()" required
                                                        id="checkbox_category{{ $inventory->id_movements }}"
                                                        style=" height: 25px; line-height: 11px; width:120px;"
                                                        class="py-0 text-sm border-gray-300  focus:ring-indigo-500 rounded-md ">
                                                        <option value="" disabled selected>Seleccione
                                                        </option>
                                                        <option value="Obra">
                                                            Obra
                                                        </option>
                                                        <option value="Almacen">
                                                            Almacen
                                                        </option>

                                                    </select>
                                                </td>
                                                <td class="px-1 py-1.5 text-center">
                                                    {{ date('d-M') }}
                                                    {{ date('H:i') }}
                                                </td>
                                                <td class="px-1  text-center">
                                                    -
                                                </td>
                                            </tr>
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
                        @switch($stateButton)
                            {{--  Pendiente --}}
                            @case('0')
                                <div class=" pt-3 pb-2 px-2 text-right">
                                    @can('admin.movement.edit')
                                        <x-danger-button class="px-2" wire:click="close()" wire:loading.attr="disabled">
                                            <i class="fa-solid fa-x"></i>&nbsp; Cerrar
                                        </x-danger-button>
                                        <x-secondary-button wire:click="save()" wire:loading.attr="disabled">
                                            <i class="fa-solid fa-check"></i>&nbsp; Retornar
                                            {{ count($selectedValues) }}
                                        </x-secondary-button>
                                    @endcan
                                </div>
                            @break

                            {{-- Completado --}}
                            @case('1')
                                <div class=" pt-3 pb-2 px-2 text-right">
                                </div>
                            @break

                            {{-- Rechazado --}}
                            @case('3')
                                <div class=" pt-3 pb-2 px-2 text-right">
                                    @can('admin.movement.edit')
                                        <x-danger-button class="px-2" wire:click="close()" wire:loading.attr="disabled">
                                            <i class="fa-solid fa-x"></i>&nbsp; Cerrar
                                        </x-danger-button>
                                        <x-secondary-button wire:click="save()" wire:loading.attr="disabled">
                                            <i class="fa-solid fa-check"></i>&nbsp; Actualizar
                                            {{ count($selectedValues) }}
                                        </x-secondary-button>
                                    @endcan
                                </div>
                            @break

                            {{-- Corregido --}}
                            @case('4')
                                <div class=" pt-3 pb-2 px-2 text-right">
                                    @can('admin.movement.refused')
                                        <x-danger-button class="px-2" wire:click="decline()" wire:loading.attr="disabled">
                                            <i class="fa-solid fa-x"></i>&nbsp; Rechazar
                                        </x-danger-button>
                                    @endcan
                                    @can('admin.movement.accept')
                                        <x-secondary-button wire:click="acceptRequest()" wire:loading.attr="disabled">
                                            <i class="fa-solid fa-check"></i>&nbsp; Aceptar
                                        </x-secondary-button>
                                    @endcan
                                </div>
                            @break

                            {{-- En Espera --}}
                            @case('5')
                                <div class=" pt-3 pb-2 px-2 text-right">
                                    @can('admin.movement.refused')
                                        <x-danger-button class="px-2" wire:click="decline()" wire:loading.attr="disabled">
                                            <i class="fa-solid fa-x"></i>&nbsp; Rechazar
                                        </x-danger-button>
                                    @endcan
                                    @can('admin.movement.accept')
                                        <x-secondary-button wire:click="acceptRequest()" wire:loading.attr="disabled">
                                            <i class="fa-solid fa-check"></i>&nbsp; Aceptar
                                        </x-secondary-button>
                                    @endcan
                                </div>
                            @break
                        @endswitch
                    </div>
                </div>
            </div>
        </div>

    @endif

    {{-- Inicio Modal Deblinar Solicitud --}}
    @if ($openDecline)
        <div class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 bg-gray-900 bg-opacity-25 ">
            <div class="pt-6">
                <div class="max-w-lg mx-auto sm:px-6 lg:px-8 lg:py-6">
                    <div class="bg-white shadow rounded-lg px-6 pt-4 pb-1">
                        <div class="flex">
                            <p class="font-bold text-base align-middle m-0  ">
                                Observación de Solicitud Rechazada: *
                            </p>
                            <button type="button" wire:click="$set('openDecline',false)"
                                wire:loading.attr="disabled"
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
                        <form wire:submit="declineRequest">
                            <div class="">
                                <textarea rows="4"wire:model.live="textDecline"
                                    class="block p-2.5 w-full text-sm text-gray-900 dark:placeholder-gray-400 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Escribe tus observaciones aquí..."></textarea>
                                <x-input-error for="textDecline" />
                            </div>
                            <div class="py-2 text-right">
                                <x-danger-button wire:click="$set('openDecline',false)" wire:loading.attr="disabled"
                                    class="mr-2">
                                    <i class="fa-solid fa-xmark"></i> &nbsp; Cerrar
                                </x-danger-button>
                                <x-secondary-button type="submit" wire:loading.attr="disabled"
                                    wire:target="declineRequest" class="disabled:opacity-55">
                                    <i class="fa-solid fa-floppy-disk"></i> &nbsp; Guardar
                                </x-secondary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- Fin Modal Deblinar Solicitud --}}

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
                            <button type="button" wire:click="$set('openImagen',false)" wire:loading.attr="disabled"
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

    {{-- Inicio Modal Mensaje Solicitud --}}
    @if ($openRequestMessage)
        <div class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 bg-gray-900 bg-opacity-25 ">
            <div class="pt-6">
                <div class="max-w-lg mx-auto sm:px-6 lg:px-8 lg:py-6">
                    <div class="bg-white shadow rounded-lg px-6 pt-4 pb-1">
                        <div class="flex">
                            <p class="font-bold text-base align-middle m-0  ">
                                Observaciones de Solicitud Rechazada: *
                            </p>
                            <button type="button" wire:click="$set('openRequestMessage',false)"
                                wire:loading.attr="disabled"
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
                        <div class="">
                            <textarea rows="4"wire:model="messageForm.message"
                                class="block p-2.5 w-full text-sm text-gray-900 dark:placeholder-gray-400 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Escribe tus observaciones aquí..." disabled></textarea>
                            <x-input-error for="messageForm.message" />
                        </div>
                        <div class="py-2 text-right">
                            <x-danger-button wire:click="$set('openRequestMessage',false)"
                                wire:loading.attr="disabled" class="mr-2">
                                <i class="fa-solid fa-xmark"></i> &nbsp; Cerrar
                            </x-danger-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- Fin Modal Mensaje Solicitud --}}
</div>
