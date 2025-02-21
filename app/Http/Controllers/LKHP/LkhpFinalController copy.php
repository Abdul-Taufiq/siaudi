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
            ->with(['pivot.riskEvent'])
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
        $desc_keadaan = $this->SummernoteImg($request->desc_keadaan_seharusnya);
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
            'desc_keadaan_seharusnya' => $desc_keadaan,
            'penyebab_terjadi_penyimpangan' => $penyebab_penyimpangan,
            'dampak_resiko' => $dampak_resiko,
            'tindak_lanjut' => $tindak_lanjut,
            'nama_creator' => auth()->user()->nama,
            'ttd_pemeriksa' => $request->ttd_pemeriksa
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
        $desc_keadaan = $this->SummernoteImg($request->desc_keadaan_seharusnya);
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
        $lkhpFinal->desc_keadaan_seharusnya = $desc_keadaan;
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


    public function printLkhpAsWord($id)
    {
        $ids = Crypt::decrypt($id);
        $lkhp_final = LkhpFinal::with(['pivot.pivotImg'])
            ->where('id_lkhp_final', $ids)
            ->first();
        // Grouping pivots by id_event_risk
        $groupedPivots = $lkhp_final->pivot->groupBy('id_event_risk');

        // log activity
        $aksi = "(+) Print As Word LKHP Final Nomor: " . $lkhp_final->no_lkhp;
        $this->logAct($aksi);

        // Determine the appropriate template based on the objek_pemeriksaan
        if ($lkhp_final->objek_pemeriksaan == 'Kredit') {
            # code...
            // Sesuaikan jalur template berdasarkan lingkungan
            if (app()->environment('local')) {
                $templatePath = public_path('phpWord/template kredit.docx');
            } else {
                $templatePath = base_path('../public_html/Laravel-public-siaudi/phpWord/template kredit.docx');
            }
            // Create an instance of TemplateProcessor
            $templateProcessor = new TemplateProcessor($templatePath);

            // value untuk mengisi template
            // parse HTML to xml
            $toOpenXML  = new Parser();
            // $lkhp_uraian = strip_tags($lkhp_final->desc_uraian_permasalahan_fakta); // menghapus semua tag html
            $lkhp_uraian = $lkhp_final->desc_uraian_permasalahan_fakta;
            $lkhp_keadaan = $lkhp_final->desc_keadaan_seharusnya;
            $lkhp_penyebab = $lkhp_final->penyebab_terjadi_penyimpangan;
            $lkhp_dampak = $lkhp_final->dampak_resiko;
            $lkhp_rekomendasi = $lkhp_final->tindak_lanjut;
            $lkhp_tanggapan = $lkhp_final->tanggapan_auditee;
            $komitmen = $lkhp_final->komitmen_tindakan;
            $penanggung_jawab = $lkhp_final->penanggung_jawab;
            $ttd_pemeriksa = $lkhp_final->ttd_pemeriksa;

            // dd($toOpenXML->fromHTML($lkhp_uraian));


            // LKHP
            $tgl_pengembalian = $lkhp_final->tgl_pengembalian ? $lkhp_final->tgl_pengembalian->translatedFormat('d F Y') : 'Data kosong';
            $templateProcessor->setValue('kc', $lkhp_final->cabang->cabang);
            $templateProcessor->setValue('tgl_pemeriksaan', $lkhp_final->tgl_awal->translatedFormat('d') . ' s/d ' . $lkhp_final->tgl_akhir->translatedFormat('d F Y'));
            $templateProcessor->setValue('no_lkhp', $lkhp_final->no_lkhp);
            $templateProcessor->setValue('lkhp_uraian', $toOpenXML->fromHTML($lkhp_uraian));
            $templateProcessor->setValue('lkhp_keadaan', $toOpenXML->fromHTML($lkhp_keadaan));
            $templateProcessor->setValue('lkhp_penyebab', $toOpenXML->fromHTML($lkhp_penyebab));
            $templateProcessor->setValue('lkhp_dampak', $toOpenXML->fromHTML($lkhp_dampak));
            $templateProcessor->setValue('lkhp_rekomendasi', $toOpenXML->fromHTML($lkhp_rekomendasi));
            $templateProcessor->setValue('lkhp_tanggapan', $toOpenXML->fromHTML($lkhp_tanggapan));
            $templateProcessor->setValue('lkhp_komitmen', $toOpenXML->fromHTML($komitmen));
            $templateProcessor->setValue('lkhp_komitmen', $toOpenXML->fromHTML($komitmen));

            $templateProcessor->setValue('lkhp_tgl_kom', $lkhp_final->komitmen_tgl ? $lkhp_final->komitmen_tgl->translatedFormat('d F Y') : 'belum ada data');

            $templateProcessor->setValue('lkhp_jawab', htmlspecialchars($penanggung_jawab));
            $templateProcessor->setValue('pemeriksa', htmlspecialchars($ttd_pemeriksa));

            $templateProcessor->setValue('lkhp_ttd_kaops', $lkhp_final->ttd_kaops);
            $templateProcessor->setValue('lkhp_ttd_kakom', $lkhp_final->ttd_kakom);
            $templateProcessor->setValue('lkhp_ttd_pincab', $lkhp_final->ttd_pincab);
            $templateProcessor->setValue('lkhp_tgl_pengembalian', $tgl_pengembalian);

            // Debitur
            // Ambil data dari Pivot
            $pivotData = Pivot::with('kkpk.debitur')->where('id_lkhp_final', $ids)->get();

            // Risk Event
            $risk_event = $pivotData->first()->riskEvent->kode_finding . ' - ' . $pivotData->first()->riskEvent->list_finding;
            $indikasi_resiko = $pivotData->first()->riskEvent->indikasi_resiko;
            $templateProcessor->setValue('risk_event', $risk_event);
            $templateProcessor->setValue('indikasi_resiko', $indikasi_resiko);

            // Gandakan baris tabel sesuai dengan jumlah data
            $templateProcessor->cloneBlock('debitur_blok', $pivotData->count(), true, true);

            // Isi placeholder di tabel dengan data
            foreach ($pivotData as $index => $pivot) {
                $debitur = $pivot->kkpk->debitur;

                // Format data
                $plafon = $debitur->plafon ? 'Rp ' . number_format($debitur->plafon, 0, ',', '.') : 'Belum ada data';
                $bd = $debitur->baki_debet ? 'Rp ' . number_format($debitur->baki_debet, 0, ',', '.') : 'Belum ada data';
                $kol = $debitur->kol;
                $dpd = $debitur->dpd;
                $tgl_realisasi = $debitur->tgl_realisasi ? $debitur->tgl_realisasi->translatedFormat('d F Y') : 'Belum ada data';

                // Set value untuk placeholder
                $templateProcessor->setValue('deb_no#' . ($index + 1), $index + 1);
                $templateProcessor->setValue('deb_norek#' . ($index + 1), $debitur->no_rekening);
                $templateProcessor->setValue('deb_nama#' . ($index + 1), $debitur->nama_nasabah);
                $templateProcessor->setValue('deb_plafon#' . ($index + 1), $plafon . '/' . $bd);
                $templateProcessor->setValue('deb_kol#' . ($index + 1), $kol . '/' . $dpd);
                $templateProcessor->setValue('deb_tgl_realisasi#' . ($index + 1), $tgl_realisasi);
                $templateProcessor->setValue('deb_nama_ao#' . ($index + 1), $pivot->kkpk->nama_ao);
                $templateProcessor->setValue('deb_nama_analis#' . ($index + 1), $pivot->kkpk->nama_analis);
                $templateProcessor->setValue('deb_nama_kakom#' . ($index + 1), $pivot->kkpk->nama_kakom);
                $templateProcessor->setValue('deb_nama_pincab#' . ($index + 1), $pivot->kkpk->nama_pincab);
                $templateProcessor->setValue('deb_area_analis#' . ($index + 1), $pivot->kkpk->nama_analis_area);
                $templateProcessor->setValue('deb_area_man#' . ($index + 1), $pivot->kkpk->nama_area_manager);
                $templateProcessor->setValue('deb_man_bisnis#' . ($index + 1), $pivot->kkpk->nama_manager_bisnis);
                $templateProcessor->setValue('deb_nama_dir#' . ($index + 1), $pivot->kkpk->nama_direksi);
                $templateProcessor->setValue('pivot_keterangan_re#' . ($index + 1), $toOpenXML->fromHTML($pivot->keterangan_re));

                // IMG
                if ($pivot->pivotImg->isNotEmpty()) {
                    foreach ($pivot->pivotImg as $num => $image) {
                        // Mengganti '/' dengan '_' untuk nama folder
                        $replace = str_replace('/', '_', $pivot->lkhp->no_lkhp_bayangan);
                        $folderName = 'gambar/Gambar Pendukung LK - ' . $replace;

                        // Gandakan baris tabel sesuai dengan jumlah gambar
                        $templateProcessor->cloneBlock('piv_img_blok#' . ($index + 1), $pivot->pivotImg->count(), true, true);

                        // Menambahkan gambar ke template
                        $templateProcessor->setImageValue(
                            'piv_img#' . ($index + 1) . '#' . ($num + 1),
                            array(
                                'path' => $folderName . '/' . $image->img, // Path gambar
                                'width' => 150, // Lebar gambar
                                'height' => 150, // Tinggi gambar
                                'ratio' => true // Menjaga rasio gambar
                            )
                        );
                        // Menambahkan caption gambar
                        $templateProcessor->setValue('piv_caption#' . ($index + 1) . '#' . ($num + 1), $image->caption);
                    }
                } else {
                    // Menghapus blok jika tidak ada gambar
                    $templateProcessor->setValue('piv_img_blok#' . ($index + 1), '');
                    $templateProcessor->setValue('/piv_img_blok#' . ($index + 1), '');
                    $templateProcessor->setValue('piv_img#' . ($index + 1), '');
                    $templateProcessor->setValue('piv_caption#' . ($index + 1), '');
                }
            }
        }
        // Operasional
        else {
            # code...
            $templatePath = 'phpWord/template operasional.docx';
            // Create an instance of TemplateProcessor
            $templateProcessor = new TemplateProcessor($templatePath);

            // value untuk mengisi template
            // parse HTML to xml
            $toOpenXML  = new Parser();
            // $lkhp_uraian = strip_tags($lkhp_final->desc_uraian_permasalahan_fakta); // menghapus semua tag html
            $lkhp_uraian = $lkhp_final->desc_uraian_permasalahan_fakta;
            $lkhp_keadaan = $lkhp_final->desc_keadaan_seharusnya;
            $lkhp_penyebab = $lkhp_final->penyebab_terjadi_penyimpangan;
            $lkhp_dampak = $lkhp_final->dampak_resiko;
            $lkhp_rekomendasi = $lkhp_final->tindak_lanjut;
            $lkhp_tanggapan = $lkhp_final->tanggapan_auditee;
            $komitmen = $lkhp_final->komitmen_tindakan;
            $penanggung_jawab = $lkhp_final->penanggung_jawab;
            $ttd_pemeriksa = $lkhp_final->ttd_pemeriksa;


            // LKHP
            $tgl_pengembalian = $lkhp_final->tgl_pengembalian ? $lkhp_final->tgl_pengembalian->translatedFormat('d F Y') : 'Data kosong';
            $templateProcessor->setValue('kc', $lkhp_final->cabang->cabang);
            $templateProcessor->setValue('tgl_pemeriksaan', $lkhp_final->tgl_awal->translatedFormat('d') . ' s/d ' . $lkhp_final->tgl_akhir->translatedFormat('d F Y'));
            $templateProcessor->setValue('no_lkhp', $lkhp_final->no_lkhp);
            $templateProcessor->setValue('lkhp_uraian', $toOpenXML->fromHTML($lkhp_uraian));
            $templateProcessor->setValue('lkhp_keadaan', $toOpenXML->fromHTML($lkhp_keadaan));
            $templateProcessor->setValue('lkhp_penyebab', $toOpenXML->fromHTML($lkhp_penyebab));
            $templateProcessor->setValue('lkhp_dampak', $toOpenXML->fromHTML($lkhp_dampak));
            $templateProcessor->setValue('lkhp_rekomendasi', $toOpenXML->fromHTML($lkhp_rekomendasi));
            $templateProcessor->setValue('lkhp_tanggapan', $toOpenXML->fromHTML($lkhp_tanggapan));
            $templateProcessor->setValue('lkhp_komitmen', $toOpenXML->fromHTML($komitmen));
            $templateProcessor->setValue('lkhp_komitmen', $toOpenXML->fromHTML($komitmen));

            $templateProcessor->setValue('lkhp_tgl_kom', $lkhp_final->komitmen_tgl ? $lkhp_final->komitmen_tgl->translatedFormat('d F Y') : 'belum ada data');

            $templateProcessor->setValue('lkhp_jawab', htmlspecialchars($penanggung_jawab));
            $templateProcessor->setValue('pemeriksa', htmlspecialchars($ttd_pemeriksa));

            $templateProcessor->setValue('lkhp_ttd_kaops', $lkhp_final->ttd_kaops);
            $templateProcessor->setValue('lkhp_ttd_kakom', $lkhp_final->ttd_kakom);
            $templateProcessor->setValue('lkhp_ttd_pincab', $lkhp_final->ttd_pincab);
            $templateProcessor->setValue('lkhp_tgl_pengembalian', $tgl_pengembalian);

            // Debitur
            // Ambil data dari Pivot
            $pivotData = Pivot::with('kkpk.debitur')->where('id_lkhp_final', $ids)->get();

            // Risk Event
            $risk_event = $pivotData->first()->riskEvent->kode_finding . ' - ' . $pivotData->first()->riskEvent->list_finding;
            $indikasi_resiko = $pivotData->first()->riskEvent->indikasi_resiko;
            $templateProcessor->setValue('risk_event', $risk_event);
            $templateProcessor->setValue('indikasi_resiko', $indikasi_resiko);

            // Gandakan baris tabel sesuai dengan jumlah data
            $templateProcessor->cloneBlock('debitur_blok', $pivotData->count(), true, true);

            // Isi placeholder di tabel dengan data
            foreach ($pivotData as $index => $pivot) {
                // Set value untuk placeholder
                $templateProcessor->setValue('pivot_keterangan_re#' . ($index + 1), $toOpenXML->fromHTML($pivot->keterangan_re));

                // IMG
                if ($pivot->pivotImg->isNotEmpty()) {
                    foreach ($pivot->pivotImg as $num => $image) {
                        // Mengganti '/' dengan '_' untuk nama folder
                        $replace = str_replace('/', '_', $pivot->lkhp->no_lkhp_bayangan);
                        $folderName = 'gambar/Gambar Pendukung LK - ' . $replace;

                        // Gandakan baris tabel sesuai dengan jumlah gambar
                        $templateProcessor->cloneBlock('piv_img_blok#' . ($index + 1), $pivot->pivotImg->count(), true, true);

                        // Menambahkan gambar ke template
                        $templateProcessor->setImageValue(
                            'piv_img#' . ($index + 1) . '#' . ($num + 1),
                            array(
                                'path' => $folderName . '/' . $image->img, // Path gambar
                                'width' => 150, // Lebar gambar
                                'height' => 150, // Tinggi gambar
                                'ratio' => true // Menjaga rasio gambar
                            )
                        );
                        // Menambahkan caption gambar
                        $templateProcessor->setValue('piv_caption#' . ($index + 1) . '#' . ($num + 1), $image->caption);
                    }
                } else {
                    // Menghapus blok jika tidak ada gambar
                    $templateProcessor->setValue('piv_img_blok#' . ($index + 1), '');
                    $templateProcessor->setValue('/piv_img_blok#' . ($index + 1), '');
                    $templateProcessor->setValue('piv_img#' . ($index + 1), '');
                    $templateProcessor->setValue('piv_caption#' . ($index + 1), '');
                }
            }
        }



        // disini dicek dulu jika ada tag img maka tag img yang seperti sampai end diganti contoh
        // <img style="width: 100%;" data-filename="Screenshot 2025-02-12 112805.png" src="http://ksb-siaudi.test/upload/img/17393350010.png"> //ini sesuai dengan db
        // diganti jadi
        //  <br>${img_1}<br>
        //  <br>${img_2}<br>
        // dst sesuai dengan jumlah tag yang ditemukan

        // Simpan atau unduh dokumen yang telah diproses
        $fileExam = 'Exam' . now()->format('YmdHi') . '.docx';
        $filePathExam = ('phpWord/' . $fileExam);
        $templateProcessor->saveAs($filePathExam);

        // disini harus ada pengecekan jika ada tag img jalankan dibawah ini

        // setelah koreksi jika ada tag img maka lakukan proses kedua ini
        $secondTemplates = new TemplateProcessor($filePathExam);

        $secondTemplates->setImageValue('img', [
            'path' => public_path('upload/img/17393345750.png'), // image name sesuai dengan isi dari database
            'width' => 500,
            'height' => 500,
            'ratio' => true,
        ]);

        $fileName = 'LKHP_' . now()->format('YmdHi') . '.docx';
        $filePath = 'phpWord/' . $fileName;

        $secondTemplates->saveAs($filePath);

        // jika tidak ada tag img maka jalankan ini
        // hapus file $fileExam yang tersimpan
        // Kemudian Kembalikan response (misalnya, untuk mendownload file)
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
            $komiten = $this->SummernoteImg($request->komitmen_tindakan);
            $tanggapan_auditee = $this->SummernoteImg($request->tanggapan_auditee);

            $lkhp->update([
                'tanggapan_auditee' => $tanggapan_auditee,
                'komitmen_tindakan' => $komiten
            ]);
        }

        $aksi = "(+) Input Data Pendukung LKHP Final Nomor: " . $lkhp->no_lkhp;
        $this->logAct($aksi);
        return redirect()->route('lkhp-final.show', Crypt::encrypt($lkhp->id_lkhp_final))->with('AlertSuccess', 'Data Pendukung berhasil disimpan!');
    }


    // summernote
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
}
