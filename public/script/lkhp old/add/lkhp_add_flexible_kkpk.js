// ############$$$##############
// flexibel tambah kkpk
document.addEventListener("DOMContentLoaded", function () {
    let container = document.getElementById("tambahan_debitur");
    // Mendapatkan nilai JSON dari input HTML
    let riskEventDataString = document.getElementById("riskEvent").value;
    // Menguraikan nilai JSON menjadi objek JavaScript
    let riskEventData = JSON.parse(riskEventDataString);
    var addButton = document.querySelector(
        'input[value="(+) Tambah Data KKPK (+)"]'
    );
    let counter = 1;

    addButton.addEventListener("click", function () {
        counter++;

        let newDiv = document.createElement("div");
        newDiv.className = "pembungkus";

        let innerHTML = `
        <div class="card card-outline card-warning">
            <div class="card-header">
                <h5 class="head"># Data KKPK ${counter} &rlhar;</h5>
            </div>
            <div class="card-body">
                <div class="row ml-2">
                    <div class="col-md-6">
                        <table class="table table-sm" style=" font-size: 14px;">
                            <tr>
                                <th style="width: 40%">Nama Debitur</th>
                                <td>: <span id="nama_debitur_${counter}"></span>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 40%">No Rekening</th>
                                <td>: <span id="no_rekening_${counter}"></span>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 40%">Tgl Realisasi</th>
                                <td>: <span id="tgl_realisasi_${counter}"></span>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 40%">Plafon</th>
                                <td>: <span id="plafon_${counter}"></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm" style=" font-size: 14px;">
                            <tr>
                                <th style="width: 40%">Status (Kol/DPD)</th>
                                <td>: <span id="status_${counter}"></span>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 40%">JKW</th>
                                <td>: <span id="jkw_${counter}"></span>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 40%">Tgl Jatuh Tempo</th>
                                <td>: <span id="tgl_jth_tempo_${counter}"></span>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 40%">Baki Debet</th>
                                <td>: <span id="baki_debet_${counter}"></span>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group input-group-sm mb-3">
                            <label for="id_kkpk_${counter}">Pilih Data KKPK :</label>
                            <select name="id_kkpk_${counter}" id="id_kkpk_${counter}" autocomplete="off" required class="form-control input select2">
                                <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="id_event_risk_${counter}_1">Pilih Risk Event :</label>
                            <select name="id_event_risk_${counter}_1" id="id_event_risk_${counter}_1" autocomplete="off" required
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
                        <input class="btn-outline-primary form-control form-control-sm mb-3" type="button"
                                id="tambah_re_${counter}_1" value="(+) Tambah Risk Event (+)">
                    </div>
                    <div class="col-md-12">
                    <div class="form-group">
                        <label for="keterangan_re_${counter}_1" class="wajib">Keterangan</label>
                        <textarea class="form-control input" name="keterangan_re_${counter}_1" id="keterangan_re_${counter}_1" cols="30" rows="5"></textarea>
                        
                    </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="img_re_${counter}_1_1">Upload Gambar Pendukung :</label>
                            <input class="form-control form-control-sm" type="file" name="img_re_${counter}_1_1"
                                id="img_re_${counter}_1_1" accept="image/jpeg,image/jpg,image/png">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="caption_re_${counter}_1_1">Captionnya :</label>
                            <input class="form-control form-control-sm" type="text" name="caption_re_${counter}_1_1"
                                id="caption_re_${counter}_1_1">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="">&nbsp;</label>
                        <input class="btn-outline-primary form-control form-control-sm mb-3" type="button"
                        id="gambar_add_${counter}_1_1" value="(+) Tambah Gambar (+)">
                    </div>
                    
                    </div>
                    <div id="tambahan_gambar_${counter}_1_1"></div>

                    <div id="tambahan_risk_event_${counter}_1"></div>
                    <div class="col-md-12">
                        <hr>
                    </div>

                    <div class="col-md-12">
                        <input class="btn btn-outline-danger  col-md-12" type="button" value="(-) Kurangi Data KKPK (-)">
                    </div>
                        <br>
                        <br>

            </div>
            <div class="card card-outline card-warning mb-0"></div>
        </div>
            `;

        newDiv.innerHTML = innerHTML;
        container.appendChild(newDiv);

        // Saat cabang dipilih, kirim permintaan AJAX untuk mendapatkan data kkpk
        let kkpkSelect = document.getElementById(`id_kkpk_${counter}`);
        let ValCabang = document.getElementById("id_cabang").value;
        if (ValCabang > 0) {
            $.ajax({
                type: "GET",
                url: "/get-kkpk/" + ValCabang,
                success: function (response) {
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
                    DetailNasabah(counter);
                },
            });
        } else {
            kkpkSelect.innerHTML =
                "<option disabled selected>- Pilih Data CABANG DULU -</option>";
        }
        // Fungsi Flexible RE
        FlexRE(counter);
        // fungsi add image
        AddImage(counter, 1);
        // saat user memilih ulang cabang
        KkpkFromCabang(counter);

        configSummernote(counter, 1);
        // config Input
        configInput(counter, 1);
    });

    // Untuk mengurangi inputan
    container.addEventListener("click", function (e) {
        // Periksa apakah elemen yang dipilih adalah tombol dan memiliki nilai yang sesuai
        if (
            e.target.tagName === "INPUT" &&
            e.target.value === "(-) Kurangi Data KKPK (-)"
        ) {
            e.preventDefault();

            // Temukan elemen <div> yang berisi tombol yang dipilih
            var divToRemove = e.target.closest(".pembungkus");

            // Hapus elemen <div> tersebut dari container
            if (divToRemove) {
                container.removeChild(divToRemove);
                counter--;
            }
        }
    });
});
// end flexibel tambah kkpk
