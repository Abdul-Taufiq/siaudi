<?php

namespace App\Imports;

use App\Models\RiskEvent\RiskEvent;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportRiskEvent implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Periksa apakah baris kosong
        if (empty(array_filter($row))) {
            // Baris kosong, abaikan
            return null;
        }

        // Jika baris tidak kosong, proses seperti biasa
        return new RiskEvent([
            'kode_finding' => $row['code_finding'],
            'activity' => $row['activity'],
            'sub_activity' => $row['sub_activity'],
            'list_finding' => $row['list_finding'],
            'indikasi_resiko' => $row['indikasi_risiko']
        ]);
    }
}
