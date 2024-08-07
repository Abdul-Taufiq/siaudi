<div class="card-body">
    <div class="row ml-2">
        <h5 style="color: rgb(110, 146, 55); font-style: italic; font-weight: bold">Data Kredit
            &rlhar;</h5>
        <div class="col-md-4">
            <div class="form-group input-group-sm mb-3">
                <label for="id_cabang">Nasabah Kantor Cabang :</label>
                <select class="form-control input" name="id_cabang" id="id_cabang" required>
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
                <label for="id_debitur">Pilih Data Nasabah :</label>
                <select name="id_debitur" id="id_debitur" required class="form-control input select2 form-control-sm">
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
                    <td>: <span id="nama_debitur"></span>
                    </td>
                </tr>
                <tr>
                    <th style="width: 40%">No Rekening</th>
                    <td>: <span id="no_rekening"></span>
                    </td>
                </tr>
                <tr>
                    <th style="width: 40%">Tgl Realisasi</th>
                    <td>: <span id="tgl_realisasi"></span>
                    </td>
                </tr>
                <tr>
                    <th style="width: 40%">Plafon</th>
                    <td>: <span id="plafon"></span>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-sm" style=" font-size: 14px;">
                <tr>
                    <th style="width: 40%">Status (Kol/DPD)</th>
                    <td>: <span id="status"></span>
                    </td>
                </tr>
                <tr>
                    <th style="width: 40%">JKW</th>
                    <td>: <span id="jkw"></span>
                    </td>
                </tr>
                <tr>
                    <th style="width: 40%">Tgl Jatuh Tempo</th>
                    <td>: <span id="tgl_jth_tempo"></span>
                    </td>
                </tr>
                <tr>
                    <th style="width: 40%">Baki Debet</th>
                    <td>: <span id="baki_debet"></span>
                    </td>
                </tr>
            </table>
        </div>

        <div class="col-md-6">
            <div class="form-group input-group-sm mb-3">
                <label for="jns_pemeriksaan">Jenis Pemeriksaan</label>
                <select class="form-control input" name="jns_pemeriksaan" id="jns_pemeriksaan" required>
                    <option selected disabled>- Pilih Jenis Pemeriksaan -</option>
                    <option value="Tentative">Tentative</option>
                    <option value="Reguler">Reguler</option>
                    <option value="Task Force">Task Force</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group input-group-sm mb-3">
                <label for="fas_kredit">Fas Kredit</label>
                <select class="form-control input" name="fas_kredit" id="fas_kredit" required>
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
                <label for="jns_kredit">Jenis Kredit</label>
                <select class="form-control input" name="jns_kredit" id="jns_kredit" required>
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
                <label for="nama_ao">Nama AO</label>
                <select class="form-control input" name="nama_ao" id="nama_ao" required>
                    <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
                <input class="form-control input hidden" type="text" name="nama_ao_inp" id="nama_ao_inp"
                    placeholder="Isikan...">
            </div>
            <div class="form-group input-group-sm mb-3">
                <label for="nama_analis">Nama Analis</label>
                <select class="form-control input" name="nama_analis" id="nama_analis" required>
                    <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
                <input class="form-control input hidden" type="text" name="nama_analis_inp" id="nama_analis_inp"
                    placeholder="Isikan...">
            </div>
            <div class="form-group input-group-sm mb-3">
                <label for="nama_kakom">Nama Kakom</label>
                <select class="form-control input" name="nama_kakom" id="nama_kakom" required>
                    <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
                <input class="form-control input hidden" type="text" name="nama_kakom_inp" id="nama_kakom_inp"
                    placeholder="Isikan...">
            </div>
            <div class="form-group input-group-sm mb-3">
                <label for="nama_pincab">Nama Pincab</label>
                <select class="form-control input" name="nama_pincab" id="nama_pincab" required>
                    <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
                <input class="form-control input hidden" type="text" name="nama_pincab_inp" id="nama_pincab_inp"
                    placeholder="Isikan...">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group input-group-sm mb-3">
                <label for="nama_analis_area">Nama Analis Area</label>
                <select class="form-control input" name="nama_analis_area" id="nama_analis_area" required>
                    <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>
                    <option value="-">- Tidak Ada! -</option>
                </select>
            </div>
            <div class="form-group input-group-sm mb-3">
                <label for="nama_area_manager">Nama Area Manager</label>
                <select class="form-control input" name="nama_area_manager" id="nama_area_manager" required>
                    <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>
                    <option value="-">- Tidak Ada! -</option>
                </select>
            </div>
            <div class="form-group input-group-sm mb-3">
                <label for="nama_manager_bisnis">Nama Manager Bisnis</label>
                <select class="form-control input" name="nama_manager_bisnis" id="nama_manager_bisnis" required>
                    <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>
                    <option value="-">- Tidak Ada! -</option>
                </select>
            </div>
            <div class="form-group input-group-sm mb-3">
                <label for="nama_analis_kpm">Nama Analis KPM</label>
                <select class="form-control input" name="nama_analis_kpm" id="nama_analis_kpm" required>
                    <option selected disabled>- Pilih Cabang Terlebih Dahulu! -</option>
                    <option value="-">- Tidak Ada! -</option>
                </select>
            </div>
            <div class="form-group input-group-sm mb-3">
                <label for="nama_direksi">Nama Direksi</label>
                <select class="form-control input" name="nama_direksi" id="nama_direksi" required>
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
                    <th style="width: 23%">A/T</th>
                    <th>Keterangan</th>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="ktp_debitur" id="ktp_debitur">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        KTP Debitur
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="ktp_pasangan" id="ktp_pasangan">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        KTP Pasangan Debitur
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="kartu_keluarga"
                            id="kartu_keluarga">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Kartu Keluarga Debitur
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="srt_nikah" id="srt_nikah">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Surat Nikah Debitur
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="akte_cerai_kematian"
                            id="akte_cerai_kematian">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Akte Cerai/Kematian Debitur
                    </td>
                </tr>

                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="ktp_debitur_penjamin"
                            id="ktp_debitur_penjamin">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        KTP Penjamin
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="ktp_pasangan_penjamin"
                            id="ktp_pasangan_penjamin">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        KTP Pasangan Penjamin
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="kartu_keluarga_penjamin"
                            id="kartu_keluarga_penjamin">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Kartu Keluarga Penjamin
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="srt_nikah_penjamin"
                            id="srt_nikah_penjamin">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Surat Nikah Penjamin
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="akte_cerai_kematian_penjamin"
                            id="akte_cerai_kematian_penjamin">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Akte Cerai/Kematian Penjamin
                    </td>
                </tr>


                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="npwp" id="npwp">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        NPWP*
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="info_siup" id="info_siup">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        SIUP*/TDP*/SKU*/Akte CV*/Akte PT*
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="slik_debitur" id="slik_debitur">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        SLIK Debitur
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="slik_pasangan" id="slik_pasangan">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        SLIK Pasangan
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="slik_badan_usaha"
                            id="slik_badan_usaha">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        SLIK Badan Usaha
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="fa_kredit" id="fa_kredit">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Form Aplikasi Kredit
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="kk_analis" id="kk_analis">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Kertas Kerja Analis
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="muk" id="muk">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        MUK
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="analisa_lr" id="analisa_lr">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Analisa L/R
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="persetujuan_muk"
                            id="persetujuan_muk">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Persetujuan MUK*
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="info_deviasi" id="info_deviasi">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Pemberitahuan/Persetujuan Deviasi
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="permohonan_add_deb"
                            id="permohonan_add_deb">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Permohonan Add (Deb)
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="info_add" id="info_add">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Pemberitahuan/Persetujuan Add*
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select class="form-control input kecuali" name="slip_gaji" id="slip_gaji">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Slip Gaji
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select class="form-control input kecuali" name="rek_tabungan" id="rek_tabungan">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Rek Tabungan
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select class="form-control input kecuali" name="nota_penjualan_pembelian"
                            id="nota_penjualan_pembelian">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Nota Penjualan/Pembelian
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select class="form-control input kecuali" name="foto_usaha" id="foto_usaha">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Foto Usaha
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select class="form-control input kecuali" name="denah_lokasi_usaha" id="denah_lokasi_usaha">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Denah lokasi Usaha
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select class="form-control input kecuali" name="surat_keterangan" id="surat_keterangan">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Surat Keterangan dr Instansi Terkait
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select class="form-control input kecuali" name="rab" id="rab">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        RAB
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select class="form-control input kecuali" name="spk_mou" id="spk_mou">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        SPK/MOU
                    </td>
                </tr>
            </table>
        </div>

        <div class="col-md-6">
            <table class="table" style="width: 95%;">
                <tr>
                    <th style="width: 23%">A/T</th>
                    <th>Keterangan</th>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select class="form-control input kecuali" name="mutasi_to" id="mutasi_to">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Mutasi Pembyrn 12bln terakhir (TO)
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select class="form-control input kecuali" name="bukti_pelunasan" id="bukti_pelunasan">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Bukti Pelunasan (TO)
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="lp_jaminan" id="lp_jaminan">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Lembar Penilaian Jaminan
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="app_independen"
                            id="app_independen">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Apprasial Independen
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="foto_jaminan" id="foto_jaminan">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Foto Jaminan
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="dl_jaminan" id="dl_jaminan">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Denah Lokasi Jaminan
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="gn_rangka" id="gn_rangka">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Gesek No. Rangka
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="gn_mesin" id="gn_mesin">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Gesek No. Mesin
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="fc_stnk" id="fc_stnk">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        FC STNK
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="pbb_dll" id="pbb_dll">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        PBB, Bukti Lunas PBB
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="imb" id="imb">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        IMB
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="kwitansi_pencairan"
                            id="kwitansi_pencairan">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Kwitansi Pencairan
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="pk" id="pk">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        PK
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="perjanjian_fidusia"
                            id="perjanjian_fidusia">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Perjanjian Fidusia Notarill
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="pk_notaril" id="pk_notaril">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        PK Add (Notarill)
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="sk_pendebetan" id="sk_pendebetan">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Surat Keterangan Pendebetan
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="sk_menjual" id="sk_menjual">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Surat Keterangan Menjual
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="pt_asuransi" id="pt_asuransi">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Surat Pernyataan Tidak Mengikuti Asuransi
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="ba_serah_terima"
                            id="ba_serah_terima">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Berita Acara Serah Terima
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="spk_barang" id="spk_barang">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Surat Pernyataan Kepemilikan Barang
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="sim_pekarangan"
                            id="sim_pekarangan">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Surat Ijin Memasuki Pekarangan
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="skmht" id="skmht">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        SKMHT
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="sht" id="sht">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        SHT
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="sertif_fidusia"
                            id="sertif_fidusia">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Sertifikat Fidusia
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="foto_akad" id="foto_akad">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Foto Akad/ Pengikatan kredit
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="sertif_asli" id="sertif_asli">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Sertifikat Asli
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="bpkb_asli" id="bpkb_asli">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        BPKB Asli
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="covernote_notaris"
                            id="covernote_notaris">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Covernote Notaris
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="faktur_kendaraan"
                            id="faktur_kendaraan">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Faktur Mobil /Motor
                    </td>
                </tr>
                <tr>
                    <td class="input-group input-group-sm">
                        <select required class="form-control input kecuali" name="ksn_bpkb" id="ksn_bpkb">
                            <option disabled>-Pilih-</option>
                            <option selected style="color: blue" value="Ada">Ada</option>
                            <option style="color: red" value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td>
                        Kwitansi sesuai nama BPKB (3)
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
                <label for="jaminan">Data Jaminan :</label>
                <input id="jaminan" type="hidden" name="jaminan" class="form-control input" required>
                <trix-editor input="jaminan" class="input trix_jaminan"></trix-editor>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group input-group-sm mb-3">
                <label for="usaha_debitur">Usaha Debitur :</label>
                <input id="usaha_debitur" type="hidden" name="usaha_debitur" class="form-control input" required>
                <trix-editor input="usaha_debitur" class="input trix_usaha_debitur"></trix-editor>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group input-group-sm mb-3">
                <label for="tujuan_kredit">Tujuan Kredit :</label>
                <input id="tujuan_kredit" type="hidden" name="tujuan_kredit" class="form-control input" required>
                <trix-editor input="tujuan_kredit" class="input trix_tujuan_kredit"></trix-editor>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group input-group-sm mb-3">
                <label for="sumber_pembayaran">Sumber Pembayaran :</label>
                <input id="sumber_pembayaran" type="hidden" name="sumber_pembayaran" class="form-control input"
                    required>
                <trix-editor input="sumber_pembayaran" class="input trix_sumber_pembayaran"></trix-editor>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group input-group-sm mb-3">
                <label for="catatan">Catatan :</label>
                <input id="catatan" type="hidden" name="catatan" class="form-control input" required>
                <trix-editor input="catatan" class="input trix_catatan"></trix-editor>
            </div>
        </div>
    </div>
</div>
