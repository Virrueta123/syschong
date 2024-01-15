<?php

namespace App\Exports;

use Illuminate\Contracts\View\View; 
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExcelDocumento implements FromView,ShouldAutoSize 
{

    public $data;
    public function __construct( $data )
    { 
        $this->data = $data;
    }
    public function view(): View
    {
        return view('pdf.excel.reporte_documento',[
            'data' => $this->data, 
        ]);
    }
}
