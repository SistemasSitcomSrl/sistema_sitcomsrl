<div>
    <x-secondary-button wire:click="save">
        <i class="fa-solid fa-plus"></i> &nbsp;Crear Usuario
    </x-secondary-button>

    {{-- Inicio - Modal Crear Usuario --}}
    @if ($openCreate)
        <div class="bg-gray-800 bg-opacity-25 fixed inset-0 ">
            <div class="pt-1">
                <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 lg:py-16">
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex">
                            <p class="font-bold text-base align-middle m-0  ">
                                Crear Usuario
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
                        <form class="space-y-4 md:space-y-6" wire:submit="save">
                            <div class="grid grid-cols-1 gap-4 mt-2">
                                <div>
                                    <x-label value="Nombre Completo: *" />
                                    <x-input wire:model="name" type="text" class="w-full"
                                        placeholder="Ingrese Nombre Completo" />
                                    <x-input-error for="name" />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-2">
                                <div>
                                    <x-label value="Carnet de Identidad: *" />
                                    <x-input wire:model="ci" type="text" class="w-full"
                                        placeholder="Ingrese Numero de Carnet" />
                                    <x-input-error for="ci" />
                                </div>
                                <div>
                                    <x-label value="Correo Electronico: *" />
                                    <x-input wire:model="email" type="email" class="w-full"
                                        placeholder="example@email.com" />
                                    <x-input-error for="email" />
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mt-2">                                
                                <div>
                                    <x-label value="Cargo Empresa: *" />
                                    <x-input wire:model="company_position" type="text" class="w-full"
                                        placeholder="Ingrese Cargo Empresa" />
                                    <x-input-error for="company_position" />
                                </div>                                
                                <div>
                                    <x-label value="Numero Celular: *" />
                                    <x-input wire:model="phone_number" id="NumberPhone" type="text" class="w-full"
                                        placeholder="Ej: 75617798" />
                                    <x-input-error for="phone_number" />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-2">
                                <div class="items-center">
                                    <x-label value="Contraseña: *" />
                                    <div class="input-group">
                                        <input wire:model="password" ID="txtPassword" type="Password"
                                            placeholder="Ingrese Contraseña"
                                            Class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                            style=" width: 83%;">
                                        <div>
                                            <button id="show_password" class="btn btn-primary " type="button"
                                                onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <x-input-error for="password" />
                                </div>
                                <div class="items-center">
                                    <x-label value="Repetir Contraseña: *" />
                                    <div class="input-group">
                                        <input wire:model="passwordConfirmation" ID="txtPasswordConfirmation"
                                            type="Password" placeholder="Repetir Contraseña"
                                            Class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                            style=" width: 83%;">
                                        <div>
                                            <button id="show_password" class="btn btn-primary " type="button"
                                                onclick="mostrarPasswordConfirmation()"> <span
                                                    class="fa fa-eye-slash iconConfirmation"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <x-input-error for="passwordConfirmation" />
                                </div>
                            </div>

                            <div class="text-right">
                                <x-danger-button wire:click="$set('openCreate',false)" class="mr-2">
                                    <i class="fa-solid fa-xmark fa-lg"></i>&nbsp;Cancelar
                                </x-danger-button>

                                <x-secondary-button wire:click="create" wire:loading.attr="disabled" wire:target="save"
                                    class="disabled:opacity-55">
                                    <i class="fa-solid fa-floppy-disk fa-lg"></i>&nbsp;Guardar
                                </x-secondary-button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- Fin - Modal Crear Usuario --}}


    <script type="text/javascript">
        function mostrarPassword() {
            var cambio = document.getElementById("txtPassword");
            if (cambio.type == "password") {
                cambio.type = "text";
                $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
            } else {
                cambio.type = "password";
                $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
            }
        }

        function mostrarPasswordConfirmation() {
            var cambioConfirmation = document.getElementById("txtPasswordConfirmation");
            if (cambioConfirmation.type == "password") {
                cambioConfirmation.type = "text";
                $('.iconConfirmation').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
            } else {
                cambioConfirmation.type = "password";
                $('.iconConfirmation').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
            }
        }
    </script>
</div>
