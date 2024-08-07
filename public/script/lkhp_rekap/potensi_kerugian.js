$(document).on("click", "#btn-filter", function () {
    let min = $("#min").val();
    let max = $("#max").val();
    let objek_pemeriksaan = $("#objek_pemeriksaan").val();
    let id_cabang = $("#id_cabang").val();

    // console.log("Min: ", min);
    // console.log("Max: ", max);
    if (id_cabang == null) {
        alert("Filter Kantor Cabang Tidak Boleh Kosong!");
    } else if (objek_pemeriksaan == null) {
        alert("Filter Objek Pemeriksaan Tidak Boleh Kosong!");
    } else {
        if (min == null || max == null) {
            min = "null";
            max = "null";
        }
        // console.log(min);
        // console.log(max);
        // console.log(objek_pemeriksaan);
        // console.log(id_cabang);
        $("#potensi_kerugian").attr(
            "src",
            "/potensi-kerugian/" +
                min +
                "/" +
                max +
                "/" +
                id_cabang +
                "/" +
                objek_pemeriksaan
        ); //merubah link frame
    }
});

$(document).on("click", "#btn-refresh", function () {
    $("#potensi_kerugian").attr("src", ""); //merubah link frame
});
// end datatables
