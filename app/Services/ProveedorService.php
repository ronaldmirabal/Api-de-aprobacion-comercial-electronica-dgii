<?php

namespace App\Services;

use App\Models\Empresa;
use App\Models\Proveedor;

class ProveedorService
{


    public function registrarProveedor($arrayARECF)
    {
        $proveedor = Proveedor::where('numero_documento', $arrayARECF['RNCEmisor'])->first();
        if ($proveedor) {
            // Ya existe, retornamos el registro existente
            return response()->json([
                'success' => true,
                'message' => 'Proveedor ya registrado.',
                'proveedor' => $proveedor
            ]);
        }
        $empresa = Empresa::where('rnc', $arrayARECF['RNCComprador'])->first();
        //No existe se registra
        $proveedor = Proveedor::create(
            [
                'numero_documento' => $arrayARECF['RNCEmisor'],
                'razon_social' => $arrayARECF['RazonSocialEmisor'],
                'email' => $arrayARECF['CorreoEmisor'],
                'empresa_id' => $empresa->id
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Proveedor registrado correctamente.',
            'proveedor' => $proveedor
        ]);
    }
}
