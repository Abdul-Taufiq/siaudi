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

        h3 {
            font-size: 15pt;
        }

        .debitur th,
        td {
            font-size: 10pt;
            color: rgb(9, 109, 109);
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

        label {
            font-size: 10pt;
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
        /* .select2-container--default .select2-selection--single {
                                                                                                                                                        border-color: red;
                                                                                                                                                    } */

        /* Opsional: Ganti warna saat select di-focus */
        /* .select2-container--default.select2-container--focus .select2-selection--single {
                                                                                                                                                        border-color: green;
                                                                                                                                                    } */
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
                <form id="addForm" class="form" action="{{ url('data-lkhp-ops') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    {{-- LKHP --}}
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h5 class="head"># Penginputan Awal &rlhar;</h5>
                        </div>
                        <div class="card-body">
                            {{-- LKHP --}}
                            <div class="row ml-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Awal Pemeriksaan :</label>
                                        <div class="input-group date" id="date_tgl_awal" data-target-input="nearest">
                                            <input readonly type="text"
                                                class="form-control form-control-sm datetimepicker-input input"
                                                data-target="#date_tgl_awal" id="tgl_awal" name="tgl_awal" required
                                                placeholder="dd-mm-yyyy" />
                                            <div class="input-group-append" data-target="#date_tgl_awal"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Akhir Pemeriksaan :</label>
                                        <div class="input-group date" id="date_tgl_akhir" data-target-input="nearest">
                                            <input readonly type="text"
                                                class="form-control form-control-sm datetimepicker-input input"
                                                data-target="#date_tgl_akhir" id="tgl_akhir" name="tgl_akhir" required
                                                placeholder="dd-mm-yyyy" />
                                            <div class="input-group-append" data-target="#date_tgl_akhir"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group input-group-sm mb-3">
                                        <label for="id_cabang">Kantor Cabang :</label>
                                        <select class="form-control form-control-sm input" name="id_cabang" id="id_cabang"
                                            required>
                                            <option disabled selected>- Pilih Kantor Cabang -</option>
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
                                        <select class="form-control form-control-sm border-success" name="objek_pemeriksaan"
                                            id="objek_pemeriksaan" readonly>
                                            {{-- <option disabled selected>- Pilih Objek Pemerintahan -</option> --}}
                                            <option selected value="Operasional">Operasional</option>
                                            {{-- <option value="Operasional">Operasional</option> --}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- End LKHP --}}
                        </div>
                        <div class="card card-outline card-primary mb-0"></div>
                    </div>

                    <div class="card card-outline card-warning">
                        <div class="card-header">
                            <h5 class="head"># Penginpuntan Risk Event 1 &rlhar;</h5>
                        </div>
                        <div class="card-body">
                            {{-- Risk Event --}}
                            <div class="row ml-2">
                                <input type="hidden" id="riskEvent" value="{{ $riskEvent }}">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="id_event_risk_1">Pilih Risk Event :</label>
                                        <select name="id_event_risk_1" id="id_event_risk_1" autocomplete="off" required
                                            class="form-control select2 form-control-sm">
                                            <option selected disabled>- Pilih KKPK Terlebih Dahulu! -</option>
                                            @foreach ($riskEvent as $risk)
                                                <option value="{{ $risk->id_event_risk }}">
                                                    ({{ $risk->kode_finding }})
                                                    - {{ $risk->sub_activity }} - {{ $risk->list_finding }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="total_noa_1" class="label">Total NOA : <i
                                                style="font-size: 10px;">(Opsional)</i>
                                        </label>
                                        <input class="form-control form-control-sm" type="number" name="total_noa_1"
                                            id="total_noa_1">
                                    </div>
                                </div>
                            </div>

                            {{-- Add kkpk --}}
                            {{-- data KKPK --}}
                            <div class="card card-outline card-secondary">
                                <div class="card-header">
                                    <h6 class="head"># Penginpuntan Keterangan Temuan 1/1 &rlhar;</h6>
                                </div>
                                <div class="row ml-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="keterangan_re_1_1">Keterangan/Deskripsi :</label>
                                            <textarea class="form-control input" name="keterangan_re_1_1" id="keterangan_re_1_1" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>

                                    {{-- tambahan gambar untuk KKPK --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="img_re_1_1_1" class="label">Upload Gambar Pendukung
                                                :</label>
                                            <input class="form-control form-control-sm" type="file"
                                                name="img_re_1_1_1" id="img_re_1_1_1"
                                                accept="image/jpeg,image/jpg,image/png">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="caption_re_1_1_1" class="label">Captionnya
                                                :</label>
                                            <input class="form-control form-control-sm" type="text"
                                                name="caption_re_1_1_1" id="caption_re_1_1_1">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">&nbsp;</label>
                                        <input class="btn-outline-primary form-control form-control-sm mb-3"
                                            type="button" id="gambar_add_1_1_1" value="(+) Tambah Gambar (+)">
                                    </div>
                                </div>
                                {{-- tambahan gambar --}}
                                <div id="tambahan_gambar_1_1_1"></div>

                                <br>
                                <div class="card card-outline card-secondary mb-0"></div>
                            </div>

                            {{-- tambahan data debitur --}}
                            <div id="tambahan_debitur_1_1"></div>

                            {{-- data lainnya --}}
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h6 class="head"># Penginpuntan Data Lainnya 1/1 &rlhar;</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="desc_uraian_permasalahan_fakta_1">Desc Uraian Permasalahan
                                                    dan Fakta</label>
                                                <textarea class="summernote" name="desc_uraian_permasalahan_fakta_1" id="desc_uraian_permasalahan_fakta_1"
                                                    cols="20" rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="desc_keadaan_seharusnya_1">Desc Keadaan Seharusnya
                                                    :</label>
                                                <textarea class="summernote" name="desc_keadaan_seharusnya_1" id="desc_keadaan_seharusnya_1" cols="20"
                                                    rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="penyebab_terjadi_penyimpangan_1">Penyebab Terjadinya
                                                    Penyimpangan
                                                    :</label>
                                                <textarea class="summernote" name="penyebab_terjadi_penyimpangan_1" id="penyebab_terjadi_penyimpangan_1"
                                                    cols="20" rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="dampak_resiko_1">Dampak/Resiko :</label>
                                                <textarea class="summernote" name="dampak_resiko_1" id="dampak_resiko_1" cols="20" rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="tindak_lanjut_1">Tindak Lanjut/Rekomendasi:</label>
                                                <textarea class="summernote" name="tindak_lanjut_1" id="tindak_lanjut_1" cols="20" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-outline card-info mb-0"></div>
                            </div>
                            {{-- end KKPK --}}
                        </div>
                        <div class="card card-outline card-warning mb-0"></div>
                    </div>


                    {{-- tambahan RE --}}
                    <div id="tambahan_risk_event_1"></div>

                    {{-- Lanjutan --}}
                    <div class="card ">
                        <div class="card-body">
                            {{-- tombol tambah re --}}
                            <div class="col-md-12 ml-2">
                                <input class="btn-outline-primary form-control form-control-sm" type="button"
                                    id="tambah_re_1" value="(+) Tambah Risk Event (+)">
                            </div>
                        </div>
                    </div>



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
    <script src="{{ asset('script/lkhp/add/lkhp_add_config.js') }}"></script>
    <script src="{{ asset('script/lkhp/add/lkhp_add_fungsi1.js') }}"></script>
    <script src="{{ asset('script/lkhp/add/lkhp_add_flexible_kkpk.js') }}"></script>
    <script src="{{ asset('script/lkhp/add/lkhp_add_flexible_re_ops.js') }}"></script>
    <script src="{{ asset('script/lkhp/add/lkhp_add_flexible_gambar.js') }}"></script>
    <script src="{{ asset('script/lkhp/add/confirm-add.js') }}"></script>
@endsection
@endsection
