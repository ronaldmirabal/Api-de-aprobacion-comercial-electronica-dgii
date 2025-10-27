<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
      protected $fillable = [
        'empresa_id',
        'numero_documento',
        'razon_social',
        'nombre_comercial',
        'direccion',
        'telefono',
        'email',
        'activo',
    ];

     protected $casts = [
        'activo' => 'boolean',
    ];
}
