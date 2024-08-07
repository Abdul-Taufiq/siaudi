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
</style>

<style>
    trix-toolbar [data-trix-button-group="file-tools"] {
        display: none;
    }
</style>



{{-- modal add  Excel --}}
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="quickFormExcel" class="form" action="{{ url('debitur') }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add" style="letter-spacing: 2px; font-weight: bold;">
                        Tambah {{ $title }} By Excel
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="row ml-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cabang">Nasabah Kantor Cabang :</label>
                                        <select class="form-control input" name="cabang" id="cabang" required>
                                            <option disabled selected>- Pilih Kantor Cabang -</option>
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

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="file_excel">Upload Excel Data Debitur :</label>
                                        <input class="form-control input" type="file" id="file_excel"
                                            name="file_excel"
                                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group mb-0">
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
{{-- End modal add  Excel --}}



{{-- modal add Manual --}}
<div class="modal fade" id="addModalManual" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="quickFormManual" class="form" action="{{ url('debitur-manual') }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add" style="letter-spacing: 2px; font-weight: bold;">
                        Tambah {{ $title }} Manual
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="row ml-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cabang_manual">Nasabah Kantor Cabang :</label>
                                        <select class="form-control input" name="cabang_manual" id="cabang_manual"
                                            required>
                                            <option disabled selected>- Pilih Kantor Cabang -</option>
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

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_rekening">Nomor Rekening :</label>
                                        <input class="form-control input" type="text" id="no_rekening"
                                            name="no_rekening" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_nasabah">Nama Nasabah :</label>
                                        <input class="form-control input" type="text" id="nama_nasabah"
                                            name="nama_nasabah" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="alamat">Alamat :</label>
                                        <textarea class="form-control input" name="alamat" id="alamat" cols="10" rows="2" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="wajib">Tanggal Realisasi :</label>
                                        <div class="input-group date" id="date_tgl_realisasi"
                                            data-target-input="nearest">
                                            <input readonly type="text"
                                                class="form-control datetimepicker-input input"
                                                data-target="#date_tgl_realisasi" id="tgl_realisasi"
                                                name="tgl_realisasi" required />
                                            <div class="input-group-append" data-target="#date_tgl_realisasi"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jkw">JKW :</label>
                                        <input class="form-control input" type="text" id="jkw"
                                            name="jkw" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="wajib">Tanggal Jatuh Tempo :</label>
                                        <div class="input-group date" id="date_tgl_jth_tempo"
                                            data-target-input="nearest">
                                            <input readonly type="text"
                                                class="form-control datetimepicker-input input"
                                                data-target="#date_tgl_jth_tempo" id="tgl_jth_tempo"
                                                name="tgl_jth_tempo" required />
                                            <div class="input-group-append" data-target="#date_tgl_jth_tempo"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="plafon">Plafon :</label>
                                        <input class="form-control input" type="text" id="plafon"
                                            name="plafon" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="baki_debet">Baki Debet :</label>
                                        <input class="form-control input" type="text" id="baki_debet"
                                            name="baki_debet" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tunggakan_bunga">Tunggakan Bunga :</label>
                                        <input class="form-control input" type="text" id="tunggakan_bunga"
                                            name="tunggakan_bunga" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tunggakan_pokok">Tunggakan Pokok :</label>
                                        <input class="form-control input" type="text" id="tunggakan_pokok"
                                            name="tunggakan_pokok" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dpd">DPD :</label>
                                        <input class="form-control input" type="text" id="dpd"
                                            name="dpd" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kol">Kol :</label>
                                        <input class="form-control input" type="text" id="kol"
                                            name="kol" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_hp">No Hp :</label>
                                        <input class="form-control input" type="text" id="no_hp"
                                            name="no_hp" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kolektor">Kolektor :</label>
                                        <input class="form-control input" type="text" id="kolektor"
                                            name="kolektor" required>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="form-group mb-0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="terms" class="custom-control-input"
                                        id="exampleCheckmanual" required>
                                    <label class="custom-control-label" for="exampleCheckmanual">
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
                    <button id="simpanManual" type="button" class="btn btn-primary" style="letter-spacing: 2px;">
                        <i class="fa-regular fa-floppy-disk"></i> &nbsp; <b>SIMPAN</b></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- End modal add Manual --}}



