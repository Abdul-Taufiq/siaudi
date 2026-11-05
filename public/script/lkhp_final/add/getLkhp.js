$(document).ready(function () {
    getLkhp();
});

function getLkhp() {
    var tgl_awal = document.getElementById("tgl_awal");
    var tgl_akhir = document.getElementById("tgl_akhir");
    var id_cabang = document.getElementById("id_cabang");
    var objek_pemeriksaan = document.getElementById("objek_pemeriksaan");

    objek_pemeriksaan.addEventListener("change", function () {
        $.ajax({
            url: "/get-lkhp-bayangan",
            method: "GET",
            data: {
                tgl_awal: tgl_awal.value,
                tgl_akhir: tgl_akhir.value,
                id_cabang: id_cabang.value,
                objek_pemeriksaan: objek_pemeriksaan.value,
            },
            success: function (response) {
                var tbody = document.querySelector("#showLkhp tbody");
                tbody.innerHTML = ""; // Kosongkan tbody sebelum mengisi data baru
                console.log(response.data);

                // foreach for lkhp
                response.data.forEach(function (item, index) {
                    var row = document.createElement("tr");

                    // foreach for pivot
                    item.pivot.forEach(function (data) {
                        row.innerHTML = `
                        <td>
                        ${index + 1}.
                            <input type="checkbox" id="id_lkhp_${
                                index + 1
                            }" name="id_lkhp_${index + 1}" value="${
                                item.id_lkhp
                            }">
                        </td>
                        <td>
                            ${item.no_lkhp_bayangan} <br><br>
                            <b>${data.kkpk.debitur.nama_nasabah}</b> <br>
                            <b>${data.kkpk.debitur.no_rekening}</b> 
                        </td>
                        <td>
                            <table class="table-sm" style="width: 100%">
                                <tr>
                                    <th style="width: 35%; color: rgb(20, 145, 145)">Tgl Pemeriksaan</th>
                                    <td style="width: 2%">:</td>
                                    <td>
                                        ${new Date(
                                            item.tgl_awal,
                                        ).toLocaleDateString("id-ID", {
                                            day: "2-digit",
                                            month: "long",
                                            year: "numeric",
                                        })} s/d
                                        ${new Date(
                                            item.tgl_akhir,
                                        ).toLocaleDateString("id-ID", {
                                            day: "2-digit",
                                            month: "long",
                                            year: "numeric",
                                        })}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 35%; color: rgb(20, 145, 145)">Objek Pemeriksaan</th>
                                    <td style="width: 2%">:</td>
                                    <td>${item.objek_pemeriksaan}</td>
                                </tr>
                                <tr>
                                    <th style="width: 35%; color: rgb(20, 145, 145)">Risk Event</th>
                                    <td style="width: 2%">:</td>
                                    <td>
                                        <b>${data.risk_event.kode_finding}</b> -
                                        ${data.risk_event.list_finding} -
                                        ( ${data.risk_event.indikasi_resiko} )

                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 35%; color: rgb(20, 145, 145)">Creator</th>
                                    <td style="width: 2%">:</td>
                                    <td>${item.nama_creator}</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="table-sm" style="width: 100%">
                                <tr>
                                    <th style="width: 35%; color: rgb(20, 145, 145)">Desc Uraian Permasalahan & Fakta</th>
                                    <td style="width: 2%">:</td>
                                    <td>${
                                        item.desc_uraian_permasalahan_fakta
                                    }</td>
                                </tr>
                                <tr>
                                    <th style="width: 35%; color: rgb(20, 145, 145)">Penyebab Terjadi Penyimpangan</th>
                                    <td style="width: 2%">:</td>
                                    <td>${
                                        item.penyebab_terjadi_penyimpangan
                                    }</td>
                                </tr>
                                <tr>
                                    <th style="width: 35%; color: rgb(20, 145, 145)">Dampak Resiko</th>
                                    <td style="width: 2%">:</td>
                                    <td>${item.dampak_resiko}</td>
                                </tr>
                                <tr>
                                    <th style="width: 35%; color: rgb(20, 145, 145)">Tindak Lanjut</th>
                                    <td style="width: 2%">:</td>
                                    <td>${item.tindak_lanjut}</td>
                                </tr>
                            </table>
                        </td>
                    `;

                        tbody.appendChild(row);
                    });
                });
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
            },
        });
    });
}
