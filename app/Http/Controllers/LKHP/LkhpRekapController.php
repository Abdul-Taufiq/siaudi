<?php

namespace App\Http\Controllers\LKHP;

use App\Http\Controllers\Controller;
use App\Models\Debitur\Debitur;
use App\Models\LKHP\Konsolidasi;
use App\Models\LKHP\Lkhp;
use App\Models\LKHP\LkhpFinal;
use App\Models\LKHP\Pivot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LkhpRekapController extends Controller
{
    public function index(Request $request)
    {
        $data = Konsolidasi::orderBy('created_at', 'DESC')->get();
        return view('Page.Potensi_Kerugian.Konsolidasi.index', compact('data'), ['title' => 'Potensi Kerugian (Konsolidasi)']);
    }

    public function store(Request $request)
    {
        $periode = Carbon::createFromDate($request->periode_pemeriksaan, 1, 1)->startOfYear();

        $data = new Konsolidasi;
        $data->periode_pemeriksaan = $periode;
        $data->total_noa = $request->total_noa;
        $data->total_plafon = str_replace(['Rp. ', '.'], '', $request->total_plafon);
        $data->total_bd = str_replace(['Rp. ', '.'], '', $request->total_bd);
        $data->save();

        return redirect('potensi-loss-konsolidasi')->with('AlertSuccess', 'Berhasil Disimpan!');
    }


    public function edit($id)
    {
        $data = Konsolidasi::find($id);
        return response()->json([
            'data' => $data
        ]);
    }


    public function update(Request $request, $id)
    {
        $periode = Carbon::createFromDate($request->periode_pemeriksaan_edit, 1, 1)->startOfYear();
        $data = Konsolidasi::find($id);
        $data->update([
            'periode_pemeriksaan' => $periode,
            'total_noa' => $request->total_noa_edit,
            'total_plafon' => str_replace(['Rp. ', '.'], '', $request->total_plafon_edit),
            'total_bd' => str_replace(['Rp. ', '.'], '', $request->total_bd_edit),
        ]);

        return redirect('potensi-loss-konsolidasi')->with('AlertSuccess', 'Berhasil Disimpan!');
    }


    public function TotalRekap(Request $request)
    {
        $min = $request->min;
        $max = $request->max;
        $objek_pemeriksaan = $request->objek_pemeriksaan;
        $reqCabang = $request->id_cabang;

        // $min = 2023;
        // $max = 2024;
        // $objek_pemeriksaan = "Kredit";
        // $reqCabang = 02;

        // Cek apakah input hanya berupa tahun
        // strlen memeriksa bahwa panjang karakter adalah 4 yang merujuk ke tahun
        if ($min == '' || $max == '') {
            # code...
            if ($objek_pemeriksaan == 'All') {
                if ($reqCabang == '99') {
                    # code...
                    $data = LkhpFinal::orderBy('created_at', 'desc')->get();
                } else {
                    # code...
                    $data = LkhpFinal::where('id_cabang', $reqCabang)
                        ->orderBy('created_at', 'desc')->get();
                }
            } else {
                if ($reqCabang == '99') {
                    # code...
                    $data = LkhpFinal::where('objek_pemeriksaan', $objek_pemeriksaan)
                        ->orderBy('created_at', 'desc')->get();
                } else {
                    $data = LkhpFinal::where('id_cabang', $reqCabang)
                        ->where('objek_pemeriksaan', $objek_pemeriksaan)
                        ->orderBy('created_at', 'asc')->get();
                }
            }
        } else {
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
                        ->orderBy('created_at', 'asc')->get();
                }
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


    public function show($Id)
    {
        $ids = Crypt::decrypt($Id);
        $lkhp = LkhpFinal::with(['pivot'])
            ->with('pivot.kkpk')
            ->with('pivot.kkpk.debitur')
            ->with('pivot.riskEvent')
            ->where('id_lkhp_final', $ids)->first();

        // DEBITUR
        $total_plafon = 0; // Inisialisasi variabel untuk total plafon
        $total_baki_debet = 0; // Inisialisasi variabel untuk total baki_debet
        foreach ($lkhp->pivot as $pivot) {
            $plafon = $pivot->kkpk->debitur->plafon;
            $baki_debet = $pivot->kkpk->debitur->baki_debet;
            $total_plafon += $plafon; // Tambahkan plafon debitur ke total plafon
            $total_baki_debet += $baki_debet; // Tambahkan plafon debitur ke total plafon

            $riskEvent = $pivot->riskEvent;
        }
        // Menghitung total NOA dengan mengelompokkan berdasarkan id_kkpk yang unik
        $total_noa = $lkhp->pivot->groupBy('id_kkpk')->count();

        return view(
            'Page.Lkhp_Rekap.show-kredit',
            compact('lkhp', 'total_plafon', 'total_noa', 'total_baki_debet', 'riskEvent'),
            ['title' => 'Show Rekap ' . $lkhp->no_lkhp]
        );
    }



    // POTENSI KERUGIAN CONTROLLER

    public function PotensiLossIndex(Request $request)
    {
        return view('Page.Potensi_Kerugian.index', ['title' => 'Potensi Kerugian']);
    }


    public function PotensiLossShow($min, $max, $id_cabang, $objek_pemeriksaan)
    {
        switch ($id_cabang) {
            case '99':
                $cabang = 'All Cabang';
                break;

            case '0':
                $cabang = 'Kantor Pusat Management';
                break;

            case '1':
                $cabang = 'Kantor Pusat Operasional';
                break;

            case '2':
                $cabang = 'KC Temanggung';
                break;

            case '3':
                $cabang = 'KC Wonosobo';
                break;

            case '4':
                $cabang = 'KC Ambarawa';
                break;

            case '5':
                $cabang = 'KC Semarang';
                break;

            case '6':
                $cabang = 'KC Mranggen';
                break;

            case '7':
                $cabang = 'KC Sukorejo';
                break;

            case '8':
                $cabang = 'KC Weleri';
                break;

            case '9':
                $cabang = 'KC Delanggu';
                break;

            case '10':
                $cabang = 'KC Gombong';
                break;

            case '11':
                $cabang = 'KC Sokaraja';
                break;
        }

        // Pengecekan apakah $min atau $max adalah null
        if ($min == 'null' || $max == 'null') {
            // Kondisi tanpa menggunakan tanggal
            if ($id_cabang == '99') {
                // Filter berdasarkan objek pemeriksaan saja
                $data = LkhpFinal::where('objek_pemeriksaan', $objek_pemeriksaan)
                    ->orderBy('created_at', 'desc')
                    ->get();
                $debitur = Debitur::all();
            } else {
                // Filter berdasarkan id_cabang dan objek pemeriksaan
                $data = LkhpFinal::where('id_cabang', $id_cabang)
                    ->where('objek_pemeriksaan', $objek_pemeriksaan)
                    ->orderBy('created_at', 'asc')
                    ->get();
                $debitur = Debitur::where('id_cabang', $id_cabang)->get();
            }
        } else {
            // Kondisi dengan menggunakan tanggal
            if (strlen($min) == 4 && strlen($max) == 4) {
                // Menggunakan tahun sebagai input
                $awal = Carbon::createFromDate($min, 1, 1)->startOfYear();
                $akhir = Carbon::createFromDate($max, 12, 31)->endOfYear();
            } else {
                // Menggunakan format tanggal lainnya
                $awal = Carbon::parse($min)->startOfDay();
                $akhir = Carbon::parse($max)->endOfDay();
            }

            if ($id_cabang == '99') {
                // Filter berdasarkan objek pemeriksaan saja, dengan tanggal
                $data = LkhpFinal::whereBetween('created_at', [$awal, $akhir])
                    ->where('objek_pemeriksaan', $objek_pemeriksaan)
                    ->orderBy('created_at', 'desc')
                    ->get();
                $debitur = Debitur::whereBetween('created_at', [$awal, $akhir])->get();
            } else {
                // Filter berdasarkan id_cabang dan objek pemeriksaan, dengan tanggal
                $data = LkhpFinal::whereBetween('created_at', [$awal, $akhir])
                    ->where('id_cabang', $id_cabang)
                    ->where('objek_pemeriksaan', $objek_pemeriksaan)
                    ->orderBy('created_at', 'asc')
                    ->get();
                $debitur = Debitur::whereBetween('created_at', [$awal, $akhir])->where('id_cabang', $id_cabang)->get();
            }
        }

        // return $data;
        if ($data->isNotEmpty()) {

            if ($objek_pemeriksaan  == 'Kredit') {
                # code...
                $total_noa = 0; // count data untuk semua
                $total_plafon = 0; // Inisialisasi variabel untuk total plafon
                $total_baki_debet = 0; // Inisialisasi variabel untuk total baki_debet

                foreach ($data as $item) {
                    // echo "NOLKHP: " . $item->no_lkhp . '<br>';
                    $periode = $item->tgl_awal->format('d') . ' s/d ' . $item->tgl_akhir->isoFormat('d MMMM Y');

                    $pivot = Pivot::with('kkpk.debitur')
                        ->where('id_lkhp_final', $item->id_lkhp_final)->groupBy('id_event_risk')->get();

                    $total_noa += $pivot->count();

                    foreach ($pivot as $kkpk) {
                        $plafon = $kkpk->kkpk->debitur->plafon;
                        $baki_debet = $kkpk->kkpk->debitur->baki_debet;
                        $total_plafon += $plafon; // Tambahkan plafon debitur ke total plafon
                        $total_baki_debet += $baki_debet; // Tambahkan plafon debitur ke total plafon
                    }

                    // echo "Periode: " .  $periode . '<br>';
                    // echo "Total: " . $total_noa . '<br>';
                }
                // echo "count: " . $total_noa  . '<br>';

                // Total Persentasi Potensi Loss
                $totaldebitur = $debitur->count();
                $debitur_bd = 0;
                foreach ($debitur as $item) {
                    $debitur_bd += $item->baki_debet;
                }

                // $persentase = $total_baki_debet / $debitur_bd * 100;
                // $persentaseLoss = round($persentase, 2);

                // for KOnsolidasi
                if ($id_cabang == '99') {
                    $kons = Konsolidasi::whereBetween('periode_pemeriksaan', [$awal, $akhir])->first();
                    $totaldebitur = $kons->total_noa;
                    $total_plafon = $kons->total_plafon;
                    $total_baki_debet = $kons->total_bd;

                    return view(
                        'Page.Potensi_Kerugian.Konsolidasi.show',
                        compact(
                            'data',
                            'totaldebitur',
                            'debitur_bd',
                            'cabang',
                            'total_plafon',
                            'total_baki_debet',
                            'total_noa',
                            'periode',
                        )
                    );
                }
                // for standard
                else {
                    return view(
                        'Page.Potensi_Kerugian.show',
                        compact(
                            'data',
                            'totaldebitur',
                            'debitur_bd',
                            'cabang',
                            'total_plafon',
                            'total_baki_debet',
                            'total_noa',
                            'periode',
                        )
                    );
                }
            } else {
                $total_noa = 0; // count data untuk semua

                foreach ($data as $item) {
                    // echo "NOLKHP: " . $item->no_lkhp . '<br>';
                    $periode = $item->tgl_awal->format('d') . ' s/d ' . $item->tgl_akhir->isoFormat('D MMMM Y');

                    $total_noa += $item->pivot->groupBy('id_lkhp')->count();
                }

                return view(
                    'Page.Potensi_Kerugian.show_ops',
                    compact(
                        'cabang',
                        'total_noa',
                        'periode',
                        'data'
                    )
                );
            }
        } else {
            return "Tidak Ada Data!";
        }
    }
}
