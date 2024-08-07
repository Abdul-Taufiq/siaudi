<div class="card-body">
    <div class="row ml-2">
        <h5 style="color: rgb(110, 146, 55); font-style: italic; font-weight: bold">Data KKPK 1
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
                <label for="id_kkpk_1">Pilih Data KKPK :</label>
                <select name="id_kkpk_1" id="id_kkpk_1" autocomplete="off" required class="form-control input">
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
                    <td>: <span id="nama_debitur_1"></span>
                    </td>
                </tr>
                <tr>
                    <th style="width: 40%">No Rekening</th>
                    <td>: <span id="no_rekening_1"></span>
                    </td>
                </tr>
                <tr>
                    <th style="width: 40%">Tgl Realisasi</th>
                    <td>: <span id="tgl_realisasi_1"></span>
                    </td>
                </tr>
                <tr>
                    <th style="width: 40%">Plafon</th>
                    <td>: <span id="plafon_1"></span>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-sm" style=" font-size: 14px;">
                <tr>
                    <th style="width: 40%">Status (Kol/DPD)</th>
                    <td>: <span id="status_1"></span>
                    </td>
                </tr>
                <tr>
                    <th style="width: 40%">JKW</th>
                    <td>: <span id="jkw_1"></span>
                    </td>
                </tr>
                <tr>
                    <th style="width: 40%">Tgl Jatuh Tempo</th>
                    <td>: <span id="tgl_jth_tempo_1"></span>
                    </td>
                </tr>
                <tr>
                    <th style="width: 40%">Baki Debet</th>
                    <td>: <span id="baki_debet_1"></span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- add debitur --}}
    <div class="col-md-12 ml-2">
        {{-- tempat menampilkan data dari debitur --}}
        <div id="tambahan_debitur"></div>
        <input class="btn btn-outline-primary col-md-12" id="tambah_kkpk" type="button"
            value="(+) Tambah Data KKPK (+)">
    </div>

</div>
