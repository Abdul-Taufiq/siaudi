<?php

namespace App\Http\Controllers;

use App\Models\Lainnya;
use App\Models\LogActivity;
use Illuminate\Http\Request;

class LainnyaController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $data = Lainnya::orderBy('nama', 'ASC')->get();
            return DataTables()->of($data)
                ->addColumn('action', function ($data) {
                    $button = '<a data-toggle="modal" data-target="#modalEdit' . $data->id  . '" id="' . $data->id  . '"
                                            class="btn btn-warning btn-sm edit" data-kode_form="' . $data->nama . '">
                                            <i class="fa fa-edit"></i></a>';
                    $button .= '&nbsp;';
                    $button .= '<a data-toggle="modal" id="' . $data->id  . '"
                                            class="hapus btn btn-danger btn-sm delete-post ">
                                            <i class="fa fa-trash"></i></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('Page.Z Lainnya.lainnya', ['title' => 'Lainnya']);
    }



    public function store(Request $request)
    {
        $lainnya = Lainnya::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan
        ]);

        // log Act
        $aksi = "(+) Tambah Data Lainnya dengan Nama File: " . $lainnya->nama;
        $this->logAct($aksi);

        return redirect()->back()->with('AlertSuccess', 'Data Berhasil Disimpan!');
    }



    public function edit(Lainnya $lainnya)
    {
        return response()->json([
            'status' => 200,
            'data' => $lainnya
        ]);
    }


    public function update(Request $request, Lainnya $lainnya)
    {
        $lainnya->nama = $request->nama_edit;
        $lainnya->jabatan = $request->jabatan_edit;
        $lainnya->save();

        // log Act
        $aksi = "(u) Update Data Lainnya dengan Nama File: " . $lainnya->nama;
        $this->logAct($aksi);

        return redirect()->back()->with('AlertSuccess', 'Berhasil Diupdate!');
    }


    public function destroy(Lainnya $lainnya)
    {
        // log Act
        $aksi = "(-) Hapus data Lainnya dengan Nama : " . $lainnya->nama;
        $this->logAct($aksi);

        $lainnya->delete();
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
