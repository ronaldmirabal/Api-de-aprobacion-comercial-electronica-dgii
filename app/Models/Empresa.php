<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
     use HasFactory;

      protected $fillable = [
        'rnc',
        'razon_social',
        'nombre_comercial',
        'direccion',
        'telefono',
        'email',
        'web',
        'logo_path',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];
}
