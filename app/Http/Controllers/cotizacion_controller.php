<?php

namespace App\Http\Controllers;

use App\Models\accesorios;
use App\Models\accesorios_inventario_detalle;
use App\Models\autorizaciones;
use App\Models\caja_chica;
use App\Models\cotizacion;
use App\Models\cotizacion_image;
use App\Models\cotizacioncotizacion_detalle;
use App\Models\cuentas;
use App\Models\detalle_venta;
use App\Models\empresa;
use App\Models\forma_pago;
use App\Models\image_pago;
use App\Models\inventario_autorizaciones;
use App\Models\inventario_moto;
use App\Models\pagos_ventas;
use App\Models\producto;
use App\Models\servicios;
use App\Models\User;
use App\Models\ventas;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
use Illuminate\Support\Facades\Mail;

class cotizacion_controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except([
            'cotizacion_show_cliente',
            "venta_show_cliente",
            'cotizacion_aprobada',
            // Adicione aqui o nome das rotas que você deseja excluir do middleware "auth"
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function add_cotizacion_image(Request $request){ 
        try{

            $Datax = $request->all();
        
            $created = new cotizacion_image(); 
            $base64Data = $Datax['url_img'];
            $decodedData = base64_decode($base64Data);
            $filename = Carbon::now()->format('Ymdhis') . '.jpg'; // Set the desired filename here
            $path = 'fotos_cotizacion/' . $filename;

            $add = Storage::disk('local')->put('public/' . $path, $decodedData);

            $created->url = $path;
            $created->cotizacion_id = $Datax['cotizacion_id'];

            if($created->save()){  
                return response()->json([
                    'message' => "se inserto correctamente la imagen",
                    'error' => '',
                    'success' => true,
                    'data' => $created,
                ]);
            } else {
                Log::error('no se pudo insertar la imagen');
                return response()->json([
                    'message' => 'no se pudo insertar la imagen',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
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

     public function edit_cotizacion_image(Request $request){
 
        try{

            $Datax = $request->all();
        
            $cotizacion_image = cotizacion_image::where("cotizacion_id",$Datax['cotizacion_id'])->first(); 

            $base64Data = $Datax['url_img'];
            $decodedData = base64_decode($base64Data); // Set the desired filename here
            $path = $cotizacion_image->url;

            $add = Storage::disk('local')->put('public/' . $path, $decodedData);

            $update = cotizacion_image::where("cotizacion_id",$Datax['cotizacion_id'])->first(); 
            $update->url = $path; 

            $cotizacion_image_actualizado = cotizacion_image::where("cotizacion_id",$Datax['cotizacion_id'])->first();
            
            if($update->save()){  
                return response()->json([
                    'message' => "se inserto correctamente la imagen",
                    'error' => '',
                    'success' => true,
                    'data' => $cotizacion_image_actualizado,
                ]);
            } else {
                Log::error('no se pudo insertar la imagen');
                return response()->json([
                    'message' => 'no se pudo insertar la imagen',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
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

    public function index(Request $request)
    {
        $fecha_actual = Carbon::now();
        if ($request->ajax()) {
            $cotizacion = cotizacion::with([
                'inventario' => function ($query) {
                    $query->with([
                        'moto' => function ($query) {
                            $query->with(['cliente']);
                        },
                    ]);
                },
            ])
                ->orderBy('created_at', 'desc')
                ->get();

            return DataTables::of($cotizacion)
                ->addIndexColumn()
                ->addColumn('cliente', function ($Data) {
                    return $Data->inventario->moto->cliente->cli_nombre . ' ' . $Data->inventario->moto->cliente->cli_apellido;
                })
                ->addColumn('moto_placa', function ($Data) {
                    return $Data->inventario->moto->mtx_placa;
                })
                ->addColumn('fecha_creacion', function ($Data) {
                    return Carbon::parse($Data->created_at)->format('d-m-Y');
                })
                ->addColumn('action', static function ($Data) {
                    $cotizacion_id = encrypt_id($Data->cotizacion_id);
                    return view('buttons.cotizacion', ['cotizacion_id' => $cotizacion_id]);
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('modules.cotizacion.index', ['fecha_actual' => $fecha_actual]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        try {
            $mecanicos = User::where('roles_id', 2)->get();
            $get = inventario_moto::with([
                'moto' => function ($query) {
                    $query->with('cliente');
                },
            ])->find(decrypt_id($id));

            if ($get) {
                $accesorios = accesorios_inventario_detalle::with('accesorios')
                    ->where('inventario_moto_id', decrypt_id($id))
                    ->get();
                $autorizaciones = inventario_autorizaciones::with('autorizaciones')
                    ->where('inventario_moto_id', decrypt_id($id))
                    ->get();
                return view('modules.cotizacion.create', ['get' => $get, 'accesorios' => $accesorios, 'autorizaciones' => $autorizaciones, 'id' => $id, 'mecanicos' => $mecanicos]);
            } else {
                return view('errors.404');
            }
        } catch (\Throwable $th) {
            Log::error(json_encode($th->getMessage(), true));

            session()->flash('error', 'error al entrar a esta ruta');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*try {*/
        $Datax = $request->all();

        // Crear una nueva instancia del modelo
        $cotizacion = new cotizacion();

        $correlativo = cotizacion::max('cotizacion_correlativo');
        if (is_null($correlativo)) {
            $correlativo = 1;
        } else {
            $correlativo++;
        }

        // Asignar valores a los campos
        $cotizacion->inventario_moto_id = decrypt_id($Datax['id']);
        $cotizacion->observacion_sta = $Datax['observacion_sta'];
        $cotizacion->total = $Datax['total'];
        $cotizacion->cotizacion_correlativo = $correlativo;
        $cotizacion->total_descuento = $Datax['total_descuento'];
        $cotizacion->user_id = Auth::id(); // ID del usuario relacionado
        $cotizacion->mecanico_id = $Datax['mecanico_id']; // ID del mecánico relacionado
        $cotizacion->trabajo_realizar = $Datax['trabajo_realizar'];
        

        if ($cotizacion->save()) {
            foreach ($Datax['cotizacion'] as $ps) {
                // Crear una nueva instancia del modelo
                $cotizaion_detalle = new cotizacioncotizacion_detalle();

                // Asignar valores a los campos
                $cotizaion_detalle->cotizacion_id = $cotizacion->cotizacion_id; // ID de la cotización relacionada
                $cotizaion_detalle->prod_id = $ps['prod_id']; // ID del producto relacionado
                $cotizaion_detalle->servicios_id = $ps['servicios_id']; // ID del servicio relacionado
                $cotizaion_detalle->tipo = $ps['tipo']; // 'P' para producto, 'S' para servicio, ajusta según sea necesario
                $cotizaion_detalle->Precio = $ps['Precio'];
                $cotizaion_detalle->Importe = $ps['Importe'];
                $cotizaion_detalle->ImporteDescuento = $ps['ImporteDescuento'];
                $cotizaion_detalle->Descuento = $ps['Descuento'];
                $cotizaion_detalle->Descripcion = $ps['Descripcion'];
                $cotizaion_detalle->Codigo = $ps['Codigo'];
                $cotizaion_detalle->Cantidad = $ps['Cantidad'];
                $cotizaion_detalle->ValorDescuento = $ps['ValorDescuento'];
                $cotizaion_detalle->Detalle = $ps['Detalle'];

                // Guardar el registro en la base de datos
                $cotizaion_detalle->save();
            }

            session()->flash('success', 'Registro creado correctamente');
            return redirect()->route('cotizaciones.show', encrypt_id($cotizacion->cotizacion_id));
        } else {
            Log::error('no se pudo registrar la cotizacion');
            session()->flash('error', 'error al registrar en la base de datos');
            return redirect()->route('cotizacion.create', $Datax['id']);
        }
        /*
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            session()->flash('error', 'error al registrar');
            return redirect()->route('cotizacion.create',$Datax['id']);
        }*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $get = cotizacion::with([ 
            'cotizacion_image',
            'inventario' => function ($query) {
                $query->with([
                    'cortesia',
                    'moto' => function ($query) {
                        $query->with(['cliente', 
                        'modelo'=>function ($query) {
                            $query->with(['marca' ]);
                        }
                    ]);
                    },
                    'inventario_autorizaciones' => function ($query) {
                        $query->with(['autorizaciones']);
                    },
                    'accesorios_inventario' => function ($query) {
                        $query->with(['accesorios']);
                    },
                ]);
            }, 
            'mecanico',
            'detalle' => function ($query) {
                $query->with([
                    'servicio',
                    'producto' => function ($query) {
                        $query->with(['unidad']);
                    },
                ]);
            },
        ])->find(decrypt_id($id));
 
  
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

        $accesorios = accesorios::all();
        $autorizaciones = autorizaciones::all();

        $forma_pago = forma_pago::where('estado', 'A')->get();

        $empresa = empresa::select('ruc', 'celular', 'razon_social', 'direccion', 'ruc')->first();

        $fecha = Carbon::now()->format("Y");

        

        if ($get) {
            return view('modules.cotizacion.show', [
                'get' => $get,
                'id' => $id,
                'accesorios' => $accesorios,
                'autorizaciones' => $autorizaciones,
                'empresa' => $empresa,
                'correlativo_factura' => $correlativo_factura,
                'correlativo_boleta' => $correlativo_boleta,
                'forma_pago' => $forma_pago,
                'url_whatsapp' => asset('/') . 'cotizacion/' . $id . '/cliente',
                'url_raiz' => asset('/'),
                'fecha' => $fecha 
            ]);
        } else {
            return view('errors.404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $get = cotizacion::with([
            'inventario' => function ($query) {
                $query->with([
                    'moto' => function ($query) {
                        $query->with(['cliente', 'marca']);
                    },
                ]);
            },
            'mecanico',
            'detalle' => function ($query) {
                $query->with([
                    'servicio',
                    'producto' => function ($query) {
                        $query->with(['unidad']);
                    },
                ]);
            },
        ])->find(decrypt_id($id));

        if ($get) {
            $mecanicos = User::where('roles_id', 2)->get();
            $accesorios = accesorios_inventario_detalle::with('accesorios')
                ->where('inventario_moto_id', decrypt_id($id))
                ->get();
            $autorizaciones = inventario_autorizaciones::with('autorizaciones')
                ->where('inventario_moto_id', decrypt_id($id))
                ->get();
            return view('modules.cotizacion.edit', [
                'get' => $get,
                'accesorios' => $accesorios,
                'autorizaciones' => $autorizaciones,
                'id' => $id,
                'mecanicos' => $mecanicos,
            ]);
        } else {
            return view('errors.404');
        }
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
      
       try {

            $cotizacion = cotizacion::find(decrypt_id($id));
       
            $delete = $cotizacion->delete(); 
            if ($delete) {
                session()->flash('success', 'se elimino correctamente la cotizacion');
                return redirect()->route('taller.index');
            } else {
                session()->flash('success', 'error al eliminar la cotizacion');
                return redirect()->route('taller.index');
            }
         
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'no se creo correctamente la caja');
            return redirect()->route('caja.index');
        }
    }
    //crear boleta
    public function emitir_boleta_cotizacion(Request $request)
    {
        try {
            $caja_chica = caja_chica::where('user_id', auth()->user()->id)
                ->where('is_abierto', 'Y')
                ->first()->caja_chica_id;
            $Datax = $request->all();

            $cotizacion = cotizacion::with([
                'inventario' => function ($query) {
                    $query->with([
                        'moto' => function ($query) {
                            $query->with(['cliente', 'marca']);
                        },
                    ]);
                },
                'mecanico',
                'detalle' => function ($query) {
                    $query->with([
                        'servicio',
                        'producto' => function ($query) {
                            $query->with(['unidad']);
                        },
                    ]);
                },
            ])
                ->where('cotizacion_id', $Datax['cotizacion_id'])
                ->first();

            /* ******** insertar ventas ************* */

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
            $venta->Dni = $cotizacion->inventario->moto->cliente->cli_dni;
            $venta->Nombre = $cotizacion->inventario->moto->cliente->cli_nombre;
            $venta->Apellido = $cotizacion->inventario->moto->cliente->cli_apellido;
            $venta->ruc = 'no tiene';
            $venta->departamento = 'no tiene';
            $venta->distrito = 'no tiene';
            $venta->provincia = 'no tiene';
            $venta->direccion = $cotizacion->inventario->moto->cliente->cli_direccion;
            $venta->razon_social = 'no tiene';
            $venta->fecha_creacion = $Datax['fecha_creacion_boleta'];
            $venta->fecha_vencimiento = $Datax['fecha_creacion_boleta'];
            $venta->tipo_venta = 'BM';
            $venta->forma_pago = 'CO';
            $venta->cli_id = $cotizacion->inventario->moto->cliente->cli_id;
            $venta->caja_chica_id = $caja_chica;
            $venta->user_id = Auth::id();
            $created_venta = $venta->save();

            foreach ($cotizacion->detalle as $cd) {
                if ($cd->aprobar == 'Y') {
                    $detalleVenta = new detalle_venta();
                    if ($cd->tipo == 'p') {
                        $producto = producto::with(['unidad'])
                            ->where('prod_id', $cd->prod_id)
                            ->first();
                        $detalleVenta->CodProducto = $producto->prod_codigo;
                        $detalleVenta->Unidad = $producto->unidad->codigo_unidad;
                        $detalleVenta->tipo = 'p';
                        $detalleVenta->prod_id = $cd->prod_id;
                        $detalleVenta->servicios_id = 0;
                    }

                    if ($cd->tipo == 's') {
                        $servicio = servicios::where('servicios_id', $cd->servicios_id)->first();
                        $detalleVenta->CodProducto = 'SER' . $servicio->servicios_id;
                        $detalleVenta->Unidad = 'ZZ';
                        $detalleVenta->tipo = 's';
                        $detalleVenta->prod_id = 0;
                        $detalleVenta->servicios_id = $cd->servicios_id;
                    }

                    // Set the values for the columns
                    $detalleVenta->Cantidad = (int) $cd->Cantidad;
                    $detalleVenta->PorcentajeIgv = 0;
                    $detalleVenta->Igv = 0;
                    $detalleVenta->BaseIgv = $cd->Importe;
                    $detalleVenta->TotalImpuestos = 0;
                    $detalleVenta->MtoValorVenta = $cd->Importe;
                    $detalleVenta->MtoValorUnitario = $cd->Precio;
                    $detalleVenta->MtoPrecioUnitario = $cd->Precio;
                    $detalleVenta->venta_id = $venta->venta_id;
                    $detalleVenta->Descripcion = $cd->Descripcion;
                    $detalleVenta->TipAfeIgv = 20;
                    $detalleVenta->save();
                }
            }

            if ($created_venta) {
                /* *********************** */

                foreach ($Datax['pagos'] as $pago) {
                    if ($pago['url'] != false) {
                        $pagosVentas = new pagos_ventas();
                        $pagosVentas->ventas_id = $venta->venta_id;
                        $pagosVentas->fecha_pago = $Datax['fecha_creacion_boleta'];
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
                        $pagosVentas->fecha_pago = $Datax['fecha_creacion_boleta'];
                        $pagosVentas->monto = $pago['monto'];
                        $pagosVentas->forma_pago_id = $pago['forma_pago_id'];
                        $pagosVentas->referencia = $pago['referencia'];
                        $pagosVentas->imagen = 'N';
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

                foreach ($cotizacion->detalle as $cd) {
                    if ($cd->aprobar == 'Y') {
                        $setCodProducto = '';
                        $setUnidad = '';

                        if ($cd->tipo == 'p') {
                            $producto = producto::with(['unidad'])
                                ->where('prod_id', $cd->prod_id)
                                ->first();
                            $setCodProducto = $producto->prod_codigo;
                            $setUnidad = $producto->unidad->codigo_unidad;
                        }

                        if ($cd->tipo == 's') {
                            $servicio = servicios::where('servicios_id', $cd->servicios_id)->first();
                            $setCodProducto = 'SER' . $servicio->servicios_id;
                            $setUnidad = 'ZZ';
                        }

                        array_push(
                            $SaleDetail,
                            (new SaleDetail())
                                ->setCodProducto($setCodProducto)
                                ->setUnidad($setUnidad)
                                ->setCantidad(intval($cd->Cantidad))
                                ->setDescripcion($cd->Descripcion)
                                ->setMtoBaseIgv($cd->Importe)
                                ->setPorcentajeIgv(0)
                                ->setIgv(0)
                                ->setTipAfeIgv('20')
                                ->setTotalImpuestos(0)
                                ->setMtoValorVenta($cd->Importe)
                                ->setMtoValorUnitario($cd->Precio)
                                ->setMtoPrecioUnitario($cd->Precio),
                        );
                    }
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

                    $factura = ventas::find($venta->venta_id);
                    $factura->venta_estado = 'R';
                    $factura->estado = 'R';
                    $factura->codigo_error = $result->getError()->getCode();
                    $factura->error = $result->getError()->getMessage();
                    $factura->save();

                    $update = cotizacion::find($cotizacion->cotizacion_id);
                    $update->venta_id = $venta->venta_id;

                    $update->save();

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
                    $factura = ventas::find($venta->venta_id);
                    $factura->venta_estado = 'A';
                    $factura->estado = 'A';
                    $factura->save();

                    $update = cotizacion::find($cotizacion->cotizacion_id);
                    $update->venta_id = $venta->venta_id;

                    $update->save();

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
                    'error' => 'error al registrar la BOLETA',
                    'success' => false,
                    'data' => '',
                ]);
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

    // crear factura

    public function emitir_factura_cotizacion(Request $request)
    {
        try {
            $caja_chica = caja_chica::where('user_id', auth()->user()->id)
                ->where('is_abierto', 'Y')
                ->first()->caja_chica_id;
            $Datax = $request->all();

            $cotizacion = cotizacion::with([
                'inventario' => function ($query) {
                    $query->with([
                        'moto' => function ($query) {
                            $query->with(['cliente', 'marca']);
                        },
                    ]);
                },
                'mecanico',
                'detalle' => function ($query) {
                    $query->with([
                        'servicio',
                        'producto' => function ($query) {
                            $query->with(['unidad']);
                        },
                    ]);
                },
            ])
                ->where('cotizacion_id', $Datax['cotizacion_id'])
                ->first();

            /* ******** insertar ventas ************* */

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
            $venta->ruc = $cotizacion->inventario->moto->cliente->cli_ruc;
            $venta->departamento = $cotizacion->inventario->moto->cliente->cli_departamento_ruc;
            $venta->distrito = $cotizacion->inventario->moto->cliente->cli_distrito_ruc;
            $venta->provincia = $cotizacion->inventario->moto->cliente->cli_provincia_ruc;
            $venta->direccion = $cotizacion->inventario->moto->cliente->cli_direccion_ruc;
            $venta->razon_social = $cotizacion->inventario->moto->cliente->cli_razon_social;
            $venta->fecha_creacion = $Datax['fecha_creacion_factura'];
            $venta->fecha_vencimiento = $Datax['fecha_vencimiento_factura'];
            $venta->tipo_venta = 'FM';
            $venta->forma_pago = 'CO';
            $venta->cli_id = $cotizacion->inventario->moto->cliente->cli_id;
            $venta->caja_chica_id = $caja_chica;
            $venta->user_id = Auth::id();
            $created_venta = $venta->save();

            foreach ($cotizacion->detalle as $cd) {
                if ($cd->aprobar == 'Y') {
                    $detalleVenta = new detalle_venta();
                    if ($cd->tipo == 'p') {
                        $producto = producto::with(['unidad'])
                            ->where('prod_id', $cd->prod_id)
                            ->first();
                        $detalleVenta->CodProducto = $producto->prod_codigo;
                        $detalleVenta->Unidad = $producto->unidad->codigo_unidad;
                        $detalleVenta->tipo = 'p';
                        $detalleVenta->prod_id = $cd->prod_id;
                        $detalleVenta->servicios_id = 0;
                    }

                    if ($cd->tipo == 's') {
                        $servicio = servicios::where('servicios_id', $cd->servicios_id)->first();
                        $detalleVenta->CodProducto = 'SER' . $servicio->servicios_id;
                        $detalleVenta->Unidad = 'ZZ';
                        $detalleVenta->tipo = 's';
                        $detalleVenta->prod_id = 0;
                        $detalleVenta->servicios_id = $cd->servicios_id;
                    }

                    // Set the values for the columns
                    $detalleVenta->Cantidad = (int) $cd->Cantidad;
                    $detalleVenta->PorcentajeIgv = 0;
                    $detalleVenta->Igv = 0;
                    $detalleVenta->BaseIgv = $cd->Importe;
                    $detalleVenta->TotalImpuestos = 0;
                    $detalleVenta->MtoValorVenta = $cd->Importe;
                    $detalleVenta->MtoValorUnitario = $cd->Precio;
                    $detalleVenta->MtoPrecioUnitario = $cd->Precio;
                    $detalleVenta->venta_id = $venta->venta_id;
                    $detalleVenta->Descripcion = $cd->Descripcion;
                    $detalleVenta->TipAfeIgv = 20;
                    $detalleVenta->save();
                }
            }

            if ($created_venta) {
                /* *********************** */

                foreach ($Datax['pagos'] as $pago) {
                    if ($pago['url'] != false) {
                        $pagosVentas = new pagos_ventas();
                        $pagosVentas->ventas_id = $venta->ventas_id;
                        $pagosVentas->fecha_pago = $Datax['fecha_creacion_factura'];
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
                        $pagosVentas->fecha_pago = $Datax['fecha_creacion_factura'];
                        $pagosVentas->monto = $pago['monto'];
                        $pagosVentas->forma_pago_id = $pago['forma_pago_id'];
                        $pagosVentas->referencia = $pago['referencia'];
                        $pagosVentas->imagen = 'N';
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

                foreach ($cotizacion->detalle as $cd) {
                    if ($cd->aprobar == 'Y') {
                        $setCodProducto = '';
                        $setUnidad = '';

                        if ($cd->tipo == 'p') {
                            $producto = producto::with(['unidad'])
                                ->where('prod_id', $cd->prod_id)
                                ->first();
                            $setCodProducto = $producto->prod_codigo;
                            $setUnidad = $producto->unidad->codigo_unidad;
                        }

                        if ($cd->tipo == 's') {
                            $servicio = servicios::where('servicios_id', $cd->servicios_id)->first();
                            $setCodProducto = 'SER' . $servicio->servicios_id;
                            $setUnidad = 'ZZ';
                        }

                        array_push(
                            $SaleDetail,
                            (new SaleDetail())
                                ->setCodProducto($setCodProducto)
                                ->setUnidad($setUnidad)
                                ->setDescripcion($cd->Descripcion)
                                ->setCantidad(intval($cd->Cantidad))
                                ->setMtoValorUnitario($cd->Precio)
                                ->setMtoValorVenta($cd->Importe)
                                ->setMtoBaseIgv($cd->Importe)
                                ->setPorcentajeIgv(0) // 18%
                                ->setIgv(0)
                                ->setTipAfeIgv('20') // Gravado Op. Onerosa - Catalog. 07
                                ->setTotalImpuestos(0)
                                ->setMtoPrecioUnitario($cd->Precio),
                        );
                    }
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

                    $update = cotizacion::find($cotizacion->cotizacion_id);
                    $update->venta_id = $venta->venta_id;
                    $update->save();

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

                    $update = cotizacion::find($cotizacion->cotizacion_id);
                    $update->venta_id = $venta->venta_id;
                    $update->save();

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

    public function pdf($id)
    {
        $cuentas = cuentas::where('estado', 'A')->get();
        $get = cotizacion::with([
            'inventario' => function ($query) {
                $query->with([
                    'moto' => function ($query) {
                        $query->with(['cliente', 'marca']);
                    },
                ]);
            },
            'mecanico',
            'detalle' => function ($query) {
                $query->with([
                    'servicio',
                    'producto' => function ($query) {
                        $query->with(['unidad']);
                    },
                ]);
            },
        ])->find(decrypt_id($id));

        if ($get) {
            $pdf = Pdf::loadView('pdf.cotizacion', ['get' => $get, 'id' => $id, 'cuentas' => $cuentas]);

            return $pdf->stream();
        } else {
            return view('errors.404');
        }
    }

    public function cotizacion_show_cliente($id)
    {
        $get = cotizacion::with([
            'inventario' => function ($query) {
                $query->with([
                    'moto' => function ($query) {
                        $query->with(['cliente', 'marca']);
                    },
                ]);
            },
            'mecanico',
            'detalle' => function ($query) {
                $query->with([
                    'servicio',
                    'producto' => function ($query) {
                        $query->with(['unidad']);
                    },
                ]);
            },
        ])->find(decrypt_id($id));
 
        return view('modules.cotizacion.show_cliente', ['get' => $get]);
    }

    public function venta_show_cliente($venta)
    {
        $cuentas = cuentas::where('estado', 'A')->get();
 
        $get = ventas::with([
            'vendedor',
            'detalle' => function ($query) {
                $query->with([
                    'servicio',
                    'producto' => function ($query) {
                        $query->with(['unidad']);
                    },
                ]);
            },
        ])->find(decrypt_id($venta));

        if ($get) {
            $pdf = Pdf::loadView('pdf.comprobante', ['get' => $get, 'id' => $venta, 'cuentas' => $cuentas]); 
            return $pdf->stream();
        } else {
            return view('errors.404');
        }
    }

    /* ******** cotizacion aprobada whatsapp ************* */
    public function cotizacion_enviada_whatsapp(Request $request)
    {
        try {
            $now = Carbon::now();
            $saludo = 'Buenos días';

            $cotizacion_id = $request->all()['cotizacion_id'];

            $cotizacion = cotizacion::with([
                'inventario' => function ($query) {
                    $query->with([
                        'moto' => function ($query) {
                            $query->with(['cliente']);
                        },
                    ]);
                },
            ])->find($cotizacion_id);

            $update = cotizacion::find($cotizacion_id);

            $update->progreso = 1;
            if ($update->save()) {
                $whatsapp = new whatsapp_api();
                $whatsapp->nombre_cliente = $cotizacion->inventario->moto->cliente->cli_nombre;
                $whatsapp->saludo = $saludo;
                $whatsapp->celular_cliente = $cotizacion->inventario->moto->cliente->cli_telefono;
                $whatsapp->numero_cotizacion = 'C' . $cotizacion->cotizacion_serie . '-' . $cotizacion->cotizacion_correlativo;
                $whatsapp->link_pdf = 'https://ocw.uca.es/pluginfile.php/1491/mod_resource/content/1/El_principe_Maquiavelo.pdf';
                $whatsapp->link_aprobacion = 'cotizacion/' . encrypt_id($cotizacion_id) . '/cliente';

                return response()->json([
                    'message' => $whatsapp->sendMessage(),
                    'error' => '',
                    'success' => true,
                    'data' => '',
                ]);
            } else {
                Log::error('no se pudo registrar la marca de producto');
                return response()->json([
                    'message' => 'no se puedo actualizar la cotizacion a enviada',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
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
    /* *********************** */
    /* ******** cambiar estado de cotizacion ************* */

    public function cotizacion_en_proceso(Request $request)
    {
        try {
            $cotizacion_id = $request->all()['cotizacion_id'];

            $update = cotizacion::find($cotizacion_id);

            $update->progreso = 1;
            if ($update->save()) {
                return response()->json([
                    'message' => 'actualizacion exitosa se cambio a "En proceso"',
                    'error' => '',
                    'success' => true,
                    'data' => '',
                ]);
            } else {
                Log::error('no se pudo registrar la marca de producto');
                return response()->json([
                    'message' => 'no se puedo actualizar la cotizacion a enviada',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
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

    public function pendiente_aprobacion(Request $request)
    {
        try {
            $cotizacion_id = $request->all()['cotizacion_id'];

            $update = cotizacion::find($cotizacion_id);

            $update->progreso = 2;
            if ($update->save()) {
                return response()->json([
                    'message' => 'actualizacion exitosa se cambio a "En proceso"',
                    'error' => '',
                    'success' => true,
                    'data' => '',
                ]);
            } else {
                Log::error('no se pudo registrar la marca de producto');
                return response()->json([
                    'message' => 'no se puedo actualizar la cotizacion a enviada',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
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

    
    public function avisado(Request $request)
    {
        try {
            $cotizacion_id = $request->all()['cotizacion_id'];

            $update = cotizacion::find($cotizacion_id);

            $update->progreso = 5;
            if ($update->save()) {
                return response()->json([
                    'message' => 'actualizacion exitosa se cambio a "Avisado"',
                    'error' => '',
                    'success' => true,
                    'data' => '',
                ]);
            } else {
                Log::error('no se puedo actualizar el estado');
                return response()->json([
                    'message' => 'no se puedo actualizar el estado',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
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
    public function cerrado(Request $request)
    {
        try {
            $cotizacion_id = $request->all()['cotizacion_id'];

            $update = cotizacion::find($cotizacion_id);

            $update->progreso = 6;
            if ($update->save()) {
                return response()->json([
                    'message' => 'actualizacion exitosa se cambio a "Cerrado"',
                    'error' => '',
                    'success' => true,
                    'data' => '',
                ]);
            } else {
                Log::error('no se puedo actualizar el estado');
                return response()->json([
                    'message' => 'no se puedo actualizar el estado',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
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

    public function cotizacion_enviada(Request $request)
    {
        try {
            $cotizacion_id = $request->all()['cotizacion_id'];

            $update = cotizacion::find($cotizacion_id);

            $update->progreso = 1;
            if ($update->save()) {
                return response()->json([
                    'message' => 'actualizacion exitosa',
                    'error' => '',
                    'success' => true,
                    'data' => '',
                ]);
            } else {
                Log::error('no se pudo registrar la marca de producto');
                return response()->json([
                    'message' => 'no se puedo actualizar el estado',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
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

    public function cotizacion_aprobada(Request $request)
    {
        try {
            $cotizacion_id = $request->all()['cotizacion_id'];
            $detalle = $request->all()['detalle'];
            $contador = 0;

            foreach ($detalle as $dt) {
                $contador++;
                $updated = cotizacioncotizacion_detalle::find($dt['cotizacion_detalle_id']);
                $updated->aprobar = $dt['aprobar'] ? 'Y' : 'N';
                $updated->save();
            }

            if (count($detalle) == $contador) {
                $cotizacion_id = $request->all()['cotizacion_id'];
                $update = cotizacion::find($cotizacion_id);
                $update->progreso = 3;
                $update->save();
                return response()->json([
                    'message' => 'se actualizo la cotizacion a aprobada',
                    'error' => '',
                    'success' => true,
                    'data' => '',
                ]);
            } else {
                Log::error('no se puedo actualizar la cotizacion a aprobada');
                return response()->json([
                    'message' => 'no se puedo actualizar la cotizacion a aprobada',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
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
    /* *********************** */

    /* ******** trabajo realizado ************* */

    public function moto_aprobada(Request $request)
    {
        try {
            $cotizacion_id = $request->all()['cotizacion_id'];
            $update = cotizacion::find($cotizacion_id);
            $update->progreso = 4;
            if ($update->save()) {
                return response()->json([
                    'message' => 'Trabajo finalizado',
                    'error' => '',
                    'success' => true,
                    'data' => '',
                ]);
            } else {
                Log::error('no se pudo registrar Trabajo finalizado');
                return response()->json([
                    'message' => 'no se pudo terminar el trabajo',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
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

    /* *********************** */

    /* ******** cotizacion datatables by progreso ************* */
    public function cotizacion_table_vue($progreso)
    {
        $cotizacion = cotizacion::select(DB::raw('*'))
            ->with([
                'mecanico',
                'inventario' => function ($query) {
                    $query->with([
                        'cortesia',
                        'moto' => function ($query) {
                            $query->with(['cliente']);
                        },
                    ]);
                },
            ])
            ->where('progreso', $progreso)
            ->get();

        return DataTables::of($cotizacion)
            ->addColumn('action', static function ($Data) {
                $cotizacion_id = encrypt_id($Data->cotizacion_id);
                return view('buttons.cotizacion', ['cotizacion_id' => $cotizacion_id]);
            })
            ->addColumn('cliente', function ($Data) {
                

                return view("complementos.activacion_cliente",compact("Data"));
                
            })
            ->addColumn('numero', function ($Data) {
               return $Data->cotizacion_serie."-".$Data->cotizacion_correlativo;
            })
            ->addColumn('dnioruc', function ($Data) {
                if(is_null($Data->inventario->moto->cliente)){
                    return "Sin Cliente";
                }else{
                    if ($Data->inventario->moto->cliente->cli_ruc != 'no tiene') {
                        return $Data->inventario->moto->cliente->cli_ruc;
                    } else {
                        if (is_null($Data->inventario->moto->cliente->cli_ruc)) {
                            return $Data->inventario->moto->cliente->cli_dni;
                        } else {
                            return $Data->inventario->moto->cliente->cli_ruc;
                        }
                    }
                }
               
            })
            ->addColumn('mecanico', function ($Data) {
                 
                    if (is_null($Data->mecanico)) {
                        return "Sin Mecanico";
                    } else {
                        return $Data->mecanico->name . ' ' . $Data->mecanico->last_name; 
                    }
            })
            ->addColumn('marca', function ($Data) {
                return $Data->inventario->moto->modelo->marca->marca_nombre;
            })
            ->addColumn('modelo', function ($Data) {
                return $Data->inventario->moto->modelo->modelo_nombre;
            })
            ->addColumn('motor', function ($Data) {
                return $Data->inventario->moto->mtx_motor;
            })
            ->addColumn('vin', function ($Data) {
                return $Data->inventario->moto->mtx_vin;
            })
            ->addColumn('fecha', function ($Data) {
                return Carbon::parse($Data->created_at)->format('d/m/Y');
            })
            ->addColumn('tipo', function ($Data) {
                if ($Data->inventario->cortesia->tipo == 'M') {
                    return 'Mantenimiento particular';
                } else {
                    $title = 'Cortesia';
                    $title_sub = 'N° Cortesia = ' . $Data->inventario->cortesia->numero_corterisa;
                    return view('complementos.title', ['title' => $title, 'title_sub'=>$title_sub]);
                }

                return Carbon::parse($Data->created_at)->format('d/m/Y');
            })
            ->toJson();

        return response()->json(['data' => $cotizacion]);
    }
    /* *********************** */

    /* ******** badge ************* */
    public function badge()
    {
        $emitidos = cotizacion::where('progreso', 0)
            ->get()
            ->count();
        $enviados = cotizacion::where('progreso', 1)
            ->get()
            ->count();
        $aprobados = cotizacion::where('progreso', 2)
            ->get()
            ->count();
        $trabajo_terminado = cotizacion::where('progreso', 3)
            ->get()
            ->count();
        $finalizados = cotizacion::where('progreso', 4)
            ->get()
            ->count();

        $responseData = [
            'emitidos' => $emitidos,
            'enviados' => $enviados,
            'aprobados' => $aprobados,
            'trabajo_terminado' => $trabajo_terminado,
            'finalizados' => $finalizados,
        ];

        return response()->json($responseData);
    }
    /* *********************** */

    /* ******** enviar cotizacion correo ************* */
    public function send_correo_cotizacion(Request $request)
    {
        try {
            
            $destinatario = $request->all()['correo'];
            $ruta = asset('/') . 'cotizacion/' . encrypt_id($request->all()['id'])."/cliente";
            $mensaje = 'Somos de Repuestos & Servicios Chong. Le enviamos esta cotizacion de su moto.Lo puede revisar en la siguiente ruta ';

            $mensaje = Mail::send('pdf.enviar_correo', ['mensaje' => $mensaje,"ruta"=>$ruta], function ($message) use ($destinatario) {
                $message->to($destinatario)->subject('Asunto del mensaje');
            });

            return response()->json([
                'message' => 'se envio el correo',
                'error' => '',
                'success' => true,
                'data' => '',
            ]);
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
    /* *********************** */
}
