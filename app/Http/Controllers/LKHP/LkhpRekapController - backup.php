<?php

namespace App\Http\Controllers\LKHP;

use App\Http\Controllers\Controller;
use App\Models\LKHP\{Lkhp, LkhpFinal, Pivot};
use App\Models\LogActivity;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DOMDocument;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;
use View;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\{Mail, Crypt, Response};

class LkhpRekapController extends Controller
{
    // Menggunakan Simple HTML dan MIME Type: langsung print word tanpa library apapun
    public function printLkhpAsWord($id)
    {
        $ids = Crypt::decrypt($id);
        $lkhp_final = LkhpFinal::with(['pivot.pivotImg'])
            ->where('id_lkhp_final', $ids)
            ->first();
        // Grouping pivots by id_event_risk
        $groupedPivots = $lkhp_final->pivot->groupBy('id_event_risk');

        $headers = array(
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'attatchement;Filename=mydoc.doc'
        );

        return Response::make(view('Page.Lkhp_Final.print.print-ops-pdf', compact('lkhp_final', 'groupedPivots')), 200, $headers);


        // Pengembalian dari tempalate word
        // Creating the new document...
        // $templatePath = ('template.docx');
        // $phpWord = new TemplateProcessor($templatePath);

        // Setting values
        // $phpWord->setValues([
        // 'cabang' => $lkhp_final->cabang->cabang,
        // 'tgl_pemeriksaan' => $lkhp_final->tgl_awal->translatedFormat('d') . ' s/d ' . $lkhp_final->tgl_akhir->translatedFormat('d F Y'),
        // 'objek' => $lkhp_final->objek_pemeriksaan,
        // 'no_lkhp' => $lkhp_final->no_lkhp,
        // 'detail_re' => $detail_re,
        // 'indikasi_resiko' => $indikasi_resiko,
        // 'fakta' => $lkhp_final->desc_uraian_permasalahan_fakta,
        // 'keadaan' => $lkhp_final->desc_keadaan_seharusnya,
        // 'dampak' => $lkhp_final->dampak_resiko,
        // 'penyebab' => $lkhp_final->penyebab_terjadi_penyimpangan,
        // 'tindak_lanjut' => $lkhp_final->tindak_lanjut,
        // 'tanggapan' => $lkhp_final->tanggapan_auditee,
        // 'tindakan' => $lkhp_final->komitmen_tindakan,
        // 'tgl' => $lkhp_final->komitmen_tgl ? $lkhp_final->komitmen_tgl->translatedFormat('d F Y') : 'Belum ada data',
        // 'penanggung_jawab' => $lkhp_final->penggung_jawab,
        // 'tgl_akhir' => $lkhp_final->tgl_akhir->translatedFormat('d F Y'),
        // 'ttd_pemeriksa' => $lkhp_final->ttd_pemeriksa,
        // 'ttd_kakom' => $lkhp_final->ttd_kakom ? $lkhp_final->ttd_kakom : 'Belum ada data',
        // 'ttd_kaops' => $lkhp_final->ttd_kaops ? $lkhp_final->ttd_kaops : 'Belum ada data',
        // 'ttd_pincab' => $lkhp_final->ttd_pincab ? $lkhp_final->ttd_pincab : 'Belum ada data'
        // ]);

        // Path untuk menyimpan dokumen yang sudah dihasilkan
        // $outputPath = storage_path('app/public/output.docx');

        // // Simpan dokumen yang sudah diisi
        // $phpWord->saveAs($outputPath);

        // // Kembalikan file sebagai respon download
        // if (file_exists($outputPath)) {
        // return response()->download($outputPath)->deleteFileAfterSend(true);
        // } else {
        // return response()->json(['error' => 'Failed to generate the document.'], 500);
        // }
    }



    // menggunakan PHPWord template prosesor menggunakan table
    public function printLkhpAsWord2($id)
    {
        // Ambil semua data dari model
        $users = User::all();

        // Path ke template Word
        $templatePath =  ('contoh.docx');

        // Buat instance TemplateProcessor
        $templateProcessor = new TemplateProcessor($templatePath);

        // Gandakan baris tabel sesuai dengan jumlah data
        $templateProcessor->cloneRow('nama', $users->count());

        // Isi placeholder di tabel dengan data
        foreach ($users as $index => $user) {
            $templateProcessor->setValue('no#' . ($index + 1), $index++);
            $templateProcessor->setValue('nama#' . ($index + 1), $user->nama);
            $templateProcessor->setValue('email#' . ($index + 1), $user->email);
        }

        // Simpan atau unduh dokumen yang telah diproses
        $fileName = 'document_' . now()->format('YmdHis') . '.docx';
        $filePath = storage_path('app/public/' . $fileName);
        $templateProcessor->saveAs($filePath);

        // Kembalikan response (misalnya, untuk mendownload file)
        return response()->download($filePath)->deleteFileAfterSend(true);
    }


    // menggunakan PHPWord template prosesor Tanpa menggunakan Table tapi harus pakai blok di template wordnya list sama number
    public function printLkhpAsWord3($id)
    {
        // Ambil semua data dari model
        $users = User::all();

        // Path ke template Word
        $templatePath =  ('contoh tanpa tabel.docx');

        // Buat instance TemplateProcessor
        $templateProcessor = new TemplateProcessor($templatePath);

        // Gandakan baris tabel sesuai dengan jumlah data
        $templateProcessor->cloneBlock('item_block', $users->count(), true, true);

        // Isi placeholder di tabel dengan data
        foreach ($users as $index => $user) {
            $templateProcessor->setValue('no#' . ($index + 1), $index + 1);
            $templateProcessor->setValue('nama#' . ($index + 1), $user->nama);
            $templateProcessor->setValue('email#' . ($index + 1), $user->email);
        }

        // Simpan atau unduh dokumen yang telah diproses
        $fileName = 'document_' . now()->format('YmdHis') . '.docx';
        $filePath = storage_path('app/public/' . $fileName);
        $templateProcessor->saveAs($filePath);

        // Kembalikan response (misalnya, untuk mendownload file)
        return response()->download($filePath)->deleteFileAfterSend(true);
    }



    // Menampilkan data tunggal
    public function printLkhpAsWord4($id)
    {
        // Ambil semua data dari model
        $user = User::first();

        // Path ke template Word
        $templatePath =  ('contoh 1 data.docx');

        // Buat instance TemplateProcessor
        $templateProcessor = new TemplateProcessor($templatePath);


        // Isi placeholder di tabel dengan data
        // foreach ($users as $index => $user) {
        $templateProcessor->setValue('no', 1);
        $templateProcessor->setValue('nama', $user->nama);
        $templateProcessor->setValue('email', $user->email);
        // img
        $templateProcessor->setImageValue('CompanyLogo', 'path/to/company/logo.png');
        // img with style
        $templateProcessor->setImageValue('UserLogo', array('path' => 'path/to/logo.png', 'width' => 100, 'height' => 100, 'ratio' => false));
        // }

        // Simpan atau unduh dokumen yang telah diproses
        $fileName = 'document_' . now()->format('YmdHis') . '.docx';
        $filePath = storage_path('app/public/' . $fileName);
        $templateProcessor->saveAs($filePath);
        // $filePath = ('phpWord/' . $fileName); // alternatif save

        // Kembalikan response (misalnya, untuk mendownload file)
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
