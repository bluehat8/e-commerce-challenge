<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Registrar productos') }}
        </h2>
    </x-slot>

<div class="container">

    @if(session('success'))
        <div class="mx-auto mt-5 px-6">
            <div class="alert alert-success text-green-500">
                {{ session('success') }}
            </div>
            <svg aria-hidden="true" class="w-8 h-8 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
            <div class="hidden sm:flex">
                <x-nav-link style="background-color: rgb(21 94 117) !important;" href="{{ route('products.index') }}" :active="request()->routeIs('products.index')">
                    {{ __('Ver productos') }}
                </x-nav-link>
            </div>
        </div>
        @endif

    <form class="mx-auto mt-5 px-6" method="POST" action="{{ route('products.store') }}">
        @csrf <!-- Protección CSRF -->

        <div class="grid grid-cols-2 gap-4 mb-5">
            <div class="mb-2">
                <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="product name" required />
            </div>
            <div class="mb-2">
                <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                <input type="text" id="descripcion" name="descripcion" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="product description" required />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-5">
            <div class="mb-2">
                <label for="precio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio</label>
                <input type="text" id="precio" name="precio" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="product price" required />
            </div>
            <div class="mb-2">
                <label for="costo_fabricacion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Costo de Fabricación</label>
                <input type="text" id="costo_fabricacion" name="costo_fabricacion" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="fabrication cost" required />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-5">
            <div class="mb-2">
                <label for="impuesto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Impuesto</label>
                <input type="text" id="impuesto" name="impuesto" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="tax" required />
            </div>
            <div class="mb-2">
                <label for="divisa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Divisa</label>
                <select id="divisa" name="divisa" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <option value="GBP">GBP</option>
                    <option value="JPY">JPY</option>
                    <!-- Añade más opciones de divisas aquí -->
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-5">
            <div class="mb-2">
                <label for="stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock</label>
                <input type="number" id="stock" name="stock" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="stock" required />
            </div>
        </div>
    
        <button type="submit" style="background-color: rgb(21 94 117) !important;" class="py-3 px-4 mt-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Registrar nuevo producto</button>
    </form>


</x-app-layout>