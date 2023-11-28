<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class mecanicos_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $fecha_actual = Carbon::now();
        if (request()->ajax()) {
            return DataTables::of(
                User::where('roles_id', 2)
                    ->orderBy('created_at', 'asc')
                    ->get(),
            )
                ->addColumn('action', static function ($Data) {
                    $mecanico_id = encrypt_id($Data->id);
                    return view('buttons.mecanicos', ['mecanico_id' => $mecanico_id]);
                })

                ->addColumn('fecha_creacion', static function ($Data) {
                    return Carbon::parse($Data->created_at)->format('d/m/Y');
                })
                ->toJson();
        }

        $html = $builder
            ->columns([
                Column::make('name')->title('Nombre'),
                Column::make('last_name')->title('Apellido'),
                Column::make('email')->title('correo'),
                Column::make('dni')->title('Dni'),
                Column::make('fecha_creacion')->title('Fecha creacion'),
                Column::make('action') 
                    ->exportable(false)
                    ->printable(false)
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

        return view('modules.mecanico.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modules.mecanico.create');
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

        $validatedData = $request->validate(
            [
                'name' => 'required|max:249',
                'last_name' => 'required|max:249|unique:users',
                'email' => 'required|email|unique:users',
                'dni' => 'required|max:9|unique:users',
            ],
            [
                'last_name.unique' => 'Este apellido ya existe en el sistema.',
                'email.unique' => 'El correo electrónico ya existe en el sistema.',
                'dni.unique' => 'Este dni ya existe en el sistema.', // Customize error message for 'unique' rule
            ],
        );
        $validatedData['password'] = Hash::make($datax['name']);
        $validatedData['remember_token'] = Str::random(10);

        $create = user::create($validatedData);

        if ($create) {
            session()->flash('success', 'Registro creado correctamente');
            return redirect()->route('mecanico.index');
        } else {
            Log::error('no se pudo registrar el mecanico');
            session()->flash('error', 'error al registrar en la base de datos');
            return redirect()->route('mecanico.index');
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
        $edit = user::find(decrypt_id($id));

        if ($edit) {
            return view('modules.mecanico.edit', compact('edit', 'id'));
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
    public function update(Request $request, $id)
    {
        $datax = $request->all();
        $user_id = decrypt_id($id);

        $update = user::find($user_id);

        $validatedData = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:249',
                'last_name' => [
                    'required',
                    'max:249',
                    Rule::unique('users')->where(function ($query) use ($user_id) {
                        $query->where('id', '!=', $user_id);
                    }),
                ],
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->where(function ($query) use ($user_id) {
                        $query->where('id', '!=', $user_id);
                    }),
                ],
                'dni' => [
                    'required',
                    'max:9',
                    Rule::unique('users')->where(function ($query) use ($user_id) {
                        $query->where('id', '!=', $user_id);
                    }),
                ],
            ],
            [
                'last_name.unique' => 'Este apellido ya existe en el sistema.',
                'email.unique' => 'El correo electrónico ya existe en el sistema.',
                'dni.unique' => 'Este dni ya existe en el sistema.',
            ],
        )->validate();

        $update = $update->update($validatedData);

        if ($update) {
            session()->flash('success', 'Registro editado correctamente');
            return redirect()->route('mecanico.index');
        } else {
            Log::error('no se pudo registrar el mecanico');
            session()->flash('error', 'error al editar en la base de datos');
            return redirect()->route('mecanico.index');
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
            $caja = user::findOrFail(decrypt_id($id));

            $delete = $caja->delete();
            if ($delete) {
                session()->flash('success', 'se elimino correctamente el mecanico');
                return redirect()->route('mecanico.index');
            } else {
                session()->flash('success', 'error al eliminar el mecanico');
                return redirect()->route('mecanico.index');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al eliminar este registro');
            return redirect()->route('mecanico.index');
        }
    }
}
