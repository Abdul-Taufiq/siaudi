$(document).ready(function () {
    FlexKkpk(1, 1);
});

// ############$$$##############
// flexibel tambah kkpk
function FlexKkpk(count_one, count_two) {
    let container = document.getElementById(
        `tambahan_debitur_${count_one}_${count_two}`
    );

    var addButton = document.getElementById(
        `tambah_kkpk_${count_one}_${count_two}`
    );

    addButton.addEventListener("click", function () {
        count_two++;

        let newDiv = document.createElement("div");
        newDiv.className = "pembungkus";

        let innerHTML = `
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h6 class="head"># Penginpuntan KKPK/Debitur ${count_one}/${count_two} &rlhar;</h6>
                </div>

                <div class="card-body">
                <div class="row ml-2">
                    <div class="col-md-6">
                        <table class="table table-sm debitur">
                            <tr>
                                <th style="width: 40%">Nama Debitur</th>
                                <td>: <span id="nama_debitur_${count_one}_${count_two}"></span>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 40%">No Rekening</th>
                                <td>: <span id="no_rekening_${count_one}_${count_two}"></span>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 40%">Tgl Realisasi</th>
                                <td>: <span id="tgl_realisasi_${count_one}_${count_two}"></span>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 40%">Plafon</th>
                                <td>: <span id="plafon_${count_one}_${count_two}"></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm debitur">
                            <tr>
                                <th style="width: 40%">Status (Kol/DPD)</th>
                                <td>: <span id="status_${count_one}_${count_two}"></span>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 40%">JKW</th>
                                <td>: <span id="jkw_${count_one}_${count_two}"></span>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 40%">Tgl Jatuh Tempo</th>
                                <td>: <span id="tgl_jth_tempo_${count_one}_${count_two}"></span>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 40%">Baki Debet</th>
                                <td>: <span id="baki_debet_${count_one}_${count_two}"></span>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-sm debitur">
                            <tr>
                                <th style="width: 20%">Catatan/Deskripsi KKPK </th>
                                <td style="width: 1%">:</td>
                                <td id="catatan_${count_one}_${count_two}"></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="id_kkpk_${count_one}_${count_two}">Pilih Data KKPK :</label>
                            <select name="id_kkpk_${count_one}_${count_two}" id="id_kkpk_${count_one}_${count_two}"
                                class="form-control form-control-sm select2" required>
                                <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>
                                {{-- ISi dikontrol Ajax berdasarkan cabang dipilih --}}
                            </select>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="keterangan_re_${count_one}_${count_two}">Keterangan/Deskripsi :</label>
                            <textarea class="form-control input summernote" name="keterangan_re_${count_one}_${count_two}" id="keterangan_re_${count_one}_${count_two}" cols="30" rows="5"></textarea>
                        </div>
                    </div>

                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="img_re_${count_one}_${count_two}_1">Upload Gambar Pendukung :</label>
                            <input class="form-control form-control-sm" type="file"
                                name="img_re_${count_one}_${count_two}_1" id="img_re_${count_one}_${count_two}_1"
                                accept="image/jpeg,image/jpg,image/png">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="caption_re_${count_one}_${count_two}_1">Captionnya :</label>
                            <input class="form-control form-control-sm" type="text"
                                name="caption_re_${count_one}_${count_two}_1" id="caption_re_${count_one}_${count_two}_1">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="">&nbsp;</label>
                        <input class="btn-outline-primary form-control form-control-sm mb-3"
                            type="button" id="gambar_add_${count_one}_${count_two}_1" value="(+) Tambah Gambar (+)">
                    </div>
                </div>
                
                
                <div id="tambahan_gambar_${count_one}_${count_two}_1"></div>
                <br>
                <div class="col-md-12">
                        <input class="btn btn-outline-danger  col-md-12" type="button" value="(-) Kurangi Data KKPK (-)">
                </div>
                </div>
                <br>
                <div class="card card-outline card-secondary mb-0"></div>
            </div>
        `;

        newDiv.innerHTML = innerHTML;
        container.appendChild(newDiv);

        // Fungsi Flexible RE
        // Saat cabang dipilih, kirim permintaan AJAX untuk mendapatkan data kkpk
        let kkpkSelect = document.getElementById(
            `id_kkpk_${count_one}_${count_two}`
        );
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
                    DetailNasabah(count_one, count_two);
                },
            });
        } else {
            kkpkSelect.innerHTML =
                "<option disabled selected>- Pilih Data CABANG DULU -</option>";
        }
        // fungsi add image
        AddImage(count_one, count_two);
        // saat user memilih ulang cabang
        KkpkFromCabang(count_one, count_two);
        // summernote
        configSummernote(`#keterangan_re_${count_one}_${count_two}`);
        // config Input
        configInput();
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
                count_two--;
            }
        }
    });
}
// end flexibel tambah kkpk
