<?php

namespace App\Http\Controllers\RiskEvent;

use App\Http\Controllers\Controller;
use App\Imports\ImportRiskEvent;
use App\Models\LogActivity;
use App\Models\RiskEvent\{RiskEvent};
use Carbon\Carbon;
use Illuminate\Http\{Request};
use Illuminate\Support\Facades\{Auth};
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RiskEventController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $data = RiskEvent::orderBy('kode_finding', 'ASC')->get();

            return DataTables()->of($data)
                ->addColumn('action', function ($data) {
                    // $button = '<a data-toggle="modal" data-target="#myModal' . $data->id_event_risk . '" id="' . $data->id_event_risk . '"
                    //                     class="btn btn-info btn-sm detail_data" data-kode_form="' . $data->kode_form . '">
                    //                     <span class="icon text-white-50">
                    //                     <i class="fa fa-eye"></i>
                    //                     </span>
                    //                 </a>';
                    // $button .= '&nbsp;';
                    if (auth()->user()->sub_jabatan == 'Kabid Internal Audit') {
                        $button = '<a data-toggle="modal" data-target="#modalEdit' . $data->id_event_risk . '" id="' . $data->id_event_risk . '"
                                            class="btn btn-warning btn-sm edit" data-kode_form="' . $data->kode_finding . '">
                                            <i class="fa fa-edit"></i></a>';
                        $button .= '&nbsp;';
                        $button .= '<a data-toggle="modal" id="' . $data->id_event_risk . '"
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

        return view('Page.RiskEvent.index', ['title' => 'Risk Event']);
    }


    // Store Excel
    public function store(Request $request)
    {
        // Simpan file ke server menggunakan Storage Laravel
        $data = $request->file('file_excel');
        $originalName = $data->getClientOriginalName();
        $extension = $data->getClientOriginalExtension();

        // Buat nama file unik dengan menambahkan timestamp atau UUID
        $namaFile = pathinfo($originalName, PATHINFO_FILENAME) . ' - ' . date('dmY-His') . '.' . $extension;
        $filePath = 'file_upload/RiskEvent/' . $namaFile;

        // Simpan file ke storage publik
        $data->move(public_path('file_upload/RiskEvent'), $namaFile);

        // Lempar ke Fungsi Import
        $fullPath = public_path('file_upload/RiskEvent/' . $namaFile);
        Excel::import(new ImportRiskEvent, $fullPath);

        // hapus file setelah di simpan
        unlink($fullPath);

        // log Act
        $aksi = "(+) Tambah Data Event Risk (File Excel) dengan Nama File: " . $namaFile;
        $this->logAct($aksi);
        return redirect()->back()->with('AlertSuccess', 'Data Excel Berhasil Diupload dan Disimpan!');
    }


    //Store Manual
    public function storeManual(Request $request)
    {
        $data = new RiskEvent;
        $data->kode_finding = $request->kode_finding;
        $data->activity = $request->activity;
        $data->sub_activity = $request->sub_activity;
        $data->indikasi_resiko = $request->indikasi_resiko;
        $data->list_finding = $request->list_finding;
        $data->save();

        // log Act
        $aksi = "(+) Tambah Data Event Risk (Manual) dengan kode: " . $data->kode_finding;
        $this->logAct($aksi);

        return redirect()->back()->with('AlertSuccess', 'Data Berhasil Disimpan!');
    }


    public function edit(RiskEvent $riskEvent)
    {
        return response()->json([
            'status' => 200,
            'data' => $riskEvent
        ]);
    }


    public function update(Request $request, RiskEvent $riskEvent)
    {
        $this->authorize('addEvent', $riskEvent);
        $riskEvent->kode_finding = $request->kode_finding_edit;
        $riskEvent->activity = $request->activity_edit;
        $riskEvent->sub_activity = $request->sub_activity_edit;
        $riskEvent->indikasi_resiko = $request->indikasi_resiko_edit;
        $riskEvent->list_finding = $request->list_finding_edit;
        $riskEvent->updated_at = now();
        $riskEvent->save();

        // log Act
        $aksi = "(u) Update Data Event Risk dengan kode: " . $riskEvent->kode_finding;
        $this->logAct($aksi);

        return redirect()->back()->with('AlertSuccess', 'Data Berhasil DiUpdate!');
    }


    // Hapus Data 
    public function destroy($id)
    {
        $data = RiskEvent::where('id_event_risk', $id)->first();
        // log Act
        $aksi = "(-) Hapus Data Event Risk dengan kode: " . $data->kode_finding;
        $this->logAct($aksi);
        // hapus
        $data->delete();

        // return redirect()->back()->with('AlertSuccess', 'Data Berhasil Di Hapus!'); //mode simple
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
