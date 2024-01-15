<?php

namespace App\Http\Controllers;

use App\Exports\ExcelDocumento;
use App\Models\compras;
use App\Models\detalle_venta;
use App\Models\gastos;
use App\Models\pagos_ventas;
use App\Models\ventas;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Facade\Ignition\DumpRecorder\Dump;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class reporte_controller extends Controller
{

    //descargar pdf

    public function descarga_pdf_reporte_documento(Request $request)
    {
        $datax = $request->all(); 
        
        $pdf = Pdf::loadView('pdf.reportes.reporte_documento', ["datatable"=>$datax["datatable"],"total"=>$datax["total"]])->setPaper('A4', 'landscape');
 
        return $pdf->download('ejemplo.pdf');
    }


    public function send_correo_documento(Request $request )
    {
         // Verificar si hay un archivo adjunto
      
        try {
            
            if ($request->hasFile('archivo')) {
                // Guardar el archivo en el servidor
                $archivo = $request->file('archivo');
                $rutaArchivo = storage_path('app/public/') . $archivo->getClientOriginalName();
                $archivo->move(storage_path('app/public/'), $archivo->getClientOriginalName());
    
                 
                $destinatario = $request->all()['correo'];
    
                    $mensaje = Mail::send('pdf.enviar_correo_aviso', ['mensaje' => "Reporte de Documentos"], function ($message) use ($destinatario,$rutaArchivo) {
                        $message->to($destinatario)->subject('Asunto del mensaje');
                        $message->attach($rutaArchivo, ['as' => 'archivo.xlsx']);
                    });
    
                // Eliminar el archivo después de enviarlo por correo (opcional)
                unlink($rutaArchivo);
     
                return response()->json([
                    'message' => 'Correo enviado con éxito',
                    'error' => '',
                    'success' => true,
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
    /* reportes */
    public function reportes()
    {
        return view('modules.reportes.index');
    }
    /*--- ----*/
    /* documentos */
    public function documentos()
    {
        return view('modules.reportes.documentos');
    }
    /*--- ----*/
    /* clientes */
    public function clientes()
    {
        return view('modules.reportes.clientes');
    }
    /*--- ----*/
    /* producto_busqueda */
    public function producto_busqueda()
    {
        return view('modules.reportes.productos_busqueda');
    }
    /*--- ----*/
    /* productos */
    public function productos()
    {
        return view('modules.reportes.productos');
    }
    /*--- ----*/
    /* notas_venta */
    public function notas_venta()
    {
        return view('modules.reportes.notas_venta');
    }
    /*--- ----*/
    public function aumentarCeroAIzquierda(int $numero)
    {
        if (strlen($numero) == 1) {
            return '0' . $numero;
        } else {
            return $numero;
        }
    }
    public function load_numero_comprobante()
    {
        try {
            $monto_total_comprobantes = ventas::whereIn('tipo_comprobante', ['F', 'B'])
                ->where('estado', 'A')
                ->count();

            $monto_total_notas_ventas = 'S/. ' . moneyformat(ventas::where('tipo_comprobante', ['N'])
                ->where('estado', 'A')
                ->sum('SubTotal'));
            
            $monto_total_general =
                'S/. ' .
                moneyformat(
                    ventas::whereIn('tipo_comprobante', ['N', 'F', 'B'])
                        ->where('estado', 'A')
                        ->sum('SubTotal'),
                );

            $utilidad_neta = 10;

            return response()->json([
                'message' => 'datos encontrados',
                'error' => '',
                'success' => true,
                'data' => [
                    'monto_total_comprobantes' => $monto_total_comprobantes,
                    'monto_total_notas_ventas' => $monto_total_notas_ventas,
                    'monto_total_general' => $monto_total_general,
                    'utilidad_neta' => $utilidad_neta,
                ],
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'message' => 'error al buscar los datos',
                'error' => $th->getMessage(),
                'success' => false,
                'data' => '',
            ]);
        }
    }

    public function load_data_dashboard(Request $req)
    {
        try {
            $datax = $req->all();
            $datos = [];

            if ($datax['todos']) {
                $datos = $this->todos();
            }
            if ($datax['ultima_semana']) {
                $datos = $this->ultima_semana();
            }
            if ($datax['por_mes']) {
                $datos = $this->por_mes($datax['fecha_por_mes']);
            }
            if ($datax['entres_meses']) {
                $datos = $this->entres_meses($datax['start_mounth'], $datax['end_mounth']);
            }
            if ($datax['por_fecha']) {
                $datos = $this->por_fecha($datax['fecha_por_date']);
            }
            if ($datax['entre_fechas']) {
                $datos = $this->entre_fechas($datax['start_date'], $datax['end_date']);
            }

            return response()->json([
                'message' => 'datos cargados',
                'error' => '',
                'success' => true,
                'data' => $datos,
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'message' => 'error al buscar los datos',
                'error' => $th->getMessage(),
                'success' => false,
                'data' => '',
            ]);
        }
    }

    private function todos()
    {
        $total_cobrado_nota_venta = ventas::where('forma_pago', 'CO')
            ->whereNotIn('venta_estado', ['B'])
            ->where('tipo_comprobante', '=', 'N')
            ->sum('SubTotal');

        $total_cobrado_comprobante = ventas::where('forma_pago', 'CO')
            ->whereNotIn('venta_estado', ['B'])
            ->whereNotIn('tipo_comprobante', ['N'])
            ->sum('SubTotal');

        $total_credito_comprobante = ventas::where('forma_pago', 'CR')
            ->whereNotIn('venta_estado', ['B'])
            ->whereNotIn('tipo_comprobante', ['N'])
            ->sum('SubTotal');

        $cliente_top = ventas::with('cliente')
            ->select('cli_id', DB::raw('MAX(fecha_creacion) as fecha_creacion'), DB::raw('COUNT(*) as cantidad_ventas'), DB::raw('SUM(SubTotal) as total_subtotal'))
           
            ->groupBy('cli_id')
            ->orderBy('total_subtotal', 'DESC')
            ->get();

        $Ventas_por_producto = detalle_venta::with('producto', 'venta')
            ->select('prod_id', DB::raw('COUNT(*) as cantidad_ventas'), DB::raw('SUM(MtoValorVenta) as total_subtotal'))
            ->where('tipo', 'p')
            ->groupBy('prod_id')
            ->orderBy('total_subtotal', 'DESC')
            ->get();

        return [
            'cliente_top' => $cliente_top,
            'Ventas_por_producto' => $Ventas_por_producto,
            'total_cobrado_nota_venta' => $total_cobrado_nota_venta,
            'total_cobrado_comprobante' => $total_cobrado_comprobante,
            'total_credito_comprobante' => $total_credito_comprobante,
        ];
    }
    private function ultima_semana()
    {
        // Obtener el primer día de la semana
        $primerDiaSemana = Carbon::now()->startOfWeek(); // Puede especificar un día específico usando ->startOfWeek(Carbon::MONDAY);

        // Obtener el último día de la semana
        $ultimoDiaSemana = Carbon::now()->endOfWeek(); // Puede especificar un día específico usando ->endOfWeek(Carbon::SUNDAY);

        $total_cobrado_nota_venta = ventas::where('forma_pago', 'CO')
            ->whereNotIn('venta_estado', ['B'])
            ->where('tipo_comprobante', '=', 'N')
            ->whereBetween('fecha_creacion', [$primerDiaSemana, $ultimoDiaSemana])
            ->sum('SubTotal');

        $total_cobrado_comprobante = ventas::where('forma_pago', 'CO')
            ->whereNotIn('venta_estado', ['B'])
            ->whereNotIn('tipo_comprobante', ['N'])
            ->whereBetween('fecha_creacion', [$primerDiaSemana, $ultimoDiaSemana])
            ->sum('SubTotal');

        $total_credito_comprobante = ventas::where('forma_pago', 'CR')
            ->whereNotIn('venta_estado', ['B'])
            ->whereNotIn('tipo_comprobante', ['N'])
            ->whereBetween('fecha_creacion', [$primerDiaSemana, $ultimoDiaSemana])
            ->sum('SubTotal');

        /* ******** reporte de barras de totales ************* */
        $total_notas_de_venta_semanal = ventas::whereNotIn('venta_estado', ['B'])
            ->where('tipo_comprobante', '=', 'N')
            ->whereBetween('fecha_creacion', [$primerDiaSemana, $ultimoDiaSemana])
            ->sum('SubTotal');

        $total_comprobantes_semanal = ventas::whereNotIn('venta_estado', ['B'])
            ->whereNotIn('tipo_comprobante', ['N'])
            ->whereBetween('fecha_creacion', [$primerDiaSemana, $ultimoDiaSemana])
            ->sum('SubTotal');

        $fechas_barra_venta = [];
        $firstData_barra_venta = [];
        $secondData_barra_venta = [];
        $primerDiaSemana_barra = $primerDiaSemana;
        $ultimoDiaSemana_barra = $ultimoDiaSemana;

        $cliente_top = ventas::with('cliente')
            ->select('cli_id', DB::raw('MAX(fecha_creacion) as fecha_creacion'), DB::raw('COUNT(*) as cantidad_ventas'), DB::raw('SUM(SubTotal) as total_subtotal'))
            ->whereBetween('fecha_creacion', [$primerDiaSemana, $ultimoDiaSemana])
            ->groupBy('cli_id')
            ->orderBy('total_subtotal', 'DESC')
            ->get();

        $Ventas_por_producto = detalle_venta::with('producto', 'venta')
            ->select('prod_id', DB::raw('COUNT(*) as cantidad_ventas'), DB::raw('SUM(MtoValorVenta) as total_subtotal'))
            ->where('tipo', 'p')
            ->groupBy('prod_id')
            ->orderBy('total_subtotal', 'DESC')
            ->get();

        //balance T. Ventas - T. Compras/Gastos

        $total_compras = compras::where('forma_pago', 'CO')
            ->whereBetween('fecha_emision', [$primerDiaSemana, $ultimoDiaSemana])
            ->sum('total');

        $total_gastos = gastos::whereBetween('created_at', [$primerDiaSemana, $ultimoDiaSemana])
            ->get()
            ->sum('monto');

        for ($date = $primerDiaSemana_barra; $date->lte($ultimoDiaSemana_barra); $date->addDay()) {
            $fechas_barra_venta[] = $date->toDateString();
            $total_notas_de_venta = ventas::whereNotIn('venta_estado', ['B'])
                ->where('tipo_comprobante', '=', 'N')
                ->where('fecha_creacion', $date->toDateString())
                ->sum('SubTotal');

            $total_comprobantes = ventas::whereNotIn('venta_estado', ['B'])
                ->whereNotIn('tipo_comprobante', ['N'])
                ->where('fecha_creacion', $date->toDateString())
                ->sum('SubTotal');

            $firstData_barra_venta[] = $total_notas_de_venta;
            $secondData_barra_venta[] = $total_comprobantes;
        }
        /* *********************** */

        return [
            'total_cobrado_nota_venta' => $total_cobrado_nota_venta,
            'total_cobrado_comprobante' => $total_cobrado_comprobante,
            'total_credito_comprobante' => $total_credito_comprobante,
            'cliente_top' => $cliente_top,
            'Ventas_por_producto' => $Ventas_por_producto,
            /* ******** variables para reporte de barras  ************* */
            'fechas_barra_venta' => $fechas_barra_venta,
            'firstData_barra_venta' => $firstData_barra_venta,
            'secondData_barra_venta' => $secondData_barra_venta,
            'total_notas_de_venta_semanal' => $total_notas_de_venta_semanal,
            'total_comprobantes_semanal' => $total_comprobantes_semanal,
            //balance
            'total_compras' => $total_compras,
            'total_gastos' => $total_gastos,
        ];
    }
    private function por_mes($fecha)
    {
        $year = $fecha['year'];
        $month = $fecha['month'] + 1;

        $total_cobrado_nota_venta = ventas::where('forma_pago', 'CO')
            ->whereNotIn('venta_estado', ['B'])
            ->where('tipo_comprobante', '=', 'N')
            ->whereYear('fecha_creacion', $year)
            ->whereMonth('fecha_creacion', $month)
            ->sum('SubTotal');

        $total_cobrado_comprobante = ventas::where('forma_pago', 'CO')
            ->whereNotIn('venta_estado', ['B'])
            ->whereNotIn('tipo_comprobante', ['N'])
            ->whereYear('fecha_creacion', $year)
            ->whereMonth('fecha_creacion', $month)
            ->sum('SubTotal');

        $total_credito_comprobante = ventas::where('forma_pago', 'CR')
            ->whereNotIn('venta_estado', ['B'])
            ->whereNotIn('tipo_comprobante', ['N'])
            ->whereYear('fecha_creacion', $year)
            ->whereMonth('fecha_creacion', $month)
            ->sum('SubTotal');

        /* ******** reporte de barras de totales ************* */

        $total_notas_de_venta_semanal = ventas::whereNotIn('venta_estado', ['B'])
            ->where('tipo_comprobante', '=', 'N')
            ->whereYear('fecha_creacion', $year)
            ->whereMonth('fecha_creacion', $month)
            ->sum('SubTotal');

        $total_comprobantes_semanal = ventas::whereNotIn('venta_estado', ['B'])
            ->whereNotIn('tipo_comprobante', ['N'])
            ->whereYear('fecha_creacion', $year)
            ->whereMonth('fecha_creacion', $month)
            ->sum('SubTotal');

        $fechas_barra_venta = [];
        $firstData_barra_venta = [];
        $secondData_barra_venta = [];

        $fechas = $year . '-' . $this->aumentarCeroAIzquierda($month) . '-01';
        $carbon = Carbon::parse($fechas);

        $endDate = $carbon->endOfMonth();

        $fechaInicio = Carbon::parse($fechas);
        $fechaFin = Carbon::parse($endDate->format('Y-m-d'));

        for ($date = $fechaInicio; $date->lte($fechaFin); $date->addDay()) {
            $fechas_barra_venta[] = $date->toDateString();
            $total_notas_de_venta = ventas::whereNotIn('venta_estado', ['B'])
                ->where('tipo_comprobante', '=', 'N')
                ->where('fecha_creacion', $date->toDateString())
                ->sum('SubTotal');

            $total_comprobantes = ventas::whereNotIn('venta_estado', ['B'])
                ->whereNotIn('tipo_comprobante', ['N'])
                ->where('fecha_creacion', $date->toDateString())
                ->sum('SubTotal');

            $firstData_barra_venta[] = $total_notas_de_venta;
            $secondData_barra_venta[] = $total_comprobantes;
        }
        /* *********************** */

        return [
            'total_cobrado_nota_venta' => $total_cobrado_nota_venta,
            'total_cobrado_comprobante' => $total_cobrado_comprobante,
            'total_credito_comprobante' => $total_credito_comprobante,
            /* ******** variables para reporte de barras  ************* */
            'fechas_barra_venta' => $fechas_barra_venta,
            'firstData_barra_venta' => $firstData_barra_venta,
            'secondData_barra_venta' => $secondData_barra_venta,
            'total_notas_de_venta_semanal' => $total_notas_de_venta_semanal,
            'total_comprobantes_semanal' => $total_comprobantes_semanal,
        ];
    }
    private function entres_meses($start, $end)
    {
        $fecha = $end['year'] . '-' . $this->aumentarCeroAIzquierda($end['month'] + 1) . '-01';
        $carbon = Carbon::parse($fecha);

        $startDate = $start['year'] . '-' . $this->aumentarCeroAIzquierda($start['month'] + 1) . '-01';
        $endDate = $carbon->endOfMonth();

        $total_cobrado_nota_venta = ventas::where('forma_pago', 'CO')
            ->whereNotIn('venta_estado', ['B'])
            ->where('tipo_comprobante', '=', 'N')
            ->whereBetween('fecha_creacion', [$startDate, $endDate])
            ->sum('SubTotal');

        $total_cobrado_comprobante = ventas::where('forma_pago', 'CO')
            ->whereNotIn('venta_estado', ['B'])
            ->whereNotIn('tipo_comprobante', ['N'])
            ->whereBetween('fecha_creacion', [$startDate, $endDate])
            ->sum('SubTotal');

        $total_credito_comprobante = ventas::where('forma_pago', 'CR')
            ->whereNotIn('venta_estado', ['B'])
            ->whereNotIn('tipo_comprobante', ['N'])
            ->whereBetween('fecha_creacion', [$startDate, $endDate])
            ->sum('SubTotal');

        /* ******** reporte de barras de totales ************* */

        $total_notas_de_venta_semanal = ventas::whereNotIn('venta_estado', ['B'])
            ->where('tipo_comprobante', '=', 'N')
            ->whereBetween('fecha_creacion', [$startDate, $endDate])
            ->sum('SubTotal');

        $total_comprobantes_semanal = ventas::whereNotIn('venta_estado', ['B'])
            ->whereNotIn('tipo_comprobante', ['N'])
            ->whereBetween('fecha_creacion', [$startDate, $endDate])
            ->sum('SubTotal');

        $intervaloMeses = [];
        $firstData_barra_venta = [];
        $secondData_barra_venta = [];

        $fechaInicio = Carbon::parse($startDate);
        $fechaFin = Carbon::parse($endDate->format('Y-m-d'));

        while ($fechaInicio->lte($fechaFin)) {
            $intervaloMeses[] = $fechaInicio->isoFormat('MMMM') . '-' . $fechaInicio->format('Y');

            $total_notas_de_venta = ventas::whereNotIn('venta_estado', ['B'])
                ->where('tipo_comprobante', '=', 'N')
                ->whereYear('fecha_creacion', $fechaInicio->format('Y'))
                ->whereMonth('fecha_creacion', $fechaInicio->format('m'))
                ->sum('SubTotal');

            $total_comprobantes = ventas::whereNotIn('venta_estado', ['B'])
                ->whereNotIn('tipo_comprobante', ['N'])
                ->whereYear('fecha_creacion', $fechaInicio->format('Y'))
                ->whereMonth('fecha_creacion', $fechaInicio->format('m'))
                ->sum('SubTotal');
            $firstData_barra_venta[] = $total_notas_de_venta;
            $secondData_barra_venta[] = $total_comprobantes;
            $fechaInicio->addMonth();
        }
        /* *********************** */

        return [
            'total_cobrado_nota_venta' => $total_cobrado_nota_venta,
            'total_cobrado_comprobante' => $total_cobrado_comprobante,
            'total_credito_comprobante' => $total_credito_comprobante,
            /* ******** variables para reporte de barras  ************* */
            'fechas_barra_venta' => $intervaloMeses,
            'firstData_barra_venta' => $firstData_barra_venta,
            'secondData_barra_venta' => $secondData_barra_venta,
            'total_notas_de_venta_semanal' => $total_notas_de_venta_semanal,
            'total_comprobantes_semanal' => $total_comprobantes_semanal,
        ];
    }
    private function por_fecha($fecha)
    {
        $fecha = Carbon::parse($fecha)->format('Y-m-d');

        $total_cobrado_nota_venta = ventas::where('forma_pago', 'CO')
            ->whereNotIn('venta_estado', ['B'])
            ->where('tipo_comprobante', '=', 'N')
            ->where('fecha_creacion', $fecha)
            ->sum('SubTotal');

        $total_cobrado_comprobante = ventas::where('forma_pago', 'CO')
            ->whereNotIn('venta_estado', ['B'])
            ->whereNotIn('tipo_comprobante', ['N'])
            ->where('fecha_creacion', $fecha)
            ->sum('SubTotal');

        $total_credito_comprobante = ventas::where('forma_pago', 'CR')
            ->whereNotIn('venta_estado', ['B'])
            ->whereNotIn('tipo_comprobante', ['N'])
            ->where('fecha_creacion', $fecha)
            ->sum('SubTotal');

        return [
            'total_cobrado_nota_venta' => $total_cobrado_nota_venta,
            'total_cobrado_comprobante' => $total_cobrado_comprobante,
            'total_credito_comprobante' => $total_credito_comprobante,
        ];
    }
    private function entre_fechas($startDate, $endDate)
    {
        $startDate = Carbon::parse($startDate)->format('Y-m-d');
        $endDate = Carbon::parse($endDate)->format('Y-m-d');

        $startDate_carbon = Carbon::parse($startDate);
        $endDate_carbon = Carbon::parse($endDate);

        $total_cobrado_nota_venta = ventas::where('forma_pago', 'CO')
            ->whereNotIn('venta_estado', ['B'])
            ->where('tipo_comprobante', '=', 'N')
            ->whereBetween('fecha_creacion', [$startDate, $endDate])
            ->sum('SubTotal');

        $total_cobrado_comprobante = ventas::where('forma_pago', 'CO')
            ->whereNotIn('venta_estado', ['B'])
            ->whereNotIn('tipo_comprobante', ['N'])
            ->whereBetween('fecha_creacion', [$startDate, $endDate])
            ->sum('SubTotal');

        $total_credito_comprobante = ventas::where('forma_pago', 'CR')
            ->whereNotIn('venta_estado', ['B'])
            ->whereNotIn('tipo_comprobante', ['N'])
            ->whereBetween('fecha_creacion', [$startDate, $endDate])
            ->sum('SubTotal');

        /* ******** reporte de barras de totales ************* */
        $total_notas_de_venta_semanal = ventas::whereNotIn('venta_estado', ['B'])
            ->where('tipo_comprobante', '=', 'N')
            ->whereBetween('fecha_creacion', [$startDate, $endDate])
            ->sum('SubTotal');

        $total_comprobantes_semanal = ventas::whereNotIn('venta_estado', ['B'])
            ->whereNotIn('tipo_comprobante', ['N'])
            ->whereBetween('fecha_creacion', [$startDate, $endDate])
            ->sum('SubTotal');

        $fechas_barra_venta = [];
        $firstData_barra_venta = [];
        $secondData_barra_venta = [];

        for ($date = $startDate_carbon; $date->lte($endDate_carbon); $date->addDay()) {
            $fechas_barra_venta[] = $date->toDateString();
            $total_notas_de_venta = ventas::whereNotIn('venta_estado', ['B'])
                ->where('tipo_comprobante', '=', 'N')
                ->where('fecha_creacion', $date->toDateString())
                ->sum('SubTotal');

            $total_comprobantes = ventas::whereNotIn('venta_estado', ['B'])
                ->whereNotIn('tipo_comprobante', ['N'])
                ->where('fecha_creacion', $date->toDateString())
                ->sum('SubTotal');

            $firstData_barra_venta[] = $total_notas_de_venta;
            $secondData_barra_venta[] = $total_comprobantes;
        }
        /* *********************** */

        return [
            'total_cobrado_nota_venta' => $total_cobrado_nota_venta,
            'total_cobrado_comprobante' => $total_cobrado_comprobante,
            'total_credito_comprobante' => $total_credito_comprobante,
            /* ******** variables para reporte de barras  ************* */
            'fechas_barra_venta' => $fechas_barra_venta,
            'firstData_barra_venta' => $firstData_barra_venta,
            'secondData_barra_venta' => $secondData_barra_venta,
            'total_notas_de_venta_semanal' => $total_notas_de_venta_semanal,
            'total_comprobantes_semanal' => $total_comprobantes_semanal,
        ];
    }

    //reporte documento

    public function load_data_documento(Request $req)
    {
        try {
            $datax = $req->all();
            $datos = [];

            if ($datax['por_mes']) {
                $datos = $this->por_mes_documento($datax['fecha_por_mes'], $datax['comprobante'], $datax['cli_id'], $datax['is_load']);
            }
            if ($datax['entres_meses']) {
                $datos = $this->entres_meses_documento($datax['start_mounth'], $datax['end_mounth'], $datax['comprobante'], $datax['cli_id']);
            }
            if ($datax['por_fecha']) {
               
                $datos = $this->por_fecha_documento($datax['fecha_por_date'], $datax['comprobante'], $datax['cli_id']);
            }
            if ($datax['entre_fechas']) {
                $datos = $this->entre_fechas_documento($datax['start_date'], $datax['end_date'],$datax['comprobante'], $datax['cli_id']);
            }

            return response()->json([
                'message' => 'datos cargados',
                'error' => '',
                'success' => true,
                'data' => $datos,
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'message' => 'error al buscar los datos',
                'error' => $th->getMessage(),
                'success' => false,
                'data' => '',
            ]);
        }
    }

    private function por_mes_documento($fecha, $comprobante, $cliente, $is_load)
    {
        if ($is_load) {
            $fecha_load = Carbon::parse($fecha);
            $year = $fecha_load->format('Y');
            $month = $fecha_load->format('m');
        } else {
            $year = $fecha['year'];
            $month = $fecha['month'] + 1;
        }

        if ($comprobante == 'S') {
            if ($cliente == 0) {
                $datatable = ventas::with([
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
                ])
                    ->whereYear('fecha_creacion', $year)
                    ->whereMonth('fecha_creacion', $month)
                    ->get();

                $total = ventas::whereYear('fecha_creacion', $year)
                    ->whereMonth('fecha_creacion', $month)
                    ->sum('SubTotal');
            } else {
                $datatable = ventas::with([
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
                ])
                    ->where('cli_id', $cliente)
                    ->whereYear('fecha_creacion', $year)
                    ->whereMonth('fecha_creacion', $month)
                    ->get();

                $total = ventas::where('cli_id', $cliente)
                    ->whereYear('fecha_creacion', $year)
                    ->whereMonth('fecha_creacion', $month)
                    ->sum('SubTotal');
            }
        } else {
            if ($cliente == 0) {
                $datatable = ventas::with([
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
                ])
                    ->where('tipo_comprobante', '=', $comprobante)
                    ->whereYear('fecha_creacion', $year)
                    ->whereMonth('fecha_creacion', $month)
                    ->get();

                $total = ventas::where('tipo_comprobante', '=', $comprobante)
                    ->whereYear('fecha_creacion', $year)
                    ->whereMonth('fecha_creacion', $month)
                    ->sum('SubTotal');
            } else {
                $datatable = ventas::with([
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
                ])
                    ->where('cli_id', $cliente)
                    ->where('tipo_comprobante', '=', $comprobante)
                    ->whereYear('fecha_creacion', $year)
                    ->whereMonth('fecha_creacion', $month)
                    ->get();

                $total = ventas::where('cli_id', $cliente)
                    ->where('tipo_comprobante', '=', $comprobante)
                    ->whereYear('fecha_creacion', $year)
                    ->whereMonth('fecha_creacion', $month)
                    ->sum('SubTotal');
            }
        }

        return [
            'total' => $total,
            'datatable' => $datatable,
        ];
    }
    private function entres_meses_documento($start, $end,$comprobante,$cliente)
    {
        $fecha = $end['year'] . '-' . $this->aumentarCeroAIzquierda($end['month'] + 1) . '-01';
        $carbon = Carbon::parse($fecha);

        $startDate = $start['year'] . '-' . $this->aumentarCeroAIzquierda($start['month'] + 1) . '-01';
        $endDate = $carbon->endOfMonth();


        if ($comprobante == 'S') {
            if ($cliente == 0) {
                $datatable = ventas::with([
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
                ])
                ->whereBetween('fecha_creacion', [$startDate, $endDate])
                    ->get();

                $total = ventas::whereBetween('fecha_creacion', [$startDate, $endDate])
                    ->sum('SubTotal');
            } else {
                $datatable = ventas::with([
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
                ])
                    ->where('cli_id', $cliente)
                    ->whereBetween('fecha_creacion', [$startDate, $endDate])
                    ->get();

                $total = ventas::where('cli_id', $cliente)
                    ->whereBetween('fecha_creacion', [$startDate, $endDate]) 
                    ->sum('SubTotal');
            }
        } else {
            if ($cliente == 0) {
                $datatable = ventas::with([
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
                ])
                    ->where('tipo_comprobante', '=', $comprobante)
                    ->whereBetween('fecha_creacion', [$startDate, $endDate]) 
                    ->get();

                $total = ventas::where('tipo_comprobante', '=', $comprobante)
                ->whereBetween('fecha_creacion', [$startDate, $endDate])
                    ->sum('SubTotal');
            } else {
                $datatable = ventas::with([
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
                ])
                    ->where('cli_id', $cliente)
                    ->where('tipo_comprobante', '=', $comprobante)
                    ->whereBetween('fecha_creacion', [$startDate, $endDate])
                    ->get();

                $total = ventas::where('cli_id', $cliente)
                    ->where('tipo_comprobante', '=', $comprobante)
                    ->whereBetween('fecha_creacion', [$startDate, $endDate])
                    ->sum('SubTotal');
            }
        }

        return [
            'total' => $total,
            'datatable' => $datatable,
        ];

 
    }
    private function por_fecha_documento($fecha,$comprobante,$cliente)
    {
        $fecha = Carbon::parse($fecha)->subDays(1)->format('Y-m-d');
 
 
        if ($comprobante == 'S') {
            if ($cliente == 0) {
                $datatable = ventas::with([
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
                ])
                ->where('fecha_creacion', $fecha)
                    ->get();
 

                $total = ventas::where('fecha_creacion', $fecha)
                    ->sum('SubTotal');
            } else {
                
                $datatable = ventas::with([
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
                ])
                    ->where('cli_id', $cliente)
                    ->where('fecha_creacion', $fecha)
                    ->get();
                 
                $total = ventas::where('cli_id', $cliente)
                    ->where('fecha_creacion', $fecha)
                    ->sum('SubTotal');
            }
        } else {
            if ($cliente == 0) {
                $datatable = ventas::with([
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
                ])
                    ->where('tipo_comprobante', '=', $comprobante)
                    ->where('fecha_creacion', $fecha)
                    ->get();
                  
                $total = ventas::where('tipo_comprobante', '=', $comprobante)
                    ->where('fecha_creacion', $fecha)
                    ->sum('SubTotal');
            } else {
                $datatable = ventas::with([
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
                ])
                    ->where('cli_id', $cliente)
                    ->where('tipo_comprobante', '=', $comprobante)
                    ->where('fecha_creacion', $fecha)
                    ->get();
                   
                $total = ventas::where('cli_id', $cliente)
                    ->where('tipo_comprobante', '=', $comprobante)
                    ->where('fecha_creacion', $fecha)
                    ->sum('SubTotal');
            }
        }

        return [
            'total' => $total,
            'datatable' => $datatable,
        ];

    }
    private function entre_fechas_documento($startDate, $endDate,$comprobante,$cliente)
    {
        $startDate = Carbon::parse($startDate)->format('Y-m-d');
        $endDate = Carbon::parse($endDate)->format('Y-m-d');

        $startDate_carbon = Carbon::parse($startDate);
        $endDate_carbon = Carbon::parse($endDate);
 

        if ($comprobante == 'S') {
            if ($cliente == 0) {
                $datatable = ventas::with([
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
                ])
                ->whereBetween('fecha_creacion', [$startDate, $endDate])
                    ->get();
 

                $total = ventas::whereBetween('fecha_creacion', [$startDate, $endDate])
                    ->sum('SubTotal');
            } else {
                
                $datatable = ventas::with([
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
                ])
                    ->where('cli_id', $cliente)
                    ->whereBetween('fecha_creacion', [$startDate, $endDate])
                    ->get();
                 
                $total = ventas::where('cli_id', $cliente)
                    ->whereBetween('fecha_creacion', [$startDate, $endDate])
                    ->sum('SubTotal');
            }
        } else {
            if ($cliente == 0) {
                $datatable = ventas::with([
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
                ])
                    ->where('tipo_comprobante', '=', $comprobante)
                    ->whereBetween('fecha_creacion', [$startDate, $endDate])
                    ->get();
                  
                $total = ventas::where('tipo_comprobante', '=', $comprobante)
                    ->whereBetween('fecha_creacion', [$startDate, $endDate])
                    ->sum('SubTotal');
            } else {
                $datatable = ventas::with([
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
                ])
                    ->where('cli_id', $cliente)
                    ->where('tipo_comprobante', '=', $comprobante)
                    ->whereBetween('fecha_creacion', [$startDate, $endDate])
                    ->get();
                   
                $total = ventas::where('cli_id', $cliente)
                    ->where('tipo_comprobante', '=', $comprobante)
                    ->whereBetween('fecha_creacion', [$startDate, $endDate])
                    ->sum('SubTotal');
            }
        }

        return [
            'total' => $total,
            'datatable' => $datatable,
        ];
    }
}
