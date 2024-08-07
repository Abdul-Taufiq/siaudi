<?php

namespace App\Http\Controllers\LKHP;

use App\Http\Controllers\Controller;
use App\Models\LKHP\{Lkhp, LkhpFinal, Pivot};
use App\Models\LogActivity;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DOMDocument;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;
use View;
use PhpOffice\PhpWord\TemplateProcessor;

class LkhpFinalController extends Controller
{
    public function index(Request $request)
    {
        $awal = Carbon::parse($request->min)->startOfDay();
        $akhir = Carbon::parse($request->max)->endOfDay();
        $username = auth()->user()->nama;
        $level = auth()->user()->level;
        $id_cabang = auth()->user()->id_cabang;

        if (request()->ajax()) {
            if ($level == 'MEDIUM USER') {
                if (!empty($request->min)) {
                    $data = LkhpFinal::whereBetween('created_at', [$awal, $akhir])
                        ->where('id_cabang', $id_cabang)
                        ->orderBy('created_at', 'desc')->get();
                } else {
                    $data = LkhpFinal::orderBy('created_at', 'desc')
                        ->where('id_cabang', $id_cabang)->get();
                }
            } else {
                if (auth()->user()->sub_jabatan == 'Kabid Internal Audit') {
                    if (!empty($request->min)) {
                        $data = LkhpFinal::whereBetween('created_at', [$awal, $akhir])
                            ->orderBy('created_at', 'desc')->get();
                    } else {
                        $data = LkhpFinal::orderBy('created_at', 'desc')->get();
                    }
                } else {
                    if (!empty($request->min)) {
                        $data = LkhpFinal::where('nama_creator', $username)->whereBetween('created_at', [$awal, $akhir])
                            ->orderBy('created_at', 'desc')->get();
                    } else {
                        $data = LkhpFinal::where('nama_creator', $username)->orderBy('created_at', 'desc')->get();
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
                        $button = '<a href="/lkhp-final-ops/' . encrypt($data->id_lkhp_final) . '/show"
                                            class="btn btn-info btn-sm detail_data">
                                            <span class="icon text-white-50">
                                            <i class="fa fa-eye"></i>
                                            </span>
                                        </a>';
                        $button .= '&nbsp;';
                        // Cek apakah user memiliki hak akses untuk mengedit atau menghapus
                        if (auth()->user()->sub_jabatan == 'Kabid Internal Audit') {
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
                        if (auth()->user()->sub_jabatan == 'Kabid Internal Audit') {
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

                ->rawColumns(['action'])
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
        // log Act
        $aksi = "(-) Hapus Data LKHP Final Nomor: " . $lkhpFinal->no_lkhp;
        $this->logAct($aksi);

        $lkhpFinal->delete();
    }


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
            $pdf = Pdf::loadView('Page.Lkhp_Final.print.print-kredit-pdf', compact('lkhp_final', 'groupedPivots'));
            return $pdf->stream('LKHP Final Nomor ' . $lkhp_final->no_lkhp . '.pdf');
        } else {
            $pdf = Pdf::loadView('Page.Lkhp_Final.print.print-ops-pdf', compact('lkhp_final', 'groupedPivots'));
            return $pdf->stream('LKHP Final Nomor ' . $lkhp_final->no_lkhp . '.pdf');
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

        // return view('Page.Lkhp_Final.print.print-ops-word', compact('lkhp_final', 'groupedPivots'));

        $aksi = "(+) Print As Word LKHP Final Nomor: " . $lkhp_final->no_lkhp;
        $this->logAct($aksi);

        $headers = array(
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'attatchement;Filename=LKHP Final Nomor ' . $lkhp_final->no_lkhp . '.doc'
        );

        if ($lkhp_final->objek_pemeriksaan == 'Kredit') {
            # code...
            return Response::make(view('Page.Lkhp_Final.print.print-kredit-word', compact('lkhp_final', 'groupedPivots')), 200, $headers);
        } else {
            return Response::make(view('Page.Lkhp_Final.print.print-ops-word', compact('lkhp_final', 'groupedPivots')), 200, $headers);
        }
    }


    // save data pendukung di LKHP FInal
    public function InputDataPendukung(Request $request, $Id)
    {
        $ids = Crypt::decrypt($Id);
        $lkhp = LkhpFinal::where('id_lkhp_final', $ids)->first();
        $user = auth()->user()->sub_jabatan;

        if ($user == 'Kabid Internal Audit') {
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

                $image_name = '/upload/img/' . time() . $key . '.png';
                file_put_contents(public_path() . $image_name, $data);

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
