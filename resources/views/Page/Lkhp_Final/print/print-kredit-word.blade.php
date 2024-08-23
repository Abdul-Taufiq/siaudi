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
        @page {
            size: 216mm 330mm;
            margin: 15mm 10mm 10mm 15mm;
            font-family: Tahoma, sans-serif;
            text-align: justify;
            font-size: 10pt;
        }

        body {
            margin: 5mm 0mm 10mm 5mm;
            font-family: Tahoma, sans-serif;
            text-align: justify;
            font-size: 9pt;
        }

        table td {
            vertical-align: top;
            text-align: justify;
            page-break-before: avoid;
            page-break-after: avoid;
            page-break-inside: avoid;
        }

        h3 {
            font-size: 11pt;
        }

        .logo {
            width: 65px;
            height: auto;
        }
    </style>
</head>

<body>
    <header>
        {{-- header --}}
        <table style="width: 100%; margin-top: -20px;">
            <tr>
                <td style="width: 20%; border: none">
                    <img style="width: 65px; height: auto;"
                        src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/img/ikon.png'))) }}">
                </td>
                <td style="width: 60%; text-align: center; border: none">
                    <h3 style="margin-top: 30px;">
                        <b>LEMBAR KONFIRMASI <br> HASIL PEMERIKSAAN PT BPR KUSUMA SUMBING</b>
                    </h3>
                </td>
                <td style="width: 20%; border: none">&nbsp;</td>
            </tr>
        </table>
        <hr>
        {{-- end header --}}


        {{-- Header --}}
        <table class="table-sm" style="border: 1px solid; width: 100%; font-size: 10pt">
            <tr>
                <th style="width: 35%; border: none; text-align: left">Kantor</th>
                <td style="width: 1%; border: none">: </td>
                <td style="border: none">{{ $lkhp_final->cabang->cabang }}</td>
            </tr>
            <tr>
                <th style="width: 35%; border: none; text-align: left">Tanggal Pemeriksaan</th>
                <td style="width: 1%; border: none">: </td>
                <td style="border: none">
                    {{ $lkhp_final->tgl_awal->translatedFormat('d') }} s/d
                    {{ $lkhp_final->tgl_akhir->translatedFormat('d F Y') }}
                </td>
            </tr>
            <tr>
                <th style="width: 35%; border: none; text-align: left">Objek Pemeriksaan</th>
                <td style="width: 1%; border: none">: </td>
                <td style="border: none">{{ $lkhp_final->objek_pemeriksaan }}</td>
            </tr>
            <tr>
                <th style="width: 35%; border: none; text-align: left">Nomor Kertas Kerja</th>
                <td style="width: 1%; border: none">: </td>
                <td style="border: none">{{ $lkhp_final->no_lkhp }}</td>
            </tr>
        </table>
    </header>

    <ol style='font-family: "JetBrains Mono"; font-size: 12px;'>
        <li>penyelesaian akan segera dilaksanakan</li>
        <li>target akan diup</li>
    </ol>


    <br>


    <main>
        {{-- Konten --}}
        @foreach ($groupedPivots as $id_event_risk => $pivotsGroup)
            <table class="table table-sm table-borderless"
                style="width: 100%; page-break-inside: avoid; margin-bottom: 0px;">
                <tr>
                    <td style="text-align: start; width: 67%;border: none">
                        <b>
                            {{ $pivotsGroup->first()->riskEvent->kode_finding }} -
                            {{ $pivotsGroup->first()->riskEvent->list_finding }}
                        </b>
                    </td>
                    <td style="width: 5%;border: none">&nbsp;</td>
                    <td style="text-align: end; width: 28%; border: none">
                        <b>
                            Indikasi Resiko : {{ $pivotsGroup->first()->riskEvent->indikasi_resiko }}
                        </b>
                    </td>
                </tr>
            </table>
            <br>

            {{-- isi uraian dan fakta --}}
            <table class="border border-collapse" style="width: 100%; page-break-inside: avoid;">
                <thead class="table-primary" style="text-align: center">
                    <tr>
                        <th>URAIAN PERMASALAHAN dan FAKTA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding-left: 10px;">
                            {!! $lkhp_final->desc_uraian_permasalahan_fakta !!}

                            <hr>
                            {{-- kkpk --}}
                            @foreach ($pivotsGroup as $pivot)
                                <b>{{ $loop->iteration }}. Debitur
                                    {{ $pivot->kkpk->debitur->nama_nasabah }}</b>

                                {{-- Pemroses --}}
                                <br>
                                <div class="row ml-2" style="margin-left: 2pt">
                                    <div class="col-md-12">
                                        <b>Pemroses :</b>
                                        <table style="width: 100%; border: none">
                                            <tr>
                                                <td style="width: 49%; border: none">
                                                    <table style="width: 100%; border: none" class="table table-sm">
                                                        <tr>
                                                            <td style="width: 50%; border: none">Nama AO</td>
                                                            <td style="width: 1%; border: none;">:</td>
                                                            <td style="border: none">{{ $pivot->kkpk->nama_ao }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border: none">Nama Analis Kredit</td>
                                                            <td style="width: 1%; border: none;">:</td>
                                                            <td style="border: none">{{ $pivot->kkpk->nama_analis }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border: none">Nama Kasi Komersial</td>
                                                            <td style="width: 1%; border: none;">:</td>
                                                            <td style="border: none">{{ $pivot->kkpk->nama_kakom }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border: none">Nama Pimpinan Cabang</td>
                                                            <td style="width: 1%; border: none;">:</td>
                                                            <td style="border: none">{{ $pivot->kkpk->nama_pincab }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style="width: 2%; border: none">&nbsp;</td>
                                                <td style="width: 49%; border: none">
                                                    <table style="width: 100%; border: none" class="table table-sm">
                                                        <tr>
                                                            <td style="width: 50%; border: none">Nama Analis Area</td>
                                                            <td style="width: 1%; border: none;">:</td>
                                                            <td style="border: none">
                                                                {{ $pivot->kkpk->nama_analis_area }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border: none">Nama Area Manager</td>
                                                            <td style="width: 1%; border: none;">:</td>
                                                            <td style="border: none">
                                                                {{ $pivot->kkpk->nama_area_manager }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border: none">Nama Manager Bisnis</td>
                                                            <td style="width: 1%; border: none;">:</td>
                                                            <td style="border: none">
                                                                {{ $pivot->kkpk->nama_manager_bisnis }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border: none">Nama Direksi</td>
                                                            <td style="width: 1%; border: none;">:</td>
                                                            <td style="border: none">{{ $pivot->kkpk->nama_direksi }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                {{-- Detail Debitur --}}
                                <br>
                                <div class="row ml-2" style="margin-left: 2pt">
                                    <div class="col-md-12">
                                        <b>Detail Debitur :</b>
                                        <table style="width: 100%; border: none;">
                                            <tr>
                                                <td style="width: 49%; border: none;">
                                                    <table style="width: 100%" class="table table-sm">
                                                        <tr>
                                                            <td style="width: 45%; border: none;">No Rekening</td>
                                                            <td style="width: 1%; border: none;">:</td>
                                                            <td style="border: none">
                                                                {{ $pivot->kkpk->debitur->no_rekening }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 45%; border: none;">Nama Debitur</td>
                                                            <td style="width: 1%; border: none;">:</td>
                                                            <td style="border: none">
                                                                {{ $pivot->kkpk->debitur->nama_nasabah }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 45%; border: none;">Tgl Realisasi</td>
                                                            <td style="width: 1%; border: none;">:</td>
                                                            <td style="border: none">
                                                                {{ $pivot->kkpk->debitur->tgl_realisasi ? $pivot->kkpk->debitur->tgl_realisasi->translatedFormat('d F Y') : 'Belum ada data' }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style="width: 2%; border: none;">&nbsp;</td>
                                                <td style="width: 49%; border: none;">
                                                    <table style="width: 100%; border: none;" class="table table-sm">
                                                        <tr>
                                                            <td style="width: 40%; border: none;">Plafond/Baki Debet
                                                            </td>
                                                            <td style="width: 1%; border: none;">:</td>
                                                            <td style="border: none">
                                                                {{ $pivot->kkpk->debitur->plafon ? 'Rp ' . number_format($pivot->kkpk->debitur->plafon, 0, ',', '.') : 'Belum ada data' }}
                                                                /
                                                                {{ $pivot->kkpk->debitur->baki_debet ? 'Rp ' . number_format($pivot->kkpk->debitur->baki_debet, 0, ',', '.') : 'Belum ada data' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 40%; border: none;">Kol/DPD</td>
                                                            <td style="width: 1%; border: none;">:</td>
                                                            <td style="border: none">{{ $pivot->kkpk->debitur->kol }}
                                                                /
                                                                {{ $pivot->kkpk->debitur->kol }}</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                {{-- Keterangan/lainnya --}}
                                <br>
                                <div class="row ml-2" style="margin-left: 2pt">
                                    <div class="col-md-12">
                                        <b>Keterangan/Lainnya :</b> <br>
                                        {!! $pivot->keterangan_re !!}
                                    </div>
                                </div>

                                {{-- Gammbar Pendukung --}}
                                @if ($pivot->pivotImg->isNotEmpty())
                                    <div class="row ml-2 mb-2" style="margin-left: 2pt">
                                        <div class="col-md-12">
                                            <b>Gambar Pendukung :</b>
                                        </div>
                                        @foreach ($pivot->pivotImg as $image)
                                            <div class="col-md-4">
                                                <img style="max-width: 12%;"
                                                    src="{{ asset('gambar/Gambar Pendukung LK - ' . str_replace('/', '_', $image->pivot->lkhp->no_lkhp_bayangan) . '/' . $image->img) }}"
                                                    alt="{{ $image->caption }}">
                                                <a href="{{ asset('gambar/Gambar Pendukung LK - ' . str_replace('/', '_', $image->pivot->lkhp->no_lkhp_bayangan) . '/' . $image->img) }}"
                                                    target="_blank">Lihat disini</a>
                                                <p>Caption: {{ $image->caption }}</p>
                                            </div>
                                        @endforeach
                                @endif
                            @endforeach

                        </td>
                    </tr>
                </tbody>
            </table>
            <br>

            {{-- Isi Keadaan seharusnya --}}
            <table class="border border-collapse" style="width: 100%; page-break-inside: avoid;">
                <thead class="table-primary" style="text-align: center">
                    <th>KEADAAN SEHARUSNYA</th>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding-left: 10px;">
                            {!! $lkhp_final->desc_keadaan_seharusnya !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>

            {{-- Isi dampak/resiko --}}
            <table class="border border-collapse" style="width: 100%; page-break-inside: avoid;">
                <thead class="table-primary" style="text-align: center">
                    <th>DAMPAK / RESIKO</th>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding-left: 10px;">
                            {!! $lkhp_final->dampak_resiko !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>

            {{-- Isi tindak lanjut --}}
            <table class="border border-collapse" style="width: 100%; page-break-inside: avoid;">
                <thead class="table-primary" style="text-align: center">
                    <th>TINDAK LANJUT / REKOMENDASI</th>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding-left: 10px;">
                            {!! $lkhp_final->tindak_lanjut !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>

            {{-- Isi tanggapan auditee --}}
            <table class="border border-collapse" style="width: 100%; page-break-inside: avoid;">
                <thead class="table-primary" style="text-align: center">
                    <th>TANGGAPAN AUDITEE</th>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding-left: 10px;">
                            {!! $lkhp_final->tanggapan_auditee ? $lkhp_final->tanggapan_auditee : 'Belum ada data' !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>

            {{-- Isi komitmen --}}
            <table class="border border-collapse" style="width: 100%; page-break-inside: avoid;">
                <thead class="table-primary" style="text-align: center">
                    <th>AGENDA PERBAIKAN / KOMITMEN</th>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <table class="table table-bordered">
                                <tr style="text-align: center">
                                    <td style="width: 60%; text-align: center">Tindakan Penyelesaian</td>
                                    <td style="width: 20%; text-align: center">Tanggal</td>
                                    <td style="width: 20%; text-align: center">Penanggung Jawab</td>
                                </tr>
                                <tr>
                                    <td>{!! $lkhp_final->komitmen_tindakan !!}</td>
                                    <td>
                                        {!! $lkhp_final->komitmen_tgl ? $lkhp_final->komitmen_tgl->translatedFormat('d F Y') : 'Belum ada data' !!}
                                    </td>
                                    <td>{!! $lkhp_final->penanggung_jawab !!}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>

            {{-- Isi LKHP footer --}}
            <table class="border border-collapse" style="width: 100%; page-break-inside: avoid;">
                <thead class="table-primary" style="text-align: left; font-size: 8pt; font-style: italic;">
                    <th style="text-align: left">
                        Lembar Konfirmasi ini agar dikembalikan tanggal
                        {{ $lkhp_final->tgl_pengembalian->translatedFormat('d F Y') }}
                    </th>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <table class="table table-bordered"
                                style="width: 100%; page-break-inside: avoid; border-collapse: collapse;">
                                <tr>
                                    <td style="text-align: center">Dibuat oleh,</td>
                                    <td style="text-align: center">Disetujui oleh,</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%; text-align: center">
                                        <br><br><br><br><br><br>
                                        <u>{{ $lkhp_final->ttd_pemeriksa ? $lkhp_final->ttd_pemeriksa : 'Belum ada data' }}</u>
                                        <br>
                                        Audit Internal
                                    </td>
                                    <td style="width: 60%; text-align: center">
                                        <br><br><br><br><br><br>
                                        <table class="table table-sm table-borderless"
                                            style="width: 100%; page-break-inside: avoid;">
                                            <tr>
                                                <td style="width: 33%; text-align: center; border: none">
                                                    <u>{{ $lkhp_final->ttd_kaops ? $lkhp_final->ttd_kaops : 'Belum ada data' }}</u>
                                                </td>
                                                <td style="width: 33%; text-align: center; border: none">
                                                    <u>{{ $lkhp_final->ttd_kakom ? $lkhp_final->ttd_kakom : 'Belum ada data' }}</u>
                                                </td>
                                                <td style="width: 33%; text-align: center; border: none">
                                                    <u>{{ $lkhp_final->ttd_pincab ? $lkhp_final->ttd_pincab : 'Belum ada data' }}</u>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center; border: none;">Kasi Operasional</td>
                                                <td style="text-align: center; border: none;">Kasi Komersial</td>
                                                <td style="text-align: center; border: none;">Pimpinan Cabang</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    </main>

    <footer>
        {{-- footer --}}
        <script type="text/php">
            if (isset($pdf)) {
                $x = 500;
                $y = 900;
                $text = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
                $font = null;
                $size = 10;
                $color = array(0,0,0);
                $word_space = 0.0;  //  default
                $char_space = 0.0;  //  default
                $angle = 0.0;   //  default
                $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
            }
        </script>
        {{-- end footer --}}
    </footer>
</body>

</html>
