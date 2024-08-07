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
                                @can('addEvent', App\Models\RiskEvent\RiskEvent::class)
                                    &nbsp;
                                    <a class="btn btn-primary btn-icon-split btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addModalManual">
                                        <span class="icon text-white-50">
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                        </span>
                                        <span class="text">Tambah {{ $title }} </span>
                                    </a>
                                    <br>
                                @endcan
                            </div>
                            <div class="card-body">
                                <table id="table_index" class="table table-hover table-striped table-bordered"
                                    width="100%">
                                    <thead style="background-color: lightseagreen">
                                        <tr>
                                            <th style="width: 5%">#</th> {{-- 0 --}}
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th style="width: 15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
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
        @include('Page.Z Lainnya.modal')
        {{-- end modal --}}

    </div>

@section('script')
    <script src="{{ asset('script/Zlainnya.js') }}"></script>
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
                            url: '/lainnya/' + id,
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
                                            "/lainnya"
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
