<?php

namespace App\Http\Controllers\LKHP;

use App\Http\Controllers\Controller;
use App\Models\Lkhp\Lkhp;
use App\Models\Lkhp\LkhpFinal;
use App\Models\LKHP\Pivot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LkhpRekapController extends Controller
{
    public function index(Request $request)
    {
        // Tangkap tanggal awal dan akhir dari request
        $min = $request->min;
        $max = $request->max;

        // Cek apakah input hanya berupa tahun
        // strlen memeriksa bahwa panjang karakter adalah 4 yang merujuk ke tahun
        if (strlen($min) == 4 && strlen($max) == 4) {
            $awal = Carbon::createFromDate($min, 1, 1)->startOfYear();
            $akhir = Carbon::createFromDate($max, 12, 31)->endOfYear();
        } else {
            $awal = Carbon::parse($min)->startOfDay();
            $akhir = Carbon::parse($max)->endOfDay();
        }
        $objek_pemeriksaan = $request->objek_pemeriksaan;
        $reqCabang = $request->id_cabang;

        // Debugging
        // Log::info('Awal: ' . $awal->toDateTimeString());
        // Log::info('Akhir: ' . $akhir->toDateTimeString());


        $id_cabang = auth()->user()->id_cabang;
        $level = auth()->user()->level;

        if (request()->ajax()) {
            if (!empty($request->min)  && !empty($request->max)) {
                // Enable query logging
                // DB::enableQueryLog();
                // Mengambil log query
                // $queryLog = DB::getQueryLog();
                // Output log
                // print_r($queryLog);

                if ($objek_pemeriksaan == 'All') {
                    if ($reqCabang == '99') {
                        # code...
                        $data = LkhpFinal::whereBetween('created_at', [$awal, $akhir])
                            ->orderBy('created_at', 'desc')->get();
                    } else {
                        # code...
                        $data = LkhpFinal::whereBetween('created_at', [$awal, $akhir])
                            ->where('id_cabang', $reqCabang)
                            ->orderBy('created_at', 'desc')->get();
                    }
                } else {
                    if ($reqCabang == '99') {
                        # code...
                        $data = LkhpFinal::whereBetween('created_at', [$awal, $akhir])
                            ->where('objek_pemeriksaan', $objek_pemeriksaan)
                            ->orderBy('created_at', 'desc')->get();
                    } else {
                        $data = LkhpFinal::whereBetween('created_at', [$awal, $akhir])
                            ->where('id_cabang', $reqCabang)
                            ->where('objek_pemeriksaan', $objek_pemeriksaan)
                            ->orderBy('created_at', 'desc')->get();
                    }
                }


                // Debugging
                Log::info('Data Count: ' . $data->count());
                foreach ($data as $item) {
                    Log::info('Data created_at: ' . $item->created_at);
                }
            } else {
                $data = LkhpFinal::orderBy('created_at', 'desc')->get();
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
                        if (auth()->user()->sub_jabatan == 'Kabid Internal Audit' || auth()->user()->nama == $data->nama_creator) {
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
                        if (auth()->user()->sub_jabatan == 'Kabid Internal Audit' || auth()->user()->nama == $data->nama_creator) {
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
                    }
                    return $button;
                })

                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        // $data = LkhpFinal::all();


        return view('Page.Lkhp_Rekap.index', ['title' => 'Rekap Lembar Konfirmasi (LKHP)']);
    }



    public function TotalRekap(Request $request)
    {
        // $min = $request->min;
        // $max = $request->max;
        // $objek_pemeriksaan = $request->objek_pemeriksaan;
        // $reqCabang = $request->id_cabang;

        $min = 2023;
        $max = 2024;
        $objek_pemeriksaan = "Kredit";
        $reqCabang = 02;

        // Cek apakah input hanya berupa tahun
        // strlen memeriksa bahwa panjang karakter adalah 4 yang merujuk ke tahun
        if (strlen($min) == 4 && strlen($max) == 4) {
            $awal = Carbon::createFromDate($min, 1, 1)->startOfYear();
            $akhir = Carbon::createFromDate($max, 12, 31)->endOfYear();
        } else {
            $awal = Carbon::parse($min)->startOfDay();
            $akhir = Carbon::parse($max)->endOfDay();
        }

        if ($objek_pemeriksaan == 'All') {
            if ($reqCabang == '99') {
                # code...
                $data = LkhpFinal::whereBetween('created_at', [$awal, $akhir])
                    ->whereHas('pivot', function ($query) {
                        $query->whereNotNull('id_lkhp_final');
                    })
                    ->with(['pivot.riskEvent'])
                    ->with(['pivot.kkpk'])
                    ->orderBy('created_at', 'desc')->get();
            } else {
                # code...
                $data = LkhpFinal::whereBetween('created_at', [$awal, $akhir])
                    ->where('id_cabang', $reqCabang)
                    ->whereHas('pivot', function ($query) {
                        $query->whereNotNull('id_lkhp_final');
                    })
                    ->with(['pivot.riskEvent'])
                    ->with(['pivot.kkpk'])
                    ->orderBy('created_at', 'desc')->get();
            }
        } else {
            if ($reqCabang == '99') {
                # code...
                $data = LkhpFinal::whereBetween('created_at', [$awal, $akhir])
                    ->where('objek_pemeriksaan', $objek_pemeriksaan)
                    ->whereHas('pivot', function ($query) {
                        $query->whereNotNull('id_lkhp_final');
                    })
                    ->with(['pivot.riskEvent'])
                    ->with(['pivot.kkpk'])
                    ->orderBy('created_at', 'desc')->get();
            } else {
                $data = LkhpFinal::whereBetween('created_at', [$awal, $akhir])
                    ->where('id_cabang', $reqCabang)
                    ->where('objek_pemeriksaan', $objek_pemeriksaan)
                    ->orderBy('created_at', 'asc')->get();
            }
        }

        // dd($data);


        // return response()->json([
        //     'status' => 200,
        //     'data' => $data
        // ]);

        foreach ($data as $item) {
            echo "<br>========================== <br>";
            echo "No Lkhp: " . $item->no_lkhp . "<br>";
            echo "========================== <br>";
            // echo "Keterangan : " . $item->pivot->keterangan_re . "<br>";

            $pivot = Pivot::where('id_lkhp_final', $item->id_lkhp_final)
                ->get();

            $total_plafon = 0; // Inisialisasi variabel untuk total plafon
            $total_baki_debet = 0; // Inisialisasi variabel untuk total baki_debet

            foreach ($pivot as $itemPivot) {
                $plafon = $itemPivot->kkpk->debitur->plafon;
                $baki_debet = $itemPivot->kkpk->debitur->baki_debet;
                $total_plafon += $plafon; // Tambahkan plafon debitur ke total plafon
                $total_baki_debet += $baki_debet; // Tambahkan plafon debitur ke total plafon

                echo "++<br>";
                echo "Kode KKPK : " .  $itemPivot->kkpk->kode_kkpk . "<br>";
                echo "Kode Risk Event : " .  $itemPivot->riskEvent->kode_finding . "<br>";
                echo "Nama Debitur : " . $itemPivot->kkpk->debitur->nama_nasabah . "<br>";
                echo "Plafon : " . $itemPivot->kkpk->debitur->plafon . "<br>";
                echo "BD : " . $itemPivot->kkpk->debitur->baki_debet . "<br><br>";

                echo "<br>";
            }

            echo "Total Plafon: " . $total_plafon . "<br>";
            echo "Total BD: " . $total_baki_debet . "<br>";
        }
    }



    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Lkhp $lkhp)
    {
        //
    }


    public function edit(Lkhp $lkhp)
    {
        //
    }


    public function update(Request $request, Lkhp $lkhp)
    {
        //
    }


    public function destroy(Lkhp $lkhp)
    {
        //
    }
}
