$(document).ready(function () {
    FlexRE(1);
});

// #############$$$#############
// flexibel tambah risk event
function FlexRE(count_one) {
    let count_two = 1;
    let container = document.getElementById(
        `tambahan_risk_event_${count_one}_${count_two}`
    );
    let addButton = document.getElementById(
        `tambah_re_${count_one}_${count_two}`
    );

    addButton.addEventListener("click", function () {
        count_two++;

        let newDiv = document.createElement("div");
        // Mendapatkan nilai JSON dari input HTML
        let riskEventDataString = document.getElementById("riskEvent").value;
        // Menguraikan nilai JSON menjadi objek JavaScript
        let riskEventData = JSON.parse(riskEventDataString);

        newDiv.className = "pembungkus_re";

        let innerHTML = `
        <div class="row ml-2">
            <hr style="width: 95%;">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="id_event_risk_${count_one}_${count_two}">Pilih Risk Event ${count_one}_${count_two} :</label>
                        <select name="id_event_risk_${count_one}_${count_two}" id="id_event_risk_${count_one}_${count_two}" autocomplete="off" required
                            class="form-control input select2 form-control-sm">
                            <option selected disabled>- Pilih KKPK Terlebih Dahulu! -</option>`;
        // Gunakan data JSON untuk membangun opsi Select2
        riskEventData.forEach(function (risk) {
            innerHTML += `
                    <option value="${risk.id_event_risk}">
                        (${risk.kode_finding})
                        - ${risk.sub_activity} - ${risk.list_finding}
                    </option>`;
        });
        innerHTML += `</select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="">&nbsp;</label>
                    <input class="btn-outline-danger form-control form-control-sm mb-3" type="button"
                        value="(-) Kurangi Risk Event (-)">
                </div>
                <div class="col-md-12">
                <div class="form-group">
                        <label for="keterangan_re_${count_one}_${count_two}" class="wajib">Keterangan</label>
                        <textarea class="form-control input" name="keterangan_re_${count_one}_${count_two}" id="keterangan_re_${count_one}_${count_two}" cols="30" rows="5"></textarea>
                </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="img_re_${count_one}_${count_two}_1">Upload Gambar Pendukung :</label>
                        <input class="form-control form-control-sm" type="file" name="img_re_${count_one}_${count_two}_1"
                            id="img_re_${count_one}_${count_two}_1" accept="image/jpeg,image/jpg,image/png">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="caption_re_${count_one}_${count_two}_1">Captionnya :</label>
                        <input class="form-control form-control-sm" type="text" name="caption_re_${count_one}_${count_two}_1"
                            id="caption_re_${count_one}_${count_two}_1">
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="">&nbsp;</label>
                    <input class="btn-outline-primary form-control form-control-sm mb-3" type="button"
                        id="gambar_add_${count_one}_${count_two}_1" value="(+) Tambah Gambar (+)">
                </div>
        </div>
                <div id="tambahan_gambar_${count_one}_${count_two}_1"></div>
                <hr style="width: 95%;">
                `;

        newDiv.innerHTML = innerHTML;
        container.appendChild(newDiv);

        // fungsi add image
        AddImage(count_one, count_two);
        // config summernote
        configSummernote(count_one, count_two);
        // config Input
        configInput(count_one, count_two);
    });

    // Untuk mengurangi inputan
    container.addEventListener("click", function (e) {
        // Periksa apakah elemen yang dipilih adalah tombol dan memiliki nilai yang sesuai
        if (
            e.target.tagName === "INPUT" &&
            e.target.value === "(-) Kurangi Risk Event (-)"
        ) {
            e.preventDefault();

            // Temukan elemen <div> yang berisi tombol yang dipilih
            var divToRemove = e.target.closest(".pembungkus_re");

            // Hapus elemen <div> tersebut dari container
            if (divToRemove) {
                container.removeChild(divToRemove);
                count_two--;
            }
        }
    });
}
// End flexibel tambah risk event
