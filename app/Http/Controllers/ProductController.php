<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $productos = Product::all();
        return view('products.products', compact('productos'));
    }

    public function client_index()
    {
        $productos = Product::all();
        return view('product-client.list-products', compact('productos'));
    }


    public function create()
    {
        return view('products.store');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'costo_fabricacion' => 'required|numeric',
            'impuesto' => 'required|numeric',
            'divisa' => 'required|string|max:10',
            'stock' => 'required|integer',
        ]);
    
        // dd($request->all()); 
    
        Product::create($request->all());
    
        // return redirect()->route('products.store')->with('success', 'Producto creado exitosamente.');
    }
    
    public function show(Product $producto)
    {
        return view('productos.show', compact('producto'));
    }

    public function edit(ProductController $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Product $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'costo_fabricacion' => 'required|numeric',
            'impuesto' => 'required|numeric',
            'divisa' => 'required|string|max:10',
            'stock' => 'required|integer',
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Product $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
