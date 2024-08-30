<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                <!-- Mostrar contenido solo a administradores -->
                @can('admin')
                    <p class="text-white text-center">Bienvenido, administrador.</p>
                @endcan

                <!-- Mostrar contenido solo a clientes -->
                @can('cliente')
                    <p class="text-white text-center">Bienvenido, cliente.</p>
                @endcan


                
                <x-welcome />
            </div>
        </div>
    </div>
</x-app-layout>
