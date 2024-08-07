$(document).ready(function () {
    KkpkFromCabang(1, 1);
    DetailNasabah(1, 1);
});

// ############$$$############## {{
// Saat cabang dipilih, kirim permintaan AJAX untuk mendapatkan data kkpk
function KkpkFromCabang(count_one, count_two) {
    let cabangSelect = document.getElementById("id_cabang");
    let kkpkSelect = document.getElementById(
        `id_kkpk_${count_one}_${count_two}`
    );
    cabangSelect.addEventListener("change", function () {
        let cabangId = cabangSelect.value;
        $.ajax({
            type: "GET",
            url: "/get-kkpk/" + cabangId,
            success: function (response) {
                console.log("Rz wuzz here");
                let kkpkData = response.data;
                // Membersihkan data kkpk sebelum mengisinya kembali
                if (kkpkData <= 0) {
                    kkpkSelect.innerHTML =
                        "<option disabled selected>- Tidak Ada Data KKPK -</option>";
                } else {
                    kkpkSelect.innerHTML =
                        "<option disabled selected>- Pilih Data KKPK -</option>";
                }
                // Mengisi kembali data kkpk sesuai dengan respons dari server
                kkpkData.forEach(function (kkpk) {
                    let option = document.createElement("option");
                    option.value = kkpk.id_kkpk;
                    option.text =
                        kkpk.kode_kkpk +
                        " → (" +
                        kkpk.nama_pemeriksa +
                        ") → Tgl Pemeriksaan: " +
                        moment(kkpk.tgl_pemeriksaan)
                            .locale("id")
                            .format("DD MMM YYYY") +
                        " WIB";
                    kkpkSelect.appendChild(option);
                });

                // panggil fungsi detail nasabah
                DetailNasabah(count_one, count_two);
            },
        });
    });
}

// ############$$$##############
// detail nasabah
function DetailNasabah(count_one, count_two) {
    $(`#id_kkpk_${count_one}_${count_two}`).on("change", function () {
        let selectopt = $(this).val();
        // console.log(selectopt);
        $.ajax({
            type: "GET",
            url: "/get-detail-kkpk/" + selectopt,
            success: function (response) {
                // console.log("Rz wuzz here");

                let nasabahData = response.data;
                // console.log(nasabahData);
                $(`#nama_debitur_${count_one}_${count_two}`).text(
                    nasabahData.nama_nasabah
                );
                $(`#no_rekening_${count_one}_${count_two}`).text(
                    nasabahData.no_rekening
                );
                $(`#jkw_${count_one}_${count_two}`).text(nasabahData.jkw);
                $(`#status_${count_one}_${count_two}`).text(
                    nasabahData.kol + "/" + nasabahData.dpd
                );
                $(`#tgl_realisasi_${count_one}_${count_two}`).text(
                    moment(nasabahData.tgl_realisasi).locale("id").format("LL")
                );
                $(`#tgl_jth_tempo_${count_one}_${count_two}`).text(
                    moment(nasabahData.tgl_jth_tempo).locale("id").format("LL")
                );

                // Rupiah plafon
                var plafon = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                }).format(nasabahData.plafon);
                // Rupiag BD
                var bd = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                }).format(nasabahData.baki_debet);

                $(`#plafon_${count_one}_${count_two}`).text(plafon);
                $(`#baki_debet_${count_one}_${count_two}`).text(bd);

                // kkpk keterangan
                let kkpk_catatan = response.catatan;
                let catatan = document.getElementById(
                    `catatan_${count_one}_${count_two}`
                );
                catatan.innerHTML = "";
                let span = document.createElement("span");
                span.innerHTML = `
                    ${kkpk_catatan}
                `;
                catatan.appendChild(span);
            },
        });
    });
}
// end detail nasabah
