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




{{-- modal add Manual --}}
<div class="modal fade" id="addModalManual" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="quickFormManual" class="form" action="{{ url('lainnya') }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add" style="letter-spacing: 2px; font-weight: bold;">
                        Tambah {{ $title }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="row ml-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama">Nama :</label>
                                        <input class="form-control input" type="text" id="nama" name="nama"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jabatan">Jabatan :</label>
                                        <select class="form-control input" name="jabatan" id="jabatan" required>
                                            <option disabled selected>- Pilih Jabatan -</option>
                                            <option value="Direksi">Direktur Utama</option>
                                            <option value="Direksi">Direktur Komersial</option>
                                            <option value="Manager Bisnis">Manager Bisnis</option>
                                            <option value="Area Manager">Area Manager</option>
                                            <option value="Analis Area">Analis Kredit Area</option>
                                            <option value="Analis KPM">Analis KPM</option>
                                        </select>
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
                                        <label for="nama_edit">Nama :</label>
                                        <input class="form-control input" type="text" id="nama_edit" name="nama_edit"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jabatan">Jabatan :</label>
                                        <select class="form-control input" name="jabatan" id="jabatan" required>
                                            <option disabled selected>- Pilih Jabatan -</option>
                                            <option value="Direksi">Direktur Utama</option>
                                            <option value="Direksi">Direktur Komersial</option>
                                            <option value="Manager Bisnis">Manager Bisnis</option>
                                            <option value="Area Manager">Area Manager</option>
                                            <option value="Analis Area">Analis Kredit Area</option>
                                            <option value="Analis KPM">Analis KPM</option>
                                        </select>
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
