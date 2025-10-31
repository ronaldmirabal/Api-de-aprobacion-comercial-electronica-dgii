<?php

namespace App\Services;

use App\Models\RecepcionFacturas;

class RecepcionFacturaService
{

    public function registrarFacturas(array $data) {
        $recepcionFactura = RecepcionFacturas::create(
            [
                'empresa_id'             => $data['empresa_id'],
                'proveedor_id'           => $data['proveedor_id'],
                'estado'                 => $data['estado'] ?? null,
                'codigo_motivo_rechazo'  => $data['codigo_motivo_rechazo'] ?? null,
                'monto_total'            => $data['monto_total'] ?? 0.00,
                'total_itbis'            => $data['total_itbis'] ?? 0.00,
                'url_xml'                => $data['url_xml'] ?? null,
            ]);
            return $recepcionFactura;
    }

}