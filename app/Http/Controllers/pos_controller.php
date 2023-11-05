<?php

namespace App\Http\Controllers;

use App\Models\caja_chica;
use App\Models\cliente;
use App\Models\detalle_venta;
use App\Models\empresa;
use App\Models\forma_pago;
use App\Models\image_pago;
use App\Models\pagos_ventas;
use App\Models\producto;
use App\Models\ventas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Storage;
use LengthException;
use Yajra\DataTables\Facades\DataTables;
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
use Greenter\Model\Voided\Voided;
use Greenter\Model\Voided\VoidedDetail;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Summary\SummaryDetail;
use Greenter\Model\Sale\Document;

class pos_controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('caja');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $correlativo_factura = ventas::where('tipo_comprobante', 'F')->max('venta_correlativo');

        if (is_null($correlativo_factura)) {
            $correlativo_factura = 1;
        } else {
            $correlativo_factura++;
        }

        $correlativo_boleta = ventas::where('tipo_comprobante', 'B')->max('venta_correlativo');

        if (is_null($correlativo_boleta)) {
            $correlativo_boleta = 1;
        } else {
            $correlativo_boleta++;
        }

        $correlativo_nota_venta = ventas::where('tipo_comprobante', 'N')->max('venta_correlativo');

        if (is_null($correlativo_boleta)) {
            $correlativo_nota_venta = 1;
        } else {
            $correlativo_nota_venta++;
        }
        $forma_pago = forma_pago::where('estado', 'A')->get();

        $empresa = empresa::select('ruc', 'celular', 'razon_social', 'direccion', 'ruc')->first();

        return view('modules.pos.create', [
            'empresa' => $empresa,
            'correlativo_factura' => $correlativo_factura,
            'correlativo_boleta' => $correlativo_boleta,
            'correlativo_nota_venta' => $correlativo_nota_venta,
            'forma_pago' => $forma_pago,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $Datax = $request->all();
  
            $caja_chica = caja_chica::where("user_id", auth()->user()->id)->where("is_abierto","Y")->first()->caja_chica_id;

            switch ($Datax['tipo_comprobante']) {
                case 'F':
                    /* ******** generar factura  ************* */

                    /* ******** insertar ventas ************* */

                    $cliente = cliente::find($request->input('cli_id'));

                    //firma sunat
                    $firma = new firma_sunat_controller();

                    $venta = new ventas();
                    $venta->venta_serie = $request->input('serie'); //-
                    $venta->venta_correlativo = $request->input('correlativo'); //-
                    $venta->venta_estado = 'A'; //-
                    $venta->venta_total = $request->input('total'); //-
                    $venta->tipo_comprobante = 'F'; //-
                    $venta->estado = 'A'; //-
                    $venta->MtoOperGravadas = 0;
                    $venta->MtoOperExoneradas = $Datax['total']; //importe total
                    $venta->MtoIGV = 0;
                    $venta->TotalImpuestos = 0;
                    $venta->setValorVenta = $Datax['total']; //importe total;
                    $venta->SubTotal = $Datax['total']; //importe total
                    $venta->MtoImpVenta = $Datax['total']; //importe total
                    $venta->Dni = 0;
                    $venta->Nombre = 'sin data';
                    $venta->Apellido = 'sin data';
                    $venta->ruc =$cliente->cli_ruc;
                    $venta->departamento =$cliente->cli_departamento_ruc;
                    $venta->distrito =$cliente->cli_distrito_ruc;
                    $venta->provincia =$cliente->cli_provincia_ruc;
                    $venta->direccion =$cliente->cli_direccion_ruc;
                    $venta->razon_social =$cliente->cli_razon_social;
                    $venta->fecha_creacion = Carbon::now();
                    $venta->fecha_vencimiento = Carbon::now();
                    $venta->tipo_venta = 'FV';
                    $venta->forma_pago = 'CO';
                    $venta->cli_id = $cliente->cli_id;
                    $venta->caja_chica_id = $caja_chica;
                    $venta->user_id = Auth::id();
                    $created_venta = $venta->save();

                    foreach ($Datax['repuestos'] as $detalle) {
                        $detalleVenta = new detalle_venta();

                        $producto = producto::with(['unidad'])
                            ->where('prod_id', $detalle['prod_id'])
                            ->first();
                        $detalleVenta->CodProducto = $producto->prod_codigo;
                        $detalleVenta->Unidad = $producto->unidad->codigo_unidad;
                        $detalleVenta->tipo = 'p';
                        $detalleVenta->prod_id = $detalle['prod_id'];
                        $detalleVenta->servicios_id = 0;

                        // Set the values for the columns
                        $detalleVenta->Cantidad = (int) $detalle['Cantidad'];
                        $detalleVenta->PorcentajeIgv = 0;
                        $detalleVenta->Igv = 0;
                        $detalleVenta->BaseIgv = $detalle['Importe'];
                        $detalleVenta->TotalImpuestos = 0;
                        $detalleVenta->MtoValorVenta = $detalle['Importe'];
                        $detalleVenta->MtoValorUnitario = $detalle['Precio'];
                        $detalleVenta->MtoPrecioUnitario = $detalle['Precio'];
                        $detalleVenta->venta_id = $venta->venta_id;
                        $detalleVenta->Descripcion = $detalle['Descripcion'];
                        $detalleVenta->TipAfeIgv = 20;
                        $detalleVenta->save();
                    }

                    if ($created_venta) {
                        /* *********************** */

                        foreach ($Datax['pagos'] as $pago) {
                            if ($pago['url'] != false) {
                                $pagosVentas = new pagos_ventas();
                                $pagosVentas->ventas_id = $venta->venta_id;
                                $pagosVentas->fecha_pago = Carbon::now();
                                $pagosVentas->monto = $pago['monto'];
                                $pagosVentas->forma_pago_id = $pago['forma_pago_id'];
                                $pagosVentas->referencia = $pago['referencia'];
                                $pagosVentas->imagen = 'Y';
                                $pagosVentas->caja_chica_id = $caja_chica;
                                $pagosVentas->user_id = Auth::id();
                                $pagosVentas->save();

                                /* ******** insertar imagen al pago ************* */
                                $base64Data = $pago['url'];
                                $decodedData = base64_decode($base64Data);
                                $filename = Carbon::now()->format('Ymdhis') . '.jpg'; // Set the desired filename here
                                $path = 'fotos_pagos/' . $filename;
                                $add = Storage::disk('local')->put('public/' . $path, $decodedData);

                                if ($add) {
                                    $imagePago = new image_pago();
                                    $imagePago->url = $path;
                                    $imagePago->pagos_ventas_id = $pagosVentas->pagos_ventas_id;
                                    $imagePago->save();
                                }
                                /* *********************** */
                            } else {
                                $pagosVentas = new pagos_ventas();
                                $pagosVentas->ventas_id = $venta->venta_id;
                                $pagosVentas->fecha_pago = Carbon::now();
                                $pagosVentas->monto = $pago['monto'];
                                $pagosVentas->forma_pago_id = $pago['forma_pago_id'];
                                $pagosVentas->referencia = $pago['referencia'];
                                $pagosVentas->imagen = 'Y';
                                $pagosVentas->caja_chica_id = $caja_chica;
                                $pagosVentas->user_id = Auth::id();
                                $pagosVentas->save();
                            }
                        }

                        // Cliente
                        $client = (new Client())
                            ->setTipoDoc('6')
                            ->setNumDoc($venta->ruc)
                            ->setRznSocial($venta->razon_social);

                        // Venta
                        $invoice = (new Invoice())
                            ->setUblVersion('2.1')
                            ->setTipoOperacion('0101') // Venta - Catalog. 51
                            ->setTipoDoc('01') // Factura - Catalog. 01
                            ->setSerie($request->input('serie'))
                            ->setCorrelativo($request->input('correlativo'))
                            ->setFechaEmision(new \DateTime()) // Zona horaria: Lima
                            ->setFormaPago(new FormaPagoContado()) // FormaPago: Contado
                            ->setTipoMoneda('PEN') // Sol - Catalog. 02
                            ->setCompany($firma->company())
                            ->setClient($client)
                            ->setMtoOperExoneradas($Datax['total'])
                            ->setMtoIGV(0)
                            ->setTotalImpuestos(0)
                            ->setValorVenta($Datax['total'])
                            ->setSubTotal($Datax['total'])
                            ->setMtoImpVenta($Datax['total']);

                        $SaleDetail = [];

                        $detalle_servicio = [];

                        foreach ($Datax['repuestos'] as $detalle) {
                            $setCodProducto = '';
                            $setUnidad = '';

                            $producto = producto::with(['unidad'])
                                ->where('prod_id', $detalle['prod_id'])
                                ->first();
                            $setCodProducto = $producto->prod_codigo;
                            $setUnidad = $producto->unidad->codigo_unidad;

                            array_push(
                                $SaleDetail,
                                (new SaleDetail())
                                    ->setCodProducto($setCodProducto)
                                    ->setUnidad($setUnidad)
                                    ->setCantidad(intval($detalle['Cantidad']))
                                    ->setDescripcion($detalle['Descripcion'])
                                    ->setMtoBaseIgv($detalle['Importe'])
                                    ->setPorcentajeIgv(0)
                                    ->setIgv(0)
                                    ->setTipAfeIgv('20')
                                    ->setTotalImpuestos(0)
                                    ->setMtoValorVenta($detalle['Importe'])
                                    ->setMtoValorUnitario($detalle['Precio'])
                                    ->setMtoPrecioUnitario($detalle['Precio']),
                            );
                        }

                        $formatter = new NumeroALetras();

                        $deletreo = 'SON: ' . $formatter->toWords($Datax['total']) . ' Y 00/100 SOLES';

                        $legend = (new Legend())
                            ->setCode('1000') // Monto en letras - Catalog. 52
                            ->setValue($deletreo);

                        $invoice->setDetails($SaleDetail)->setLegends([$legend]);

                        $see = env('APP_ENV') == 'local' ? $firma->firma_digital_beta() : $firma->firma_digital_produccion();

                        //guardar en los archivos
                        $result = $see->send($invoice);

                        // Guardar XML firmado digitalmente.
                        Storage::disk('local')->put('public/comprobantes/facturas/' . $invoice->getName() . '.xml', $see->getFactory()->getLastXml());

                        // Verificamos que la conexión con SUNAT fue exitosa.
                        if (!$result->isSuccess()) {
                            // Mostrar error al conectarse a SUNAT.

                            $factura = ventas::find($venta->venta_id);
                            $factura->venta_estado = 'R';
                            $factura->estado = 'R';
                            $factura->codigo_error = $result->getError()->getCode();
                            $factura->error = $result->getError()->getMessage();
                            $factura->save();

                            return response()->json([
                                'message' => 'error del servidor',
                                'error' => 'Codigo Error: ' . $result->getError()->getCode() . ' Mensaje Error: ' . $result->getError()->getMessage(),
                                'success' => false,
                                'data' => encrypt_id($venta->venta_id),
                            ]);
                            exit();
                        }

                        // Guardamos el CDR
                        Storage::disk('local')->put('public/comprobantes/facturas/R-' . $invoice->getName() . '.zip', $result->getCdrZip());

                        $cdr = $result->getCdrResponse();

                        $code = (int) $cdr->getCode();

                        if ($code === 0) {
                            $factura = ventas::find($venta->venta_id);
                            $factura->venta_estado = 'A';
                            $factura->estado = 'A';
                            $factura->save();

                            return response()->json([
                                'message' => $cdr->getDescription(),
                                'error' => '',
                                'success' => true,
                                'data' => encrypt_id($venta->venta_id),
                            ]);

                            if (count($cdr->getNotes()) > 0) {
                                dump('OBSERVACIONES:' . PHP_EOL);
                                // Corregir estas observaciones en siguientes emisiones.
                                dump($cdr->getNotes());
                            }
                        } elseif ($code >= 2000 && $code <= 3999) {
                            $this->dispatchBrowserEvent('error_mensaje', 'ESTADO: RECHAZADA');
                        } else {
                            /* Esto no debería darse, pero si ocurre, es un CDR inválido que debería tratarse como un error-excepción. */
                            /*code: 0100 a 1999 */
                            dump('Excepción');
                        }
                    } else {
                        return response()->json([
                            'message' => 'error del servidor',
                            'error' => 'error al registrar la factura',
                            'success' => false,
                            'data' => '',
                        ]);
                    }

                    /* *********************** */
                    break;
                case 'B':
                    /* ******** generar boleta ************* */
                    /* ******** insertar ventas ************* */

                    $cliente = cliente::find($request->input('cli_id'));

                     

                    //firma sunat
                    $firma = new firma_sunat_controller();

                    $venta = new ventas();
                    $venta->venta_serie = $request->input('serie'); //-
                    $venta->venta_correlativo = $request->input('correlativo'); //-
                    $venta->venta_estado = 'A'; //-
                    $venta->venta_total = $request->input('total'); //-
                    $venta->tipo_comprobante = 'B'; //-
                    $venta->estado = 'A'; //-
                    $venta->MtoOperGravadas = 0;
                    $venta->MtoOperExoneradas = $Datax['total']; //importe total
                    $venta->MtoIGV = 0;
                    $venta->TotalImpuestos = 0;
                    $venta->setValorVenta = $Datax['total']; //importe total;
                    $venta->SubTotal = $Datax['total']; //importe total
                    $venta->MtoImpVenta = $Datax['total']; //importe total
                    $venta->Dni = $cliente->cli_dni;
                    $venta->Nombre = $cliente->cli_nombre;
                    $venta->Apellido = $cliente->cli_apellido;
                    $venta->ruc = 'no tiene';
                    $venta->departamento = 'no tiene';
                    $venta->distrito = 'no tiene';
                    $venta->provincia = 'no tiene';
                    $venta->direccion = $cliente->cli_direccion;
                    $venta->razon_social = 'no tiene';
                    $venta->fecha_creacion = Carbon::now();
                    $venta->fecha_vencimiento = Carbon::now();
                    $venta->tipo_venta = 'BV';
                    $venta->forma_pago = 'CO';
                    $venta->cli_id = $cliente->cli_id;
                    $venta->caja_chica_id = $caja_chica;
                    $venta->user_id = Auth::id();
                    $created_venta = $venta->save();

                    foreach ($Datax['repuestos'] as $detalle) {
                        $detalleVenta = new detalle_venta();

                        $producto = producto::with(['unidad'])
                            ->where('prod_id', $detalle['prod_id'])
                            ->first();
                        $detalleVenta->CodProducto = $producto->prod_codigo;
                        $detalleVenta->Unidad = $producto->unidad->codigo_unidad;
                        $detalleVenta->tipo = 'p';
                        $detalleVenta->prod_id = $detalle['prod_id'];
                        $detalleVenta->servicios_id = 0;

                        // Set the values for the columns
                        $detalleVenta->Cantidad = (int) $detalle['Cantidad'];
                        $detalleVenta->PorcentajeIgv = 0;
                        $detalleVenta->Igv = 0;
                        $detalleVenta->BaseIgv = $detalle['Importe'];
                        $detalleVenta->TotalImpuestos = 0;
                        $detalleVenta->MtoValorVenta = $detalle['Importe'];
                        $detalleVenta->MtoValorUnitario = $detalle['Precio'];
                        $detalleVenta->MtoPrecioUnitario = $detalle['Precio'];
                        $detalleVenta->venta_id = $venta->venta_id;
                        $detalleVenta->Descripcion = $detalle['Descripcion'];
                        $detalleVenta->TipAfeIgv = 20;
                        $detalleVenta->save();
                    }

                    if ($created_venta) {
                        /* *********************** */
                       
                        foreach ($Datax['pagos'] as $pago) {
                            if ($pago['url'] != false) {
                                $pagosVentas = new pagos_ventas();
                                $pagosVentas->ventas_id = $venta->venta_id;
                                $pagosVentas->fecha_pago = Carbon::now();
                                $pagosVentas->monto = $pago['monto'];
                                $pagosVentas->forma_pago_id = $pago['forma_pago_id'];
                                $pagosVentas->referencia = $pago['referencia'];
                                $pagosVentas->imagen = 'Y';
                                $pagosVentas->caja_chica_id = $caja_chica;
                                $pagosVentas->user_id = Auth::id();
                                $pagosVentas->save();

                                /* ******** insertar imagen al pago ************* */
                                $base64Data = $pago['url'];
                                $decodedData = base64_decode($base64Data);
                                $filename = Carbon::now()->format('Ymdhis') . '.jpg'; // Set the desired filename here
                                $path = 'fotos_pagos/' . $filename;
                                $add = Storage::disk('local')->put('public/' . $path, $decodedData);

                                if ($add) {
                                    $imagePago = new image_pago();
                                    $imagePago->url = $path;
                                    $imagePago->pagos_ventas_id = $pagosVentas->pagos_ventas_id;
                                    $imagePago->save();
                                }
                                /* *********************** */
                            } else {
                                $pagosVentas = new pagos_ventas();
                                $pagosVentas->ventas_id = $venta->venta_id;
                                $pagosVentas->fecha_pago = Carbon::now();
                                $pagosVentas->monto = $pago['monto'];
                                $pagosVentas->forma_pago_id = $pago['forma_pago_id'];
                                $pagosVentas->referencia = $pago['referencia'];
                                $pagosVentas->imagen = 'Y';
                                $pagosVentas->caja_chica_id = $caja_chica;
                                $pagosVentas->user_id = Auth::id();
                                $pagosVentas->save();
                            }
                        }

                        // Cliente
                        $client = new Client();
                        $client
                            ->setTipoDoc('1')
                            ->setNumDoc($venta->dni)
                            ->setRznSocial($venta->Nombre . ' ' . $venta->Apellido);

                        // Venta
                        $invoice = (new Invoice())
                            ->setUblVersion('2.1')
                            ->setTipoOperacion('0101') // Venta - Catalog. 51
                            ->setTipoDoc('03') // Factura - Catalog. 01
                            ->setSerie($request->input('serie'))
                            ->setCorrelativo($request->input('correlativo'))
                            ->setFechaEmision(new \DateTime()) // Zona horaria: Lima
                            ->setTipoMoneda('PEN') // Sol - Catalog. 02
                            ->setClient($client)
                            ->setMtoOperExoneradas($Datax['total'])
                            ->setMtoIGV(0.0)
                            ->setTotalImpuestos(0.0)
                            ->setValorVenta($Datax['total'])
                            ->setSubTotal($Datax['total'])
                            ->setMtoImpVenta($Datax['total'])
                            ->setCompany($firma->company());

                        $SaleDetail = [];

                        $detalle_servicio = [];

                        foreach ($Datax['repuestos'] as $detalle) {
                            $setCodProducto = '';
                            $setUnidad = '';

                            $producto = producto::with(['unidad'])
                                ->where('prod_id', $detalle['prod_id'])
                                ->first();
                            $setCodProducto = $producto->prod_codigo;
                            $setUnidad = $producto->unidad->codigo_unidad;

                            array_push(
                                $SaleDetail,
                                (new SaleDetail())
                                    ->setCodProducto($setCodProducto)
                                    ->setUnidad($setUnidad)
                                    ->setCantidad(intval($detalle['Cantidad']))
                                    ->setDescripcion($detalle['Descripcion'])
                                    ->setMtoBaseIgv($detalle['Importe'])
                                    ->setPorcentajeIgv(0)
                                    ->setIgv(0)
                                    ->setTipAfeIgv('20')
                                    ->setTotalImpuestos(0)
                                    ->setMtoValorVenta($detalle['Importe'])
                                    ->setMtoValorUnitario($detalle['Precio'])
                                    ->setMtoPrecioUnitario($detalle['Precio']),
                            );
                        }

                        $formatter = new NumeroALetras();

                        $deletreo = 'SON: ' . $formatter->toWords($Datax['total']) . ' Y 00/100 SOLES';

                        $legend = (new Legend())
                            ->setCode('1000') // Monto en letras - Catalog. 52
                            ->setValue($deletreo);

                        $invoice->setDetails($SaleDetail)->setLegends([$legend]);

                        $see = env('APP_ENV') == 'local' ? $firma->firma_digital_beta() : $firma->firma_digital_produccion();

                        //guardar en los archivos
                        $result = $see->send($invoice);

                        // Guardar XML firmado digitalmente.
                        Storage::disk('local')->put('public/comprobantes/boletas/' . $invoice->getName() . '.xml', $see->getFactory()->getLastXml());

                        // Verificamos que la conexión con SUNAT fue exitosa.
                        if (!$result->isSuccess()) {
                            // Mostrar error al conectarse a SUNAT.

                            $comprobante = ventas::find($venta->venta_id);
                            $comprobante->venta_estado = 'R';
                            $comprobante->estado = 'R';
                            $comprobante->codigo_error = $result->getError()->getCode();
                            $comprobante->error = $result->getError()->getMessage();
                            $comprobante->save();

                            return response()->json([
                                'message' => 'error la boleta no se pudo enviar a sunat',
                                'error' => 'Codigo Error: ' . $result->getError()->getCode() . ' Mensaje Error: ' . $result->getError()->getMessage(),
                                'success' => false,
                                'data' => encrypt_id($venta->venta_id),
                            ]);
                            exit();
                        }

                        // Guardamos el CDR
                        Storage::disk('local')->put('public/comprobantes/boletas/R-' . $invoice->getName() . '.zip', $result->getCdrZip());

                        $cdr = $result->getCdrResponse();

                        $code = (int) $cdr->getCode();

                        if ($code === 0) {
                            $comprobante = ventas::find($venta->venta_id);
                            $comprobante->venta_estado = 'A';
                            $comprobante->estado = 'A';
                            $comprobante->save();

                            return response()->json([
                                'message' => $cdr->getDescription(),
                                'error' => '',
                                'success' => true,
                                'data' =>encrypt_id($venta->venta_id),
                            ]);

                            if (count($cdr->getNotes()) > 0) {
                                dump('OBSERVACIONES:' . PHP_EOL);
                                // Corregir estas observaciones en siguientes emisiones.
                                dump($cdr->getNotes());
                            }
                        } elseif ($code >= 2000 && $code <= 3999) {
                            $this->dispatchBrowserEvent('error_mensaje', 'ESTADO: RECHAZADA');
                        } else {
                            /* Esto no debería darse, pero si ocurre, es un CDR inválido que debería tratarse como un error-excepción. */
                            /*code: 0100 a 1999 */
                            dump('Excepción');
                        }
                    } else {
                        return response()->json([
                            'message' => 'error del servidor',
                            'error' => 'error al registrar el comprobante',
                            'success' => false,
                            'data' => '',
                        ]);
                    }
                    /* *********************** */
                    break;
                case 'N':
                    /* ******** generar boleta ************* */
                    /* ******** insertar ventas ************* */

                    $cliente = cliente::find($request->input('cli_id'));

                    //firma sunat
                    $firma = new firma_sunat_controller();

                    $venta = new ventas();
                    $venta->venta_serie = $request->input('serie'); //-
                    $venta->venta_correlativo = $request->input('correlativo'); //-
                    $venta->venta_estado = 'A'; //-
                    $venta->venta_total = $request->input('total'); //-
                    $venta->tipo_comprobante = 'N'; //-
                    $venta->estado = 'A'; //-
                    $venta->MtoOperGravadas = 0;
                    $venta->MtoOperExoneradas = $Datax['total']; //importe total
                    $venta->MtoIGV = 0;
                    $venta->TotalImpuestos = 0;
                    $venta->setValorVenta = $Datax['total']; //importe total;
                    $venta->SubTotal = $Datax['total']; //importe total
                    $venta->MtoImpVenta = $Datax['total']; //importe total
                    $venta->Dni = $cliente->cliente->cli_dni;
                    $venta->Nombre = $cliente->cli_nombre;
                    $venta->Apellido = $cliente->cli_apellido;
                    $venta->ruc = 'no tiene';
                    $venta->departamento = 'no tiene';
                    $venta->distrito = 'no tiene';
                    $venta->provincia = 'no tiene';
                    $venta->direccion = $cliente->cliente->cli_direccion;
                    $venta->razon_social = 'no tiene';
                    $venta->fecha_creacion = Carbon::now();
                    $venta->fecha_vencimiento = Carbon::now();
                    $venta->tipo_venta = 'NV';
                    $venta->forma_pago = 'CO';
                    $venta->cli_id = $cliente->cli_id;
                    $venta->caja_chica_id = $caja_chica;
                    $venta->user_id = Auth::id();
                    $created_venta = $venta->save();

                    foreach ($Datax['repuestos'] as $detalle) {
                        $detalleVenta = new detalle_venta();

                        $producto = producto::with(['unidad'])
                            ->where('prod_id', $detalle['prod_id'])
                            ->first();
                        $detalleVenta->CodProducto = $producto->prod_codigo;
                        $detalleVenta->Unidad = $producto->unidad->codigo_unidad;
                        $detalleVenta->tipo = 'p';
                        $detalleVenta->prod_id = $detalle['prod_id'];
                        $detalleVenta->servicios_id = 0;

                        // Set the values for the columns
                        $detalleVenta->Cantidad = (int) $detalle['Cantidad'];
                        $detalleVenta->PorcentajeIgv = 0;
                        $detalleVenta->Igv = 0;
                        $detalleVenta->BaseIgv = $detalle['Importe'];
                        $detalleVenta->TotalImpuestos = 0;
                        $detalleVenta->MtoValorVenta = $detalle['Importe'];
                        $detalleVenta->MtoValorUnitario = $detalle['Precio'];
                        $detalleVenta->MtoPrecioUnitario = $detalle['Precio'];
                        $detalleVenta->venta_id = $venta->venta_id;
                        $detalleVenta->Descripcion = $detalle['Descripcion'];
                        $detalleVenta->TipAfeIgv = 20;
                        $detalleVenta->save();
                    }

                    if ($created_venta) {
                        /* *********************** */

                        foreach ($Datax['pagos'] as $pago) {
                            if ($pago['url'] != false) {
                                $pagosVentas = new pagos_ventas();
                                $pagosVentas->ventas_id = $venta->venta_id;
                                $pagosVentas->fecha_pago = Carbon::now();
                                $pagosVentas->monto = $pago['monto'];
                                $pagosVentas->forma_pago_id = $pago['forma_pago_id'];
                                $pagosVentas->referencia = $pago['referencia'];
                                $pagosVentas->imagen = 'Y';
                                $pagosVentas->caja_chica_id = $caja_chica;
                                $pagosVentas->user_id = Auth::id();
                                $pagosVentas->save();

                                /* ******** insertar imagen al pago ************* */
                                $base64Data = $pago['url'];
                                $decodedData = base64_decode($base64Data);
                                $filename = Carbon::now()->format('Ymdhis') . '.jpg'; // Set the desired filename here
                                $path = 'fotos_pagos/' . $filename;
                                $add = Storage::disk('local')->put('public/' . $path, $decodedData);

                                if ($add) {
                                    $imagePago = new image_pago();
                                    $imagePago->url = $path;
                                    $imagePago->pagos_ventas_id = $pagosVentas->pagos_ventas_id;
                                    $imagePago->save();
                                }
                                /* *********************** */
                            } else {
                                $pagosVentas = new pagos_ventas();
                                $pagosVentas->ventas_id = $venta->ventas_id;
                                $pagosVentas->fecha_pago = Carbon::now();
                                $pagosVentas->monto = $pago['monto'];
                                $pagosVentas->forma_pago_id = $pago['forma_pago_id'];
                                $pagosVentas->referencia = $pago['referencia'];
                                $pagosVentas->imagen = 'Y';
                                $pagosVentas->caja_chica_id = $caja_chica;
                                $pagosVentas->user_id = Auth::id();
                                $pagosVentas->save();
                            }
                        }

                        return response()->json([
                            'message' => "Nota de venta creada correctamente",
                            'error' => '',
                            'success' => true,
                            'data' =>encrypt_id($venta->venta_id),
                        ]);
 
                    } else {
                        return response()->json([
                            'message' => 'error del servidor',
                            'error' => 'error al registrar el comprobante',
                            'success' => false,
                            'data' => '',
                        ]);
                    }
                    /* *********************** */
                    break;
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'message' => 'error del servidor',
                'error' => $th->getMessage(),
                'success' => false,
                'data' => '',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
