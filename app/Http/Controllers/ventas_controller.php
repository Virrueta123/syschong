<?php

namespace App\Http\Controllers;

use App\Models\cotizacion;
use App\Models\cotizacioncotizacion_detalle;
use App\Models\cuentas;
use App\Models\detalle_venta;
use App\Models\empresa;
use App\Models\ventas;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Summary\SummaryDetail;
use Greenter\Model\Voided\Voided;
use Greenter\Model\Voided\VoidedDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Greenter\Ws\Services\SoapClient;
use Greenter\Ws\Services\BillSender;
use Illuminate\Support\Facades\Mail;

class ventas_controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except([
            'ventas_cliente',
            // Adicione aqui o nome das rotas que você deseja excluir do middleware "auth"
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $url = asset('/');
        $fecha_actual = Carbon::now();

        return view('modules.ventas.index', compact('fecha_actual', 'url'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notas_venta(Builder $builder)
    {
        $fecha_actual = Carbon::now();
        if (request()->ajax()) {
            return DataTables::of(
                ventas::where('tipo_comprobante', 'N')
                    ->orderBy('created_at', 'asc')
                    ->get(),
            )
                ->addColumn('action', static function ($Data) {
                    $venta_id = encrypt_id($Data->venta_id);
                    return view('buttons.nota_de_venta', ['venta_id' => $venta_id]);
                })

                ->addColumn('numero', static function ($Data) {
                    return $Data->venta_serie . '-' . $Data->venta_correlativo;
                })
                ->addColumn('venta_estado', static function ($Data) {
                    switch ($Data->venta_estado) {
                        case 'A':
                            return 'Aceptado';
                            break;

                        case 'R':
                            return 'Rechazado';
                            break;
                    }
                })
                ->addColumn('cliente', static function ($Data) {
                    if ($Data->tipo_comprobante == 'B') {
                        return $Data->Nombre . ' ' . $Data->Apellido;
                    } else {
                        return $Data->razon_social;
                    }
                })
                ->addColumn('documento', static function ($Data) {
                    if ($Data->tipo_comprobante == 'B') {
                        return $Data->Dni;
                    } else {
                        return $Data->ruc;
                    }
                })
                ->addColumn('forma_pago', static function ($Data) {
                    switch ($Data->forma_pago) {
                        case 'CO':
                            return 'Contado';
                            break;

                        case 'CR':
                            return 'Credito';
                            break;
                    }
                })
                ->toJson();
        }

        $html = $builder
            ->columns([
                Column::make('fecha_creacion')->title('Emision'),
                Column::make('cliente')
                    ->title('Cliente')
                    ->searchable(true)
                    ->orderable(true)
                    ->exportable(false)
                    ->printable(false),
                Column::make('documento')->title('Documento'),
                Column::make('numero')->title('numero'),
                Column::make('venta_estado')->title('Estado'),
                Column::make('venta_total')->title('Venta Total'),
                Column::make('MtoOperGravadas')->title('MtoOperGravadas'),
                Column::make('SubTotal')->title('SubTotal'),
                Column::make('forma_pago')->title('forma pago'),
                Column::make('action')
                    ->title('Opcion')
                    ->exportable(false)
                    ->printable(false),
            ])
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => [
                    [
                        'text' => '<i class="fa fa-bars"></i> columnas visibles',
                        'extend' => 'colvis',
                    ],
                    [
                        'text' => '<i class="fa fa-copy"></i> Copiar',
                        'extend' => 'copy',
                        'title' => 'tabla_cliente_fecha_' . $fecha_actual,
                    ],
                    [
                        'text' => '<i class="fa fa-file-csv"></i> Csv',
                        'extend' => 'csvHtml5',
                        'title' => 'tabla_cliente_fecha_' . $fecha_actual,
                    ],
                    [
                        'text' => '<i class="fa fa-file-excel"></i> Excel',
                        'extend' => 'excelHtml5',
                        'title' => 'tabla_cliente_fecha_' . $fecha_actual,
                    ],
                    [
                        'text' => '<i class="fa fa-file-pdf"></i> Pdf',
                        'extend' => 'pdfHtml5',
                        'title' => 'tabla_cliente_fecha_' . $fecha_actual,
                    ],
                    [
                        'text' => '<i class="fa fa-print"></i> Imprimir',
                        'extend' => 'print',
                        'title' => 'tabla_cliente_fecha_' . $fecha_actual,
                    ],
                ],
                'language' => [
                    'url' => url('//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'),
                ],
                'processing' => false,
                'serverSide' => true,
                'responsive' => true,
                'autoWidth' => false,
            ]);
        //php artisan vendor:publish --tag=datatables-buttons

        return view('modules.ventas.nota_venta', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cuentas = cuentas::where('estado', 'A')->get();
        $get = ventas::with([
            'vendedor',
            'pagos' => function ($query) {
                $query->with(['forma_pago']);
            },
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
            return view('modules.ventas.show', compact('get', 'cuentas', 'id'));
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
        $get = ventas::find(decrypt_id($id));

        $firma = new firma_sunat_controller();
        $see = env('APP_ENV') == 'local' ? $firma->firma_digital_beta() : $firma->firma_digital_produccion();

        $detail1 = new VoidedDetail();
        $tipo_doc = $get->tipo_comprobante == 'B' ? '01' : '03';
        $detail1
            ->setTipoDoc($tipo_doc) // Factura
            ->setSerie($get->venta_serie)
            ->setCorrelativo($get->venta_correlativo)
            ->setDesMotivoBaja('ERROR EN CÁLCULOS'); // Motivo por el cual se da de baja.

        $cDeBaja = new Voided();
        $cDeBaja
            ->setCorrelativo(generarNumeroConsecutivo(app('empresa')->nro_baja())) // Correlativo, necesario para diferenciar c. de baja de en un mismo día.
            ->setFecGeneracion(new \DateTime($get->fecha_creacion)) // Fecha de emisión de los comprobantes a dar de baja
            ->setFecComunicacion(new \DateTime(Carbon::now()->format('Y-m-d'))) // Fecha de envio de la C. de baja
            ->setCompany($firma->company())
            ->setDetails([$detail1]);

        $result = $see->send($cDeBaja);
        // Guardar XML
        file_put_contents($cDeBaja->getName() . '.xml', $see->getFactory()->getLastXml());

        if (!$result->isSuccess()) {
            // Si hubo error al conectarse al servicio de SUNAT.
            dd($result->getError());
            exit();
        }

        $ticket = $result->getTicket();
        dd('Ticket : ' . $ticket . PHP_EOL);

        $statusResult = $see->getStatus($ticket);
        if (!$statusResult->isSuccess()) {
            // Si hubo error al conectarse al servicio de SUNAT.
            dd($statusResult->getError());
            return;
        }

        dd($statusResult->getCdrResponse()->getDescription());
        // Guardar CDR
        file_put_contents('R-' . $cDeBaja->getName() . '.zip', $statusResult->getCdrZip());
    }

    public function ventas_baja($id)
    {
        $empresa = empresa::first();

        $ventas = ventas::where('venta_id', decrypt_id($id))->first();

        $codigo = sprintf('%05d', $empresa->nro_baja);

        $firma = new firma_sunat_controller();
        $see = env('APP_ENV') == 'local' ? $firma->firma_digital_beta() : $firma->firma_digital_produccion();

        $company = new Company();

        $company
            ->setRuc('10464579481')
            ->setRazonSocial('ROSA LUZ INGA TORRES')
            ->setNombreComercial('ROSA LUZ INGA TORRES')
            ->setAddress(
                (new Address())
                    ->setUbigueo('210601')
                    ->setDepartamento('SAN MARTIN')
                    ->setProvincia('SAN MARTIN')
                    ->setDistrito('TARAPOTO')
                    ->setUrbanizacion('-')
                    ->setDireccion('PJ. UNION 126B LOZA BELAUNDE'),
            );

        if ($ventas->tipo_comprobante == "F") {
            $detail1 = new VoidedDetail();
            $detail1
                ->setTipoDoc('01') // Factura
                ->setSerie($ventas->venta_serie)
                ->setCorrelativo($ventas->venta_correlativo)
                ->setDesMotivoBaja('ERROR EN CÁLCULOS'); // Motivo por el cual se da de baja.
    
            $cDeBaja = new Voided();
            $cDeBaja
                ->setCorrelativo($codigo) // Correlativo, necesario para diferenciar c. de baja de en un mismo día.
                ->setFecGeneracion(new \DateTime(Carbon::parse($ventas->fecha_creacion)->format('Y-m-d'))) // Fecha de emisión de los comprobantes a dar de baja
                ->setFecComunicacion(new \DateTime(Carbon::now()->format('Y-m-d'))) // Fecha de envio de la C. de baja
                ->setCompany($company)
                ->setDetails([$detail1]);
    
            $result = $see->send($cDeBaja);
            // Guardar XML
            file_put_contents($cDeBaja->getName() . '.xml', $see->getFactory()->getLastXml());
    
            if (!$result->isSuccess()) {
                // Si hubo error al conectarse al servicio de SUNAT.
                return response()->json([
                    'message' => 'error sunat',
                    'error' => 'error al conectarse a la sunat',
                    'success' => false,
                    'data' => '',
                ]);
            }
    
            $ticket = $result->getTicket();
      
            $statusResult = $see->getStatus($ticket);
            if (!$statusResult->isSuccess()) {
                return response()->json([
                    'message' => 'error sunat',
                    'error' => 'error al conectarse a la sunat',
                    'success' => false,
                    'data' => '',
                ]);
            }
            file_put_contents('R-' . $cDeBaja->getName() . '.zip', $statusResult->getCdrZip());
    
            $ventas->venta_estado = "B";
            $ventas->save();
    
            $empresa->nro_baja = $empresa->nro_baja + 1;
            $empresa->save();
     
            return response()->json([
                'message' => $statusResult->getCdrResponse()->getDescription(),
                'error' => '',
                'success' => true,
                'data' => '',
            ]); 
        } else {
             
            $detail = new SummaryDetail();
            $detail->setTipoDoc('03') // Boleta
                ->setSerieNro($ventas->venta_serie.'-'.$ventas->venta_correlativo)
                ->setEstado('3') // Anulación
                ->setClienteTipo('1')
                ->setClienteNro($ventas->Dni)
                ->setTotal($ventas->SubTotal) 
                ->setMtoOperExoneradas($ventas->SubTotal) 
                ->setMtoIGV(0);
            
            $codigo = sprintf('%03d', $empresa->nro_baja);
            $resumen = new Summary();
            $resumen->setFecGeneracion(new \DateTime(Carbon::parse($ventas->fecha_creacion)->format('Y-m-d'))) // Fecha de emisión de las boletas.
                ->setFecResumen(new \DateTime(Carbon::now()->format('Y-m-d'))) // Fecha de envío del resumen diario.
                ->setCorrelativo($codigo ) // Correlativo, necesario para diferenciar de otros Resumen diario del mismo día.
                ->setCompany($company)
                ->setDetails([$detail]);
            
            $result = $see->send($resumen);
            // Guardar XML
            file_put_contents($resumen->getName().'.xml',
                              $see->getFactory()->getLastXml());
            
            if (!$result->isSuccess()) {
                // Si hubo error al conectarse al servicio de SUNAT.
                return response()->json([
                    'message' => 'error sunat',
                    'error' => 'error al conectarse a la sunat',
                    'success' => false,
                    'data' => '',
                ]);
            }
            
            $ticket = $result->getTicket();
            
            $statusResult = $see->getStatus($ticket);
            if (!$statusResult->isSuccess()) {
                return response()->json([
                    'message' => 'error sunat',
                    'error' => 'error al conectarse a la sunat',
                    'success' => false,
                    'data' => '',
                ]);
            }
             
            // Guardar CDR
            file_put_contents('R-'.$resumen->getName().'.zip', $statusResult->getCdrZip());

            $ventas->venta_estado = "B";
            $ventas->save();
    
            $empresa->nro_baja = $empresa->nro_baja + 1;
            $empresa->save();
     
            return response()->json([
                'message' => $statusResult->getCdrResponse()->getDescription(),
                'error' => '',
                'success' => true,
                'data' => '',
            ]); 
        }
              

    }

    public function destroy_nota($id)
    {
        $ventas = ventas::where('venta_id', decrypt_id($id))->first();
        $ventas->delete();

        detalle_venta::where('venta_id', decrypt_id($id))->delete();

        session()->flash('success', 'Registro eliminado correctamente');
        return redirect()->route('ventas.notas_venta');
    }

    /* ******** registrar la venta con vue ************* */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_vue(Request $request)
    {
        try {
            $cotizacion_id = $request->all()['cotizacion_id'];
            $detalle = $request->all()['detalle'];
            $contador = 0;

            foreach ($detalle as $dt) {
                $contador++;
                $updated = cotizacioncotizacion_detalle::find($dt['cotizacion_detalle_id']);
                $updated->aprobar = $dt['aprobar'];
                $updated->save();
            }

            if (count($detalle) == $contador) {
                $cotizacion_id = $request->all()['cotizacion_id'];
                $update = cotizacion::find($cotizacion_id);
                $update->progreso = 2;
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
    public function ventas_pdf($id)
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
        ])->find(decrypt_id($id));

        if ($get) {
            $pdf = Pdf::loadView('pdf.comprobante', ['get' => $get, 'id' => $id, 'cuentas' => $cuentas]);

            return $pdf->stream();
        } else {
            return view('errors.404');
        }
    }

    public function ventas_cliente($id)
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
        ])->find(decrypt_id($id));

        if ($get) {
            $pdf = Pdf::loadView('pdf.comprobante', ['get' => $get, 'id' => $id, 'cuentas' => $cuentas]);

            return $pdf->stream();
        } else {
            return view('errors.404');
        }
    }

    public function send_correo(Request $request)
    {
        try {
            $destinatario = $request->all()['correo'];
            $ruta = asset('/') . 'ventas_cliente/' . $request->all()['id'];
            $mensaje = 'Puede ver el comprante ' . $request->all()['documento'] . ' en la siguiente ruta';

            $mensaje = Mail::send('pdf.enviar_correo', ['mensaje' => $mensaje, 'ruta' => $ruta], function ($message) use ($destinatario) {
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
}
