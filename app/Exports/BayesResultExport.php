<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class BayesResultExport implements FromArray
{
    protected $results;

    // Kirim data saat class ini dipanggil
    public function __construct(array $results)
    {
        $this->results = $results;
    }
    // Data yang akan dimasukkan ke Excel
    public function array(): array
    {
        return $this->results;
    }
}
