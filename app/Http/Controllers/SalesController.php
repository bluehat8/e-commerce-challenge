<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Auth;



class SalesController extends Controller
{

    public function showPurchaseForm($id)
    {
        $producto = Product::find($id);

        return view('product-client.buy', compact('producto'));
    }

    public function comprar(Request $request, $id)
    {
        $producto = Product::find($id);
    
        $request->validate([
            'cantidad' => 'required|integer|min:1|max:' . $producto->stock,
            'divisa' => 'required|string|in:USD,EUR,GBP,JPY',
        ]);
    
        $cantidad = $request->input('cantidad');
        $divisa = $request->input('divisa');
    
        $tasasDeCambio = [
            'USD' => 1,
            'EUR' => 0.9023,
            'GBP' => 0.7588,
            'JPY' => 145.23
        ];
    
        // Tasa de cambio para la divisa original y la seleccionada
        $tasaCambioOriginal = $tasasDeCambio[$producto->divisa] ?? 1;
        $tasaCambioSeleccionada = $tasasDeCambio[$divisa] ?? 1;
    
        // Convertir el precio unitario a USD y luego a la divisa seleccionada
        $precioUnitarioEnUSD = $producto->precio / $tasaCambioOriginal;
        $precioUnitarioEnSeleccionada = $precioUnitarioEnUSD * $tasaCambioSeleccionada;
    
        // Calcular el total sin impuestos
        $precioTotal = $precioUnitarioEnSeleccionada * $cantidad;
    
        $impuestoTotal = ($producto->impuesto / 100) * $precioTotal;
    
        $producto->stock -= $cantidad;
        $producto->save();
    
        Sale::create([
            'product_id' => $producto->id,
            'user_id' => Auth::id(),
            'cantidad' => $cantidad,
            'precio_total' => $precioTotal,
            'impuesto_total' => $impuestoTotal,
            'divisa' => $divisa,
        ]);
    
        return back()->with('success', 'Compra realizada con éxito en ' . $divisa . ' por un total de ' . number_format($precioTotal + $impuestoTotal, 2) . ' ' . $divisa . ', impuestos incluidos: ' . number_format($impuestoTotal, 2) . ' ' . $divisa);
    }

    // public function generar(Request $request)
    // {
    //     if (Auth::user()->role !== 'admin') {
    //         abort(403, 'Acceso no autorizado.');
    //     }

    //     $fechaInicio = $request->input('fecha_inicio', now()->subDays(7)->startOfDay()->format('Y-m-d'));
    //     $fechaFin = $request->input('fecha_fin', now()->endOfDay()->format('Y-m-d'));

    //     $inicioDelDia = \Carbon\Carbon::parse($fechaInicio)->startOfDay();
    //     $finDelDia = \Carbon\Carbon::parse($fechaFin)->endOfDay();

    //     $ventas = Sale::whereBetween('created_at', [$inicioDelDia, $finDelDia])->get();

    //     $productos = Product::all()->keyBy('id'); 

    //     // Tasas de conversión a USD
    //     $tasasDeCambio = [
    //         'USD' => 1,
    //         'EUR' => 1 / 0.9023,
    //         'GBP' => 1 / 0.7588,
    //         'JPY' => 1 / 145.23
    //     ];

    //     $ventasPorProducto = $ventas->groupBy('product_id')->map(function ($ventasPorProducto) use ($productos, $tasasDeCambio) {
    //         $productoId = $ventasPorProducto->first()->product_id;
    //         $producto = $productos->get($productoId);

    //         $cantidadTotal = $ventasPorProducto->sum('cantidad');
            
    //         // Convertir precios a USD
    //         $divisa = $ventasPorProducto->first()->divisa;
    //         $tasaCambio = $tasasDeCambio[$divisa] ?? 1; 

