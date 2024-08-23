@extends('partial.main')
@section('konten')
    <style>
        label {
            font-size: 9pt
        }

        .total {
            font-size: 10pt;
            margin: 0;
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

                        {{-- inputan konsolidasi --}}
                        <div class="card card-outline card-success">
                            <div class="card-header">
                                <b>Data Konsolidasi</b>
                            </div>
                            <div class="card-body">
                                <a class="btn btn-primary btn-icon-split btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#addModalManual">
                                    <span class="icon text-white-50">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    </span>
                                    <span class="text">Tambah {{ $title }} </span>
                                </a>
                                <br>
                                <br>
                                <table id="table_index" class="table table-hover table-sm table-striped table-bordered"
                                    style="width: 100%">
                                    <thead style="background-color: lightseagreen; text-align: center;">
                                        <tr>
                                            <th>#</th>
                                            <th>Periode Pemeriksaan</th>
                                            <th>Total NOA</th>
                                            <th>Total Plafon</th>
                                            <th>Total BD</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->periode_pemeriksaan->translatedFormat('d F Y') }}</td>
                                                <td>{{ $item->total_noa }}</td>
                                                <td>
                                                    {{ $item->total_plafon ? 'Rp ' . number_format($item->total_plafon, 0, ',', '.') : 'belum ada data' }}
                                                </td>
                                                <td>{{ $item->total_bd ? 'Rp ' . number_format($item->total_bd, 0, ',', '.') : 'belum ada data' }}
                                                </td>
                                                <td>
                                                    <a data-toggle="modal"
                                                        data-target="#modalEdit{{ $item->id_konsolidasi }}"
                                                        id="{{ $item->id_konsolidasi }}" class="btn btn-warning btn-sm edit"
                                                        data-kode_form="{{ $item->periode_pemeriksaan }}">
                                                        <i class="fa fa-edit"></i></a>
                                                    <a data-toggle="modal" id="{{ $item->id_konsolidasi }}"
                                                        class="hapus btn btn-danger btn-sm delete-post ">
                                                        <i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card card-outline card-success mb-0"></div>
                        </div>



                        {{-- filter + data --}}
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label for="min" class="">Filter dari Tahun:</label>
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
                                                    <select class="form-control form-control-sm" name="id_cabang"
                                                        id="id_cabang" readonly>
                                                        <option selected value="99">All Cabang</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="objek_pemeriksaan">Objek Pemeriksaan :</label>
                                                    <select class="form-control form-control-sm" name="objek_pemeriksaan"
                                                        id="objek_pemeriksaan">
                                                        <option disabled selected>- Pilih Objek Pemeriksaan -</option>
                                                        {{-- <option value="All">All</option> --}}
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
                                        <button id="btn-cetak" class="btn btn-primary btn-md">Cetak</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <iframe id="potensi_kerugian" frameborder="1" width="100%" height="720px"> </iframe>
                            </div>
                            <div class="card card-outline card-danger mb-0"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- Konten End --}}

        {{-- Modal --}}
        @include('Page.Potensi_Kerugian.Konsolidasi.modal')
        {{-- end modal --}}

        {{-- mengamibil user untuk menentukan tombol export --}}
        <input hidden type="text" id="user" value="{{ Auth::user()->level }}">
    </div>

