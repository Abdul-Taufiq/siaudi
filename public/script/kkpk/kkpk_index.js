// Data tables
$(document).ready(function () {
    loadtable();
});

function loadtable(min, max, id_cabang) {
    $(document).ready(function () {
        // Mendapatkan nilai kode dari URL (jika ada)
        var urlParams = new URLSearchParams(window.location.search);
        var kode = urlParams.get("kode");

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
                        columns: [0, 1, 2, 3, 4, 5, 6],
                    },
                },
                {
                    extend: "excelHtml5",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
                    },
                },
                {
                    extend: "pdfHtml5",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
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
            // scrollX: true,
            oLanguage: {
                sEmptyTable: "Tidak Ada Data Yang Ditemukan!",
            },

            processing: true,
            serverSide: true,
            ajax: {
                // type: "post",
                url: "data-kkpk",
                data: {
                    min: min,
                    max: max,
                    id_cabang: id_cabang,
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
                    data: "kode_kkpk",
                    name: "kode_kkpk",
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
                    data: "nama_pemeriksa",
                    name: "nama_pemeriksa",
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        return moment(data.tgl_pemeriksaan)
                            .locale("id")
                            .format("DD MMM YYYY");
                    },
                },
                {
                    data: "jns_pemeriksaan",
                    name: "jns_pemeriksaan",
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
                    targets: [7, 8],
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
    let id_cabang = $("#id_cabang").val();

    // console.log("Min: ", min);
    // console.log("Max: ", max);
    if (id_cabang == null) {
        alert("Filter Kantor Cabang Tidak Boleh Kosong!");
    } else {
        $("#table_index").DataTable().destroy();
        loadtable(min, max, id_cabang);
    }
});

