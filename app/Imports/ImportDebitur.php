<?php

namespace App\Imports;

use App\Models\Debitur\Debitur;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Log;
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

        // LOGGING, LIHAT HASIL LOG DI STORAGE/LOGS/laravel.log
        // Log nilai row untuk debugging
        // Log::info('Processing row: ', $row);

        // Logging nilai asli yang diterima dari Excel
        // Log::info('Original dates: ', ['realisasi' => $row['realisasi'], 'jth_tempo' => $row['jth_tempo']]);

        // Lakukan konversi tanggal atau serial number Excel ke tanggal
        $tgl_realisasi = $this->convertToDate($row['realisasi']);
        $tgl_jth_tempo = $this->convertToDate($row['jth_tempo']);

        // Logging nilai tanggal setelah konversi
        // Log::info('Converted dates:', [
        //     'tgl_realisasi' => $tgl_realisasi,
        //     'tgl_jth_tempo' => $tgl_jth_tempo,
        // ]);


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


    // Fungsi untuk mengonversi nilai ke tanggal
    protected function convertToDate($value)
    {
        // format date excel
        if ($this->isExcelDate($value)) {
            return Date::excelToDateTimeObject($value);
        }
        // format d/m/y
        elseif ($this->isDateSlash($value)) {
            return \Carbon\Carbon::createFromFormat('d/m/Y', $value);
        }
        // format d-m-y 
        elseif ($this->isDateDash($value)) {
            return \Carbon\Carbon::createFromFormat('d-m-Y', $value);
        }
        // format Y-m-d 
        elseif ($this->isDateDashYMD($value)) {
            return \Carbon\Carbon::createFromFormat('Y-m-d', $value);
        }
        // format Y/m/d
        elseif ($this->isDateSlashYMD($value)) {
            return \Carbon\Carbon::createFromFormat('Y/m/d', $value);
        } else {
            return null;
        }
    }

    // Fungsi untuk memeriksa apakah nilai adalah serial number Excel
    protected function isExcelDate($value)
    {
        return is_numeric($value) && $value > 0 && $value < 2958465; // Nilai valid serial number Excel (1 Jan 1900 hingga 31 Des 9999)
    }

    // Fungsi untuk memeriksa apakah nilai adalah tanggal yang valid dalam format dd/mm/yyyy
    protected function isDateSlash($date)
    {
        return DateTime::createFromFormat('d/m/Y', $date) !== false;
    }

    // Fungsi untuk memeriksa apakah nilai adalah tanggal yang valid dalam format dd-mm-yyyy
    protected function isDateDash($date)
    {
        return DateTime::createFromFormat('d-m-Y', $date) !== false;
    }

    // Fungsi untuk memeriksa apakah nilai adalah tanggal yang valid dalam format yyyy-mm-dd
    protected function isDateDashYMD($date)
    {
        return DateTime::createFromFormat('Y-m-d', $date) !== false;
    }

    // Fungsi untuk memeriksa apakah nilai adalah tanggal yang valid dalam format yyyy/mm/dd
    protected function isDateSlashYMD($date)
    {
        return DateTime::createFromFormat('Y/m/d', $date) !== false;
    }
}
