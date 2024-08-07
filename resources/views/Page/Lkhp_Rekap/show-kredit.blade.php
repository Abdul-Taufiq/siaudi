@extends('partial.main')
@section('konten')

    <style>
        label {
            font-size: 9pt
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Kode Finding Risk Event : </label>
                                        <p class="total" id="total_re">
                                            <b>{{ $riskEvent->kode_finding }}</b>
                                            - {{ $riskEvent->list_finding }}
                                        </p>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">Total NOA : </label>
                                        <p class="total" id="total_noa">
                                            {{ $total_noa }}
                                        </p>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">Total Plafon : </label>
                                        <p class="total" id="total_plafon">
                                            {{ $total_plafon ? 'Rp ' . number_format($total_plafon, 0, ',', '.') : 'belum ada data' }}
                                        </p>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">Total Baki Debet : </label>
                                        <p class="total" id="total_bd">
                                            {{ $total_baki_debet ? 'Rp ' . number_format($total_baki_debet, 0, ',', '.') : 'belum ada data' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

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
