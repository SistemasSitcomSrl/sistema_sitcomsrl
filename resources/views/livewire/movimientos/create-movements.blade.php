<div>
    <div class="flex bg-white">
        <div class="p-2 border-4  border-slate-200 w-7/12">
            <div class="pt-3 flex items-center">
                <img class="w-1/5" src="{{ asset('img/logo.png') }}">
                <p class="w-3/5 text-center font-bold text-lg py-1 align-middle m-0">SITCOM SRL</p>
            </div>
            <div>
                <p class="w-4/5 text-xs text-justify py-1 align-middle m-0  ">
                    Dirrecion: Dir. Av. Mariscal Santa Cruz # 6350<br>
                    Telefono: 3-3260654 <br>
                    Celular: 74604441
                </p>
            </div>
            <div>
                <p class="w-full text-xs text-center font-bold py-1 align-middle m-0">
                    REPORTE PRESTAMO DE HERRAMIENTAS</p>
            </div>
            <div class="w-full">
                <button type="button" wire:click="projectName()"
                    class="w-full py-1.5 text-xs m-0 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    DATOS A QUIEN SE LE ENTREGA LA HERRAMIENTAS
                </button>
            </div>


            <div class="pb-2 text-sm">
                @foreach ($names as $name)
                    <div class=" border-x-4 border-t border-slate-700 grid grid-cols-12 divide-x">
                        <div class="pr-2 text-right font-bold">Nombre:</div>
                        <div class="col-span-5">{{ $name->name }}</div>
                        <div class="text-right pr-2 font-bold">Cargo:</div>
                        <div class="col-span-2">{{ $name->company_position }}</div>
                        <div class="text-right pr-2 font-bold">Fecha:</div>
                        <div class="col-span-2">{{ date('d-m-Y') }}</div>
                    </div>
                    <div class=" border-x-4 border-t border-b border-slate-700 grid grid-cols-12 divide-x">
                        <div class="pr-2 text-right font-bold">Proyecto:</div>
                        <div class="col-span-5">{{ $name->object }}</div>
                        <div class="text-right pr-2 font-bold">Entidad:</div>
                        <div class="col-span-2">{{ $name->entity }}</div>
                        <div class="text-right pr-2 font-bold">Ciudad</div>
                        <div class="col-span-2">{{ $name->ubi_entity }}</div>
                    </div>
                @endforeach
            </div>

            <div class="w-full">
                <button type="button"
                    class="w-full m-0 text-xs text-white bg-blue-600 font-medium rounded-lg py-1.5 me-2 mb-2 " disabled>
                    DATOS DEL RESPONSABLE DE LA ENTREGA DE LOS EQUIPOS DE HERRAMIENTAS
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
                    DETALLES DE LAS HERRAMIENTAS
                </button>
            </div>
            <div class="pb-2">
                <table class="w-full text-sm  table-auto border-x-4 border-t border-b border-slate-700">
                    <thead>
                        <tr>
                            <th>Nro</th>
                            <th>Nombre</th>
                            <th>Unidad</th>
                            <th>Ubicación</th>
                            <th>Precio</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    @php
                        $j = 0;
                    @endphp
                    <tbody>
                        @foreach ($orderInventories as $orderInventory)
                            <tr wire:key="orderInventory-{{ $orderInventory->id }}">
                                <td>{{ $j++ }}</td>
                                <td>{{ $orderInventory->name_equipment }}</td>
                                <td>{{ $orderInventory->unit_measure }}</td>
                                <td>{{ $orderInventory->location }}</td>
                                <td>{{ $orderInventory->price }}</td>
                                <td>{{ $orderInventory->type }}</td>
                                <td>{{ $selectedAll[array_search($orderInventory->id, $selectedTool)] }}</td>
                                <td>
                                    <i wire:click="deleteItemTool({{ $orderInventory->id }})" style="cursor:pointer;"
                                        class=" fa-solid fa-square-minus text-[#FF0000] "></i>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pb-16 text-sm">
                <p class="w-4/5 text-justify  py-1 align-middle m-0  ">
                    El presente compromiso aplica para el uso correcto de los equipos o heramientas prestadas.
                </p>

                <p class="w-4/5 text-xs font-bold text-justify py-1 align-middle m-0  ">
                    FIRMA DE QUIEN RECIBE LOS EQUIPOS O HERRAMIENTAS:
                </p>
            </div>
            <div class="pb-8">
                <div class=" text-center grid grid-cols-2 divide-x">
                    <div>

                        @foreach ($names as $name)
                            <p class="text-sm  text-basealign-middle m-0  ">
                                ___________________________________
                            </p>
                            <p class="text-sm  text-basealign-middle m-0  ">
                                {{ $name->name }}
                            </p>
                            <p class="text-sm font-bold  align-middle m-0  ">
                                {{ $name->company_position }}

                            </p>
                        @endforeach

                    </div>
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

            <div class="text-center">
                <x-danger-button wire:click="returnShow_movements()" class="mr-2">
                    <i class="fa-solid fa-xmark"></i> &nbsp; Cancelar
                </x-danger-button>

                <x-secondary-button wire:click="create()" wire:loading.attr="disabled" wire:target="save"
                    class="disabled:opacity-55">
                    <i class="fa-solid fa-floppy-disk"></i> &nbsp; Guardar
                </x-secondary-button>
            </div>



        </div>

        <div class="border-4  border-slate-200 w-5/12">
            <div class="px-2 py-2 flex items-center">
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
                                        <i wire:click="editar({{ $movement->id }})" style="cursor:pointer;"
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
        </div>
    </div>

    {{-- Inicio Modal Seleccionar Proyecto --}}
    @if ($openCreate)
        <div class="bg-gray-800 bg-opacity-25 fixed inset-0 ">
            <div class="pt-6">
                <div class="max-w-xl mx-auto sm:px-6 lg:px-8 lg:py-16">
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex">
                            <p class="font-bold text-base align-middle m-0  ">
                                Seleccione Proyecto:
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
                        <form class="space-y-4 md:space-y-6" wire:submit="dataProject()">
                            <div class=" my-2">
                                <div>
                                    <select wire:model='selectedInput' id="countries"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required>
                                        <option value="" selected>Seleccione un Proyecto</option>

                                        @foreach ($projects as $project)
                                            <option wire:key="selectProject-{{ $project->id }}"
                                                value="{{ $project->id }}">{{ $project->object }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="text-right text-xs">
                                <x-danger-button wire:click="$set('openCreate',false)" class="mr-2  ">
                                    <i class="fa-solid fa-xmark"></i> &nbsp; Cerrar
                                </x-danger-button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- Fin Modal Seleccionar Proyecto --}}

    {{-- Inicio Modal Seleccionar Cantidad Herramienta --}}
    @if ($openImagen)
        <div class="bg-gray-800 bg-opacity-25 fixed inset-0 ">
            <div class="pt-1">
                <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 lg:py-14">
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex">
                            <p class="font-bold text-base align-middle m-0  ">
                                Seleccione Cantidad Herramienta
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
                        <form class="space-y-4 md:space-y-6">
                            <div class="grid grid-rows-5 grid-flow-col">
                                <div class="grid grid-cols-2 gap-4 mt-1 ">
                                    <div>
                                        <x-label value="Nombre de Equipo:" />
                                        <x-input wire:model="inventoryEdit.name_equipment" type="text"
                                            class="w-full" disabled />
                                    </div>
                                    <div>
                                        <x-label value="Modelo:" />
                                        <x-input wire:model="inventoryEdit.color" type="text" class="w-full"
                                            disabled />
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mt-1">
                                    <div>
                                        <x-label value="Precio:" />
                                        <x-input wire:model="inventoryEdit.price" type="number" class="w-full"
                                            disabled />
                                    </div>
                                    <div>
                                        <x-label value="Marca:" />
                                        <x-input wire:model="inventoryEdit.brand" type="text" class="w-full"
                                            disabled />
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mt-1">
                                    <div>
                                        <x-label value="Ubicación:" />
                                        <x-input wire:model="inventoryEdit.location" type="text" class="w-full"
                                            disabled />
                                    </div>
                                    <div>
                                        <x-label value="Unidad medida:" />
                                        <x-input wire:model="inventoryEdit.unit_measure" type="text"
                                            class="w-full" disabled />
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mt-1">
                                    <div>
                                        <x-label value="Codigo de Barra:" />
                                        <x-input wire:model="inventoryEdit.bar_Code" type="text" class="w-full"
                                            disabled />
                                    </div>
                                    <div>
                                        <x-label value="Tipo de Equipo: *" />
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
                                <div class="grid grid-cols-2 gap-4 mt-1">
                                    <div>
                                        <x-label value="Cantidad Actual:" />
                                        <x-input wire:model="inventoryEdit.amount" type="number" class="w-full"
                                            disabled />
                                        <x-input-error for="inventoryEdit.amount" />
                                    </div>
                                    <div>
                                        <x-label value="Cantidad de los Equipos:" />
                                        <select wire:model.live="orderAmount" name="orderAmount"
                                            class="w-full border-gray-300  focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="" selected>Seleccione Cantidad</option>
                                            @for ($i = 1; $i <= $amount; $i++)
                                                <option value="{{ $i }}">{{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                        <x-input-error for="orderAmount" />
                                    </div>
                                </div>
                                @if ($imageTool->image_path)
                                    <div class="row-span-4 pt-2 pl-3 text-center">
                                        <x-label value="Imagen Seleccionada:" class="mb-2" />
                                        <img style="width: 260px; height: 250px; display: block; margin: 0 auto; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                            src="{{ asset('storage/' . $imageTool->image_path) }}">
                                        <x-input-error for="update_image" />
                                    </div>
                                @else
                                    <x-label value="La Herramienta Selecionada No Tiene Imagen." />
                                @endif
                            </div>

                            <div class="text-right ">
                                <x-danger-button wire:click="$set('openImagen',false)" class="mr-2">
                                    <i class="fa-solid fa-xmark"></i> &nbsp; Cancelar
                                </x-danger-button>

                                <x-secondary-button wire:click="save({{ $id }})"
                                    wire:loading.attr="disabled" wire:target="update" class="disabled:opacity-55">
                                    <i class="fa-solid fa-floppy-disk"></i> &nbsp; Guardar
                                </x-secondary-button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- Fin Modal Seleccionar Cantidad Herramienta --}}
</div>
