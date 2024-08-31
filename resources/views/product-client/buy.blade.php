<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Comprar producto') }}
        </h2>
    </x-slot>

    <div class="container py-4 mx-auto mt-5 p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-200 mb-4">Comprar Producto: {{ $producto->nombre }}</h1>

        <!-- Mostrar mensajes de error -->
        @if ($errors->any())
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success text-green-500">
                {{ session('success') }}
            </div>
            <svg aria-hidden="true" class="w-8 h-8 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
        @endif

        <!-- Formulario de compra -->
        <form method="POST" action="{{ route('ventas.comprar', $producto->id) }}">
            @csrf

            <div class="mb-4">
                <label for="cantidad" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cantidad:</label>
                <input type="number" name="cantidad" id="cantidad" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" value="1" min="1" max="{{ $producto->stock }}" required>
            </div>

            <div class="mb-4">
                <label for="divisa" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Divisa:</label>
                <select name="divisa" id="divisa" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    <option value="USD" data-rate="1" {{ $producto->divisa == 'USD' ? 'selected' : '' }}>USD</option>
                    <option value="EUR" data-rate="0.90" {{ $producto->divisa == 'EUR' ? 'selected' : '' }}>EUR</option>
                    <option value="GBP" data-rate="0.76" {{ $producto->divisa == 'GBP' ? 'selected' : '' }}>GBP</option>
                    <option value="JPY" data-rate="145.23" {{ $producto->divisa == 'JPY' ? 'selected' : '' }}>JPY</option>
                </select>
            </div>

            <div class="mb-4">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Precio unitario: <span id="precioUnitario" class="text-green-500">{{ $producto->precio }}</span></p>
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Impuesto: {{ $producto->impuesto }}%</p>
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Precio total sin impuestos: <span id="precioTotal" class="text-green-500">0</span> </p>
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Impuesto total: <span id="impuestoTotal" class="text-green-500">0</span></p>
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Precio total con impuestos: <span id="precioConImpuesto" class="text-green-500">0</span></p>
            </div>

            <button type="submit" style="background-color: #007bff !important;" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                Comprar
            </button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const precioUnitarioOriginal = parseFloat('{{ $producto->precio }}');
            const impuestoPorcentaje = parseFloat('{{ $producto->impuesto }}');
            const divisaOriginal = '{{ $producto->divisa }}'; // Divisa original del producto

            const cantidadInput = document.getElementById('cantidad');
            const divisaSelect = document.getElementById('divisa');
            const precioUnitarioElem = document.getElementById('precioUnitario');
            const precioTotalElem = document.getElementById('precioTotal');
            const impuestoTotalElem = document.getElementById('impuestoTotal');
            const precioConImpuestoElem = document.getElementById('precioConImpuesto');
            const divisaTotalElem = document.getElementById('divisaTotal');

            const tasasDeCambio = {
                'USD': 1,
                'EUR': 0.9023,
                'GBP': 0.7588,
                'JPY': 145.23
            };

            function obtenerTasaCambio(divisa) {
                return tasasDeCambio[divisa] || 1;
            }

            function actualizarPrecios() {
                const cantidad = parseInt(cantidadInput.value);
                const divisaSeleccionada = divisaSelect.value;
                
                const tasaCambioOriginal = obtenerTasaCambio(divisaOriginal);
                const tasaCambioSeleccionada = obtenerTasaCambio(divisaSeleccionada);

                // Convertir el precio unitario de la divisa original a USD
                const precioUnitarioEnUSD = precioUnitarioOriginal / tasaCambioOriginal;

                // Convertir el precio unitario en USD a la divisa seleccionada
                const precioUnitarioEnSeleccionada = precioUnitarioEnUSD * tasaCambioSeleccionada;

                const precioTotal = precioUnitarioEnSeleccionada * cantidad;
                const impuestoTotal = (impuestoPorcentaje / 100) * precioTotal;
                const precioConImpuesto = precioTotal + impuestoTotal;

                // Actualizar el contenido con los valores convertidos
                precioUnitarioElem.textContent = `${precioUnitarioEnSeleccionada.toFixed(2)} ${divisaSeleccionada}`;
                precioTotalElem.textContent = `${precioTotal.toFixed(2)} ${divisaSeleccionada}`;
                impuestoTotalElem.textContent = `${impuestoTotal.toFixed(2)} ${divisaSeleccionada}`;
                precioConImpuestoElem.textContent = `${precioConImpuesto.toFixed(2)} ${divisaSeleccionada}`;
                divisaTotalElem.textContent = divisaSeleccionada;
            }

            cantidadInput.addEventListener('input', actualizarPrecios);
            divisaSelect.addEventListener('change', actualizarPrecios);

            // Inicializa los precios al cargar
            actualizarPrecios();
        });
    </script>
</x-app-layout>
