// ADD FORM
$(document).ready(function () {
    // Select all label elements that do not have the class "custom-control-label"
    var labels = document.querySelectorAll("label:not(.custom-control-label)");

    // Loop through each label element
    for (var i = 0; i < labels.length; i++) {
        // Add the class "wajib" to the current label element
        labels[i].classList.add("wajib");
    }

    $("#simpan").on("click", function () {
        // Ganti #nama_form sesuai dengan ID formulir Anda
        var $form = $("#EditForm");

        // Validasi input yang diperlukan
        var inputRequired = $form.find("[required]").not(".trix-input--dialog");
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
});
