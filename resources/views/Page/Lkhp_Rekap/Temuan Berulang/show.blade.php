@extends('partial.main')
@section('konten')

    <style>
        label {
            font-size: 12pt
        }

        .total {
            font-size: 10pt;
            margin: 0;
        }
    </style>


    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="m-0" style="letter-spacing: 2px;">
                                    <b>Halaman {{ $title }}</b>
                                </h4>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                                    <li class="breadcrumb-item active">Halaman {{ $title }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Konten start --}}
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <label for="">{{ $re }}</label>

                            </div>
                            <div class="card-body">
                                <table class="table table-hover table-striped" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th>Kantor Cabang</th>
                                            <th>No LKHP</th>
                                            <th>Tanggal Pemeriksaan</th>
                                            <th>Objek Pemeriksaan</th>
                                            <th>Creator</th>
                                            <th style="width: 5%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $items)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $items->lkhpFinal?->cabang->cabang ?? 'data hilang' }}</td>
                                                <td>{{ $items->lkhpFinal?->no_lkhp ?? 'data hilang' }}</td>
                                                <td>
                                                    {{ $items->lkhpFinal?->tgl_awal->translatedFormat('d') }} s/d
                                                    {{ $items->lkhpFinal?->tgl_akhir->translatedFormat('d F Y') }}
                                                </td>
                                                <td>{{ $items->lkhpFinal?->objek_pemeriksaan ?? 'data hilang' }}</td>
                                                <td>{{ $items->lkhpFinal?->nama_creator ?? 'data hilang' }}</td>
                                                <td>
                                                    <a href="{{ route('lkhp-final.show', encrypt($items->lkhpFinal?->id_lkhp_final)) }}"
                                                        class="btn btn-sm btn-info {{ $items->lkhpFinal == null ? 'disabled' : '' }}"><span
                                                            class="icon text-white-50"><i class="fa fa-eye"></i></span></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card card-outline card-danger mb-0"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- Konten End --}}


    </div>

@section('script')
    {{-- <script src="{{ asset('script/lkhp/lkhp_index.js') }}"></script> --}}

    <script></script>
@endsection
@endsection
