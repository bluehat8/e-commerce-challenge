<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Productos disponibles') }}
        </h2>
    </x-slot>

    <div class="container px-4 mx-auto mt-5">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($productos as $producto)
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                    <div class="mb-4">
                        <h5 class="text-xl font-bold text-gray-900 dark:text-gray-200">{{ $producto->nombre }}</h5>
                        <p class="text-gray-700 dark:text-gray-400">{{ $producto->descripcion }}</p>
                    </div>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-200"><strong>Precio:</strong> {{ $producto->precio }} {{ $producto->divisa }}</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-200"><strong>Stock:</strong> {{ $producto->stock }}</p>
                    <a href="{{ route('purchase.form', $producto->id) }}" style="background-color: #007bff !important;" class="mt-4 inline-block px-4 py-2 bg-green-600 text-white font-semibold rounded hover:bg-blue-700">
                        Comprar
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
