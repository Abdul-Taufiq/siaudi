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
            border-color: green;
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
                <form id="EditForm" action="  {{ url('data-lkhp/' . $data->id_lkhp) }} " class="form" method="post"
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
                                                class="form-control form-control-sm datetimepicker-input input"
                                                data-target="#date_tgl_akhir" id="tgl_akhir" name="tgl_akhir" required
                                                value="{{ $data->tgl_akhir->format('d-m-Y ') }}" />
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
                                        <select class="form-control form-control-sm border-success" name="objek_pemeriksaan"
                                            id="objek_pemeriksaan" readonly>
                                            {{-- <option disabled selected>- Pilih Objek Pemerintahan -</option> --}}
                                            <option selected value="Kredit">Kredit</option>
                                            {{-- <option value="Operasional">Operasional</option> --}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- End LKHP --}}
                        </div>
                        <div class="card card-outline card-primary mb-0"></div>
                    </div>

                    {{-- kkpk old --}}
                    <div class="card card-outline card-secondary">
                        <div class="card-header">
                            <h5 class="head" style="color: red;"># Data Lama &rlhar;</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-sm" style="font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th colspan="2">
                                            <a href="/data-lkhp-tambah-kkpk/{{ encrypt($data->id_lkhp) }}"
                                                class="btn btn-sm btn-outline-primary" style="font-size: 12px"> + Tambah
                                                KKPK</a>
                                        </th>
                                        <th colspan="4" style="text-align: center; color: red">DATA KKPK</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Data KKPK</th>
                                        <th>Data Debitur</th>
                                        <th>Data Risk Event</th>
                                        <th>Tgl Pemeriksaan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pivot as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <ul>
                                                    <li>{{ $item->kkpk->kode_kkpk }}</li>
                                                    <li>{{ $item->kkpk->jns_pemeriksaan }}</li>
                                                    <li>{{ $item->kkpk->nama_pemeriksa }}</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>{{ $item->kkpk->debitur->no_rekening }}</li>
                                                    <li>{{ $item->kkpk->debitur->nama_nasabah }}</li>
                                                    <li>BD:
                                                        {{ $item->kkpk->debitur->baki_debet ? 'Rp ' . number_format($item->kkpk->debitur->baki_debet, 0, ',', '.') : 'belum ada data' }}
                                                    </li>
                                                </ul>
                                            </td>
                                            <td>
                                                <input type="hidden"
                                                    value="{{ $risk_event = $pivotAll->where('id_kkpk', $item->id_kkpk) }}">
                                                <ul>
                                                    @foreach ($risk_event as $risk)
                                                        <li>{{ $risk->riskEvent->kode_finding }}</li>
                                                        <li>{{ $risk->riskEvent->list_finding }}</li>
                                                        <li>{{ $risk->riskEvent->indikasi_resiko }}</li>
                                                        <hr>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>{{ $item->kkpk->tgl_pemeriksaan->translatedFormat('d F Y') }}</td>
                                            <td>
                                                <a href="{{ route('lkhp-edit', ['Id' => encrypt($item->id_kkpk)]) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fa fa-edit"></i></a>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger hapus"
                                                    id="{{ $item->id_kkpk }}" data-id_lkhp="{{ $item->id_lkhp }}"
                                                    data-id_en="{{ encrypt($item->id_lkhp) }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card card-outline card-secondary mb-0"></div>
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="desc_keadaan_seharusnya">Desc Keadaan Seharusnya
                                            :</label>
                                        <textarea name="desc_keadaan_seharusnya" id="desc_keadaan_seharusnya" cols="20" rows="5">
                                            {!! $data->desc_keadaan_seharusnya !!}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="penyebab_terjadi_penyimpangan">Penyebab Terjadinya
                                            Penyimpangan
                                            :</label>
                                        <textarea name="penyebab_terjadi_penyimpangan" id="penyebab_terjadi_penyimpangan" cols="20" rows="5">
                                            {!! $data->penyebab_terjadi_penyimpangan !!}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="dampak_resiko">Dampak/Resiko :</label>
                                        <textarea name="dampak_resiko" id="dampak_resiko" cols="20" rows="5">
                                            {!! $data->dampak_resiko !!}
                                        </textarea>
                                    </div>
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
    <script src="{{ asset('script/lkhp/edit/lkhp_edit_config.js') }}"></script>
    <script src="{{ asset('script/lkhp/add/lkhp_add_fungsi1.js') }}"></script>
    <script src="{{ asset('script/lkhp/add/lkhp_add_flexible_kkpk.js') }}"></script>
    <script src="{{ asset('script/lkhp/add/lkhp_add_flexible_re.js') }}"></script>
    <script src="{{ asset('script/lkhp/add/lkhp_add_flexible_gambar.js') }}"></script>
    <script src="{{ asset('script/lkhp/edit/confirm-edit.js') }}"></script>

    <script>
        $(function() {
            $(document).on('click', '.hapus', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");
                let id = $(this).attr("id");
                let id_lkhp = $(this).data("id_lkhp");
                let id_en = $(this).data("id_en");
                console.log('id kkpk = ' + id);
                console.log('id lkhp = ' + id_lkhp);
                console.log('id en = ' + id_en);

                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Anda Ingin Menghapus Data Ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Mengirim permintaan penghapusan ke server menggunakan Ajax
                        $.ajax({
                            url: '/data-lkhp-hapus/' + id + '/' + id_lkhp,
                            type: 'POST',
                            data: {
                                '_method': 'DELETE',
                                '_token': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Sukses!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href =
                                            "/data-lkhp/" + id_en + "/edit"
                                    }
                                });
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'An error occurred while deleting the data.',
                                    'error'
                                );
                            }
                        });
                    } else {
                        Swal.fire("Cancelled", "Data Tidak Terhapus :)", "error");
                    }
                });
            });
        });
    </script>
@endsection
@endsection
