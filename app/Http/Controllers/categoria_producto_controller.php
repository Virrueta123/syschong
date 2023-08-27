<?php

namespace App\Http\Controllers;

use App\Models\categoria_producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class categoria_producto_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
