<?php

namespace App\Http\Controllers;

use App\Models\activacion_precio;
use App\Models\activaciones;
use App\Models\cortesias_activacion;
use App\Models\producto;
use App\Models\tiendas;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class tiendas_controller extends Controller
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
            $tiendas = tiendas::orderBy('created_at', 'desc')->get();

            return DataTables::of($tiendas)
                ->addIndexColumn()
                ->addColumn('fecha_creacion', function ($Data) {
                    return Carbon::parse($Data->created_at)->format('d/m/Y');
                })
                ->addColumn('action', static function ($Data) {
                    $tienda_id = encrypt_id($Data->tienda_id);
                    return view('buttons.tiendas', ['tienda_id' => $tienda_id]);
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('modules.tiendas.index', ['fecha_actual' => $fecha_actual]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modules.tiendas.create');
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
        $tienda = new tiendas();
        $tienda->tienda_nombre = $datax['tienda_nombre'];
        $tienda->tienda_ruc = $datax['tienda_ruc'];
        $tienda->tienda_razon = $datax['tienda_razon'];
        $tienda->tienda_contacto = $datax['tienda_contacto'];
        $tienda->tienda_direccion = $datax['tienda_direccion'];
        $tienda->tienda_provincia = $datax['tienda_provincia'];
        $tienda->tienda_departamento = $datax['tienda_departamento'];
        $tienda->tienda_distrito = $datax['tienda_distrito'];
        $tienda->tienda_correo = $datax['tienda_correo'];
        if ($tienda->save()) {
            foreach ($datax['precios'] as $precio) {
                // Crear una nueva instancia del modelo
                $activacion_precio = new activacion_precio();

                // Asignar valores a los campos
                $activacion_precio->tienda_id = $tienda->tienda_id; // ID de la cotización relacionada
                $activacion_precio->modelo_id = $precio['modelo_id']; // ID del producto relacionado
                $activacion_precio->precio_activacion = $precio['precio_activacion']; // ID del servicio relacionado
                $activacion_precio->precio_cortesia = $precio['precio_cortesia'];

                // Guardar el registro en la base de datos
                $activacion_precio->save();
            }

            session()->flash('success', 'Registro creado correctamente');
            return redirect()->route('tiendas.show', encrypt_id($tienda->tienda_id));
        } else {
            Log::error('no se pudo registrar la tienda');
            session()->flash('error', 'error al registrar en la base de datos');
            return redirect()->route('tiendas.create');
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
        

        $get = tiendas::with([
            'precios' => function ($query) {
                $query->with([
                    'modelo' => function ($query) {
                        $query->with(['marca']);
                    },
                ]);
            },
        ])->find(decrypt_id($id));

        $get = tiendas::with([
            'precios' => function ($query) {
                $query->with([
                    'modelo' => function ($query) {
                        $query->with(['marca']);
                    },
                ]);
            },
        ])->find(decrypt_id($id));

        $activaciones = activaciones::where('is_cobro', 'N')
            ->where('activado_taller', 'Y')
            ->where('activaciones.tienda_cobrar', decrypt_id($id))
            ->get();

        $activaciones_count = count($activaciones);
        $activaciones_cobro = $activaciones->sum('precio');

        $cortesias = cortesias_activacion::where('is_cobro', 'N')
            ->where('tipo', 'C')
            ->where('tienda_cobrar', decrypt_id($id))
            ->get();

        $cortesias_count = count($cortesias);
        $cortesias_cobro = $cortesias->sum('precio');

        return view('modules.tiendas.show', compact('get', 'id', 'activaciones_count', 'activaciones_cobro', 'cortesias_count', 'cortesias_cobro'));
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

    public function search_tienda(Request $request)
    {
        $keyword = $request->all()['search'];

        $tiendas = tiendas::select(DB::raw('tienda_id AS id'), DB::raw('CONCAT(tienda_razon," - ",tienda_nombre, " - ", tienda_ruc) AS name'))
            ->where(function ($query) use ($keyword) {
                $query->where('tienda_nombre', 'like', '%' . $keyword . '%')->orWhere('tienda_ruc', 'like', '%' . $keyword . '%');
            })
            ->where(function ($query) use ($keyword) {
                $query
                    ->whereNotNull('tienda_nombre') // Asegura que tienda_nombre no sea nulo
                    ->orWhereNotNull('tienda_ruc'); // Asegura que tienda_ruc no sea nulo
            })
            ->limit(9)
            ->get();
        echo json_encode($tiendas);
    }

    public function factura($id)
    {
        dd($id);
    }
}
