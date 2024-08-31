<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Productos') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-5 px-4">
        <div class="flex justify-end mb-4">
            <a href="{{ route('products.create') }}" style="background-color: rgb(21 94 117) !important;" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent custom-green text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">Crear Producto</a>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200 dark:divide-neutral-700">
                <thead class="border-b border-gray-100 dark:border-neutral-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-gray-600">Nombre</th>
                        <th class="px-6 py-3 text-left text-gray-600">Descripción</th>
                        <th class="px-6 py-3 text-left text-gray-600">Precio</th>
                        <th class="px-6 py-3 text-left text-gray-600">Costo de Fabricación</th>
                        <th class="px-6 py-3 text-left text-gray-600">Impuesto</th>
                        <th class="px-6 py-3 text-left text-gray-600">Divisa</th>
                        <th class="px-6 py-3 text-left text-gray-600">Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                    <tr class="border-b text-gray-600 border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 ">{{ $producto->nombre }}</td>
                        <td class="px-6 py-4">{{ $producto->descripcion }}</td>
                        <td class="px-6 py-4">{{ $producto->precio }} {{ $producto->divisa }}</td>
                        <td class="px-6 py-4">{{ $producto->costo_fabricacion }} {{ $producto->divisa }}</td>
                        <td class="px-6 py-4">{{ $producto->impuesto }} {{ $producto->divisa }}</td>
                        <td class="px-6 py-4">{{ $producto->divisa }}</td>
                        <td class="px-6 py-4">{{ $producto->stock }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> 
</x-app-layout>
