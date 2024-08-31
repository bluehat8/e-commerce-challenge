<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'user_id',
        'cantidad',
        'precio_total',
        'impuesto_total',
        'divisa',
    ];

    public function producto()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
