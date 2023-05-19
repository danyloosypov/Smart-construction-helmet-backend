<?php

namespace App\Imports;

use App\Models\Reading;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class ReadingImport implements ToModel, WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Reading([
            'sensor_value' => $row['sensor_value'],
            'sensor_id' => $row['sensor_id'],
            'helmet_id' => $row['helmet_id'],
        ]);
    }
}
