// Data tables
$(document).ready(function () {
    loadtable();
});

function loadtable(min, max, cari) {
    $(document).ready(function () {
        $("#table_index").DataTable({
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
                url: "lainnya",
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
                    data: "nama",
                    name: "nama",
                },
                {
                    data: "jabatan",
                    name: "jabatan",
                },
                {
                    data: "action",
                    name: "action",
                    searchable: false,
                },
            ],

            lengthMenu: [
                [10, 20, 50, -1],
                [10, 20, 50, "Semua"],
            ],
        });
    });
}
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
            url: "/lainnya/" + Id + "/edit",
            success: function (response) {
                console.log("Rz wuzz here");
                $("#nama_edit").val(response.data.nama);
                $("#jabatan_edit").val(response.data.jabatan);

                // link formnya
                $("#editForm").attr("action", "/lainnya/" + Id);
            },
        });
    });
});
// end edit data

// ############$$$##############
// Hapus Data Mode Simple
// $("body").on("click", ".hapus", function () {
//     var Id = $(this).attr("id");
//     var Kode = $(this).data("kode_form");
//     console.log(Id);
//     Swal.fire({
//         title: "Apakah Anda Yakin?",
//         text: "Menghapus Data Akan Hilang Secara Permanen!",
//         icon: "warning",
//         showCancelButton: true,
//         confirmButtonColor: "#3085d6",
//         cancelButtonColor: "#d33",
//         confirmButtonText: "Yes, delete it!",
//     }).then((result) => {
//         if (result.isConfirmed) {
//             window.location.href = "/risk-event-delete/" + Id;
//         } else {
//             Swal.fire("Cancelled", "Data Tidak Terhapus :)", "error");
//         }
//     });
// });
// End Hapus Data Mode Simple
// NOTE: MODE HARD ADA DI INDEX
