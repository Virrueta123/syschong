<?php

namespace App\Http\Controllers;

use App\Imports\proveedores_import;
use App\Models\cliente;
use App\Models\proveedores;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class proveedores_controller extends Controller
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
            return DataTables::of(proveedores::with(['usuario']))
                ->addColumn('action', static function ($Data) {
                    $proveedor_id = encrypt_id($Data->proveedor_id);
                    return view('buttons.proovedores', ['proveedor_id' => $proveedor_id]);
                })
                ->addColumn('estado', static function ($Data) {
                    switch ($Data->estado) {
                        case 'A':
                            return ' Activo';
                            break;

                        case 'D':
                            return ' Desactivado';
                            break;
                    }
                })
                ->addColumn('documento', static function ($Data) {
                    if ($Data->proveedor_dni == 'no tiene') {
                        return 'Ruc';
                    } else {
                        return 'Dni';
                    }
                })
                ->addColumn('ndocumento', static function ($Data) {
                    if ($Data->proveedor_dni == 'no tiene') {
                        return $Data->proveedor_ruc;
                    } else {
                        return $Data->proveedor_dni;
                    }
                })

                ->addColumn('nombre', static function ($Data) {
                    if ($Data->proveedor_dni != 'no tiene') {
                        return $Data->proveedor_nombre;
                    } else {
                        return $Data->proveedor_razon_social;
                    }
                })
                ->addColumn('fecha_creacion', function ($Data) {
                    return Carbon::parse($Data->created_at)->format('d-m-Y');
                })
                ->toJson();
        }

        $html = $builder
            ->columns([
                Column::computed('documento')->title('Tipo de documento'),
                Column::computed('ndocumento')->title('documento'),
                Column::computed('nombre')->title('Nombre'),
                Column::make('proveedor_nombre_comercial')->title('nombre comercial'),
                Column::make('proveedor_contacto1')->title('Contacto 1'),
                Column::make('proveedor_contacto2')->title('Contacto 2'),
                Column::make('proveedor_departamento')->title('departamento'),
                Column::make('proveedor_provincia')->title('provincia'),
                Column::make('proveedor_distrito')->title('proveedor_distrito'),
                Column::make('usuario.name')->title('usuario'),
                Column::computed('estado')->title('estado'),
                Column::computed('fecha_creacion')->title('F. creacion')->exportFormat('mm/dd/yyyy'),
                Column::computed('action')
                    ->title('Opcion')
                    ->exportable(false)
                    ->printable(true),
            ])
            
            ->selectStyleSingle()  
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

        return view('modules.proveedores.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modules.proveedores.create');
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
           
           
            $request->merge([
                'proveedor_contacto2' => $request->input('proveedor_contacto2', 'no tiene'),
                'proveedor_direccion' => $request->input('proveedor_direccion', 'no tiene'),
                'proveedor_departamento' => $request->input('proveedor_departamento', 'no tiene'),
                'proveedor_provincia' => $request->input('proveedor_provincia', 'no tiene'),
                'proveedor_distrito' => $request->input('proveedor_distrito', 'no tiene'),
                'proveedor_email' => $request->input('proveedor_email', 'no tiene'),
                'proveedor_nombre_comercial' => $request->input('proveedor_nombre_comercial', 'no tiene'),
            ]);
         
            if (isset($datax['proveedor_dni'])) {
                $validate = $request->validate(
                    [
                        'proveedor_dni' => 'required|string|max:11|unique:proveedor,proveedor_dni',
                        'proveedor_nombre' => 'required|string|max:255|unique:proveedor,proveedor_nombre',
                        'proveedor_contacto1' => 'required|string|max:45',
                        'proveedor_contacto2' => 'nullable|string|max:45',
                        'proveedor_direccion' => 'nullable|string|max:255',
                        'proveedor_departamento' => 'nullable|string|max:255',
                        'proveedor_provincia' => 'nullable|string|max:255',
                        'proveedor_distrito' => 'nullable|string|max:255',
                        'proveedor_email' => 'nullable|string|max:255', 
                    ],
                    [
                        'proveedor_dni.required' => 'El campo DNI del proveedor es obligatorio.',
                        'proveedor_dni.max' => 'El DNI del proveedor no puede tener más de 11 caracteres.',
                        'proveedor_dni.unique' => 'El DNI del proveedor ya existe en la base de datos.',
                        'proveedor_nombre.required' => 'El campo Nombre del proveedor es obligatorio.',
                        'proveedor_nombre.max' => 'El Nombre del proveedor no puede tener más de 255 caracteres.',
                        // Add custom error messages for other fields as needed
                    ],
                );
            } else {
                $validate = $request->validate(
                    [
                        'proveedor_ruc' => 'required|string|max:11|unique:proveedor,proveedor_ruc',
                        'proveedor_razon_social' => 'required|string|max:255|unique:proveedor,proveedor_razon_social',
                        'proveedor_nombre_comercial' => 'nullable|string|max:45',
                        'proveedor_contacto1' => 'required|string|max:45',
                        'proveedor_contacto2' => 'nullable|string|max:45',
                        'proveedor_direccion' => 'nullable|string|max:255',
                        'proveedor_departamento' => 'nullable|string|max:255',
                        'proveedor_provincia' => 'nullable|string|max:255',
                        'proveedor_distrito' => 'nullable|string|max:255',
                        'proveedor_email' => 'nullable|string|max:255', 
                    ],
                    [
                        'proveedor_ruc.required' => 'El campo RUC del proveedor es obligatorio.',
                        'proveedor_ruc.max' => 'El RUC del proveedor no puede tener más de 11 caracteres.',
                        'proveedor_ruc.unique' => 'El RUC del proveedor ya existe en la base de datos.',
                        'proveedor_razon_social.required' => 'El campo Razón Social del proveedor es obligatorio.',
                        'proveedor_razon_social.max' => 'La Razón Social del proveedor no puede tener más de 255 caracteres.',
                        // Add custom error messages for other fields as needed
                    ],
                );
               
            }

            $validate['proveedor_contacto1'] = str_replace('-', '', $validate['proveedor_contacto1']);
            if(isset($validate['proveedor_contacto2'])){
                $validate['proveedor_contacto2'] = str_replace('-', '', $validate['proveedor_contacto2']);
            }

            $validate['user_id'] = Auth::user()->id;

            $create = proveedores::create($validate);

            if ($create) {
                session()->flash('success', 'Registro creado correctamente');
                return redirect()->route('proveedores.index');
            } else {
                Log::error('no se pudo registrar el proveedores');
                session()->flash('error', 'error al registrar en la base de datos');
                return redirect()->route('proveedores.index');
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

    public function importar()
    {
        return view('modules.proveedores.importar');
    }

    public function importar_proveedores(Request $request)
    {
        Excel::import(new proveedores_import(), $request->file('file'));
    }
    /* ******** buscando servicios peticion via ajax ************* */
}