$(document).on("click", "#btn-refresh", function () {
    $("#table_index").DataTable().destroy();
    loadtable();
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

// Select2 On modal
// In your Javascript (external .js resource or <script> tag)
$(document).ready(function () {
    $("#id_debitur").select2({
        dropdownParent: $("#addModal"),
    });
});
// Select 2 border color if change
// Mendapatkan elemen Select2
var select2Element = $(".select2");

// Menambahkan event listener untuk perubahan nilai Select2
select2Element.on("change", function () {
    // Mendapatkan nilai Select2
    var selectedValue = $(this).val();

    // Memeriksa apakah Select2 memiliki nilai
    if (selectedValue) {
        // Jika ada nilai, atur border menjadi hijau
        $(this)
            .next(".select2-container")
            .find(".select2-selection--single")
            .css("border-color", "green"); // warna hijau
    } else {
        // Jika tidak ada nilai, atur border menjadi merah
        $(this)
            .next(".select2-container")
            .find(".select2-selection--single")
            .css("border-color", "green"); // warna merah
    }
});

// ############$$$##############
// select OPT nasabah berdasarkan ID Cabang
// Menentukan elemen select untuk cabang dan data nasabah
var cabangSelect = document.getElementById("id_cabang");
var nasabahSelect = document.getElementById("id_debitur");
var nama_aoSelect = document.getElementById("nama_ao");
var nama_analisSelect = document.getElementById("nama_analis");
var nama_kakomSelect = document.getElementById("nama_kakom");
var nama_pincabSelect = document.getElementById("nama_pincab");
var nama_analis_areaSelect = document.getElementById("nama_analis_area");
var nama_area_managerSelect = document.getElementById("nama_area_manager");
var nama_manager_bisnisSelect = document.getElementById("nama_manager_bisnis");
var nama_analis_kpmSelect = document.getElementById("nama_analis_kpm");
var nama_direksiSelect = document.getElementById("nama_direksi");
// ############$$$##############
// inp nama pemutus kredit {{
$("#nama_ao").on("change", function () {
    var selectopt = $(this).val();
    var ao = document.getElementById("nama_ao_inp");
    if (selectopt == "Lainnya") {
        ao.classList.remove("hidden");
        $(ao).prop("required", true);
    } else {
        ao.classList.add("hidden");
        $(ao).prop("required", false);
    }
});
$("#nama_analis").on("change", function () {
    var selectopt = $(this).val();
    var elemen = document.getElementById("nama_analis_inp");
    if (selectopt == "Lainnya") {
        elemen.classList.remove("hidden");
        $(elemen).prop("required", true);
    } else {
        elemen.classList.add("hidden");
        $(elemen).prop("required", false);
    }
});
$("#nama_kakom").on("change", function () {
    var selectopt = $(this).val();
    var elemen = document.getElementById("nama_kakom_inp");
    if (selectopt == "Lainnya") {
        elemen.classList.remove("hidden");
        $(elemen).prop("required", true);
    } else {
        elemen.classList.add("hidden");
        $(elemen).prop("required", false);
    }
});
$("#nama_pincab").on("change", function () {
    var selectopt = $(this).val();
    var elemen = document.getElementById("nama_pincab_inp");
    if (selectopt == "Lainnya") {
        elemen.classList.remove("hidden");
        $(elemen).prop("required", true);
    } else {
        elemen.classList.add("hidden");
        $(elemen).prop("required", false);
    }
});
// end }}

// ############$$$############## {{
// Saat cabang dipilih, kirim permintaan AJAX untuk mendapatkan data nasabah
cabangSelect.addEventListener("change", function () {
    var cabangId = cabangSelect.value;
    $.ajax({
        type: "GET",
        url: "/get-nasabah/" + cabangId,
        success: function (response) {
            console.log("Rz wuzz here");
            let nasabahData = response.data;
            // Membersihkan data nasabah sebelum mengisinya kembali
            if (nasabahData <= 0) {
                nasabahSelect.innerHTML =
                    "<option disabled selected>- Tidak Ada Data Nasabah -</option>";
            } else {
                nasabahSelect.innerHTML =
                    "<option disabled selected>- Pilih Data Nasabah -</option>";
            }
            // Mengisi kembali data nasabah sesuai dengan respons dari server
            nasabahData.forEach(function (nasabah) {
                var option = document.createElement("option");
                option.value = nasabah.id_debitur;
                option.text =
                    nasabah.no_rekening +
                    " → (" +
                    nasabah.nama_nasabah +
                    ") → Created_At: " +
                    moment(nasabah.created_at)
                        .locale("id")
                        .format("DD MMM YYYY, HH:mm") +
                    " WIB";
                nasabahSelect.appendChild(option);
            });

            // Mengisi kembali data nasabah sesuai dengan respons dari server
            var nama_ao = response.nama_ao;
            nama_ao.forEach(function (ao) {
                var option = document.createElement("option");
                option.value = ao.nama;
                option.text = ao.nama;
                nama_aoSelect.appendChild(option);
            });

            // Mengisi kembali data nasabah sesuai dengan respons dari server
            var nama_kakom = response.nama_kakom;
            nama_kakom.forEach(function (kakom) {
                var option = document.createElement("option");
                option.value = kakom.nama;
                option.text = kakom.nama;
                nama_kakomSelect.appendChild(option);
            });
            // Mengisi kembali data nasabah sesuai dengan respons dari server
            var nama_analis = response.nama_analis;
            nama_analis.forEach(function (analis) {
                var option = document.createElement("option");
                option.value = analis.nama;
                option.text = analis.nama;
                nama_analisSelect.appendChild(option);
            });
            // Mengisi kembali data nasabah sesuai dengan respons dari server
            var nama_pincab = response.nama_pincab;
            nama_pincab.forEach(function (pincab) {
                var option = document.createElement("option");
                option.value = pincab.nama;
                option.text = pincab.nama;
                nama_pincabSelect.appendChild(option);
            });
            // Mengisi kembali data nasabah sesuai dengan respons dari server
            var nama_analis_area = response.nama_analis_area;
            nama_analis_area.forEach(function (analis_area) {
                var option = document.createElement("option");
                option.value = analis_area.nama;
                option.text = analis_area.nama;
                nama_analis_areaSelect.appendChild(option);
            });
            // Mengisi kembali data nasabah sesuai dengan respons dari server
            var nama_area_manager = response.nama_area_manager;
            nama_area_manager.forEach(function (area_manager) {
                var option = document.createElement("option");
                option.value = area_manager.nama;
                option.text = area_manager.nama;
                nama_area_managerSelect.appendChild(option);
            });
            // Mengisi kembali data nasabah sesuai dengan respons dari server
            var nama_manager_bisnis = response.nama_manager_bisnis;
            nama_manager_bisnis.forEach(function (manager_bisnis) {
                var option = document.createElement("option");
                option.value = manager_bisnis.nama;
                option.text = manager_bisnis.nama;
                nama_manager_bisnisSelect.appendChild(option);
            });
            // Mengisi kembali data nasabah sesuai dengan respons dari server
            var nama_analis_kpm = response.nama_analis_kpm;
            nama_analis_kpm.forEach(function (analis_kpm) {
                var option = document.createElement("option");
                option.value = analis_kpm.nama;
                option.text = analis_kpm.nama;
                nama_analis_kpmSelect.appendChild(option);
            });
            // Mengisi kembali data nasabah sesuai dengan respons dari server
            var nama_direksi = response.nama_direksi;
            nama_direksi.forEach(function (direksi) {
                var option = document.createElement("option");
                option.value = direksi.nama;
                option.text = direksi.nama;
                nama_direksiSelect.appendChild(option);
            });
        },
    });
});
// end }}

// ############$$$##############
// tambahan detail nasabah
$("#id_debitur").on("change", function () {
    var selectopt = $(this).val();
    // console.log(selectopt);
    $.ajax({
        type: "GET",
        url: "/get-detail-nasabah/" + selectopt,
        success: function (response) {
            console.log("Rz wuzz here");

            var nasabahData = response.data;
            // console.log(nasabahData);
            $("#nama_debitur").text(nasabahData.nama_nasabah);
            $("#no_rekening").text(nasabahData.no_rekening);
            $("#jkw").text(nasabahData.jkw);
            $("#status").text(nasabahData.kol + "/" + nasabahData.dpd);
            $("#tgl_realisasi").text(
                moment(nasabahData.tgl_realisasi).locale("id").format("LL")
            );
            $("#tgl_jth_tempo").text(
                moment(nasabahData.tgl_jth_tempo).locale("id").format("LL")
            );
            $("#plafon").text(
                (this.value = formatRupiah(nasabahData.plafon, "Rp. "))
            );
            $("#baki_debet").text(
                (this.value = formatRupiah(nasabahData.baki_debet, "Rp. "))
            );

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
                    split[1] !== undefined ? rupiah + "," + split[1] : rupiah;

                return prefix && rupiah ? prefix + rupiah : rupiah;
            }
        },
    });
});
// end tambahan detail nasabah

// ############$$$##############
// Konfirm Add data
$(document).ready(function () {
    // ADD FORM
    $("#simpan").on("click", function () {
        // Ganti #nama_form sesuai dengan ID formulir Anda
        var $form = $("#addForm");

        // Validasi input yang diperlukan
        var inputRequired = $form
            .find("[required]")
            .not(".trix-input--dialog")
            .not(".kecuali");
        var terms = document.getElementById("exampleCheck1");
        console.log(terms.checked);

        var inputKosong = inputRequired.filter(function () {
            var val = $(this).val();
            return val === null || val.trim() === "";
        });
        // console.log(inputKosong);

        if (terms.checked == false) {
            // Jika ada input yang kosong, tampilkan alert gagal simpan
            Swal.fire({
                title: "Gagal Simpan Data!",
                text: "PASTIKAN UNTUK MENYETUJUI TERMS APLIKASI!",
                icon: "error",
            });
            return;
        } else {
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
        }
    });

    // EDIT FORM
    $("#simpanEdit").on("click", function () {
        // Ganti #nama_form sesuai dengan ID formulir Anda
        var $form = $("#editForm");

        // Validasi input yang diperlukan
        var inputRequired = $form.find("[required]").not(".trix-input--dialog");
        var terms = document.getElementById("exampleEdits");
        console.log(terms.checked);

        var inputKosong = inputRequired.filter(function () {
            var val = $(this).val();
            return val === null || val.trim() === "";
        });
        // console.log(inputKosong);

        if (terms.checked == false) {
            // Jika ada input yang kosong, tampilkan alert gagal simpan
            Swal.fire({
                title: "Gagal Simpan Data!",
                text: "PASTIKAN UNTUK MENYETUJUI TERMS APLIKASI!",
                icon: "error",
            });
            return;
        } else {
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
        }
    });

    // ADD KKO
    $("#simpanKKO").on("click", function () {
        // Ganti #nama_form sesuai dengan ID formulir Anda
        var $form = $("#TambahKKO");

        // Validasi input yang diperlukan
        var inputRequired = $form.find("[required]");
        var terms = document.getElementById("TermsKKO");
        console.log(terms.checked);

        var inputKosong = inputRequired.filter(function () {
            var val = $(this).val();
            return val === null || val.trim() === "";
        });
        // console.log(inputKosong);

        if (terms.checked == false) {
            // Jika ada input yang kosong, tampilkan alert gagal simpan
            Swal.fire({
                title: "Gagal Simpan Data!",
                text: "PASTIKAN UNTUK MENYETUJUI TERMS APLIKASI!",
                icon: "error",
            });
            return;
        } else {
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
                text: "SEBELUM MENYIMPAN DATA HARAP PERHATIKAN BAHWA DATA SUDAH BENAR! SETELAH SIMPAN DATA TIDAK BISA DIEDIT!",
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
        }
    });
});
// End Konfirm Add data

//  ==================$$======================
// {{ show detail data modal }}
$(document).ready(function () {
    $("body").on("click", ".detail_data", function () {
        var Id = $(this).attr("id");
        var kode_form = $(this).data("kode_form");
        var data_ID = $(this).data("id");
        $("#myModal").modal("show");

        // var modalId = "myModal" + Id;
        // $("#myModal").attr("id", modalId); //merubah id dari modal
        $("#modalHeader").text("DETAIL DATA - Kode KKPK = " + kode_form);
        $("#frameDetail").attr("src", "/data-kkpk/" + Id); //merubah link frame
        $("#kkpk_print").attr("href", "/print-kkpk/" + data_ID);

        // modal ots / second modal
        document.getElementById("detail_data_kko").onclick = function () {
            $("#ModalKKO").modal("show"); // Tampilkan modal kedua
            $("#titleModalKKO").text(
                "DETAIL DATA OTS - Kode KKPK = " + kode_form
            );
            $("#frameDetailKKO").attr("src", "/show-kko/" + Id); //merubah link frame
            $("#ots_print").attr("href", "/print-kko/" + data_ID);
            $("#myModal").modal("hide"); // Tampilkan modal pertama
        };

        // Tambahkan event listener untuk menangkap penutupan modal
        // $("#" + modalId).on("hidden.bs.modal", function () {
        //     // Kembalikan ID modal ke nilai default
        //     $(this).attr("id", "myModal");
        // });
    });
});
// end shoe detail

// detail OTS second modal
// Fungsi untuk kembali ke modal pertama dari modal kedua
function closeMymodal() {
    $("#myModal").modal("hide"); // Tampilkan modal pertama
}
function OpenModalKKPK() {
    $("#ModalKKO").modal("hide"); // Sembunyikan modal kedua
    $("#myModal").modal("show"); // Tampilkan modal pertama
}
// Pastikan untuk menghapus kelas modal-open saat modal kedua ditutup
$("#ModalKKO").on("hidden.bs.modal", function () {
    if ($(".modal:visible").length) {
        $("body").addClass("modal-open");
    } else {
        $("body").removeClass("modal-open");
    }
});
// Pastikan untuk menghapus kelas modal-open saat modal pertama ditutup
$("#myModal").on("hidden.bs.modal", function () {
    if ($(".modal:visible").length) {
        $("body").addClass("modal-open");
    } else {
        $("body").removeClass("modal-open");
    }
});
// End detail OTS second modal

//
//  ========================================
// {{ Add KKO }}
$("#date_kunjungan").datetimepicker({
    format: "DD-MM-yyyy",
});
// $('.btn-codeview').prop('disabled', true);

$(document).ready(function () {
    $("body").on("click", ".tambah_kko", function () {
        var Id = $(this).attr("id");
        var Kode = $(this).data("kode_form");

        // config model
        // console.log("Nama Kredit:", Id, Kode);
        // console.log("Copyright by Abdul Taufiq");
        $("#addKKO").text("Tambah Data OTS - Kode KKPK = " + Kode);
        $("#modalTambahKKO").modal("show");

        // Setiap kali tombol edit diklik, atur border menjadi border-success
        $("#TambahKKO .input")
            .removeClass("border-success")
            .addClass("border-danger");

        $(document).on("input", "#modalTambahKKO .input", function () {
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
            url: "/get-detail-nasabah/" + Id,
            success: function (response) {
                console.log("Rz wuzz here");
                // console.log(Id);

                var nasabahData = response.data;
                // console.log(nasabahData);
                $("#nama_debitur_kko").text(nasabahData.nama_nasabah);
                $("#no_rekening_kko").text(nasabahData.no_rekening);
                $("#jkw_kko").text(nasabahData.jkw);
                $("#alamat_kko").text(nasabahData.alamat);

                // alterbatif 1
                // Extract and set text content from HTML in jaminan
                // var tempDiv = document.createElement("div");
                // tempDiv.innerHTML = nasabahData.jaminan;
                // var jaminanText =
                //     tempDiv.textContent || tempDiv.innerText || "";
                // $("#jaminan_kko").text(jaminanText);

                // var tempTujuan = document.createElement("div");
                // tempTujuan.innerHTML = nasabahData.tujuan_kredit;
                // var tujuan_kredit =
                //     tempTujuan.textContent || tempTujuan.innerText || "";
                // $("#tujuan_pinjaman_kko").text(tujuan_kredit);

                // alternatif 2
                let jaminan = document.getElementById("jaminan_kko");
                jaminan.innerHTML = "";
                let div = document.createElement("span");
                div.innerHTML = `
                    ${nasabahData.jaminan}
                `;
                jaminan.appendChild(div);

                let tujuan = document.getElementById("tujuan_pinjaman_kko");
                tujuan.innerHTML = "";
                let span = document.createElement("span");
                span.innerHTML = `
                    ${nasabahData.tujuan_kredit}
                `;
                tujuan.appendChild(span);

                $("#status_kko").text(nasabahData.kol + "/" + nasabahData.dpd);
                $("#tgl_realisasi_kko").text(
                    moment(nasabahData.tgl_realisasi).locale("id").format("LL")
                );
                $("#tgl_jth_tempo_kko").text(
                    moment(nasabahData.tgl_jth_tempo).locale("id").format("LL")
                );

                // belum bisa
                $("#plafon_kko").text(formatRupiah(nasabahData.plafon, "Rp. "));
                $("#baki_debet_kko").text(
                    formatRupiah(nasabahData.baki_debet, "Rp. ")
                );

                /* Fungsi formatRupiah */
                function formatRupiah(angka, prefix) {
                    var numberString = angka.toString().replace(/[^,\d]/g, ""),
                        split = numberString.split(","),
                        sisa = split[0].length % 3,
                        rupiah = split[0].substr(0, sisa),
                        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                    if (ribuan) {
                        var separator = sisa ? "." : "";
                        rupiah += separator + ribuan.join(".");
                    }

                    rupiah =
                        split[1] !== undefined
                            ? rupiah + "," + split[1]
                            : rupiah;

                    return prefix && rupiah ? prefix + rupiah : rupiah;
                }
            },
            error: function (xhr, status, error) {
                console.log("Error: " + error);
            },
        });

        // link formnya
        $("#TambahKKO").attr("action", "/add-kko/" + Id);
    });
});
// end Add KKO

//summernote
function initializeSummernote(selector, placeholder, height) {
    $(selector).summernote({
        placeholder: placeholder,
        tabsize: 2,
        height: height,
        callbacks: {
            onInit: function () {
                // Menambahkan kelas CSS ke elemen yang dihasilkan oleh Summernote
                $(selector).next(".note-editor").addClass("input");
            },
        },
    });
}

// Inisialisasi Summernote dengan selector, placeholder, dan tinggi yang berbeda
initializeSummernote("#deskripsi", "Keterangan...", 200);

// event hendrler summernote
$(document).on("summernote.change", function (e, contents) {
    var $editor = $(e.target).next(".note-editor");

    // Jika konten editor kosong, tambahkan kelas "border-danger", dan hapus kelas "border-success"
    if (contents.trim() === "") {
        $editor.addClass("border-danger").removeClass("border-success");
    } else {
        // Jika konten editor tidak kosong, tambahkan kelas "border-success", dan hapus kelas "border-danger"
        $editor.addClass("border-success").removeClass("border-danger");
    }
});
// Menonaktifkan tombol codeview untuk semua editor Summernote
$(".btn-codeview").prop("disabled", true);
$(".btn-fullscreen").prop("disabled", true);
$(".note-insert button").prop("disabled", true);
