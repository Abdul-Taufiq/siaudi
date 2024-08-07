@extends('partial.main')
@section('konten')
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
                                    <a class="btn btn-success btn-icon-split btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addModal">
                                        <span class="icon text-white-50">
                                            <i class="fa-solid fa-file-import"></i>
                                        </span>
                                        <span class="text">Tambah {{ $title }} <b> By Upload Excel</b></span>
                                    </a>

                                    &nbsp;
                                    <a class="btn btn-primary btn-icon-split btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addModalManual">
                                        <span class="icon text-white-50">
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                        </span>
                                        <span class="text">Tambah {{ $title }} <b>By Manual</b></span>
                                    </a>
                                    <br>
                                    <br>

                                {{-- filter per tanggal --}}
                                <div class="d-flex align-items-center justify-content-center flex-wrap">
                                    <strong class="mb-2 mr-4">
                                        <span class="text">Filter Pertanggal</span>
                                    </strong>
                                    <div class="d-flex align-items-end mr-2">
                                        <div class="form-group mb-2">
                                            <label for="min" class="sr-only">From:</label>
                                            <input type="date" name="min" id="min" class="form-control">
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="max" class="sr-only">To:</label>
                                            <input type="date" name="max" id="max" class="form-control">
                                        </div>
                                    </div>
                                    <div class="btn-group mb-2">
                                        <button id="btn-filter" class="btn btn-success">Filter</button>
                                        <button id="btn-refresh" class="btn btn-info">Refresh</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Total NOA : </label>
                                        <p id="total_noa">NULL</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Total Plafon : </label>
                                        <p id="total_plafon">NULL</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Total Baki Debet : </label>
                                        <p id="total_bd">NULL</p>
                                    </div>
                                </div>

                                <br>
                                <table id="table_index" class="table table-hover table-striped table-bordered"
                                    style="width: 100%">
                                    <thead style="background-color: lightseagreen">
                                        <tr>
                                            <th style="10px">#</th> {{-- 0 --}}
                                            <th>Kantor Cabang</th>
                                            <th>No Rek</th>
                                            <th>Nama Nasabah</th>
                                            <th>Alamat</th>
                                            <th>Tgl Realisasi</th>
                                            <th>JKW</th>
                                            <th>Tgl Jatuh Tempo</th>
                                            <th>Plafon</th>
                                            <th>Baki Debet</th>
                                            <th>Tunggakan Bunga</th>
                                            <th>Tunggakan Pokok</th>
                                            <th>DPD</th>
                                            <th>Kol</th>
                                            <th>No Hp</th>
                                            <th>Kolektor</th>

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
        @include('Page.Debitur.modal')
        {{-- end modal --}}

        {{-- mengamibil user untuk menentukan tombol export --}}
        <input hidden type="text" id="user" value="{{ Auth::user()->level }}">

    </div>

@section('script')
    <script src="{{ asset('script/debitur_index.js') }}"></script>
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
                            url: '/debitur/' + id,
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
                                            "/debitur"
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
