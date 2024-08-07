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
                                <h3 class="m-0" style="letter-spacing: 2px;">
                                    <b>Halaman {{ $title }}</b>
                                </h3>
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
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label for="min" class="">Filter dari Tahun:</label>
                                                    <select name="min" id="min"
                                                        class="form-control form-control-sm yearSelect"></select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label for="max" class="">To:</label>
                                                    <select name="max" id="max"
                                                        class="form-control form-control-sm yearSelect"></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group input-group-sm mb-3">
                                                    <label for="id_cabang">Kantor Cabang :</label>
                                                    <select class="form-control form-control-sm input" name="id_cabang"
                                                        id="id_cabang" required>
                                                        <option disabled selected>- Pilih Kantor Cabang -</option>
                                                        <option value="99">All Cabang</option>
                                                        <option value="0">Kantor Pusat Management</option>
                                                        <option value="1">Kantor Pusat Operasional</option>
                                                        <option value="2">KC Temanggung</option>
                                                        <option value="3">KC Wonosobo</option>
                                                        <option value="4">KC Ambarawa</option>
                                                        <option value="5">KC Semarang</option>
                                                        <option value="6">KC Mranggen</option>
                                                        <option value="7">KC Sukorejo</option>
                                                        <option value="8">KC Weleri</option>
                                                        <option value="9">KC Delanggu</option>
                                                        <option value="10">KC Gombong</option>
                                                        <option value="11">KC Sokaraja</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="objek_pemeriksaan">Objek Pemeriksaan :</label>
                                                    <select class="form-control form-control-sm input"
                                                        name="objek_pemeriksaan" id="objek_pemeriksaan">
                                                        <option disabled selected>- Pilih Objek Pemeriksaan -</option>
                                                        <option value="All">All</option>
                                                        <option value="Kredit">Kredit</option>
                                                        <option value="Operasional">Operasional</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-row-reverse bd-highlight">
                                    <div class="btn-group mb-2">
                                        <button id="btn-filter" class="btn btn-success btn-md">Filter</button>
                                        <button id="btn-refresh" class="btn btn-info btn-md">Refresh</button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <table id="table_index" class="table table-hover table-striped table-bordered table-sm"
                                    style="width: 100%">
                                    <thead style="background-color: lightseagreen">
                                        <tr>
                                            <th>#</th>
                                            <th>Kantor Cabang</th>
                                            <th>No LKHP</th>
                                            <th>Risk Event</th>
                                            <th>Tgl Pemeriksaan</th>
                                            <th>Objek Pemeriksaan</th>
                                            <th>Nama Creator</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th style="width: 1%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <div class="card card-outline card-danger mb-0"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- Konten End --}}

        {{-- Modal --}}
        {{-- @include('Page.Lkhp.modal') --}}
        {{-- end modal --}}

        {{-- mengamibil user untuk menentukan tombol export --}}
        <input hidden type="text" id="user" value="{{ Auth::user()->level }}">
    </div>

@section('script')
    <script src="{{ asset('script/lkhp_rekap/lkhp_config.js') }}"></script>
    <script src="{{ asset('script/lkhp_rekap/lkhp_index.js') }}"></script>
@endsection
@endsection
