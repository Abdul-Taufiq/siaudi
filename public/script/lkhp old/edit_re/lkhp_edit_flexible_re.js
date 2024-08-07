$(document).ready(function () {
    FlexRE();
});

// #############$$$#############
// flexibel tambah risk event
function FlexRE() {
    let container = document.getElementById(`tambahan_risk_event`);
    let addButton = document.getElementById(`tambah_re`);

    var inputElements = document.querySelectorAll(
        'textarea[name^="keterangan_re_"]'
    );

    // Mencari nomor terbesar dari nama input
    var angka_besar = 0;

    if (inputElements.length > 0) {
        inputElements.forEach(function (inputElement) {
            // Menggunakan ekspresi reguler untuk mencocokkan nomor pada nama input
            var match = inputElement.name.match(/\d+/);

            // Jika ada kecocokan dan nomornya lebih besar dari yang sudah ada
            if (match && parseInt(match[0]) > angka_besar) {
                count_one = parseInt(match[0]);
            }
        });
    } else {
        count_one = 1;
    }

    addButton.addEventListener("click", function () {
        count_one++;

        let newDiv = document.createElement("div");
        // Mendapatkan nilai JSON dari input HTML
        let riskEventDataString = document.getElementById("riskEvent").value;
        // Menguraikan nilai JSON menjadi objek JavaScript
        let riskEventData = JSON.parse(riskEventDataString);

        newDiv.className = "pembungkus_re";

        let innerHTML = `
        <div class="card card-outline card-primary">
        <div class="card-header">
                <h5 class="head"># Data Risk Event ${count_one} &rlhar;</h5>
            </div>
        <div class="card-body">
        <div class="row ml-2">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="id_event_risk_${count_one}">Pilih Risk Event ${count_one} :</label>
                        <select name="id_event_risk_${count_one}" id="id_event_risk_${count_one}" autocomplete="off" required
                            class="form-control input select2 form-control-sm">
                            <option selected disabled>- Pilih  Terlebih Dahulu! -</option>`;
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
                        <label for="keterangan_re_${count_one}" class="wajib">Keterangan</label>
                        <textarea class="form-control input summernote_tambahan" name="keterangan_re_${count_one}" id="keterangan_re_${count_one}" cols="30" rows="5"></textarea>
                </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="img_re_${count_one}_1">Upload Gambar Pendukung :</label>
                        <input class="form-control form-control-sm" type="file" name="img_re_${count_one}_1"
                            id="img_re_${count_one}_1" accept="image/jpeg,image/jpg,image/png">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="caption_re_${count_one}_1">Captionnya :</label>
                        <input class="form-control form-control-sm" type="text" name="caption_re_${count_one}_1"
                            id="caption_re_${count_one}_1">
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="">&nbsp;</label>
                    <input class="btn-outline-primary form-control form-control-sm mb-3" type="button"
                        id="gambar_add_${count_one}" value="(+) Tambah Gambar (+)">
                </div>
        </div>
                <div id="tambahan_gambar_${count_one}"></div>
                </div>
                        <div class="card card-outline card-primary mb-0"></div>
                    </div>
                `;

        newDiv.innerHTML = innerHTML;
        container.appendChild(newDiv);

        // config summernote
        configSummernote();
        // config Input
        configInput(count_one, count_one);
        // fungsi add image
        AddImage(count_one);
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
                count_one--;
            }
        }
    });
}
// End flexibel tambah risk event
