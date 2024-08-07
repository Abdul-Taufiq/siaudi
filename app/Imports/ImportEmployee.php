<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\Example2;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportEmployee implements ToModel
{
    public function model(array $row)
    {
        // Periksa apakah baris kosong
        if (empty(array_filter($row))) {
            // Baris kosong, abaikan
            return null;
        }

        // Jika baris tidak kosong, proses seperti biasa
        return new Employee([
            'nama' => $row[1],
            'nim' => $row[2],
            'tmp_lahir' => $row[3],
            'tgl_lahir' => Date::excelToDateTimeObject($row[4]),
        ]);
    }
}
// dd(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4]));
