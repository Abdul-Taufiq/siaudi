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
use HTMLtoOpenXML\Parser;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;
use View;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\{Mail, Crypt, Response};

class LkhpFinalController extends Controller
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
                        $data = LkhpFinal::whereBetween('created_at', [$awal, $akhir])
                            ->where('id_cabang', $id_cabang)
                            ->whereNotNull('status_ia')
                            ->orderBy('created_at', 'desc')->get();
                    } else {
                        $data = LkhpFinal::whereBetween('created_at', [$awal, $akhir])
                            ->where('id_cabang', $id_cabang)
                            ->whereNotNull('status_ia')
                            ->where('objek_pemeriksaan', $reqObjek)
                            ->orderBy('created_at', 'desc')->get();
                    }
                } else {
                    $data = LkhpFinal::orderBy('created_at', 'desc')
                        ->where('id_cabang', $id_cabang)
                        ->whereNotNull('status_ia')->get();
                }
            } else {
                if (auth()->user()->sub_jabatan == 'Kabid Audit Internal') {
                    if (!empty($request->min)) {
                        if ($reqObjek == 'All') {
                            if ($reqCabang == 99) {
                                $data = LkhpFinal::whereBetween('created_at', [$awal, $akhir])
                                    ->orderBy('created_at', 'desc')->get();
                            } else {
                                $data = LkhpFinal::whereBetween('created_at', [$awal, $akhir])
                                    ->where('id_cabang', $reqCabang)
                                    ->orderBy('created_at', 'desc')->get();
                            }
                        } else {
                            if ($reqCabang == 99) {
                                $data = LkhpFinal::whereBetween('created_at', [$awal, $akhir])
                                    ->where('objek_pemeriksaan', $reqObjek)
                                    ->orderBy('created_at', 'desc')->get();
                            } else {
                                $data = LkhpFinal::whereBetween('created_at', [$awal, $akhir])
                                    ->where('objek_pemeriksaan', $reqObjek)
                                    ->where('id_cabang', $reqCabang)
                                    ->orderBy('created_at', 'desc')->get();
                            }
                        }
                    } else {
                        $data = LkhpFinal::orderBy('created_at', 'desc')->get();
                    }
                } else {
                    if (!empty($request->min)) {
                        if ($reqCabang == 99) {
                            $data = LkhpFinal::where('nama_creator', $username)->whereBetween('created_at', [$awal, $akhir])
                                ->orderBy('created_at', 'desc')->get();
                        } else {
                            $data = LkhpFinal::where('nama_creator', $username)->whereBetween('created_at', [$awal, $akhir])
                                ->where('id_cabang', $reqCabang)
                                ->orderBy('created_at', 'desc')->get();
                        }
                    } else {
                        $data = LkhpFinal::where('nama_creator', $username)->orderBy('created_at', 'desc')->get();
                    }
                }
            }

            return DataTables()->of($data)
                ->addColumn('cabang', function ($data) {
                    return $data->cabang->cabang;
                })
                ->addColumn('status', function ($data) {
                    $statusDropdown = $this->statusNothing($data); //menyimpan ke variable dari status private ke table sini

                    $status = '';
                    switch (auth()->user()->sub_jabatan) {
                        case 'Kasi Operasional':
                        case 'Kasi Komersial':
                            $jabatan = $data->status_kasi;
                            $statusAfter = $this->statusAfter($data, $jabatan, $statusDropdown);
                            return $statusAfter;
                            break;
                        case 'Pimpinan Cabang':
                            $jabatan = $data->status_pincab;
                            $statusAfter = $this->statusAfter($data, $jabatan, $statusDropdown);
                            return $statusAfter;
                            break;

                        case 'Kabid Audit Internal':
                            $jabatan = $data->status_ia;
                            $statusAfter = $this->statusAfter($data, $jabatan, $statusDropdown);
                            return $statusAfter;
                            break;

                        default:
                            $status .= '<a class="btn btn-info btn-sm disabled">NotAct</a>';
                            break;
                    }

                    return $status;
                })
                ->addColumn('action', function ($data) {
                    // Operasional
                    if ($data->objek_pemeriksaan == 'Operasional') {
                        $button = '<a href="/lkhp-final-ops/' . encrypt($data->id_lkhp_final) . '/show"
                                            class="btn btn-info btn-sm detail_data">
                                            <span class="icon text-white-50">
                                            <i class="fa fa-eye"></i>
                                            </span>
                                        </a>';
                        $button .= '&nbsp;';
                        // Cek apakah user memiliki hak akses untuk mengedit atau menghapus
                        if (auth()->user()->sub_jabatan == 'Kabid Audit Internal') {
                            // Tombol edit
                            $button .= '<a href="/lkhp-final/' . encrypt($data->id_lkhp_final)  . '/edit" 
                                                class="btn btn-warning btn-sm edit">
                                                <i class="fa fa-edit"></i></a>';
                            $button .= '&nbsp;';
                            // Tombol hapus
                            $button .= '<a data-toggle="modal" id="' . $data->id_lkhp_final  . '"
                                        class="hapus btn btn-danger btn-sm delete-post ">
                                        <i class="fa fa-trash"></i></a>';
                        } else {
                            // Jika tidak memenuhi kondisi, tambahkan kelas disabled pada tombol
                            $button .= '<a class="btn btn-warning btn-sm edit disabled"><i class="fa fa-edit"></i></a>';
                            $button .= '&nbsp;';
                            $button .= '<a class="delete btn btn-danger btn-sm delete-post disabled"><i class="fa fa-trash"></i></a>';
                        }
                    }
                    // Kredit
                    else {
                        $button = '<a href="/lkhp-final/' . encrypt($data->id_lkhp_final) . '"
                                            class="btn btn-info btn-sm detail_data">
                                            <span class="icon text-white-50">
                                            <i class="fa fa-eye"></i>
                                            </span>
                                        </a>';
                        $button .= '&nbsp;';
                        // Cek apakah user memiliki hak akses untuk mengedit atau menghapus
                        if (auth()->user()->sub_jabatan == 'Kabid Audit Internal') {
                            // Tombol edit
                            $button .= '<a href="/lkhp-final/' . encrypt($data->id_lkhp_final)  . '/edit" 
                                                class="btn btn-warning btn-sm edit">
                                                <i class="fa fa-edit"></i></a>';
                            $button .= '&nbsp;';
                            // Tombol hapus
                            $button .= '<a data-toggle="modal" id="' . $data->id_lkhp_final  . '"
                                                class="hapus btn btn-danger btn-sm delete-post ">
                                                <i class="fa fa-trash"></i></a>';
                        } else {
                            // Jika tidak memenuhi kondisi, tambahkan kelas disabled pada tombol
                            $button .= '<a class="btn btn-warning btn-sm edit disabled"><i class="fa fa-edit"></i></a>';
                            $button .= '&nbsp;';
                            $button .= '<a class="delete btn btn-danger btn-sm delete-post disabled"><i class="fa fa-trash"></i></a>';
                        }
                    }
                    return $button;
                })

                ->rawColumns(['action', 'status'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('Page.Lkhp_Final.index', ['title' => 'LKHP (Final)']);
    }


    public function create()
    {
        $lkhp_bayangan = Lkhp::with('cabang')->orderBy('created_at', 'DESC')->get();
        return view('Page.Lkhp_Final.create', compact('lkhp_bayangan'), ['title' => 'Add LKHP (Final)']);
    }


    public function getLkhp(Request $request)
    {
        $awal = Carbon::parse($request->tgl_awal)->startOfDay()->format('Y-m-d');
        $akhir = Carbon::parse($request->tgl_akhir)->endOfDay()->format('Y-m-d');
        $cabang = $request->id_cabang;
        $objek = $request->objek_pemeriksaan;

        $data = Lkhp::where('id_cabang', $cabang)
            ->where('tgl_awal', $awal)
            ->where('tgl_akhir', $akhir)
            ->where('objek_pemeriksaan', $objek)
            ->whereHas('pivot', function ($query) {
                $query->whereNull('id_lkhp_final');
            })
            ->with(['pivot.riskEvent', 'pivot.kkpk.debitur'])
            ->get();


        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }


    public function store(Request $request)
    {
        // convert u/ summernote
        $desc_uraian = $this->SummernoteImg($request->desc_uraian_permasalahan_fakta);
        // $desc_keadaan = $this->SummernoteImg($request->desc_keadaan_seharusnya);
        $penyebab_penyimpangan = $this->SummernoteImg($request->penyebab_terjadi_penyimpangan);
        $dampak_resiko = $this->SummernoteImg($request->dampak_resiko);
        $tindak_lanjut = $this->SummernoteImg($request->tindak_lanjut);

        // lkhp final
        $final  = LkhpFinal::create([
            'id_cabang' => $request->id_cabang,
            'no_lkhp' => $request->no_lkhp,
            'tgl_awal' => $request->tgl_awal,
            'tgl_akhir' => $request->tgl_akhir,
            'objek_pemeriksaan' => $request->objek_pemeriksaan,
            'ttd_pemeriksa' => $request->ttd_pemeriksa,
            'desc_uraian_permasalahan_fakta' => $desc_uraian,
            // 'desc_keadaan_seharusnya' => $desc_keadaan,
            'penyebab_terjadi_penyimpangan' => $penyebab_penyimpangan,
            'dampak_resiko' => $dampak_resiko,
            'tindak_lanjut' => $tindak_lanjut,
            'nama_creator' => auth()->user()->nama,
        ]);

        for ($i = 1; $i <= 100; $i++) {
            $lkhp = $request->input('id_lkhp_' . $i);

            if ($lkhp) {
                Lkhp::where('id_lkhp', $lkhp)->update([
                    'status' => 'Created LKHP Final'
                ]);
                # code...
                Pivot::where('id_lkhp', $lkhp)
                    ->update([
                        'id_lkhp_final' => $final->id_lkhp_final
                    ]);
            }
        }


        $aksi = "(+) Tambah LKHP Final Nomor: " . $final->no_lkhp;
        $this->logAct($aksi);

        return redirect()->route('lkhp-final.index')->with('AlertSuccess', 'Data LKHP Final berhasil disimpan!');
    }


    public function show($lkhpFinal)
    {
        $ids = Crypt::decrypt($lkhpFinal);
        $lkhp = LkhpFinal::where('id_lkhp_final', $ids)->first();

        return view('Page.Lkhp_Final.show', compact('lkhp'), [
            'title' => 'Show Lkhp Final Nomor ' . $lkhp->no_lkhp
        ]);
    }


    public function showDetail($Id)
    {
        $ids = Crypt::decrypt($Id);
        $lkhp_final = LkhpFinal::with(['pivot.kkpk.debitur', 'pivot.pivotImg'])
            ->where('id_lkhp_final', $ids)
            ->first();

        // Grouping pivots by id_event_risk
        $groupedPivots = $lkhp_final->pivot->groupBy('id_event_risk');

        return view('Page.Lkhp_Final.show-detail', compact('lkhp_final', 'groupedPivots'));
    }


    // Ops
    public function showOPS($Id)
    {
        $ids = Crypt::decrypt($Id);
        $lkhp = LkhpFinal::where('id_lkhp_final', $ids)->first();

        return view('Page.Lkhp_Final.show-ops', compact('lkhp'), [
            'title' => 'Show Lkhp Final Nomor ' . $lkhp->no_lkhp
        ]);
    }



    public function showDetailOPS($Id)
    {
        $ids = Crypt::decrypt($Id);
        $lkhp_final = LkhpFinal::with(['pivot.pivotImg'])
            ->where('id_lkhp_final', $ids)
            ->first();

        // Grouping pivots by id_event_risk
        $groupedPivots = $lkhp_final->pivot->groupBy('id_event_risk');
        // untuk akses folder gambar
        $replace = str_replace('/', '_', $lkhp_final->no_lkhp_bayangan);
        $folderName = 'gambar/Gambar Pendukung LK - ' . $replace;

        return view('Page.Lkhp_Final.show-detail-ops', compact('lkhp_final', 'groupedPivots'));
    }


    public function edit($lkhpFinal)
    {
        $ids = Crypt::decrypt($lkhpFinal);
        $data = LkhpFinal::where('id_lkhp_final', $ids)->first();
        $pivot = Pivot::with(['lkhpFinal', 'riskEvent'])
            ->where('id_lkhp_final', $ids)->get();

        return view('Page.Lkhp_Final.edit', compact('data', 'pivot'), ['title' => 'Edit LKHP (Final)']);
    }


    public function update(Request $request, LkhpFinal $lkhpFinal)
    {
        // convert u/ summernote
        $desc_uraian = $this->SummernoteImg($request->desc_uraian_permasalahan_fakta);
        // $desc_keadaan = $this->SummernoteImg($request->desc_keadaan_seharusnya);
        $penyebab_penyimpangan = $this->SummernoteImg($request->penyebab_terjadi_penyimpangan);
        $dampak_resiko = $this->SummernoteImg($request->dampak_resiko);
        $tindak_lanjut = $this->SummernoteImg($request->tindak_lanjut);

        $lkhpFinal->id_cabang = $request->id_cabang;
        $lkhpFinal->no_lkhp = $request->no_lkhp;
        $lkhpFinal->tgl_awal = $request->tgl_awal;
        $lkhpFinal->tgl_akhir = $request->tgl_akhir;
        $lkhpFinal->objek_pemeriksaan = $request->objek_pemeriksaan;
        $lkhpFinal->ttd_pemeriksa = $request->ttd_pemeriksa;
        $lkhpFinal->desc_uraian_permasalahan_fakta = $desc_uraian;
        // $lkhpFinal->desc_keadaan_seharusnya = $desc_keadaan;
        $lkhpFinal->penyebab_terjadi_penyimpangan = $penyebab_penyimpangan;
        $lkhpFinal->dampak_resiko = $dampak_resiko;
        $lkhpFinal->tindak_lanjut = $tindak_lanjut;
        $lkhpFinal->save();

        for ($i = 1; $i <= 100; $i++) {
            $pivot = Pivot::where('id_pivot', $request->input('id_pivot_' . $i))->first();

            if ($pivot) { // Check if $pivot is not null
                if ($request->input('aksi_pivot_' . $i) == 'Edit') {
                    $pivot->update([
                        'id_lkhp_final' => $lkhpFinal->id_lkhp_final
                    ]);
                } else {
                    $pivot->update([
                        'id_lkhp_final' => null
                    ]);
                }
            }

            $lkhp = $request->input('id_lkhp_' . $i);
            if ($lkhp) {
                # code...
                Pivot::where('id_lkhp', $lkhp)
                    ->update([
                        'id_lkhp_final' => $lkhpFinal->id_lkhp_final
                    ]);
            }
        }


        $aksi = "(u) Update LKHP Final Nomor: " . $lkhpFinal->no_lkhp;
        $this->logAct($aksi);

        return redirect()->route('lkhp-final.index')->with('AlertSuccess', 'Data LKHP Final berhasil diubah');
    }


    public function destroy(LkhpFinal $lkhpFinal)
    {
        $pivot = Pivot::where('id_lkhp_final', $lkhpFinal->id_lkhp_final)->get();
        foreach ($pivot as $p) {
            $p->lkhp->update([
                'status' => null,
            ]);
        }

        // log Act
        $aksi = "(-) Hapus Data LKHP Final Nomor: " . $lkhpFinal->no_lkhp;
        $this->logAct($aksi);

        $lkhpFinal->delete();
    }


    // status
    public function StatusLkhp($Id)
    {
        $ids = Crypt::decrypt($Id);
        $data = LkhpFinal::where('id_lkhp_final', $ids)->first();
        $jabatan = auth()->user()->sub_jabatan;
        $nama = auth()->user()->nama;

        switch ($jabatan) {
            case 'Kasi Operasional':
            case 'Kasi Komersial':
                $data->update([
                    'status_kasi' => $nama . ' - Sended ke Pimpinan Cabang pada tanggal ' . now()->translatedFormat('d F Y, H:i'),
                ]);

                $userPenerima = User::where('id_cabang', $data->id_cabang)
                    ->where('status', 'Aktif')
                    ->where('jabatan', 'Pimpinan Cabang')
                    ->first();

                $url = route('lkhp-final.index');
                $title = 'Lembar Konfirmasi Hasil Pemeriksaan (LKHP) Memerlukan Approve!';
                $pesan = 'Terdapat Lembar Konfirmasi Hasil Pemeriksaan (LKHP) dari Audit Internal Untuk segera diberikan Approve!';
                if ($jabatan == 'Kasi Operasional') {
                    $regard = 'Kasi Operasional';
                } else {
                    $regard = 'Kasi Komersial';
                }
                $this->SendEmail($data, $userPenerima, $url, $title, $pesan, $regard);
                break;

            case 'Pimpinan Cabang':
                if ($data->status_kasi == null) {
                    $data->update([
                        'status_kasi' => 'Ditarik Pimpinan Cabang ' . $nama . 'pada tanggal ' . now()->translatedFormat('d F Y, H:i'),
                        'status_pincab' => $nama . ' - Sended ke Audit Internal pada tanggal ' . now()->translatedFormat('d F Y, H:i'),
                    ]);
                } else {
                    $data->update([
                        'status_pincab' => $nama . ' - Sended ke Audit Internal pada tanggal ' . now()->translatedFormat('d F Y, H:i'),
                    ]);
                }

                $userPenerima = User::where('status', 'Aktif')
                    ->where('jabatan', 'Internal Audit')
                    ->get();

                $url = route('lkhp-final.index');
                $title = 'Lembar Konfirmasi Hasil Pemeriksaan (LKHP) Sudah Diberikan Tanggapan!';
                $pesan = 'Lembar Konfirmasi Hasil Pemeriksaan (LKHP) Dengan Data Berikut Sudah Diberikan Tanggapan Oleh Cabang Terkait';
                if ($data->id_cabang == 1) {
                    $regard = 'Kepala Kantor';
                } else {
                    $regard = 'Pimpinan Cabang';
                }

                $this->SendEmailDobel($data, $userPenerima, $url, $title, $pesan, $regard);

                break;
        }


        $aksi = "(+) Ubah Status LKHP Final Nomor: " . $data->no_lkhp;
        $this->logAct($aksi);

        return redirect()->route('lkhp-final.index')->with('AlertSuccess', 'Status LKHP Final berhasil diubah');
    }


    public function StatusLkhpIA($Id, $Tgl)
    {
        $ids = Crypt::decrypt($Id);
        $data = LkhpFinal::where('id_lkhp_final', $ids)->first();
        $nama = auth()->user()->nama;

        $data->update([
            'tgl_pengembalian' => $Tgl,
            'status_ia' => $nama . ' - Sended ke Audit Internal pada tanggal ' . now()
        ]);

        // Send Email Single to Kaops cabang
        if ($data->objek_pemeriksaan == 'Operasional') {
            # code...
            $userPenerima = User::where('id_cabang', $data->id_cabang)
                ->where('status', 'Aktif')
                ->where('jabatan', 'Kasi Operasional')
                ->Orwhere('jabatan', 'Pimpinan Cabang')
                ->get();
        } else {
            # code...
            $userPenerima = User::where('id_cabang', $data->id_cabang)
                ->where('status', 'Aktif')
                ->where('jabatan', 'Kasi Komersial')
                ->Orwhere('jabatan', 'Pimpinan Cabang')
                ->get();
        }

        $url = route('lkhp-final.index');
        $title = 'Lembar Konfirmasi Hasil Pemeriksaan (LKHP) Memerlukan Tanggapan!';
        $pesan = 'Terdapat Lembar Konfirmasi Hasil Pemeriksaan (LKHP) dari Audit Internal Untuk segera diberikan Tanggapan!';
        $regard = 'Bidang Audit Internal';
        $this->SendEmailDobel($data, $userPenerima, $url, $title, $pesan, $regard);

        $aksi = "(+) Ubah Status LKHP Final Nomor: " . $data->no_lkhp;
        $this->logAct($aksi);

        return redirect()->route('lkhp-final.index')->with('AlertSuccess', 'Status LKHP Final berhasil diubah');
    }


    // PRINT
    public function printLkhpAsPDF($id)
    {
        $ids = Crypt::decrypt($id);
        $lkhp_final = LkhpFinal::with(['pivot.pivotImg'])
            ->where('id_lkhp_final', $ids)
            ->first();

        // Grouping pivots by id_event_risk
        $groupedPivots = $lkhp_final->pivot->groupBy('id_event_risk');
        // untuk akses folder gambar
        $replace = str_replace('/', '_', $lkhp_final->no_lkhp_bayangan);
        $folderName = 'gambar/Gambar Pendukung LK - ' . $replace;

        $aksi = "(+) Print As PDF LKHP Final Nomor: " . $lkhp_final->no_lkhp;
        $this->logAct($aksi);

        // return view('Page.Lkhp_Final.show-detail-ops', compact('lkhp_final', 'groupedPivots'));
        if ($lkhp_final->objek_pemeriksaan == 'Kredit') {
            // $pdf = Pdf::loadView('Page.Lkhp_Final.print.print-kredit-pdf', compact('lkhp_final', 'groupedPivots'));
            // $pdf->setPaper('f4', 'portrait');
            // return $pdf->stream('LKHP Final Nomor ' . $lkhp_final->no_lkhp . '.pdf');

            return view('Page.Lkhp_Final.print.print-kredit-pdf', compact('lkhp_final', 'groupedPivots'), [
                'title' => $lkhp_final->no_lkhp
            ]);
        } else {
            // $pdf = Pdf::loadView('Page.Lkhp_Final.print.print-ops-pdf', compact('lkhp_final', 'groupedPivots'));
            // $pdf->setPaper('f4', 'portrait');
            // return $pdf->stream('LKHP Final Nomor ' . $lkhp_final->no_lkhp . '.pdf');

            return view('Page.Lkhp_Final.print.print-ops-pdf', compact('lkhp_final', 'groupedPivots'), [
                'title' => $lkhp_final->no_lkhp
            ]);
        }
    }


    // PRINT
    public function printLkhpAsWord($id)
    {
        $ids = Crypt::decrypt($id);
        $lkhp_final = LkhpFinal::with(['pivot.pivotImg'])
            ->where('id_lkhp_final', $ids)
            ->first();

        $groupedPivots = $lkhp_final->pivot->groupBy('id_event_risk');

        // Log activity
        $aksi = "(+) Print As Word LKHP Final Nomor: " . $lkhp_final->no_lkhp;
        $this->logAct($aksi);

        // Template Path
        if ($lkhp_final->objek_pemeriksaan == 'Kredit') {
            if (app()->environment('local')) {
                $templatePath = public_path('phpWord/template kredit.docx');
            } else {
                $templatePath = base_path('../public_html/Laravel-public-siaudi/phpWord/template kredit.docx');
            }
        } else {
            if (app()->environment('local')) {
                $templatePath = public_path('phpWord/template operasional.docx');
            } else {
                $templatePath = base_path('../public_html/Laravel-public-siaudi/phpWord/template operasional.docx');
            }
        }

        $templateProcessor = new TemplateProcessor($templatePath);
        $toOpenXML = new Parser();

        // Data HTML dari DB
        $lkhp_uraian_cek    = $lkhp_final->desc_uraian_permasalahan_fakta;
        $lkhp_penyebab      = $lkhp_final->penyebab_terjadi_penyimpangan;
        $lkhp_dampak        = $lkhp_final->dampak_resiko;
        $lkhp_rekomendasi   = $lkhp_final->tindak_lanjut;
        $lkhp_tanggapan_cek = $lkhp_final->tanggapan_auditee;
        $komitmen           = $lkhp_final->komitmen_tindakan;
        $penanggung_jawab   = $lkhp_final->penanggung_jawab;
        $ttd_pemeriksa      = $lkhp_final->ttd_pemeriksa;

        // Proses replace <img> di HTML menjadi placeholder ${img_N}
        $images = [];
        $imageIndex = 1;
        $lkhp_uraian    = $this->replaceImagesWithPlaceholders($lkhp_uraian_cek, $images, $imageIndex);
        $lkhp_tanggapan = $this->replaceImagesWithPlaceholders($lkhp_tanggapan_cek, $images, $imageIndex);

        // Set Values Utama
        $tgl_pengembalian = $lkhp_final->tgl_pengembalian ? $lkhp_final->tgl_pengembalian->translatedFormat('d F Y') : 'Data kosong';
        $templateProcessor->setValue('kc', $lkhp_final->cabang->cabang);
        $templateProcessor->setValue('tgl_pemeriksaan', $lkhp_final->tgl_awal->translatedFormat('d') . ' s/d ' . $lkhp_final->tgl_akhir->translatedFormat('d F Y'));
        $templateProcessor->setValue('no_lkhp', $lkhp_final->no_lkhp);

        // Parse HTML hasil penyesuaian gambar ke XML Word
        $templateProcessor->setValue('lkhp_uraian', $toOpenXML->fromHTML($lkhp_uraian));
        $templateProcessor->setValue('lkhp_penyebab', $toOpenXML->fromHTML($lkhp_penyebab));
        $templateProcessor->setValue('lkhp_dampak', $toOpenXML->fromHTML($lkhp_dampak));
        $templateProcessor->setValue('lkhp_rekomendasi', $toOpenXML->fromHTML($lkhp_rekomendasi));
        $templateProcessor->setValue('lkhp_tanggapan', $toOpenXML->fromHTML($lkhp_tanggapan));
        $templateProcessor->setValue('lkhp_komitmen', $toOpenXML->fromHTML($komitmen));

        $templateProcessor->setValue('lkhp_tgl_kom', $lkhp_final->komitmen_tgl ? $lkhp_final->komitmen_tgl->translatedFormat('d F Y') : 'belum ada data');
        $templateProcessor->setValue('lkhp_jawab', htmlspecialchars($penanggung_jawab));
        $templateProcessor->setValue('pemeriksa', htmlspecialchars($ttd_pemeriksa));

        $templateProcessor->setValue('lkhp_ttd_kaops', $lkhp_final->ttd_kaops);
        $templateProcessor->setValue('lkhp_ttd_kakom', $lkhp_final->ttd_kakom);
        $templateProcessor->setValue('lkhp_ttd_pincab', $lkhp_final->ttd_pincab);
        $templateProcessor->setValue('lkhp_tgl_pengembalian', $tgl_pengembalian);

        // Pivot & Debitur / Risk Event
        $pivotData = Pivot::with('kkpk.debitur')->where('id_lkhp_final', $ids)->get();

        if ($pivotData->isNotEmpty()) {
            $risk_event = $pivotData->first()->riskEvent->kode_finding . ' - ' . $pivotData->first()->riskEvent->list_finding;
            $indikasi_resiko = $pivotData->first()->riskEvent->indikasi_resiko;
            $templateProcessor->setValue('risk_event', $risk_event);
            $templateProcessor->setValue('indikasi_resiko', $indikasi_resiko);

            $templateProcessor->cloneBlock('debitur_blok', $pivotData->count(), true, true);

            foreach ($pivotData as $index => $pivot) {
                $idx = $index + 1;
                if ($lkhp_final->objek_pemeriksaan == 'Kredit' && $pivot->kkpk->debitur) {
                    $debitur = $pivot->kkpk->debitur;
                    $plafon = $debitur->plafon ? 'Rp ' . number_format($debitur->plafon, 0, ',', '.') : 'Belum ada data';
                    $bd     = $debitur->baki_debet ? 'Rp ' . number_format($debitur->baki_debet, 0, ',', '.') : 'Belum ada data';
                    $tgl_realisasi = $debitur->tgl_realisasi ? $debitur->tgl_realisasi->translatedFormat('d F Y') : 'Belum ada data';

                    $templateProcessor->setValue('deb_no#' . $idx, $idx);
                    $templateProcessor->setValue('deb_norek#' . $idx, $debitur->no_rekening);
                    $templateProcessor->setValue('deb_nama#' . $idx, $debitur->nama_nasabah);
                    $templateProcessor->setValue('deb_plafon#' . $idx, $plafon);
                    $templateProcessor->setValue('deb_bd#' . $idx, $bd);
                    $templateProcessor->setValue('deb_kol#' . $idx, $debitur->kol . ' / ' . $debitur->dpd);
                    $templateProcessor->setValue('deb_tgl_realisasi#' . $idx, $tgl_realisasi);
                    $templateProcessor->setValue('deb_nama_ao#' . $idx, $pivot->kkpk->nama_ao);
                    $templateProcessor->setValue('deb_nama_analis#' . $idx, $pivot->kkpk->nama_analis);
                    $templateProcessor->setValue('deb_nama_kakom#' . $idx, $pivot->kkpk->nama_kakom);
                    $templateProcessor->setValue('deb_nama_pincab#' . $idx, $pivot->kkpk->nama_pincab);
                    $templateProcessor->setValue('deb_area_analis#' . $idx, $pivot->kkpk->nama_analis_area);
                    $templateProcessor->setValue('deb_area_man#' . $idx, $pivot->kkpk->nama_area_manager);
                    $templateProcessor->setValue('deb_man_bisnis#' . $idx, $pivot->kkpk->nama_manager_bisnis);
                    $templateProcessor->setValue('deb_nama_dir#' . $idx, $pivot->kkpk->nama_direksi);
                }

                // Proses replace <img> di HTML menjadi placeholder ${img_N}
                $imagesIndex = count($images) + 1;
                $keterangan_cek    = $pivot->keterangan_re;
                $keterangan    = $this->replaceImagesWithPlaceholders($keterangan_cek, $images, $imagesIndex);
                $templateProcessor->setValue('pivot_keterangan_re#' . $idx, $toOpenXML->fromHTML($keterangan));

                foreach ($images as $placeholder => $imageData) {
                    $templateProcessor->setImageValue(
                        $placeholder,
                        [
                            'path'   => $imageData['path'],
                            'width'  => $imageData['width'],
                            'height' => $imageData['height'],
                            'ratio'  => true,
                        ]
                    );
                }

                // Gambar Pendukung Pivot
                if ($pivot->pivotImg->isNotEmpty()) {
                    $replace = str_replace('/', '_', $pivot->lkhp->no_lkhp_bayangan);
                    $folderName = 'gambar/Gambar Pendukung LK - ' . $replace;

                    $templateProcessor->cloneBlock('piv_img_blok#' . $idx, $pivot->pivotImg->count(), true, true);

                    foreach ($pivot->pivotImg as $num => $image) {
                        $imgNum = $num + 1;
                        $templateProcessor->setImageValue(
                            'piv_img#' . $idx . '#' . $imgNum,
                            [
                                'path'   => $folderName . '/' . $image->img,
                                'width'  => 150,
                                'height' => 150,
                                'ratio'  => true
                            ]
                        );
                        $templateProcessor->setValue('piv_caption#' . $idx . '#' . $imgNum, $image->caption);
                    }
                } else {
                    $templateProcessor->setValue('piv_img_blok#' . $idx, '');
                    $templateProcessor->setValue('/piv_img_blok#' . $idx, '');
                    $templateProcessor->setValue('piv_img#' . $idx, '');
                    $templateProcessor->setValue('piv_caption#' . $idx, '');
                }
            }
        }

        // Tahap 1: Simpan dokumen sementara
        $fileExam = 'LKHP_TEMP_' . now()->format('YmdHis') . '_' . uniqid() . '.docx';
        $filePathExam = public_path('phpWord/' . $fileExam);
        $templateProcessor->saveAs($filePathExam);

        // Tahap 2: Sisipkan Gambar Inline dari HTML (jika ada)
        if (!empty($images)) {

            $secondTemplates = new TemplateProcessor($filePathExam);

            foreach ($images as $placeholder => $imageData) {

                $secondTemplates->setImageValue($placeholder, [
                    'path'   => $imageData['path'],
                    'width'  => $imageData['width'],
                    'height' => $imageData['height'],
                    'ratio'  => true,
                ]);
            }

            $fileName = 'LKHP_' . now()->format('YmdHi') . '.docx';
            $filePath = public_path('phpWord/' . $fileName);
            $secondTemplates->saveAs($filePath);
        } else {
            $filePath = $filePathExam;
        }

        // Download dan hapus file setelah selesai terkirim
        unlink($filePathExam); // Hapus file sementara
        return response()->download($filePath)->deleteFileAfterSend(true);
    }


    // save data pendukung di LKHP FInal
    public function InputDataPendukung(Request $request, $Id)
    {
        $ids = Crypt::decrypt($Id);
        $lkhp = LkhpFinal::where('id_lkhp_final', $ids)->first();
        $user = auth()->user()->sub_jabatan;

        if ($user == 'Kabid Audit Internal') {
            # code...
            $lkhp->update([
                'penanggung_jawab' => $request->penanggung_jawab,
                'komitmen_tgl' => $request->komitmen_tgl ? Carbon::createFromFormat('d-m-Y', $request->komitmen_tgl)->format('Y-m-d') : null,
                'ttd_kaops' => $request->ttd_kaops,
                'ttd_kakom' => $request->ttd_kakom,
                'ttd_pincab' => $request->ttd_pincab,
            ]);
        } else {
            $tanggapan_auditee = $this->SummernoteImg($request->tanggapan_auditee);
            $komiten = $this->SummernoteImg($request->komitmen_tindakan);

            $lkhp->update([
                'tanggapan_auditee' => $tanggapan_auditee,
                'komitmen_tindakan' => $komiten
            ]);
        }

        $aksi = "(+) Input Data Pendukung LKHP Final Nomor: " . $lkhp->no_lkhp;
        $this->logAct($aksi);
        return redirect()->route('lkhp-final.show', Crypt::encrypt($lkhp->id_lkhp_final))->with('AlertSuccess', 'Data Pendukung berhasil disimpan!');
    }


    // fungsi handle summernote img
    private function SummernoteImg($html)
    {
        if (empty($html)) {
            return $html;
        }
        $dom = new DOMDocument();
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');
        foreach ($images as $key => $img) {
            $src = $img->getAttribute('src');
            if (strpos($src, 'base64,') !== false) {
                list($type, $data) = explode(';', $src);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);

                // $image_name = '/upload/img/' . time() . $key . '.png';
                $image_name = url('/resource-gambar/' . time() . $key . '.png');
                // file_put_contents(public_path() . $image_name, $data);
                file_put_contents(public_path('upload/img/' . time() . $key . '.png'), $data);
                $src = url($image_name);

                $img->removeAttribute('src');
                $img->setAttribute('src', $src);
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



    // ==============
    // button pada status data table index
    private function statusNothing($data)
    {
        $status = '';
        $status .= '<div class="dropdown">';
        $status .= '<button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="statusDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
        $status .= 'Nothing';
        $status .= '</button>';
        $status .= '<div class="dropdown-menu" aria-labelledby="statusDropdown">';
        $status .= '<a class="dropdown-item send" id="send' . $data->id_lkhp_final . '" data-id="' . encrypt($data->id_lkhp_final) . '" data-kode="' . $data->no_lkhp . '" data-jabatan="' . auth()->user()->sub_jabatan . '" >Kirim</a>';
        $status .= '</div>';
        $status .= '</div>';
        return $status;
    }


    private function statusAfter($data, $jabatan, $statusDropdown)
    {
        $status = '';
        if ($jabatan != '') {
            $status .= '<a class="btn btn-success btn-sm disabled">Terkirim</a>';
        } else {
            return $statusDropdown;
        }
        return $status;
    }


    // Email single
    private function SendEmail($data, $userPenerima, $url, $title, $pesan, $regard)
    {
        Mail::send('email.notif.notif-dobel',  [
            'no_lkhp' => $data->no_lkhp,
            'kc' => $data->cabang->cabang,
            'url' => $url,
            'title' => $title,
            'pesan' => $pesan,
            'regard' => $regard,
            'tgl_pengembalian' => $data->tgl_pengembalian->translatedFormat('d F Y'),
        ], function ($message) use ($userPenerima, $title) {
            $message->from('tsiksb@bprkusumasumbing.com', 'KSB | Si-PUTa');
            $message->to($userPenerima->email);
            $message->subject($title);
        });
    }


    // Email Doubel
    private function SendEmailDobel($data, $userPenerima, $url, $title, $pesan, $regard)
    {
        foreach ($userPenerima as $user) {
            Mail::send('email.notif.notif-dobel',  [
                'no_lkhp' => $data->no_lkhp,
                'kc' => $data->cabang->cabang,
                'url' => $url,
                'title' => $title,
                'pesan' => $pesan,
                'regard' => $regard,
                'tgl_pengembalian' => $data->tgl_pengembalian->translatedFormat('d F Y'),
            ], function ($message) use ($user, $title) {
                $message->from('tsiksb@bprkusumasumbing.com', 'KSB | Si-AUDI');
                $message->to($user->email);
                $message->subject($title);
            });
        }
    }



    // Fungsi untuk mengganti tag <img> dengan placeholder dengan stylenya


    private function replaceImagesWithPlaceholders($html, &$images, &$imageIndex)
    {
        if (empty($html)) {
            return $html;
        }

        libxml_use_internal_errors(true);

        $dom = new \DOMDocument('1.0', 'UTF-8');

        $dom->loadHTML(
            '<?xml encoding="UTF-8"><div id="wrapper">' . $html . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        $xpath = new \DOMXPath($dom);

        $imgElements = $xpath->query('//img');

        // Simpan dahulu daftar gambar agar aman saat DOM dimodifikasi
        $imgElements = iterator_to_array($imgElements);

        foreach ($imgElements as $img) {

            $src = $img->getAttribute('src');

            if (empty($src)) {
                $img->parentNode->removeChild($img);
                continue;
            }

            // Ambil lokasi file gambar dari URL
            $imageUrlPath = parse_url($src, PHP_URL_PATH);

            $imageUrlPath = rawurldecode($imageUrlPath);

            // jika URL menggunakan route /resource-gambar/
            // arahkan ke lokasi file fisik yang sebenarnya
            if (strpos($imageUrlPath, '/resource-gambar/') === 0) {
                $imagePath = public_path(
                    'upload/img/' . basename($imageUrlPath)
                );
            } else {
                $imagePath = public_path(
                    ltrim($imageUrlPath, '/')
                );
            }

            // Periksa file
            if (!is_file($imagePath)) {
                $img->parentNode->removeChild($img);
                continue;
            }

            // Ambil ukuran gambar
            $size = @getimagesize($imagePath);

            if (!$size) {
                $img->parentNode->removeChild($img);
                continue;
            }

            // Ambil width dari inline style
            $style = $img->getAttribute('style');

            $width = 650;

            if (preg_match('/width\s*:\s*(\d+(?:\.\d+)?)px/i', $style, $match)) {
                $width = (int) round((float) $match[1]);
            } elseif ($img->hasAttribute('width')) {
                $width = (int) $img->getAttribute('width');
            }

            // Hitung tinggi berdasarkan rasio asli
            $height = (int) round(
                ($width / $size[0]) * $size[1]
            );

            $placeholder = 'img_' . $imageIndex;

            $images[$placeholder] = [
                'path'   => $imagePath,
                'width'  => $width,
                'height' => $height,
            ];

            $imageIndex++;

            // Buat placeholder pada posisi gambar semula
            $placeholderNode = $dom->createTextNode(
                '${' . $placeholder . '}'
            );

            $img->parentNode->replaceChild(
                $placeholderNode,
                $img
            );
        }

        $wrapper = $dom->getElementById('wrapper');

        $result = '';

        foreach ($wrapper->childNodes as $child) {
            $result .= $dom->saveHTML($child);
        }

        libxml_clear_errors();

        return $result;
    }





    // Fungsi untuk mengganti tag <img> dengan placeholder tanpa menginport style nya
    // function replaceImagesWithPlaceholders($html, &$images, &$imageIndex)
    // {
    //     return preg_replace_callback('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/', function ($matches) use (&$images, &$imageIndex) {
    //         $src = $matches[1];
    //         // $imagePath = public_path(str_replace(url('/'), '', $src));
    //         if (app()->environment('local')) {
    //             $imagePath = public_path(str_replace(url('/'), '', $src));
    //         } else {
    //             $imagePath = base_path(str_replace(url('/resource-gambar'), '', 'public/upload/img' . $src)); // Sesuaikan dengan jalur folder Anda
    //         }

    //         // dd($imagePath);

    //         if (!empty($imagePath)) {
    //             $placeholder = "img_{$imageIndex}";
    //             $changePlaceholder = "{" . $placeholder . "}";
    //             $images[$placeholder] = $imagePath;
    //             $imageIndex++;

    //             // Ganti tag <img> dengan placeholder tanpa mengubah format lain
    //             return "<br>\${$changePlaceholder}<br>";
    //         }

    //         return $matches[0]; // Jika gambar tidak ditemukan, tetap gunakan tag asli
    //     }, $html);
    // }
}
