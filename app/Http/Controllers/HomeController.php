<?php

namespace App\Http\Controllers;

use App\Exports\ExcelDocumento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Obtener la fecha actual
        // Obtén la fecha actual
        $hoy = Carbon::now();

        // Ajusta la fecha al último día de la semana (domingo)
        $ultimoDiaSemana = $hoy->endOfWeek();

        // Resta 6 días para obtener el primer día de la semana
        $primerDiaSemana = $ultimoDiaSemana->copy()->subDays(6);

        $ultimoDiaSemana = $ultimoDiaSemana->format('Y-m-d');

        $primerDiaSemana = $primerDiaSemana->format('Y-m-d');
 
       return Excel::download(new ExcelDocumento( ["datatable"=>"dsadasd"]), 'padroSunatF'.'_'.Carbon::now()->format("H:i:s").'.xlsx' );

        return view('home', compact('primerDiaSemana', 'ultimoDiaSemana'));

 
    }
}
