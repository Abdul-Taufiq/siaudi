$(document).ready(function () {
    FlexRE();
});

// #############$$$#############
// flexibel tambah risk event
function FlexRE() {
    let count_one = 1;
    let container = document.getElementById(`tambahan_risk_event_${count_one}`);
    let addButton = document.getElementById(`tambah_re_${count_one}`);

    addButton.addEventListener("click", function () {
        count_one++;

        let newDiv = document.createElement("div");
        // Mendapatkan nilai JSON dari input HTML
        let riskEventDataString = document.getElementById("riskEvent").value;
        // Menguraikan nilai JSON menjadi objek JavaScript
        let riskEventData = JSON.parse(riskEventDataString);

        newDiv.className = "pembungkus_re";

        let innerHTML = `
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h5 class="head"># Penginpuntan Risk Event ${count_one} &rlhar;</h5>
                </div>
                <div class="card-body">
                    <div class="row ml-2">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="id_event_risk_${count_one}">Pilih Risk Event :</label>
                                <select name="id_event_risk_${count_one}" id="id_event_risk_${count_one}" autocomplete="off" required
                                    class="form-control select2 form-control-sm">
                                    <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>`;
        // Gunakan data JSON untuk membangun opsi Select2
        riskEventData.forEach(function (risk) {
            innerHTML += `
                    <option value="${risk.id_event_risk}">
                        (${risk.kode_finding})
                        - ${risk.sub_activity} - ${risk.list_finding}
                    </option>`;
        });
        innerHTML += `</select>
                                    
                                    
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="total_noa_${count_one}" class="label">Total NOA : <i
                                        style="font-size: 10px;">(Opsional)</i>
                                </label>
                                <input class="form-control form-control-sm" type="number" name="total_noa_${count_one}"
                                    id="total_noa_${count_one}">
                            </div>
                        </div>
                    </div>

                    <div class="card card-outline card-secondary">
                        <div class="card-header">
                            <h6 class="head"># Penginpuntan Keterangan Temuan ${count_one}/1 &rlhar;</h6>
                        </div>
                        <div class="row ml-2">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="keterangan_re_${count_one}_1">Keterangan/Deskripsi :</label>
                                    <textarea class="form-control input summernote" name="keterangan_re_${count_one}_1" id="keterangan_re_${count_one}_1" cols="30" rows="5"></textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="img_re_${count_one}_1_1">Upload Gambar Pendukung :</label>
                                    <input class="form-control form-control-sm" type="file"
                                        name="img_re_${count_one}_1_1" id="img_re_${count_one}_1_1"
                                        accept="image/jpeg,image/jpg,image/png">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="caption_re_${count_one}_1_1">Captionnya :</label>
                                    <input class="form-control form-control-sm" type="text"
                                        name="caption_re_${count_one}_1_1" id="caption_re_${count_one}_1_1">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="">&nbsp;</label>
                                <input class="btn-outline-primary form-control form-control-sm mb-3"
                                    type="button" id="gambar_add_${count_one}_1_1" value="(+) Tambah Gambar (+)">
                            </div>
                        </div>
                        
                        <div id="tambahan_gambar_${count_one}_1_1"></div>

                        <br>
                        <div class="card card-outline card-secondary mb-0"></div>
                    </div>


                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h6 class="head"># Penginpuntan Data Lainnya 1/1 &rlhar;</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="desc_uraian_permasalahan_fakta_${count_one}">Desc Uraian Permasalahan
                                            dan Fakta</label>
                                        <textarea class="summernote" name="desc_uraian_permasalahan_fakta_${count_one}" id="desc_uraian_permasalahan_fakta_${count_one}"
                                            cols="20" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="desc_keadaan_seharusnya_${count_one}">Desc Keadaan Seharusnya
                                            :</label>
                                        <textarea class="summernote" name="desc_keadaan_seharusnya_${count_one}" id="desc_keadaan_seharusnya_${count_one}" cols="20"
                                            rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="penyebab_terjadi_penyimpangan_${count_one}">Penyebab Terjadinya
                                            Penyimpangan
                                            :</label>
                                        <textarea class="summernote" name="penyebab_terjadi_penyimpangan_${count_one}" id="penyebab_terjadi_penyimpangan_${count_one}"
                                            cols="20" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="dampak_resiko_${count_one}">Dampak/Resiko :</label>
                                        <textarea class="summernote" name="dampak_resiko_${count_one}" id="dampak_resiko_${count_one}" cols="20" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="tindak_lanjut_${count_one}">Tindak Lanjut/Rekomendasi:</label>
                                        <textarea class="summernote" name="tindak_lanjut_${count_one}" id="tindak_lanjut_${count_one}" cols="20" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-outline card-info mb-0"></div>
                    </div>

                    <div class="col-md-12 mb-0 mt-4">
                        <input class="btn-outline-danger form-control form-control-sm mb-3" type="button"
                        value="(-) Kurangi Risk Event (-)">
                    </div>
                </div>

                <div class="card card-outline card-warning mb-0"></div>
            </div>

        `;

        newDiv.innerHTML = innerHTML;
        container.appendChild(newDiv);

        // fungsi add image
        AddImage(count_one, 1);
        // config summernote
        configSummernote(
            `#keterangan_re_${count_one}_1, #desc_uraian_permasalahan_fakta_${count_one}, #desc_keadaan_seharusnya_${count_one}, #penyebab_terjadi_penyimpangan_${count_one}, #dampak_resiko_${count_one}, #tindak_lanjut_${count_one}`
        );

        // config Input
        configInput();
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
