// ############$$$##############
// Penggantian ID didalam form edit
$(document).ready(function () {
    // Mengubah id input
    $("#modalEdit input:not(.tidak_edit)").each(function () {
        var currentId = $(this).attr("id");
        var newId = currentId + "_edit";
        $(this).attr("id", newId);
    });

    // Mengubah id select
    $("#modalEdit select").each(function () {
        var currentId = $(this).attr("id");
        var newId = currentId + "_edit";
        $(this).attr("id", newId);
    });

    // Mengubah id select
    $("#modalEdit span").each(function () {
        var currentId = $(this).attr("id");
        var newId = currentId + "_edit";
        $(this).attr("id", newId);
    });

    // Select2 On modal
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function () {
        $("#id_debitur_edit").select2({
            dropdownParent: $("#modalEdit"),
        });
    });

    // Mengatur properti required pada input dengan tipe hidden
    $("#modalEdit input[type='hidden']").prop("required", false);
});

function formatRupiah(angka, prefix) {
    var number_string = angka.toString().replace(/[^,\d]/g, ""),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // Tambahkan titik jika yang diinput sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] !== undefined ? rupiah + "," + split[1] : rupiah;
    return prefix === undefined ? rupiah : rupiah ? prefix + rupiah : "";
}

// edit data
$(document).ready(function () {
    $("body").on("click", ".edit", function () {
        var Id = $(this).attr("id");
        var Kode = $(this).data("kode_form");
        var modal = $("#modalEdit");
        var cabangSelect = document.getElementById("id_cabang_edit");
        var nasabahSelect = document.getElementById("id_debitur_edit");
        var nama_aoSelect = document.getElementById("nama_ao_edit");
        var nama_analisSelect = document.getElementById("nama_analis_edit");
        var nama_kakomSelect = document.getElementById("nama_kakom_edit");
        var nama_pincabSelect = document.getElementById("nama_pincab_edit");
        var nama_analis_areaSelect = document.getElementById(
            "nama_analis_area_edit"
        );
        var nama_area_managerSelect = document.getElementById(
            "nama_area_manager_edit"
        );
        var nama_manager_bisnisSelect = document.getElementById(
            "nama_manager_bisnis_edit"
        );
        var nama_analis_kpmSelect = document.getElementById(
            "nama_analis_kpm_edit"
        );
        var nama_direksiSelect = document.getElementById("nama_direksi_edit");

        // config model
        // console.log("Nama Kredit:", Id, Kode);
        console.log("Copyright by Abdul Taufiq");
        $("#modalEditLabel").text("EDIT DATA - No.Rek = " + Kode);
        $("#modalEdit").modal("show");

        // Setiap kali tombol edit diklik, atur border menjadi border-success
        $("#editForm .input")
            .addClass("border-success")
            .removeClass("border-danger");

        $(document).on("input", "#editForm .input", function () {
            if ($(this).val().trim() === "") {
                // Jika kosong, berikan border warna merah dan hapus border warna hijau
                $(this).addClass("border-danger").removeClass("border-success");
            } else {
                // Jika tidak kosong, berikan border warna hijau dan hapus border warna merah
                $(this).addClass("border-success").removeClass("border-danger");
            }
        });

        $.ajax({
            type: "GET",
            url: "/data-kkpk/" + Id + "/edit",
            success: function (response) {
                let kkpk = response.data;
                let debitur = response.data.debitur;
                let keterangan = response.data.keterangan;

                // {{ nasabah }}
                $("#id_cabang_edit").val(kkpk.id_cabang);
                $("#jns_pemeriksaan_edit").val(kkpk.jns_pemeriksaan);
                $("#fas_kredit_edit").val(kkpk.fas_kredit);
                $("#jns_kredit_edit").val(kkpk.jns_kredit);
                // ############$$$##############
                // select OPT nasabah berdasarkan ID Cabang Menentukan elemen select untuk cabang dan data nasabah
                $.ajax({
                    type: "GET",
                    url: "/get-nasabah/" + kkpk.id_cabang,
                    success: function (response) {
                        // Mengisi kembali data nasabah sesuai dengan respons dari server
                        let nasabahData = response.data;
                        let NasabahExist = nasabahData.some(function (nasabah) {
                            return nasabah.id_debitur === kkpk.id_debitur;
                        });
                        // Mengosongkan isi elemen select
                        nasabahSelect.innerHTML = "";
                        if (NasabahExist) {
                            // Jika nasabah dengan id_debitur yang sama dengan kkpk.id_debitur ada, pilih opsi tersebut
                            nasabahData.forEach(function (nasabah) {
                                let option = document.createElement("option");
                                option.value = nasabah.id_debitur;
                                option.text =
                                    nasabah.no_rekening +
                                    " → (" +
                                    nasabah.nama_nasabah +
                                    ") → Created_At: " +
                                    moment(nasabah.created_at)
                                        .locale("id")
                                        .format("DD MMM YYYY, HH:mm") +
                                    " WIB";
                                nasabahSelect.appendChild(option);
                                if (nasabah.id_debitur === kkpk.id_debitur) {
                                    option.selected = true;
                                }
                            });
                        } else {
                            // Jika nasabah dengan id_debitur yang sama dengan kkpk.id_debitur tidak ada, tambahkan semua nasabah dan pilih "Lainnya"
                            nasabahData.forEach(function (nasabah) {
                                let option = document.createElement("option");
                                option.value = nasabah.id_debitur;
                                option.text =
                                    nasabah.no_rekening +
                                    " → (" +
                                    nasabah.nama_nasabah +
                                    ") → Created_At: " +
                                    moment(nasabah.created_at)
                                        .locale("id")
                                        .format("DD MMM YYYY, HH:mm") +
                                    " WIB";
                                nasabahSelect.appendChild(option);
                            });
                            // Menambahkan opsi "Lainnya" dan menandainya sebagai terpilih
                            let lainnyaOption =
                                document.createElement("option");
                            lainnyaOption.value = "Lainnya";
                            lainnyaOption.text = "Lainnya";
                            lainnyaOption.selected = true;
                            nasabahSelect.appendChild(lainnyaOption);
                        }

                        // Mengisi kembali data nasabah sesuai dengan respons dari server
                        var nama_ao = response.nama_ao;
                        var isNamaAoExist = nama_ao.some(function (ao) {
                            return ao.nama === kkpk.nama_ao;
                        });
                        if (isNamaAoExist) {
                            nama_aoSelect.innerHTML =
                                '<option value="Lainnya">Lainnya</option>'; // Mengosongkan isi elemen select
                            nama_ao.forEach(function (ao) {
                                var option = document.createElement("option");
                                option.value = ao.nama;
                                option.text = ao.nama;
                                nama_aoSelect.appendChild(option);
                                if (ao.nama === kkpk.nama_ao) {
                                    option.selected = true; // Menandai opsi yang sama dengan kkpk.nama_ao sebagai terpilih
                                }
                            });
                        } else {
                            nama_aoSelect.innerHTML =
                                '<option selected value="Lainnya">Lainnya</option>'; // Mengosongkan isi elemen select
                            nama_ao.forEach(function (ao) {
                                var option = document.createElement("option");
                                option.value = ao.nama;
                                option.text = ao.nama;
                                nama_aoSelect.appendChild(option);
                            });
                            var aoInp =
                                document.getElementById("nama_ao_inp_edit");
                            aoInp.classList.remove("hidden");
                            $("#nama_ao_inp_edit").val(kkpk.nama_ao);
                        }

                        // Mengisi kembali data nasabah sesuai dengan respons dari server
                        var nama_analis = response.nama_analis;
                        var isNamaanalisExist = nama_analis.some(function (
                            analis
                        ) {
                            return analis.nama === kkpk.nama_analis;
                        });
                        if (isNamaanalisExist) {
                            nama_analisSelect.innerHTML =
                                '<option value="Lainnya">Lainnya</option>'; // Mengosongkan isi elemen select
                            nama_analis.forEach(function (analis) {
                                var option = document.createElement("option");
                                option.value = analis.nama;
                                option.text = analis.nama;
                                nama_analisSelect.appendChild(option);
                                if (analis.nama === kkpk.nama_analis) {
                                    option.selected = true; // Menandai opsi yang sama dengan kkpk.nama_analis sebagai terpilih
                                }
                            });
                        } else {
                            nama_analisSelect.innerHTML =
                                '<option selected value="Lainnya">Lainnya</option>'; // Mengosongkan isi elemen select
                            nama_analis.forEach(function (analis) {
                                var option = document.createElement("option");
                                option.value = analis.nama;
                                option.text = analis.nama;
                                nama_analisSelect.appendChild(option);
                            });
                            var analisInp = document.getElementById(
                                "nama_analis_inp_edit"
                            );
                            analisInp.classList.remove("hidden");
                            $("#nama_analis_inp_edit").val(kkpk.nama_analis);
                        }

                        // Mengisi kembali data nasabah sesuai dengan respons dari server
                        var nama_kakom = response.nama_kakom;
                        var isNamakakomExist = nama_kakom.some(function (
                            kakom
                        ) {
                            return kakom.nama === kkpk.nama_kakom;
                        });
                        if (isNamakakomExist) {
                            nama_kakomSelect.innerHTML =
                                '<option value="Lainnya">Lainnya</option>'; // Mengosongkan isi elemen select
                            nama_kakom.forEach(function (kakom) {
                                var option = document.createElement("option");
                                option.value = kakom.nama;
                                option.text = kakom.nama;
                                nama_kakomSelect.appendChild(option);
                                if (kakom.nama === kkpk.nama_kakom) {
                                    option.selected = true; // Menandai opsi yang sama dengan kkpk.nama_kakom sebagai terpilih
                                }
                            });
                        } else {
                            nama_kakomSelect.innerHTML =
                                '<option selected value="Lainnya">Lainnya</option>'; // Mengosongkan isi elemen select
                            nama_kakom.forEach(function (kakom) {
                                var option = document.createElement("option");
                                option.value = kakom.nama;
                                option.text = kakom.nama;
                                nama_kakomSelect.appendChild(option);
                            });
                            var kakomInp = document.getElementById(
                                "nama_kakom_inp_edit"
                            );
                            kakomInp.classList.remove("hidden");
                            $("#nama_kakom_inp_edit").val(kkpk.nama_kakom);
                        }

                        // Mengisi kembali data nasabah sesuai dengan respons dari server
                        var nama_pincab = response.nama_pincab;
                        var isNamapincabExist = nama_pincab.some(function (
                            pincab
                        ) {
                            return pincab.nama === kkpk.nama_pincab;
                        });
                        if (isNamapincabExist) {
                            nama_pincabSelect.innerHTML =
                                '<option value="Lainnya">Lainnya</option>'; // Mengosongkan isi elemen select
                            nama_pincab.forEach(function (pincab) {
                                var option = document.createElement("option");
                                option.value = pincab.nama;
                                option.text = pincab.nama;
                                nama_pincabSelect.appendChild(option);
                                if (pincab.nama === kkpk.nama_pincab) {
                                    option.selected = true; // Menandai opsi yang sama dengan kkpk.nama_pincab sebagai terpilih
                                }
                            });
                        } else {
                            nama_pincabSelect.innerHTML =
                                '<option selected value="Lainnya">Lainnya</option>'; // Mengosongkan isi elemen select
                            nama_pincab.forEach(function (pincab) {
                                var option = document.createElement("option");
                                option.value = pincab.nama;
                                option.text = pincab.nama;
                                nama_pincabSelect.appendChild(option);
                            });
                            var pincabInp = document.getElementById(
                                "nama_pincab_inp_edit"
                            );
                            pincabInp.classList.remove("hidden");
                            $("#nama_pincab_inp_edit").val(kkpk.nama_pincab);
                        }
                    },
                });
                $("#id_debitur_edit").val(kkpk.id_debitur).trigger("change"); // untuk select2
                $("#nama_debitur_edit").text(debitur.nama_nasabah);
                $("#no_rekening_edit").text(debitur.no_rekening);
                $("#status_edit").text(debitur.kol + "/" + debitur.dpd);
                $("#jkw_edit").text(debitur.jkw);
                $("#tgl_realisasi_edit").text(
                    moment(debitur.tgl_realisasi).locale("id").format("LL")
                );
                $("#tgl_jth_tempo_edit").text(
                    moment(debitur.tgl_jth_tempo).locale("id").format("LL")
                );

                var formattedPlafon = formatRupiah(debitur.plafon, "Rp. ");
                $("#plafon_edit").text(formattedPlafon);

                var formattedBD = formatRupiah(debitur.baki_debet, "Rp. ");
                $("#baki_debet_edit").text(formattedBD);

                //keterangan
                $("#ktp_debitur_edit").val(keterangan.ktp_debitur);
                $("#ktp_pasangan_edit").val(keterangan.ktp_pasangan);
                $("#kartu_keluarga_edit").val(keterangan.kartu_keluarga);
                $("#srt_nikah_edit").val(keterangan.srt_nikah);
                $("#akte_cerai_kematian_edit").val(
                    keterangan.akte_cerai_kematian
                );
                $("#npwp_edit").val(keterangan.npwp);
                $("#siup_edit").val(keterangan.siup);
                $("#tdp_edit").val(keterangan.tdp);
                $("#slik_debitur_edit").val(keterangan.slik_debitur);
                $("#slik_pasangan_edit").val(keterangan.slik_pasangan);
                $("#slik_badan_usaha_edit").val(keterangan.slik_badan_usaha);
                $("#fa_kredit_edit").val(keterangan.fa_kredit);
                $("#kk_analis_edit").val(keterangan.kk_analis);
                $("#muk_edit").val(keterangan.muk);
                $("#analisa_lr_edit").val(keterangan.analisa_lr);
                $("#persetujuan_muk_edit").val(keterangan.persetujuan_muk);
                $("#pemberitahuan_deviasi_edit").val(
                    keterangan.pemberitahuan_deviasi
                );
                $("#persetujuan_deviasi_edit").val(
                    keterangan.persetujuan_deviasi
                );
                $("#permohonan_add_deb_edit").val(
                    keterangan.permohonan_add_deb
                );
                $("#pemberitahuan_add_edit").val(keterangan.pemberitahuan_add);
                $("#persetujuan_add_edit").val(keterangan.persetujuan_add);
                $("#slip_gaji_edit").val(keterangan.slip_gaji);
                $("#rek_tabungan_edit").val(keterangan.rek_tabungan);
                $("#nota_penjualan_pembelian_edit").val(
                    keterangan.nota_penjualan_pembelian
                );
                $("#foto_usaha_edit").val(keterangan.foto_usaha);
                $("#denah_lokasi_usaha_edit").val(
                    keterangan.denah_lokasi_usaha
                );
                $("#surat_keterangan_edit").val(keterangan.surat_keterangan);
                $("#rab_edit").val(keterangan.rab);
                $("#spk_mou_edit").val(keterangan.spk_mou);
                $("#mutasi_to_edit").val(keterangan.mutasi_to);
                $("#bukti_pelunasan_edit").val(keterangan.bukti_pelunasan);
                $("#lp_jaminan_edit").val(keterangan.lp_jaminan);
                $("#app_independen_edit").val(keterangan.app_independen);
                $("#foto_jaminan_edit").val(keterangan.foto_jaminan);
                $("#dl_jaminan_edit").val(keterangan.dl_jaminan);
                $("#gn_rangka_edit").val(keterangan.gn_rangka);
                $("#gn_mesin_edit").val(keterangan.gn_mesin);
                $("#fc_stnk_edit").val(keterangan.fc_stnk);
                $("#pbb_edit").val(keterangan.pbb);
                $("#sspd_pbb_edit").val(keterangan.sspd_pbb);
                $("#imb_edit").val(keterangan.imb);
                $("#kwitansi_pencairan_edit").val(
                    keterangan.kwitansi_pencairan
                );
                $("#pk_pmk_edit").val(keterangan.pk_pmk);
                $("#perjanjian_fidusia_edit").val(
                    keterangan.perjanjian_fidusia
                );
                $("#pk_notaril_edit").val(keterangan.pk_notaril);
                $("#sk_pendebetan_edit").val(keterangan.sk_pendebetan);
                $("#sk_menjual_edit").val(keterangan.sk_menjual);
                $("#pt_asuransi_edit").val(keterangan.pt_asuransi);
                $("#ba_serah_terima_edit").val(keterangan.ba_serah_terima);
                $("#spk_barang_edit").val(keterangan.spk_barang);
                $("#sim_pekarangan_edit").val(keterangan.sim_pekarangan);
                $("#skmht_edit").val(keterangan.skmht);
                $("#sht_edit").val(keterangan.sht);
                $("#sertif_fidusia_edit").val(keterangan.sertif_fidusia);
                $("#foto_akad_edit").val(keterangan.foto_akad);
                $("#sertif_asli_edit").val(keterangan.sertif_asli);
                $("#bpkb_asli_edit").val(keterangan.bpkb_asli);
                $("#covernote_notaris_edit").val(keterangan.covernote_notaris);
                $("#faktur_kendaraan_edit").val(keterangan.faktur_kendaraan);
                $("#ksn_bpkb_edit").val(keterangan.ksn_bpkb);
                $("#fc_ktp_bpkb_edit").val(keterangan.fc_ktp_bpkb);

                // catatan
                $("#jaminan_edit").val(debitur.jaminan);
                $(".trix_jaminan").html(debitur.jaminan);
                $("#usaha_debitur_edit").val(debitur.usaha_debitur);
                $(".trix_usaha_debitur").html(debitur.usaha_debitur);
                $("#tujuan_kredit_edit").val(debitur.tujuan_kredit);
                $(".trix_tujuan_kredit").html(debitur.tujuan_kredit);
                $("#sumber_pembayaran_edit").val(debitur.sumber_pembayaran);
                $(".trix_sumber_pembayaran").html(debitur.sumber_pembayaran);
                $("#catatan_edit").val(keterangan.catatan);
                $(".trix_catatan").html(keterangan.catatan);

                // pemutus kredit
                // ############$$$##############
                // inp nama pemutus kredit {{
                var ao = document.getElementById("nama_ao_inp_edit");
                if (kkpk == "Lainnya") {
                    ao.classList.remove("hidden");
                    $(ao).prop("required", true);
                } else {
                    ao.classList.add("hidden");
                    $(ao).prop("required", false);
                }
                $("#nama_analis_edit").on("change", function () {
                    var selectopt = $(this).val();
                    var elemen = document.getElementById(
                        "nama_analis_inp_edit"
                    );
                    if (selectopt == "Lainnya") {
                        elemen.classList.remove("hidden");
                        $(elemen).prop("required", true);
                    } else {
                        elemen.classList.add("hidden");
                        $(elemen).prop("required", false);
                    }
                });
                $("#nama_kakom_edit").on("change", function () {
                    var selectopt = $(this).val();
                    var elemen = document.getElementById("nama_kakom_inp_edit");
                    if (selectopt == "Lainnya") {
                        elemen.classList.remove("hidden");
                        $(elemen).prop("required", true);
                    } else {
                        elemen.classList.add("hidden");
                        $(elemen).prop("required", false);
                    }
                });
                $("#nama_pincab_edit").on("change", function () {
                    var selectopt = $(this).val();
                    var elemen = document.getElementById(
                        "nama_pincab_inp_edit"
                    );
                    if (selectopt == "Lainnya") {
                        elemen.classList.remove("hidden");
                        $(elemen).prop("required", true);
                    } else {
                        elemen.classList.add("hidden");
                        $(elemen).prop("required", false);
                    }
                });

                // link formnya
                $("#editForm").attr("action", "/data-kkpk/" + Id);
            },
        });

        // ############$$$##############
        // inp nama pemutus kredit {{
        $("#nama_ao_edit").on("change", function () {
            var selectopt = $(this).val();
            var ao = document.getElementById("nama_ao_inp_edit");
            if (selectopt == "Lainnya") {
                ao.classList.remove("hidden");
                $(ao).prop("required", true);
            } else {
                ao.classList.add("hidden");
                $(ao).prop("required", false);
            }
        });
        $("#nama_analis_edit").on("change", function () {
            var selectopt = $(this).val();
            var elemen = document.getElementById("nama_analis_inp_edit");
            if (selectopt == "Lainnya") {
                elemen.classList.remove("hidden");
                $(elemen).prop("required", true);
            } else {
                elemen.classList.add("hidden");
                $(elemen).prop("required", false);
            }
        });
        $("#nama_kakom_edit").on("change", function () {
            var selectopt = $(this).val();
            var elemen = document.getElementById("nama_kakom_inp_edit");
            if (selectopt == "Lainnya") {
                elemen.classList.remove("hidden");
                $(elemen).prop("required", true);
            } else {
                elemen.classList.add("hidden");
                $(elemen).prop("required", false);
            }
        });
        $("#nama_pincab_edit").on("change", function () {
            var selectopt = $(this).val();
            var elemen = document.getElementById("nama_pincab_inp_edit");
            if (selectopt == "Lainnya") {
                elemen.classList.remove("hidden");
                $(elemen).prop("required", true);
            } else {
                elemen.classList.add("hidden");
                $(elemen).prop("required", false);
            }
        });
        // end }}

        // ############$$$############## {{
        // Saat cabang dipilih, kirim permintaan AJAX untuk mendapatkan data nasabah
        cabangSelect.addEventListener("change", function () {
            var cabangId = cabangSelect.value;
            $.ajax({
                type: "GET",
                url: "/get-nasabah/" + cabangId,
                success: function (response) {
                    let nasabahData = response.data;
                    // Membersihkan data nasabah sebelum mengisinya kembali
                    if (nasabahData <= 0) {
                        nasabahSelect.innerHTML =
                            "<option disabled selected>- Tidak Ada Data Nasabah -</option>";
                    } else {
                        nasabahSelect.innerHTML =
                            "<option disabled selected>- Pilih Data Nasabah -</option>";
                    }
                    // Mengisi kembali data nasabah sesuai dengan respons dari server
                    nasabahData.forEach(function (nasabah) {
                        var option = document.createElement("option");
                        option.value = nasabah.id_debitur;
                        option.text =
                            nasabah.no_rekening +
                            " → (" +
                            nasabah.nama_nasabah +
                            ") → Created_At: " +
                            moment(nasabah.created_at)
                                .locale("id")
                                .format("DD MMM YYYY, HH:mm") +
                            " WIB";
                        nasabahSelect.appendChild(option);
                    });

                    // Mengisi kembali data nasabah sesuai dengan respons dari server
                    var nama_ao = response.nama_ao;
                    nama_ao.forEach(function (ao) {
                        var option = document.createElement("option");
                        option.value = ao.nama;
                        option.text = ao.nama;
                        nama_aoSelect.appendChild(option);
                    });

                    // Mengisi kembali data nasabah sesuai dengan respons dari server
                    var nama_kakom = response.nama_kakom;
                    nama_kakom.forEach(function (kakom) {
                        var option = document.createElement("option");
                        option.value = kakom.nama;
                        option.text = kakom.nama;
                        nama_kakomSelect.appendChild(option);
                    });
                    // Mengisi kembali data nasabah sesuai dengan respons dari server
                    var nama_analis = response.nama_analis;
                    nama_analis.forEach(function (analis) {
                        var option = document.createElement("option");
                        option.value = analis.nama;
                        option.text = analis.nama;
                        nama_analisSelect.appendChild(option);
                    });
                    // Mengisi kembali data nasabah sesuai dengan respons dari server
                    var nama_pincab = response.nama_pincab;
                    nama_pincab.forEach(function (pincab) {
                        var option = document.createElement("option");
                        option.value = pincab.nama;
                        option.text = pincab.nama;
                        nama_pincabSelect.appendChild(option);
                    });
                    // Mengisi kembali data nasabah sesuai dengan respons dari server
                    var nama_analis_area = response.nama_analis_area;
                    console.log(nama_analis_area);

                    nama_analis_area.forEach(function (analis_area) {
                        var option = document.createElement("option");
                        option.value = analis_area.nama;
                        option.text = analis_area.nama;
                        nama_analis_areaSelect.appendChild(option);
                    });
                    // Mengisi kembali data nasabah sesuai dengan respons dari server
                    var nama_area_manager = response.nama_area_manager;
                    console.log(nama_area_manager);

                    nama_area_manager.forEach(function (area_manager) {
                        var option = document.createElement("option");
                        option.value = area_manager.nama;
                        option.text = area_manager.nama;
                        nama_area_managerSelect.appendChild(option);
                    });
                    // Mengisi kembali data nasabah sesuai dengan respons dari server
                    var nama_manager_bisnis = response.nama_manager_bisnis;
                    console.log(nama_manager_bisnis);

                    nama_manager_bisnis.forEach(function (manager_bisnis) {
                        var option = document.createElement("option");
                        option.value = manager_bisnis.nama;
                        option.text = manager_bisnis.nama;
                        nama_manager_bisnisSelect.appendChild(option);
                    });
                    // Mengisi kembali data nasabah sesuai dengan respons dari server
                    var nama_analis_kpm = response.nama_analis_kpm;
                    console.log(nama_analis_kpm);
                    nama_analis_kpm.forEach(function (analis_kpm) {
                        var option = document.createElement("option");
                        option.value = analis_kpm.nama;
                        option.text = analis_kpm.nama;
                        nama_analis_kpmSelect.appendChild(option);
                    });
                    // Mengisi kembali data nasabah sesuai dengan respons dari server
                    var nama_direksi = response.nama_direksi;
                    console.log(nama_direksi);
                    nama_direksi.forEach(function (direksi) {
                        var option = document.createElement("option");
                        option.value = direksi.nama;
                        option.text = direksi.nama;
                        nama_direksiSelect.appendChild(option);
                    });
                },
            });
        });
        // end }}

        // ############$$$##############
        // tambahan detail nasabah
        $("#id_debitur_edit").on("change", function () {
            var selectopt = $(this).val();
            // console.log(selectopt);
            $.ajax({
                type: "GET",
                url: "/get-detail-nasabah/" + selectopt,
                success: function (response) {
                    var nasabahData = response.data;
                    $("#nama_debitur_edit").text(nasabahData.nama_nasabah);
                    $("#no_rekening_edit").text(nasabahData.no_rekening);
                    $("#jkw_edit").text(nasabahData.jkw);
                    $("#status_edit").text(
                        nasabahData.kol + "/" + nasabahData.dpd
                    );
                    $("#tgl_realisasi_edit").text(
                        moment(nasabahData.tgl_realisasi)
                            .locale("id")
                            .format("LL")
                    );
                    $("#tgl_jth_tempo_edit").text(
                        moment(nasabahData.tgl_jth_tempo)
                            .locale("id")
                            .format("LL")
                    );

                    $("#plafon_edit").text(
                        (this.value = formatRupiah(nasabahData.plafon, "Rp. "))
                    );
                    $("#baki_debet_edit").text(
                        (this.value = formatRupiah(
                            nasabahData.baki_debet,
                            "Rp. "
                        ))
                    );
                },
            });
        });
        // end tambahan detail nasabah

        // modal ots / second modal
        document.getElementById("Edit_data_OTS").onclick = function () {
            $("#ModalEditOTS").modal("show"); // Tampilkan modal kedua
            $("#titleModalEditOTS").text("EDIT DATA OTS - Kode KKPK = " + Kode);
            $("#frameEditOTS").attr("src", "/edit-kko/" + Id + "/edit"); //merubah link frame=
            // link formnya
            $("#editFormOTS").attr("action", "/edit-kko/" + Id);
            $("#modalEdit").modal("hide");
        };
    });
});
// end edit

