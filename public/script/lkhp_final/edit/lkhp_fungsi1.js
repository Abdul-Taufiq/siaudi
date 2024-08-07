$(document).ready(function () {
    flexlkhp();
    showlkhp(1);
});

function showlkhp(counter) {
    let lkhp = document.getElementById(`id_lkhp_bayangan_${counter}`);

    // Inisialisasi select2 pada elemen select
    if (lkhp) {
        let $lkhp = $(lkhp);
        $lkhp.select2();

        // Tambahkan event listener untuk event change.select2
        $lkhp.on("change.select2", function () {
            let lkhValue = $(this).val();
            // console.log(lkhValue);

            $.ajax({
                type: "GET",
                url: "/get-lkhp/" + lkhValue,
                success: function (response) {
                    let data = response.data;

                    // Panggil fungsi sanitizeAndDisplayHTML
                    sanitizeAndDisplayHTML(data, counter);
                },
                error: function (error) {
                    console.error("Error fetching data:", error);
                },
            });
        });

        // Tambahkan event listener untuk perubahan nilai
        $lkhp.on("change", function () {
            var container = $(this)
                .next(".select2-container")
                .find(".select2-selection--single");

            if ($(this).val().trim() === "") {
                container
                    .addClass("border-danger")
                    .removeClass("border-success");
            } else {
                container
                    .addClass("border-success")
                    .removeClass("border-danger");
            }
        });

        // Initial check to set the border color based on the initial value
        $lkhp.trigger("change");

        // console.log(`showlkhp(${counter}) called and select2 initialized.`);
    } else {
        console.error("Element not found:", `id_lkhp_bayangan_${counter}`);
    }
}

function sanitizeAndDisplayHTML(data, counter) {
    // Membersihkan HTML menggunakan DOMPurify
    let uraian = DOMPurify.sanitize(data.desc_uraian_permasalahan_fakta);
    let keadaan = DOMPurify.sanitize(data.desc_keadaan_seharusnya);
    let penyebab = DOMPurify.sanitize(data.penyebab_terjadi_penyimpangan);
    let dampak = DOMPurify.sanitize(data.dampak_resiko);
    let tindak = DOMPurify.sanitize(data.tindak_lanjut);

    // Menampilkan HTML bersih di elemen target
    document.getElementById(`show_uraian_${counter}`).innerHTML = uraian;
    document.getElementById(`show_keadaan_${counter}`).innerHTML = keadaan;
    document.getElementById(`show_penyebab_${counter}`).innerHTML = penyebab;
    document.getElementById(`show_dampak_${counter}`).innerHTML = dampak;
    document.getElementById(`show_tindak_${counter}`).innerHTML = tindak;
}

function flexlkhp() {
    let counter = 1;
    let container = document.getElementById(`tambahan_lkhp_${counter}`);
    let addButton = document.getElementById(`add_lkhp`);

    addButton.addEventListener("click", function () {
        // Temukan semua elemen input dengan nama yang sesuai pola
        var inputElements = document.querySelectorAll(
            'select[name^="id_lkhp_bayangan_"]'
        );
        // Mencari nomor terbesar dari nama input
        var angka_besar = 0;

        if (inputElements.length > 0) {
            inputElements.forEach(function (inputElement) {
                // Menggunakan ekspresi reguler untuk mencocokkan nomor pada nama input
                var match = inputElement.name.match(/\d+/);

                // Jika ada kecocokan dan nomornya lebih besar dari yang sudah ada
                if (match && parseInt(match[0]) > angka_besar) {
                    angka_besar = parseInt(match[0]);
                }
            });
            counter = angka_besar + 1;
        } else {
            counter = 1;
        }

        let newDiv = document.createElement("div");
        // Mendapatkan nilai JSON dari input HTML
        let lkhp_bayangan = document.getElementById("lkhp_bayangan").value;
        // Menguraikan nilai JSON menjadi objek JavaScript
        let lkhp_Data = JSON.parse(lkhp_bayangan);

        newDiv.className = "pembungkus_lkhp";

        let innerHTML = `
                <div class="row ml-2">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label class="wajib" for="id_lkhp_bayangan_${counter}">Pilih data LKHP Bayangan ${counter}</label>
                            <select class="form-control select2" name="id_lkhp_bayangan_${counter}"
                                id="id_lkhp_bayangan_${counter}">
                                <option selected disabled>- Pilih data LKHP Bayangan -</option>`;

        lkhp_Data.forEach(function (data) {
            if (data && data.cabang && data.cabang.cabang) {
                innerHTML += `
                    <option value="${data.id_lkhp}">
                        ${data.cabang.cabang} - ${data.no_lkhp_bayangan} - ${
                    data.objek_pemeriksaan
                } - (
                        ${new Date(data.tgl_awal).toLocaleDateString(
                            "id-ID"
                        )} s/d
                        ${new Date(data.tgl_akhir).toLocaleDateString("id-ID", {
                            day: "2-digit",
                            month: "long",
                            year: "numeric",
                        })} )
                    </option>`;
            } else {
                console.warn("Data cabang tidak ditemukan:", data.id_cabang);
            }
        });
        innerHTML += `    
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="">&nbsp;</label>
                        <input class="btn-outline-danger form-control mb-3" type="button" id="delete_lkhp_${counter}"
                            value="(-) Kurangi LKHP (-)">
                    </div>

                    <div class="col-md-12">
                        <table class="table table-sm">
                            <tr>
                                <th style="width: 35%; color:rgb(74, 177, 247)">Deskripsi Uraian Permasalahan
                                    dan Fakta</th>
                                <td style="width: 2px">:</td>
                                <td id="show_uraian_${counter}"></td>
                            </tr>
                            <tr>
                                <th style="width: 35%; color:rgb(74, 177, 247)">Deskripsi Keadaan Seharusnya
                                </th>
                                <td>:</td>
                                <td id="show_keadaan_${counter}"></td>
                            </tr>
                            <tr>
                                <th style="width: 35%; color:rgb(74, 177, 247)">Penyebab Terjadi Penyimpangan
                                </th>
                                <td>:</td>
                                <td id="show_penyebab_${counter}"></td>
                            </tr>
                            <tr>
                                <th style="width: 35%; color:rgb(74, 177, 247)">Dampak/Resiko</th>
                                <td>:</td>
                                <td id="show_dampak_${counter}"></td>
                            </tr>
                            <tr>
                                <th style="width: 35%; color:rgb(74, 177, 247)">Tindak Lanjut</th>
                                <td>:</td>
                                <td id="show_tindak_${counter}"></td>
                            </tr>
                        </table>
                        <hr>
                    </div>
                </div>
        `;

        newDiv.innerHTML = innerHTML;
        container.appendChild(newDiv);

        showlkhp(counter); // Pastikan ini dipanggil setelah elemen baru ditambahkan ke DOM
    });

    // Untuk mengurangi inputan
    container.addEventListener("click", function (e) {
        // Periksa apakah elemen yang dipilih adalah tombol dan memiliki nilai yang sesuai
        if (
            e.target.tagName === "INPUT" &&
            e.target.value === "(-) Kurangi LKHP (-)"
        ) {
            e.preventDefault();

            // Temukan elemen <div> yang berisi tombol yang dipilih
            var divToRemove = e.target.closest(".pembungkus_lkhp");

            // Hapus elemen <div> tersebut dari container
            if (divToRemove) {
                container.removeChild(divToRemove);
                counter--;
            }
        }
    });
}
