<div>
    <h2 class=" pt-2 text-lg font-bold leading-tight tracking-tight text-dark-900 md:text-2xl dark:text-dark">
        Inicio
    </h2>
    <div class="pt-2 grid grid-cols-3 gap-4">
        <div class="small-box bg-gradient-success">
            <div class="inner">
                <h3>{{ $branch_count }}</h3>
                <p>3.1 Sucursales Registradas</p>
            </div>
            <div class="icon">
                <i class="fa-solid fa-building"></i>
            </div>
            <a href="{{ Route('admin.branch.index') }}" class="small-box-footer">
                Mas Informacion <i class="fas fa-arrow-circle-right"> </i>
            </a>
        </div>

        <div class="small-box  bg-gradient-danger">
            <div class="inner">
                <h3> {{ $tool_count }}</h3>
                <p>4.1 Heramientas Registradas</p>
            </div>
            <div class="icon">
                <i class="fa-solid fa-screwdriver-wrench"></i>
            </div>
            <a href="{{ Route('admin.inventory.index') }}" class="small-box-footer">
                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
        <div class="small-box bg-gradient-secondary">
            <div class="inner">
                <h3>{{ $requestInventory_count }}</h3>
                <p>4.2 Solicitud Pendientes Crear Herramientas</p>
            </div>
            <div class="icon">
                <i class="fa-solid fa-truck-moving"></i>
            </div>
            <a href="{{ Route('requestInventory') }}" class="small-box-footer">
                Mas Informacion <i class="fas fa-arrow-circle-right"> </i>
            </a>
        </div>

    </div>

    <div class="pt-2 grid grid-cols-3 gap-4">
        <div class="small-box bg-gradient-teal">
            <div class="inner">
                <h3>{{ $retired_count }}</h3>
                <p>4.3 Solicitudes Pendientes de Retiro de Herramientas</p>
            </div>
            <div class="icon">
                <i class="fa-solid fa-box-archive"></i>
            </div>
            <a href="{{ Route('retiredInventory') }}" class="small-box-footer">
                Mas Informacion <i class="fas fa-arrow-circle-right"> </i>
            </a>
        </div>
        <div class="small-box bg-gradient-primary">
            <div class="inner">
                <h3>{{ $movement_count }}</h3>
                <p>5.1 Solicitudes Pendientes de Movimientos de Herramientas</p>
            </div>
            <div class="icon">
                <i class="fas fa-fw fa-dolly"></i>
            </div>
            <a href="{{ Route('admin.movement.index') }}" class="small-box-footer">
                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
        <div class="small-box bg-info">
            <div class="inner">

                <h3>{{ $transfer_count }}</h3>
                <p>4.3 Solicitudes Pendientes de Transferencias de Herramientas </p>
            </div>
            <div class="icon">
                <i class="fas fa-right-left"></i>
            </div>
            <a href="{{ Route('transfer') }}" class="small-box-footer">
                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>
