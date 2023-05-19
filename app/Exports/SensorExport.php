<?php

namespace App\Exports;

use App\Models\Sensor;
use Maatwebsite\Excel\Concerns\FromCollection;

class SensorExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Sensor::all();
    }
}
