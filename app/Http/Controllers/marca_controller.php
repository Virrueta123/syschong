<?php

namespace App\Http\Controllers;

use App\Models\marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class marca_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         
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

    public function marca_store_vue (Request $request)
    {
        try {
            $datax = $request->all();
            $validate = $request->validate([
                'marca_nombre' => 'required|string|max:200' 
            ]); 
            $validate['user_id'] = Auth::user()->id; 
 
            $unique_marca_nombre = marca::where('marca_nombre', $datax['marca_nombre'])->first();

            if($unique_marca_nombre){ 
                return response()->json([
                    'message' => 'Esta marca ya existe',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
            }else{
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
