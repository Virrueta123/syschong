<?php

namespace App\Http\Controllers;

use App\Models\zona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
