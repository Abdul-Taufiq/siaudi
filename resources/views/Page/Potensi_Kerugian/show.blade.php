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
            font-size: 12px;
        }

        table td {
            vertical-align: top;
        }

        .border {
            width: 100%;
            border: 1px solid #ddd;
        }

        .border th {
            text-align: center;
            border: 1px solid #ddd;
        }

        .border td {
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>
    {{-- Header --}}
    <div class="card card-outline card-primary">
        <div class="card-header">
            Potensi Kerugian
        </div>
        <div class="card-body">
            <table style="width: 100%">
                <tr>
                    <td style="width: 50%">
                        <table style="width: 100%">
                            <tr>
                                <th style="width: 40%">Kantor Cabang</th>
                                <td style="width: 2%">:</td>
                                <td>{{ $cabang }}</td>
                            </tr>
                            <tr>
                                <th>Total NOA Cabang</th>
                                <td>:</td>
                                <td>{{ $totaldebitur }}</td>
                            </tr>
                            <tr>
                                <th>Periode Pemeriksaan</th>
                                <td>:</td>
                                <td>{{ $periode }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Pemeriksaan</th>
                                <td>:</td>
                                <td>Kredit</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 50%">
                        <table style="width: 100%">
                            <tr>
                                <th style="width: 40%">Total NOA Risk Event</th>
                                <td style="width: 2%">:</td>
                                <td>{{ $total_noa }}</td>
                            </tr>
                            <tr>
                                <th>Total Plafon</th>
                                <td>:</td>
                                <td>
                                    {{ $total_plafon ? 'Rp ' . number_format($total_plafon, 0, ',', '.') : 'belum ada data' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Total Baki Debet</th>
                                <td>:</td>
                                <td>
                                    {{ $total_baki_debet ? 'Rp ' . number_format($total_baki_debet, 0, ',', '.') : 'belum ada data' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Total Baki Debet Cabang</th>
                                <td>:</td>
                                <td>
                                    {{ $debitur_bd ? 'Rp ' . number_format($debitur_bd, 0, ',', '.') : 'belum ada data' }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    </td>
                </tr>
            </table>

            <br>

            {{-- re --}}
            <table class="border">
                <thead style="background-color: lightseagreen">
                    <tr>
                        <th style="width: 3%">#</th>
                        <th style="width: 50%">Risk Event</th>
                        <th style="width: 15%">Total NOA</th>
                        <th style="width: 15%">Total BD</th>
                        <th style="width: 15%">Potensi Kerugian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            @php
                                $displayedFindings = []; // Array untuk menyimpan kode_finding yang sudah ditampilkan
                                $total_bd = 0;
                            @endphp
                            @foreach ($item->pivot as $pivot)
                                @if (!in_array($pivot->riskEvent->kode_finding, $displayedFindings))
                                    <td style="padding-bottom: 10px;">
                                        {{ $pivot->riskEvent->kode_finding }} -
                                        {{ $pivot->riskEvent->list_finding }} - <i>Tingkat Risiko:</i>
                                        <b><i>{{ $pivot->riskEvent->indikasi_resiko }}</i></b>
                                    </td>
                                    @php
                                        $baki_debet = $pivot->kkpk->debitur->baki_debet;
                                        $total_bd += $baki_debet; // Tambahkan plafon debitur ke total plafon
                                        $displayedFindings[] = $pivot->riskEvent->kode_finding; // Tambahkan kode_finding ke array
                                    @endphp
                                    <td>{{ $item->pivot->groupBy('id_kkpk')->count() }}</td>
                                    <td>
                                        {{ $total_bd ? 'Rp ' . number_format($total_bd, 0, ',', '.') : 'belum ada data' }}
                                    </td>
                                    <td>
                                        {{ number_format(($total_bd / $debitur_bd) * 100, 2, ',', '.') . ' %' }}
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card card-outline card-primary mb-0"></div>
    </div>

</body>

</html>
