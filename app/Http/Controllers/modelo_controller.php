<?php

namespace App\Http\Controllers;

use App\Models\modelo;
use App\Models\tipo_vehiculo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class modelo_controller extends Controller
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
            return DataTables::of(
                modelo::with(['marca', 'tipovehiculo'])
                    ->orderBy('created_at', 'asc')
                    ->get(),
            )
                ->addColumn('action', static function ($Data) {
                    $modelo_id = encrypt_id($Data->modelo_id);
                    return view('buttons.modelo', ['modelo_id' => $modelo_id]);
                })
                ->addColumn('fecha_creacion', static function ($Data) {
                    return Carbon::parse($Data->created_at)->format("d/m/Y");
                })
                ->toJson();
        }

        $html = $builder
            ->columns([
                Column::make('modelo_nombre')->title('Nombre Modelo'),
                Column::make('marca.marca_nombre')->title('Nombre Marca'),
                Column::make('tipovehiculo.tipo_vehiculo_nombre')->title('Tipo vehiculo'),
                Column::make('precio_gasolina')->title('Precio Gasolina'),
                Column::make('cilindraje')->title('Cilindraje'),
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
                'processing' => false,
                'serverSide' => true,
                'responsive' => true,
                'autoWidth' => false,
            ]);
        //php artisan vendor:publish --tag=datatables-buttons

        return view('modules.modelo.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipo_vehiculo = tipo_vehiculo::all();
        $tipo_vehiculo_select = tipo_vehiculo::first(); 

        return view('modules.modelo.create',compact("tipo_vehiculo","tipo_vehiculo_select"));
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
            $datax = $request->all();

            $validatedData = $request->validate([
                'modelo_nombre' => 'required|max:249',
                'precio_gasolina' => 'required',
                'cilindraje' => 'required|numeric',
                'marca_id' => 'required',
                'tipo_vehiculo_id' => 'required',
            ]);
  
            $create = modelo::create($validatedData);

            if ($create) {
               
                    session()->flash('success', 'Registro creado correctamente');
                    return redirect()->route('modelo.index');
               
            } else {
                Log::error('no se pudo registrar el modelo');
                session()->flash('error', 'error al registrar en la base de datos');
                return redirect()->route('modelo.index');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al registrar');
            return redirect()->route('modelo.index');
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
        $get = modelo::with([
            'marca', 'tipovehiculo'
        ])->find(decrypt_id($id));
 

        if ($get) {
            $tipo_vehiculo = tipo_vehiculo::all();
            return view('modules.modelo.edit', ['get' => $get, 'id' => $id,'tipo_vehiculo' => $tipo_vehiculo]);
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
        
            $update = modelo::where('modelo_id', decrypt_id($id));
            $datax = $request->all(); 
            $validate = $request->validate([
                'modelo_nombre' => 'required|max:249',
                'precio_gasolina' => 'required',
                'cilindraje' => 'required|numeric',
                'marca_id' => 'required',
                'tipo_vehiculo_id' => 'required',
            ]);
 

            $update = $update->update($validate);

            if ($update) {
                session()->flash('success', 'Registro editado correctamente');
                return redirect()->route('modelo.index');
            } else {
                Log::error('no se pudo editar el modelo');
                session()->flash('error', 'error al editar en la base de datos');
                return redirect()->route('modelo.index');
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

            $caja = modelo::findOrFail(decrypt_id($id));
          
            if ($caja->moto()->exists()) {
                session()->flash('warning', 'No se puede eliminar esta modelo por que se esta usando en otros registros');
                return redirect()->route('modelo.index');
            } else {
                $delete = $caja->delete(); 
                if ($delete) {
                    session()->flash('success', 'se elimino correctamente el modelo');
                    return redirect()->route('modelo.index');
                } else {
                    session()->flash('success', 'error al eliminar el modelo');
                    return redirect()->route('modelo.index');
                }
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al eliminar este registro');
            return redirect()->route('modelo.index');
        }
    }

    /* ******** vue api ************* */

    public function search_modelo(Request $request)
    {
        $search = $request->input('search');

        $modelo = modelo::select('modelo.modelo_id as id', DB::raw("CONCAT(marca.marca_nombre, '-', modelo.modelo_nombre, '-', modelo.cilindraje) as name"))
            ->join('marca', 'modelo.marca_id', '=', 'marca.marca_id')
            ->where(function ($query) use ($search) {
                $query->where('modelo.modelo_nombre', 'like', '%' . $search . '%')->orWhere('marca.marca_nombre', 'like', '%' . $search . '%');
            })
            ->get(15);

        echo json_encode($modelo);
    }

    /* *********************** */

    public function get_modelo(Request $request){
        try {
            $modelo = modelo::find($request->all()['modelo_id']);

            if ($modelo) {
                return response()->json([
                    'message' => 'datos encontrados',
                    'error' => '',
                    'success' => true,
                    'data' => $modelo,
                ]);
            } else {
                Log::error('error al buscar los datos:modelo');
                return response()->json([
                    'message' => 'error al buscar los datos',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
            }
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
