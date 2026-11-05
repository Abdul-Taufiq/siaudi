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
                <form id="addForm" action="  {{ url('lkhp-final/' . $data->id_lkhp_final) }} " class="form"
                    method="post" enctype="multipart/form-data">
                    @method('patch')
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
                                                class="form-control input form-control-sm datetimepicker-input input"
                                                data-target="#date_tgl_awal" id="tgl_awal" name="tgl_awal" required
                                                value="{{ $data->tgl_awal->format('d-m-Y') }}" />
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
                                                class="form-control input form-control-sm datetimepicker-input input"
                                                data-target="#date_tgl_akhir" id="tgl_akhir" name="tgl_akhir" required
                                                value="{{ $data->tgl_akhir->format('d-m-Y') }}" />
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
                                        <select class="form-control input form-control-sm input" name="id_cabang"
                                            id="id_cabang" required>
                                            <option disabled selected>- Pilih Kantor Cabang -</option>
                                            <option {{ $data->id_cabang == '0' ? 'selected' : null }} value="0">Kantor
                                                Pusat Management</option>
                                            <option {{ $data->id_cabang == '1' ? 'selected' : null }} value="1">Kantor
                                                Pusat Operasional</option>
                                            <option {{ $data->id_cabang == '2' ? 'selected' : null }} value="2">KC
                                                Temanggung</option>
                                            <option {{ $data->id_cabang == '3' ? 'selected' : null }} value="3">KC
                                                Wonosobo</option>
                                            <option {{ $data->id_cabang == '4' ? 'selected' : null }} value="4">KC
                                                Ambarawa</option>
                                            <option {{ $data->id_cabang == '5' ? 'selected' : null }} value="5">KC
                                                Semarang</option>
                                            <option {{ $data->id_cabang == '6' ? 'selected' : null }} value="6">KC
                                                Mranggen</option>
                                            <option {{ $data->id_cabang == '7' ? 'selected' : null }} value="7">KC
                                                Sukorejo</option>
                                            <option {{ $data->id_cabang == '8' ? 'selected' : null }} value="8">KC
                                                Weleri</option>
                                            <option {{ $data->id_cabang == '9' ? 'selected' : null }} value="9">KC
                                                Delanggu</option>
                                            <option {{ $data->id_cabang == '10' ? 'selected' : null }} value="10">KC
                                                Gombong</option>
                                            <option {{ $data->id_cabang == '11' ? 'selected' : null }} value="11">KC
                                                Sokaraja</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="objek_pemeriksaan">Objek Pemeriksaan :</label>
                                        <select class="form-control input form-control-sm input" name="objek_pemeriksaan"
                                            id="objek_pemeriksaan">
                                            <option disabled selected>- Pilih Objek Pemeriksaan -</option>
                                            <option {{ $data->objek_pemeriksaan == 'Kredit' ? 'selected' : null }}
                                                value="Kredit">Kredit</option>
                                            <option {{ $data->objek_pemeriksaan == 'Operasional' ? 'selected' : null }}
                                                value="Operasional">Operasional</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_lkhp">Nomor LKHP Final</label>
                                        <input class="form-control input form-control-sm input" type="text"
                                            id="no_lkhp" name="no_lkhp" required value="{{ $data->no_lkhp }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ttd_pemeriksa">Nama Pemeriksa (IA)</label>
                                        <input class="form-control input form-control-sm input" type="text"
                                            id="ttd_pemeriksa" name="ttd_pemeriksa" required
                                            value="{{ $data->ttd_pemeriksa }}">
                                    </div>
                                </div>
                            </div>
                            {{-- End LKHP --}}
                        </div>
                        <div class="card card-outline card-primary mb-0"></div>
                    </div>

                    {{-- lkhp old --}}
                    <div class="card card-outline card-warning">
                        <div class="card-header">
                            <h5 class="head"># Data LKHP Old &rlhar;</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-striped table-hover" style="100%; font-size: 11pt">
                                <thead style="text-align: center;">
                                    <th style="width: 3%;">#</th>
                                    <th style="width: 15%">No LKHP Final</th>
                                    <th>Deskripsi</th>
                                </thead>
                                <tbody>
                                    @foreach ($pivot as $item)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                                <input type="hidden" name="id_pivot_{{ $loop->iteration }}"
                                                    value="{{ $item->id_pivot }}">
                                            </td>
                                            <td>
                                                {{ $item->lkhpFinal->no_lkhp }}
                                                <select class="form-control form-control-sm"
                                                    name="aksi_pivot_{{ $loop->iteration }}">
                                                    <option selected value="Edit">Edit/Tetap Simpan</option>
                                                    <option value="Hapus">Hapus/Tidak DiSimpan</option>
                                                </select>
                                            </td>
                                            <td>
                                                <table class="table-sm" style="width: 100%">
                                                    <tr>
                                                        <th style="width: 35%; color: rgb(20, 145, 145)">Tgl Pemeriksaan
                                                        </th>
                                                        <td style="width: 2%">:</td>
                                                        <td>
                                                            {{ $item->lkhpFinal->tgl_awal->format('d-m-Y') }} s/d
                                                            {{ $item->lkhpFinal->tgl_akhir->format('d-m-Y') }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 35%; color: rgb(20, 145, 145)">Objek Pemeriksaan
                                                        </th>
                                                        <td style="width: 2%">:</td>
                                                        <td>{{ $item->lkhpFinal->objek_pemeriksaan }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 35%; color: rgb(20, 145, 145)">Risk Event</th>
                                                        <td style="width: 2%">:</td>
                                                        <td>
                                                            <b>{{ $item->riskEvent->kode_finding }}</b> -
                                                            {{ $item->riskEvent->list_finding }} -
                                                            {{ $item->riskEvent->indikasi_resiko }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 35%; color: rgb(20, 145, 145)">Creator</th>
                                                        <td style="width: 2%">:</td>
                                                        <td>
                                                            {{ $item->lkhpFinal->nama_creator }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            {{-- <td>
                                                <table class="table-sm" style="width: 100%">
                                                    <tr>
                                                        <th style="width: 35%; color: rgb(20, 145, 145)">Desc Uraian
                                                            Permasalahan & Fakta</th>
                                                        <td style="width: 2%">:</td>
                                                        <td>
                                                            {!! $item->lkhpFinal->desc_uraian_permasalahan_fakta !!}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 35%; color: rgb(20, 145, 145)">Desc Keadaan
                                                            Seharusnya</th>
                                                        <td style="width: 2%">:</td>
                                                        <td>
                                                            {!! $item->lkhpFinal->desc_keadaan_seharusnya !!}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 35%; color: rgb(20, 145, 145)">Penyebab Terjadi
                                                            Penyimpangan</th>
                                                        <td style="width: 2%">:</td>
                                                        <td>
                                                            {!! $item->lkhpFinal->penyebab_terjadi_penyimpangan !!}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 35%; color: rgb(20, 145, 145)">Dampak Resiko</th>
                                                        <td style="width: 2%">:</td>
                                                        <td>
                                                            {!! $item->lkhpFinal->dampak_resiko !!}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 35%; color: rgb(20, 145, 145)">Tindak Lanjut</th>
                                                        <td style="width: 2%">:</td>
                                                        <td>
                                                            {!! $item->lkhpFinal->tindak_lanjut !!}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot style="text-align: center;">
                                    <th style="width: 3%;">#</th>
                                    <th style="width: 12%">No LKHP Final</th>
                                    <th>Deskripsi</th>
                                </tfoot>
                            </table>
                        </div>
                        <div class="card card-outline card-warning mb-0"></div>
                    </div>

                    {{-- LKHP choise --}}
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h5 class="head"># Data LKHP Bayangan &rlhar;</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-striped table-hover" style="100%; font-size: 10pt"
                                id="showLkhp">
                                <thead style="text-align: center;">
                                    <th style="width: 3%;">#</th>
                                    <th style="width: 12%">No LKHP Bayangan</th>
                                    <th style="width: 35%">Deskripsi</th>
                                    <th style="width: 50%">Deskripsi Lanjutan</th>
                                </thead>
                                <tbody></tbody>
                                <tfoot style="text-align: center;">
                                    <th style="width: 3%;">#</th>
                                    <th style="width: 12%">No LKHP Bayangan</th>
                                    <th style="width: 35%">Deskripsi</th>
                                    <th style="width: 50%">Deskripsi Lanjutan</th>
                                </tfoot>
                            </table>
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
                                        <textarea name="desc_uraian_permasalahan_fakta" id="desc_uraian_permasalahan_fakta" cols="20" rows="5">
                                            {!! $data->desc_uraian_permasalahan_fakta !!}
                                        </textarea>
                                    </div>
                                    <hr>
                                </div>
                                {{-- <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="desc_keadaan_seharusnya">Desc Keadaan Seharusnya
                                            :</label>
                                        <textarea name="desc_keadaan_seharusnya" id="desc_keadaan_seharusnya" cols="20" rows="5">
                                            {!! $data->desc_keadaan_seharusnya !!}
                                        </textarea>
                                    </div>
                                    <hr>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="penyebab_terjadi_penyimpangan">Penyebab Terjadinya
                                            Penyimpangan
                                            :</label>
                                        <textarea name="penyebab_terjadi_penyimpangan" id="penyebab_terjadi_penyimpangan" cols="20" rows="5">
                                            {!! $data->penyebab_terjadi_penyimpangan !!}
                                        </textarea>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="dampak_resiko">Dampak/Risiko :</label>
                                        <textarea name="dampak_resiko" id="dampak_resiko" cols="20" rows="5">
                                            {!! $data->dampak_resiko !!}
                                        </textarea>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="tindak_lanjut">Tindak Lanjut/Rekomendasi:</label>
                                        <textarea name="tindak_lanjut" id="tindak_lanjut" cols="20" rows="5">
                                            {!! $data->tindak_lanjut !!}
                                        </textarea>
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
    <script src="{{ asset('script/lkhp_final/edit/lkhp_config.js') }}"></script>
    <script src="{{ asset('script/lkhp_final/edit/getLkhp.js') }}"></script>
    <script src="{{ asset('script/lkhp_final/edit/lkhp_fungsi1.js') }}"></script>
    <script src="{{ asset('script/lkhp_final/confirm-add.js') }}"></script>
@endsection
@endsection
