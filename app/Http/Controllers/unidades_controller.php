<?php

namespace App\Http\Controllers;

use App\Models\unidades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class unidades_controller extends Controller
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
            $unidades = unidades::select(DB::raw('unidades_id AS id'), 'unidades_nombre as name')
                ->where('unidades_nombre', 'like', '%' . $req->all()['search'] . '%')
                ->limit(7)
                ->get();
            echo json_encode($unidades);
        }
    
        /* *********************** */
    
        /* ******** crear marca_producto vue ************* */
    
        public function store_vue(Request $request)
        {
            try {
                $datax = $request->all();
                $validate = $request->validate([
                    'unidades_nombre' => 'required|string|max:250',
                ]);
                $validate['user_id'] = Auth::user()->id;
    
                $unique_unidades_nombre = unidades::where('unidades_nombre', $datax['unidades_nombre'])->first();
    
                if ($unique_unidades_nombre) {
                    return response()->json([
                        'message' => 'Esta unidades ya existe',
                        'error' => '',
                        'success' => false,
                        'data' => '',
                    ]);
                } else {
                    $create = unidades::create($validate);
                    if ($create) {
                        return response()->json([
                            'message' => 'se creo correctamente una unidade',
                            'error' => '',
                            'success' => true,
                            'data' => ['value' => $create->unidades_id, 'title' => $create->unidades_nombre],
                        ]);
                    } else {
                        Log::error('no se pudo registrar la unidade');
                        return response()->json([
                            'message' => 'no se pudo registrar la unidades',
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
