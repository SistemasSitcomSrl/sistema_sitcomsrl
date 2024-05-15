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
            <h2>Transferencia de Herramientas</h2>
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
                <p>Dir. {{ $movement->branch_from_direction }}</p>
                <p>Tel(s). 3 326 0654 - Cel. 74604441</p>
                <p>{{ $movement->branch_from_name }}</p>
            @break
        @endforeach

    </div>
</div>
<br>
<div class="customer-info">
    <table>
        <tr>
            <th style="text-align: center; font-size: 12px;" colspan="6">Datos de la Sucursal que Envia</th>
        </tr>
        @foreach ($movements as $movement)
            <tr>
                <th style="text-align: right;">Nombre:</th>
                <td>{{ $movement->user_from_name }}</td>
                <th style="text-align: right;">Departamento:</th>
                <td>{{ $movement->branch_from_department }}</td>
                <th style="text-align: right;">Fecha:</th>
                <td>{{ $movement->departure_date }}</td>
            </tr>
            <tr>
                <th style="text-align: right;">Sucursal:</th>
                <td>{{ $movement->branch_from_name }}</td>
                <th style="text-align: right;">Celular:</th>
                <td>{{ $movement->branch_from_number_phone }}</td>
                <th style="text-align: right;">Hora:</th>
                <td>{{ $movement->departure_time }}</td>
            </tr>
        @break
    @endforeach
</table>

<div class="customer-info">
    <table>
        <tr>
            <th style="text-align: center; font-size: 12px;" colspan="6">Datos de la Sucursal que Recibe
            </th>
        </tr>
        @foreach ($movements as $movement)
            <tr>
                <th style="text-align: right;">Nombre:</th>
                <td>{{ $movement->user_to_name }}</td>
                <th style="text-align: right;">Departamento:</th>
                <td>{{ $movement->branch_to_department }}</td>
                <th style="text-align: right;">Sucursal:</th>
                <td>{{ $movement->branch_to_name }}</td>
            </tr>
        @break
    @endforeach
</table>
</div>
<table>
<thead>
    <tr>
        <th style="text-align: center; font-size: 12px;" colspan="10">Detalles de las Herramientas
            Envidas
        </th>
    </tr>
    <tr>
        <th>Nro</th>
        <th>Nombre</th>
        <th style=" text-align: center;">Codigo</th>
        <th>Marca</th>
        <th>Unidad</th>
        <th style=" text-align: center;">Tipo</th>
        <th style="text-align: center;">Precio(Bs)</th>
        <th style=" text-align: center;">Cantidad</th>
        <th style=" text-align: center;">Devuelto</th>
        <th style=" text-align: center;">Fecha</th>
    </tr>
</thead>
<tbody>

    {{ $counter = 1 }}
    @foreach ($movements as $movement)
        <tr style=" background-color: #d7dbdd37;">
            <td style="text-align: center; font-weight: bold;">{{ $counter++ }}</td>
            <td style="font-weight: bold;">{{ $movement->name_equipment }}</td>
            <td style=" text-align: center; font-weight: bold;">{{ $movement->bar_Code }}</td>
            <td style="font-weight: bold;">{{ $movement->brand }}</td>
            <td style="font-weight: bold;">{{ $movement->unit_measure }}</td>
            <td style=" text-align: center; font-weight: bold;">{{ $movement->type }}</td>
            <td style="text-align: center; font-weight: bold;">{{ $movement->price }}</td>
            <td style=" text-align: center; font-weight: bold;">{{ $movement->missing_amount }}</td>
            @if ($movement->missing_amount == $movement->return_amount)
                <td style=" text-align: center; font-weight: bold; color:green">
                    {{ $movement->return_amount }}</td>
                <td style=" text-align: center; font-weight: bold;">-</td>
            @else
                <td style=" text-align: center; font-weight: bold; color:red">
                    {{ $movement->return_amount }}</td>
                <td style=" text-align: center; font-weight: bold;">-</td>
            @endif

        </tr>

        @php
            $i = 1;
        @endphp

        @foreach ($movements_histories as $record)
            @if ($movement->id_trasnfers == $record->transfer_id)
                <tr>
                    <td style=" text-align: center;">-
                    </td>
                    <td class="px-1 py-1 text-left">Devolucion
                        #{{ $i++ }}
                    </td>
                    <td style="text-align: center;">-
                    </td>
                    <td style="text-align: center;">-
                    </td>
                    <td style="text-align: center;">-
                    </td>
                    <td style="text-align: center;">-
                    </td>
                    <td style="text-align: center;">-
                    </td>
                    <td style="text-align: center;">-
                    </td>
                    <td style="text-align: center;">
                        <div class="text-sm text-gray-900">
                            {{ $record->return_amount }}
                        </div>
                    </td>

                    <td style="text-align: center;">
                        <div class="text-sm text-gray-900">
                            {{ date('d-M', strtotime($record->return_time)) }}
                            {{ date('H:i', strtotime($record->return_time)) }}
                        </div>
                    </td>
                </tr>
            @endif
        @endforeach
    @endforeach
</tbody>
</table>
<div>
<label style="font-weight: bold">Nota:</label>
<label for="">El presente compromiso aplica para el uso correcto de los equipos o
    heramientas.</label>
<br>
<label style="font-weight: bold;">FIRMA DE QUIEN ENVIA Y RECIBE LOS EQUIPOS O HERRAMIENTAS:</label>
</div>
<br><br><br><br><br><br>
<div class="signature-fields">
@foreach ($movements as $movement)
    <div class="signature-column">
        <div class="signature-container">
            <label>________________________</label>
            <label>{{ $movement->user_to_name }}</label>
            <label>{{ $movement->user_to_company_position }}</label>
        </div>
    </div>
@break
@endforeach
@foreach ($movements as $movement)
<div class="signature-column">
    <div class="signature-container">
        <label>________________________</label>
        <label>{{ $movement->user_from_name }}</label>
        <label>{{ $movement->user_from_company_position }}</label>
    </div>
</div>
@break
@endforeach
</div>
</body>

</html>
</div>
