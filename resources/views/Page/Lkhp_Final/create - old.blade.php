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
                <form id="addForm" class="form" action="{{ url('lkhp-final') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    {{-- LKHP --}}
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h5 class="head"># Data LKHP &rlhar;</h5>
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
                                        <select class="form-control form-control-sm input" name="objek_pemeriksaan"
                                            id="objek_pemeriksaan">
                                            <option disabled selected>- Pilih Objek Pemeriksaan -</option>
                                            <option value="Kredit">Kredit</option>
                                            <option value="Operasional">Operasional</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_lkhp">Nomor LKHP Final</label>
                                        <input class="form-control form-control-sm input" type="text" id="no_lkhp"
                                            name="no_lkhp" required placeholder="wajib diisi oleh user">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ttd_pemeriksa">Nama Pemeriksa (IA)</label>
                                        <input class="form-control form-control-sm input" type="text" id="ttd_pemeriksa"
                                            name="ttd_pemeriksa" required placeholder="wajib diisi oleh user">
                                    </div>
                                </div>
                            </div>
                            {{-- End LKHP --}}
                        </div>
                        <div class="card card-outline card-primary mb-0"></div>
                    </div>

                    {{-- LKHP choise --}}
                    <input type="hidden" id="lkhp_bayangan" value='@json($lkhp_bayangan)'>
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h5 class="head"># Pilih Data LKHP Bayangan &rlhar;</h5>
                        </div>
                        <div class="card-body">
                            <div class="row ml-2">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="id_lkhp_bayangan_1">Pilih data LKHP Bayangan 1</label>
                                        <select class="form-control select2" name="id_lkhp_bayangan_1"
                                            id="id_lkhp_bayangan_1">
                                            <option selected disabled>- Pilih data LKHP Bayangan -</option>
                                            @foreach ($lkhp_bayangan as $lkhp)
                                                <option value="{{ $lkhp->id_lkhp }}">
                                                    {{ $lkhp->cabang->cabang }} - {{ $lkhp->no_lkhp_bayangan }} -
                                                    {{ $lkhp->objek_pemeriksaan }} - (
                                                    {{ $lkhp->tgl_awal->translatedFormat('d') }} s/d
                                                    {{ $lkhp->tgl_akhir->translatedFormat('d F Y') }}
                                                    )
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">&nbsp;</label>
                                    <input class="btn-outline-primary form-control mb-3" type="button" id="add_lkhp"
                                        value="(+) Tambah LKHP (+)">
                                </div>

                                <div class="col-md-12">
                                    <table class="table table-sm">
                                        <tr>
                                            <th style="width: 35%; color:rgb(74, 177, 247)">Deskripsi Uraian Permasalahan
                                                dan Fakta</th>
                                            <td style="width: 2px">:</td>
                                            <td id="show_uraian_1"></td>
                                        </tr>
                                        <tr>
                                            <th style="width: 35%; color:rgb(74, 177, 247)">Deskripsi Keadaan Seharusnya
                                            </th>
                                            <td>:</td>
                                            <td id="show_keadaan_1"></td>
                                        </tr>
                                        <tr>
                                            <th style="width: 35%; color:rgb(74, 177, 247)">Penyebab Terjadi Penyimpangan
                                            </th>
                                            <td>:</td>
                                            <td id="show_penyebab_1"></td>
                                        </tr>
                                        <tr>
                                            <th style="width: 35%; color:rgb(74, 177, 247)">Dampak/Resiko</th>
                                            <td>:</td>
                                            <td id="show_dampak_1"></td>
                                        </tr>
                                        <tr>
                                            <th style="width: 35%; color:rgb(74, 177, 247)">Tindak Lanjut</th>
                                            <td>:</td>
                                            <td id="show_tindak_1"></td>
                                        </tr>
                                    </table>
                                    <hr>
                                </div>
                            </div>

                            {{-- tambahan --}}
                            <div id="tambahan_lkhp_1"></div>
                        </div>
                        <div class="card card-outline card-primary mb-0"></div>
                    </div>

                    {{-- Lanjutan --}}
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h5 class="head">Data Lanjutan &rlhar;</h5>
                        </div>
                        <div class="card-body">
                            <div class="row ml-2">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="desc_uraian_permasalahan_fakta">Desc Uraian Permasalahan
                                            dan Fakta</label>
                                        <textarea name="desc_uraian_permasalahan_fakta" id="desc_uraian_permasalahan_fakta" cols="20" rows="5"></textarea>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="desc_keadaan_seharusnya">Desc Keadaan Seharusnya
                                            :</label>
                                        <textarea name="desc_keadaan_seharusnya" id="desc_keadaan_seharusnya" cols="20" rows="5"></textarea>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="penyebab_terjadi_penyimpangan">Penyebab Terjadinya
                                            Penyimpangan
                                            :</label>
                                        <textarea name="penyebab_terjadi_penyimpangan" id="penyebab_terjadi_penyimpangan" cols="20" rows="5"></textarea>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="dampak_resiko">Dampak/Resiko :</label>
                                        <textarea name="dampak_resiko" id="dampak_resiko" cols="20" rows="5"></textarea>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="tindak_lanjut">Tindak Lanjut/Rekomendasi:</label>
                                        <textarea name="tindak_lanjut" id="tindak_lanjut" cols="20" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-outline card-info mb-0"></div>
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
                            <a href="/lkhp-final" type="button" class="btn btn-secondary" style="letter-spacing: 2px;">
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
    <script src="{{ asset('script/lkhp_final/add/lkhp_config.js') }}"></script>
    <script src="{{ asset('script/lkhp_final/add/lkhp_fungsi1.js') }}"></script>
    <script src="{{ asset('script/lkhp_final/confirm-add.js') }}"></script>
@endsection
@endsection
