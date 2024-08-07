<?php

namespace App\Imports;

use App\Models\Debitur\Debitur;
use DateTime;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportDebitur implements ToModel, WithHeadingRow
{
    // untuk ambil inputan
    protected $cabang;

    public function __construct($cabang)
    {
        $this->cabang = $cabang;
    }

    public function model(array $row)
    {
        // Periksa apakah baris kosong
        if (empty(array_filter($row))) {
            // Baris kosong, abaikan
            return null;
        }

        // Lakukan konversi tanggal hanya untuk nilai tanggal yang valid
        $tgl_realisasi = $this->isValidDate($row['realisasi']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $row['realisasi']) : null;
        $tgl_jth_tempo = $this->isValidDate($row['jth_tempo']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $row['jth_tempo']) : null;

        // Jika baris tidak kosong, proses seperti biasa
        return new Debitur([
            'id_cabang' => $this->cabang,
            'no_rekening' => $row['no_rekening'],
            'nama_nasabah' => $row['nama_nasabah'],
            'alamat' => $row['alamat'],
            'tgl_realisasi' => $tgl_realisasi,
            'jkw' => $row['jkw'],
            'tgl_jth_tempo' => $tgl_jth_tempo,
            'plafon' => $row['plafon'],
            'baki_debet' => $row['baki_debet'],
            'tunggakan_bunga' => $row['tunggakan_bunga'],
            'tunggakan_pokok' => $row['tunggakan_pokok'],
            'dpd' => $row['dpd'],
            'kol' => $row['kol'],
            'no_hp' => $row['no_hp'],
            'kolektor' => $row['kolektor']
        ]);
    }


    // Fungsi untuk memeriksa apakah nilai adalah tanggal yang valid
    protected function isValidDate($date)
    {
        return DateTime::createFromFormat('d/m/Y', $date) !== false;
    }
}
