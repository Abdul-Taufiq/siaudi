@extends('partial.main')
@section('konten')
    <style>
        label {
            font-size: 12px;
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
                                @if (auth()->user()->jabatan == 'Internal Audit')
                                    <a href="data-lkhp/create" class="btn btn-primary btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                        </span>
                                        <span class="text">Tambah LKHP - Kredit</span>
                                    </a>
                                    <a href="data-lkhp-ops/create" class="btn btn-info btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                        </span>
                                        <span class="text">Tambah LKHP - Non-KKPK</span>
                                    </a>
                                    <br>
                                    <br>
                                @endif

                                {{-- filter per tanggal --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label for="min" class="">Filter dari:</label>
                                                    <input type="date" name="min" id="min"
                                                        class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label for="max" class="">To:</label>
                                                    <input type="date" name="max" id="max"
                                                        class="form-control form-control-sm">
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
                                <table id="table_index"
                                    class="display nowrap table table-hover table-striped table-bordered"
                                    style="width: 100%">
                                    <thead style="background-color: lightseagreen">
                                        <tr>
                                            <th style="10px">#</th> {{-- 0 --}}
                                            <th>Kantor Cabang</th>
                                            <th>No LK Bayangan</th>
                                            <th>Nama Pemeriksa</th>
                                            <th>Tgl Pemeriksaan</th>
                                            <th>Objek Pemeriksaan</th>

                                            <th>Tanggal Create</th>
                                            <th>Last Update</th>
                                            <th style="width: 10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
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
    <script src="{{ asset('script/lkhp/lkhp_index.js') }}"></script>

    <script>
        $(function() {
            $(document).on('click', '.hapus', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");
                let id = $(this).attr("id");
                // alert(id);

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
                            url: '/data-lkhp/' + id,
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
                                            "/data-lkhp"
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
