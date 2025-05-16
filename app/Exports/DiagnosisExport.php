<?php

namespace App\Exports;

use App\Models\Diagnosis;
use Maatwebsite\Excel\Concerns\FromCollection;

class DiagnosisExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Diagnosis::orderBy('created_at', 'desc')->get();
    }
}
