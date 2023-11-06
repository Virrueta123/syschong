<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Greenter\Model\Client\Client;
use Greenter\See;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\XMLSecLibs\Certificate\X509Certificate;
use Greenter\XMLSecLibs\Certificate\X509ContentType;
use Luecano\NumeroALetras\NumeroALetras;
use Greenter\Ws\Services\SunatEndpoints;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\Facades\DataTables;
use Greenter\Model\Voided\Voided;
use Greenter\Model\Voided\VoidedDetail;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Summary\SummaryDetail;
use Greenter\Model\Sale\Document;

class firma_sunat_controller extends Controller
{
    public function firma_digital_produccion()
    {
        $see = new See();
        $see->setCertificate(file_get_contents('keys/certificate.pem'));
        $see->setService(SunatEndpoints::FE_PRODUCCION);
        $see->setClaveSOL('10010667971', 'JUANCARL', 'Juanc1234');

        return $see;
    }

    public function firma_digital_beta()
    {
        $pfx = file_get_contents('keys/certificate.pem'); 

        $see = new See();
        $see->setCertificate($pfx);
        $see->setService(SunatEndpoints::FE_BETA);
        $see->setClaveSOL('20000000001', 'MODDATOS', 'moddatos');
        return $see;
    }

    public function company()
    {
        // Emisor
        $address = (new Address())
            ->setUbigueo('210601')
            ->setDepartamento('SAN MARTIN')
            ->setProvincia('SAN MARTIN')
            ->setDistrito('TARAPOTO')
            ->setUrbanizacion('-')
            ->setDireccion('PJ. UNION 126B LOZA BELAUNDE')
            ->setCodLocal('0000'); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.

        $company = (new Company())
            ->setRuc('10464579481')
            ->setRazonSocial('ROSA LUZ INGA TORRES')
            ->setNombreComercial('ROSA LUZ INGA TORRES')
            ->setAddress($address);

        return $company;
    }
}
