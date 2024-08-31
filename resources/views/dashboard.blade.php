<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                <!-- Mostrar contenido solo a administradores -->
                @can('admin')
                    <div class="p-6">
                        <p class="text-2xl font-bold text-center text-white mb-4">
                            <i class="fas fa-user-shield mr-2"></i> Panel Administrador
                        </p>

                        <!-- Sección de Descripción -->
                        <div class="mb-6">
                            <h3 class="text-xl font-semibold text-white mb-4">
                                <i class="fas fa-info-circle mr-2"></i> Descripción
                            </h3>
                            <p class="text-white leading-relaxed">
                                Desde aquí puedes gestionar el catálogo de productos y revisar informes de ventas. Usa las opciones abajo para agregar nuevos productos o consultar los informes de ventas detallados.
                            </p>
                        </div>

                        <!-- Registro de Productos -->
                        <div class="mb-6">
                            <h3 class="text-xl font-semibold text-white mb-4">
                                <i class="fas fa-box-open mr-2"></i> Registrar Productos
                            </h3>
                            <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-900 flex items-center">
                                <i class="fas fa-plus-circle mr-2"></i> Gestionar Productos
                            </a>
                        </div>

                        <!-- Ver Informes -->
                        <div class="mb-6">
                            <h3 class="text-xl font-semibold text-white mb-4">
                                <i class="fas fa-chart-line mr-2"></i> Ver Informes
                            </h3>
                            <a href="{{ route('informes.mostrar') }}" class="text-indigo-600 hover:text-indigo-900 flex items-center">
                                <i class="fas fa-file-alt mr-2"></i> Ver Informes de Ventas
                            </a>
                        </div>
                    </div>
                @endcan

                <!-- Mostrar contenido solo a clientes -->
                @can('cliente')
                    <div class="p-6">
                        <p class="text-2xl font-bold text-center text-white mb-4">
                            <i class="fas fa-shopping-cart mr-2"></i> Panel de Clientes
                        </p>

                        <div class="mb-6">
                            <h3 class="text-xl font-semibold text-white mb-4">
                                <i class="fas fa-box mr-2"></i> Productos Disponibles
                            </h3>
                            <a href="{{ route('pruducts.client') }}" class="text-indigo-600 hover:text-indigo-900 flex items-center">
                                <i class="fas fa-eye mr-2"></i> Ver Productos Disponibles
                            </a>
                        </div>
                    </div>
                @endcan

            </div>
        </div>
    </div>
</x-app-layout>
