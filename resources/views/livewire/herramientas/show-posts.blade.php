<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- Inicio - Lista de Herramienta --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class=" py-1 text-lg font-bold leading-tight tracking-tight text-dark-900 md:text-2xl dark:text-dark">
            Lista de Equipos | {{ $branch_name }}
        </h2>
        <x-table>
            <div class="px-3 py-3 flex items-center">
                <div wire:model.live="cant" wire:key="{{ $canthKey }}" class="flex items-center">
                    <span>Mostrar</span>
                    <select class="mx-2 form-control">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100&nbsp;&nbsp;&nbsp;&nbsp;</option>
                    </select>
                    <span>Entradas&nbsp; </span>
                </div>

                <input id="searchInput" placeholder="Buscador Nombre Equipo" type="text" value=""
                    wire:model.live="search" wire:key="{{ $searchKey }}"
                    class="flex-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <form class="flex items-center pl-1 " method="POST" action="{{ route('admin.inventory.download') }}">
                    @csrf

                    @can('admin.inventory.select')
                        <div wire:model.live="selectBranch" class="flex items-center">
                            <select wire:model.live="postForm.select" wire:click="resetInput" name="branch_inventory"
                                class="mx-2 form-control">
                                <option value="0">Todas Las Sucursales
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                </option>
                                @foreach ($inputBranch as $branch)
                                    <option value="{{ $branch->id }}">
                                        {{ $branch->name }}&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                @endforeach
                            </select>
                        </div>
                    @endcan

                    @can('admin.inventory.pdf')
                        <div>
                            <button type="submit" value="" name="transfer_receipt_number"
                                class= "inline-flex items-center px-2 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fa-solid fa-file-pdf fa-lg"></i>&nbsp; PDF Herramientas
                            </button>
                        </div>
                    @endcan

                </form>

            </div>

            @if ($posts->count())
                <table class="table-fixed min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 sticky top-0">
                        <tr>
                            <th scope="col"
                                class="px-1 py-1 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
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
                                class="px-1 py-1 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
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
                                class="px-1 py-1 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
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
                                class="px-1 py-1 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('Bar_Code')">

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
                                class="px-1 py-1 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('brand')">

                                @if ($sort == 'brand')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Marca
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Marca
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Marca
                                @endif
                            </th>
                            <th scope="col"
                                class="px-1 py-1 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('location')">

                                @if ($sort == 'location')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Ubicacion
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Ubicacion
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Ubicacion
                                @endif
                            </th>
                            <th scope="col"
                                class="px-1 py-1 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('unit_measure')">

                                @if ($sort == 'unit_measure')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Unidad
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Unidad
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Unidad
                                @endif
                            </th>
                            <th scope="col"
                                class="px-1 py-1 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                wire:click="order('price')">

                                @if ($sort == 'price')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Precio
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Precio
                                    @endif
                                @else
                                    <i class= "fas fa-sort ">&nbsp;</i>Precio
                                @endif
                            </th>
                            @can('admin.inventory.see')
                                <th scope="col"
                                    class="px-1 py-1 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Opciones
                                </th>
                            @endcan
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($posts as $post)
                            <tr wire:key="post-{{ $post->id }}">
                                <td class="px-1 py-1 text-center">
                                    <div class="text-sm text-gray-900">
                                        {{ $post->id }}
                                    </div>
                                </td>
                                <td class="px-1 py-1 text-center">
                                    <div class="text-sm text-gray-900">
                                        {{ $post->name_equipment }}
                                    </div>
                                </td>
                                <td class="px-1 py-1 text-center">
                                    <div class="text-sm text-gray-900">
                                        {{ $post->amount }}
                                    </div>
                                </td>
                                <td class="px-1 py-1 text-center">
                                    <div class="text-sm text-gray-900">
                                        {{ $post->bar_Code }}
                                    </div>
                                </td>
                                <td class="px-1 py-1 text-center">
                                    <div class="text-sm text-gray-900">
                                        {{ $post->brand }}
                                    </div>
                                </td>
                                <td class="px-1 py-1 text-center">
                                    <div class="text-sm text-gray-900">
                                        {{ $post->location }}
                                    </div>
                                </td>
                                <td class="px-1 py-1 text-center">
                                    <div class="text-sm text-gray-900">
                                        {{ $post->unit_measure }}
                                    </div>
                                </td>
                                <td class="px-1 py-1 text-center">
                                    <div class="text-sm text-gray-900">
                                        {{ $post->price }}
                                    </div>
                                </td>
                                <td class="px-1 py-1 ">
                                    <div class="text-center text-gray-900">
                                        @can('admin.inventory.see')
                                            <button wire:click="edit({{ $post->id }})"
                                                class= "inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 transition ease-in-out duration-150">
                                                <i class="fa-regular fa-eye lg"></i>
                                            </button>
                                        @endcan
                                    </div>
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
            @if ($posts->hasPages(2))
                <div class="px-6 py-2">
                    {{ $posts->links() }}
                </div>
            @endif
        </x-table>
    </div>
    {{-- Fin - Lista de Herramienta --}}

    {{-- Inicio - Modal Actualizar Herramienta --}}
    @if ($open)
        <div class="bg-gray-800 bg-opacity-25 fixed inset-0 ">
            <div class="pt-1">
                <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 lg:py-14">
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex">
                            <p class="font-bold text-base align-middle m-0  ">
                                Actualizar Imagen de Equipo
                            </p>
                            <button type="button" wire:click="$set('open',false)"
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
                            <div class="grid grid-rows-5 grid-flow-col">
                                <div class="grid grid-cols-1 gap-4 mt-1 ">
                                    <div>
                                        <x-label value="Nombre de Equipo:" />
                                        <x-input wire:model="postForm.name_equipment" type="text" class="w-full"
                                            disabled />
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mt-1">
                                    <div>
                                        <x-label value="Precio:" />
                                        <x-input wire:model="postForm.price" type="number" class="w-full"
                                            disabled />
                                    </div>
                                    <div>
                                        <x-label value="Marca:" />
                                        <x-input wire:model="postForm.brand" type="text" class="w-full"
                                            disabled />
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mt-1">
                                    <div>
                                        <x-label value="Modelo:" />
                                        <x-input wire:model="postForm.color" type="text" class="w-full"
                                            disabled />
                                    </div>
                                    <div>
                                        <x-label value="Cantidad:" />
                                        <x-input wire:model="postForm.amount" type="number" class="w-full"
                                            disabled />
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mt-1">
                                    <div>
                                        <x-label value="Ubicación:" />
                                        <x-input wire:model="postForm.location" type="text" class="w-full"
                                            disabled />
                                    </div>
                                    <div>
                                        <x-label value="Unidad medida:" />
                                        <x-input wire:model="postForm.unit_measure" type="text" class="w-full"
                                            disabled />
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mt-1">
                                    <div>
                                        <x-label value="Codigo de Barra:" />
                                        <x-input wire:model="postForm.bar_Code" type="text" class="w-full"
                                            disabled />
                                    </div>
                                    <div>
                                        <x-label value="Tipo de Equipo:" />
                                        <select wire:model="postForm.type"
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
                                        <x-input-error for="postForm.type" />
                                    </div>

                                </div>
                                @if ($update_image)
                                    <div class="row-span-4 pt-2 pl-3 text-center">
                                        <x-label value="Imagen Seleccionada:" class="mb-2" />
                                        <img style="width: 260px; height: 250px; display: block; margin: 0 auto; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                            src="{{ $this->update_image->temporaryUrl() }}">
                                        <x-input-error for="update_image" />
                                    </div>
                                @else
                                    <div class="row-span-4 pt-2 pl-3 text-center">
                                        <x-label value="Imagen Seleccionada:" class="mb-2" />
                                        <img style="width: 260px; height: 250px; display: block; margin: 0 auto; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                            src="{{ asset('storage/' . $imageTool) }}">
                                        <x-input-error for="update_image" />
                                    </div>
                                @endif
                                @can('admin.inventory.image')
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
                                @endcan

                            </div>
                            <div class="text-right m-0">
                                <x-danger-button wire:click="$set('open',false)" class="mr-2">
                                    <i class="fa-solid fa-xmark fa-lg"></i>&nbsp;Cerrar
                                </x-danger-button>
                                @can('admin.inventory.image')
                                    <x-secondary-button wire:click="update" class="disabled:opacity-55">
                                        <i class="fa-solid fa-floppy-disk fa-lg"></i>&nbsp;Actualizar
                                    </x-secondary-button>
                                @endcan
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    @endif
    {{-- Fin - Modal Actualizar Herramienta --}}
    <script>
        function resetSearch() {
            // Establecer el valor de $this->search en una cadena vacía
            <?php $this->search = ''; ?>

            // Limpiar el valor del input de búsqueda

            document.getElementById("searchInput").value = "";
            // Redirigir o recargar la página según sea necesario para aplicar los cambios
            // Por ejemplo, puedes redirigir a la misma página
            window.location.href = window.location.href;
        }
    </script>
</div>
