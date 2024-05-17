<div>
    @php
        $can = Gate::allows('admin.Link.store') || Gate::allows('admin.Link.Admin');
    @endphp
    @if ($can)
        <h2 class=" pt-2 text-lg font-bold leading-tight tracking-tight text-dark-900 md:text-2xl dark:text-dark">
            Almacenes
        </h2>

        <div class="flex flex-wrap gap-4">

            <div class="flex-1 md:w-1/3 lg:w-1/4 p-2 small-box  bg-gradient-danger">
                <div class="inner">
                    <h3> {{ $tool_count }}</h3>
                    <p>Equipos</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                </div>
                <a href="{{ Route('admin.inventory.index') }}" class="small-box-footer">
                    Mas Información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>

            <div class="flex-1 md:w-1/3 lg:w-1/4 p-2 small-box bg-gradient-secondary">
                <div class="inner">
                    <h3>{{ $requestInventory_count }}</h3>
                    <p>Agregar Equipos</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-truck-moving"></i>
                </div>
                <a href="{{ Route('admin.request.index') }}" class="small-box-footer">
                    Mas Información <i class="fas fa-arrow-circle-right"> </i>
                </a>
            </div>
            <div class="flex-1 md:w-1/3 lg:w-1/4 p-2 small-box bg-gradient-teal">
                <div class="inner">
                    <h3>{{ $retired_count }}</h3>
                    <p>Dar de Baja</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-box-archive"></i>
                </div>
                <a href="{{ Route('admin.retired.index') }}" class="small-box-footer">
                    Mas Información <i class="fas fa-arrow-circle-right"> </i>
                </a>
            </div>

            @can('admin.Link.store')
            </div>
            <div class="flex flex-wrap gap-4">
            @endcan

            <div class="flex-1 md:w-1/3 lg:w-1/4 p-2 small-box bg-gradient-primary">
                <div class="inner">
                    <h3>{{ $movement_count }}</h3>
                    <p>Prestar Equipos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-fw fa-dolly"></i>
                </div>
                <a href="{{ Route('admin.movement.index') }}" class="small-box-footer">
                    Mas Información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>

            <div class=" flex-1 md:w-1/3 lg:w-1/4 p-2 small-box bg-info">
                <div class="inner">

                    <h3>{{ $transfer_count }}</h3>
                    <p>Transf. Recibidas </p>
                </div>
                <div class="icon">
                    <i class="fas fa-right-left"></i>
                </div>
                <a href="{{ Route('admin.transfer-received.index') }}" class="small-box-footer">
                    Mas Información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    @endif
    @php
        $can = Gate::allows('admin.Link.active') || Gate::allows('admin.Link.Admin');
    @endphp
    @if ($can)
        <h2 class=" pt-2 text-lg font-bold leading-tight tracking-tight text-dark-900 md:text-2xl dark:text-dark">
            Activos Fijos
        </h2>

        <div class="flex flex-wrap gap-4">

            <div class="flex-1 md:w-1/3 lg:w-1/4 p-2 small-box  bg-gradient-danger">
                <div class="inner">
                    <h3> {{ $tool_count_active }}</h3>
                    <p>Activos </p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                </div>
                <a href="{{ Route('admin.inventory_asset.index') }}" class="small-box-footer">
                    Mas Información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>

            <div class="flex-1 md:w-1/3 lg:w-1/4 p-2 small-box bg-gradient-secondary">
                <div class="inner">
                    <h3>{{ $requestInventory_count_active }}</h3>
                    <p>Agregar Equipos</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-truck-moving"></i>
                </div>
                <a href="{{ Route('admin.request_asset.index') }}" class="small-box-footer">
                    Mas Información <i class="fas fa-arrow-circle-right"> </i>
                </a>
            </div>
            <div class="flex-1 md:w-1/3 lg:w-1/4 p-2 small-box bg-gradient-teal">
                <div class="inner">
                    <h3>{{ $retired_count_active }}</h3>
                    <p>Dar de Baja</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-box-archive"></i>
                </div>
                <a href="{{ Route('admin.retired_asset.index') }}" class="small-box-footer">
                    Mas Información <i class="fas fa-arrow-circle-right"> </i>
                </a>
            </div>
            
            @can('admin.Link.active')
            </div>
            <div class="flex flex-wrap gap-4">
            @endcan

            <div class="flex-1 md:w-1/3 lg:w-1/4 p-2 small-box bg-gradient-primary">
                <div class="inner">
                    <h3>{{ $assign_count }}</h3>
                    <p>Asignación de Activo</p>
                </div>
                <div class="icon">
                    <i class="fas fa-handshake-angle"></i>
                </div>
                <a href="{{ Route('admin.assign.index') }}" class="small-box-footer">
                    Mas Información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>

            <div class="flex-1 md:w-1/3 lg:w-1/4 p-2 small-box bg-info">
                <div class="inner">
                    <h3>{{ $worker_count }}</h3>
                    <p>Trabajadores</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-address-card"></i>
                </div>
                <a href="{{ Route('admin.workers.index') }}" class="small-box-footer">
                    Mas Información <i class="fas fa-arrow-circle-right"> </i>
                </a>
            </div>
        </div>
    @endif




</div>
