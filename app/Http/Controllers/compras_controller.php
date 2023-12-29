<?php

namespace App\Http\Controllers;

use App\Models\caja_chica;
use App\Models\compra;
use App\Models\compras;
use App\Models\cotizacioncotizacion_detalle;
use App\Models\detalle_compra;
use App\Models\forma_pago;
use App\Models\image_pago;
use App\Models\pagos_ventas;
use App\Models\producto;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class compras_controller extends Controller
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
    public function index(Builder $builder)
    {
        $fecha_actual = Carbon::now();
        if (request()->ajax()) {
            return DataTables::of(compras::with(['usuario',"proveedor"])->orderBy('created_at', 'asc')->get())
             
                ->addColumn('action', static function ($Data) {
                    $compra_id = encrypt_id($Data->compra_id);
                    return view('buttons.compras', ['compra_id' => $compra_id]);
                }) 
                ->addColumn('proveedor', static function ($Data) { 
                    return $Data->proveedor->proveedor_razon_social." - ".$Data->proveedor->proveedor_ruc;
                })
                ->addColumn('created_at', static function ($Data) {
                    return Carbon::parse($Data->created_at)->format('Y-m-d');
                }) 
                ->addColumn('fecha_emision', static function ($Data) {
                    return Carbon::parse($Data->fecha_emision)->format('Y-m-d');
                }) 
                ->addColumn('forma_pago', static function ($Data) {
                    switch ($Data->forma_pago) {
                        case 'CO':
                            return "Contado";
                        break;
                        case 'CR':
                            return "Credito";
                        break; 
                    }
                }) 
                ->addColumn('is_pago', static function ($Data) {
                    switch ($Data->is_pago) {
                        case 'Y':
                            return "Si hay pagos";
                        break;
                        case 'N':
                            return "no hay pagos";
                        break; 
                    }
                    return Carbon::parse($Data->created_at)->format('Y-m-d');
                }) 
                ->addColumn('tipo_comprobante', static function ($Data) {
                    switch ($Data->t_comprobante) {
                        case 'F':
                            return "FACTURA";
                        break;
                        case 'B':
                            return "FACTURA";
                        break;
                        case 'N':
                            return "FACTURA";
                        break; 
                    }
                    return Carbon::parse($Data->created_at)->format('Y-m-d');
                }) 
                ->addColumn('documento', static function ($Data) {
                    return $Data->compra_correlativo." - ".$Data->compra_serie;
                }) 
                ->make(true);
        }

        $html = $builder
            ->columns([
                Column::make('created_at')->title('Fecha creacion'),
                Column::make('proveedor')->title('Proveedor'),
                Column::make('documento')->title('documento'),
                Column::make('tipo_comprobante')->title('T.Comprobante'),
                Column::make('fecha_emision')->title('F.emision'),
                Column::make('forma_pago')->title('Forma de pago'),
                Column::make('total')->title('Total'),
                Column::make('is_pago')->title('Pagos'), 
                Column::computed('action')
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

        return view('modules.compras.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $forma_pago = forma_pago::where('estado', 'A')->get();
        return view('modules.compras.create', compact('forma_pago'));
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
            $caja_chica = caja_chica::where("user_id", auth()->user()->id)->where("is_abierto","Y")->first()->caja_chica_id;
            $Datax = $request->all();
            $compra = new compras();
            $compra->compra_correlativo = $Datax['correlativo'];
            $compra->compra_serie = $Datax['serie'];
            $compra->compra_total = $Datax['total'];
            $compra->t_comprobante = $Datax['tipo_comprobante'];
            $compra->fecha_vencimiento = $Datax['fecha_creacion'];
            $compra->fecha_emision = $Datax['fecha_vencimiento'];
            $compra->proveedor_id = $Datax['proveedor_id'];
            $compra->total = $Datax['total'];
            $compra->forma_pago = $Datax['fecha_creacion'] == $Datax['fecha_vencimiento'] ? 'CO' : 'CR';
            $compra->user_id = Auth::user()->id;
            $compra->is_pago = $Datax['is_pago'] ? 'Y' : 'N';
            $compra->caja_chica_id = $caja_chica;
 
            if ($compra->save()) {
                foreach ($Datax['repuestos'] as $detalle) {

                    $producto = producto::find($detalle['prod_id']);

                    $compra_lote = detalle_compra::where('prod_id', $detalle['prod_id'])->max('lote');
                    $lote = 0;
                    if (is_null($compra_lote)) {
                        $lote = 1;
                    } else {
                        $lote++;
                    }

                    $detalle_compra = new detalle_compra(); 
                    $detalle_compra->compra_id = $compra->compra_id;
                    $detalle_compra->lote = $lote;
                    $detalle_compra->prod_id = $detalle['prod_id'];
                    $detalle_compra->cantidad = $detalle['Cantidad'];
                    $detalle_compra->descripcion = $detalle['Descripcion'];
                    $detalle_compra->precio_compra = $detalle['precio_compra'];
                    $detalle_compra->precio_venta = $detalle['is_precio_venta'] ? $detalle['precio_venta'] : 0;
                    $detalle_compra->is_precio_venta = $detalle['is_precio_venta'] ? 'Y' : 'N';
                    $detalle_compra->zona_id = $detalle['zona_id'];

                    $detalle_compra->save();
 
                   foreach ( $detalle["cotizaccion"] as $coti) {
                   
                        $cotizaion_detalle = new cotizacioncotizacion_detalle();

                        // Asignar valores a los campos
                        $cotizaion_detalle->cotizacion_id =$coti["cotizacion_id"]; // ID de la cotización relacionada
                        $cotizaion_detalle->prod_id =$detalle_compra->prod_id; // ID del producto relacionado
                        $cotizaion_detalle->servicios_id = 0; // ID del servicio relacionado
                        $cotizaion_detalle->tipo = "P"; // 'P' para producto, 'S' para servicio, ajusta según sea necesario
                        $cotizaion_detalle->Precio = $detalle['is_precio_venta'] ? $detalle['precio_venta'] :  $detalle['precio_compra'];
                        $cotizaion_detalle->Importe =$detalle['is_precio_venta'] ? $detalle['precio_venta'] *$coti["cantidad"] :  $detalle['precio_compra'] *$coti["cantidad"];
                        $cotizaion_detalle->ImporteDescuento = 0;
                        $cotizaion_detalle->Descuento = 0;
                        $cotizaion_detalle->Descripcion = $detalle['Descripcion'];
                        $cotizaion_detalle->Codigo = $producto->prod_codigo;
                        $cotizaion_detalle->Cantidad = $coti["cantidad"];
                        $cotizaion_detalle->ValorDescuento = 0;
                        $cotizaion_detalle->Detalle = "";
        
                        // Guardar el registro en la base de datos
                        $cotizaion_detalle->save();
                    } 
                }

                foreach ($Datax['pagos'] as $pago) {
                    if ($pago['url'] != false) {
                        $pagosVentas = new pagos_ventas();
                        $pagosVentas->compra_id = $compra->compra_id;
                        $pagosVentas->fecha_pago = $Datax['fecha_creacion'];
                        $pagosVentas->monto = $pago['monto'];
                        $pagosVentas->forma_pago_id = $pago['forma_pago_id'];
                        $pagosVentas->referencia = $pago['referencia'];
                        $pagosVentas->imagen = 'Y';
                        $pagosVentas->tipo = 'C';
                        $pagosVentas->caja_chica_id = $caja_chica;
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
                        $pagosVentas->compra_id = $compra->compra_id;
                        $pagosVentas->fecha_pago = $Datax['fecha_creacion'];
                        $pagosVentas->monto = $pago['monto'];
                        $pagosVentas->forma_pago_id = $pago['forma_pago_id'];
                        $pagosVentas->referencia = $pago['referencia'];
                        $pagosVentas->tipo = 'C';
                        $pagosVentas->imagen = 'N';
                        $pagosVentas->caja_chica_id = $caja_chica;
                        $pagosVentas->save();
                    }
                }

                session()->flash('success', 'se creo correctamente la compra');
                return response()->json([
                    'message' => 'se creo correctamente la compra',
                    'error' => '',
                    'success' => true,
                    'data' => '',
                ]);
            } else {
                return response()->json([
                    'message' => 'no se pudo registrar la compra',
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
        $get = compras::with(["proveedor","pagos"=>function($query){
            return $query->with(["img"]); 
        },"detalle"=>function($query){
            return $query->with(["producto"=>function($query){
                return $query->with(["unidad"]);
            },"zona"]);
        }])->find(decrypt_id($id));

    
  
        $forma_pago = forma_pago::where('estado', 'A')->get();

        return view('modules.compras.edit', compact('forma_pago',"get"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editar_comprar(Request $request)
    {
        try {
            $Datax = $request->all();
            $compra_id = $Datax['compra_id'];

            $get = compras::with(["pagos"=>function($query){
                return $query->with(["img"]);
            }])->find($compra_id);

         
            $Datax = $request->all();
            $compra = compras::find($compra_id);
            $compra->compra_correlativo = $Datax['correlativo'];
            $compra->compra_serie = $Datax['serie'];
            $compra->compra_total = $Datax['total'];
            $compra->t_comprobante = $Datax['tipo_comprobante'];
            $compra->fecha_vencimiento = $Datax['fecha_creacion'];
            $compra->fecha_emision = $Datax['fecha_vencimiento'];
            $compra->proveedor_id = $Datax['proveedor_id'];
            $compra->total = $Datax['total'];
            $compra->forma_pago = $Datax['fecha_creacion'] == $Datax['fecha_vencimiento'] ? 'CO' : 'CR';
            $compra->user_id = Auth::user()->id;
            $compra->is_pago = $Datax['is_pago'] ? 'Y' : 'N';
  
            if ($compra->update()) {

                $detalle_compra_by_delete = detalle_compra::where('compra_id', $compra_id)->pluck('prod_id')->toArray();
                $prod_ids = array_column($Datax['repuestos'], 'prod_id');
                $result = array_diff($detalle_compra_by_delete, $prod_ids);

                detalle_compra::whereIn('compra_id', [$compra_id])->whereIn('prod_id', $result)->delete(); 
   
                foreach ($Datax['repuestos'] as $detalle) {

                    $detalle_compra_update = detalle_compra::where('prod_id', $detalle['prod_id'])->where('compra_id', $compra_id)->first();
  
                    if($detalle_compra_update){  
                        $detalle_compra_update->cantidad = $detalle['Cantidad'];
                        $detalle_compra_update->descripcion = $detalle['Descripcion'];
                        $detalle_compra_update->precio_compra = $detalle['precio_compra'];
                        $detalle_compra_update->precio_venta = $detalle['is_precio_venta'] ? $detalle['precio_venta'] : 0;
                        $detalle_compra_update->is_precio_venta = $detalle['is_precio_venta'] ? 'Y' : 'N';
                        $detalle_compra_update->zona_id = $detalle['zona_id'];
                        $detalle_compra_update->save(); 
                    }else{ 
                        $detalle_compra = detalle_compra::where('prod_id', $detalle['prod_id'])->where('compra_id', $compra_id);
 
                        $compra_lote = detalle_compra::where('prod_id', $detalle['prod_id'])->max('lote');

                        $lote = 0;
                        if (is_null($compra_lote)) {
                            $lote = 1;
                        } else {
                            $lote++;
                        } 
                        $detalle_compra = new detalle_compra(); 
                        $detalle_compra->compra_id = $compra->compra_id;
                        $detalle_compra->lote = $lote;
                        $detalle_compra->prod_id = $detalle['prod_id'];
                        $detalle_compra->cantidad = $detalle['Cantidad'];
                        $detalle_compra->descripcion = $detalle['Descripcion'];
                        $detalle_compra->precio_compra = $detalle['precio_compra'];
                        $detalle_compra->precio_venta = $detalle['is_precio_venta'] ? $detalle['precio_venta'] : 0;
                        $detalle_compra->is_precio_venta = $detalle['is_precio_venta'] ? 'Y' : 'N';
                        $detalle_compra->zona_id = $detalle['zona_id'];
    
                        $detalle_compra->save();
                    } 
                    
                }

                if( $Datax['is_pago'] =="Y" ){

                    $pagos_compra_by_delete = pagos_ventas::where('compra_id', $compra_id)->pluck('forma_pago_id')->toArray();
                    $pagos_ventas = array_column($Datax['pagos'], 'forma_pago_id');
                    $deletes = array_diff($pagos_compra_by_delete, $pagos_ventas);
    
                    pagos_ventas::whereIn('compra_id', [$compra_id])->whereIn('forma_pago_id', $deletes)->delete(); 

                    foreach ($Datax['pagos'] as $pago) {

                        $pagos_compra = pagos_ventas::where('forma_pago_id', $pago['forma_pago_id'])->where('compra_id', $compra_id)->first();

                        if ($pagos_compra) {
                            $pagos_ventas_id = $pagos_compra->pagos_ventas_id;
                            if ($pago['url'] != false) { 
                                $pagos_compra->compra_id = $compra->compra_id;
                                $pagos_compra->fecha_pago = $Datax['fecha_creacion'];
                                $pagos_compra->monto = $pago['monto'];
                                $pagos_compra->forma_pago_id = $pago['forma_pago_id'];
                                $pagos_compra->referencia = $pago['referencia'];
                                $pagos_compra->imagen = 'Y';
                                $pagos_compra->tipo = 'C'; 
                                $pagos_compra->save();
        
                                /* ******** insertar imagen al pago ************* */
                                $base64Data = $pago['url'];
                                $decodedData = base64_decode($base64Data);
                                $filename = Carbon::now()->format('Ymdhis') . '.jpg'; // Set the desired filename here
                                $path = 'fotos_pagos/' . $filename;
                                $add = Storage::disk('local')->put('public/' . $path, $decodedData);
        
                                if ($add) {
                                    $imagePago = image_pago::where("pagos_ventas_id",$pagos_ventas_id);
                                    $imagePago->url = $path; 
                                    $imagePago->save();
                                }
                                /* *********************** */
                            } else { 
                                $pagos_compra->compra_id = $compra->compra_id;
                                $pagos_compra->fecha_pago = $Datax['fecha_creacion'];
                                $pagos_compra->monto = $pago['monto'];
                                $pagos_compra->forma_pago_id = $pago['forma_pago_id'];
                                $pagos_compra->referencia = $pago['referencia'];
                                $pagos_compra->tipo = 'C';
                                $pagos_compra->imagen = 'N'; 
                                $pagos_compra->save();
                            }
                        } else {
                            if ($pago['url'] != false) {
                                $pagosVentas = new pagos_ventas();
                                $pagosVentas->compra_id = $compra->compra_id;
                                $pagosVentas->fecha_pago = $Datax['fecha_creacion'];
                                $pagosVentas->monto = $pago['monto'];
                                $pagosVentas->forma_pago_id = $pago['forma_pago_id'];
                                $pagosVentas->referencia = $pago['referencia'];
                                $pagosVentas->imagen = 'Y';
                                $pagosVentas->tipo = 'C';
                                $pagosVentas->caja_chica_id = $compra->caja_chica_id;
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
                                $pagosVentas->compra_id = $compra->compra_id;
                                $pagosVentas->fecha_pago = $Datax['fecha_creacion'];
                                $pagosVentas->monto = $pago['monto'];
                                $pagosVentas->forma_pago_id = $pago['forma_pago_id'];
                                $pagosVentas->referencia = $pago['referencia'];
                                $pagosVentas->tipo = 'C';
                                $pagosVentas->imagen = 'N';
                                $pagosVentas->caja_chica_id = $compra->caja_chica_id;
                                $pagosVentas->save();
                            }
                        }
                    }
                }else{
                    foreach ($get->pagos as $pago) {
                        $pago->delete();
                    }  
                }
                session()->flash('success', 'se creo correctamente la compra');
                return response()->json([
                    'message' => 'se creo correctamente la compra',
                    'error' => '',
                    'success' => true,
                    'data' => '',
                ]);
            } else {
                return response()->json([
                    'message' => 'no se pudo registrar la compra',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'message' => $th,
                'error' => $th->getMessage(),
                'success' => false,
                'data' => '',
            ]);
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
            $delete = compras::find(decrypt_id($id));
 
            if ($delete->delete()) {

                detalle_compra::where('compra_id',decrypt_id($id))->delete(); 

                pagos_ventas::where('compra_id',decrypt_id($id))->delete();

                session()->flash('success', 'se elimino correctamente la compra');
                return redirect()->route('compras.index');
            } else {
                session()->flash('success', 'error al eliminar la compra');
                return redirect()->route('compras.index');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al eliminar este registro');
            return redirect()->route('compras.index');
        }
    }
}
