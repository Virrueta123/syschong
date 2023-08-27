<?php

namespace App\Http\Controllers;

use App\Imports\ProductoImport;
use App\Models\imagen_producto;
use App\Models\marca;
use App\Models\producto;
use App\Models\producto_marcas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class producto_controller extends Controller
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
    public function index(Request $request)
    {
        $fecha_actual = Carbon::now();
        if ($request->ajax()) {
            $producto = producto::with(['marca_producto'])
                ->orderBy('created_at', 'desc')
                ->get();

            return DataTables::of($producto)
                ->addIndexColumn()
                ->addColumn('fecha_creacion', function ($Data) {
                    return Carbon::parse($Data->created_at)->format('d/m/Y');
                })
                ->addColumn('action', static function ($Data) {
                    $marca_prod_id = encrypt_id($Data->marca_prod_id);
                    return view('buttons.productos', ['marca_prod_id' => $marca_prod_id]);
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('modules.productos.index', ['fecha_actual' => $fecha_actual]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $marcas_motos = marca::select('marca_id AS id', DB::raw('marca_nombre AS text'))->get();
        return view('modules.productos.create', ['marcas_motos' => $marcas_motos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $array_marcas = explode(',', $request->input('marca_select'));

        if ($request->file) {
            $images_upload = Storage::disk('local')->put('fotos_producto', $request->file);

            $created = true;

            // Crear un nuevo registro
            $producto = new producto();
            $producto->categoria_id = $request->input('select_categoria_producto');
            $producto->marca_id = $request->input('marcas_moto');
            $producto->unidades_id = $request->input('select_unidades');
            $producto->zona_id = $request->input('select_zona');
            $producto->prod_nombre = $request->input('prod_nombre');
            $producto->prod_precio_venta = $request->input('prod_precio_venta');
            $producto->prod_precio_compra = $request->input('prod_precio_compra');
            $producto->prod_stock_inicial = $request->input('prod_stock_inicial');
            $producto->prod_nombre_secundario = $request->input('prod_nombre_secundario');
            $producto->prod_codigo = $request->input('prod_codigo');
            $producto->prod_descripcion = $request->input('prod_descripcion');
            $producto->prod_minimo = $request->input('prod_imnimo');
            $producto->user_id = Auth::id();

            $created = $producto->save();

            if ($created) {
                $imagen_producto = new imagen_producto();
                $imagen_producto->prod_id = $producto->prod_id;
                $imagen_producto->url = $images_upload;
                $created = $imagen_producto->save();

                foreach ($array_marcas as $marca) {
                    $producto_marcas = new producto_marcas();
                    $producto_marcas->marca_id = $marca;
                    $producto_marcas->prod_id = $producto->prod_id;
                    $producto_marcas->save();
                }

                return response()->json([
                    'message' => 'se creo correctamente un producto',
                    'error' => '',
                    'success' => true,
                    'data' => '',
                ]);
            } else {
                Log::error('no se pudo registrar el producto');
                return response()->json([
                    'message' => 'no se pudo registrar el producto',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
            }
        }

        return response([], 400);

        dd($request);
        foreach ($request->file('images') as $imagefile) {
            $path = $imagefile->store('/images/resource', ['disk' => 'my_files']);
            dump($path);
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
        return view('modules.productos.importar');
    }

    public function importar_productos(Request $request)
    {
        Excel::import(new ProductoImport(), $request->file('file'));
    }

    /* ******** buscando repuesto peticion via ajax ************* */
    public function search_repuesto(Request $request)
    { 
        try {
            $producto = producto::select(DB::raw('*'))->
            with("unidad")
            ->where('prod_nombre', 'like', '%' . $request->all()['search'] . '%')
            ->orWhere('prod_nombre_secundario', 'like', '%' . $request->all()['search'] . '%')
            ->orWhere('prod_codigo', 'like', '%' . $request->all()['search'] . '%')
            ->limit(7)
            ->get();

                if ($producto) {
                    return response()->json([
                        'message' => 'datos encontrados',
                        'error' => '',
                        'success' => true,
                        'data' => json_encode($producto) ,
                    ]);
                } else {
                    Log::error('no se pudo registrar la zona');
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
    /* *********************** */
}
