<?php

namespace App\Http\Controllers;

use App\Models\compra;
use App\Models\compras;
use App\Models\forma_pago;
use App\Models\pagos_ventas;
use App\Models\ventas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class reportes_vue_controller extends Controller
{
    public function reporte_ventas(Request $request)
    {
        try {
            $id = decrypt_id($request->input('caja_chica_id'));

            /* ******** reporte pagos ************* */

            $forma_pago = forma_pago::where('estado', 'A')->get();

            $labels_pago_venta = [];
            $data_pago_venta = [];

            foreach ($forma_pago as $fg) {
                $pagos_ventas = pagos_ventas::with([
                    'forma_pago',
                    'ventas' 
                ])
                    ->where('tipo', 'V')
                    ->where('forma_pago_id', $fg->forma_pago_id)
                    ->where("caja_chica_id", $id)
                    ->get()
                    ->sum('monto');

                array_push($labels_pago_venta, $fg->forma_pago_nombre);
                array_push($data_pago_venta, $pagos_ventas);
            }

            $labels_pago_compras = [];
            $data_pago_compras = [];

            foreach ($forma_pago as $fg) {
                $pagos_compras = pagos_ventas::with([
                    'forma_pago',
                    'ventas' 
                ])
                    ->where('tipo', 'C')
                    ->where('forma_pago_id', $fg->forma_pago_id)
                    ->where("caja_chica_id", $id)
                    ->get()
                    ->sum('monto');
                array_push($labels_pago_compras, $fg->forma_pago_nombre);
                array_push($data_pago_compras, $pagos_compras);
            }
            /* *********************** */

            $forma_pago = forma_pago::where('caja_chica_id', $id);

            $ventas_boleta_legend = ventas::where('tipo_comprobante', 'B')
                ->where('caja_chica_id', $id)
                ->get()
                ->sum('SubTotal');
            $ventas_factura_legend = ventas::where('tipo_comprobante', 'F')
                ->where('caja_chica_id', $id)
                ->get()
                ->sum('SubTotal');
            $ventas_nota_venta_legend = ventas::where('tipo_comprobante', 'N')
                ->where('caja_chica_id', $id)
                ->get()
                ->sum('SubTotal');

            $ventas_boleta_labels_compras = compras::where('t_comprobante', 'B')
                ->where('caja_chica_id', $id)
                ->get()
                ->sum('total');
            $ventas_factura_labels_compras = compras::where('t_comprobante', 'F')
                ->where('caja_chica_id', $id)
                ->get()
                ->sum('total');
            $ventas_nota_venta_labels_compras = compras::where('t_comprobante', 'N')
                ->where('caja_chica_id', $id)
                ->get()
                ->sum('total');

            $data = [$ventas_boleta_legend, $ventas_factura_legend, $ventas_nota_venta_legend];
            $labels = ['Ventas Boleta', 'Ventas Factura', 'Ventas nota de venta'];

            $data_compras = [$ventas_boleta_labels_compras, $ventas_factura_labels_compras, $ventas_nota_venta_labels_compras];
            $labels_compras = ['Compras Boleta', 'Compras Factura', 'Compras nota de venta'];

            return response()->json([
                'message' => 'reportes cargando correctamente',
                'error' => '',
                'success' => true,
                'data' => [
                    'compras' => ['data' => $data_compras, 'labels' => $labels_compras],
                    'ventas' => ['data' => $data, 'labels' => $labels],
                    'pago_venta' => ['data' => $data_pago_venta, 'labels' => $labels_pago_venta],
                    'pago_compra' => ['data' => $data_pago_compras, 'labels' => $labels_pago_compras],
                ],
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

    public function load_numero_comprobante()
    {
        try {
            $monto_total_comprobantes = 0;

            $monto_total_notas_ventas = 2;

            $monto_total_general = 20;

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
                'error' => $th,
                'success' => false,
                'data' => '',
            ]);
        }
    }
}
