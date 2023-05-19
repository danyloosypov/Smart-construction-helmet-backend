<?php

namespace App\Exports;

use App\Models\Reading;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReadingExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Reading::all();
    }
}
