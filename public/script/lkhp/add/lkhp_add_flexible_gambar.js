$(document).ready(function () {
    AddImage(1, 1);
});

// flexibel gambar
function AddImage(count_one, count_two) {
    let count_three = 1;
    let contengambar = document.getElementById(
        `tambahan_gambar_${count_one}_${count_two}_${count_three}`
    );
    var addGambar = document.getElementById(
        `gambar_add_${count_one}_${count_two}_${count_three}`
    );

    addGambar.addEventListener("click", function () {
        count_three++;

        let newDiv = document.createElement("div");
        newDiv.className = "row ml-2";

        let innerHTML = `
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="img_re_${count_one}_${count_two}_${count_three}">Upload Gambar Pendukung :</label>
                        <input class="form-control form-control-sm" type="file" name="img_re_${count_one}_${count_two}_${count_three}"
                            id="img_re_${count_one}_${count_two}_${count_three}" accept="image/jpeg,image/jpg,image/png">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="caption_re_${count_one}_${count_two}_${count_three}">Captionnya :</label>
                        <input class="form-control form-control-sm" type="text" name="caption_re_${count_one}_${count_two}_${count_three}"
                            id="caption_re_${count_one}_${count_two}_${count_three}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="">&nbsp;</label>
                    <input class="btn-outline-danger form-control form-control-sm mb-3" type="button"
                        value="(-) Kurangi Gambar (-)">
                </div>
            `;

        newDiv.innerHTML = innerHTML;
        contengambar.appendChild(newDiv);
    });

    // Untuk mengurangi inputan
    contengambar.addEventListener("click", function (e) {
        // Periksa apakah elemen yang dipilih adalah tombol dan memiliki nilai yang sesuai
        if (
            e.target.tagName === "INPUT" &&
            e.target.value === "(-) Kurangi Gambar (-)"
        ) {
            e.preventDefault();

            // Temukan elemen <div> yang berisi tombol yang dipilih
            var divToRemove = e.target.closest(".row");

            // Hapus elemen <div> tersebut dari contengambar
            if (divToRemove) {
                contengambar.removeChild(divToRemove);
                count_three--;
            }
        }
    });
}
// end flexibel gambar
