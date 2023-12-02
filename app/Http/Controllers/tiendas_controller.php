<?php

namespace App\Http\Controllers;

use App\Models\activacion_precio;
use App\Models\activaciones;
use App\Models\caja_chica;
use App\Models\cortesias_activacion;
use App\Models\detalle_venta;
use App\Models\empresa;
use App\Models\producto;
use App\Models\tienda_detalle_factura;
use App\Models\tienda_facturas;
use App\Models\tiendas;
use App\Models\ventas;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Greenter\Model\Client\Client;
use Greenter\See;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\Cuota;
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
use Greenter\Model\Sale\FormaPagos\FormaPagoCredito;
use Illuminate\Support\Facades\Storage;

class tiendas_controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fecha_actual = Carbon::now();
        if ($request->ajax()) {
            $tiendas = tiendas::orderBy('created_at', 'desc')->get();

            return DataTables::of($tiendas)
                ->addIndexColumn()
                ->addColumn('fecha_creacion', function ($Data) {
                    return Carbon::parse($Data->created_at)->format('d/m/Y');
                })
                ->addColumn('action', static function ($Data) {
                    $tienda_id = encrypt_id($Data->tienda_id);
                    return view('buttons.tiendas', ['tienda_id' => $tienda_id]);
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('modules.tiendas.index', ['fecha_actual' => $fecha_actual]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modules.tiendas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datax = $request->all();
        $tienda = new tiendas();
        $tienda->tienda_nombre = $datax['tienda_nombre'];
        $tienda->tienda_ruc = $datax['tienda_ruc'];
        $tienda->tienda_razon = $datax['tienda_razon'];
        $tienda->tienda_contacto = $datax['tienda_contacto'];
        $tienda->tienda_direccion = $datax['tienda_direccion'];
        $tienda->tienda_provincia = $datax['tienda_provincia'];
        $tienda->tienda_departamento = $datax['tienda_departamento'];
        $tienda->tienda_distrito = $datax['tienda_distrito'];
        $tienda->tienda_correo = $datax['tienda_correo'];
        if ($tienda->save()) {
            /*
            foreach ($datax['precios'] as $precio) {
                // Crear una nueva instancia del modelo
                $activacion_precio = new activacion_precio();

                // Asignar valores a los campos
                $activacion_precio->tienda_id = $tienda->tienda_id; // ID de la cotización relacionada
                $activacion_precio->modelo_id = $precio['modelo_id']; // ID del producto relacionado
                $activacion_precio->precio_activacion = $precio['precio_activacion']; // ID del servicio relacionado
                $activacion_precio->precio_cortesia = $precio['precio_cortesia'];

                // Guardar el registro en la base de datos
                $activacion_precio->save();
            }*/

            session()->flash('success', 'Registro creado correctamente');
            return redirect()->route('tiendas.show', encrypt_id($tienda->tienda_id));
        } else {
            Log::error('no se pudo registrar la tienda');
            session()->flash('error', 'error al registrar en la base de datos');
            return redirect()->route('tiendas.create');
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
        $get = tiendas::with([
            'precios' => function ($query) {
                $query->with([
                    'modelo' => function ($query) {
                        $query->with(['marca']);
                    },
                ]);
            },
        ])->find(decrypt_id($id));

        $activaciones = activaciones::where('is_cobro', 'N')
            ->where('activado_taller', 'A')
            ->where('tienda_id', decrypt_id($id))
            ->get();

        $activaciones_count = count($activaciones);
        $activaciones_cobro = $activaciones->sum('total');

        $cortesias = cortesias_activacion::where('is_cobro', 'N')
            ->where('tipo', 'C')
            ->where('tienda_cobrar', decrypt_id($id))
            ->get();

        $cortesias_count = count($cortesias);
        $cortesias_cobro = $cortesias->sum('precio');

        return view('modules.tiendas.show', compact('get', 'id', 'activaciones_count', 'activaciones_cobro', 'cortesias_count', 'cortesias_cobro'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tienda = tiendas::find(decrypt_id($id));
        return view('modules.tiendas.edit', compact('tienda', 'id'));
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
        $datax = $request->all();
        $tienda = tiendas::find(decrypt_id($id));
        $tienda->tienda_nombre = $datax['tienda_nombre'];
        $tienda->tienda_ruc = $datax['tienda_ruc'];
        $tienda->tienda_razon = $datax['tienda_razon'];
        $tienda->tienda_contacto = $datax['tienda_contacto'];
        $tienda->tienda_direccion = $datax['tienda_direccion'];
        $tienda->tienda_provincia = $datax['tienda_provincia'];
        $tienda->tienda_departamento = $datax['tienda_departamento'];
        $tienda->tienda_distrito = $datax['tienda_distrito'];
        $tienda->tienda_correo = $datax['tienda_correo'];
        if ($tienda->update()) {
            session()->flash('success', 'Registro editado correctamente');
            return redirect()->route('tiendas.show', encrypt_id($tienda->tienda_id));
        } else {
            Log::error('no se pudo editar la tienda');
            session()->flash('error', 'error al editar en la base de datos');
            return redirect()->route('tiendas.create');
        }
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
            $caja = tiendas::findOrFail(decrypt_id($id));

            if ($caja->activaciones()->exists()) {
                session()->flash('warning', 'No se puede eliminar esta tienda por que ya tiene activaciones');
                return redirect()->route('tiendas.index');
            } else {
                $delete = $caja->delete();
                if ($delete) {
                    session()->flash('success', 'se elimino correctamente la tienda');
                    return redirect()->route('tiendas.index');
                } else {
                    session()->flash('success', 'error al eliminar la tienda');
                    return redirect()->route('tiendas.index');
                }
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'no se creo correctamente la caja');
            return redirect()->route('caja.index');
        }
    }

    public function search_tienda(Request $request)
    {
        $keyword = $request->all()['search'];

        $tiendas = tiendas::select(DB::raw('tienda_id AS id'), DB::raw('CONCAT(tienda_razon," - ",tienda_nombre, " - ", tienda_ruc) AS name'))
            ->where(function ($query) use ($keyword) {
                $query->where('tienda_nombre', 'like', '%' . $keyword . '%')->orWhere('tienda_ruc', 'like', '%' . $keyword . '%');
            })
            ->where(function ($query) use ($keyword) {
                $query
                    ->whereNotNull('tienda_nombre') // Asegura que tienda_nombre no sea nulo
                    ->orWhereNotNull('tienda_ruc'); // Asegura que tienda_ruc no sea nulo
            })
            ->limit(9)
            ->get();
        echo json_encode($tiendas);
    }

    public function factura($id)
    {
        $tienda = tiendas::find(decrypt_id($id));

        $correlativo_factura = ventas::where('tipo_comprobante', 'F')->max('venta_correlativo');

        if (is_null($correlativo_factura)) {
            $correlativo_factura = 1;
        } else {
            $correlativo_factura++;
        }

        $empresa = empresa::select('ruc', 'celular', 'razon_social', 'direccion', 'ruc')->first();

        return view('modules.tiendas.factura', [
            'id' => $id,
            'empresa' => $empresa,
            'correlativo_factura' => $correlativo_factura,
            'tienda' => $tienda,
        ]);
    }
    // add factura por tienda cortesia y activaciones
    public function emitir_factura_tienda(Request $request)
    {
        $datax = $request->all();

        /* ******** generar factura  ************* */

        /* ******** insertar ventas ************* */

        $caja_chica = caja_chica::where('user_id', auth()->user()->id)
            ->where('is_abierto', 'Y')
            ->first()->caja_chica_id;
        //firma sunat
        $firma = new firma_sunat_controller();

        $venta = new ventas();
        $venta->venta_serie = 'F003'; //-
        $venta->venta_correlativo = $request->input('correlativo'); //-
        $venta->venta_estado = 'A'; //-
        $venta->venta_total = $request->input('total'); //-
        $venta->tipo_comprobante = 'F'; //-
        $venta->estado = 'A'; //-
        $venta->MtoOperGravadas = 0;
        $venta->MtoOperExoneradas = $datax['total']; //importe total
        $venta->MtoIGV = 0;
        $venta->TotalImpuestos = 0;
        $venta->setValorVenta = $datax['total']; //importe total;
        $venta->SubTotal = $datax['total']; //importe total
        $venta->MtoImpVenta = $datax['total']; //importe total
        $venta->Dni = 0;
        $venta->Nombre = 'sin data';
        $venta->Apellido = 'sin data';
        $venta->ruc = $datax['tienda']['tienda_ruc'];
        $venta->departamento = $datax['tienda']['tienda_departamento'];
        $venta->distrito = $datax['tienda']['tienda_distrito'];
        $venta->provincia = $datax['tienda']['tienda_provincia'];
        $venta->direccion = $datax['tienda']['tienda_direccion'];
        $venta->razon_social = $datax['tienda']['tienda_razon'];
        $venta->fecha_creacion = Carbon::parse($datax['fecha_creacion_factura']);
        $venta->fecha_vencimiento = Carbon::parse($datax['fecha_vencimiento_factura']);
        $venta->tipo_venta = 'FT';
        $venta->forma_pago = 'CR';
        $venta->cli_id = 0;
        $venta->caja_chica_id = $caja_chica;
        $venta->user_id = Auth::id();
        $created_venta = $venta->save();

        $tienda_factura = new tienda_facturas();
        $tienda_factura->venta_id = $venta->venta_id;
        $tienda_factura->tienda_id = $datax['tienda']['tienda_id'];
        $tienda_factura->total = $datax['total'];
        $tienda_factura->save();

        foreach ($datax['detalle'] as $detalle) {
            $detalleVenta = new detalle_venta();
            $tienda_detalle_factura = new tienda_detalle_factura();
            $tienda_detalle_factura->tienda_facturas_id = $tienda_factura->tienda_facturas_id;
            $tienda_detalle_factura->descripcion = $detalle['Descripcion'];
            $tienda_detalle_factura->tipo = $detalle['tipo'];
            $tienda_detalle_factura->precio = $detalle['Precio'];
            $tienda_detalle_factura->cantidad = 1;

            if ($detalle['tipo'] == 'AC') {
                $activaciones = activaciones::with([
                    'moto' => function ($query) {
                        return $query->with([
                            'cliente',
                            'modelo' => function ($query) {
                                return $query->with(['marca']);
                            },
                        ]);
                    },
                    'vendedor',
                    'tienda',
                ])->find($detalle['activaciones_id']);

                $activaciones->is_cobro = 'Y';
                $activaciones->update();

                $tienda_detalle_factura->activaciones_id = $activaciones->activaciones_id;

                $detalleVenta->CodProducto = 'SER' . $detalle['tipo'] . $activaciones->moto->mtx_motor;
                $detalleVenta->Unidad = 'ZZ';
                $detalleVenta->tipo = 's';
                $detalleVenta->prod_id = 0;
                $detalleVenta->servicios_id = 0;

                // Set the values for the columns
                $detalleVenta->Cantidad = 1;
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
            } else {
                $cortesias_activacion = cortesias_activacion::with([
                    'activaciones' => function ($query) {
                        return $query->with([
                            'tienda',
                            'moto' => function ($query) {
                                return $query->with([
                                    'cliente',
                                    'modelo' => function ($query) {
                                        return $query->with(['marca']);
                                    },
                                ]);
                            },
                        ]);
                    },
                ])->find($detalle['cortesias_activacion_id']);

                $cortesias_activacion->is_cobro = 'Y';
                $cortesias_activacion->update();

                $tienda_detalle_factura->cortesia_activacion_id = $detalle['cortesias_activacion_id'];

                $detalleVenta->CodProducto = 'SER' . $detalle['tipo'] . $cortesias_activacion->activaciones->moto->mtx_motor;
                $detalleVenta->Unidad = 'ZZ';
                $detalleVenta->tipo = 's';
                $detalleVenta->prod_id = 0;
                $detalleVenta->servicios_id = 0;

                // Set the values for the columns
                $detalleVenta->Cantidad = 1;
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
            $tienda_detalle_factura->save();
        }

        if ($created_venta) {
            /* *********************** */
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
                ->setSerie('F003')
                ->setCorrelativo($request->input('correlativo'))
                ->setFechaEmision(Carbon::parse($datax['fecha_creacion_factura']))

                // Zona horaria: Lima
                ->setFormaPago(new FormaPagoCredito($datax['total']))
                ->setCuotas([(new Cuota())->setMonto($datax['total'])->setFechaPago(Carbon::parse($datax['fecha_vencimiento_factura']))]) // FormaPago: Contado
                ->setTipoMoneda('PEN') // Sol - Catalog. 02
                ->setCompany($firma->company())
                ->setClient($client)
                ->setMtoOperExoneradas($datax['total'])
                ->setMtoIGV(0)
                ->setTotalImpuestos(0)
                ->setValorVenta($datax['total'])
                ->setSubTotal($datax['total'])
                ->setMtoImpVenta($datax['total']);

            $SaleDetail = [];

            $detalle_servicio = [];

            foreach ($datax['detalle'] as $detalle) {
                $setCodProducto = '';

                if ($detalle['tipo'] == 'AC') {
                    $activaciones = activaciones::with([
                        'moto' => function ($query) {
                            return $query->with([
                                'cliente',
                                'modelo' => function ($query) {
                                    return $query->with(['marca']);
                                },
                            ]);
                        },
                        'vendedor',
                        'tienda',
                    ])->find($detalle['activaciones_id']);

                    $setCodProducto = 'SER' . $detalle['tipo'] . $activaciones->moto->mtx_motor;
                } else {
                    $cortesias_activacion = cortesias_activacion::with([
                        'activaciones' => function ($query) {
                            return $query->with([
                                'tienda',
                                'moto' => function ($query) {
                                    return $query->with([
                                        'cliente',
                                        'modelo' => function ($query) {
                                            return $query->with(['marca']);
                                        },
                                    ]);
                                },
                            ]);
                        },
                    ])->find($detalle['cortesias_activacion_id']);

                    $setCodProducto = 'SER' . $detalle['tipo'] . $cortesias_activacion->activaciones->moto->mtx_motor;
                }

                array_push(
                    $SaleDetail,
                    (new SaleDetail())
                        ->setCodProducto($setCodProducto)
                        ->setUnidad('ZZ')
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

            $deletreo = 'SON: ' . $formatter->toWords($datax['total']) . ' Y 00/100 SOLES';

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
                    'data' => encrypt_id($datax['tienda']["tienda_id"]),
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
                    'data' => encrypt_id($datax['tienda']["tienda_id"]),
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
    }

    public function reporte_factura($id)
    {
        

        $get = tienda_facturas::with([
              "tienda_detalle_factura"
        ])->find(decrypt_id($id));
 

        if ($get) {

            $pdf = Pdf::loadView('pdf.reporte_factura_pdf', ['get' => $get, 'id' => $id])->setPaper('a4', 'landscape'); 
            return $pdf->stream();
             
        } else {
            return view('errors.404');
        }
    }
}
