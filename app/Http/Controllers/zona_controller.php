<?php

namespace App\Http\Controllers;

use App\Models\zona;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class zona_controller extends Controller
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
            return DataTables::of(zona::orderBy('created_at', 'asc')->get())
                ->addColumn('action', static function ($Data) {
                    $zona_id = encrypt_id($Data->zona_id);
                    return view('buttons.zona', ['zona_id' => $zona_id]);
                })
                ->addColumn('creacion', static function ($Data) {
                    $venta_id = encrypt_id($Data->venta_id);
                    return Carbon::parse($Data->created_at)->format('d/m/Y');
                })

                ->toJson();
        }

        $html = $builder
            ->columns([
                Column::make('zona_nombre')->title('Nombre'),
                Column::make('creacion')->title('Fecha de Creacion'), 
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

        return view('modules.zona.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modules.zona.create');
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
           
            $validate = $request->validate([
                'zona_nombre' => 'required|string|max:249|unique:zona'
            ]);

            $validate['user_id'] = Auth::user()->id;

            $create = zona::create($validate);
             
            if ($create) {
                session()->flash('success', 'se creo correctamente una nueva zona de producto');
                return redirect()->route('zona.index');
            } else {
                Log::error('no se pudo registrar la nueva zona de producto');
                session()->flash('error', 'error al registrar en la base de datos');
                return redirect()->route('zona.index');
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
        try {
            $get = zona::find(decrypt_id($id));

            if ($get) {
                return view('modules.zona.edit', ['get' => $get, 'id' => $id]);
            } else {
                return view('errors.404');
            }
        } catch (\Throwable $th) {
            Log::error(json_encode($th->getMessage(), true));

            session()->flash('error', 'error al entrar a esta ruta');
            return redirect()->back();
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
      
            $update = zona::find( decrypt_id($id));
            $datax = $request->all();
        
            $validate = $request->validate([
                'zona_nombre' => 'required|string|max:249|unique:zona'
            ]);

            $validate['user_id'] = Auth::user()->id;

            $update = $update->update($validate);

            if ($update) {
                session()->flash('success', 'Registro editado correctamente');
                return redirect()->route('zona.index');
            } else {
                Log::error('no se pudo registrar la zona');
                session()->flash('error', 'error al editar en la base de datos');
                return redirect()->route('zona.index');
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
            $destroy = zona::find(  decrypt_id($id));
            $destroy->delete();

            if ($destroy) {
                session()->flash('success', 'Registro eliminado correctamente');
                return redirect()->route('zona.index');
            } else {
                Log::error('no se pudo eliminar la zona');
                session()->flash('error', 'error al eliminar en la base de datos');
                return redirect()->route('zona.index');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al eliminar');
            return redirect()->route('zona.index');
        }   
    }

    /* ******** api ************* */

    public function search(Request $req)
    {
        $zona = zona::select(DB::raw('zona_id AS id'), 'zona_nombre as name')
            ->where('zona_nombre', 'like', '%' . $req->all()['search'] . '%')
            ->limit(7)
            ->get();
        echo json_encode($zona);
    }

    /* *********************** */

    /* ******** crear marca_producto vue ************* */

    public function store_vue(Request $request)
    {
        try {
            $datax = $request->all();
            $validate = $request->validate([
                'zona_nombre' => 'required|string|max:250',
            ]);
            $validate['user_id'] = Auth::user()->id;

            $unique_zona_nombre = zona::where('zona_nombre', $datax['zona_nombre'])->first();

            if ($unique_zona_nombre) {
                return response()->json([
                    'message' => 'Esta zona ya existe',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
            } else {
                $create = zona::create($validate);
                if ($create) {
                    return response()->json([
                        'message' => 'se creo correctamente una zona',
                        'error' => '',
                        'success' => true,
                        'data' => ['value' => $create->zona_id, 'title' => $create->zona_nombre],
                    ]);
                } else {
                    Log::error('no se pudo registrar la zona');
                    return response()->json([
                        'message' => 'no se pudo registrar la zona',
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
