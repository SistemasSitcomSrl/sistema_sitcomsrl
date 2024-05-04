<div>
    <div class="flex bg-white">
        <div class="p-2 border-4  border-slate-200 w-7/12">
            <div class="pt-3 flex items-center">
                <img class="w-1/5" src="{{ asset('img/logo.png') }}">
                <p class="w-3/5 text-center font-bold text-lg py-1 align-middle m-0">SITCOM SRL</p>
            </div>
            <div>
                <p class="w-4/5 text-xs text-justify py-1 align-middle m-0  ">
                    Dirrecion: Dir. Av. Mariscal Santa Cruz # 6350 <br>
                    Telefono: 3-3260654 <br>
                    Celular: 74604441
                </p>
            </div>
            <div>
                <p class="w-full text-xs text-center font-bold py-1 align-middle m-0">
                    SOLICITUD DE ANULACION DE EQUIPOS</p>
            </div>

            <div class="w-full">
                <button type="button"
                    class="w-full m-0 text-xs text-white bg-blue-600 font-medium rounded-lg py-1.5 me-2 mb-2 " disabled>
                    DATOS DEL RESPONSABLE
                </button>
            </div>

            <div class="pb-2 text-sm">
                <div class=" border-x-4 border-t border-b border-slate-700 grid grid-cols-12 divide-x">
                    <div class="pr-2 text-right font-bold">Nombre:</div>
                    <div class="col-span-3">{{ Auth::user()->name }}</div>
                    <div class="text-right pr-2 font-bold">Cargo:</div>
                    <div class="col-span-3">{{ Auth::user()->company_position }}</div>
                    <div class="text-right pr-2 font-bold">Celular:</div>
                    <div class="col-span-2">{{ Auth::user()->phone_number }}</div>
                </div>
            </div>

            <div class="w-full">
                <button type="button"
                    class="w-full m-0 text-xs text-white bg-blue-600 font-medium rounded-lg py-1.5 me-2 mb-2 " disabled>
                    DETALLES DE LOS EQUIPOS
                    
                </button>
            </div>
            <div class="pb-2">
                <table class="w-full text-sm  table-auto border-x-4 border-t border-b border-slate-700">
                    <thead>
                        <tr>
                            <th class="text-center">Nro</th>
                            <th>Nombre</th>
                            <th>Unidad</th>
                            <th class="text-center">Ubicación</th>
                            <th class="text-center">Precio</th>
                            <th class="text-center">Cantidad</th>
                        </tr>
                    </thead>
                    @php
                        $counter = 1; // Inicializar el contador en 1
                    @endphp
                    <tbody>
                        @foreach ($orderInventories as $orderInventory)
                            <tr wire:key="orderInventory-{{ $orderInventory->custom_key }}">
                                <td class="text-center">{{ $counter++ }}</td>
                                <td>{{ $orderInventory->name_equipment }}</td>
                                <td>{{ $orderInventory->unit_measure }}</td>
                                <td class="text-center"> {{ $orderInventory->location }}</td>
                                <td class="text-center">{{ $orderInventory->price }}</td>
                                <td class="text-center">{{ $array_amount_tool[$orderInventory->custom_key] }}</td>
                                <td>
                                    <i wire:click="deleteItemTool({{ $orderInventory->custom_key }})"
                                        style="cursor:pointer;" class=" fa-solid fa-square-minus text-[#FF0000] "></i>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pb-32 text-sm">
                <p class="w-4/5 text-justify  py-1 align-middle m-0  ">
                    El presente compromiso aplica para el uso correcto de la solicitud para crear o agregar equipos.
                </p>

                <p class="w-4/5 text-xs font-bold text-justify py-1 align-middle m-0  ">
                    FIRMA DE QUIEN CREAR O AGREGA LOS EQUIPOS O HERRAMIENTAS:
                </p>
            </div>

            <div class="pb-28">
                <div class=" text-center grid grid-cols-1 divide-x">
                    <div>
                        <p class="text-sm  text-basealign-middle m-0  ">
                            ___________________________________
                        </p>
                        <p class="text-sm  text-basealign-middle m-0  ">
                            {{ Auth::user()->name }}
                        </p>
                        <p class="text-sm font-bold align-middle m-0  ">
                            {{ Auth::user()->company_position }}

                        </p>
                    </div>

                </div>
            </div>

            <div class="pb-2 text-right">
                <x-danger-button wire:click="returnShow_movements()" class="mr-2">
                    <i class="fa-solid fa-xmark"></i> &nbsp; Cancelar
                </x-danger-button>

                <x-secondary-button wire:click="create()" wire:loading.attr="disabled" wire:target="create"
                    class="disabled:opacity-55">
                    <i class="fa-solid fa-floppy-disk"></i> &nbsp; Guardar
                </x-secondary-button>
            </div>
        </div>

        <div class="border-4  border-slate-200 w-5/12">
            <x-table>
                <div class="px-3 py-3 flex items-center">
                    <x-input class="flex-1 mx-2 text-xs" placeholder="Buscador Nombre Equipo" type="text"
                        wire:model.live="search" />
                </div>
                @if ($movements->count())
                    <table class="table-fixed min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th scope="col"
                                    class="px-1 py-1 text-left text-xs font-medium text-gray-500 tracking-wider"
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
                                    class="px-1 py-1 text-left text-xs font-medium text-gray-500 tracking-wider"
                                    wire:click="order('name_equipment')">

                                    @if ($sort == 'name_equipment')
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
                                    class="px-1 py-1 text-left text-xs font-medium text-gray-500 tracking-wider"
                                    wire:click="order('bar_Code')">

                                    @if ($sort == 'bar_Code')
                                        @if ($direction == 'asc')
                                            <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Codigo
                                        @else
                                            <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Codigo
                                        @endif
                                    @else
                                        <i class= "fas fa-sort ">&nbsp;</i>Codigo
                                    @endif

                                </th>
                                <th scope="col"
                                    class="px-1 py-1 text-center text-xs font-medium text-gray-500 tracking-wider"
                                    wire:click="order('amount')">

                                    @if ($sort == 'amount')
                                        @if ($direction == 'asc')
                                            <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Cantidad
                                        @else
                                            <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Cantidad
                                        @endif
                                    @else
                                        <i class= "fas fa-sort ">&nbsp;</i>Cantidad
                                    @endif
                                </th>
                                <th scope="col"
                                    class="px-1 py-1 text-center text-xs font-medium text-gray-500 tracking-wider">
                                    Opcion
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($movements as $movement)
                                <tr wire:key="post-{{ $movement->id }}">
                                    <td class="px-1 py-1 text-center">
                                        <div class="text-xs text-gray-900">
                                            {{ $movement->id }}
                                        </div>
                                    </td>
                                    <td class="px-1 py-1">
                                        <div class="text-xs text-gray-900">
                                            {{ $movement->name_equipment }}
                                        </div>
                                    </td>
                                    <td class="px-1 py-1">
                                        <div class="text-xs text-gray-900">
                                            {{ $movement->bar_Code }}
                                        </div>
                                    </td>
                                    <td class="px-1 py-1">
                                        <div class="text-xs text-center text-gray-900">
                                            {{ $movement->amount }}
                                        </div>
                                    </td>
                                    @if ($movement->amount == 0)
                                        <td class="px-1 py-1 text-center items-center">
                                            <i style="cursor:pointer;"
                                                class="fa-solid fa-ban fa-lg text-[rgba(255,12,4,0.76)]"
                                                @disabled(true)></i>
                                        </td>
                                    @else
                                        <td class="px-1 py-1 text-center items-center">
                                            <i wire:click="edit({{ $movement->id }})" style="cursor:pointer;"
                                                class="fa-solid fa-square-plus fa-lg "></i>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="px-4 py-2 text-xs">
                        No existe ningun registro coincidente: {{ $search }}
                    </div>
                @endif

                @if ($movements->hasPages(2))
                    <div class="px-1 py-1">
                        {{ $movements->links() }}
                    </div>
                @endif
            </x-table>
        </div>
    </div>

    {{-- Inicio Modal Reporte de Retiro de Equipo --}}
    @if ($openAdd)
        <div class="bg-gray-800 bg-opacity-25 fixed inset-0 ">
            <div class="pt-1">
                <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 lg:py-14">
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex">
                            <p class="font-bold text-base align-middle m-0  ">
                                Observación de Equipo en Mal Estado
                            </p>
                            <button type="button" wire:click="$set('openAdd',false)"
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

                        <form class="space-y-4 md:space-y-6" wire:submit="addTool({{ $toolEdit->id }})">

                            <div class="grid grid-rows-5 grid-flow-col">
                                <div class="grid grid-cols-2 gap-4 mt-1 ">
                                    <div>
                                        <x-label value="Nombre de Equipo: *" />
                                        <x-input wire:model="inventoryEdit.name_equipment" type="text"
                                            class="w-full" disabled />
                                    </div>
                                    <div>
                                        <x-label value="Codigo de Barra: *" />
                                        <x-input wire:model="inventoryEdit.bar_Code" type="text" class="w-full"
                                            disabled />
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2 ">
                                    <div>
                                        <x-label value="Precio: *" />
                                        <x-input wire:model="inventoryEdit.price" type="text" class="w-full"
                                            disabled />
                                    </div>
                                    <div>
                                        <x-label value="Marca: *" />
                                        <x-input wire:model="inventoryEdit.brand" type="text" class="w-full"
                                            disabled />
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2 ">
                                    <div>
                                        <x-label value="Modelo: *" />
                                        <x-input wire:model="inventoryEdit.color" type="text" class="w-full"
                                            disabled />
                                    </div>
                                    <div>
                                        <x-label value="Ubicación: *" />
                                        <x-input wire:model="inventoryEdit.location" type="text" class="w-full"
                                            disabled />
                                        <x-input wire:model="orderAmount" type="text" class="w-full"
                                            style="display: none;" />
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2 ">
                                    <div>
                                        <x-label value="Cantidad: *" />
                                        <x-input wire:model="inventoryEdit.amount" type="text" class="w-full"
                                            disabled />
                                    </div>
                                    <div>
                                        <x-label value="Tipo de Equipo:" />
                                        <select wire:model="inventoryEdit.type"
                                            class="bg-white-50 border border-gray-500 text-gray-600 rounded-lg text-base focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                            disabled>
                                            <option value="" disabled selected>Seleccione Tipo</option>
                                            <option value="activo">Activo Fijo
                                            </option>
                                            <option value="herramienta">Herramienta
                                            </option>
                                            <option value="material">Material
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-5 ">
                                    <div>
                                        <x-label value="Observación: *" />
                                        <textarea wire:model="message"
                                            class="block p-1.5 w-full text-sm
                                             text-gray-900  bg-gray-50 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                            placeholder="Escribe tus observaciones aquí..."></textarea>
                                        <x-input-error for="message" />
                                    </div>
                                </div>
                                @if ($this->create_image)
                                    <div class="row-span-4 pt-2 pl-3 text-center">
                                        <x-label value="Imagen Seleccionada:" class="mb-2" />
                                        <img style="width: 260px; height: 250px; display: block; margin: 0 auto; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                            src="{{ $this->create_image->temporaryUrl() }}">
                                        <x-input-error for="create_image" />
                                    </div>
                                    <div class="row-span-1 pl-7">
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
                                            <input type="file" accept="image/*" wire:click="Validation"
                                                wire:model.live="create_image" id='uploadFile1' class="hidden" />
                                        </label>
                                    </div>
                                @else
                                    <div class="row-span-5 pt-9 pl-3">
                                        <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                                            x-on:livewire-upload-finish="uploading = false"
                                            x-on:livewire-upload-cancel="uploading = false"
                                            x-on:livewire-upload-error="uploading = false"
                                            x-on:livewire-upload-progress="progress = $event.detail.progress">

                                            <div class="flex items-center justify-center w-full">
                                                <label for="dropzone-file"
                                                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed rounded-lg cursor-pointer  hover:bg-gray-200 bg-gray-0  border-gray-400 hover:border-gray-500">
                                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-500"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 20 16">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                        </svg>
                                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-800">
                                                            <span class="font-semibold">Haga clic para cargar</span> o
                                                            arrastrar y soltar
                                                        </p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-800">SVG, PNG,
                                                            JPG o GIF (MAX. 300x200px)</p>
                                                    </div>
                                                    <input id="dropzone-file" wire:model.live="create_image"
                                                        type="file" class="bto-image hidden"
                                                        accept="image/*" /><x-input-error for="create_image" />
                                                </label>
                                            </div>
                                            <div x-show="uploading">
                                                <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                                                    <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                                                        style="width: 100%">
                                                        <div x-text="progress">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="text-right m-0">
                                <x-danger-button wire:click="$set('openAdd',false)" class="mr-2">
                                    <i class="fa-solid fa-xmark fa-lg"></i>&nbsp; Cancelar
                                </x-danger-button>
                                <x-secondary-button type="submit" class="disabled:opacity-55">
                                    <i class="fa-solid fa-floppy-disk fa-lg"></i>&nbsp;Guardar
                                </x-secondary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- Fin Modal Reporte de Retiro de Equipos --}}
</div>
