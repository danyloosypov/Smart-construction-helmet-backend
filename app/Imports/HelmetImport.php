<?php

namespace App\Imports;

use App\Models\Helmet;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class HelmetImport implements ToModel, WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Helmet([
            'name' => $row['name'],
            'description' => $row['description'],
            'worker_id' => $row['worker_id']
        ]);
    }
}