// detail OTS second modal
// Fungsi untuk kembali ke modal pertama dari modal kedua
function openFirstModal() {
    $("#ModalEditOTS").modal("hide"); // Sembunyikan modal kedua
    $("#modalEdit").modal("show"); // Tampilkan modal pertama
}
// Pastikan untuk menghapus kelas modal-open saat modal kedua ditutup
$("#ModalEditOTS").on("hidden.bs.modal", function () {
    if ($(".modal:visible").length) {
        $("body").addClass("modal-open");
    } else {
        $("body").removeClass("modal-open");
    }
});
// Pastikan untuk menghapus kelas modal-open saat modal pertama ditutup
$("#modalEdit").on("hidden.bs.modal", function () {
    if ($(".modal:visible").length) {
        $("body").addClass("modal-open");
    } else {
        $("body").removeClass("modal-open");
    }
});

$("#editForm").submit(function () {
    var tujuanKreditValue = $(".trix_tujuan_kredit").val();
    var jaminanValue = $(".trix_jaminan").val();
    var usaha_debiturValue = $(".trix_usaha_debitur").val();
    var tujuan_kreditValue = $(".trix_tujuan_kredit").val();
    var sumber_pembayaranValue = $(".trix_sumber_pembayaran").val();
    var catatanValue = $(".trix_catatan").val();
    // isi
    $("#tujuan_kredit_edit").val(tujuanKreditValue);
    $("#jaminan_edit").val(jaminanValue);
    $("#usaha_debitur_edit").val(usaha_debiturValue);
    $("#tujuan_kredit_edit").val(tujuan_kreditValue);
    $("#sumber_pembayaran_edit").val(sumber_pembayaranValue);
    $("#catatan_edit").val(catatanValue);
});
