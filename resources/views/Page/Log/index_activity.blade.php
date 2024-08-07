@extends('partial.main')
@section('konten')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="card card-outline card-info">
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
                        <div class="card card-outline card-info">
                            <div class="card-header">

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
                                <table id="table_log" class="table table-hover table-striped table-bordered" width="100%">
                                    <thead style="background-color: lightseagreen">
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Username</th>
                                            <th>Jabatan</th>
                                            <th>Aksi</th>
                                            <th>Tanggal Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card card-outline card-info mb-0"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

@section('script')
    <script>
        // table
        $(document).ready(function() {
            loadtable()
        })

        function loadtable(min, max) {
            $(document).ready(function() {

                $("#table_log").DataTable({
                    paging: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    autoWidth: false,
                    responsive: true,

                    processing: true,
                    serverSide: true,
                    ajax: {
                        // type: "post",
                        url: "log-act",
                        data: {
                            min: min,
                            max: max
                        }
                    },
                    columns: [{
                            data: null,
                            sortable: false,
                            orderColumn: false,
                            ordering: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            },
                        },
                        {
                            data: "username",
                            name: "username"
                        },
                        {
                            data: "jabatan",
                            name: "jabatan"
                        },
                        {
                            data: "aksi",
                            name: "aksi",
                            render: function(data, type, row) {
                                // Menggunakan jQuery untuk menginisialisasi HTML dari string
                                // return $('<div/>').html(data).text(); //berhasil
                                // atau
                                var div = document.createElement('div');
                                div.innerHTML = data;
                                return div.innerText;
                            }
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return moment(data.created_at)
                                    .locale("id")
                                    .format("DD MMM YYYY, HH:mm:ss");
                            },
                        },
                    ],

                    lengthMenu: [
                        [10, 20, 50, -1],
                        [10, 20, 50, "Semua"],
                    ],
                });

                // tabel.buttons().container().appendTo("#tabel1_wrapper .col-md-6:eq(0)");
            });
        }

        $(document).on('click', '#btn-filter', function() {
            let min = $('#min').val()
            let max = $('#max').val()
            $('#table_log').DataTable().destroy()
            loadtable(min, max)
        })

        $(document).on('click', '#btn-refresh', function() {
            $('#table_log').DataTable().destroy()
            loadtable()
        })
    </script>
@endsection
@endsection
