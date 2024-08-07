//  =================$$===================
// {{ konfigurasi Lainnya }}
$(document).ready(function () {
    // ############$$$##############
    // date
    $("#date_tgl_awal").datetimepicker({
        format: "DD-MM-yyyy",
    });
    $("#date_tgl_akhir").datetimepicker({
        format: "DD-MM-yyyy",
    });

    // ############$$$##############
    // protect form input
    $("input").attr("autocomplete", "off");
    // default form danger
    $(".input").addClass("border-success");
    $(document).on("input", ".input", function () {
        if ($(this).val().trim() === "") {
            // Jika kosong, berikan border warna merah dan hapus border warna hijau
            $(this).addClass("border-danger").removeClass("border-success");
        } else {
            // Jika tidak kosong, berikan border warna hijau dan hapus border warna merah
            $(this).addClass("border-success").removeClass("border-danger");
        }
    });

    // Select all label elements that do not have the class "custom-control-label"
    var labels = document.querySelectorAll("label:not(.custom-control-label)");

    // Loop through each label element
    for (var i = 0; i < labels.length; i++) {
        // Add the class "wajib" to the current label element
        labels[i].classList.add("wajib");
    }

    configInput();
});

// fungsi configurasi inputan awal
function configInput() {
    // ############$$$##############
    // select2
    // Initialize Select2
    var select2Element = $(".select2").select2();

    // Add the class 'input' to the Select2 container
    select2Element
        .next(".select2-container")
        .find(".select2-selection--single")
        .addClass("input");

    // Event handler for change event on Select2
    select2Element.on("change", function () {
        var container = $(this)
            .next(".select2-container")
            .find(".select2-selection--single");

        if ($(this).val().trim() === "") {
            container.addClass("border-danger").removeClass("border-success");
        } else {
            container.addClass("border-success").removeClass("border-danger");
        }
    });

    // Initial check to set the border color based on the initial value
    select2Element.trigger("change");
}

//summernote
function initializeSummernote(selector, placeholder, height) {
    $(selector).summernote({
        placeholder: placeholder,
        tabsize: 2,
        height: height,
        callbacks: {
            onInit: function () {
                // Menambahkan kelas CSS ke elemen yang dihasilkan oleh Summernote
                $(selector)
                    .next(".note-editor")
                    .addClass("input")
                    .addClass("border-success");
            },
        },
    });
}

// Inisialisasi Summernote dengan selector, placeholder, dan tinggi yang berbeda
initializeSummernote(`.summernote`, "Keterangan...", 200);

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

// fungsi config summernote
function configSummernote() {
    $(`.summernote_tambahan`).summernote({
        placeholder: "Keterangan...",
        tabsize: 2,
        height: 200,
        callbacks: {
            onInit: function () {
                // Menambahkan kelas CSS ke elemen yang dihasilkan oleh Summernote
                $(`.summernote_tambahan`)
                    .next(".note-editor")
                    .addClass("input");
            },
        },
    });
    $(".btn-codeview").prop("disabled", true);
    $(`.summernote_tambahan`).next(".note-editor").addClass("border-danger");
    // Menangani perubahan konten pada editor Summernote
    $(`.summernote_tambahan`).on("summernote.change", function (_, contents) {
        // Jika konten editor kosong, tambahkan kelas "border-danger", dan hapus kelas "border-success"
        if (contents.trim() === "") {
            $(`.summernote_tambahan`)
                .next(".note-editor")
                .addClass("border-danger")
                .removeClass("border-success");
        } else {
            // Jika konten editor tidak kosong, tambahkan kelas "border-success", dan hapus kelas "border-danger"
            $(`.summernote_tambahan`)
                .next(".note-editor")
                .addClass("border-success")
                .removeClass("border-danger");
        }
    });
}
