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