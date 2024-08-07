$(document).ready(function () {
    $(".btnpdf").on("click", function () {
        var id = $(this).data("id");

        Swal.fire({
            title: "Konfirmasi Cetak LKHP",
            text: "Apakah Anda yakin ingin mencetak LKHP?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Cetak!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                // window.location.href = '/print-perjanjian-kredit-pk/' + id;
                window.open("/print-lkhp-as-pdf/" + id, "_blank");
            }
        });
    });
});

$(document).ready(function () {
    $(".btnword").on("click", function () {
        var id = $(this).data("id");

        Swal.fire({
            title: "Konfirmasi Cetak LKHP",
            text: "Apakah Anda yakin ingin mencetak LKHP?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Cetak!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                // window.location.href = '/print-perjanjian-kredit-pk/' + id;
                window.open("/print-lkhp-as-word/" + id, "_blank");
            }
        });
    });
});
