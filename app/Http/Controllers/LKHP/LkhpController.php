<?php

namespace App\Http\Controllers\LKHP;

use App\Http\Controllers\Controller;
use App\Models\Debitur\Debitur;
use App\Models\KKPK\Kkpk;
use App\Models\LKHP\Lkhp;
use App\Models\LKHP\Pivot;
use App\Models\LKHP\PivotImg;
use App\Models\LogActivity;
use App\Models\RiskEvent\RiskEvent;
use Carbon\Carbon;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class LkhpController extends Controller
{
    public function index(Request $request)
    {
        $awal = Carbon::parse($request->min)->startOfDay();
        $akhir = Carbon::parse($request->max)->endOfDay();
        $username = auth()->user()->nama;
        $level = auth()->user()->level;
        $id_cabang = auth()->user()->id_cabang;
        $reqCabang = $request->id_cabang;
        $reqObjek = $request->objek_pemeriksaan;

        if (request()->ajax()) {
            if ($level == 'MEDIUM USER') {
                if (!empty($request->min)) {
                    if ($reqObjek == 'All') {
                        $data = Lkhp::whereBetween('created_at', [$awal, $akhir])
                            ->where('id_cabang', $id_cabang)
                            ->orderBy('created_at', 'desc')->get();
                    } else {
                        $data = Lkhp::whereBetween('created_at', [$awal, $akhir])
                            ->where('id_cabang', $id_cabang)
                            ->where('objek_pemeriksaan', $reqObjek)
                            ->orderBy('created_at', 'desc')->get();
                    }
                } else {
                    $data = Lkhp::orderBy('created_at', 'desc')
                        ->where('id_cabang', $id_cabang)->get();
                }
            } else {
                if (auth()->user()->sub_jabatan == 'Kabid Audit Internal') {
                    if (!empty($request->min)) {
                        if ($reqObjek == 'All') {
                            if ($reqCabang == 99) {
                                $data = Lkhp::whereBetween('created_at', [$awal, $akhir])
                                    ->orderBy('created_at', 'desc')->get();
                            } else {
                                $data = Lkhp::whereBetween('created_at', [$awal, $akhir])
                                    ->where('id_cabang', $reqCabang)
                                    ->orderBy('created_at', 'desc')->get();
                            }
                        } else {
                            if ($reqCabang == 99) {
                                $data = Lkhp::whereBetween('created_at', [$awal, $akhir])
                                    ->where('objek_pemeriksaan', $reqObjek)
                                    ->orderBy('created_at', 'desc')->get();
                            } else {
                                $data = Lkhp::whereBetween('created_at', [$awal, $akhir])
                                    ->where('objek_pemeriksaan', $reqObjek)
                                    ->where('id_cabang', $reqCabang)
                                    ->orderBy('created_at', 'desc')->get();
                            }
                        }
                    } else {
                        $data = Lkhp::orderBy('created_at', 'desc')->get();
                    }
                } else {
                    if (!empty($request->min)) {
                        if ($reqCabang == 99) {
                            $data = Lkhp::where('nama_creator', $username)->whereBetween('created_at', [$awal, $akhir])
                                ->orderBy('created_at', 'desc')->get();
                        } else {
                            $data = Lkhp::where('nama_creator', $username)->whereBetween('created_at', [$awal, $akhir])
                                ->where('id_cabang', $reqCabang)
                                ->orderBy('created_at', 'desc')->get();
                        }
                    } else {
                        $data = Lkhp::where('nama_creator', $username)->orderBy('created_at', 'desc')->get();
                    }
                }
            }

            return DataTables()->of($data)
                ->addColumn('cabang', function ($data) {
                    return $data->cabang->cabang;
                })
                ->addColumn('action', function ($data) {
                    // Operasional
                    if ($data->objek_pemeriksaan == 'Operasional') {
                        $button = '<a href="/lkhp-ops/' . encrypt($data->id_lkhp) . '/show"
                                            class="btn btn-info btn-sm detail_data">
                                            <span class="icon text-white-50">
                                            <i class="fa fa-eye"></i>
                                            </span>
                                        </a>';
                        $button .= '&nbsp;';
                        // Cek apakah user memiliki hak akses untuk mengedit atau menghapus
                        if (auth()->user()->sub_jabatan == 'Kabid Audit Internal' || auth()->user()->nama == $data->nama_creator) {
                            // cek apakah kkpk udah ditambahkan ke LKHP atau belum if yes maka button off
                            if ($data->status == null) {
                                // Tombol edit
                                $button .= '<a href="/data-lkhp-ops/' . encrypt($data->id_lkhp)  . '/edit" 
                                                class="btn btn-warning btn-sm edit">
                                                <i class="fa fa-edit"></i></a>';
                                $button .= '&nbsp;';
                                // Tombol hapus
                                $button .= '<a data-toggle="modal" id="' . $data->id_lkhp  . '"
                                                class="hapus btn btn-danger btn-sm delete-post ">
                                                <i class="fa fa-trash"></i></a>';
                            } else {
                                // Jika tidak memenuhi kondisi, tambahkan kelas disabled pada tombol
                                $button .= '<a class="btn btn-warning btn-sm edit disabled"><i class="fa fa-edit"></i></a>';
                                $button .= '&nbsp;';
                                $button .= '<a class="delete btn btn-danger btn-sm delete-post disabled"><i class="fa fa-trash"></i></a>';
                            }
                        } else {
                            // Jika tidak memenuhi kondisi, tambahkan kelas disabled pada tombol
                            $button .= '<a class="btn btn-warning btn-sm edit disabled"><i class="fa fa-edit"></i></a>';
                            $button .= '&nbsp;';
                            $button .= '<a class="delete btn btn-danger btn-sm delete-post disabled"><i class="fa fa-trash"></i></a>';
                        }
                    }
                    // Kredit 
                    else {
                        $button = '<a href="/data-lkhp/' . encrypt($data->id_lkhp) . '"
                                            class="btn btn-info btn-sm detail_data">
                                            <span class="icon text-white-50">
                                            <i class="fa fa-eye"></i>
                                            </span>
                                        </a>';
                        $button .= '&nbsp;';
                        // Cek apakah user memiliki hak akses untuk mengedit atau menghapus
                        if (auth()->user()->sub_jabatan == 'Kabid Audit Internal' || auth()->user()->nama == $data->nama_creator) {
                            // cek apakah kkpk udah ditambahkan ke LKHP atau belum if yes maka button off
                            if ($data->status == null) {
                                // Tombol edit
                                $button .= '<a href="/data-lkhp/' . encrypt($data->id_lkhp)  . '/edit" 
                                                class="btn btn-warning btn-sm edit">
                                                <i class="fa fa-edit"></i></a>';
                                $button .= '&nbsp;';
                                // Tombol hapus
                                $button .= '<a data-toggle="modal" id="' . $data->id_lkhp  . '"
                                                class="hapus btn btn-danger btn-sm delete-post ">
                                                <i class="fa fa-trash"></i></a>';
                            } else {
                                // Jika tidak memenuhi kondisi, tambahkan kelas disabled pada tombol
                                $button .= '<a class="btn btn-warning btn-sm edit disabled"><i class="fa fa-edit"></i></a>';
                                $button .= '&nbsp;';
                                $button .= '<a class="delete btn btn-danger btn-sm delete-post disabled"><i class="fa fa-trash"></i></a>';
                            }
                        } else {
                            // Jika tidak memenuhi kondisi, tambahkan kelas disabled pada tombol
                            $button .= '<a class="btn btn-warning btn-sm edit disabled"><i class="fa fa-edit"></i></a>';
                            $button .= '&nbsp;';
                            $button .= '<a class="delete btn btn-danger btn-sm delete-post disabled"><i class="fa fa-trash"></i></a>';
                        }
                    }
                    return $button;
                })

                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('Page.Lkhp.index', ['title' => 'Lembar Konfirmasi (LKHP)']);
    }


    public function getKKPK($Id)
    {
        $data = Kkpk::where('id_cabang', $Id)->where('nama_pemeriksa', auth()->user()->nama)->get();
        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function create()
    {
        $riskEvent = RiskEvent::OrderBy('kode_finding', 'ASC')->get();
        return view('Page.Lkhp.Kredit.create', compact('riskEvent'), ['title' => 'Tambah Data LKHP - Kredit']);
    }


    public function getDetailKKPK($Id)
    {
        $kkpk = Kkpk::where('id_kkpk', $Id)->first();
        $debitur = Debitur::where('id_debitur', $kkpk->id_debitur)->first();
        $catatan = $kkpk->keterangan->catatan;

        return response()->json([
            'status' => 200,
            'catatan' => $catatan,
            'data' => $debitur
        ]);
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
                    $idKkpk = $request->input('id_kkpk_' . $re . '_' . $pi_kkpk);
                    $keteranganFinal = $request->input('keterangan_re_' . $re . '_' . $pi_kkpk);

                    if ($idKkpk) {
                        # code...
                        KKpk::where('id_kkpk', $idKkpk)->update([
                            'status' => 'Created LKHP'
                        ]);

                        $piv_kkpk = Pivot::create([
                            'id_lkhp' => $lkhp->id_lkhp,
                            'id_event_risk' => $request->input('id_event_risk_' . $re),
                            'id_kkpk' => $idKkpk,
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
                            $pivotImg->id_pivot = $piv_kkpk->id_pivot;
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

        return view('Page.Lkhp.Kredit.show', compact('lkhp'), ['title' => 'Show ' . $lkhp->no_lkhp_bayangan]);
    }


    // show detail
    public function showDetail($Id)
    {
        $ids = Crypt::decrypt($Id); //decript link
        $lkhp = Lkhp::with(['pivot.kkpk.debitur', 'pivot.pivotImg'])
            ->where('id_lkhp', $ids)
            ->first();

        // Grouping pivots by id_event_risk
        $groupedPivots = $lkhp->pivot->groupBy('id_event_risk');

        // untuk akses folder gambar
        $replace = str_replace('/', '_', $lkhp->no_lkhp_bayangan);
        $folderName = 'gambar/Gambar Pendukung LK - ' . $replace;

        return view('Page.Lkhp.Kredit.show-detail', compact('lkhp', 'folderName', 'groupedPivots'), ['title' => 'Edit ' . $lkhp->no_lkhp_bayangan]);
    }


    public function edit($lkhp)
    {
        $ids = Crypt::decrypt($lkhp); //decript link
        $pivot = Pivot::with('kkpk.debitur')->where('id_lkhp', $ids)->groupBy('id_kkpk')->get();
        $pivotAll = Pivot::where('id_lkhp', $ids)->get();
        $data = Lkhp::where('id_lkhp', $ids)->first();
        $riskEvent = RiskEvent::orderBy('kode_finding', 'ASC')->get();
        $kkpk = Kkpk::orderBy('created_at', 'ASC')->get();

        return view('Page.Lkhp.Kredit.edit', compact('pivot', 'pivotAll', 'riskEvent', 'data', 'kkpk'), ['title' => 'Edit ' . $data->no_lkhp_bayangan]);
    }

    public function update(Request $request, Lkhp $lkhp)
    {
        $lkhp->update([
            'id_cabang' => $request->id_cabang,
            'tgl_awal' => Carbon::createFromFormat('d-m-Y', $request->tgl_awal)->format('Y-m-d'),
            'tgl_akhir' => Carbon::createFromFormat('d-m-Y', $request->tgl_akhir)->format('Y-m-d'),
            'desc_uraian_permasalahan_fakta' => $request->desc_uraian_permasalahan_fakta,
            'desc_keadaan_seharusnya' => $request->desc_keadaan_seharusnya,
            'penyebab_terjadi_penyimpangan' => $request->penyebab_terjadi_penyimpangan,
            'dampak_resiko' => $request->dampak_resiko,
            'tindak_lanjut' => $request->tindak_lanjut
        ]);

        // log Act
        $aksi = "(u) Update Data LKHP Nomor: " . $lkhp->no_lkhp_bayangan;
        $this->logAct($aksi);

        return redirect('data-lkhp')->with('AlertSuccess', 'Data Berhasil Disimpan!');
    }


    public function destroy(Lkhp $lkhp)
    {
        // log Act
        $aksi = "(-) Hapus Data LKHP Nomor: " . $lkhp->no_lkhp_bayangan;
        $this->logAct($aksi);

        $lkhp->delete();
    }


    // Create Data KKPK ke Pivot
    public function CreateLKHP($Id)
    {
        $ids = Crypt::decrypt($Id); //decript link
        $lkhp = Lkhp::where('id_lkhp', $ids)->first();
        $pivot = Pivot::where('id_lkhp', $lkhp->id_lkhp)->first();

        return view('Page.Lkhp.Kredit.edit.create-kkpk', compact('lkhp', 'pivot'), [
            'title' => 'Tambah KKPK ' . $lkhp->no_lkhp_bayangan
        ]);
    }

    // store data KKPK ke Pivot
    public function storeLkhp(Request $request, $Id)
    {
        $lkhp = Lkhp::where('id_lkhp', $Id)->first();
        // impact
        for ($i = 1; $i < 100; $i++) {
            // Periksa apakah input id_kkpk ada dan tidak kosong
            $idEventRisk = $request->input('id_event_risk');

            if ($idEventRisk) {
                // Iterasi melalui kemungkinan nilai id_event_risk
                for ($a = 1; $a < 10; $a++) {
                    $idKkpk = $request->input('id_kkpk_' . $i . '_' . $a);
                    $keteranganFinal = $request->input('keterangan_re_' . $i . '_' . $a);

                    if ($keteranganFinal) {
                        // Buat instance baru dari Pivot dan simpan
                        $pivot = new Pivot();
                        $pivot->id_lkhp = $Id;
                        $pivot->id_kkpk = $idKkpk;
                        $pivot->id_event_risk = $idEventRisk;
                        $pivot->keterangan_re = $this->SummernoteImg($keteranganFinal);
                        $pivot->save();
                    }

                    for ($img = 1; $img < 10; $img++) {
                        $image = $request->file('img_re_' . $i . '_' . $a . '_' . $img);
                        $CaptionImg = $request->input('caption_re_'  . $i . '_' . $a . '_' . $img);
                        if ($image != null) {
                            // config gambar
                            $gambar = $request->file('img_re_' . $i . '_' . $a . '_' . $img);
                            $fileName = $gambar->getClientOriginalName();
                            // Ganti karakter '/' dengan '_'
                            $folderName = str_replace('/', '_', $lkhp->no_lkhp_bayangan);
                            $gambar->move('gambar/Gambar Pendukung LK - ' . $folderName, $fileName);

                            $pivotImg = new PivotImg();
                            $pivotImg->id_pivot = $pivot->id_pivot;
                            $pivotImg->img = $fileName;
                            $pivotImg->caption = $CaptionImg;
                            $pivotImg->save();
                        }
                    }
                }
            }
        };


        // log Act
        $aksi = "(+) Tambah KKPK for LKHP No.: " . $lkhp->no_lkhp_bayangan;
        $this->logAct($aksi);
        $EncIdLkhp = Crypt::encrypt($lkhp->id_lkhp);


        return redirect('data-lkhp/' . $EncIdLkhp . '/edit')->with('AlertSuccess', 'Data Berhasil Disimpan!');
    }


    // Edit data RE ke Pivot
    public function EditLkhp($Id)
    {
        $ids = Crypt::decrypt($Id); //decript link
        $pivot = Pivot::with('kkpk.debitur')->where('id_kkpk', $ids)->first();
        $pivot_re = Pivot::where('id_kkpk', $ids)->get();
        $riskEvent = RiskEvent::orderBy('kode_finding', 'ASC')->get();

        // folders old images
        $kode_lkhp = str_replace('/', '_', $pivot->lkhp->no_lkhp_bayangan);
        $folderName = 'gambar/Gambar Pendukung LK - ' . $kode_lkhp;

        return view('Page.Lkhp.Kredit.edit.edit-create', compact('pivot', 'pivot_re', 'riskEvent', 'folderName'), [
            'title' => 'Edit KKPK ' . $pivot->kkpk->kode_kkpk
        ]);
    }


    // update data RE ke Pivot
    public function updateLkhp(Request $request, $Id)
    {
        $pivot_tunggal = Pivot::where('id_kkpk', $Id)->first();
        $pivot = Pivot::where('id_kkpk', $Id)->get();

        // Update Pivot untuk Risk Event dan Image
        foreach ($pivot as $item) {
            for ($aksi_re = 1; $aksi_re <= 50; $aksi_re++) {
                // Ambil nilai dari request
                $keterangan_re = $request->input('keterangan_re_old_' . $aksi_re);

                // Debugging untuk memastikan nilai tidak null
                Log::info('Keterangan RE: ' . $keterangan_re);

                // Pastikan nilai tidak null sebelum update
                if (!is_null($keterangan_re)) {
                    // Update Pivot untuk Keterangan dan RE
                    $item->update([
                        'keterangan_re' => $keterangan_re
                    ]);
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
                            $folderName = str_replace('/', '_', $pivot_tunggal->lkhp->no_lkhp_bayangan);
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

            # kondisi save new untuk Image
            for ($counter_img = 1; $counter_img < 10; $counter_img++) {
                # kondisi update img
                $image = $request->file('img_re_' . $counter_re . '_' . $counter_img);
                if ($image) {
                    // config gambar
                    $gambar = $image;
                    $fileName = $gambar->getClientOriginalName();
                    // Ganti karakter '/' dengan '_'
                    $folderName = str_replace('/', '_', $pivot_tunggal->lkhp->no_lkhp_bayangan);
                    $gambar->move('gambar/Gambar Pendukung LK - ' . $folderName, $fileName);

                    $pivotimg = new PivotImg();
                    $pivotimg->insert([
                        'id_pivot' => $pivot_tunggal->id_pivot,
                        'img' => $fileName,
                        'caption' => $request->input('caption_re_' . $counter_re . '_' . $counter_img),
                    ]);
                }
            }
        }

        // log Act
        $aksi = "(u) Update RE untuk LKHP Nomor: " . $pivot_tunggal->lkhp->no_lkhp_bayangan;
        $this->logAct($aksi);

        $EncIdLkhp = Crypt::encrypt($pivot_tunggal->id_lkhp);

        return redirect('data-lkhp/' . $EncIdLkhp . '/edit')->with('AlertSuccess', 'Data Berhasil Disimpan!');
    }

    // Hapus data RE ke Pivot
    public function HapusLkhp(Request $request, $Id, $lkhp)
    {
        $pivot = Pivot::where('id_kkpk', $Id)->where('id_lkhp', $lkhp)->first();
        // log Act
        $aksi = "(-) Hapus Data KKPK dari LKHP Nomor: " . $pivot->lkhp->no_lkhp_bayangan;
        $this->logAct($aksi);

        $pivot->delete();
    }



    // fungsi handle summernote img
    private function SummernoteImg($html)
    {
        if (empty($html)) {
            return $html;
        }
        $dom = new DOMDocument();
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');
        foreach ($images as $key => $img) {
            $src = $img->getAttribute('src');
            if (strpos($src, 'base64,') !== false) {
                list($type, $data) = explode(';', $src);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);

                $image_name = '/upload/img/' . time() . $key . '.png';
                // file_put_contents(public_path() . $image_name, $data);
                file_put_contents(public_path('upload/img/' . time() . $key . '.png'), $data);

                $img->removeAttribute('src');
                $img->setAttribute('src', $image_name);
            }
        }

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
