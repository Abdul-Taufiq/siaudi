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
                                    <li class="breadcrumb-item active">Data LKHP</li>
                                    <li class="breadcrumb-item active">Edit LKHP</li>
                                    <li class="breadcrumb-item active">Here</li>
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
                <form id="addForm" action="  {{ url('data-lkhp-edit/' . $pivot->id_kkpk) }} " class="form"
                    method="post" enctype="multipart/form-data">
                    @method('patch')
                    @csrf

                    {{-- KKPK --}}
                    <div class="card card-outline card-info">
                        <div class="card-header"></div>
                        <div class="card-body">
                            <div class="row ml-2">
                                <div class="col-md-12">
                                    <p class="head">#DATA Risk Event &rlhar;</p>
                                    <hr>
                                </div>
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
                                            <th>Indikasi Resiko</th>
                                            <td>: {{ $pivot->riskEvent->indikasi_resiko }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row ml-2">
                                <div class="col-md-12">
                                    <p class="head">#DATA KKPK &rlhar;</p>
                                    <hr>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <table class="table table-sm" style=" font-size: 13px;">
                                        <tr>
                                            <th style="width: 40%">Kode KKPK</th>
                                            <td>: {{ $pivot->kkpk->kode_kkpk }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tgl Pemeriksaan</th>
                                            <td>: {{ $pivot->kkpk->tgl_pemeriksaan->translatedformat('d F Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Pemeriksa</th>
                                            <td>: {{ $pivot->kkpk->nama_pemeriksa }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm" style=" font-size: 13px;">
                                        <tr>
                                            <th style="width: 40%">Jns Pemeriksaan</th>
                                            <td>: {{ $pivot->kkpk->jns_pemeriksaan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Fas Kredit</th>
                                            <td>: {{ $pivot->kkpk->fas_kredit }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jns Kredit</th>
                                            <td>: {{ $pivot->kkpk->jns_kredit }}</td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-12">
                                    <table class="table table-sm" style=" font-size: 13px;">
                                        <tr>
                                            <th style="width: 20%">Catatan/Deskripsi KKPK </th>
                                            <td style="width: 1%">:</td>
                                            <td>{!! $pivot->kkpk->keterangan->catatan !!}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row ml-2">
                                <div class="col-md-12">
                                    <p class="head">#DATA DEBITUR &rlhar;</p>
                                    <hr>
                                </div>
                                {{-- detail debitur  --}}
                                <div class="col-md-6">
                                    <table class="table table-sm" style=" font-size: 13px;">
                                        <tr>
                                            <th style="width: 40%">Nama Debitur</th>
                                            <td>:
                                                <span id="nama_debitur_">
                                                    {{ $pivot->kkpk->debitur->nama_nasabah }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 40%">No Rekening</th>
                                            <td>: <span id="no_rekening_">
                                                    {{ $pivot->kkpk->debitur->no_rekening }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 40%">Tgl Realisasi</th>
                                            <td>: <span id="tgl_realisasi_">
                                                    {{ $pivot->kkpk->debitur->tgl_realisasi ? $pivot->kkpk->debitur->tgl_realisasi->translatedFormat('d F Y') : 'belum ada data' }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 40%">Plafon</th>
                                            <td>: <span id="plafon_">
                                                    {{ $pivot->kkpk->debitur->plafon ? 'Rp ' . number_format($pivot->kkpk->debitur->plafon, 0, ',', '.') : 'belum ada data' }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm" style=" font-size: 13px;">
                                        <tr>
                                            <th style="width: 40%">Status (Kol/DPD)</th>
                                            <td>: <span id="status_">
                                                    {{ $pivot->kkpk->debitur->kol . '/' . $pivot->kkpk->debitur->dpd }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 40%">JKW</th>
                                            <td>: <span id="jkw_">
                                                    {{ $pivot->kkpk->debitur->jkw }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 40%">Tgl Jatuh Tempo</th>
                                            <td>: <span id="tgl_jth_tempo_">
                                                    {{ $pivot->kkpk->debitur->tgl_jth_tempo ? $pivot->kkpk->debitur->tgl_jth_tempo->translatedFormat('d F Y') : 'belum ada data' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 40%">Baki Debet</th>
                                            <td>: <span id="baki_debet_">
                                                    {{ $pivot->kkpk->debitur->baki_debet ? 'Rp ' . number_format($pivot->kkpk->debitur->baki_debet, 0, ',', '.') : 'belum ada data' }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="card card-outline card-info mb-0"></div>
                    </div>

                    {{-- risk event --}}
                    <?php $count = 1; ?>
                    <input type="hidden" id="riskEvent" value="{{ $riskEvent }}">
                    @foreach ($pivot_re as $item)
                        <div class="card card-outline card-warning">
                            <div class="card-header">
                                <h5 class="head"># Data Lainnya {{ $loop->iteration }} &rlhar;</h5>
                            </div>
                            <div class="card-body">
                                <div class="col-md-12 ml-2">
                                    <div class="form-group">
                                        <label for="keterangan_re_old_{{ $loop->iteration }}"
                                            class="wajib">Keterangan/Deskripsi :</label>
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
                                                <a href="{{ asset($folderName . '/' . $img->img) }}"
                                                    target="_blank">Lihat
                                                    disini</a>
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
                                <div id="tambahan_gambar_{{ $count }}"></div>
                                <div class="col-md-12 ml-2">
                                    <input class="btn-outline-primary form-control form-control-sm mb-3" type="button"
                                        id="gambar_add_{{ $count }}" value="(+) Tambah Gambar (+)">
                                </div>

                            </div>
                            <div class="card card-outline card-warning mb-0"></div>
                        </div>
                        <?php $count++; ?>
                    @endforeach


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