    //         $ventasTotales = $ventasPorProducto->sum('precio_total') * $tasaCambio;
    //         $costoTotal = $producto->costo_fabricacion * $cantidadTotal * $tasaCambio;
    //         $ganancias = $ventasTotales - $costoTotal;

    //         return [
    //             'cantidad_total' => $cantidadTotal,
    //             'ventas_totales' => $ventasTotales,
    //             'costo_total' => $costoTotal,
    //             'ganancias' => $ganancias
    //         ];
    //     });

    //     $ventasTotales = $ventasPorProducto->sum('ventas_totales');
    //     $costosTotales = $ventasPorProducto->sum('costo_total');
    //     $gananciasTotales = $ventasTotales - $costosTotales;
    //     $impuestosTotales = $ventas->sum('impuesto_total') * ($tasasDeCambio[$ventas->first()->divisa] ?? 1);

    //     return view('products.sales', [
    //         'ventasPorProducto' => $ventasPorProducto,
    //         'ventasTotales' => $ventasTotales,
    //         'costosTotales' => $costosTotales,
    //         'gananciasTotales' => $gananciasTotales,
    //         'impuestosTotales' => $impuestosTotales,
    //         'fechaInicio' => $fechaInicio,
    //         'fechaFin' => $fechaFin
    //     ]);
    // }


    public function generar(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado.');
        }

        $fechaInicio = $request->input('fecha_inicio', now()->subDays(7)->startOfDay()->format('Y-m-d'));
        $fechaFin = $request->input('fecha_fin', now()->endOfDay()->format('Y-m-d'));

        $inicioDelDia = \Carbon\Carbon::parse($fechaInicio)->startOfDay();
        $finDelDia = \Carbon\Carbon::parse($fechaFin)->endOfDay();

        $ventas = Sale::whereBetween('created_at', [$inicioDelDia, $finDelDia])->get();
        $productos = Product::all()->keyBy('id'); 

        $tasasDeCambio = [
            'USD' => 1,
            'EUR' => 1 / 0.9023,
            'GBP' => 1 / 0.7588,
            'JPY' => 1 / 145.23
        ];

        $ventasPorProducto = $ventas->groupBy('product_id')->map(function ($ventasPorProducto) use ($productos, $tasasDeCambio) {
            $productoId = $ventasPorProducto->first()->product_id;
            $producto = $productos->get($productoId);

            $cantidadTotal = $ventasPorProducto->sum('cantidad');
            
            // Convertir precios a USD
            $divisa = $ventasPorProducto->first()->divisa;
            $tasaCambio = $tasasDeCambio[$divisa] ?? 1; 

            $impuestoTotalDivisa = $ventasPorProducto->sum('impuesto_total');
            
            $impuestoTotalUSD = $impuestoTotalDivisa * $tasaCambio;

            $ventasTotales = $ventasPorProducto->sum('precio_total') * $tasaCambio;
            $costoTotal = $producto->costo_fabricacion * $cantidadTotal * $tasaCambio;

            // Calcular ganancias restando costos y impuestos
            $ganancias = ($ventasTotales - $impuestoTotalUSD) - $costoTotal;

            return [
                'cantidad_total' => $cantidadTotal,
                'ventas_totales' => $ventasTotales,
                'costo_total' => $costoTotal,
                'ganancias' => $ganancias,
                'impuesto_total' => $impuestoTotalUSD
            ];
        });

        // Sumar los totales generales
        $ventasTotales = $ventasPorProducto->sum('ventas_totales');
        $costosTotales = $ventasPorProducto->sum('costo_total');
        $gananciasTotales = $ventasPorProducto->sum('ganancias');
        $impuestosTotales = $ventasPorProducto->sum('impuesto_total');

        return view('products.sales', [
            'ventasPorProducto' => $ventasPorProducto,
            'ventasTotales' => $ventasTotales,
            'costosTotales' => $costosTotales,
            'gananciasTotales' => $gananciasTotales,
            'impuestosTotales' => $impuestosTotales,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin
        ]);
    }

}
