<?php

namespace App\Http\Controllers;

use App\Imports\ImportEmployee;
use App\Models\Employee;
use App\Models\Example2;
use DOMDocument;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //file disimpan ke server
        // $data = $request->file('excel');
        // $namaFile = $data->getClientOriginalName();
        // $data->move('EmployeeFile', $namaFile);

        // Excel::import(new ImportEmployee, \public_path('/EmployeeFile/' . $namaFile)); //file disimpan ke server

        // Excel::import(new ImportEmployee, request()->file('excel')); // langsung tanpa simpan file ke server
        // Excel::import(new ImportEmployee,  request()->file('excel'), 'model', null, \Maatwebsite\Excel\Excel::XLSX, [
        //     'date_format' => 'd/m/Y',
        // ]);

        $jam = $request->jam;
        $dom = new DOMDocument();
        $dom->loadHTML($jam, 9);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key => $img) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = '/upload/img/' . time() . $key . 'png';
            file_put_contents(public_path() . $image_name, $data);

            $img->removeAttribute('src');
            $img->setAttribute('src', $image_name);
        }
        $jam = $dom->saveHTML();

        Example2::create([
            'mapel' => $request->mapel,
            'nama_guru' => $request->nama_guru,
            'jam' => $jam,
        ]);

        return redirect()->back();
    }




    public function show(Employee $employee)
    {
        //
    }


    public function edit(Employee $employee)
    {
        //
    }


    public function update(Request $request, Employee $employee)
    {
        //
    }


    public function destroy(Employee $employee)
    {
        //
    }
}