{{-- modal edit Manual --}}
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cabang_edit">Nasabah Kantor Cabang :</label>
                                        <select class="form-control input" name="cabang_edit" id="cabang_edit"
                                            required>
                                            <option disabled selected>- Pilih Kantor Cabang -</option>
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

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_rekening_edit">Nomor Rekening :</label>
                                        <input class="form-control input" type="text" id="no_rekening_edit"
                                            name="no_rekening_edit" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_nasabah_edit">Nama Nasabah :</label>
                                        <input class="form-control input" type="text" id="nama_nasabah_edit"
                                            name="nama_nasabah_edit" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="alamat_edit">Alamat :</label>
                                        <textarea class="form-control input" name="alamat_edit" id="alamat_edit" cols="10" rows="2" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="wajib">Tanggal Realisasi :</label>
                                        <div class="input-group date" id="date_tgl_realisasi_edit"
                                            data-target-input="nearest">
                                            <input readonly type="text"
                                                class="form-control datetimepicker-input input"
                                                data-target="#date_tgl_realisasi_edit" id="tgl_realisasi_edit"
                                                name="tgl_realisasi_edit" required />
                                            <div class="input-group-append" data-target="#date_tgl_realisasi_edit"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jkw_edit">JKW :</label>
                                        <input class="form-control input" type="text" id="jkw_edit"
                                            name="jkw_edit" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="wajib">Tanggal Jatuh Tempo :</label>
                                        <div class="input-group date" id="date_tgl_jth_tempo_edit"
                                            data-target-input="nearest">
                                            <input readonly type="text"
                                                class="form-control datetimepicker-input input"
                                                data-target="#date_tgl_jth_tempo_edit" id="tgl_jth_tempo_edit"
                                                name="tgl_jth_tempo_edit" required />
                                            <div class="input-group-append" data-target="#date_tgl_jth_tempo_edit"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="plafon_edit">Plafon :</label>
                                        <input class="form-control input" type="text" id="plafon_edit"
                                            name="plafon_edit" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="baki_debet_edit">Baki Debet :</label>
                                        <input class="form-control input" type="text" id="baki_debet_edit"
                                            name="baki_debet_edit" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tunggakan_bunga_edit">Tunggakan Bunga :</label>
                                        <input class="form-control input" type="text" id="tunggakan_bunga_edit"
                                            name="tunggakan_bunga_edit" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tunggakan_pokok_edit">Tunggakan Pokok :</label>
                                        <input class="form-control input" type="text" id="tunggakan_pokok_edit"
                                            name="tunggakan_pokok_edit" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dpd_edit">DPD :</label>
                                        <input class="form-control input" type="text" id="dpd_edit"
                                            name="dpd_edit" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kol_edit">Kol :</label>
                                        <input class="form-control input" type="text" id="kol_edit"
                                            name="kol_edit" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_hp_edit">No Hp :</label>
                                        <input class="form-control input" type="text" id="no_hp_edit"
                                            name="no_hp_edit" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kolektor_edit">Kolektor :</label>
                                        <input class="form-control input" type="text" id="kolektor_edit"
                                            name="kolektor_edit" required>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="form-group mb-0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="terms" class="custom-control-input"
                                        id="exampleCheckmanualEdit" required>
                                    <label class="custom-control-label" for="exampleCheckmanualEdit">
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
                    <button id="simpanEdit" type="button" class="btn btn-primary" style="letter-spacing: 2px;">
                        <i class="fa-regular fa-floppy-disk"></i> &nbsp; <b>SIMPAN</b></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- End modal edit Manual --}}
