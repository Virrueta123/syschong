<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Route;

class user_controller extends Controller
{
    public function index(Builder $builder)
    {
        $fecha_actual = Carbon::now();
        if (request()->ajax()) {
            return DataTables::of(User::where('active', 'A'))
                ->addColumn('action', static function ($Data) {
                    $user_id = encrypt_id($Data->id);
                    return view('buttons.users', ['user_id' => $user_id]);
                })
                ->toJson();
        }

        $html = $builder
            ->columns([
                Column::make('name')->title('Nombres'),
                Column::make('last_name')->title('apellido'),
                Column::make('email')->title('correo electronico'),
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

        return view('modules.users.index', compact('html'));
    }
    public function create()
    {
        // Obtener todas las rutas registradas
        $routes = Route::getRoutes();

        // Inicializar un arreglo para almacenar los nombres de las rutas
        $routeNames = [];

        // Iterar sobre las rutas y obtener sus nombres
        foreach ($routes as $route) {
            $name = $route->getName();
            if ($name) {
                $routeNames[] = $name;
            }
        }

        // Imprimir el JSON
        dd( $routeNames);

        $roles = Role::all();
        return view('modules.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'last_name' => 'required|max:250',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8',
        ]);

        User::create($validatedData);

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('modules.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'last_name' => 'required|max:250',
            'email' => 'required|email|unique:users,email,' . $user->id . ',id',
            'password' => 'nullable|min:8',
        ]);

        $user->update($validatedData);

        return redirect()->route('users.index');
    }
    /* ******** aixos  ************* */
    public function search_mecanico(Request $req)
    {
        if ($req->all()['search'] == '') {
            $search_mecanico = User::select(DB::raw('id AS id'), DB::raw('CONCAT(name, " ", last_name) as name'))
                ->where('roles_id', '2')
                ->get();
        } else {
            $search_mecanico = User::select(DB::raw('id AS id'), DB::raw('CONCAT(name, " ", last_name) as name'))
                ->where(function ($query) use ($req) {
                    $query->where('name', 'like', '%' . $req->all()['search'] . '%')->orWhere('last_name', 'like', '%' . $req->all()['search'] . '%');
                })
                ->where('roles_id', '2')
                ->get();
        }

        echo json_encode($search_mecanico);
    }
    /* *********************** */
}
