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
                    </div>

                    <div class="card card-outline card-secondary">
                        <div class="card-header">
                            <h6 class="head"># Penginpuntan KKPK/Debitur ${count_one}/1 &rlhar;</h6>
                        </div>
                        <div class="row ml-2">
                            <div class="col-md-6">
                                <table class="table table-sm debitur">
                                    <tr>
                                        <th style="width: 40%">Nama Debitur</th>
                                        <td>: <span id="nama_debitur_${count_one}_1"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width: 40%">No Rekening</th>
                                        <td>: <span id="no_rekening_${count_one}_1"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width: 40%">Tgl Realisasi</th>
                                        <td>: <span id="tgl_realisasi_${count_one}_1"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width: 40%">Plafon</th>
                                        <td>: <span id="plafon_${count_one}_1"></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm debitur">
                                    <tr>
                                        <th style="width: 40%">Status (Kol/DPD)</th>
                                        <td>: <span id="status_${count_one}_1"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width: 40%">JKW</th>
                                        <td>: <span id="jkw_${count_one}_1"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width: 40%">Tgl Jatuh Tempo</th>
                                        <td>: <span id="tgl_jth_tempo_${count_one}_1"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width: 40%">Baki Debet</th>
                                        <td>: <span id="baki_debet_${count_one}_1"></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                             <div class="col-md-12">
                                <table class="table table-sm debitur">
                                    <tr>
                                        <th style="width: 20%">Catatan/Deskripsi KKPK </th>
                                        <td style="width: 1%">:</td>
                                        <td id="catatan_${count_one}_1"></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="id_kkpk_${count_one}_1">Pilih Data KKPK :</label>
                                    <select name="id_kkpk_${count_one}_1" id="id_kkpk_${count_one}_1"
                                        class="form-control form-control-sm select2" required>
                                        <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="">&nbsp;</label>
                                <input class="btn-outline-primary form-control form-control-sm mb-3"
                                    type="button" id="tambah_kkpk_${count_one}_1" value="(+) Tambah Data KKPK (+)">
                            </div>

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

                    <div id="tambahan_debitur_${count_one}_1"></div>


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

        // Fungsi Flexible RE
        // Saat cabang dipilih, kirim permintaan AJAX untuk mendapatkan data kkpk
        let kkpkSelect = document.getElementById(`id_kkpk_${count_one}_1`);
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
                    DetailNasabah(count_one, 1);
                },
            });
        } else {
            kkpkSelect.innerHTML =
                "<option disabled selected>- Pilih Data CABANG DULU -</option>";
        }
        // kkpk
        FlexKkpk(count_one, 1);
        // saat user memilih ulang cabang
        KkpkFromCabang(count_one, 1);
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
