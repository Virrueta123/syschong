<?php

namespace App\Http\Controllers;

use App\Models\ventas;
use Carbon\Carbon; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class ventas_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $fecha_actual = Carbon::now();
        if (request()->ajax()) {
            return DataTables::of(
                ventas::orderBy('created_at', 'asc')
            )
                ->addColumn('action', static function ($Data) {
                    $venta_id = encrypt_id($Data->venta_id);
                    return view('buttons.venta', ['venta_id' => $venta_id]);
                })
                ->addColumn('tipo_venta', static function ($Data) {
                    switch ($Data->tipo_venta) {
                        case 'FM':
                            return 'Factura Mantenimiento';
                            break;

                        case 'BM':
                            return ' Boleta Mantenimiento';
                            break;
                    }
                })
                ->addColumn('numero', static function ($Data) {
                    return $Data->venta_serie."-".$Data->venta_correlativo;
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
                    if($Data->tipo_comprobante=="B"){
                        return $Data->Nombre . " " . $Data->Apellido; 
                    }else{
                        return $Data->razon_social; 
                    }
                })
                ->addColumn('documento', static function ($Data) {
                    if($Data->tipo_comprobante=="B"){
                        return $Data->Dni; 
                    }else{
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
                Column::computed('tipo_venta')->title('Tipo Comprobante'),
                Column::computed('cliente')->title('Cliente')->searchable(true)
                ->orderable(true)  
                ->exportable(false)
                ->printable(false),
                Column::computed('documento')->title('Documento'),
                Column::computed('numero')->title('numero'), 
                Column::make('venta_estado')->title('Estado'),
                Column::make('venta_total')->title('Venta Total'),
                Column::make('MtoOperGravadas')->title('MtoOperGravadas'), 
                Column::make('SubTotal')->title('SubTotal'),
                Column::computed('forma_pago')->title('forma pago'), 
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

        return view('modules.ventas.index', compact('html'));
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
}
