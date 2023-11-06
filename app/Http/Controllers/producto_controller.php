<?php

namespace App\Http\Controllers;

use App\Imports\ProductoImport;
use App\Models\detalle_compra;
use App\Models\detalle_venta;
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
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

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
    public function datatables_vue()
    {
        $producto = producto::with(['marca_producto'])
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($producto)
            ->addIndexColumn()
            ->addColumn('fecha_creacion', function ($Data) {
                return Carbon::parse($Data->created_at)->format('d/m/Y');
            })
            ->addColumn('action', static function ($Data) {
                $prod_id = encrypt_id($Data->prod_id);
                return view('buttons.productos', ['prod_id' => $prod_id]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function search_aceites()
    {
        $producto = producto::with(['marca_producto',"unidad"])
            ->where('unidades_id',65)
            ->orderBy('created_at', 'desc') 
            ->get();

        return DataTables::of($producto)
            ->addIndexColumn()
            ->addColumn('fecha_creacion', function ($Data) {
                return Carbon::parse($Data->created_at)->format('d/m/Y');
            })
            ->addColumn('stock_actual', function ($Data) {
                $compras = detalle_compra::where('prod_id', $Data->prod_id)->sum('cantidad');
                $ventas = detalle_venta::where('prod_id', $Data->prod_id)->sum('Cantidad');
                $stock = $Data->prod_stock_inicial + $ventas + $compras;
                return $stock;
            })
            ->addColumn('action', static function ($Data) {
                $prod_id = encrypt_id($Data->prod_id);
                return view('buttons.productos', ['prod_id' => $prod_id]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function index(Builder $builder)
    {
        $fecha_actual = Carbon::now();
        if (request()->ajax()) {
            return DataTables::of(
                producto::with([
                    'marca_producto',
                    'producto_marcas' => function ($query) {
                        $query->with(['marca']);
                    },
                    'unidad',
                    'categoria',
                    'marca',
                    'zona',
                    'imagen',
                ]),
            )
                ->addColumn('action', static function ($Data) {
                    $prod_id = encrypt_id($Data->prod_id);
                    return view('buttons.productos', ['prod_id' => $prod_id]);
                })
                ->addColumn('calidad', static function ($Data) {
                    switch ($Data->prod_calidad) {
                        case 'O':
                            return ' Original';
                            break;

                        case 'A':
                            return ' Alternativo';
                            break;
                    }
                })
                ->toJson();
        }

        $html = $builder
            ->columns([
                Column::make('prod_codigo')->title('Codigo'),
                Column::make('prod_nombre')->title('Nombre'),
                Column::make('prod_descripcion')->title('descripcion'),
                Column::make('prod_precio_venta')->title('precio venta'),
                Column::make('stock')->title('cantidad'),
                Column::computed('calidad')->title('Calidad'),
                Column::make('unidad.unidades_nombre')->title('unidad'),
                Column::make('categoria.categoria_nombre')->title('categoria'),
                Column::make('marca.marca_prod_nombre')->title('marca'),
                Column::make('zona.zona_nombre')->title('zona'),

                Column::computed('action')
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

        return view('modules.productos.index', compact('html'));
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
        dd($request);
        $array_marcas = explode(',', $request->input('marcas_moto'));

        // Crear un nuevo registro
        $producto = new producto();
        $producto->categoria_id = $request->input('categoria_id');
        $producto->marca_id = $request->input('marca_prod_id');
        $producto->unidades_id = $request->input('unidades_id');
        $producto->zona_id = $request->input('zona_id');
        $producto->prod_nombre = $request->input('prod_nombre');
        $producto->prod_precio_venta = $request->input('prod_precio_venta');
        $producto->prod_precio_compra = $request->input('prod_precio_compra');
        $producto->prod_stock_inicial = $request->input('prod_stock_inicial');
        $producto->prod_nombre_secundario = $request->input('prod_nombre_secundario');
        $producto->prod_codigo = $request->input('prod_codigo');
        $producto->prod_descripcion = $request->input('prod_descripcion');
        $producto->prod_minimo = $request->input('prod_minimo');
        $producto->prod_calidad = $request->input('prod_calidad');

        $producto->user_id = Auth::id();

        $created = $producto->save();

        if ($created) {
            if ($request->files) {
                $uploadedFiles = $request->file('files');

                // Verifica si se subieron archivos
                if ($uploadedFiles) {
                    foreach ($uploadedFiles as $uploadedFile) {
                        // Verifica si el archivo es válido
                        if ($uploadedFile->isValid()) {
                            // Define la ruta de almacenamiento (cambia 'fotos_producto/dd' según tu estructura de almacenamiento)
                            $storagePath = 'fotos_producto';

                            // Genera un nombre de archivo único
                            $fileName = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();

                            // Almacena el archivo en la ubicación deseada

                            $images_upload = Storage::disk('local')->put('public/fotos_producto/', $uploadedFile);
                            $images_upload = explode('/', $images_upload);

                            $imagen_producto = new imagen_producto();
                            $imagen_producto->prod_id = $producto->prod_id;
                            $imagen_producto->url = $images_upload[1] . '/' . $images_upload[3];
                            $created = $imagen_producto->save();

                            // Verifica si la operación de almacenamiento fue exitosa
                            if ($images_upload) {
                                // Aquí puedes realizar cualquier otra acción necesaria
                                // por ejemplo, registrar la ubicación del archivo en una base de datos
                            } else {
                                // Manejo de error en caso de falla al almacenar el archivo
                            }
                        } else {
                            // Manejo de error si el archivo no es válido
                        }
                    }
                } else {
                    // Manejo de error si no se subieron archivos
                }
            }

            foreach ($array_marcas as $marca) {
                $producto_marcas = new producto_marcas();
                $producto_marcas->marca_id = $marca;
                $producto_marcas->prod_id = $producto->prod_id;
                $producto_marcas->save();
            }

            session()->flash('success', 'Producto creado correctamente');
            return response()->json([
                'message' => 'se creo correctamente un producto',
                'error' => '',
                'success' => true,
                'data' => route('producto.show', encrypt_id($producto->prod_id)),
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $get = producto::with([
            'marca_producto',
            'producto_marcas' => function ($query) {
                $query->with(['marca']);
            },
            'unidad',
            'categoria',
            'marca',
            'zona',
            'imagen',
            "usuario"
        ])->find(decrypt_id($id));
 

        if ($get) {
            return view('modules.productos.show', ['get' => $get, 'id' => $id]);
        } else {
            return view('errors.404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $get = producto::with([
            'marca_producto',
            'unidad',
            'categoria',
            'producto_marcas' => function ($query) {
                $query->with(['marca']);
            },
            'zona',
            'imagen',
        ])->find(decrypt_id($id));

        if ($get) {
            $marcas_motos = marca::select('marca_id AS id', DB::raw('marca_nombre AS text'))
                ->where('estado', 'A')
                ->get();

            return view('modules.productos.edit', ['get' => $get, 'id' => $id, 'marcas_motos' => $marcas_motos]);
        } else {
            return view('errors.404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editar_producto(Request $request, $id)
    {
        $array_marcas = explode(',', $request->input('marcas_moto'));

        // Crear un nuevo registro
        $update = producto::find(decrypt_id($id));

        $update->categoria_id = $request->input('categoria_id');
        $update->marca_id = $request->input('marca_prod_id');
        $update->unidades_id = $request->input('unidades_id');
        $update->zona_id = $request->input('zona_id');
        $update->prod_nombre = $request->input('prod_nombre');
        $update->prod_precio_venta = $request->input('prod_precio_venta');
        $update->prod_precio_compra = $request->input('prod_precio_compra');
        $update->prod_stock_inicial = $request->input('prod_stock_inicial');
        $update->prod_nombre_secundario = $request->input('prod_nombre_secundario');
        $update->prod_codigo = $request->input('prod_codigo');
        $update->prod_descripcion = $request->input('prod_descripcion');
        $update->prod_minimo = $request->input('prod_minimo');
        $update->prod_calidad = $request->input('prod_calidad');

        $update->user_id = Auth::id();

        $update = $update->save();

        if ($update) {
            if ($request->files) {
                $uploadedFiles = $request->file('files');

                // Verifica si se subieron archivos
                if ($uploadedFiles) {
                    foreach ($uploadedFiles as $uploadedFile) {
                        // Verifica si el archivo es válido
                        if ($uploadedFile->isValid()) {
                            // Define la ruta de almacenamiento (cambia 'fotos_producto/dd' según tu estructura de almacenamiento)
                            $storagePath = 'fotos_producto';

                            // Genera un nombre de archivo único
                            $fileName = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();

                            // Almacena el archivo en la ubicación deseada

                            $image = imagen_producto::where('prod_id', decrypt_id($id))->first();

                            if ($image) {
                                $images_upload = Storage::putFileAs('public/', $uploadedFile, $image->url);
                            } else {
                                $images_upload = Storage::disk('local')->put('public/fotos_producto/', $uploadedFile);
                                $images_upload = explode('/', $images_upload);

                                $imagen_producto = new imagen_producto();
                                $imagen_producto->prod_id = decrypt_id($id);
                                $imagen_producto->url = $images_upload[1] . '/' . $images_upload[3];
                                $created = $imagen_producto->save();
                            }

                            // Verifica si la operación de almacenamiento fue exitosa
                            if ($images_upload) {
                                // Aquí puedes realizar cualquier otra acción necesaria
                                // por ejemplo, registrar la ubicación del archivo en una base de datos
                            } else {
                                // Manejo de error en caso de falla al almacenar el archivo
                            }
                        } else {
                            // Manejo de error si el archivo no es válido
                        }
                    }
                } else {
                    // Manejo de error si no se subieron archivos
                }
            }

            $eliminar = producto_marcas::where('prod_id', decrypt_id($id))->delete();

            foreach ($array_marcas as $marca) {
                $producto_marcas = new producto_marcas();

                $producto_marcas->marca_id = $marca;
                $producto_marcas->prod_id = decrypt_id($id);
                $producto_marcas->save();
            }

            session()->flash('success', 'Producto editado correctamente');
            return response()->json([
                'message' => 'se creo correctamente un producto',
                'error' => '',
                'success' => true,
                'data' => route('producto.show', $id),
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
            $producto = producto::select(DB::raw('*'))
                ->with('marca_producto', 'unidad', 'categoria', 'marca', 'zona', 'imagen')
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
                    'data' => json_encode($producto),
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

    /* ******** buscando repuesto peticion via ajax ************* */
    public function search_repuesto_datatable()
    {
        $producto = producto::select(DB::raw('*'))->get();

        return response()->json(['data' => $producto]);
    }
    /* *********************** */
    public function get_producto(Request $request)
    {
        $producto = producto::with('marca_producto', 'unidad', 'categoria', 'marca', 'zona', 'imagen')->find($request->input('prod_id'));
        if ($producto) {
            return response()->json([
                'message' => 'datos encontrados',
                'error' => '',
                'success' => true,
                'data' => $producto,
            ]);
        } else {
            Log::error('no se encontro el producto');
            return response()->json([
                'message' => 'no se encontro el producto',
                'error' => '',
                'success' => false,
                'data' => '',
            ]);
        }
    }

    /* ******** ajax para buscar repuestos para las compras ************* */
    function search_repuesto_compra(Request $request)
    {
        $search = $request->input('search');

        $modelo = producto::select('prod_id as id', DB::raw("CONCAT('Nombre :',prod_nombre, ' | Codigo : ', prod_codigo) as name"))
            ->where('prod_nombre', 'like', '%' . $request->all()['search'] . '%')
            ->orWhere('prod_nombre_secundario', 'like', '%' . $request->all()['search'] . '%')
            ->orWhere('prod_codigo', 'like', '%' . $request->all()['search'] . '%')
            ->get();

        echo json_encode($modelo);
    }
    /* *********************** */
}
