<div>
    <button
        class=" text-center inline-flex items-center justify-center px-2 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
        wire:click="open()">
        <i class="fa-regular fa-eye "></i>
    </button>
    @if ($state_create == 2 || $state_create == 3)
        <button wire:click="openMessage()"
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
                                Nro {{ $receipt_number }}: Solicitud de Crear o Incrementar Cantidad de Equipos
                            </h3>
                            <button type="button" style="cursor:pointer;" wire:click="closeModalView"
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
                            <x-input class="flex-1 mx-1  text-sm" placeholder="Buscador Nombre del Equipo"
                                type="text" wire:model.live="search" />
                        </div>

                        @if ($inventories->count())
                            <table class="table-fixed min-w-full  divide-gray-200 py-1">
                                <thead class="bg-slate-200 static top-0 border border-y-neutral-950">
                                    <tr>
                                        <th scope="col"
                                            class="px-1 py-1 text-left text-sm  font-bold text-gray-900 tracking-wider"
                                            wire:click="order('custom_id')">

                                            @if ($orderSort == 'custom_id')
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
                                            wire:click="order('brand')">

                                            @if ($orderSort == 'brand')
                                                @if ($orderDirection == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Marca
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Marca
                                                @endif
                                            @else
                                                <i class= "fas fa-sort ">&nbsp;</i>Marca
                                            @endif
                                        </th>
                                        <th scope="col"
                                            class="px-1 py-1 text-left text-sm font-bold text-gray-900 tracking-wider"
                                            wire:click="order('color')">

                                            @if ($orderSort == 'color')
                                                @if ($orderDirection == 'asc')
                                                    <i class="fa-solid fa-arrow-down-1-9">&nbsp;</i>Modelo
                                                @else
                                                    <i class="fa-solid fa-arrow-up-9-1">&nbsp;</i>Modelo
                                                @endif
                                            @else
                                                <i class= "fas fa-sort ">&nbsp;</i>Modelo
                                            @endif
                                        </th>
                                        <th scope="col"
                                            class="px-1 py-1 text-center text-sm font-bold text-gray-900 tracking-wider"
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
                                            class="px-1 py-1 text-center text-sm font-bold text-gray-900 tracking-wider"
                                            wire:click="order('price')">

                                            @if ($orderSort == 'price')
                                                @if ($orderDirection == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Precio
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Precio
                                                @endif
                                            @else
                                                <i class= "fas fa-sort ">&nbsp;</i>Precio
                                            @endif
                                        </th>
                                        <th scope="col"
                                            class="px-1 py-1 text-left text-sm font-bold text-gray-900 tracking-wider"
                                            wire:click="order('type')">

                                            @if ($orderSort == 'type')
                                                @if ($orderDirection == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Tipo
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Tipo
                                                @endif
                                            @else
                                                <i class= "fas fa-sort ">&nbsp;</i>Tipo
                                            @endif
                                        </th>
                                        <th scope="col"
                                            class="px-1 py-1 text-center text-sm font-bold text-gray-900 tracking-wider"
                                            wire:click="order('amount')">

                                            @if ($orderSort == 'amount')
                                                @if ($orderDirection == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Cantidad
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Cantidad
                                                @endif
                                            @else
                                                <i class= "fas fa-sort ">&nbsp;</i>Cantidad
                                            @endif
                                        </th>
                                        <th scope="col"
                                            class="px-1 py-1 text-center text-sm font-bold text-gray-900 tracking-wider"
                                            wire:click="order('state_exist')">

                                            @if ($orderSort == 'state_exist')
                                                @if ($orderDirection == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Estado
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Estado
                                                @endif
                                            @else
                                                <i class= "fas fa-sort ">&nbsp;</i>Estado
                                            @endif
                                        </th>
                                        <th scope="col"
                                            class="px-1 py-1 text-left text-sm font-bold text-gray-900 tracking-wider">
                                            Opcion
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200 border-y">
                                    @foreach ($inventories as $key => $inventory)
                                        <tr wire:key="inventory-{{ $inventory->id }}">
                                            <td class="px-1 py-1.5 text-center">
                                                <div class="text-sm text-gray-900  ">
                                                    {{ $inventory->custom_id }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1.5 text-left">
                                                <div class="text-sm text-gray-900">
                                                    {{ $inventory->name_equipment }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1.5 text-left">
                                                <div class="text-sm text-gray-900">
                                                    {{ $inventory->bar_Code }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1.5 text-left">
                                                <div class="text-sm text-gray-900">
                                                    {{ $inventory->brand }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1.5 text-left">
                                                <div class="text-sm text-gray-900">
                                                    {{ $inventory->color }}
                                                </div>
                                            </td>

                                            <td class="px-1 py-1.5 text-left">
                                                <div class="text-sm text-gray-900">
                                                    {{ $inventory->unit_measure }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1.5 text-left">
                                                <div class="text-sm text-gray-900">
                                                    {{ $inventory->price }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1.5 text-left">
                                                <div class="text-sm text-gray-900">
                                                    {{ $inventory->type }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1.5 text-center">
                                                <div class="text-sm text-red font-bold">
                                                    {{ $inventory->amount }}
                                                </div>
                                            </td>
                                            @if ($inventory->state_exist)
                                                <td class="px-1 text-center"
                                                    style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                                    <span
                                                        class="inline-flex items-center bg-green-100 text-green-900 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-300 dark:text-green-900">
                                                        <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                                        Incrementar
                                                    </span>
                                                </td>
                                            @else
                                                <td class="px-1 text-center"
                                                    style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                                    <span
                                                        class="inline-flex items-center bg-red-100 text-blue-500 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-500 dark:text-white">
                                                        &nbsp;<span
                                                            class="w-2 h-2 me-1 bg-blue-600 rounded-full"></span>
                                                        &nbsp;Agregando&nbsp;
                                                    </span>
                                                </td>
                                            @endif
                                            <td class="px-1 pt-2 text-center items-center justify-center ">
                                                @can('admin.request.edit')
                                                    @if ($inventory->state_create == 2 || $inventory->state_create == 3)
                                                        <i wire:click="edit({{ $inventory->id }})"
                                                            style="cursor:pointer;"
                                                            class="fa-solid fa-pen-to-square fa-lg "></i>
                                                    @endif
                                                @endcan

                                                @if ($inventory->id_inventory == 0)
                                                    <i wire:click="openImagenTool({{ json_encode(['id' => $inventory->id]) }})"
                                                        style="cursor:pointer;"
                                                        class="fa-regular fa-image fa-lg "></i>
                                                @else
                                                    <i wire:click="openImagenTool({{ json_encode(['id_inventory' => $inventory->id_inventory]) }})"
                                                        style="cursor:pointer;"
                                                        class="fa-regular fa-image fa-lg "></i>
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

                        @if ($inventories->hasPages(2))
                            <div class="px-6 py-3">
                                {{ $inventories->links() }}
                            </div>
                        @endif
                        <div class="pt-3 pb-2 px-2 text-right">
                            @can('admin.request.accept')
                                @if ($state == 0 || $state == 3)
                                    <x-danger-button style=" height: 30px; line-height: 11px;" wire:click="decline()">
                                        <i class="fa-solid fa-x"></i>&nbsp; Rechazar
                                    </x-danger-button>&nbsp;
                                    <x-secondary-button style=" height: 30px; line-height: 11px;"
                                        wire:click="acceptpApplication()">
                                        <i class="fa-solid fa-check"></i>&nbsp; Aceptar
                                    </x-secondary-button>
                                @endif
                            @endcan
                            @can('admin.request.send')
                                @if ($state == 2)
                                    <x-danger-button style=" height: 30px; line-height: 11px;"
                                        wire:click="closeModalView">
                                        <i class="fa-solid fa-x"></i>&nbsp; Cerrar
                                    </x-danger-button>&nbsp;
                                    <x-secondary-button style=" height: 30px; line-height: 11px;"
                                        wire:click="acceptRequest()">
                                        <i class="fa-solid fa-check"></i>&nbsp; Enviar
                                    </x-secondary-button>&nbsp;
                                @endif
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Inicio Modal Visualizar una Herramienta --}}
    @if ($openImagen)
        <div class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 bg-gray-900 bg-opacity-25 ">
            <div class="pt-6">
                <div class="max-w-lg mx-auto sm:px-6 lg:px-8 lg:py-6">
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex">
                            <p class="font-bold text-base align-middle m-0  ">
                                Imagen del Equipo
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
                        @if ($imageTool)
                            <img style="width: 390px; height: 360px; display: block; margin: 0 auto; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                src="{{ asset('storage/' . $imageTool) }}">
                        @else
                            <x-label class="text-red" value="El Equipo Selecionado No Tiene Imagen." />
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- Fin Modal Visualizar una Herramienta --}}

    {{-- Inicio Modal Deblinar Solicitud --}}
    @if ($openDecline)
        <div class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 bg-gray-900 bg-opacity-25 ">
            <div class="pt-6">
                <div class="max-w-lg mx-auto sm:px-6 lg:px-8 lg:py-6">
                    <div class="bg-white shadow rounded-lg px-6 pt-4 pb-1">
                        <div class="flex">
                            <p class="font-bold text-base align-middle m-0  ">
                                Observaciones de Solicitud Rechazada: *
                            </p>
                            <button type="button" wire:click="$set('openDecline',false)"
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
                                <x-danger-button wire:click="$set('openDecline',false)" class="mr-2">
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
                            <x-danger-button wire:click="$set('openRequestMessage',false)" class="mr-2">
                                <i class="fa-solid fa-xmark"></i> &nbsp; Cerrar
                            </x-danger-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- Fin Modal Mensaje Solicitud --}}


    @if ($openEdit)
        <div class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 bg-gray-900 bg-opacity-25 ">
            <div class="pt-6">
                <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 lg:py-6">
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex">
                            <p class="font-bold text-base align-middle m-0  ">
                                Solicitud Rechazada:
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
                        <form class="space-y-4 md:space-y-6" wire:submit="update()">

                            <div class="grid grid-rows-5 grid-flow-col">
                                <div class="grid grid-cols-1 gap-4 mt-1">
                                    <div>
                                        <x-label value="Nombre de Equipo: *" />
                                        <x-input disabled="{{ $stateInput }}"
                                            wire:model.live="editForm.edit_name_equipment" type="text"
                                            class="w-full" placeholder="Descripción del Equipo" />
                                        <x-input-error for="editForm.edit_name_equipment" />
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mt-1">
                                    <div>
                                        <x-label value="Precio: *" />
                                        <x-input disabled="{{ $stateInput }}" wire:model.live="editForm.edit_price"
                                            type="text" class="w-full" placeholder="Ingrese Precio" />
                                        <x-input-error for="editForm.edit_price" />

                                    </div>
                                    <div>
                                        <x-label value="Marca: *" />
                                        <x-input disabled="{{ $stateInput }}" wire:model.live="editForm.edit_brand"
                                            type="text" class="w-full" placeholder="Ingrese Marca" />
                                        <x-input-error for="editForm.edit_brand" />

                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mt-1">
                                    <div>
                                        <x-label value="Modelo: *" />
                                        <x-input disabled="{{ $stateInput }}" wire:model.live="editForm.edit_color"
                                            type="text" class="w-full" placeholder="Ingrese Modelo" />
                                        <x-input-error for="editForm.edit_color" />
                                    </div>
                                    <div>
                                        <x-label value="Cantidad: *" />
                                        <x-input wire:model.live="editForm.edit_amount" type="number" class="w-full"
                                            placeholder="Ingrese Cantidad" />
                                        <x-input-error for="editForm.edit_amount" />
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mt-1">
                                    <div>
                                        <x-label value="Ubicación: *" />
                                        <x-input disabled="{{ $stateInput }}"
                                            wire:model.live="editForm.edit_location" type="text" class="w-full"
                                            placeholder="Ingrese Ubicación" />
                                        <x-input-error for="editForm.edit_location" />
                                    </div>
                                    <div>

                                        <x-label value="Unidad de Medida: *" />
                                        <x-input disabled="{{ $stateInput }}"
                                            wire:model.live="editForm.edit_unit_measure" type="text"
                                            class="w-full" placeholder="Ingrese Unidad de Medida" />
                                        <x-input-error for="editForm.edit_unit_measure" />
                                    </div>

                                </div>
                                <div class="grid grid-cols-2 gap-4 mt-1">
                                    <div>
                                        <x-label value="Codigo de Barra: *" />
                                        <x-input disabled="{{ $stateInput }}"
                                            wire:model.live="editForm.edit_bar_Code" type="text" class="w-full"
                                            placeholder="Ingrese Codigo de Barra" />
                                        <x-input-error for="editForm.edit_bar_Code" />
                                    </div>
                                    <div>
                                        <x-label value="Tipo de Equipo: *" />
                                        @if ($stateInput)
                                            <select wire:model.live="editForm.select_type"
                                                class="bg-white-50 border border-gray-500 text-gray-600 rounded-lg text-base focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                disabled>
                                            @else
                                                <select wire:model.live="editForm.select_type"
                                                    class="bg-white-50 border border-gray-500 text-gray-600 rounded-lg text-base focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        @endif

                                        <option value="" disabled selected>Seleccione Tipo</option>
                                        @switch($rol)
                                            @case('Encargado de Almacen')
                                                <option value="herramienta">Herramienta
                                                </option>
                                                <option value="material">Material
                                                </option>
                                            @break

                                            @case('Encargado de Activo')
                                                <option value="activo">Activo Fijo
                                                </option>
                                            @break
                                        @endswitch
                                        </select>
                                        <x-input-error for="editForm.select_type" />
                                    </div>
                                </div>
                                @if ($update_image)
                                    <div class="row-span-4 pt-2 pl-3 text-center">
                                        <x-label value="Imagen Seleccionada:" class="mb-2" />
                                        <img style="width: 260px; height: 250px; display: block; margin: 0 auto; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                            src="{{ $this->update_image->temporaryUrl() }}">
                                    </div>
                                @else
                                    @if ($edit_image)
                                        <div class="row-span-4 pt-2 pl-3 text-center">
                                            <x-label value="Imagen Seleccionada:" class="mb-2" />
                                            <img style="width: 260px; height: 250px; display: block; margin: 0 auto; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                                src="{{ asset('storage/' . $edit_image) }}">
                                        </div>
                                    @else
                                        <div class="row-span-3 pt-2 pl-3" style="width: 300px; height: 200px;">
                                            <x-label value="La Equipo Selecionada No Tiene Imagen." />
                                        </div>
                                    @endif
                                @endif

                                <div class="row-span-1 ">
                                    <label for="uploadFile1"
                                        class="bg-gray-800 hover:bg-gray-700 text-white text-sm px-4 py-1.5 outline-none rounded w-max cursor-pointer mx-auto block font-[sans-serif]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 mr-2 fill-white inline"
                                            viewBox="0 0 32 32">
                                            <path
                                                d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956z"
                                                data-original="#000000" />
                                            <path
                                                d="M20.293 19.707a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z"
                                                data-original="#000000" />
                                        </svg>
                                        Actualizar Imagen
                                        <input type="file" accept="image/*" wire:model.live="update_image"
                                            id='uploadFile1' class="hidden" />
                                    </label>
                                </div>

                            </div>
                            <div class="text-right m-0">
                                <x-danger-button wire:click="$set('openEdit',false)" class="mr-2">
                                    <i class="fa-solid fa-xmark fa-lg"></i>&nbsp; Cancelar
                                </x-danger-button>
                                <x-secondary-button type="submit" class="disabled:opacity-55">
                                    <i class="fa-solid fa-floppy-disk fa-lg"></i>&nbsp; Guardar
                                </x-secondary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- Fin Modal Mensaje Solicitud --}}
</div>
