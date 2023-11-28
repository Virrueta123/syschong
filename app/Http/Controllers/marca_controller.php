<?php

namespace App\Http\Controllers;

use App\Models\marca;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class marca_controller extends Controller
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
                marca::with(['modelo'])
                    ->orderBy('created_at', 'asc')
                    ->get(),
            )
                ->addColumn('action', static function ($Data) {
                    $marca_id = encrypt_id($Data->marca_id);
                    return view('buttons.marca', ['marca_id' => $marca_id]);
                })
                ->addColumn('modelos', static function ($Data) {
                    return count($Data->modelo);
                })
                ->addColumn('fecha_creacion', static function ($Data) {
                    return Carbon::parse($Data->created_at)->format('d/m/Y');
                })
                ->toJson();
        }

        $html = $builder
            ->columns([
                Column::make('marca_nombre')->title('Nombre Marca'),
                Column::make('modelos')->title('Numero de modelos con esta marca'),
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

        return view('modules.marca.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modules.marca.create');
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
            'marca_nombre' => 'required|max:249|unique:marca',
        ]);

        $create = marca::create($validatedData);

        if ($create) {
            session()->flash('success', 'Registro creado correctamente');
            return redirect()->route('marca.index');
        } else {
            Log::error('no se pudo registrar la marca');
            session()->flash('error', 'error al registrar en la base de datos');
            return redirect()->route('marca.index');
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
        $edit = marca::find(decrypt_id($id));
 

        if ($edit) { 
            return view('modules.marca.edit', ['edit' => $edit, 'id' => $id]);
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

        $update = marca::where('marca_id', decrypt_id($id));
        $datax = $request->all(); 

        $validate = $request->validate([
            'marca_nombre' => 'required|max:249|unique:marca',
        ]);


        $update = $update->update($validate);

        if ($update) {
            session()->flash('success', 'Registro editado correctamente');
            return redirect()->route('marca.index');
        } else {
            Log::error('no se pudo editar marca');
            session()->flash('error', 'error al editar en la base de datos');
            return redirect()->route('marca.index');
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
            $caja = marca::findOrFail(decrypt_id($id));

            if ($caja->modelo()->exists()) {
                session()->flash('warning', 'No se puede eliminar esta marca por que se esta usando en otros registros');
                return redirect()->route('marca.index');
            } else {
                $delete = $caja->delete();
                if ($delete) {
                    session()->flash('success', 'se elimino correctamente la marca');
                    return redirect()->route('marca.index');
                } else {
                    session()->flash('success', 'error al eliminar la marca');
                    return redirect()->route('marca.index');
                }
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al eliminar este registro');
            return redirect()->route('marca.index');
        }
    }

    /* ******** api ************* */

    public function marca_search(Request $req)
    {
        $cliente = marca::select(DB::raw('marca_id AS id'), 'marca_nombre as name')
            ->where('marca_nombre', 'like', '%' . $req->all()['search'] . '%')
            ->limit(7)
            ->get();
        echo json_encode($cliente);
    }

    /* *********************** */

    /* ******** crear marca vue ************* */

    public function marca_store_vue(Request $request)
    {
        try {
            $datax = $request->all();
            $validate = $request->validate([
                'marca_nombre' => 'required|string|max:200',
            ]);
            $validate['user_id'] = Auth::user()->id;

            $unique_marca_nombre = marca::where('marca_nombre', $datax['marca_nombre'])->first();

            if ($unique_marca_nombre) {
                return response()->json([
                    'message' => 'Esta marca ya existe',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
            } else {
                $create = marca::create($validate);
                if ($create) {
                    return response()->json([
                        'message' => 'se creo correctamente una marca',
                        'error' => '',
                        'success' => true,
                        'data' => ['value' => $create->marca_id, 'title' => $create->marca_nombre],
                    ]);
                } else {
                    Log::error('no se pudo registrar la marca');
                    return response()->json([
                        'message' => 'no se pudo registrar la marca',
                        'error' => '',
                        'success' => false,
                        'data' => '',
                    ]);
                }
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'message' => 'error del servidor',
                'error' => $th,
                'success' => false,
                'data' => '',
            ]);
        }
    }

    /* *********************** */
}
