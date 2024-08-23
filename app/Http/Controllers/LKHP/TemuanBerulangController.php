<?php

namespace App\Http\Controllers\LKHP;

use App\Http\Controllers\Controller;
use App\Models\LKHP\Pivot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class TemuanBerulangController extends Controller
{
    public function index(Request $request)
    {
        $id_cabang = $request->id_cabang;
        $min = $request->min;
        $max = $request->max;
        $objek_pemeriksaan = $request->objek_pemeriksaan;

        // Menggunakan tahun sebagai input
        $awal = Carbon::createFromDate($min, 1, 1)->startOfYear();
        $akhir = Carbon::createFromDate($max, 12, 31)->endOfYear();


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


        // if (!empty($min)) {
        //     if ($id_cabang == '99') {
        //         $data = Pivot::join('tb_event_risk as re', 'tb_pivot.id_event_risk', '=', 're.id_event_risk')
        //             ->join('tb_lkhp_final as lkhp', 'tb_pivot.id_lkhp_final', '=', 'lkhp.id_lkhp_final')
        //             ->join('cabang', 'lkhp.id_cabang', '=', 'cabang.id_cabang')
        //             ->where('lkhp.objek_pemeriksaan', '=', $objek_pemeriksaan)
        //             ->whereBetween('lkhp.created_at', [$awal, $akhir])
        //             ->select('tb_pivot.*', 're.kode_finding', 're.list_finding', 'lkhp.objek_pemeriksaan', 'cabang.cabang', 'lkhp.created_at')
        //             ->orderBy('re.kode_finding')
        //             ->get()
        //             ->groupBy('kode_finding'); // Kelompokkan berdasarkan kode_finding
        //     }
        //     // else
        //     else {
        //         $data = Pivot::join('tb_event_risk as re', 'tb_pivot.id_event_risk', '=', 're.id_event_risk')
        //             ->join('tb_lkhp_final as lkhp', 'tb_pivot.id_lkhp_final', '=', 'lkhp.id_lkhp_final')
        //             ->join('cabang', 'lkhp.id_cabang', '=', 'cabang.id_cabang')
        //             ->where('lkhp.objek_pemeriksaan', '=', $objek_pemeriksaan)
        //             ->where('lkhp.id_cabang', '=', $id_cabang)
        //             ->whereBetween('lkhp.created_at', [$awal, $akhir])
        //             ->select('tb_pivot.*', 're.kode_finding', 're.list_finding', 'lkhp.objek_pemeriksaan', 'cabang.cabang', 'lkhp.created_at')
        //             ->orderBy('re.kode_finding')
        //             ->get()
        //             ->groupBy('kode_finding'); // Kelompokkan berdasarkan kode_finding
        //     }
        // } else {
        //     $data = Pivot::join('tb_event_risk as re', 'tb_pivot.id_event_risk', '=', 're.id_event_risk')
        //         ->join('tb_lkhp_final as lkhp', 'tb_pivot.id_lkhp_final', '=', 'lkhp.id_lkhp_final')
        //         ->join('cabang', 'lkhp.id_cabang', '=', 'cabang.id_cabang')
        //         ->select('tb_pivot.*', 're.kode_finding', 're.list_finding', 'lkhp.objek_pemeriksaan', 'cabang.cabang', 'lkhp.created_at')
        //         ->orderBy('re.kode_finding')
        //         ->get()
        //         ->groupBy('kode_finding'); // Kelompokkan berdasarkan kode_finding
        // }


        // if (request()->ajax()) {
        //     return datatables()->of($data)
        //         ->addColumn('action', function ($items) {
        //             // Mengambil elemen pertama dari setiap grup untuk ditampilkan
        //             $firstItem = $items->first();
        //             $button = '<a href="' . route('temuan-berulang.show', $firstItem->id_lkhp_final) . '" 
        //             class="btn btn-sm btn-info">
        //                 <span class="icon text-white-50">
        //                     <i class="fa fa-eye"></i>
        //                 </span>
        //             </a>';
        //             return $button;
        //         })
        //         ->addColumn('kode_finding', function ($items) {
        //             return $items->first()->kode_finding . ' - ' . $items->first()->list_finding;
        //         })
        //         ->addColumn('list_finding', function ($items) {
        //             return $items->first()->list_finding;
        //         })
        //         ->addColumn('objek_pemeriksaan', function ($items) {
        //             return $items->first()->objek_pemeriksaan;
        //         })
        //         ->addColumn('cabang', function ($items) {
        //             return $items->first()->cabang;
        //         })
        //         ->addColumn('tahun_pemeriksaan', function ($items) {
        //             return $items->first()->created_at->translatedFormat('d F Y');
        //         })
        //         ->rawColumns(['action'])
        //         ->addIndexColumn()
        //         ->make(true);
        // }

        if (!empty($min)) {
            if ($objek_pemeriksaan == 'All') {
                # code...
                if ($id_cabang == '99') {
                    # code...
                    $data = Pivot::with(['lkhpFinal', 'riskEvent'])
                        ->get()
                        ->whereBetween('lkhpFinal.created_at', [$awal, $akhir])
                        ->groupBy('riskEvent.kode_finding');
                } else {
                    $data = Pivot::with(['lkhpFinal', 'riskEvent'])
                        ->get()
                        ->where('lkhpFinal.id_cabang', $id_cabang)
                        ->whereBetween('lkhpFinal.created_at', [$awal, $akhir])
                        ->groupBy('riskEvent.kode_finding');
                }
            } else {
                # code...
                if ($id_cabang == '99') {
                    # code...
                    $data = Pivot::with(['lkhpFinal', 'riskEvent'])
                        ->get()
                        ->where('lkhpFinal.objek_pemeriksaan', $objek_pemeriksaan)
                        ->whereBetween('lkhpFinal.created_at', [$awal, $akhir])
                        ->groupBy('riskEvent.kode_finding');
                } else {
                    $data = Pivot::with(['lkhpFinal', 'riskEvent'])
                        ->get()
                        ->where('lkhpFinal.objek_pemeriksaan', $objek_pemeriksaan)
                        ->where('lkhpFinal.id_cabang', $id_cabang)
                        ->whereBetween('lkhpFinal.created_at', [$awal, $akhir])
                        ->groupBy('riskEvent.kode_finding');
                }
            }
        } else {
            $data = Pivot::with(['lkhpFinal', 'riskEvent'])
                ->get()
                ->groupBy('riskEvent.kode_finding');
        }

        $formattedData = [];

        foreach ($data as $key => $group) {
            $firstItem = $group->first();
            $cabangList = $group->map(function ($item) {
                return '- ' . $item->lkhpFinal->cabang->cabang;
            })->unique()->implode('<br>');

            $tahunTemuanList = $group->map(function ($item) {
                return '- ' . $item->lkhpFinal->created_at->translatedFormat('d F Y');
            })->unique()->implode('<br>');

            $formattedData[] = [
                'kode_finding' => $firstItem->riskEvent->kode_finding . ' - ' . $firstItem->riskEvent->list_finding,
                'objek_pemeriksaan' => $firstItem->lkhpFinal->objek_pemeriksaan,
                'cabang' => $cabangList,
                'tahun_temuan' => $tahunTemuanList,
                'action' => '<a href="' . route('temuan-berulang.show', encrypt($firstItem->id_event_risk)) . '" class="btn btn-sm btn-info"><span class="icon text-white-50"><i class="fa fa-eye"></i></span></a>',
            ];
        }

        if (request()->ajax()) {
            return datatables()->of($formattedData)
                ->rawColumns(['cabang', 'tahun_temuan', 'action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('Page.Lkhp_Rekap.Temuan Berulang.index',  [
            'title' => 'Rekap Temuan Berulang'
        ]);
    }



    public function show($Id)
    {
        $ids = Crypt::decrypt($Id);
        $data = Pivot::with(['lkhpFinal', 'riskEvent'])
            ->where('id_event_risk', $ids)->get();

        foreach ($data as $items) {
            $re = $items->riskEvent->kode_finding . ' - ' . $items->riskEvent->list_finding;
        }

        return view('Page.Lkhp_Rekap.Temuan Berulang.show', compact('data', 're'), [
            'title' => 'Detail Temuan Berulang'
        ]);
    }
}
