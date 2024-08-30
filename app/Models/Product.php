<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'costo_fabricacion',
        'impuesto',
        'divisa',
        'stock',
    ];

    public function getPriceInCurrency($currency)
    {
        // Aquí podrías implementar la lógica para convertir el precio según la divisa
        // Por ahora, simplemente retornaremos el precio en la moneda original
        return $this->price;
    }
    
}
