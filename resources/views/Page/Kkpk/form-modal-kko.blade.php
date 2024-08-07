<div class="card-body">
    <div class="row ml-2">
        {{-- detail debitur  --}}
        <div class="col-md-6">
            <table class="table table-sm" style=" font-size: 14px;">
                <tr>
                    <th style="width: 40%">Nama Debitur</th>
                    <td style="width: 1px;">:</td>
                    <td id="nama_debitur_kko"></td>
                </tr>
                <tr>
                    <th style="width: 40%">No Rekening</th>
                    <td style="width: 1px;">:</td>
                    <td id="no_rekening_kko"></td>
                </tr>
                <tr>
                    <th style="width: 40%">Alamat</th>
                    <td style="width: 1px;">:</td>
                    <td id="alamat_kko"></td>
                </tr>
                <tr>
                    <th style="width: 40%">Data Jaminan</th>
                    <td style="width: 1px;">:</td>
                    <td id="jaminan_kko"></td>
                </tr>
                <tr>
                    <th style="width: 40%">Tujuan Pinjaman</th>
                    <td style="width: 1px;">:</td>
                    <td id="tujuan_pinjaman_kko"></td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-sm" style=" font-size: 14px;">
                <tr>
                    <th style="width: 40%">Tgl Realisasi</th>
                    <td style="width: 1px;">:</td>
                    <td id="tgl_realisasi_kko"></td>
                </tr>
                <tr>
                    <th style="width: 40%">Tgl Jatuh Tempo</th>
                    <td style="width: 1px;">:</td>
                    <td id="tgl_jth_tempo_kko"></td>
                </tr>
                <tr>
                    <th style="width: 40%">Status (Kol/DPD)</th>
                    <td style="width: 1px;">:</td>
                    <td id="status_kko"></td>
                </tr>
                <tr>
                    <th style="width: 40%">JKW</th>
                    <td style="width: 1px;">:</td>
                    <td id="jkw_kko"></td>
                </tr>
                <tr>
                    <th style="width: 40%">Plafon</th>
                    <td style="width: 1px;">:</td>
                    <td id="plafon_kko"></td>
                </tr>
                <tr>
                    <th style="width: 40%">Baki Debet</th>
                    <td style="width: 1px;">:</td>
                    <td id="baki_debet_kko"></td>
                </tr>

            </table>
        </div>
    </div>

    <hr>
    <div class="row ml-2">
        <div class="col-md-6">
            <div class="form-group">
                <label for="tgl_kunjungan">Tanggal Kunjungan :</label>
                <div class="input-group date" id="date_kunjungan" data-target-input="nearest">
                    <input type="text" class="form-control input datetimepicker-input" data-target="#date_kunjungan"
                        id="tgl_kunjungan" name="tgl_kunjungan" required
                        placeholder="format : Tanggal-Bulan-Tahun, contoh: 31-12-1995" />
                    <div class="input-group-append" data-target="#date_kunjungan" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="alamat_jaminan">Alamat Jaminan</label>
                <textarea class="form-control input" name="alamat_jaminan" id="alamat_jaminan" cols="30" rows="3" required></textarea>
            </div>
        </div>
    </div>

    <div class="row ml-2">
        <div class="col-md-12">
            <div class="form-group">
                <label for="deskripsi">Deskripsi :</label>
                <textarea class="input" name="deskripsi" id="deskripsi" cols="30" rows="10" required></textarea>
            </div>
        </div>
    </div>
</div>
