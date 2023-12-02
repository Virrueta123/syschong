<?php

namespace App\Http\Controllers;

use App\Models\tipo_cliente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Illuminate\Validation\Rule;

class tipo_cliente_controller extends Controller
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
                tipo_cliente::
                     orderBy('created_at', 'asc')
                    ->get(),
            )
                ->addColumn('action', static function ($Data) {
                    $tipo_cliente_id = encrypt_id($Data->tipo_cliente_id);
                    return view('buttons.tipo_cliente', ['tipo_cliente_id' => $tipo_cliente_id]);
                })
                ->addColumn('fecha_creacion', static function ($Data) {
                    return Carbon::parse($Data->created_at)->format("d/m/Y");
                })
                ->toJson();
        }

        $html = $builder
            ->columns([
                Column::make('tipo_cliente_nombre')->title('Nombre tipo cliente'), 
                Column::make('fecha_creacion')->title('Fecha creacion'),
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
                'processing' => true,
                'serverSide' => true,
                'responsive' => true,
                'autoWidth' => false,
            ]);
        //php artisan vendor:publish --tag=datatables-buttons

        return view('modules.tipo_cliente.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modules.tipo_cliente.create');
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

        $validatedData = $request->validate([
            'tipo_cliente_nombre' => 'required|max:249|unique:tipo_cliente',
        ]);

        $create = tipo_cliente::create($validatedData);

        if ($create) {
            session()->flash('success', 'Registro creado correctamente');
            return redirect()->route('tipo_cliente.index');
        } else {
            Log::error('no se pudo registrar la tipo cliente');
            session()->flash('error', 'error al registrar en la base de datos');
            return redirect()->route('tipo_cliente.index');
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
        $edit = tipo_cliente::findOrFail(decrypt_id($id));
  
        if ($edit) { 
            return view('modules.tipo_cliente.edit', ['edit' => $edit, 'id' => $id]);
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
        $datax = $request->all();
        $tipo_cliente_id = decrypt_id($id);

        $update = tipo_cliente::findOrFail($tipo_cliente_id);

        $validatedData = Validator::make(
            $request->all(),
            [ 
                'tipo_cliente_nombre' => [
                    'required',
                    'max:249',
                    Rule::unique('tipo_cliente')->where(function ($query) use ($tipo_cliente_id) {
                        $query->where('tipo_cliente_id', '!=', $tipo_cliente_id);
                    }),
                ], 
            ],
            [
                'tipo_cliente_nombre.unique' => 'Este tipo de cliente ya existe en el sistema.', 
            ],
        )->validate();

        $update = $update->update($validatedData);

        if ($update) {
            session()->flash('success', 'Registro editado correctamente');
            return redirect()->route('tipo_cliente.index');
        } else {
            Log::error('no se pudo registrar el tipo cliente');
            session()->flash('error', 'error al editar en la base de datos');
            return redirect()->route('tipo_cliente.index');
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
            $caja = tipo_cliente::findOrFail(decrypt_id($id));

            if ($caja->cliente()->exists()) {
                session()->flash('warning', 'No se puede eliminar este tipo de cliente por que se esta usando en otros registros');
                return redirect()->route('tipo_cliente.index');
            } else {
                $delete = $caja->delete();
                if ($delete) {
                    session()->flash('success', 'se elimino correctamente el tipo de cliente');
                    return redirect()->route('tipo_cliente.index');
                } else {
                    session()->flash('success', 'error al eliminar el tipo de cliente');
                    return redirect()->route('tipo_cliente.index');
                }
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al eliminar este registro');
            return redirect()->route('tipo_cliente.index');
        }
    }
}
