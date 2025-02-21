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
    </style>
</head>

<body>
    {{-- Header --}}
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h6><b>Header &rarr;</b></h6>
        </div>
        <div class="card-body">
            <div class="row ">
                <div class="col-md-6">
                    <table style="width: 100%;" class="table table-striped table-sm">
                        <tr>
                            <th style="width: 40%">Kantor</th>
                            <td style="width: 5%">: </td>
                            <td>{{ $lkhp_final->cabang->cabang }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Pemeriksaan</th>
                            <td>: </td>
                            <td>
                                {{ $lkhp_final->tgl_awal->translatedFormat('d') }} s/d
                                {{ $lkhp_final->tgl_akhir->translatedFormat('d F Y') }}
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <table style="width: 100%;" class="table table-striped table-sm">
                        <tr>
                            <th style="width: 40%">Objek Pemeriksaan</th>
                            <td style="width: 5%">: </td>
                            <td>{{ $lkhp_final->objek_pemeriksaan }}</td>
                        </tr>
                        <tr>
                            <th>Nomor Kertas Kerja</th>
                            <td>: </td>
                            <td>{{ $lkhp_final->no_lkhp }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card card-outline card-primary mb-0"></div>
    </div>


    {{-- Konten --}}
    @foreach ($groupedPivots as $id_event_risk => $pivotsGroup)
        <div class="card card-outline card-info">
            <div class="card-header">
                <h6><b>Konten &rarr;</b></h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless" style="width: 100%">
                    <tr>
                        <td style="text-align: start; width: 80%">
                            <label>
                                {{ $pivotsGroup->first()->riskEvent->kode_finding }} -
                                {{ $pivotsGroup->first()->riskEvent->list_finding }}
                            </label>
                        </td>
                        <td style="text-align: end">
                            <label>
                                Indikasi Risiko : {{ $pivotsGroup->first()->riskEvent->indikasi_resiko }}
                            </label>
                        </td>
                    </tr>
                </table>

                {{-- isi uraian dan fakta --}}
                <table class="border border-collapse" style="width: 100%">
                    <thead class="table-primary" style="text-align: center">
                        <tr>
                            <th>URAIAN PERMASALAHAN dan FAKTA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding-left: 10px;">
                                {!! $lkhp_final->desc_uraian_permasalahan_fakta !!}
                                @foreach ($pivotsGroup as $pivot)
                                    {{-- Keterangan/lainnya --}}
                                    <br>
                                    <div class="row ml-2">
                                        <div class="col-md-12">
                                            <label>Keterangan/Lainnya :</label>
                                            {!! $pivot->keterangan_re !!}
                                        </div>
                                    </div>

                                    {{-- Gammbar Pendukung --}}
                                    <div class="row ml-2 mb-2">
                                        <div class="col-md-12">
                                            <label>Gambar Pendukung :</label>
                                        </div>
                                        @if ($pivot->pivotImg->isNotEmpty())
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
                                        @else
                                            <div class="col-md-4">
                                                <p style="color: red">Tidak ada Gambar</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach

                            </td>
                        </tr>
                    </tbody>
                </table>

                {{-- Isi Keadaan seharusnya --}}
                <table class="border border-collapse" style="width: 100%">
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

                {{-- Isi dampak/resiko --}}
                <table class="border border-collapse" style="width: 100%">
                    <thead class="table-primary" style="text-align: center">
                        <th>DAMPAK / RISIKO</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding-left: 10px;">
                                {!! $lkhp_final->dampak_resiko !!}
                            </td>
                        </tr>
                    </tbody>
                </table>

                {{-- Isi tindak lanjut --}}
                <table class="border border-collapse" style="width: 100%">
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

                {{-- Isi tanggapan auditee --}}
                <table class="border border-collapse" style="width: 100%">
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

                {{-- Isi komitmen --}}
                <table class="border border-collapse" style="width: 100%">
                    <thead class="table-primary" style="text-align: center">
                        <th>AGENDA PERBAIKAN / KOMITMEN</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <table class="table table-bordered">
                                    <tr style="text-align: center">
                                        <td style="width: 60%">Tindakan Penyelesaian</td>
                                        <td style="width: 20%;">Tanggal</td>
                                        <td style="width: 20%;">Penanggung Jawab</td>
                                    </tr>
                                    <tr>
                                        <td>{!! $lkhp_final->komitmen_tindakan !!}</td>
                                        <td style="text-align: center;">
                                            {!! $lkhp_final->komitmen_tgl ? $lkhp_final->komitmen_tgl->translatedFormat('d F Y') : 'Belum ada data' !!}
                                        </td>
                                        <td style="text-align: center;">{!! $lkhp_final->penanggung_jawab !!}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>

                {{-- Isi LKHP footer --}}
                <table class="border border-collapse" style="width: 100%">
                    <thead class="table-primary" style="text-align: center">
                        <th>
                            Lembar Konfirmasi ini agar dikembalikan tanggal
                            {{ $lkhp_final->tgl_pengembalian ? $lkhp_final->tgl_pengembalian->translatedFormat('d F Y') : '-' }}
                        </th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <table class="table table-bordered" style="width: 100%">
                                    <tr style="text-align: center">
                                        <td>Dibuat oleh,</td>
                                        <td>Disetujui oleh,</td>
                                    </tr>
                                    <tr style="text-align: center">
                                        <td style="width: 50%">
                                            <br><br><br><br><br><br>
                                            <u>{{ $lkhp_final->ttd_pemeriksa ? $lkhp_final->ttd_pemeriksa : 'Belum ada data' }}</u>
                                            <br>
                                            Audit Internal
                                        </td>
                                        <td style="width: 60%; text-align: center">
                                            <table class="table table-sm"
                                                style="width: 100%; page-break-inside: avoid;">
                                                <tr>
                                                    <td style="width: 33%; text-align: center;">
                                                        &nbsp;<br><br><br><br>
                                                    </td>
                                                    <td style="width: 33%; text-align: center;">
                                                        &nbsp;<br><br><br><br>
                                                    </td>
                                                    <td style="width: 33%; text-align: center;">
                                                        &nbsp;<br><br><br><br>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 33%; text-align: center;">
                                                        <u>{{ $lkhp_final->ttd_kaops ? $lkhp_final->ttd_kaops : 'Belum ada data' }}</u>
                                                    </td>
                                                    <td style="width: 33%; text-align: center;">
                                                        <u>{{ $lkhp_final->ttd_kakom ? $lkhp_final->ttd_kakom : 'Belum ada data' }}</u>
                                                    </td>
                                                    <td style="width: 33%; text-align: center;">
                                                        <u>{{ $lkhp_final->ttd_pincab ? $lkhp_final->ttd_pincab : 'Belum ada data' }}</u>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center;">Kasi Operasional</td>
                                                    <td style="text-align: center;">Kasi Komersial</td>
                                                    <td style="text-align: center;">Pimpinan Cabang</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>



            </div>
            <div class="card card-outline card-info mb-0"></div>
        </div>
    @endforeach

</body>

</html>
