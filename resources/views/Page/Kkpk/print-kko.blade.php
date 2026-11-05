<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="icon" href="{{ public_path('img/icon_logo.png') }}">
    <style>
        body {
            margin: 10mm 0mm 5mm 5mm;
            font-family: 'JetBrains Mono';
            text-align: justify;
            font-size: 9pt;
            line-height: 1.2;
            letter-spacing: 0.6px;
            word-spacing: 1px;
        }

        table {
            border-collapse: collapse;
            vertical-align: top;
            text-align: justify;
            page-break-before: auto;
            page-break-after: auto;
            page-break-inside: always;
        }

        .table_underline tr {
            border-bottom: 1px solid black;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .deskripsi {
            page-break-before: auto;
            page-break-after: auto;
            page-break-inside: always;
        }

        @page {
            margin: 100px 25px;
        }

        header {
            position: fixed;
            top: -50px;
            left: 10px;
            right: 0px;
            /* background-color: lightblue; */
            height: 50px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            background-color: lightblue;
            height: 50px;
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%; margin-top: -8px">
            <tr>
                <td style="width: 25%">
                    <img style="width: 60px; height: 60px;"
                        src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/img/icon_logo.png'))) }}">
                </td>
                <td style="width: 50%; text-align: center; "></td>
                <td style="width: 25%">&nbsp;</td>
            </tr>
        </table>
    </header>

    <div class="card card-outline card-primary">
        <div class="card-header">
            <h6 class="header">LEMBAR KERJA KUNJUNGAN DEBITUR</h6>
        </div>
        <div class="card-body">
            <b>Tanggal Kunjungan :</b> {{ $kkpk->kko->tgl_kunjungan->translatedFormat('d F Y') }}
            <hr>
            <table style="width: 100%" class="table table-borderless">
                <tbody>
                    <tr>
                        <td style="width: 50%; padding:0%;">
                            <table class="table_underline table-sm">
                                <tbody>
                                    <tr>
                                        <th style="width: 30%">Nama Debitur</th>
                                        <td style="width: 70%">{{ $kkpk->debitur->nama_nasabah }}</td>
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
                                        <td>{!! $kkpk->debitur->alamat !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Data Jaminan</th>
                                        <td>{!! $kkpk->debitur->jaminan !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Jaminan</th>
                                        <td>{!! $kkpk->debitur->alamat_jaminan !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Tujuan Pinjaman</th>
                                        <td>{!! $kkpk->debitur->tujuan_kredit !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td>&nbsp;</td>
                        <td style="width: 50%; padding:0%;">
                            <table class="table_underline table-sm">
                                <tr>
                                    <th style="width: 20%">Status (Kol/DPD)</th>
                                    <td style="width: 80%">
                                        {{ $kkpk->debitur->kol . '/' . $kkpk->debitur->dpd }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>JKW</th>
                                    <td>{{ $kkpk->debitur->jkw }}</td>
                                </tr>
                                <tr>
                                    <th>Tgl Jatuh Tempo</th>
                                    <td>
                                        {{ $kkpk->debitur->tgl_jth_tempo->translatedFormat('d F Y') }}
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <th>Baki Debet</th>
                                    <td>
                                        {{ $kkpk->debitur->baki_debet ? 'Rp ' . number_format($kkpk->debitur->baki_debet, 0, ',', '.') : 'belum ada data' }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card card-outline card-primary mb-0"></div>
    </div>
    </div>


    <div class="card card-outline card-success">
        <div class="card-header">
            <h6 class="header">DESKRIPSI</h6>
        </div>
        <div class="card-body">
            <div class="ml-4 deskripsi">
                {!! $data != null ? $htmlText : 'Belum Ada Data Kunjungan' !!}
            </div>
        </div>
        <div class="card card-outline card-success mb-0"></div>
    </div>


    {{-- footer --}}
    <script type="text/php">
        if (isset($pdf)) {
            $x = 400;
            $y = 810;
            $text = "BPR Kusuma Sumbing - Audit Internal {PAGE_NUM}/{PAGE_COUNT}";
            $font = "JetBrains Mono"; // font family
            $size = 9; // font size
            $color = array(0,0,0); // font color (RGB)
            $word_space = 0.0;
            $char_space = 0.0;
            $angle = 0.0;
    
            // Set style using CSS inline
            $style = [
                'font-family' => $font,
                'font-size' => $size . 'pt',
                'font-style' => 'italic',
                'font-weight' => 'normal',
            ];
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>
    {{-- end footer --}}
</body>

</html>
