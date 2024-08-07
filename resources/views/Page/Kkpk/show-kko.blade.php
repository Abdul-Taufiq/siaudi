<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        body {
            font-family: 'JetBrains Mono';
            font-size: 9pt;
        }
    </style>
</head>

<body>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h4><b>LEMBAR KERJA KUNJUNGAN DEBITUR &rarr;</b></h4>
        </div>
        <div class="card-body">
            <div class="row ml-2">
                <div class="col-md-12">
                    <b>Tanggal Kunjungan :</b>
                    {{ $data != null ? $data->tgl_kunjungan->translatedFormat('d F Y') : 'Belum Ada Data Kunjungan' }}
                </div>
                <div class="col-md-6">
                    <table style="width: 100%;" class="table table-striped">
                        <tr>
                            <th>Nama Debitur</th>
                            <td>{{ $kkpk->debitur->nama_nasabah }}</td>
                        </tr>
                        <tr>
                            <th>No Rekening</th>
                            <td>{{ $kkpk->debitur->no_rekening }}</td>
                        </tr>
                        <tr>
                            <th>Tgl Realisasi</th>
                            <td>{{ $kkpk->debitur->tgl_realisasi->translatedFormat('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Plafon</th>
                            <td>
                                {{ $kkpk->debitur->plafon ? 'Rp ' . number_format($kkpk->debitur->plafon, 0, ',', '.') : 'belum ada data' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Jenis Kredit</th>
                            <td>{{ $kkpk->jns_kredit }}</td>
                        </tr>
                        <tr>
                            <th>Alamat Debitur</th>
                            <td>{{ $kkpk->debitur->alamat }}</td>
                        </tr>
                        <tr>
                            <th>Data Jaminan</th>
                            <td>{!! $kkpk->debitur->jaminan !!}</td>
                        </tr>
                        <tr>
                            <th>Alamat Jaminan</th>
                            <td>{{ $kkpk->debitur->alamat_jaminan }}</td>
                        </tr>
                        <tr>
                            <th>Tujuan Pinjaman</th>
                            <td>{!! $kkpk->debitur->tujuan_kredit !!}</td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <table style="width: 100%;" class="table table-striped">
                        <tr>
                            <th>Status (Kol/DPD)</th>
                            <td>{{ $kkpk->debitur->kol . '/' . $kkpk->debitur->dpd }}</td>
                        </tr>
                        <tr>
                            <th>JKW</th>
                            <td>{{ $kkpk->debitur->jkw }}</td>
                        </tr>
                        <tr>
                            <th>Tgl Jatuh Tempo</th>
                            <td>{{ $kkpk->debitur->tgl_jth_tempo->translatedFormat('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Baki Debet</th>
                            <td>
                                {{ $kkpk->debitur->baki_debet ? 'Rp ' . number_format($kkpk->debitur->baki_debet, 0, ',', '.') : 'belum ada data' }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card card-outline card-primary mb-0"></div>
    </div>


    {{-- pemutus kredit --}}
    <div class="card card-outline card-success">
        <div class="card-header">
            <h6><b>Deskripsi &rarr;</b></h6>
        </div>
        <div class="card-body">
            <div class="ml-4">
                {!! $data != null ? $data->deskripsi : 'Belum Ada Data Kunjungan' !!}
            </div>
        </div>
        <div class="card card-outline card-success mb-0"></div>
    </div>

</body>

</html>
