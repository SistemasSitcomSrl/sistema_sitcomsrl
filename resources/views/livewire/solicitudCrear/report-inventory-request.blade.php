<div>
    
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Factura</title>
        <style>
            @page {
                margin: 70px;
            }

            body {
                font-family: Arial, sans-serif;
            
                /* Añadido */
                font-size: 12px;
                /* Reducido el tamaño de fuente */
            }

            .header {
                width: 100%;
                text-align: center;
                margin-bottom: 20px;
            }

            #footer {
               
                position: fixed;
                bottom: -1cm;
                left: 0cm;
                width: 100%;
            }

            .textFooter {
                text-align: left;
                width: 100%;
            }

            .invoice-details {
                border-bottom: 1px solid #ccc;
                padding-bottom: 10px;
                margin-bottom: 20px;
            }

            .invoice-details p {
                margin: 5px 0;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
                font-size: 11px;
                /* Reducido el tamaño de fuente */
            }

            th,
            td {
                padding: 5px;
                /* Reducido el padding para reducir la altura de las filas */
                text-align: left;
                border-bottom: 1px solid #839192;
            }

            th {
                background-color: #D7DBDD;
            }

            .logo-container {
                position: absolute;
                top: 0px;
                left: 0px;
                display: flex;
                align-items: center;
            }

            .logo {
                max-width: 160px;
                max-height: 50px;
                margin-right: 10px;
            }

            .company-info p {
                font-size: 10px;
                /* Reducido el tamaño de fuente */
                margin: 0;
                color: #555;
            }

            .customer-info {
                margin-top: 20px;
                /* Ajusta según sea necesario */
            }

            .customer-info table {
                border-collapse: collapse;
                font-size: 11px;
                /* Reducido el tamaño de fuente */
            }

            .customer-info th,
            .customer-info td {
                padding: 5px;
                /* Reducido el padding para reducir la altura de las filas */
                border-bottom: 1px solid #839192;
            }

            .receipt-number {
                position: absolute;
                top: 0px;
                right: 20px;
                font-size: 14px;
                /* Ajustado el tamaño de fuente */
                font-weight: bold;
            }

            .signature-fields {
                width: 100%;
                height: 60px;
            }

            .signature-column {
                width: 50%;
                height: 60px;
                /* Cada columna toma el 50% del ancho */
                float: left;
                /* Hace que las columnas floten */

            }

            .signature-container {
                text-align: center;             
            }

            .signature-container label {             
                display: block;
            }
        </style>
    </head>

    <body>
        <div class="header">
            <h2>Solicitud Agregar Equipo</h2>
        </div>
        <div id="footer">
            <p class="textFooter">
                Confidencial, elaborado por Sitcom Srl
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Fecha de Impresion <?php echo date('Y-m-d H:i:s'); ?></p>
        </div>
        <div class="receipt-number">
            @foreach ($movements as $movement)
                Nro: {{ $movement->receipt_number }}
            @break
        @endforeach
    </div>
    <div class="logo-container">
        <img class="logo" src="{{ asset('img/logo.png') }}" alt="Logo de la empresa">
        <div class="company-info">
            @foreach ($movements as $movement)
                <p>Dir. {{ $movement->branch_direction }}</p>
                <p>Tel(s). 3 326 0654 - Cel. 74604441</p>
                <p>{{ $movement->branch_name }}</p>
            @break
        @endforeach

    </div>
</div>
<br>
<div class="customer-info">
    <table>
        <tr>
            <th style="text-align: center; font-size: 12px;" colspan="6">Solicitud - Datos de la Sucursal
            </th>
        </tr>
        @foreach ($movements as $movement)
            <tr>
                <th style="text-align: right;">Nombre:</th>
                <td>{{ $movement->user_name }}</td>
                <th style="text-align: right;">Departamento:</th>
                <td>{{ $movement->branch_department }}</td>
                <th style="text-align: right;">Fecha:</th>
                <td>{{ $movement->departure_date }}</td>
            </tr>
            <tr>
                <th style="text-align: right;">Sucursal:</th>
                <td>{{ $movement->branch_name }}</td>
                <th style="text-align: right;">Celular:</th>
                <td>{{ $movement->user_phone_number }}</td>
                <th style="text-align: right;">Hora:</th>
                <td>{{ $movement->departure_time }}</td>
            </tr>
        @break
    @endforeach
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; font-size: 12px;" colspan="9">Detalles de los Equipos
            </th>
        </tr>
        <tr>
            <th>Nro</th>
            <th>Nombre</th>
            <th style=" text-align: center;">Codigo</th>
            <th>Marca</th>            
            <th style=" text-align: center;">Ubicación</th>
            <th>Unidad</th>
            <th>Tipo</th>
            <th style="text-align: center;">Precio(Bs)</th>
            <th style=" text-align: center;">Cantidad</th>
        </tr>
    </thead>
    <tbody>

        {{ $counter = 1 }}
        @foreach ($movements as $movement)
            <tr>
                <td style="text-align: center;">{{ $counter++ }}</td>
                <td>{{ $movement->name_equipment }}</td>
                <td style=" text-align: center;">{{ $movement->bar_Code }}</td>
                <td>{{ $movement->brand }}</td>                
                <td style=" text-align: center;">{{ $movement->location }}</td>
                <td>{{ $movement->unit_measure }}</td>
                <td>{{ $movement    ->type }}</td>
                <td style="text-align: center;">{{ $movement->price }}</td>
                @if ($movement->state_exist)
                    <td style=" text-align: center; color:blue; font-weight: bold">{{ $movement->amount }}
                    </td>
                @else
                    <td style=" text-align: center; color:red; font-weight: bold">{{ $movement->amount }}
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
<div>
    <label style="font-weight: bold">Nota:</label>
    <label>Las herramientas en azul se están aumentando y las rojas son las nuevas que se agregarán.</label>
    <br>
    <label>El presente compromiso aplica para el uso correcto de los equipos o
        heramientas.</label>
    <br>
    <label style="font-weight: bold;">FIRMA DE QUIEN AGREGA O INCREMENTA LOS EQUIPOS O HERRAMIENTAS:</label>
</div>
<br><br><br><br><br><br>
<div class="signature-fields">
    @foreach ($movements as $movement)
        <div class="signature-container">
            <label>________________________</label>
            <label>{{ $movement->user_name }}</label>
            <label>{{ $movement->user_company_position }}</label>
        </div>
    @break
@endforeach

</div>
</body>

</html>
</div>
