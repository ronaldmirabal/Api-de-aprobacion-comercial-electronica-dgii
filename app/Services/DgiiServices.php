<?php

namespace App\Services;

use Carbon\Carbon;
use DOMDocument;
use Selective\XmlDSig\Algorithm;
use Selective\XmlDSig\CryptoSigner;
use Selective\XmlDSig\PrivateKeyStore;
use Selective\XmlDSig\XmlSigner;

class DgiiServices
{
    public function buildArrayARECFToXML($xmlString)
    {
        $xml = simplexml_load_string($xmlString);
        $data = [
            'RNCEmisor' => (string)$xml->Encabezado->Emisor->RNCEmisor,
            'RazonSocialEmisor' => (string)$xml->Encabezado->Emisor->RazonSocialEmisor,
            'NombreComercial' => (string)$xml->Encabezado->Emisor->NombreComercial ?? '',
            'CorreoEmisor' => (string)$xml->Encabezado->Emisor->CorreoEmisor ?? '',
            'RNCComprador' => (string)$xml->Encabezado->Emisor->RNCComprador ?? '',
            'eNCF' => (string)$xml->Encabezado->IdDoc->eNCF,
            'FechaEmision' => (string)$xml->Encabezado->Emisor->FechaEmision,
            'MontoTotal' => (string)$xml->Encabezado->Totales->MontoTotal,
            'RNCComprador' => (string)$xml->Encabezado->Comprador->RNCComprador,
            'Estado' => 0,
            'FechaHoraAcuseRecibo' => Carbon::now('America/Santo_Domingo')->format('d-m-Y H:i:s')
        ];
        return $data;
    }

    public function buildARECFXml($data)
    {
        $dom = new DOMDocument('1.0', 'utf-8');
        $ecf = $dom->createElement('ARECF');
        $dom->appendChild($ecf);

        $detalleAcuseRecibo = $dom->createElement('DetalleAcusedeRecibo');
        $ecf->appendChild($detalleAcuseRecibo);

        $this->addElement($dom, $detalleAcuseRecibo, 'Version', '1.0');
        $this->addElement($dom, $detalleAcuseRecibo, 'RNCEmisor', $data['RNCEmisor'] ?? '');
        $this->addElement($dom, $detalleAcuseRecibo, 'RNCComprador', $data['RNCComprador'] ?? '');
        $this->addElement($dom, $detalleAcuseRecibo, 'eNCF', $data['eNCF'] ?? '');
        $this->addElement($dom, $detalleAcuseRecibo, 'Estado', $data['Estado'] ?? '');
        if ($data['Estado'] == '1') {
            $this->addElement($dom, $detalleAcuseRecibo, 'CodigoMotivoNoRecibido', $data['CodigoMotivoNoRecibido'] ?? '');
        }
        $this->addElement($dom, $detalleAcuseRecibo, 'FechaHoraAcuseRecibo', $data['FechaHoraAcuseRecibo'] ?? '');
        return $dom->saveXML();
    }

    public static function firmarXML(string $certPath, string $password, string $xml): string
    {
        $dom = new DOMDocument();
        $dom->loadXML($xml);
        $privateKeyStore = new PrivateKeyStore();
        if (!file_exists($certPath)) {
            throw new \Exception('El archivo del certificado no existe.');
        }
        $certContent = @file_get_contents($certPath);
        if (!$certContent) {
            throw new \Exception('No se pudo leer el contenido del certificado.');
        }
        if (!openssl_pkcs12_read($certContent, $certs, $password)) {
            throw new \Exception('Error al leer el archivo .p12: ' . openssl_error_string());
        }
        if (empty($certs['pkey']) || empty($certs['cert'])) {
            throw new \Exception('Certificado .p12 inválido: clave privada o certificado faltante.');
        }
        $pem_file_contents = $certs['cert'] . $certs['pkey'];
        $privateKeyStore->loadFromPem($pem_file_contents, $password);
        $privateKeyStore->addCertificatesFromX509Pem($pem_file_contents);


        $algorithm = new Algorithm(Algorithm::METHOD_SHA256);
        $cryptoSigner = new CryptoSigner($privateKeyStore, $algorithm);

        $xmlSigner = new XmlSigner($cryptoSigner);
        $xmlSigner->setReferenceUri('');
        $signedXml = $xmlSigner->signXml($xml);

        return $signedXml;
    }



     private function addElement($dom, $parent, $name, $value)
    {
        if ($value != '') {
            // Escapa el valor para XML (usa ENT_XML1 para compatibilidad estricta con XML)
            $escapedValue = htmlspecialchars($value, ENT_XML1, 'UTF-8');
            $element = $dom->createElement($name, $escapedValue);
        } else {
            $element = $dom->createElement($name);
        }
        $parent->appendChild($element);
    }
}
