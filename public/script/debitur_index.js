// Data tables
$(document).ready(function () {
    loadtable();
    loadtotal();
});

function loadtotal(min, max, cari) {
    $(document).ready(function () {
        $.ajax({
            type: "GET",
            url: "/debitur/noa/all",
            data: {
                min: min,
                max: max,
                cari: cari,
            },
            success: function (response) {
                console.log("Rz wuzz here");
                console.log(response.data);
                $("#total_noa").text(response.data.length + " Noa");

                // Rupiah plafon
                var plafon = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                }).format(response.totalPlafon);
                // Rupiag BD
                var bd = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                }).format(response.totalBakiDebet);

                $("#total_plafon").text(plafon);
                $("#total_bd").text(bd);
            },
        });
    });
}

function loadtable(min, max, cari) {
    $(document).ready(function () {
        // Mendapatkan nilai kode dari URL (jika ada, notifikasi)
        // var urlParams = new URLSearchParams(window.location.search);
        // var kode = urlParams.get("kode");

        // kondisi memunculkan button export
        var level = $("#user").val();
        var buttons = ["colvis"];
        if (level == "SUPER USER" || level == "DIREKTUR") {
            var show = true;
        } else {
            var show = false;
        }

        if (show) {
            buttons.push([
                {
                    extend: "copyHtml5",
                    exportOptions: {
                        columns: [
                            0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14,
                            15, 16, 17, 18, 19, 20, 21,
                        ],
                    },
                },
                {
                    extend: "excelHtml5",
                    exportOptions: {
                        columns: [
                            0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14,
                            15, 16, 17, 18, 19, 20, 21,
                        ],
                    },
                },
                {
                    extend: "pdfHtml5",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                    },
                },
            ]);
        }
        // End kondisi memunculkan button export

        $("#table_index").DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
            scrollX: true,

            processing: true,
            serverSide: true,
            ajax: {
                // type: "post",
                url: "debitur",
                data: {
                    min: min,
                    max: max,
                    // kode: kode,
                    cari: cari,
                },
            },
            columns: [
                {
                    data: null,
                    sortable: false,
                    orderColumn: false,
                    ordering: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: "cabang",
                    name: "cabang",
                },
                {
                    data: "no_rekening",
                    name: "no_rekening",
                },
                {
                    data: "nama_nasabah",
                    name: "nama_nasabah",
                },
                {
                    data: "alamat",
                    name: "alamat",
                    searchable: false,
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        return moment(data.tgl_realisasi)
                            .locale("id")
                            .format("DD MMM YYYY");
                    },
                    searchable: false,
                },
                {
                    data: "jkw",
                    name: "jkw",
                    searchable: false,
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        return moment(data.tgl_jth_tempo)
                            .locale("id")
                            .format("DD MMM YYYY");
                    },
                    searchable: false,
                },
                {
                    data: "plafon",
                    name: "plafon",
                    render: function (data, type, row) {
                        var formattedNominal = new Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR",
                        }).format(data);
                        return formattedNominal;
                    },
                },
                {
                    data: "baki_debet",
                    name: "baki_debet",
                    searchable: false,
                    render: function (data, type, row) {
                        var formattedNominal = new Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR",
                        }).format(data);
                        return formattedNominal;
                    },
                },
                {
                    data: "tunggakan_bunga",
                    name: "tunggakan_bunga",
                    searchable: false,
                    render: function (data, type, row) {
                        var formattedNominal = new Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR",
                        }).format(data);
                        return formattedNominal;
                    },
                },
                {
                    data: "tunggakan_pokok",
                    name: "tunggakan_pokok",
                    searchable: false,
                    render: function (data, type, row) {
                        var formattedNominal = new Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR",
                        }).format(data);
                        return formattedNominal;
                    },
                },
                {
                    data: "dpd",
                    name: "dpd",
                    searchable: false,
                },
                {
                    data: "kol",
                    name: "kol",
                    searchable: false,
                },
                {
                    data: "no_hp",
                    name: "no_hp",
                    searchable: false,
                },
                {
                    data: "kolektor",
                    name: "kolektor",
                    searchable: false,
                },

                {
                    data: null,
                    render: function (data, type, row) {
                        return moment(data.created_at)
                            .locale("id")
                            .format("DD MMM YYYY, HH:mm");
                    },
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        return moment(data.updated_at)
                            .locale("id")
                            .format("DD MMM YYYY, HH:mm");
                    },
                },
                {
                    data: "action",
                    name: "action",
                    searchable: false,
                },
            ],

            columnDefs: [
                {
                    // targets: [
                    //     4, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18,
                    // ],
                    visible: false,
                    searchable: false,
                },
            ],

            dom:
                "<'row'<'col-md-3'l><'col-md-5'B><'col-md-4'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row'<'col-md-5'i><'col-md-7'p>>",
            buttons: buttons,
            lengthMenu: [
                [10, 20, 50, -1],
                [10, 20, 50, "Semua"],
            ],
        });
    });
}

$(document).on("click", "#btn-filter", function () {
    let min = $("#min").val();
    let max = $("#max").val();
    $("#table_index").DataTable().destroy();
    loadtable(min, max);
    loadtotal(min, max);
});

$(document).on("click", "#btn-refresh", function () {
    $("#table_index").DataTable().destroy();
    loadtable();
    loadtotal();
});
// end datatables

