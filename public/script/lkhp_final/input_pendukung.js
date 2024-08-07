function showInput() {
    var input = document.getElementById("card_body");
    var lock = document.getElementById("showing");

    if (input.classList.contains("d-none")) {
        lock.classList.remove("fa-eye-slash");
        lock.classList.add("fa-eye");
        input.classList.remove("d-none");
    } else {
        lock.classList.remove("fa-eye");
        lock.classList.add("fa-eye-slash");
        input.classList.add("d-none");
    }
}

// config input
$("#date_komitmen_tgl").datetimepicker({
    format: "DD-MM-yyyy",
});

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
initializeSummernote(`#tanggapan_auditee`, "Keterangan...", 200);
initializeSummernote(`#komitmen_tindakan`, "Keterangan...", 200);
