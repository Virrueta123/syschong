<?php

namespace App\Http\Controllers;

use App\Models\forma_pago;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class forma_pago_controller extends Controller
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
            return DataTables::of(forma_pago::orderBy('created_at', 'asc')->get())

                ->addColumn('action', static function ($Data) {
                    $forma_pago_id = encrypt_id($Data->forma_pago_id);
                    $no_delete = $Data->no_delete;

                    return view('buttons.forma_pago', ['forma_pago_id' => $forma_pago_id, 'no_delete' => $no_delete]);
                })
                ->addColumn('estado', static function ($Data) {
                    return view("buttons.estado",['estado' => $Data->estado ]);
                   
                })
                ->addColumn('created_at', static function ($Data) {
                    return Carbon::parse($Data->created_at)->format('Y-m-d');
                })
                ->make(true);
        }

        $html = $builder
            ->columns([
                Column::make('created_at')->title('Fecha creacion'),
                Column::make('forma_pago_nombre')->title('Nombre'),
                Column::make('estado')->title('Estado'),
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

        return view('modules.forma_pago.index', compact('html'));
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function estado($id)
    {
        try {
            $update = forma_pago::find(decrypt_id($id));
            $forma_pago = forma_pago::find(decrypt_id($id));

            if ($forma_pago->estado == 'A') {
                $estado = 'D';
            } else {
                $estado = 'A';
            }

            $update = $update->update(['estado' => $estado]);

            if ($update) {
                session()->flash('success', 'estado actualizado correctamente');
                return redirect()->route('forma_pago.index');
            } else {
                Log::error('falla al cambiar estado');
                session()->flash('error', 'error al editar en la base de datos');
                return redirect()->route('forma_pago.index');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al editar');
            return redirect()->route('forma_pago.index');
        }
    }
}
