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
                <form id="addForm" action="  {{ url('data-lkhp-ops/' . $lkhp->id_lkhp) }} " class="form" method="post"
                    enctype="multipart/form-data">
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
                                                class="form-control form-control-sm datetimepicker-input input"
                                                data-target="#date_tgl_awal" id="tgl_awal" name="tgl_awal" required
                                                value="{{ $lkhp->tgl_awal->format('d-m-Y') }}" />
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
                                                value="{{ $lkhp->tgl_akhir->format('d-m-Y ') }}" />
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
                                            <option {{ $lkhp->id_cabang == '0' ? 'selected' : null }} value="0">Kantor
                                                Pusat Management</option>
                                            <option {{ $lkhp->id_cabang == '1' ? 'selected' : null }} value="1">Kantor
                                                Pusat Operasional</option>
                                            <option {{ $lkhp->id_cabang == '2' ? 'selected' : null }} value="2">KC
                                                Temanggung</option>
                                            <option {{ $lkhp->id_cabang == '3' ? 'selected' : null }} value="3">KC
                                                Wonosobo</option>
                                            <option {{ $lkhp->id_cabang == '4' ? 'selected' : null }} value="4">KC
                                                Ambarawa</option>
                                            <option {{ $lkhp->id_cabang == '5' ? 'selected' : null }} value="5">KC
                                                Semarang</option>
                                            <option {{ $lkhp->id_cabang == '6' ? 'selected' : null }} value="6">KC
                                                Mranggen</option>
                                            <option {{ $lkhp->id_cabang == '7' ? 'selected' : null }} value="7">KC
                                                Sukorejo</option>
                                            <option {{ $lkhp->id_cabang == '8' ? 'selected' : null }} value="8">KC
                                                Weleri</option>
                                            <option {{ $lkhp->id_cabang == '9' ? 'selected' : null }} value="9">KC
                                                Delanggu</option>
                                            <option {{ $lkhp->id_cabang == '10' ? 'selected' : null }} value="10">KC
                                                Gombong</option>
                                            <option {{ $lkhp->id_cabang == '11' ? 'selected' : null }} value="11">KC
                                                Sokaraja</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="objek_pemeriksaan">Objek Pemeriksaan :</label>
                                        <select class="form-control form-control-sm" name="objek_pemeriksaan"
                                            id="objek_pemeriksaan">
                                            <option disabled selected>- Pilih Objek Pemerintahan -</option>
                                            <option value="Kredit">Kredit</option>
                                            <option value="Operasional">Operasional</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="total_noa" class="label">Total NOA : <i
                                                style="font-size: 10px;">(Opsional)</i>
                                        </label>
                                        <input class="form-control form-control-sm" type="number" name="total_noa"
                                            id="total_noa" value="{{ $lkhp->total_noa }}">
                                    </div>
                                </div>

                            </div>
                            {{-- End LKHP --}}
                        </div>
                        <div class="card card-outline card-primary mb-0"></div>
                    </div>

                    {{-- risk event --}}
                    <?php $count = 1; ?>
                    <input type="hidden" id="riskEvent" value="{{ $riskEvent }}">
                    @foreach ($pivot as $item)
                        <div class="card card-outline card-warning">
                            <div class="card-header">
                                <h5 class="head"># Data Risk Event {{ $loop->iteration }} &rlhar;</h5>
                            </div>
                            <div class="card-body">
                                {{-- Risk Event --}}
                                <div class="row ml-2">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="id_event_risk_old_{{ $loop->iteration }}">Pilih Risk Event
                                                :</label>
                                            <select name="id_event_risk_old_{{ $loop->iteration }}"
                                                id="id_event_risk_old_{{ $loop->iteration }}" autocomplete="off" required
                                                class="form-control select2 form-control-sm">
                                                <option selected disabled>- Pilih KKPK Terlebih Dahulu! -</option>
                                                @foreach ($riskEvent as $risk)
                                                    <option
                                                        {{ $risk->id_event_risk == $item->riskEvent->id_event_risk ? 'selected' : null }}
                                                        value="{{ $risk->id_event_risk }}"> ({{ $risk->kode_finding }}) -
                                                        {{ $risk->sub_activity }} - {{ $risk->list_finding }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Aksi Risk Event Ini :</label>
                                        <select class="form-control form-control-sm border-danger input"
                                            name="aksi_{{ $loop->iteration }}" id="aksi_{{ $loop->iteration }}">
                                            <option selected value="Edit">Biarkan/Edit/Tetap Simpan</option>
                                            <option value="Hapus">Hapus/Tidak DiSimpan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 ml-2">
                                    <div class="form-group">
                                        <label for="keterangan_re_old_{{ $loop->iteration }}"
                                            class="wajib">Keterangan</label>
                                        <textarea class="form-control input summernote" name="keterangan_re_old_{{ $loop->iteration }}"
                                            id="keterangan_re_old_{{ $loop->iteration }}" cols="30" rows="5">
                                        {!! $item->keterangan_re !!}
                                        </textarea>
                                    </div>
                                </div>

                                {{-- tambahan gambar untuk RE --}}
                                @foreach ($item->pivotImg as $img)
                                    <div class="row ml-2">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Upload Gambar Pendukung :</label>
                                                <input class="form-control form-control-sm" type="file"
                                                    name="img_re_old_{{ $count }}_{{ $loop->iteration }}"
                                                    id="img_re_old_{{ $count }}_{{ $loop->iteration }}"
                                                    accept="image/jpeg,image/jpg,image/png">

                                                <a href="{{ asset('gambar/Gambar Pendukung LK - ' . str_replace('/', '_', $item->lkhp->no_lkhp_bayangan) . '/' . $img->img) }}"
                                                    target="_blank">Lihat disini</a>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label
                                                    for="caption_re_{{ $count }}_{{ $loop->iteration }}">Captionnya
                                                    :</label>
                                                <input class="form-control form-control-sm" type="text"
                                                    name="caption_re_old_{{ $count }}_{{ $loop->iteration }}"
                                                    id="caption_re_old_{{ $count }}_{{ $loop->iteration }}"
                                                    value="{{ $img->caption }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">&nbsp;</label>
                                            <select class="form-control form-control-sm border-danger input"
                                                name="aksi_gambar_{{ $count }}_{{ $loop->iteration }}"
                                                id="aksi_gambar_{{ $count }}_{{ $loop->iteration }}">
                                                <option selected value="Edit">Biarkan/Edit/Tetap Simpan</option>
                                                <option value="Hapus">Hapus/Tidak DiSimpan</option>
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- tambahan gambar --}}
                                <div class="col-md-12">
                                    <input class="btn-outline-primary form-control form-control-sm mb-3" type="button"
                                        id="gambar_add_{{ $count }}" value="(+) Tambah Gambar (+)">
                                </div>
                                <div id="tambahan_gambar_{{ $count }}"></div>

                            </div>
                            <div class="card card-outline card-warning mb-0"></div>
                        </div>
                        <?php $count++; ?>
                    @endforeach

                    <div id="tambahan_risk_event"></div>

                    <div class="card card-outline card-secondary">
                        <div class="card-body">
                            <div class="col-md-12">
                                <input class="btn-outline-primary form-control form-control-sm mb-3" type="button"
                                    id="tambah_re" value="(+) Tambah Risk Event (+)">
                            </div>
                        </div>
                        <div class="card card-outline card-secondary mb-0"></div>
                    </div>



                    {{-- <div id="tambahan_debitur"></div> --}}


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
                                        <textarea class="summernote" name="desc_uraian_permasalahan_fakta" id="desc_uraian_permasalahan_fakta"
                                            cols="20" rows="5">
                                            {!! $lkhp->desc_uraian_permasalahan_fakta !!}
                                        </textarea>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="desc_keadaan_seharusnya">Desc Keadaan Seharusnya
                                            :</label>
                                        <textarea class="summernote" name="desc_keadaan_seharusnya" id="desc_keadaan_seharusnya" cols="20"
                                            rows="5">
                                            {!! $lkhp->desc_keadaan_seharusnya !!}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="penyebab_terjadi_penyimpangan">Penyebab Terjadinya
                                            Penyimpangan
                                            :</label>
                                        <textarea class="summernote" name="penyebab_terjadi_penyimpangan" id="penyebab_terjadi_penyimpangan" cols="20"
                                            rows="5">
                                            {!! $lkhp->penyebab_terjadi_penyimpangan !!}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="dampak_resiko">Dampak/Risiko :</label>
                                        <textarea class="summernote" name="dampak_resiko" id="dampak_resiko" cols="20" rows="5">
                                            {!! $lkhp->dampak_resiko !!}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="tindak_lanjut">Tindak Lanjut/Rekomendasi:</label>
                                        <textarea class="summernote" name="tindak_lanjut" id="tindak_lanjut" cols="20" rows="5">
                                            {!! $lkhp->tindak_lanjut !!}
                                        </textarea>
                                    </div>
                                </div>
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
                            <button id="simpan" type="button" class="btn btn-primary" style="letter-spacing: 2px;">
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
    <script src="{{ asset('script/lkhp/edit_re/lkhp_edit_config.js') }}"></script>
    <script src="{{ asset('script/lkhp/edit_re/lkhp_edit_flexible_gambar.js') }}"></script>
    <script src="{{ asset('script/lkhp/edit_re/lkhp_edit_flexible_re.js') }}"></script>
    <script src="{{ asset('script/lkhp/add/confirm-add.js') }}"></script>
@endsection
@endsection
