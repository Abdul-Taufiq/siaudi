<?php

namespace App\Http\Controllers\LKHP;

use App\Http\Controllers\Controller;
use App\Models\LKHP\Lkhp;
use App\Models\LKHP\Pivot;
use App\Models\LKHP\PivotImg;
use App\Models\LogActivity;
use App\Models\RiskEvent\RiskEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DOMDocument;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class LkhpOpsController extends Controller
{
    public function create()
    {
        $riskEvent = RiskEvent::OrderBy('kode_finding', 'ASC')->get();
        return view('Page.Lkhp.Operasional.create', compact('riskEvent'), ['title' => 'Tambah Data LKHP - Operasional']);
    }

    public function store(Request $request)
    {
        for ($re = 1; $re < 50; $re++) {
            # code...
            $ambil = Lkhp::all()->last();
            $bulanRom = \Carbon\Carbon::now()->format('m');
            switch ($bulanRom) {
                case 1:
                    $bulanRom = "I";
                    break;
                case 2:
                    $bulanRom = "II";
                    break;
                case 3:
                    $bulanRom = "III";
                    break;
                case 4:
                    $bulanRom = "IV";
                    break;
                case 5:
                    $bulanRom = "V";
                    break;
                case 6:
                    $bulanRom = "VI";
                    break;
                case 7:
                    $bulanRom = "VII";
                    break;
                case 8:
                    $bulanRom = "VIII";
                    break;
                case 9:
                    $bulanRom = "IX";
                    break;
                case 10:
                    $bulanRom = "X";
                    break;
                case 11:
                    $bulanRom = "XI";
                    break;
                case 12:
                    $bulanRom = "XII";
            }
            $thn = Carbon::now()->year;
            if ($ambil == null) {
                $cekTahun = Carbon::now()->year;
                $urut = '0001'; // Perhatikan bahwa '0001' harus dalam tanda kutip untuk mempertahankan nol di depan
                $nomer = $urut . '/LK-BY/' . $bulanRom . '/' . $thn;
            } else {
                $cekTahun = substr($ambil->no_lkhp_bayangan, -4);
                if ($cekTahun != $thn) {
                    $urut = '0001'; // Perhatikan bahwa '0001' harus dalam tanda kutip untuk mempertahankan nol di depan
                    $nomer = $urut . '/LK-BY/' . $bulanRom . '/' . $thn;
                } else {
                    $urut = intval(substr($ambil->no_lkhp_bayangan, 0, 4)) + 1;
                    $urut = str_pad($urut, 4, '0', STR_PAD_LEFT); // Menyertakan panjang hasil yang diinginkan, yaitu 4
                    $nomer = $urut . '/LK-BY/' . $bulanRom . '/' . $thn;
                }
            }

            // convert u/ summernote
            $desc_uraian = $this->SummernoteImg($request->input('desc_uraian_permasalahan_fakta_' . $re));
            $desc_keadaan = $this->SummernoteImg($request->input('desc_keadaan_seharusnya_' . $re));
            $penyebab_penyimpangan = $this->SummernoteImg($request->input('penyebab_terjadi_penyimpangan_' . $re));
            $dampak_resiko = $this->SummernoteImg($request->input('dampak_resiko_' . $re));
            $tindak_lanjut = $this->SummernoteImg($request->input('tindak_lanjut_' . $re));
            // lkhp
            if ($request->input('id_event_risk_' . $re)) {
                // save lkhp bayangan
                $lkhp = Lkhp::create([
                    'id_cabang' => $request->id_cabang,
                    'tgl_awal' => Carbon::createFromFormat('d-m-Y', $request->tgl_awal)->format('Y-m-d'),
                    'tgl_akhir' => Carbon::createFromFormat('d-m-Y', $request->tgl_akhir)->format('Y-m-d'),
                    'objek_pemeriksaan' => $request->objek_pemeriksaan,
                    'total_noa' => $request->input('total_noa_' . $re),
                    'no_lkhp_bayangan' => $nomer,
                    'desc_uraian_permasalahan_fakta' => $desc_uraian,
                    'desc_keadaan_seharusnya' => $desc_keadaan,
                    'penyebab_terjadi_penyimpangan' => $penyebab_penyimpangan,
                    'dampak_resiko' => $dampak_resiko,
                    'tindak_lanjut' => $tindak_lanjut,
                    'nama_creator' => auth()->user()->nama
                ]);

                // save kkpk on pivot
                for ($pi_kkpk = 0; $pi_kkpk <= 50; $pi_kkpk++) {
                    // Periksa apakah input id_kkpk ada dan tidak kosong
                    $keteranganFinal = $request->input('keterangan_re_' . $re . '_' . $pi_kkpk);

                    if ($keteranganFinal) {
                        # code...
                        $piv_re = Pivot::create([
                            'id_lkhp' => $lkhp->id_lkhp,
                            'id_event_risk' => $request->input('id_event_risk_' . $re),

                            'keterangan_re' => $this->SummernoteImg($keteranganFinal)
                        ]);
                    }

                    // save img pivot
                    for ($img = 0; $img < 50; $img++) {
                        # code...
                        $image = $request->file('img_re_' . $re . '_' . $pi_kkpk . '_' . $img);
                        $CaptionImg = $request->input('caption_re_'  . $re . '_' . $pi_kkpk . '_' . $img);
                        if ($image != null) {
                            // config gambar
                            $gambar = $request->file('img_re_' . $re . '_' . $pi_kkpk . '_' . $img);
                            $fileName = $gambar->getClientOriginalName();
                            // Ganti karakter '/' dengan '_'
                            $folderName = str_replace('/', '_', $nomer);
                            $gambar->move('gambar/Gambar Pendukung LK - ' . $folderName, $fileName);

                            $pivotImg = new PivotImg();
                            $pivotImg->id_pivot = $piv_re->id_pivot;
                            $pivotImg->img = $fileName;
                            $pivotImg->caption = $CaptionImg;
                            $pivotImg->save();
                        }
                    }
                }
            }
        }

        // log Act
        $aksi = "(+) Tambah LKHP No.: " . $nomer;
        $this->logAct($aksi);
        return redirect('/data-lkhp')->with('AlertSuccess', 'Data Berhasil Disimpan!');
    }


    public function show($lkhp)
    {
        $ids = Crypt::decrypt($lkhp); //decript link
        $lkhp = Lkhp::where('id_lkhp', $ids)->first();

        return view('Page.Lkhp.Operasional.show', compact('lkhp'), ['title' => 'Show ' . $lkhp->no_lkhp_bayangan]);
    }

    public function showDetail($lkhp)
    {
        $ids = Crypt::decrypt($lkhp); //decript link
        $lkhp = Lkhp::with(['pivot.pivotImg'])
            ->where('id_lkhp', $ids)
            ->first();

        // Grouping pivots by id_event_risk
        $groupedPivots = $lkhp->pivot->groupBy('id_event_risk');

        // untuk akses folder gambar
        $replace = str_replace('/', '_', $lkhp->no_lkhp_bayangan);
        $folderName = 'gambar/Gambar Pendukung LK - ' . $replace;

        return view('Page.Lkhp.Operasional.show-detail', compact('lkhp', 'folderName', 'groupedPivots'), ['title' => 'Edit ' . $lkhp->no_lkhp_bayangan]);
    }


    public function edit($lkhp)
    {
        $ids = Crypt::decrypt($lkhp);

        $lkhp = Lkhp::where('id_lkhp', $ids)->first();
        $pivot = Pivot::where('id_lkhp', $ids)->get();
        $riskEvent = RiskEvent::OrderBy('kode_finding', 'ASC')->get();

        return view('Page.Lkhp.Operasional.edit-ops', compact('lkhp', 'pivot', 'riskEvent'), [
            'title' => 'Edit LKHP Operasional ' . $lkhp->no_lkhp_bayangan
        ]);
    }


    public function update(Request $request, Lkhp $lkhp)
    {
        // convert u/ summernote
        $desc_uraian = $this->SummernoteImg($request->desc_uraian_permasalahan_fakta);
        $desc_keadaan = $this->SummernoteImg($request->desc_keadaan_seharusnya);
        $penyebab_penyimpangan = $this->SummernoteImg($request->penyebab_terjadi_penyimpangan);
        $dampak_resiko = $this->SummernoteImg($request->dampak_resiko);
        $tindak_lanjut = $this->SummernoteImg($request->tindak_lanjut);

        // update lkhp
        $lkhp->update([
            'tgl_awal' => Carbon::createFromFormat('d-m-Y', $request->tgl_awal)->format('Y-m-d'),
            'tgl_akhir' => Carbon::createFromFormat('d-m-Y', $request->tgl_akhir)->format('Y-m-d'),
            'total_noa' => $request->total_noa,
            'objek_pemeriksaan' => $request->objek_pemeriksaan,
            'desc_uraian_permasalahan_fakta' => $desc_uraian,
            'desc_keadaan_seharusnya' => $desc_keadaan,
            'penyebab_terjadi_penyimpangan' => $penyebab_penyimpangan,
            'dampak_resiko' => $dampak_resiko,
            'tindak_lanjut' => $tindak_lanjut,
        ]);

        // deklarasi pivot
        $pivot = Pivot::where('id_lkhp', $lkhp->id_lkhp)->get();
        $pivot_tunggal = Pivot::where('id_lkhp', $lkhp->id_lkhp)->first();

        // Update Pivot untuk Risk Event dan Image
        foreach ($pivot as $item) {
            for ($aksi_re = 1; $aksi_re <= 50; $aksi_re++) {
                // Ambil nilai dari request
                $aksi = $request->input('aksi_' . $aksi_re);
                $id_event_risk = $request->input('id_event_risk_old_' . $aksi_re);
                $keterangan_re = $request->input('keterangan_re_old_' . $aksi_re);

                // Debugging untuk memastikan nilai tidak null
                Log::info('Aksi: ' . $aksi);
                Log::info('ID Event Risk: ' . $id_event_risk);
                Log::info('Keterangan RE: ' . $keterangan_re);

                // Kondisi aksi_re untuk RE
                if ($aksi != 'Hapus') {
                    // Pastikan nilai tidak null sebelum update
                    if (!is_null($id_event_risk) && !is_null($keterangan_re)) {
                        // Update Pivot untuk Keterangan dan RE
                        $item->update([
                            'id_event_risk' => $id_event_risk,
                            'keterangan_re' => $keterangan_re
                        ]);
                    }
                } else {
                    $item->delete();
                }
            }

            # foreach untuk update pivot IMG
            foreach ($item->pivotImg as $pivotimg) {
                for ($aksi_img = 1; $aksi_img < 10; $aksi_img++) {
                    # kondisi update img
                    $image = $request->file('img_re_old_' . $aksi_re . '_' . $aksi_img);
                    if ($request->input('aksi_gambar_' . $aksi_re . '_' . $aksi_img) != 'Hapus') {
                        if ($image != null) {
                            // config gambar
                            $gambar = $image;
                            $fileName = $gambar->getClientOriginalName();
                            // Ganti karakter '/' dengan '_'
                            $folderName = str_replace('/', '_', $lkhp->no_lkhp_bayangan);
                            $gambar->move('gambar/Gambar Pendukung LK - ' . $folderName, $fileName);

                            $pivotimg->update([
                                'img' => $fileName,
                                'caption' => $request->input('caption_re_old_' . $aksi_re . '_' . $aksi_img),
                            ]);
                        }
                    } else {
                        $pivotimg->delete();
                    }
                }
            }
        }

        // Add baru untuk Pivot Risk Event Image
        for ($counter_re = 1; $counter_re <= 50; $counter_re++) {
            # kondisi save new untuk RE
            if ($request->input('id_event_risk_' . $counter_re) != null) {
                # Update Pivot untuk Keterangan dan RE
                $re = new Pivot();
                $re->id_lkhp = $pivot_tunggal->id_lkhp;
                $re->id_kkpk = $pivot_tunggal->id_kkpk;
                $re->id_event_risk = $request->input('id_event_risk_' . $counter_re);
                $re->keterangan_re = $request->input('keterangan_re_' . $counter_re);
                $re->save();
            }

            # kondisi save new untuk Image
            for ($counter_img = 1; $counter_img < 10; $counter_img++) {
                # kondisi update img
                $image = $request->file('img_re_' . $counter_re . '_' . $counter_img);
                if ($image) {
                    // config gambar
                    $gambar = $image;
                    $fileName = $gambar->getClientOriginalName();
                    // Ganti karakter '/' dengan '_'
                    $folderName = str_replace('/', '_', $lkhp->no_lkhp_bayangan);
                    $gambar->move('gambar/Gambar Pendukung LK - ' . $folderName, $fileName);

                    $pivotimg = new PivotImg();
                    $pivotimg->insert([
                        'id_pivot' => $re->id_pivot,
                        'img' => $fileName,
                        'caption' => $request->input('caption_re_' . $counter_re . '_' . $counter_img),
                    ]);
                }
            }
        }

        // log Act
        $aksi = "(u) Update RE untuk LKHP Nomor: " . $pivot_tunggal->lkhp->no_lkhp_bayangan;
        $this->logAct($aksi);

        return redirect()->route('data-lkhp.index')->with('AlertSuccess', 'Data LKHP Operasional berhasil diubah');
    }


    // fungsi handle summernote img
    private function SummernoteImg($html)
    {
        // Jika HTML kosong, kembalikan HTML seperti awal
        if (empty($html)) {
            return $html;
        }

        // Buat objek DOMDocument
        $dom = new DOMDocument();
        // Muat HTML ke dalam objek DOMDocument
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        // Ambil semua elemen gambar dalam HTML
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $key => $img) {
            // Ambil nilai atribut 'rc'
            $src = $img->getAttribute('src');
            // Jika 'rc' berisi URL gambar dalam format base64
            if (strpos($src, 'base64,') !== false) {
                // Pisahkan tipe data dan data gambar
                list($type, $data) = explode(';', $src);
                list(, $data) = explode(',', $data);
                // Dekode data gambar dari format base64
                $data = base64_decode($data);

                // Buat nama file gambar baru
                $image_name = '/upload/img/' . time() . $key . '.png';
                // Simpan gambar ke dalam direktori yang ditentukan
                file_put_contents(public_path() . $image_name, $data);

                // Hapus atribut 'rc' yang lama
                $img->removeAttribute('src');
                // Tambahkan atribut 'rc' yang baru ke elemen gambar
                $img->setAttribute('src', $image_name);
            }
        }

        // Kembalikan HTML yang diperbarui
        return $dom->saveHTML();
    }

    // ============
    // Log Activity
    private function logAct($aksi)
    {
        $log = new LogActivity();
        $log->username = auth()->user()->nama;
        $log->email = auth()->user()->email;
        $log->jabatan = auth()->user()->sub_jabatan;
        $log->aksi = $aksi . " <br> Tanggal Aksi: " . now()->translatedFormat('d F Y, H:i');
        $log->save();
    }
}
