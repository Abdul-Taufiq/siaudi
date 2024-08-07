@extends('partial.main')
@section('konten')

    <style>
        h6 {
            font-weight: bold;
            letter-spacing: 2px;
        }

        label {
            font-size: 14px;
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
                    <div class="col-md-12">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h6>Input Data Pendukung &rarr;</h6>
                                    <span id="showing" class="fas fa-eye-slash" onclick="showInput()"></span>
                                </div>
                            </div>
                            <div class="card-body d-none" id="card_body">
                                <form id="quickForm" action="{{ url('lkhp-input/' . encrypt($lkhp->id_lkhp_final)) }}"
                                    method="post" enctype="multipart/form-data">
                                    @method('patch')
                                    @csrf

                                    @switch(auth()->user()->sub_jabatan)
                                        {{-- Kabid IA --}}
                                        @case('Kabid Internal Audit')
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="penanggung_jawab">Penanggung Jawab :</label>
                                                        <input class="form-control  form-control-sm" type="text"
                                                            name="penanggung_jawab" id="penanggung_jawab"
                                                            placeholder="Penanggung Jawab" value="{{ $lkhp->penanggung_jawab }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="komitmen_tgl">Tanggal Komitmen :</label>
                                                        <div class="input-group date" id="date_komitmen_tgl"
                                                            data-target-input="nearest">
                                                            <input readonly type="text"
                                                                class="form-control form-control-sm datetimepicker-input input"
                                                                data-target="#date_komitmen_tgl" id="komitmen_tgl"
                                                                name="komitmen_tgl" required placeholder="dd-mm-yyyy"
                                                                value="{{ $lkhp->komitmen_tgl ? $lkhp->komitmen_tgl->format('d-m-Y') : null }}" />
                                                            <div class="input-group-append" data-target="#date_komitmen_tgl"
                                                                data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group input-group-sm mb-3">
                                                        <label for="ttd_kaops">Nama Kasi Operasional</label>
                                                        <input class="form-control form-control-sm" type="text" name="ttd_kaops"
                                                            id="ttd_kaops" placeholder="Isikan..." value="{{ $lkhp->ttd_kaops }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group input-group-sm mb-3">
                                                        <label for="ttd_kakom">Nama Kasi Komersial</label>
                                                        <input class="form-control form-control-sm" type="text" name="ttd_kakom"
                                                            id="ttd_kakom" placeholder="Isikan..." value="{{ $lkhp->ttd_kakom }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group input-group-sm mb-3">
                                                        <label for="ttd_pincab">Nama Pimpinan Cabang</label>
                                                        <input class="form-control form-control-sm" type="text" name="ttd_pincab"
                                                            id="ttd_pincab" placeholder="Isikan..." value="{{ $lkhp->ttd_pincab }}">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="btn-group mb-2">
                                                <button type="submit" id="btn-simpan" class="btn btn-primary">
                                                    <i class="fa-regular fa-floppy-disk"></i>
                                                    &nbsp; Simpan
                                                </button>
                                            </div>
                                        @break

                                        {{-- KAsi --}}
                                        @case('Kasi Komersial')
                                            {{-- Pincab --}}
                                        @case('Pimpinan Cabang')
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="tanggapan_auditee">Tanggapan Auditee :</label>
                                                        <textarea name="tanggapan_auditee" id="tanggapan_auditee" cols="20" rows="5">
                                                            {!! $lkhp->tanggapan_auditee !!}
                                                        </textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="komitmen_tindakan">Tindakan Penyelesaian :</label>
                                                        <textarea name="komitmen_tindakan" id="komitmen_tindakan" cols="20" rows="5">
                                                            {!! $lkhp->komitmen_tindakan !!}
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="btn-group mb-2">
                                                <button type="submit" id="btn-simpan" class="btn btn-primary">
                                                    <i class="fa-regular fa-floppy-disk"></i>
                                                    &nbsp; Simpan
                                                </button>
                                            </div>
                                        @break

                                        @default
                                            <h4>Tidak Ada Inputan Untuk User Anda!</h4>
                                    @endswitch

                                </form>

                            </div>
                            <div class="card card-outline card-danger mb-0"></div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6>Lembar Konfirmasi Hasil Pemeriksaan Final &rarr;</h6>
                                <div class="row">
                                    <div class="col-md-3 ">
                                        <button type="button"
                                            class="btn btn-primary btn-icon-text btn-rounded btnpdf w-100 btn-sm"
                                            data-id="{{ encrypt($lkhp->id_lkhp_final) }}">
                                            <i class="fa fa-print" aria-hidden="true"></i> &nbsp;
                                            <b>PRINT LKHP As PDF</b>
                                        </button>
                                    </div>
                                    <div class="col-md-3 ">
                                        <button type="button"
                                            class="btn btn-primary btn-icon-text btn-rounded btnword w-100 btn-sm"
                                            data-id="{{ encrypt($lkhp->id_lkhp_final) }}">
                                            <i class="fa fa-print" aria-hidden="true"></i> &nbsp;
                                            <b>PRINT LKHP As Word</b>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <iframe src="/show-detail-final-kredit/{{ encrypt($lkhp->id_lkhp_final) }}}"
                                    frameborder="1" width="100%" height="720px"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- Konten End --}}


        {{-- mengamibil user untuk menentukan tombol export --}}
        <input hidden type="text" id="user" value="{{ Auth::user()->level }}">
    </div>

    @section('script')
        <script src="{{ asset('script/lkhp_final/print.js') }}"></script>

        <script src="{{ asset('script/lkhp_final/input_pendukung.js') }}"></script>
    @endsection
@endsection
