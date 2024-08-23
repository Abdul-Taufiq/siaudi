<?php

namespace App\Http\Controllers\Debitur;

use App\Http\Controllers\Controller;
use App\Imports\ImportDebitur;
use App\Models\Debitur\Debitur;
use App\Models\LogActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DebiturController extends Controller
{
    public function index(Request $request)
    {
        $awal = Carbon::parse($request->min)->startOfDay();
        $akhir = Carbon::parse($request->max)->endOfDay();
        $level = auth()->user()->level;
        $id_cabang = auth()->user()->id_cabang;

        if (request()->ajax()) {
            if ($level == 'MEDIUM USER') {
                # code...
                if (!empty($request->min)) {
                    $data = Debitur::whereBetween('created_at', [$awal, $akhir])
                        ->where('id_cabang', $id_cabang)
                        ->orderBy('created_at', 'desc')->get();
                } else {
                    $data = Debitur::orderBy('created_at', 'desc')
                        ->where('id_cabang', $id_cabang)->get();
                }
            } else {
                # code...
                if (!empty($request->min)) {
                    $data = Debitur::whereBetween('created_at', [$awal, $akhir])
                        ->orderBy('created_at', 'desc')->get();
                } else {
                    $data = Debitur::orderBy('created_at', 'desc')->get();
                }
            }


            return DataTables()->of($data)
                ->addColumn('cabang', function ($data) {
                    return $data->cabang->cabang;
                })
                ->addColumn('action', function ($data) {
                    // $button = '<a data-toggle="modal" data-target="#myModal' . $data->id_debitur . '" id="' . $data->id_debitur . '"
                    //                     class="btn btn-info btn-sm detail_data" data-kode_form="' . $data->no_rekening . '">
                    //                     <span class="icon text-white-50">
                    //                     <i class="fa fa-eye"></i>
                    //                     </span>
                    //                 </a>';
                    // $button .= '&nbsp;';
                    if (auth()->user()->sub_jabatan == 'Kabid Audit Internal') {
                        $button = '<a data-toggle="modal" data-target="#modalEdit' . $data->id_debitur . '" id="' . $data->id_debitur . '"
                                            class="btn btn-warning btn-sm edit" data-kode_form="' . $data->no_rekening . '">
                                            <i class="fa fa-edit"></i></a>';
                        $button .= '&nbsp;';
                        $button .= '<a data-toggle="modal" id="' . $data->id_debitur . '"
                                            class="hapus btn btn-danger btn-sm delete-post ">
                                            <i class="fa fa-trash"></i></a>';
                    } else {
                        $button = '<a class="btn btn-warning btn-sm edit disabled"><i class="fa fa-edit"></i></a>';
                        $button .= '&nbsp;';
                        $button .= '<a class="delete btn btn-danger btn-sm delete-post disabled"><i class="fa fa-trash"></i></a>';
                    }

                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('Page.Debitur.index', ['title' => 'Debitur']);
    }

    // total noa dll
    public function TotalAll(Request $request)
    {
        $awal = Carbon::parse($request->min)->startOfDay();
        $akhir = Carbon::parse($request->max)->endOfDay();

        if (!empty($request->min)) {
            $data = Debitur::whereBetween('created_at', [$awal, $akhir])
                ->orderBy('created_at', 'desc')->get();
        } else {
            $data = Debitur::orderBy('created_at', 'desc')->get();
        }

        $totalPlafon = $data->sum('plafon');
        $totalBakiDebet = $data->sum('baki_debet');

        return response()->json([
            'data' => $data,
            'totalPlafon' => $totalPlafon,
            'totalBakiDebet' => $totalBakiDebet
        ]);
    }

    public function store(Request $request)
    {
        // Simpan file ke server menggunakan Storage Laravel
        $data = $request->file('file_excel');
        $originalName = $data->getClientOriginalName();
        $extension = $data->getClientOriginalExtension();

        // Buat nama file unik dengan menambahkan timestamp atau UUID
        $namaFile = pathinfo($originalName, PATHINFO_FILENAME) . ' - ' . date('dmY-His') . '.' . $extension;
        $filePath = 'file_upload/Debitur/' . $namaFile;

        // Simpan file ke storage publik
        $data->move(public_path('file_upload/Debitur'), $namaFile);

        // Lempar ke Fungsi Import
        $fullPath = public_path('file_upload/Debitur/' . $namaFile);
        Excel::import(new ImportDebitur(request()->cabang), $fullPath);

        // log Act
        $aksi = "(+) Tambah Data Debitur (File Excel) dengan Nama File: " . $namaFile;
        $this->logAct($aksi);
        return redirect()->back()->with('AlertSuccess', 'Data Excel Berhasil Diupload dan Disimpan!');
    }


    public function storeManual(Request $request)
    {
        $data = new Debitur();
        $data->id_cabang = $request->cabang_manual;
        $data->no_rekening = $request->no_rekening;
        $data->nama_nasabah = $request->nama_nasabah;
        $data->alamat = $request->alamat;
        $data->tgl_realisasi = Carbon::createFromFormat('d-m-Y', $request->tgl_realisasi)->format('Y-m-d');
        $data->jkw = $request->jkw;
        $data->tgl_jth_tempo = Carbon::createFromFormat('d-m-Y', $request->tgl_jth_tempo)->format('Y-m-d');
        $data->plafon = str_replace(['Rp. ', '.'], '', $request->plafon);
        $data->baki_debet = str_replace(['Rp. ', '.'], '', $request->baki_debet);
        $data->tunggakan_bunga = str_replace(['Rp. ', '.'], '', $request->tunggakan_bunga);
        $data->dpd = $request->dpd;
        $data->kol = $request->kol;
        $data->no_hp = $request->no_hp;
        $data->kolektor = $request->kolektor;
        $data->save();

        // log Act
        $aksi = "(+) Tambah Data Debitur (Manual) dengan Nomor Rekening: " . $data->no_rekening . " - An: " . $data->nama_nasabah;
        $this->logAct($aksi);

        return redirect()->back()->with('AlertSuccess', 'Data Debitur Berhasil Disimpan!');
    }


    public function edit(Debitur $debitur)
    {
        return response()->json([
            'status' => 200,
            'data' => $debitur
        ]);
    }


    public function update(Request $request, Debitur $debitur)
    {
        $debitur->id_cabang = $request->cabang_edit;
        $debitur->no_rekening = $request->no_rekening_edit;
        $debitur->nama_nasabah = $request->nama_nasabah_edit;
        $debitur->alamat = $request->alamat_edit;
        $debitur->tgl_realisasi = Carbon::createFromFormat('d-m-Y', $request->tgl_realisasi_edit)->format('Y-m-d');
        $debitur->jkw = $request->jkw_edit;
        $debitur->tgl_jth_tempo = Carbon::createFromFormat('d-m-Y', $request->tgl_jth_tempo_edit)->format('Y-m-d');
        $debitur->plafon = str_replace(['Rp. ', '.'], '', $request->plafon_edit);
        $debitur->baki_debet = str_replace(['Rp. ', '.'], '', $request->baki_debet_edit);
        $debitur->tunggakan_bunga = str_replace(['Rp. ', '.'], '', $request->tunggakan_bunga_edit);
        $debitur->dpd = $request->dpd_edit;
        $debitur->kol = $request->kol_edit;
        $debitur->no_hp = $request->no_hp_edit;
        $debitur->kolektor = $request->kolektor_edit;
        $debitur->save();

        // log Act
        $aksi = "(u) Update Data Debitur dengan Nomor Rekening: " . $debitur->no_rekening . " - An: " . $debitur->nama_nasabah;
        $this->logAct($aksi);

        return redirect()->back()->with('AlertSuccess', 'Data Debitur Berhasil Di Update!');
    }


    public function destroy(Debitur $debitur)
    {
        // log Act
        $aksi = "(-) Hapus Data Debitur dengan Nomor Rekening: " . $debitur->no_rekening . " - An: " . $debitur->nama_nasabah;
        $this->logAct($aksi);

        $debitur->delete();
        return response()->json(['message' => 'Data Berhasil Di Hapus!']);
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