// ############$$$##############
// protect form input
$("input").attr("autocomplete", "off");
$(document).ready(function () {
    // default form danger
    $(".input").addClass("border-danger");
    $(document).ready(function () {
        // default form danger
        $(".input").addClass("border-danger");
    });

    $(document).on("input", ".input", function () {
        if ($(this).val().trim() === "") {
            // Jika kosong, berikan border warna merah dan hapus border warna hijau
            $(this).addClass("border-danger").removeClass("border-success");
        } else {
            // Jika tidak kosong, berikan border warna hijau dan hapus border warna merah
            $(this).addClass("border-success").removeClass("border-danger");
        }
    });
});

// ======================-
//Date picker
$("#date_tgl_realisasi").datetimepicker({
    format: "DD-MM-yyyy",
});
$("#date_tgl_jth_tempo").datetimepicker({
    format: "DD-MM-yyyy",
});
$("#date_tgl_realisasi_edit").datetimepicker({
    format: "DD-MM-yyyy",
});
$("#date_tgl_jth_tempo_edit").datetimepicker({
    format: "DD-MM-yyyy",
});

// format rupiah
var plafon = document.getElementById("plafon");
plafon.addEventListener("input", function (e) {
    this.value = formatRupiah(this.value, "Rp. ");
});
var baki_debet = document.getElementById("baki_debet");
baki_debet.addEventListener("input", function (e) {
    this.value = formatRupiah(this.value, "Rp. ");
});
var tunggakan_bunga = document.getElementById("tunggakan_bunga");
tunggakan_bunga.addEventListener("input", function (e) {
    this.value = formatRupiah(this.value, "Rp. ");
});
var tunggakan_pokok = document.getElementById("tunggakan_pokok");
tunggakan_pokok.addEventListener("input", function (e) {
    this.value = formatRupiah(this.value, "Rp. ");
});
var plafon_edit = document.getElementById("plafon_edit");
plafon_edit.addEventListener("input", function (e) {
    this.value = formatRupiah(this.value, "Rp. ");
});
var baki_debet_edit = document.getElementById("baki_debet_edit");
baki_debet_edit.addEventListener("input", function (e) {
    this.value = formatRupiah(this.value, "Rp. ");
});
var tunggakan_bunga_edit = document.getElementById("tunggakan_bunga_edit");
tunggakan_bunga_edit.addEventListener("input", function (e) {
    this.value = formatRupiah(this.value, "Rp. ");
});

/* Fungsi formatRupiah */
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
// Konfirm Add data
$(document).ready(function () {
    $(".form").on("click", "button", function () {
        var $form = $(this).closest("form");

        // Validasi input yang diperlukan
        var inputRequired = $form.find("[required]");
        var inputKosong = inputRequired.filter(function () {
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
$(document).ready(function () {
    $("body").on("click", ".edit", function () {
        var Id = $(this).attr("id");
        var Kode = $(this).data("kode_form");

        console.log("Nama Kredit:", Id, Kode);
        console.log("Copyright by Abdul Taufiq");
        $("#modalEditLabel").text("EDIT DATA - " + Kode);
        $("#modalEdit").modal("show");

        // Setiap kali tombol edit diklik, atur border menjadi border-success
        $("#editForm .input")
            .addClass("border-success")
            .removeClass("border-danger");

        $(document).on("input", "#editForm .input", function () {
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
            url: "/debitur/" + Id + "/edit",
            success: function (response) {
                console.log("Rz wuzz here");
                $("#cabang_edit").val(response.data.id_cabang);
                $("#no_rekening_edit").val(response.data.no_rekening);
                $("#nama_nasabah_edit").val(response.data.nama_nasabah);
                $("#alamat_edit").val(response.data.alamat);
                $("#jkw_edit").val(response.data.jkw);

                $("#tgl_realisasi_edit").val(
                    moment(response.data.tgl_realisasi)
                        .locale("id")
                        .format("DD-MM-yyyy")
                );
                $("#tgl_jth_tempo_edit").val(
                    moment(response.data.tgl_jth_tempo)
                        .locale("id")
                        .format("DD-MM-yyyy")
                );

                $("#plafon_edit").val(
                    (this.value = formatRupiah(response.data.plafon, "Rp. "))
                );
                $("#baki_debet_edit").val(
                    (this.value = formatRupiah(
                        response.data.baki_debet,
                        "Rp. "
                    ))
                );
                $("#tunggakan_bunga_edit").val(
                    (this.value = formatRupiah(
                        response.data.tunggakan_bunga,
                        "Rp. "
                    ))
                );
                $("#tunggakan_pokok_edit").val(
                    (this.value = formatRupiah(
                        response.data.tunggakan_pokok,
                        "Rp. "
                    ))
                );

                $("#dpd_edit").val(response.data.dpd);
                $("#kol_edit").val(response.data.kol);
                $("#no_hp_edit").val(response.data.no_hp);
                $("#kolektor_edit").val(response.data.kolektor);

                // link formnya
                $("#editForm").attr("action", "/debitur/" + Id);

                /* Fungsi formatRupiah */
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

                    rupiah =
                        split[1] !== undefined
                            ? rupiah + "," + split[1]
                            : rupiah;

                    return prefix && rupiah ? prefix + rupiah : rupiah;
                }
            },
        });
    });
});
// end edit data
