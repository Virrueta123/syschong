<?php

namespace App\Http\Controllers;

use App\Imports\ActivacionesImport;
use App\Models\activaciones;
use App\Models\cortesias_activacion;
use App\Models\tiendas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class activaciones_controller extends Controller
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
            $tiendas = activaciones::with([
                'moto' => function ($query) {
                    return $query->with([
                        'cliente',
                        'modelo' => function ($query) {
                            return $query->with(['marca']);
                        },
                    ]);
                },
                'vendedor',
                'tienda',
            ])
                ->orderBy('created_at', 'desc')
                ->get();

            return DataTables::of($tiendas)
                ->addIndexColumn()
                ->addColumn('cliente', function ($Data) {
                    if($Data->moto->cliente->cli_ruc != "no tiene" ){
                        return $Data->moto->cliente->cli_razon_social;
                    }else{
                        return $Data->moto->cliente->cli_nombre . ' ' . $Data->moto->cliente->cli_apellido;
                    } 
                })
                ->addColumn('dnioruc', function ($Data) {
                    if($Data->moto->cliente->cli_ruc  != "no tiene" ){
                        return $Data->moto->cliente->cli_ruc;
                    }else{
                        return $Data->moto->cliente->cli_dni;
                    }   
                })
                ->addColumn('vendedor', function ($Data) {
                    return $Data->vendedor->vendedor_nombres;
                })
                ->addColumn('marca', function ($Data) {
                    return $Data->moto->modelo->marca->marca_nombre;
                })
                ->addColumn('modelo', function ($Data) {
                    return $Data->moto->modelo->modelo_nombre;
                })
                ->addColumn('tienda', function ($Data) {
                    return $Data->tienda->tienda_nombre;
                })
                ->addColumn('motor', function ($Data) {
                    return $Data->moto->mtx_motor;
                })

                ->addColumn('fecha_creacion', function ($Data) {
                    return Carbon::parse($Data->created_at)->format('d/m/Y');
                })
                ->addColumn('action', static function ($Data) {
                    $activaciones_id = encrypt_id($Data->activaciones_id);
                    return view('buttons.activaciones', ['activaciones_id' => $activaciones_id]);
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('modules.activaciones.index', ['fecha_actual' => $fecha_actual]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modules.activaciones.create');
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
        // Crear una nueva instancia del modelo
        $activaciones = new activaciones();

        // Establecer los valores de los campos
        $activaciones->tienda_id = $datax['tienda_id'];
        $activaciones->vendedor_id = $datax['vendedor_id'];
        $activaciones->moto_id = $datax['moto_id'];
        $activaciones->activado_taller = $datax['activado_taller'];
        $activaciones->precio = $datax['precio'];
        $activaciones->user_id = auth()->user()->id;
        $activaciones->start_cortesia = isset($datax['start_cortesia']) ? $datax['start_cortesia'] : 1;

        // Guardar el registro en la base de datos

        if ($activaciones->save()) {
            session()->flash('success', 'Se creo correctamente la activacion');
            return redirect()->route('activaciones.show', encrypt_id($activaciones->activaciones_id));
        } else {
            Log::error('no se pudo registrar la activacion');
            session()->flash('error', 'error al registrar en la base de datos');
            return redirect()->route('activaciones.create');
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
        $get = activaciones::with([
            'moto' => function ($query) {
                return $query->with([
                    'cliente',
                    'modelo' => function ($query) {
                        return $query->with(['marca']);
                    },
                ]);
            },
            'cortesias',
            'vendedor',
            'tienda',
        ])->find(decrypt_id($id));

        return view('modules.activaciones.show', ['get' => $get, 'id' => $id]);
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

    /* ******** importar excel para crear activaciones ************* */

    public function importar()
    {
        return view('modules.activaciones.importar');
    }

    /* ******** agregar cortesias ************* */

    public function cortesia($id)
    {
        return view('modules.cortesia.create', ['id' => $id]);
    }

    public function cortesia_store($id, Request $request)
    {
        $datax = $request->all();

        $cortesia = new cortesias_activacion();
        $cortesia->km = $datax['km'];
        $cortesia->precio = $datax['precio'];
        $cortesia->activaciones_id = decrypt_id($id);

        $numero_corterisa = cortesias_activacion::where('activaciones_id', decrypt_id($id))
            ->select('numero_corterisa')
            ->max('numero_corterisa');
        if (is_null($numero_corterisa)) {
            $numero_corterisa = 1;
        } else {
            $numero_corterisa++;
        }

        $cortesia->numero_corterisa = $numero_corterisa;
        // Guardar el registro en la base de datos

        if ($cortesia->save()) {
            session()->flash('success', 'Se creo correctamente la cortesia');
            return redirect()->route('activaciones.show', $id);
        } else {
            Log::error('no se pudo registrar la activacion');
            session()->flash('error', 'error al registrar en la base de datos');
            return redirect()->route('activaciones.show', $id);
        }
    }

    /* *********************** */

    public function importar_activaciones(Request $request)
    {
        Excel::import(new ActivacionesImport(), $request->file('file'));
    }
    /* *********************** */
}
