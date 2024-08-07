<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cabang;
use Illuminate\Support\Facades\Hash;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function index()
    {
        $cabang = Cabang::all();
    	$data = User::all();
        // dd($data);
        return view ('user.user', compact('data', 'cabang'), [
            "title" => "Data User"
        ],
        [
            'data'=>$data
        ]);

        
    }


    public function create()
    {
        $cabang = Cabang::all();
        $now = Carbon::now();
        return view('debitur.add-debitur', compact('cabang'), [
            "title" => "Tambah Data User"
        ]);

    }


    public function edit(User $user)
    {
        $data = User::all();
        $cabang = Cabang::all();
        return view ('user.update-user', compact('user', 'data', 'cabang'), [
            "title" => "Edit User"
        ],
        [
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        // FORM VALIDASI
       $request->validate([
            'nama' => ['required', 'string', 'max:255', 'min:2'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,id'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
           // PESAN ERROR
            'nama.min' => 'Nama Minimal 2 Karakter!',
            'nama.max' => 'Nama Maksimal 255 Karakter!',
            'email.email' => 'Email Yang Anda Masukan Tidak Valid!',
            'email.unique' => 'Email Tidak Bisa Digunakan!',
            'password.min' => 'Password Minimal 8 Karakter!',
            'password.confirmed' => 'Konfirmasi Password Tidak Cocok!',
        ]);

        DB::table('users')->where('id', $id)
        ->update([
            'nama' => $request['nama'],
            'email' => $request['email'],
            'level' => $request['level'],
            'jabatan' => $request['jabatan'],
            'id_cabang' => $request['cabang'],
            // menggunakan enkripsi jenis BCrypt
            'password' => Hash::make($request['password']),
            'updated_at' => now(),
            // menggunakan md5
            // 'password' => md5($data['password']),
        ]);


        return redirect('user')->with('status', 'DATA USER BERHASIL DIUBAH!');
    }


    public function destroy($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect('user')->with('status', 'DATA USER BERHASIL DIHAPUS!');
    }

    public function profil()
    {
        return view('user.profile', [
            "title" => "My Profile"
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|max:5024',
        ], [
            // PESAN ERROR
            'gambar.image' => 'File Harus Berformat Gambar!',
            'gambar.max' => 'File Terlalu Besar! Maximal 5 MB',
        ]); 


        //mengambil data file yang diupload
        $gambar = $request->file('gambar');
        //mengambil nama file
        $fileName = $gambar->getClientOriginalName();
        //memindahkan file ke folder tujuan
        $gambar->move('file_upload/foto profil', $fileName);
        // $gambar->storeAs('file_upload',$gambar->getClientOriginalName());

        DB::table('users')->where('id', Auth::user()->id )
        ->update([
            'gambar' => $fileName,
            'updated_at' => now(),
        ]);

        return redirect('/home')->with('status', 'Foto Profil Berhasil Diubah!');
    }


}
