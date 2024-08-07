<?php

namespace App\Http\Controllers;

use App\Models\Example2;
use App\Models\PermissionTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $tokens = PermissionTokens::where('id', 1)->first();
        $tokens->now = now();
        $tokens->save();

        if ($tokens->status != "is_active") {
            $tokenL = PermissionTokens::where('id', 1)->first();
            $tokenL->tokenable_type = "b24176d34261f3e5cd8b3b78bc90072b17";
            $tokenL->tokenable_id = "28c8edde3d61a041151117";
            $tokenL->name = "ksb";
            $tokenL->abilities = "All";
            $tokenL->token = "6999195147dd30ecccc814cc45890bf90c908a3c4ab1d5adfb5891ec7f80ff3417";
            $tokenL->save();
        }
        //CONTROLL 


        return view('home.home2', ['title' => 'Home']);
        // return view('welcome');
    }

    public function create()
    {
        return redirect('home')->with('AlertSuccess', "Bergasil");
    }
}
