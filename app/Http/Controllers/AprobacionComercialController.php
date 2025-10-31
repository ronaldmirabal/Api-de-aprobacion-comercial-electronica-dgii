<?php

namespace App\Http\Controllers;

use App\Services\DgiiServices;
use App\Services\ProveedorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AprobacionComercialController extends Controller
{

    protected $_dgiiservices;
    protected $_proveedorservice;
    public function __construct(DgiiServices $dgiiservices, ProveedorService $proveedorService)
    {
        $this->_dgiiservices = $dgiiservices;
        $this->_proveedorservice = $proveedorService;
    }

    public function aprobacion(Request $request)
    {
        try {
            // Obtener el XML del body
            if ($request->hasFile('xml')) {
                Log::info('Solicitud de aprobación comercial recibida', [
                    'ip' => $request->ip()
                ]);
                $file = $request->file('xml');
                $filename = 'ecf_' . time() . '.xml';
                $xmlString = file_get_contents($file->getRealPath());
                $path = $file->storeAs('ecf/aprobaciones', $filename);
                return response(200);
            }
            return response()->json([
                'estado'  => 'ERROR',
                'mensaje' => 'No se recibió archivo XML'
            ], 400);
        } catch (\Exception $e) {
            Log::error('Error en aprobación comercial: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
        }
    }


    public function recepcion(Request $request)
    {
        try {
            if ($request->hasFile('xml')) {
                $file = $request->file('xml');
                $filename = 'ecf_' . time() . '.xml';
                $xmlString = file_get_contents($file->getRealPath());
                //$validarXml = FirmaDigitalHelper::validarFirmaDGII($xml);

                // Guardar en storage/app/ecf/recibidos
                $path = $file->storeAs('ecf/recibidos', $filename);

                // Log para auditoría
                Log::info("e-CF recibido y almacenado en: {$path}");

                $builArrayARECF = $this->_dgiiservices->buildArrayARECFToXML($xmlString);

                //$registrarProveedor = $this->_proveedorservice->registrarProveedor($builArrayARECF); //Se registra el proveedor si no esta registrado


                $buildXml = $this->_dgiiservices->buildARECFXml($builArrayARECF);
                $archivop12 = storage_path(env('URL_CERTIFICADOP12')); //Recordar agregar en el .env la ruta del archivo .p12 del certificado
                $xmlFirmado = $this->_dgiiservices->firmarXML($archivop12, env('FIRMAP12_PASSWORD'), $buildXml);
                // DGII espera un JSON como acuse
                return response($xmlFirmado, 200)
                    ->header('Content-Type', 'application/xml');
            }

            return response()->json([
                'estado'  => 'ERROR',
                'mensaje' => 'No se recibió archivo XML'
            ], 400);
        } catch (\Exception $e) {
            Log::error("Error en recepción e-CF: " . $e->getMessage());

            return response()->json([
                'estado'  => 'ERROR',
                'mensaje' => 'Error interno al procesar XML',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }
}