@section('script')
    <script src="{{ asset('script/lkhp_rekap/lkhp_config.js') }}"></script>
    <script src="{{ asset('script/lkhp_rekap/potensi_kerugian.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#table_index").DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: true,
                oLanguage: {
                    sEmptyTable: "Secara Default Data Kosong, Silahkan Lakukan Filter Agar bisa memuat data!",
                },
                lengthMenu: [
                    [5, 10, 50, -1],
                    [5, 10, 50, "Semua"],
                ],
            });
        });

        // rupiah format
        var total_plafon = document.getElementById("total_plafon");
        total_plafon.addEventListener("input", function(e) {
            this.value = formatRupiah(this.value, "Rp. ");
        });
        var total_bd = document.getElementById("total_bd");
        total_bd.addEventListener("input", function(e) {
            this.value = formatRupiah(this.value, "Rp. ");
        });
        var total_plafon_edit = document.getElementById("total_plafon_edit");
        total_plafon_edit.addEventListener("input", function(e) {
            this.value = formatRupiah(this.value, "Rp. ");
        });
        var total_bd_edit = document.getElementById("total_bd_edit");
        total_bd_edit.addEventListener("input", function(e) {
            this.value = formatRupiah(this.value, "Rp. ");
        });

        function formatRupiah(angka, prefix) {
            var numberString = angka.replace(/[^,\d]/g, "").toString(),
                split = numberString.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] !== undefined ? rupiah + "," + split[1] : rupiah;

            return prefix && rupiah ? prefix + rupiah : rupiah;
        }

        // ############$$$##############
        // protect form input
        $("input").attr("autocomplete", "off");
        $(document).ready(function() {
            // default form danger
            $(".input").addClass("border-danger");
            $(".input").attr("required", true);
            $(document).ready(function() {
                // default form danger
                $(".input").addClass("border-danger");
            });

            $(document).on("input", ".input", function() {
                if ($(this).val().trim() === "") {
                    // Jika kosong, berikan border warna merah dan hapus border warna hijau
                    $(this).addClass("border-danger").removeClass("border-success");
                } else {
                    // Jika tidak kosong, berikan border warna hijau dan hapus border warna merah
                    $(this).addClass("border-success").removeClass("border-danger");
                }
            });
        });

        // ############$$$##############
        // Konfirm Add data
        $(document).ready(function() {
            $(".form").on("click", "button", function() {
                var $form = $(this).closest("form");

                // Validasi input yang diperlukan
                var inputRequired = $form.find("[required]");
                var inputKosong = inputRequired.filter(function() {
                    var val = $(this).val();
                    return val === null || val.trim() === "";
                });
                console.log(inputKosong);

                var $clickedButton = $(this);
                var buttonText = $clickedButton.text().trim(); // Ambil teks dari tombol yang diklik

                if (buttonText === "SIMPAN") {
                    // Periksa apakah tombol yang diklik bukanlah tombol "Kembali"
                    if (inputKosong.length > 0) {
                        // Jika ada input yang kosong, tampilkan alert gagal simpan
                        Swal.fire({
                            title: "Gagal Simpan Data!",
                            text: "ADA DATA MANDATORI YANG BELUM DIISI, PASTIKAN UNTUK MENGISI SEMUA DATA MANDATORI!",
                            icon: "error",
                        });
                        return;
                    }
                    // Jika semua input diperlukan sudah terisi, tampilkan konfirmasi simpan
                    Swal.fire({
                        title: "Konfirmasi Simpan Data!",
                        text: "SEBELUM MENYIMPAN DATA HARAP PERHATIKAN BAHWA DATA SUDAH BENAR! DAN JANGAN LEWATKAN PERINGATAN SEKECIL APAPUN!",
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Simpan!",
                        cancelButtonText: "Batal",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $form.submit();
                        }
                    });
                } else {
                    // Jika tombol yang diklik adalah tombol "Kembali", tidak lakukan apa-apa
                }
            });
        });
        // End Konfirm Add data

        // ############$$$##############
        // edit data
        $(document).ready(function() {
            $("body").on("click", ".edit", function() {
                var Id = $(this).attr("id");
                var Kode = $(this).data("kode_form");

                console.log("Nama Kredit:", Id, Kode);
                console.log("Copyright by Abdul Taufiq");
                $("#modalEditLabel").text("EDIT DATA - " + moment(Kode)
                    .locale("id")
                    .format("L"));
                $("#modalEdit").modal("show");

                // Setiap kali tombol edit diklik, atur border menjadi border-success
                $("#editForm .input")
                    .addClass("border-success")
                    .removeClass("border-danger");

                $(document).on("input", "#editForm .input", function() {
                    if ($(this).val().trim() === "") {
                        // Jika kosong, berikan border warna merah dan hapus border warna hijau
                        $(this).addClass("border-danger").removeClass("border-success");
                    } else {
                        // Jika tidak kosong, berikan border warna hijau dan hapus border warna merah
                        $(this).addClass("border-success").removeClass("border-danger");
                    }
                });

                $.ajax({
                    type: "GET",
                    url: "/potensi-loss-konsolidasi/" + Id + "/edit",
                    success: function(response) {
                        console.log("Rz wuzz here");
                        // $("#periode_pemeriksaan_edit").val(
                        //     moment(response.data.periode_pemeriksaan)
                        //     .locale("id")
                        //     .format("LL");
                        // );
                        $("#periode_pemeriksaan_edit").val(
                            moment(response.data.periode_pemeriksaan).format("YYYY-MM-DD")
                        );

                        $("#total_noa_edit").val(response.data.total_noa);
                        $("#total_plafon_edit").val(formatRupiah(response.data.total_plafon
                            .toString(),
                            "Rp. "));
                        $("#total_bd_edit").val(formatRupiah(response.data.total_bd.toString(),
                            "Rp. "));


                        // link formnya
                        $("#editForm").attr("action", "/potensi-loss-konsolidasi/" + Id);


                        function formatRupiah(angka, prefix) {
                            var numberString = angka.replace(/[^,\d]/g, "").toString(),
                                split = numberString.split(","),
                                sisa = split[0].length % 3,
                                rupiah = split[0].substr(0, sisa),
                                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                            if (ribuan) {
                                separator = sisa ? "." : "";
                                rupiah += separator + ribuan.join(".");
                            }

                            rupiah = split[1] !== undefined ? rupiah + "," + split[1] : rupiah;

                            return prefix && rupiah ? prefix + rupiah : rupiah;
                        }
                    },
                });
            });
        });
        // end edit data
    </script>
@endsection
@endsection
