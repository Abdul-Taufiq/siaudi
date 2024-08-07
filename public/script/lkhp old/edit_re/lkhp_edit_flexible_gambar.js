// flexibel gambar
document.addEventListener("DOMContentLoaded", function () {
    var addGambarButtons = document.querySelectorAll('[id^="gambar_add_"]');
    addGambarButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            var buttonId = this.id;
            var buttonIndex = buttonId.match(/\d+/)[0];

            let contengambar = document.getElementById(
                `tambahan_gambar_${buttonIndex}`
            );
            var inputCountTwo = contengambar.querySelectorAll(
                `input[name^="img_re_${buttonIndex}_"]`
            );

            var highestCount = 0;
            if (inputCountTwo.length >= 0) {
                inputCountTwo.forEach(function (inputElement) {
                    var match = inputElement.name.match(/_(\d+)$/);

                    if (match && parseInt(match[1]) > highestCount) {
                        highestCount = parseInt(match[1]);
                    }
                });
                count_two = highestCount;
            } else {
                count_two = 0;
            }

            count_two++;
            let newDiv = document.createElement("div");
            newDiv.className = "row ml-2";

            let innerHTML = `
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="img_re_${buttonIndex}_${count_two}">Upload Gambar Pendukung :</label>
                            <input class="form-control form-control-sm" type="file" name="img_re_${buttonIndex}_${count_two}"
                                id="img_re_${buttonIndex}_${count_two}" accept="image/jpeg,image/jpg,image/png">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="caption_re_${buttonIndex}_${count_two}">Captionnya :</label>
                            <input class="form-control form-control-sm" type="text" name="caption_re_${buttonIndex}_${count_two}"
                                id="caption_re_${buttonIndex}_${count_two}">
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

        var buttonId = button.id;
        var buttonIndex = buttonId.match(/\d+/)[0];

        let contengambar = document.getElementById(
            `tambahan_gambar_${buttonIndex}`
        );
        contengambar.addEventListener("click", function (e) {
            if (
                e.target.tagName === "INPUT" &&
                e.target.value === "(-) Kurangi Gambar (-)"
            ) {
                e.preventDefault();
                var divToRemove = e.target.closest(".row");
                if (divToRemove) {
                    contengambar.removeChild(divToRemove);
                    count_two--;
                }
            }
        });
    });
});
// end flexibel gambar

// flexibel gambar
function AddImage(count_one) {
    let count_two = 1;
    let contengambar = document.getElementById(`tambahan_gambar_${count_one}`);
    var addGambar = document.getElementById(`gambar_add_${count_one}`);

    addGambar.addEventListener("click", function () {
        count_two++;

        let newDiv = document.createElement("div");
        newDiv.className = "row ml-2";

        let innerHTML = `
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="img_re_${count_one}_${count_two}">Upload Gambar Pendukung :</label>
                        <input class="form-control form-control-sm" type="file" name="img_re_${count_one}_${count_two}"
                            id="img_re_${count_one}_${count_two}" accept="image/jpeg,image/jpg,image/png">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="caption_re_${count_one}_${count_two}">Captionnya :</label>
                        <input class="form-control form-control-sm" type="text" name="caption_re_${count_one}_${count_two}"
                            id="caption_re_${count_one}_${count_two}">
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
                count_two--;
            }
        }
    });
}
// end flexibel gambar
