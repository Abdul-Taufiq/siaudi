<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LogActController extends Controller
{
    public function index(Request $request)
    {
        $jabatan = auth()->user()->jabatan;
        $username = auth()->user()->nama;
        $level = auth()->user()->level;
        $email = auth()->user()->email;
        $awal = Carbon::parse($request->min)->startOfDay();
        $akhir = Carbon::parse($request->max)->endOfDay();

        if (request()->ajax()) {
            if (!empty($request->min)) {
                $data = LogActivity::where('username', $username)
                    ->where('email', $email)
                    ->whereBetween('created_at', [$awal, $akhir])
                    ->orderBy('created_at', 'desc')->get();
            } else {
                $data = LogActivity::where('username', $username)
                    ->where('email', $email)
                    ->orderBy('created_at', 'desc')->get();
            }

            return DataTables()->of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('Page.Log.index_activity', ['title' => 'Log Aktifitas User']);
    }
}
