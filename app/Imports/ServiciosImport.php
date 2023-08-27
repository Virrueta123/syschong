<?php

namespace App\Imports;

use App\Models\servicios;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class ServiciosImport implements ToCollection
{
    public function collection(Collection $rows)
    {
       
            foreach ($rows as $row => $valores) {
                if ($row != 0) {
                    if ($valores[2] == 'SERVICIOS') {
                        
                        servicios::create([
                            'servicios_nombre' => $valores[0],
                            'servicios_precio' => $valores[4],
                        ]);
                    }
                }
            }

            
    }
}
