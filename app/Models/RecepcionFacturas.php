<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecepcionFacturas extends Model
{
    use HasFactory;
    protected $table = 'recepcion_facturas';

    protected $fillable = [
        'empresa_id',
        'proveedor_id',
        'estado',
        'codigo_motivo_rechazo',
        'monto_total',
        'total_itbis',
        'url_xml',
    ];

     /**
     * Relación con la empresa.
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    /**
     * Relación con el proveedor.
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
}
