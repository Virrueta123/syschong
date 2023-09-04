<?php

namespace App\Http\Controllers;

use App\Models\categoria_producto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class categoria_producto_controller extends Controller
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
            $cliente = categoria_producto::orderBy('created_at', 'desc')
                ->get();
            return DataTables::of($cliente)
                ->addIndexColumn() 
                ->addColumn('fecha_creacion', function ($Data) {
                    return Carbon::parse($Data->created_at)->format('d/m/Y');
                })
                ->addColumn('action', static function ($Data) {
                    $categoria_id = encrypt_id($Data->categoria_id);
                    return view('buttons.categoria_producto', ['categoria_id' => $categoria_id]);
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('modules.categoria_producto.index', ['fecha_actual' => $fecha_actual]);
        } 
    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modules.categoria_producto.create');
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
                'categoria_nombre' => 'required|string|max:249|unique:categoria'
            ]);

            $validate['user_id'] = Auth::user()->id;

            $create = categoria_producto::create($validate);
             
            if ($create) {
                session()->flash('success', 'se creo correctamente una nueva categoria de producto');
                return redirect()->route('categorias.index');
            } else {
                Log::error('no se pudo registrar la nueva categoria de producto');
                session()->flash('error', 'error al registrar en la base de datos');
                return redirect()->route('categorias.index');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al registrar');
            return redirect()->route('categorias.index');
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
            $get = categoria_producto::find(decrypt_id($id));

            if ($get) {
                return view('modules.categoria_producto.edit', ['get' => $get, 'id' => $id]);
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
        try {
            $update = categoria_producto::where('categoria_id', decrypt_id($id));
            $datax = $request->all();
       
            
            $validate = $request->validate([
                'categoria_nombre' => 'required|string|max:249|unique:categoria'
            ]);

            $validate['user_id'] = Auth::user()->id;

            $update = $update->update($validate);

            if ($update) {
                session()->flash('success', 'Registro editado correctamente');
                return redirect()->route('categorias.index');
            } else {
                Log::error('no se pudo registrar la categoria');
                session()->flash('error', 'error al editar en la base de datos');
                return redirect()->route('categorias.index');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al editar');
            return redirect()->route('categorias.index');
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
            $destroy = categoria_producto::where('categoria_id', decrypt_id($id));
            $destroy->delete();

            if ($destroy) {
                session()->flash('success', 'Registro eliminado correctamente');
                return redirect()->route('categorias.index');
            } else {
                Log::error('no se pudo eliminar la categoria');
                session()->flash('error', 'error al eliminar en la base de datos');
                return redirect()->route('categorias.index');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al eliminar');
            return redirect()->route('categorias.index');
        }   
    }


    
    public function estado($id)
    {
        try {
            $update = categoria_producto::find(decrypt_id($id));
            $categoria = categoria_producto::find(decrypt_id($id));

            if ($categoria->estado == 'A') {
                $estado = 'D';
            } else {
                $estado = 'A';
            }

            $update = $update->update(['estado' => $estado]);

            if ($update) {
                session()->flash('success', 'estado actualizado correctamente');
                return redirect()->route('categorias.index');
            } else {
                Log::error('falla al cambiar estado');
                session()->flash('error', 'error al editar en la base de datos');
                return redirect()->route('categorias.index');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al editar');
            return redirect()->route('categorias.index');
        }
    }


     /* ******** api ************* */

     public function search(Request $req)
     {
         $zona = categoria_producto::select(DB::raw('categoria_id AS id'), 'categoria_nombre as name')
             ->where('categoria_nombre', 'like', '%' . $req->all()['search'] . '%')
             ->limit(7)
             ->get();
         echo json_encode($zona);
     }
 
     /* *********************** */
 
     /* ******** crear categoria producto vue ************* */
 
     public function store_vue(Request $request)
     {
         try {
             $datax = $request->all();
             $validate = $request->validate([
                 'categoria_nombre' => 'required|string|max:250',
             ]);
             $validate['user_id'] = Auth::user()->id;
 
             $unique_categoria_nombre = categoria_producto::where('categoria_nombre', $datax['categoria_nombre'])->first();
 
             if ($unique_categoria_nombre) {
                 return response()->json([
                     'message' => 'Esta zona ya existe',
                     'error' => '',
                     'success' => false,
                     'data' => '',
                 ]);
             } else {
                 $create = categoria_producto::create($validate);
                 if ($create) {
                     return response()->json([
                         'message' => 'se creo correctamente una zona',
                         'error' => '',
                         'success' => true,
                         'data' => ['value' => $create->categoria_id, 'title' => $create->categoria_nombre],
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
