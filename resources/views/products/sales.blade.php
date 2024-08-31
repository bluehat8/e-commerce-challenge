<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Informe de ventas') }}
        </h2>
    </x-slot>

    <style>

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: #fff !important; 
            border-radius: 4px; 
        }

        label{
            color: #666; 
        }
        .dataTables_info{
            color: #666 !important; 
        }

        .dataTables_wrapper .dataTables_filter input {
            background-color: #f9f9f9;
            border: 1px solid #fff !important; 
            border-radius: 4px; 
            color: #e2e8f0 !important;
            padding: 0.375rem 0.75rem;
        }

        .dataTables_wrapper .dataTables_filter label {
            color: #666; 
            font-size: 0.875rem;
            margin-bottom: 0.5rem; 
        }


        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_paginate {
            margin-bottom: 1rem;
        }

        td{
            background-color: #374151 !important;
            color: #A9AAAB !important;
            border: 1px solid gray;
        }
        th{
            background-color: #101726 !important;
            color: #A9AAAB !important;
        }

        thead{
            border-radius: 10px !important;
            border: 1px solid gray;
        }
	</style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <form method="GET" action="{{ route('informes.mostrar') }}" class="mb-8 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
    @csrf
    <div class="flex flex-col gap-6">
        <h2 class="text-lg font-medium text-gray-800 dark:text-gray-200 leading-tight">
            Informe de Ventas del {{ $fechaInicio }} al {{ $fechaFin }}
        </h2>

        <div class="flex gap-4">
            <!-- Fecha de Inicio -->
            <div class="flex-1">
                <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha de Inicio:</label>
                <input type="text" name="fecha_inicio" id="fecha_inicio" class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:ring-blue-400" value="{{ $fechaInicio }}" required>
            </div>

            <!-- Fecha de Fin -->
            <div class="flex-1">
                <label for="fecha_fin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha de Fin:</label>
                <input type="text" name="fecha_fin" id="fecha_fin" class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:ring-blue-400" value="{{ $fechaFin }}" required>
            </div>

            <!-- Generar informe -->
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Acciones</label>
                <button type="submit" style="background-color: #007bff !important;" class="px-4 py-2 w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow-md transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 flex items-center justify-center">
                    Generar Informe
                </button>
            </div>
        </div>
    </div>
</form>



    <div class="p-6 bg-gray-800 mt-5 rounded-lg shadow-md">

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <table id="example" class="table-auto w-full">
                <thead>
                    <tr class="bg-gray-800 text-gray-500">
                        <th class="p-4 border-b">Producto</th>
                        <th class="p-4 border-b">Cantidad Total</th>
                        <th class="p-4 border-b">Ventas Totales</th>
                        <th class="p-4 border-b">Costo Total</th>
                        <th class="p-4 border-b">Impuesto Total</th>
                        <th class="p-4 border-b">Ganancias</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-700">
                    @foreach($ventasPorProducto as $productoId => $datos)
                        @php
                            $producto = App\Models\Product::find($productoId);
                        @endphp
                        <tr class="bg-gray-700">
                            <td class="border px-4 py-2">{{ $producto->nombre }}</td>
                            <td class="border px-4 py-2">{{ $datos['cantidad_total'] }}</td>
                            <td class="border px-4 py-2">${{ number_format($datos['ventas_totales'], 2) }}</td>
                            <td class="border px-4 py-2">${{ number_format($datos['costo_total'], 2) }}</td>
                            <td class="border px-4 py-2">${{ number_format($datos['impuesto_total'], 2) }}</td>
                            <td class="border px-4 py-2">${{ number_format($datos['ganancias'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        </div>


        <div class="p-6 bg-gray-800 mt-5 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-500 mb-4">Totales Generales</h2>
            <p class="flex items-center">
                <span class="font-semibold text-gray-500 mr-2">Ventas Totales:</span>
                <span class="text-green-500">${{ number_format($ventasTotales, 2) }}</span>
            </p>
            <p class="flex items-center">
                <span class="font-semibold text-gray-500 mr-2">Costos Totales:</span>
                <span class="text-green-500">${{ number_format($costosTotales, 2) }}</span>
            </p>
            <p class="flex items-center">
                <span class="font-semibold text-gray-500 mr-2">Impuestos Totales:</span>
                <span class="text-green-500">${{ number_format($impuestosTotales, 2) }}</span>
            </p>
            <p class="flex items-center">
                <span class="font-semibold text-gray-500 mr-2">Ganancias Totales:</span>
                <span class="text-green-500">${{ number_format($gananciasTotales, 2) }}</span>
            </p>
            
        </div>
    </div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            // Add any customization options here
        });
    });
</script>

<script>
        flatpickr("#fecha_inicio", {
            dateFormat: "Y-m-d",
            maxDate: "today"
        });

        flatpickr("#fecha_fin", {
            dateFormat: "Y-m-d",
            maxDate: "today"
        });
</script>

</x-app-layout>
