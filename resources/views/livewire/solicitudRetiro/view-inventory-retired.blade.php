<div>
    <div class="text-center">
        <button
            class=" text-center inline-flex items-center justify-center px-2 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
            wire:click="open()">
            <i class="fa-regular fa-eye "></i>
        </button>
    </div>
    @if ($openUpdate)
        <div class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 bg-gray-900 bg-opacity-25 ">
            <div class="pt-6">
                <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 lg:py-6">
                    <div class="bg-white  rounded-lg ">
                        <div class="flex pt-3">
                            <h3 class="font-bold text-base align-middle m-0 px-3">
                                Nro {{ $receipt_number }}: Solicitud de Retiros de Equipos
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
                                            wire:click="order('message')">

                                            @if ($orderSort == 'message')
                                                @if ($orderDirection == 'asc')
                                                    <i class="fas fa-sort-alpha-up-alt ">&nbsp;</i>Mensaje de
                                                    Solicitud
                                                @else
                                                    <i class="fas fa-sort-alpha-down-alt ">&nbsp;</i>Mensaje de
                                                    Solicitud
                                                @endif
                                            @else
                                                <i class= "fas fa-sort ">&nbsp;</i>Mensaje de Solicitud
                                            @endif
                                        </th>
                                        <th scope="col"
                                            class="px-1 py-1 text-center text-sm font-bold text-gray-900 tracking-wider"
                                            wire:click="order('state_request')">

                                            @if ($orderSort == 'state_request')
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
                                            Opciones
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200 border-y">
                                    @foreach ($inventories as $key => $inventory)
                                        <tr wire:key="inventory-{{ $inventory->receipt_number }}">
                                            <td class="px-1 py-1 text-center">
                                                <div class="text-sm text-gray-900">
                                                    {{ $inventory->custom_id }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1 text-left">
                                                <div class="text-sm text-gray-900">
                                                    {{ $inventory->name_equipment }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1 text-left">
                                                <div class="text-sm text-gray-900">
                                                    {{ $inventory->bar_Code }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1 text-left">
                                                <div class="text-sm text-gray-900">
                                                    {{ $inventory->brand }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1 text-left">
                                                <div class="text-sm text-gray-900">
                                                    {{ $inventory->color }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1 text-left">
                                                <div class="text-sm text-gray-900">
                                                    {{ $inventory->unit_measure }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1 text-center">
                                                <div class="text-sm text-gray-900">
                                                    {{ $inventory->price }}.00 Bs
                                                </div>
                                            </td>
                                            <td class="px-1 py-1 text-left">
                                                <div class="text-sm text-gray-900">
                                                    {{ $inventory->type }}
                                                </div>
                                            </td>
                                            <td class="px-1 py-1 text-left">
                                                <div class="text-sm text-gray-900 font-bold text-red">
                                                    {{ $inventory->message }}
                                                </div>
                                            </td>

                                            @if ($inventory->state_request == '1')
                                                <td class="px-1 text-center"
                                                    style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                                    <span
                                                        class="inline-flex items-center bg-red-100 text-blue-500 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-500 dark:text-white">
                                                        &nbsp;<span
                                                            class="w-2 h-2 me-1 bg-blue-600 rounded-full"></span>
                                                        &nbsp;Aceptado&nbsp;
                                                    </span>
                                                </td>
                                            @else
                                                @if ($inventory->state_request == '0')
                                                    <td class="px-1 text-center"
                                                        style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                                        <span
                                                            class="inline-flex items-center bg-red-500 text-white text-xs font-medium px-2.5 py-0.5 rounded-full ">
                                                            <span class="w-2 h-2 me-1 bg-red-600 rounded-full"></span>
                                                            Rechazado
                                                        </span>
                                                    </td>
                                                @else
                                                    <td class="px-1 text-center"
                                                        style="padding-top: 0.150rem;   padding-bottom: 0.150rem;">
                                                        <span
                                                            class="inline-flex items-center bg-stone-400 text-white text-xs font-medium px-2.5 py-0.5 rounded-full ">
                                                            <span
                                                                class="w-2 h-2 me-1 bg-stone-600 rounded-full"></span>
                                                            Pendiente
                                                        </span>
                                                    </td>
                                                @endif
                                            @endif
                                            <td class="px-1 pt-2 text-left items-center justify-center ">
                                                @if ($inventory->state == 0 || $inventory->state == 2)
                                                    @can('admin.request.accept')
                                                        <i style="cursor:pointer;"
                                                            wire:click="$dispatch('modalAccept', {{ json_encode(['id' => $inventory->id, 'receipt_number' => $inventory->receipt_number]) }})"
                                                            class="fa-solid fa-square-check text-blue-500 fa-xl transition-opacity duration-300 hover:opacity-50 "></i>
                                                        <i style="cursor:pointer;"
                                                            wire:click="checkDecline({{ $inventory->id }})"
                                                            class="fa-solid fa-square-xmark text-red-500 fa-xl transition-opacity duration-300 hover:opacity-50 "></i>
                                                    @endcan
                                                @endif

                                                <i wire:click="openImagenTool({{ $inventory->id }})"
                                                    style="cursor:pointer;"
                                                    class="fa-regular fa-image fa-xl transition-opacity duration-300 hover:opacity-50"></i>
                                                @if ($inventory->state_request == '0')
                                                    <i style="cursor:pointer;"
                                                        wire:click="openMessage({{ $inventory->id }})"
                                                        class="fa-solid fa-comment-sms fa-xl text-red-500 transition-opacity duration-300 hover:opacity-50"></i>
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
                        <div class=" pt-3 pb-2 px-2 text-right">
                            @can('admin.request.accept')
                                @if ($stateButtom == 0 || $stateButtom == 2)
                                    <x-danger-button style=" height: 30px; line-height: 11px;"
                                        wire:click="closeModalView">
                                        <i class="fa-solid fa-x"></i>&nbsp; Cerrar
                                    </x-danger-button>
                                    <x-secondary-button style=" height: 30px; line-height: 11px;"
                                        wire:click="acceptpApplication()">
                                        <i class="fa-solid fa-check"></i>&nbsp; Enviar
                                    </x-secondary-button>&nbsp;
                                @endif
                            @endcan

                            @can('admin.request.update')
                                @if ($stateButtom == 0)
                                    <x-danger-button style=" height: 30px; line-height: 11px;"
                                        wire:click="closeModalView">
                                        <i class="fa-solid fa-x"></i>&nbsp; Cerrar
                                    </x-danger-button>
                                    <x-secondary-button style=" height: 30px; line-height: 11px;"
                                        wire:click="cancelRequest()">
                                        <i class="fa-solid fa-check"></i>&nbsp; Anular
                                    </x-secondary-button>&nbsp;
                                @endif
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Inicio Modal Visualizar una Equipo --}}
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
    {{-- Fin Modal Visualizar una Equipo --}}

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
                                    <i class="fa-solid fa-xmark"></i> &nbsp; Cancelar
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

    {{-- Inicio Modal Mensage de Solicitud Rechazada --}}
    @if ($openDeclineMessage)
        <div class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 bg-gray-900 bg-opacity-25 ">
            <div class="pt-6">
                <div class="max-w-lg mx-auto sm:px-6 lg:px-8 lg:py-6">
                    <div class="bg-white shadow rounded-lg px-6 pt-4 pb-1">
                        <div class="flex">
                            <p class="font-bold text-base align-middle m-0  ">
                                Solicitud Rechazada: *
                            </p>
                            <button type="button" wire:click="$set('openDeclineMessage',false)"
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
                                <textarea rows="4" wire:model="messageForm.messageDecline"
                                    class="block p-2.5 w-full text-sm text-gray-900 dark:placeholder-gray-400 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Escribe tus observaciones aquí..." disabled></textarea>
                            </div>
                            <div class="py-2 text-right">
                                <x-danger-button wire:click="$set('openDeclineMessage',false)" class="mr-2">
                                    <i class="fa-solid fa-xmark"></i> &nbsp; Cerrar
                                </x-danger-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- Fin Modal Mensage de Solicitud Rechazada --}}

    {{-- Inicio -  Alerta de confirmar de eliminar --}}
    @push('js')
        <script>
            Livewire.on('modalAccept', (toolId) => {
                Swal.fire({
                    title: "¿Estás seguro de dar de baja la herramienta?",
                    text: "¡No podrás revertir esto!",
                    icon: "warning",
                    cancelButtonText: 'Cancelar',
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Aceptar"

                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.dispatchTo('solicitud-retiro.view-inventory-retired', 'checkTool', [toolId]);

                        Swal.fire({
                            title: "¡Aprobado!",
                            text: "Ha sido cambiado de estado con éxito.",
                            icon: "success"
                        });
                    }
                });
            });
        </script>
    @endpush
    {{-- Fin -  Alerta de confirmar de eliminar --}}

</div>
