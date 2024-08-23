@extends('partial.main')
@section('konten')
    <style>
        .head {
            color: rgb(10, 136, 115);
            font-style: italic;
            font-weight: bold;
            margin-bottom: 0;
            letter-spacing: 4px;
        }

        label {
            font-size: 14px;
        }

        .show {
            display: block;
        }

        .hidden {
            display: none;
        }

        .head-judul {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        label:has(+ input[required])::after {
            content: "  *";
            color: red;
            font-style: italic;
        }


        label:has(+ textarea[required])::after {
            content: " *";
            color: red;
        }

        .wajib::after {
            content: " *";
            color: red;
        }

        /* Mengganti warna border Select2 */
        .select2-container--default .select2-selection--single {
            border-color: red;
        }

        /* Opsional: Ganti warna saat select di-focus */
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: green;
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
                <form id="addForm" class="form" action="{{ url('data-lkhp-tambah-kkpk/' . $lkhp->id_lkhp) }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- KKPK --}}
                    <input id="id_cabang" name="id_cabang" type="hidden" value="{{ $lkhp->id_cabang }}">

                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h5 class="head"># Data Risk Event &rlhar;</h5>
                        </div>
                        <div class="card-body">
                            <div class="row ml-2">
                                <input type="hidden" name="id_event_risk" id="id_event_risk"
                                    value="{{ $pivot->riskEvent->id_event_risk }}">

                                <div class="col-md-6 mb-2">
                                    <table class="table table-sm" style=" font-size: 13px;">
                                        <tr>
                                            <th style="width: 40%">Kode Finding</th>
                                            <td>: {{ $pivot->riskEvent->kode_finding }}</td>
                                        </tr>
                                        <tr>
                                            <th>Activity</th>
                                            <td>: {{ $pivot->riskEvent->activity }}</td>
                                        </tr>
                                        <tr>
                                            <th>Sub Activity</th>
                                            <td>: {{ $pivot->riskEvent->sub_activity }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm" style=" font-size: 13px;">
                                        <tr>
                                            <th style="width: 40%">List Finding</th>
                                            <td>: {{ $pivot->riskEvent->list_finding }}</td>
                                        </tr>
                                        <tr>
                                            <th>Indikasi Risiko</th>
                                            <td>: {{ $pivot->riskEvent->indikasi_resiko }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card card-outline card-info mb-0"></div>
                    </div>

                    <div class="card card-outline card-warning">
                        <div class="card-header">
                            <h5 class="head"># Data KKPK 1 &rlhar;</h5>
                        </div>
                        <div class="card-body">
                            {{-- data KKPK --}}
                            <div class="row ml-2">
                                {{-- detail debitur  --}}
                                <div class="col-md-6">
                                    <table class="table table-sm" style=" font-size: 14px;">
                                        <tr>
                                            <th style="width: 40%">Nama Debitur</th>
                                            <td>: <span id="nama_debitur_1_1"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 40%">No Rekening</th>
                                            <td>: <span id="no_rekening_1_1"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 40%">Tgl Realisasi</th>
                                            <td>: <span id="tgl_realisasi_1_1"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 40%">Plafon</th>
                                            <td>: <span id="plafon_1_1"></span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm" style=" font-size: 14px;">
                                        <tr>
                                            <th style="width: 40%">Status (Kol/DPD)</th>
                                            <td>: <span id="status_1_1"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 40%">JKW</th>
                                            <td>: <span id="jkw_1_1"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 40%">Tgl Jatuh Tempo</th>
                                            <td>: <span id="tgl_jth_tempo_1_1"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 40%">Baki Debet</th>
                                            <td>: <span id="baki_debet_1_1"></span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-12">
                                    <table class="table table-sm debitur">
                                        <tr>
                                            <th style="width: 20%">Catatan/Deskripsi KKPK </th>
                                            <td style="width: 1%">:</td>
                                            <td id="catatan_1_1"></td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="id_kkpk_1_1">Pilih Data KKPK :</label>
                                        <select name="id_kkpk_1_1" id="id_kkpk_1_1" class="form-control select2" required>
                                            <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>
                                            {{-- ISi dikontrol Ajax berdasarkan cabang dipilih --}}
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Risk Event --}}
                            <div class="col-md-12 ml-2">
                                <div class="form-group">
                                    <label for="keterangan_re_1_1">Keterangan/Deskripsi :</label>
                                    <textarea class="form-control input" name="keterangan_re_1_1" id="keterangan_re_1_1" cols="30" rows="5"></textarea>
                                </div>
                            </div>

                            {{-- tambahan gambar untuk RE --}}
                            <div class="row ml-2">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="img_re_1_1_1">Upload Gambar Pendukung :</label>
                                        <input class="form-control form-control-sm" type="file" name="img_re_1_1_1"
                                            id="img_re_1_1_1" accept="image/jpeg,image/jpg,image/png">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="caption_re_1_1_1">Captionnya :</label>
                                        <input class="form-control form-control-sm" type="text"
                                            name="caption_re_1_1_1" id="caption_re_1_1_1">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">&nbsp;</label>
                                    <input class="btn-outline-primary form-control form-control-sm mb-3" type="button"
                                        id="gambar_add_1_1_1" value="(+) Tambah Gambar (+)">
                                </div>
                            </div>

                            <div id="tambahan_gambar_1_1_1"></div>

                            <br>
                            {{-- end KKPK --}}
                        </div>
                        <div class="card card-outline card-warning mb-0"></div>
                    </div>

                    <div id="tambahan_debitur_1_1"></div>

                    {{-- tombol save --}}
                    <div class="card card-outline card-danger">
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="terms" class="custom-control-input"
                                        id="exampleCheck1" required>
                                    <label class="custom-control-label" for="exampleCheck1">
                                        Saya setuju dengan <a href="{{ asset('Juknis/Juknis.pdf') }}"
                                            target="_blank">ketentuan yang berlaku</a>.
                                    </label>
                                </div>
                            </div>
                            <br>
                            <button id="simpan" type="button" class="btn btn-primary " style="letter-spacing: 2px;">
                                <i class="fa-regular fa-floppy-disk"></i> &nbsp; <b>SIMPAN</b></button>
                            <a href="/data-lkhp" type="button" class="btn btn-secondary" style="letter-spacing: 2px;">
                                <i class="fa-solid fa-arrow-left-long"></i> &nbsp; <b>KEMBALI</b></a>
                        </div>
                        <div class="card card-outline card-danger mb-0"></div>
                    </div>
                </form>
            </div>
        </section>
        {{-- Konten End --}}
    </div>

@section('script')
    <script src="{{ asset('script/lkhp/edit/config_add_kkpk_on_lkhp.js') }}"></script>
    <script src="{{ asset('script/lkhp/edit/config_lkhp_add.js') }}"></script>
    <script src="{{ asset('script/lkhp/add/lkhp_add_fungsi1.js') }}"></script>
    <script src="{{ asset('script/lkhp/add/lkhp_add_flexible_kkpk.js') }}"></script>
    {{-- <script src="{{ asset('script/lkhp/add/lkhp_add_flexible_re.js') }}"></script> --}}
    <script src="{{ asset('script/lkhp/add/lkhp_add_flexible_gambar.js') }}"></script>
    <script src="{{ asset('script/lkhp/add/confirm-add.js') }}"></script>
@endsection
@endsection
