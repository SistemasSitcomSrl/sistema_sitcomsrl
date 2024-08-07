<div>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Factura</title>
        <style>
            @page {
                margin: 60px;
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
                font-size: 11px;+
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
            <h2>Reporte de Herramientas</h2>
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
            Nro: <?php $fecha_actual = date('Y-m-d H:i:s'); // Obtener la fecha y hora actual en formato 'Y-m-d H:i:s'
            $fecha_numerica = str_replace(['-', ':', ' '], '', $fecha_actual); // Eliminar guiones, dos puntos y espacios
            echo $fecha_numerica; // Imprimir la fecha y hora en formato numérico ?></p>

        </div>
        <div class="logo-container">
            <img class="logo" src="{{ asset('img/logo.png') }}" alt="Logo de la empresa">
            <div class="company-info">
                <p>Dir. Av. Mariscal Santa Cruz # 6350</p>
                <p>Tel(s). 3 326 0654 - Cel. 74604441</p>
            </div>
        </div>
        <br>
        <div class="customer-info">
            <table>
                <tr>
                    <th style="text-align: center; font-size: 12px;" colspan="6">Datos del Encargado</th>
                </tr>

                <tr>
                    <th style="text-align: right;">Nombre:</th>
                    <td>{{ Auth::user()->name }}</td>
                    <th style="text-align: right;">Cargo Corporativo:</th>
                    <td>{{ Auth::user()->company_position }}</td>
                    <th style="text-align: right;">Sucursal:</th>
                    <td>{{ $nameBranch }}</td>
                </tr>
            </table>

            <table>
                <thead>
                    <tr>
                        <th style="text-align: center; font-size: 12px;" colspan="9">Detalles de las Herramientas
                        </th>
                    </tr>
                    <tr>
                        <th>Nro</th>
                        <th>Nombre</th>
                        <th>Codigo</th>
                        <th>Marca</th>                        
                        <th>Ubicación</th>
                        <th>Unidad</th>
                        <th>Tipo</th>
                        <th>Precio(Bs)</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>

                    {{ $counter = 1 }}
                    @foreach ($movements as $movement)
                        <tr>
                            <td style="text-align: center;">{{ $counter++ }}</td>
                            <td>{{ $movement->name_equipment }}</td>
                            <td>{{ $movement->bar_Code }}</td>
                            <td>{{ $movement->brand }}</td>                            
                            <td>{{ $movement->location }}</td>
                            <td>{{ $movement->unit_measure }}</td>
                            <td>{{ $movement->type }}</td>
                            <td>{{ $movement->price }}</td>
                            <td>{{ $movement->amount }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </body>

    </html>
</div>
