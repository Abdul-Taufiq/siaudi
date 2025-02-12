<?php

namespace App\Http\Controllers\KKPK;

use App\Http\Controllers\Controller;
use App\Models\Debitur\Debitur;
use App\Models\KKPK\{Kko, Kkpk, KkpkKeterangan};
use App\Models\Lainnya;
use App\Models\LogActivity;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class KkpkController extends Controller
{
    public function index(Request $request)
    {
        $awal = Carbon::parse($request->min)->startOfDay();
        $akhir = Carbon::parse($request->max)->endOfDay();
        $username = auth()->user()->nama;
        $level = auth()->user()->level;
        $id_cabang = auth()->user()->id_cabang;
        $reqCabang = $request->id_cabang;

        if (request()->ajax()) {
            if ($level == 'MEDIUM USER') {
                if (!empty($request->min)) {
                    $data = Kkpk::whereBetween('created_at', [$awal, $akhir])
                        ->where('id_cabang', $id_cabang)
                        ->orderBy('created_at', 'desc')->get();
                } else {
                    $data = Kkpk::orderBy('created_at', 'desc')
                        ->where('id_cabang', $id_cabang)->get();
                }
            } else {
                if (auth()->user()->sub_jabatan == 'Kabid Audit Internal') {
                    if (!empty($request->min)) {
                        if ($reqCabang == 99) {
                            $data = Kkpk::whereBetween('created_at', [$awal, $akhir])
                                ->orderBy('created_at', 'desc')->get();
                        } else {
                            $data = Kkpk::whereBetween('created_at', [$awal, $akhir])
                                ->where('id_cabang', $reqCabang)
                                ->orderBy('created_at', 'desc')->get();
                        }
                    } else {
                        $data = Kkpk::orderBy('created_at', 'desc')->get();
                    }
                } else {
                    if (!empty($request->min)) {
                        if ($reqCabang == 99) {
                            $data = Kkpk::where('nama_pemeriksa', $username)->whereBetween('created_at', [$awal, $akhir])
                                ->orderBy('created_at', 'desc')->get();
                        } else {
                            $data = Kkpk::where('nama_pemeriksa', $username)->whereBetween('created_at', [$awal, $akhir])
                                ->where('id_cabang', $reqCabang)
                                ->orderBy('created_at', 'desc')->get();
                        }
                    } else {
                        $data = Kkpk::where('nama_pemeriksa', $username)->orderBy('created_at', 'desc')->get();
                    }
                }
            }

            return DataTables()->of($data)
                ->addColumn('cabang', function ($data) {
                    return $data->cabang->cabang;
                })
                ->addColumn('no_rekening', function ($data) {
                    return $data->debitur->no_rekening;
                })
                ->addColumn('nama_nasabah', function ($data) {
                    return $data->debitur->nama_nasabah;
                })
                ->addColumn('action', function ($data) {
                    $button = '<a data-toggle="modal" data-target="#myModal' . $data->id_kkpk  . '" id="' . $data->id_kkpk  . '"
                                        class="btn btn-info btn-sm detail_data" data-kode_form="' . $data->kode_kkpk . '" data-id="' . encrypt($data->id_kkpk)  . '">
                                        <span class="icon text-white-50">
                                        <i class="fa fa-eye"></i>
                                        </span>
                                    </a>';
                    $button .= '&nbsp;';
                    // Cek apakah user memiliki hak akses untuk mengedit atau menghapus
                    if (auth()->user()->sub_jabatan == 'Kabid Audit Internal' || auth()->user()->nama == $data->nama_pemeriksa) {
                        // cek apakah kkpk udah ditambahkan ke LKHP atau belum if yes maka button off
                        if ($data->status == null) {
                            # code...
                            // Tombol tambah KKO
                            $button .= '<a data-toggle="modal" data-target="#modalTambahKKO' . $data->id_kkpk  . '" id="' . $data->debitur->id_debitur  . '"
                                                class="btn btn-success btn-sm tambah_kko" data-kode_form="' . $data->kode_kkpk . '">
                                                <i class="fa fa-plus"></i></a>';
                            $button .= '&nbsp;';
                            // Tombol edit
                            $button .= '<a data-toggle="modal" data-target="#modalEdit' . $data->id_kkpk  . '" id="' . $data->id_kkpk  . '"
                                                class="btn btn-warning btn-sm edit" data-kode_form="' . $data->kode_kkpk . '">
                                                <i class="fa fa-edit"></i></a>';
                            $button .= '&nbsp;';
                            // Tombol hapus
                            $button .= '<a data-toggle="modal" id="' . $data->id_kkpk  . '"
                                                class="hapus btn btn-danger btn-sm delete-post ">
                                                <i class="fa fa-trash"></i></a>';
                        } else {
                            // Jika tidak memenuhi kondisi, tambahkan kelas disabled pada tombol
                            $button .= '<a class="btn btn-success btn-sm disabled"><i class="fa fa-plus"></i></a>';
                            $button .= '&nbsp;';
                            $button .= '<a class="btn btn-warning btn-sm edit disabled"><i class="fa fa-edit"></i></a>';
                            $button .= '&nbsp;';
                            $button .= '<a class="delete btn btn-danger btn-sm delete-post disabled"><i class="fa fa-trash"></i></a>';
                        }
                    } else {
                        // Jika tidak memenuhi kondisi, tambahkan kelas disabled pada tombol
                        $button .= '<a class="btn btn-success btn-sm disabled"><i class="fa fa-plus"></i></a>';
                        $button .= '&nbsp;';
                        $button .= '<a class="btn btn-warning btn-sm edit disabled"><i class="fa fa-edit"></i></a>';
                        $button .= '&nbsp;';
                        $button .= '<a class="delete btn btn-danger btn-sm delete-post disabled"><i class="fa fa-trash"></i></a>';
                    }
                    return $button;
                })

                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('Page.Kkpk.index', ['title' => 'Kertas Kerja Pemeriksaan Kredit']);
    }


    public function getNasabah($Id)
    {
        $data = Debitur::where('id_cabang', $Id)->get();
        $nama_ao = User::where('jabatan', 'AO')->where('id_cabang', $Id)->where('status', 'Aktif')->get();
        $nama_analis = User::where('jabatan', 'Analis Cabang')->where('id_cabang', $Id)->where('status', 'Aktif')->get();
        $nama_kakom = User::where('jabatan', 'Kasi Komersial')->where('id_cabang', $Id)->where('status', 'Aktif')->get();
        $nama_pincab = User::where('jabatan', 'Pimpinan Cabang')->where('id_cabang', $Id)->where('status', 'Aktif')->get();
        $nama_analis_area = Lainnya::where('jabatan', 'Analis Area')->get();
        $nama_area_manager = Lainnya::where('jabatan', 'Area Manager')->get();
        $nama_manager_bisnis = Lainnya::where('jabatan', 'Manager Bisnis')->get();
        $nama_analis_kpm = Lainnya::where('jabatan', 'Analis KPM')->get();
        $nama_direksi = Lainnya::where('jabatan', 'Direksi')->get();
        return response()->json([
            'status' => 200,
            'data' => $data,
            'nama_ao' => $nama_ao,
            'nama_analis' => $nama_analis,
            'nama_kakom' => $nama_kakom,
            'nama_pincab' => $nama_pincab,
            'nama_analis_area' => $nama_analis_area,
            'nama_area_manager' => $nama_area_manager,
            'nama_manager_bisnis' => $nama_manager_bisnis,
            'nama_analis_kpm' => $nama_analis_kpm,
            'nama_direksi' => $nama_direksi,
        ]);
    }

    public function detailNasabah($Id)
    {
        $data = Debitur::where('id_debitur', $Id)->first();
        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function AddKKO(Request $request, $Id)
    {
        $kkpk = Kkpk::where('id_debitur', $Id)->first();
        $kko = Kko::where('id_kkpk', $kkpk->id_kkpk)->first();
        if ($kko > 0) {
            $kko->delete();
        };
        Debitur::where('id_debitur', $kkpk->id_debitur)->update([
            'alamat_jaminan' => $request->alamat_jaminan
        ]);

        // Convert untuk deskripsi
        $deskripsi = $request->deskripsi;
        $dom = new DOMDocument();
        // Menghindari error dengan menambahkan LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        @$dom->loadHTML($deskripsi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');
        foreach ($images as $key => $img) {
            // Memisahkan dan mendekode gambar base64
            $src = $img->getAttribute('src');
            if (strpos($src, 'base64,') !== false) {
                $data = base64_decode(explode(',', explode(';', $src)[1])[1]);
                // $image_name = 'upload/img/' . time() . $key . '.png';
                $image_name = url('/resource-gambar/' . time() . $key . '.png');

                // Menyimpan gambar ke public_html
                file_put_contents(public_path($image_name), $data);

                // Memperbarui atribut src dengan path yang benar
                $img->removeAttribute('src');
                $img->setAttribute('src', '/' . $image_name);
            }
        }

        // Menyimpan kembali HTML yang sudah diperbarui
        $deskripsi = $dom->saveHTML();


        $data = Kko::create([
            'id_kkpk' => $kkpk->id_kkpk,
            'tgl_kunjungan' => Carbon::createFromFormat('d-m-Y', $request->tgl_kunjungan)->format('Y-m-d'),
            'deskripsi' => $deskripsi
        ]);

        // log Act
        $aksi = "(+) Tambah Data KUNJUNGAN DEBITUR : " . $kkpk->debitur->nama_nasabah;
        $this->logAct($aksi);

        return redirect()->back()->with('AlertSuccess', 'Data Berhasil Disimpan!');
    }

    public function ShowKKO($Id)
    {
        $kkpk = Kkpk::where('id_kkpk', $Id)->first();
        $data = Kko::where('id_kkpk', $Id)->first();
        return view('Page.Kkpk.show-kko', compact('data', 'kkpk'));
    }

    public function EditKKO($Id)
    {
        $kkpk = Kkpk::where('id_kkpk', $Id)->first();
        $data = Kko::where('id_kkpk', $Id)->first();
        if ($data == null) {
            abort(403, "Data OTS belum ada, silahkan tambahakan terlebih dahulu!");
        }
        return view('Page.Kkpk.edit-kko', compact('kkpk', 'data'), ['title' => 'ok']);
    }

    public function UpdateKKO(Request $request, $Id)
    {
        $kkpk = Kkpk::where('id_kkpk', $Id)->first();
        Debitur::where('id_debitur', $kkpk->id_debitur)->update([
            'alamat_jaminan' => $request->alamat_jaminan
        ]);

        // Convert untuk deskripsi
        $deskripsi = $request->deskripsi;
        $dom = new DOMDocument();
        // Menghindari error dengan menambahkan LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        @$dom->loadHTML($deskripsi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');
        foreach ($images as $key => $img) {
            // Memisahkan dan mendekode gambar base64
            $src = $img->getAttribute('src');
            if (strpos($src, 'base64,') !== false) {
                $data = base64_decode(explode(',', explode(';', $src)[1])[1]);
                // $image_name = 'upload/img/' . time() . $key . '.png';
                $image_name = url('/resource-gambar/' . time() . $key . '.png');

                // Menyimpan gambar ke public_html
                file_put_contents(public_path($image_name), $data);

                // Memperbarui atribut src dengan path yang benar
                $img->removeAttribute('src');
                $img->setAttribute('src', '/' . $image_name);
            }
        }

        // Menyimpan kembali HTML yang sudah diperbarui
        $deskripsi = $dom->saveHTML();


        $data = Kko::where('id_kkpk', $Id)->update([
            'tgl_kunjungan' => Carbon::createFromFormat('d-m-Y', $request->tgl_kunjungan)->format('Y-m-d'),
            'deskripsi' => $deskripsi
        ]);

        // log Act
        $aksi = "(u) Update Data KUNJUNGAN DEBITUR : " . $kkpk->debitur->nama_nasabah;
        $this->logAct($aksi);

        return 'Data Berhasil Disimpan!';
    }

    public function PrintKKO($Id)
    {
        $ids = Crypt::decrypt($Id);
        $kkpk = Kkpk::where('id_kkpk', $ids)->first();
        $data = Kko::where('id_kkpk', $ids)->first();
        $htmlText = $data->deskripsi; // Ambil teks HTML dari database

        // Gunakan regular expression untuk mencari tag <img> dalam teks HTML
        $htmlText = preg_replace_callback('/<img.*?src="(.*?)".*?>/i', function ($matches) {
            $imageUrl = $matches[1]; // Ambil URL gambar dari tag <img>
            $imageData = base64_encode(file_get_contents(public_path($imageUrl))); // Ambil data base64 gambar
            return '<img src="data:image/jpeg;base64,' . $imageData . '" />'; // Ganti URL dengan data base64
        }, $htmlText);

        // Sekarang $htmlText berisi teks HTML dengan gambar-gambar yang disisipkan sebagai data base64
        $pdf = Pdf::loadView('Page.Kkpk.print-kko', compact('data', 'kkpk', 'htmlText'), ['title' => 'Print Data OTS']);
        $pdf->setPaper('A4', 'potrait')
            ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'isPhpEnabled' => true]);

        // log Act
        $aksi = "(p) Print Data KUNJUNGAN DEBITUR : " . $kkpk->debitur->nama_nasabah;
        $this->logAct($aksi);
        return $pdf->stream('OTS Nasabah dg No Rek: ' . $kkpk->no_rekening);
    }

    public function PrintKKPK($Id)
    {
        $ids = Crypt::decrypt($Id);
        $kkpk = Kkpk::where('id_kkpk', $ids)->first();

        $pdf = Pdf::loadView('Page.Kkpk.print-kkpk', compact('kkpk'));
        $pdf->setPaper('A4', 'potrait');

        // log Act
        $aksi = "(p) Print Data Kertas Kerja Pemeriksaan Kredit : " . $kkpk->debitur->nama_nasabah;
        $this->logAct($aksi);
        return $pdf->stream(' Kertas Kerja Pemeriksaan Kredit dg Kode: ' . $kkpk->kode_kkpk);
    }


    public function store(Request $request)
    {
        $ambil = Kkpk::all()->last();
        // Ambil nama bulan dalam bentuk romawi
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
            $nomer = $urut . '/AI_KP/' . $bulanRom . '/' . $thn;
        } else {
            $cekTahun = substr($ambil->kode_kkpk, -4);
            if ($cekTahun != $thn) {
                $urut = '0001'; // Perhatikan bahwa '0001' harus dalam tanda kutip untuk mempertahankan nol di depan
                $nomer = $urut . '/AI_KP/' . $bulanRom . '/' . $thn;
            } else {
                $urut = intval(substr($ambil->kode_kkpk, 0, 4)) + 1;
                $urut = str_pad($urut, 4, '0', STR_PAD_LEFT); // Menyertakan panjang hasil yang diinginkan, yaitu 4
                $nomer = $urut . '/AI_KP/' . $bulanRom . '/' . $thn;
            }
        }

        Debitur::where('id_debitur', $request->id_debitur)->update([
            'jaminan' => $request->jaminan,
            'usaha_debitur' => $request->usaha_debitur,
            'tujuan_kredit' => $request->tujuan_kredit,
            'sumber_pembayaran' => $request->sumber_pembayaran,
        ]);
        $kkpk = Kkpk::create([
            'id_cabang' => $request->id_cabang,
            'id_debitur' => $request->id_debitur,
            'kode_kkpk' => $nomer,
            'tgl_pemeriksaan' => now(),
            'nama_pemeriksa' => auth()->user()->nama,
            'jns_pemeriksaan' => $request->jns_pemeriksaan,
            'fas_kredit' => $request->fas_kredit,
            'jns_kredit' => $request->jns_kredit,
            'nama_ao' => ($request->nama_ao == 'Lainnya') ? $request->nama_ao_inp : $request->nama_ao,
            'nama_analis' => ($request->nama_analis == 'Lainnya') ? $request->nama_analis_inp : $request->nama_analis,
            'nama_kakom' => ($request->nama_kakom == 'Lainnya') ? $request->nama_kakom_inp : $request->nama_kakom,
            'nama_pincab' => ($request->nama_pincab == 'Lainnya') ? $request->nama_pincab_inp : $request->nama_pincab,
            'nama_analis_area' => $request->nama_analis_area,
            'nama_area_manager' => $request->nama_area_manager,
            'nama_manager_bisnis' => $request->nama_manager_bisnis,
            'nama_analis_kpm' => $request->nama_analis_kpm,
            'nama_direksi' => $request->nama_direksi,
        ]);

        KkpkKeterangan::create([
            'id_kkpk' => $kkpk->id_kkpk,
            'ktp_debitur' => $request->ktp_debitur,
            'ktp_pasangan' => $request->ktp_pasangan,
            'kartu_keluarga' => $request->kartu_keluarga,
            'srt_nikah' => $request->srt_nikah,
            'akte_cerai_kematian' => $request->akte_cerai_kematian,
            'ktp_debitur_penjamin' => $request->ktp_debitur_penjamin,
            'ktp_pasangan_penjamin' => $request->ktp_pasangan_penjamin,
            'kartu_keluarga_penjamin' => $request->kartu_keluarga_penjamin,
            'srt_nikah_penjamin' => $request->srt_nikah_penjamin,
            'akte_cerai_kematian_penjamin' => $request->akte_cerai_kematian_penjamin,

            'npwp' => $request->npwp,
            'info_siup' => $request->info_siup,
            'slik_debitur' => $request->slik_debitur,
            'slik_pasangan' => $request->slik_pasangan,
            'slik_badan_usaha' => $request->slik_badan_usaha,
            'fa_kredit' => $request->fa_kredit,
            'kk_analis' => $request->kk_analis,
            'muk' => $request->muk,
            'analisa_lr' => $request->analisa_lr,
            'persetujuan_muk' => $request->persetujuan_muk,
            'info_deviasi' => $request->info_deviasi,
            'permohonan_add_deb' => $request->permohonan_add_deb,
            'info_add' => $request->info_add,
            'slip_gaji' => $request->slip_gaji,
            'rek_tabungan' => $request->rek_tabungan,
            'nota_penjualan_pembelian' => $request->nota_penjualan_pembelian,
            'foto_usaha' => $request->foto_usaha,
            'denah_lokasi_usaha' => $request->denah_lokasi_usaha,
            'surat_keterangan' => $request->surat_keterangan,
            'rab' => $request->rab,
            'spk_mou' => $request->spk_mou,
            'mutasi_to' => $request->mutasi_to,
            'bukti_pelunasan' => $request->bukti_pelunasan,
            'lp_jaminan' => $request->lp_jaminan,
            'app_independen' => $request->app_independen,
            'foto_jaminan' => $request->foto_jaminan,
            'dl_jaminan' => $request->dl_jaminan,
            'gn_rangka' => $request->gn_rangka,
            'gn_mesin' => $request->gn_mesin,
            'fc_stnk' => $request->fc_stnk,
            'pbb_dll' => $request->pbb_dll,
            'imb' => $request->imb,
            'kwitansi_pencairan' => $request->kwitansi_pencairan,
            'pk' => $request->pk,
            'perjanjian_fidusia' => $request->perjanjian_fidusia,
            'pk_notaril' => $request->pk_notaril,
            'sk_pendebetan' => $request->sk_pendebetan,
            'sk_menjual' => $request->sk_menjual,
            'pt_asuransi' => $request->pt_asuransi,
            'ba_serah_terima' => $request->ba_serah_terima,
            'spk_barang' => $request->spk_barang,
            'sim_pekarangan' => $request->sim_pekarangan,
            'skmht' => $request->skmht,
            'sht' => $request->sht,
            'sertif_fidusia' => $request->sertif_fidusia,
            'foto_akad' => $request->foto_akad,
            'sertif_asli' => $request->sertif_asli,
            'bpkb_asli' => $request->bpkb_asli,
            'covernote_notaris' => $request->covernote_notaris,
            'faktur_kendaraan' => $request->faktur_kendaraan,
            'ksn_bpkb' => $request->ksn_bpkb,
            'catatan' => $request->catatan,
        ]);

        // log Act
        $aksi = "(+) Tambah Data Kertas Kerja Atas Nama: " . $kkpk->debitur->nama_nasabah;
        $this->logAct($aksi);

        return redirect()->back()->with('AlertSuccess', 'Data Berhasil Disimpan!');
    }


    public function show(Kkpk $kkpk)
    {
        return view('Page.Kkpk.show', compact('kkpk'));
    }


    public function edit(Kkpk $kkpk)
    {
        $this->authorize('Batasan', $kkpk);
        $kkpk->load('debitur'); // Memuat relasi debitur
        $kkpk->load('keterangan');
        return response()->json([
            'status' => 200,
            'data' => $kkpk
        ]);
    }


    public function update(Request $request, Kkpk $kkpk)
    {
        $this->authorize('Batasan', $kkpk);
        // $tujuanKredit = $request->input('tujuan_kredit');
        Debitur::where('id_debitur', $request->id_debitur)->update([
            'jaminan' => $request->jaminan,
            'usaha_debitur' => $request->usaha_debitur,
            'tujuan_kredit' => $request->tujuan_kredit,
            'sumber_pembayaran' => $request->sumber_pembayaran,
        ]);

        $kkpk->update([
            'id_cabang' => $request->id_cabang,
            'id_debitur' => $request->id_debitur,
            'tgl_pemeriksaan' => now(),
            'jns_pemeriksaan' => $request->jns_pemeriksaan,
            'fas_kredit' => $request->fas_kredit,
            'jns_kredit' => $request->jns_kredit,
            'nama_ao' => ($request->nama_ao == 'Lainnya') ? $request->nama_ao_inp : $request->nama_ao,
            'nama_analis' => ($request->nama_analis == 'Lainnya') ? $request->nama_analis_inp : $request->nama_analis,
            'nama_kakom' => ($request->nama_kakom == 'Lainnya') ? $request->nama_kakom_inp : $request->nama_kakom,
            'nama_pincab' => ($request->nama_pincab == 'Lainnya') ? $request->nama_pincab_inp : $request->nama_pincab,
            'nama_analis_area' => $request->nama_analis_area,
            'nama_area_manager' => $request->nama_area_manager,
            'nama_manager_bisnis' => $request->nama_manager_bisnis,
            'nama_analis_kpm' => $request->nama_analis_kpm,
            'nama_direksi' => $request->nama_direksi,
        ]);

        KkpkKeterangan::where('id_kkpk', $kkpk->id_kkpk)->update([
            'id_kkpk' => $kkpk->id_kkpk,
            'ktp_debitur' => $request->ktp_debitur,
            'ktp_pasangan' => $request->ktp_pasangan,
            'kartu_keluarga' => $request->kartu_keluarga,
            'srt_nikah' => $request->srt_nikah,
            'akte_cerai_kematian' => $request->akte_cerai_kematian,
            'ktp_debitur_penjamin' => $request->ktp_debitur_penjamin,
            'ktp_pasangan_penjamin' => $request->ktp_pasangan_penjamin,
            'kartu_keluarga_penjamin' => $request->kartu_keluarga_penjamin,
            'srt_nikah_penjamin' => $request->srt_nikah_penjamin,
            'akte_cerai_kematian_penjamin' => $request->akte_cerai_kematian_penjamin,

            'npwp' => $request->npwp,
            'info_siup' => $request->info_siup,
            'slik_debitur' => $request->slik_debitur,
            'slik_pasangan' => $request->slik_pasangan,
            'slik_badan_usaha' => $request->slik_badan_usaha,
            'fa_kredit' => $request->fa_kredit,
            'kk_analis' => $request->kk_analis,
            'muk' => $request->muk,
            'analisa_lr' => $request->analisa_lr,
            'persetujuan_muk' => $request->persetujuan_muk,
            'info_deviasi' => $request->info_deviasi,
            'permohonan_add_deb' => $request->permohonan_add_deb,
            'info_add' => $request->info_add,
            'slip_gaji' => $request->slip_gaji,
            'rek_tabungan' => $request->rek_tabungan,
            'nota_penjualan_pembelian' => $request->nota_penjualan_pembelian,
            'foto_usaha' => $request->foto_usaha,
            'denah_lokasi_usaha' => $request->denah_lokasi_usaha,
            'surat_keterangan' => $request->surat_keterangan,
            'rab' => $request->rab,
            'spk_mou' => $request->spk_mou,
            'mutasi_to' => $request->mutasi_to,
            'bukti_pelunasan' => $request->bukti_pelunasan,
            'lp_jaminan' => $request->lp_jaminan,
            'app_independen' => $request->app_independen,
            'foto_jaminan' => $request->foto_jaminan,
            'dl_jaminan' => $request->dl_jaminan,
            'gn_rangka' => $request->gn_rangka,
            'gn_mesin' => $request->gn_mesin,
            'fc_stnk' => $request->fc_stnk,
            'pbb_dll' => $request->pbb_dll,
            'imb' => $request->imb,
            'kwitansi_pencairan' => $request->kwitansi_pencairan,
            'pk' => $request->pk,
            'perjanjian_fidusia' => $request->perjanjian_fidusia,
            'pk_notaril' => $request->pk_notaril,
            'sk_pendebetan' => $request->sk_pendebetan,
            'sk_menjual' => $request->sk_menjual,
            'pt_asuransi' => $request->pt_asuransi,
            'ba_serah_terima' => $request->ba_serah_terima,
            'spk_barang' => $request->spk_barang,
            'sim_pekarangan' => $request->sim_pekarangan,
            'skmht' => $request->skmht,
            'sht' => $request->sht,
            'sertif_fidusia' => $request->sertif_fidusia,
            'foto_akad' => $request->foto_akad,
            'sertif_asli' => $request->sertif_asli,
            'bpkb_asli' => $request->bpkb_asli,
            'covernote_notaris' => $request->covernote_notaris,
            'faktur_kendaraan' => $request->faktur_kendaraan,
            'ksn_bpkb' => $request->ksn_bpkb,
            'catatan' => $request->catatan,
        ]);

        // log Act
        $aksi = "(u) Update Data Kertas Kerja Atas Nama: " . $kkpk->debitur->nama_nasabah;
        $this->logAct($aksi);

        return redirect()->back()->with('AlertSuccess', 'Data Berhasil Di Update!');
    }


    public function destroy(Kkpk $kkpk)
    {
        $this->authorize('Batasan', $kkpk);
        // log Act
        $aksi = "(-) Hapus Data Kertas Kerja Atas Nama: " . $kkpk->debitur->nama_nasabah;
        $this->logAct($aksi);

        $kkpk->delete();
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
