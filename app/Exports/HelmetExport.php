<?php

namespace App\Exports;

use App\Models\Helmet;
use Maatwebsite\Excel\Concerns\FromCollection;

class HelmetExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Helmet::all();
    }
}
