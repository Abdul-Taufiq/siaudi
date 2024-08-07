<style>
    label {
        font-size: 14px;
    }

    .show {
        display: block;
    }

    .hidden {
        display: none;
    }

    .head-judul {
        font-size: 18px;
        font-weight: bold;
        letter-spacing: 2px;
    }

    label:has(+ input[required])::after {
        content: "  *";
        color: red;
        font-style: italic;
    }

    label:has(+ select[required])::after {
        content: "  *";
        color: red;
        font-style: italic;
    }

    label:has(+ textarea[required])::after {
        content: " *";
        color: red;
    }

    .wajib::after {
        content: " *";
        color: red;
    }

    /* Mengganti warna border Select2 */
    .select2-container--default .select2-selection--single {
        border-color: green;
    }

    /* Opsional: Ganti warna saat select di-focus */
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: green;
    }
</style>

<style>
    trix-toolbar [data-trix-button-group="file-tools"] {
        display: none;
    }
</style>



<div class="modal fade" id="modalEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="editForm" class="form" method="post" enctype="multipart/form-data">
            @method('patch')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel" style="letter-spacing: 2px; font-weight: bold;"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="row ml-2">
                                <h5 style="color: rgb(110, 146, 55); font-style: italic; font-weight: bold">Data Kredit
                                    &rlhar;</h5>
                                <div class="col-md-4">
                                    <div class="form-group input-group-sm mb-3">
                                        <label for="id_cabang_edit">Nasabah Kantor Cabang :</label>
                                        <select class="form-control input" name="id_cabang_edit" id="id_cabang_edit"
                                            required>
                                            <option disabled selected>- Pilih Kantor Cabang -</option>
                                            <option value="0">Kantor Pusat Management</option>
                                            <option value="1">Kantor Pusat Operasional</option>
                                            <option value="2">KC Temanggung</option>
                                            <option value="3">KC Wonosobo</option>
                                            <option value="4">KC Ambarawa</option>
                                            <option value="5">KC Semarang</option>
                                            <option value="6">KC Mranggen</option>
                                            <option value="7">KC Sukorejo</option>
                                            <option value="8">KC Weleri</option>
                                            <option value="9">KC Delanggu</option>
                                            <option value="10">KC Gombong</option>
                                            <option value="11">KC Sokaraja</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group input-group-sm mb-3">
                                        <label for="id_debitur_edit">Pilih Data Nasabah :</label>
                                        <select name="id_debitur_edit" id="id_debitur_edit" autocomplete="off" required
                                            class="form-control js-example-basic-single input select2 form-control-sm">
                                            <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>
                                            {{-- ISi dikontrol Ajax berdasarkan cabang dipilih --}}
                                        </select>
                                    </div>
                                </div>

                                {{-- detail debitur  --}}
                                <div class="col-md-6">
                                    <table class="table table-sm" style=" font-size: 14px;">
                                        <tr>
                                            <th style="width: 40%">Nama Debitur</th>
                                            <td>: <span id="nama_debitur_edit"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 40%">No Rekening</th>
                                            <td>: <span id="no_rekening_edit"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 40%">Tgl Realisasi</th>
                                            <td>: <span id="tgl_realisasi_edit"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 40%">Plafon</th>
                                            <td>: <span id="plafon_edit"></span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm" style=" font-size: 14px;">
                                        <tr>
                                            <th style="width: 40%">Status (Kol/DPD)</th>
                                            <td>: <span id="status_edit"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 40%">JKW</th>
                                            <td>: <span id="jkw_edit"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 40%">Tgl Jatuh Tempo</th>
                                            <td>: <span id="tgl_jth_tempo_edit"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 40%">Baki Debet</th>
                                            <td>: <span id="baki_debet_edit"></span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group input-group-sm mb-3">
                                        <label for="jns_pemeriksaan_edit">Jenis Pemeriksaan</label>
                                        <select class="form-control input" name="jns_pemeriksaan_edit"
                                            id="jns_pemeriksaan_edit" required>
                                            <option selected disabled>- Pilih Jenis Pemeriksaan -</option>
                                            <option value="Tentative">Tentative</option>
                                            <option value="Reguler">Reguler</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group input-group-sm mb-3">
                                        <label for="fas_kredit_edit">Fas Kredit</label>
                                        <select class="form-control input" name="fas_kredit_edit" id="fas_kredit_edit"
                                            required>
                                            <option selected disabled>- Pilih Fas Kredit -</option>
                                            <option value="New">New</option>
                                            <option value="Top Up">Top Up</option>
                                            <option value="Restructur">Restructur</option>
                                            <option value="Tutup Buka">Tutup Buka</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group input-group-sm mb-3">
                                        <label for="jns_kredit_edit">Jenis Kredit</label>
                                        <select class="form-control input" name="jns_kredit_edit" id="jns_kredit_edit"
                                            required>
                                            <option selected disabled>- Pilih Jenis Kredit -</option>
                                            <option value="Angsuran">Angsuran</option>
                                            <option value="Berjangka">Berjangka</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <br>
                            {{-- pemutus kredit --}}
                            <div class="row ml-2">
                                <h5 style="color: rgb(110, 146, 55); font-style: italic; font-weight: bold">Data
                                    Pemutus Kredit &rlhar;</h5>
                                <div class="col-md-6">
                                    <div class="form-group input-group-sm mb-3">
                                        <label for="nama_ao_edit">Nama AO</label>
                                        <select class="form-control input" name="nama_ao_edit" id="nama_ao_edit"
                                            required>
                                            <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>
                                        </select>
                                    </div>
                                    <div class="form-group input-group-sm mb-3">
                                        <label for="nama_analis_edit">Nama Analis</label>
                                        <select class="form-control input" name="nama_analis_edit"
                                            id="nama_analis_edit" required>
                                            <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>
                                        </select>
                                    </div>
                                    <div class="form-group input-group-sm mb-3">
                                        <label for="nama_kakom_edit">Nama Kakom</label>
                                        <select class="form-control input" name="nama_kakom_edit"
                                            id="nama_kakom_edit" required>
                                            <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>
                                        </select>
                                    </div>
                                    <div class="form-group input-group-sm mb-3">
                                        <label for="nama_pincab_edit">Nama Pincab</label>
                                        <select class="form-control input" name="nama_pincab_edit"
                                            id="nama_pincab_edit" required>
                                            <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group input-group-sm mb-3">
                                        <label for="nama_analis_area_edit">Nama Analis Area</label>
                                        <select class="form-control input" name="nama_analis_area_edit"
                                            id="nama_analis_area_edit" required>
                                            <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>
                                            <option value="-">- Tidak Ada! -</option>
                                        </select>
                                    </div>
                                    <div class="form-group input-group-sm mb-3">
                                        <label for="nama_area_manager_edit">Nama Area Manager</label>
                                        <select class="form-control input" name="nama_area_manager_edit"
                                            id="nama_area_manager_edit" required>
                                            <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>
                                            <option value="-">- Tidak Ada! -</option>
                                        </select>
                                    </div>
                                    <div class="form-group input-group-sm mb-3">
                                        <label for="nama_manager_bisnis_edit">Nama Manager Bisnis</label>
                                        <select class="form-control input" name="nama_manager_bisnis_edit"
                                            id="nama_manager_bisnis_edit" required>
                                            <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>
                                            <option value="-">- Tidak Ada! -</option>
                                        </select>
                                    </div>
                                    <div class="form-group input-group-sm mb-3">
                                        <label for="nama_analis_kpm_edit">Nama Analis KPM</label>
                                        <select class="form-control input" name="nama_analis_kpm_edit"
                                            id="nama_analis_kpm_edit" required>
                                            <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>
                                            <option value="-">- Tidak Ada! -</option>
                                        </select>
                                    </div>
                                    <div class="form-group input-group-sm mb-3">
                                        <label for="nama_direksi_edit">Nama Direksi</label>
                                        <select class="form-control input" name="nama_direksi_edit"
                                            id="nama_direksi_edit" required>
                                            <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>
                                            <option value="-">- Tidak Ada! -</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="row ml-2">
                                <div class="col-md-6">
                                    <table class="table" style="width: 95%;">
                                        <tr>
                                            <th style="width: 30%">A/T</th>
                                            <th>Keterangan</th>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="ktp_debitur_edit"
                                                    id="ktp_debitur_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                KTP Debitur
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="ktp_pasangan_edit"
                                                    id="ktp_pasangan_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                KTP Pasangan
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="kartu_keluarga_edit"
                                                    id="kartu_keluarga_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Kartu Keluarga
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="srt_nikah_edit"
                                                    id="srt_nikah_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Surat Nikah
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input"
                                                    name="akte_cerai_kematian_edit" id="akte_cerai_kematian_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Akte Cerai/Kematian
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="npwp_edit"
                                                    id="npwp_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                NPWP*
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="siup_edit"
                                                    id="siup_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                SIUP*
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="tdp_edit"
                                                    id="tdp_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                TDP*
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="slik_debitur_edit"
                                                    id="slik_debitur_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                SLIK Debitur
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="slik_pasangan_edit"
                                                    id="slik_pasangan_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                SLIK Pasangan
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input"
                                                    name="slik_badan_usaha_edit" id="slik_badan_usaha_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                SLIK Badan Usaha
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="fa_kredit_edit"
                                                    id="fa_kredit_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Form Aplikasi Kredit
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="kk_analis_edit"
                                                    id="kk_analis_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Kertas Kerja Analis
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="muk_edit"
                                                    id="muk_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                MUK
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="analisa_lr_edit"
                                                    id="analisa_lr_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Analisa L/R
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input"
                                                    name="persetujuan_muk_edit" id="persetujuan_muk_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Persetujuan MUK*
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input"
                                                    name="pemberitahuan_deviasi_edit" id="pemberitahuan_deviasi_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Pemberitahuan Deviasi
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input"
                                                    name="persetujuan_deviasi_edit" id="persetujuan_deviasi_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Persetujuan Deviasi
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input"
                                                    name="permohonan_add_deb_edit" id="permohonan_add_deb_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Permohonan Add (Deb)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input"
                                                    name="pemberitahuan_add_edit" id="pemberitahuan_add_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Pemberitahuan Add
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input"
                                                    name="persetujuan_add_edit" id="persetujuan_add_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Persetujuan Add*
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select class="form-control input" name="slip_gaji_edit"
                                                    id="slip_gaji_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Slip Gaji
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select class="form-control input" name="rek_tabungan_edit"
                                                    id="rek_tabungan_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Rek Tabungan
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select class="form-control input"
                                                    name="nota_penjualan_pembelian_edit"
                                                    id="nota_penjualan_pembelian_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Nota Penjualan/Pembelian
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select class="form-control input" name="foto_usaha_edit"
                                                    id="foto_usaha_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Foto Usaha
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select class="form-control input" name="denah_lokasi_usaha_edit"
                                                    id="denah_lokasi_usaha_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Denah lokasi Usaha
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select class="form-control input" name="surat_keterangan_edit"
                                                    id="surat_keterangan_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Surat Keterangan
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select class="form-control input" name="rab_edit" id="rab_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                RAB
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select class="form-control input" name="spk_mou_edit"
                                                    id="spk_mou_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                SPK/MOU
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select class="form-control input" name="mutasi_to_edit"
                                                    id="mutasi_to_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Mutasi Pembyrn 12bln terakhir (TO)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select class="form-control input" name="bukti_pelunasan_edit"
                                                    id="bukti_pelunasan_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Bukti Pelunasan (TO)
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <table class="table" style="width: 95%;">
                                        <tr>
                                            <th style="width: 30%">A/T</th>
                                            <th>Keterangan</th>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="lp_jaminan_edit"
                                                    id="lp_jaminan_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Lembar Penilaian Jaminan
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="app_independen_edit"
                                                    id="app_independen_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Apprasial Independen
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="foto_jaminan_edit"
                                                    id="foto_jaminan_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Foto Jaminan
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="dl_jaminan_edit"
                                                    id="dl_jaminan_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Denah Lokasi Jaminan
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="gn_rangka_edit"
                                                    id="gn_rangka_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Gesek No. Rangka
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="gn_mesin_edit"
                                                    id="gn_mesin_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Gesek No. Mesin
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="fc_stnk_edit"
                                                    id="fc_stnk_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                FC STNK
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="pbb_edit"
                                                    id="pbb_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                PBB
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="sspd_pbb_edit"
                                                    id="sspd_pbb_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                SSPD PBB
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="imb_edit"
                                                    id="imb_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                IMB
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input"
                                                    name="kwitansi_pencairan_edit" id="kwitansi_pencairan_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Kwitansi Pencairan
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="pk_pmk_edit"
                                                    id="pk_pmk_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                PK/PMK
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input"
                                                    name="perjanjian_fidusia_edit" id="perjanjian_fidusia_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Perjanjian Fidusia
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="pk_notaril_edit"
                                                    id="pk_notaril_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                PK Add (Notarill)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="sk_pendebetan_edit"
                                                    id="sk_pendebetan_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                SK Pendebetan
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="sk_menjual_edit"
                                                    id="sk_menjual_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                SK Menjual
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="pt_asuransi_edit"
                                                    id="pt_asuransi_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Pernyataan Tidak Asuransi
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input"
                                                    name="ba_serah_terima_edit" id="ba_serah_terima_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Berita Acara Serah Terima
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="spk_barang_edit"
                                                    id="spk_barang_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Surat Pernyataan Kepemilikan Barang
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="sim_pekarangan_edit"
                                                    id="sim_pekarangan_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Surat Ijin Memasuki Pekarangan
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="skmht_edit"
                                                    id="skmht_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                SKMHT
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="sht_edit"
                                                    id="sht_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                SHT
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="sertif_fidusia_edit"
                                                    id="sertif_fidusia_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Sertif Fidusia
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="foto_akad_edit"
                                                    id="foto_akad_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Foto Akad/ Pengikatan kredit
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="sertif_asli_edit"
                                                    id="sertif_asli_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Sertifikat Asli
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="bpkb_asli_edit"
                                                    id="bpkb_asli_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                BPKB Asli
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input"
                                                    name="covernote_notaris_edit" id="covernote_notaris_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Covernote Notaris
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input"
                                                    name="faktur_kendaraan_edit" id="faktur_kendaraan_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Faktur Mobil /Motor
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="ksn_bpkb_edit"
                                                    id="ksn_bpkb_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                Kwitansi sesuai nama BPKB (3)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="input-group input-group-sm">
                                                <select required class="form-control input" name="fc_ktp_bpkb_edit"
                                                    id="fc_ktp_bpkb_edit">
                                                    <option selected disabled>-Pilih-</option>
                                                    <option style="color: blue" value="Ada">Ada</option>
                                                    <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </td>
                                            <td>
                                                FC KTP sesuai nama BPKB
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </div>

                            <div class="row ml-2">
                                <h5 style="color: rgb(110, 146, 55); font-style: italic; font-weight: bold">Lainnya
                                    &rlhar;</h5>
                                <div class="col-md-12">
                                    <div class="form-group input-group-sm mb-3">
                                        <label for="jaminan_edit">Data Jaminan :</label>
                                        <input id="jaminan_edit" type="hidden" name="jaminan_edit"
                                            class="form-control input" required>
                                        <trix-editor input="jaminan" class="input"></trix-editor>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group input-group-sm mb-3">
                                        <label for="usaha_debitur_edit">Usaha Debitur :</label>
                                        <input id="usaha_debitur_edit" type="hidden" name="usaha_debitur_edit"
                                            class="form-control input" required>
                                        <trix-editor input="usaha_debitur" class="input"></trix-editor>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group input-group-sm mb-3">
                                        <label for="tujuan_kredit">Tujuan Kredit :</label>
                                        <input id="tujuan_kredit" type="hidden" name="tujuan_kredit_edit"
                                            class="form-control input" required>
                                        <trix-editor input="tujuan_kredit" class="input"></trix-editor>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group input-group-sm mb-3">
                                        <label for="sumber_pembayaran">Sumber Pembayaran :</label>
                                        <input id="sumber_pembayaran_edit" type="hidden"
                                            name="sumber_pembayaran_edit" class="form-control input" required>
                                        <trix-editor input="sumber_pembayaran" class="input"></trix-editor>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group input-group-sm mb-3">
                                        <label for="catatan">Catatanx :</label>
                                        <input id="catatan_edit" type="hidden" name="catatan_edit"
                                            class="form-control input" required>
                                        <trix-editor id="trix_catatan" input="catatan" class="input"></trix-editor>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group input-group-sm mb-3 mb-0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="terms" class="custom-control-input"
                                        id="exampleCheck1" required>
                                    <label class="custom-control-label" for="exampleCheck1">
                                        Saya setuju dengan <a href="{{ asset('Juknis/Juknis.pdf') }}"
                                            target="_blank">ketentuan yang berlaku</a>.
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="card card-outline card-primary mb-0"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="simpanExcel" type="button" class="btn btn-primary" style="letter-spacing: 2px;">
                        <i class="fa-regular fa-floppy-disk"></i> &nbsp; <b>SIMPAN</b></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- End modal add   --}}
