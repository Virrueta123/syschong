<?php

namespace App\Http\Controllers;

use App\Models\marca_producto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class marca_producto_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        $fecha_actual = Carbon::now();
        if ($request->ajax()) {
            $cliente = marca_producto::orderBy('created_at', 'desc')
                ->get();
            return DataTables::of($cliente)
                ->addIndexColumn() 
                ->addColumn('fecha_creacion', function ($Data) {
                    return Carbon::parse($Data->created_at)->format('d/m/Y');
                })
                ->addColumn('action', static function ($Data) {
                    $marca_prod_id = encrypt_id($Data->marca_prod_id);
                    return view('buttons.marca_producto_buttons', ['marca_prod_id' => $marca_prod_id]);
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('modules.marca_producto.index', ['fecha_actual' => $fecha_actual]);
        } 
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
        try {
            $datax = $request->all();
           
            $validate = $request->validate([
                'marca_prod_nombre' => 'required|string|max:200'
            ]);

            $validate['user_id'] = Auth::user()->id;

            $create = marca_producto::create($validate);
             
            if ($create) {
                session()->flash('success', 'se creo correctamente una nueva marca de producto');
                return redirect()->route('moto.index');
            } else {
                Log::error('no se pudo registrar la nueva  marca de producto');
                session()->flash('error', 'error al registrar en la base de datos');
                return redirect()->route('modules.categoria_producto.index');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al registrar');
            return redirect()->route('modules.categoria_producto.index');
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


        /* ******** api ************* */

        public function marca_search(Request $req)
        {
            $marca_prod = marca_producto::select(DB::raw('marca_prod_id AS id'), 'marca_prod_nombre as name')
                ->where('marca_prod_nombre', 'like', '%' . $req->all()['search'] . '%')
                ->limit(7)
                ->get();
            echo json_encode($marca_prod);
        }
    
        /* *********************** */
    
        /* ******** crear marca_producto vue ************* */
    
        public function marca_producto_store_vue (Request $request)
        {
            try {
                $datax = $request->all();
                $validate = $request->validate([
                    'marca_prod_nombre' => 'required|string|max:200' 
                ]); 
                $validate['user_id'] = Auth::user()->id; 
     
                $unique_marca_prod_nombre = marca_producto::where('marca_prod_nombre', $datax['marca_prod_nombre'])->first();
    
                if($unique_marca_prod_nombre){ 
                    return response()->json([
                        'message' => 'Esta marca de producto ya existe',
                        'error' => '',
                        'success' => false,
                        'data' => '',
                    ]);
                }else{
                    $create = marca_producto::create($validate);
                    if ($create) {
                        return response()->json([
                            'message' => 'se creo correctamente una marca de producto',
                            'error' => '',
                            'success' => true,
                            'data' => ['value' => $create->marca_id, 'title' => $create->marca_nombre],
                        ]);
                    } else {
                        Log::error('no se pudo registrar la marca de producto');
                        return response()->json([
                            'message' => 'no se pudo registrar la marca de producto',
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
