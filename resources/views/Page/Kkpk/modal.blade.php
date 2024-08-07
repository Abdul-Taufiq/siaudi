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
        border-color: red;
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



{{-- modal add   --}}
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form id="addForm" class="form" action="{{ url('data-kkpk') }}" method="post" enctype="multipart/form-data">
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

                        {{-- load form --}}
                        @include('Page.Kkpk.form-modal')

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
                    <button id="simpan" type="button" class="btn btn-primary" style="letter-spacing: 2px;">
                        <i class="fa-regular fa-floppy-disk"></i> &nbsp; <b>SIMPAN</b></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- End modal add   --}}



{{-- edit --}}
<div class="modal fade" id="modalEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
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

                        {{-- load form --}}
                        @include('Page.Kkpk.form-modal')

                        <div class="card-footer">
                            <div class="form-group input-group-sm mb-3 mb-0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="terms" class="custom-control-input tidak_edit"
                                        id="exampleEdits" required>
                                    <label class="custom-control-label" for="exampleEdits">
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
                    <button id="simpanEdit" class="btn btn-primary" style="letter-spacing: 2px;">
                        <i class="fa-regular fa-floppy-disk"></i> &nbsp; <b>SIMPAN</b></button>
                    <button type="button" id="Edit_data_OTS" class="btn btn-warning"><i class="fa fa-edit"></i> Edit
                        Data OTS</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- End modal edit   --}}


{{-- modal add KKO   --}}
<div class="modal fade" id="modalTambahKKO" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalTambahKKOLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="TambahKKO" class="form" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addKKO" style="letter-spacing: 2px; font-weight: bold;">
                        Tambah OTS
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card card-outline card-primary">

                        {{-- load form --}}
                        @include('Page.Kkpk.form-modal-kko')

                        <div class="card-footer">
                            <div class="form-group input-group-sm mb-3 mb-0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="terms" class="custom-control-input"
                                        id="TermsKKO" required>
                                    <label class="custom-control-label" for="TermsKKO">
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
                    <button id="simpanKKO" type="button" class="btn btn-primary" style="letter-spacing: 2px;">
                        <i class="fa-regular fa-floppy-disk"></i> &nbsp; <b>SIMPAN</b></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- End modal add  KKO --}}


{{-- modal detail --}}
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHeader" style="letter-spacing: 2px; font-weight: bold;">DETAIL
                    DATA
                </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"
                    onclick="closeMymodal()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <iframe id="frameDetail" type="" width="100%" height="500px"></iframe>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" id="kkpk_print" target="_blank"><i class="fa-solid fa-print"></i> Cetak
                    KKPK</a>
                <button class="btn btn-success" id="detail_data_kko"><i class="fa fa-eye"></i> Lihat Data
                    OTS</button>
                <button class="btn btn-secondary" type="button" data-dismiss="modal"
                    onclick="closeMymodal()">Kembali</button>
            </div>
        </div>
    </div>
</div>


{{-- second modal detail OTS --}}
<div class="modal fade" id="ModalKKO" aria-hidden="true" aria-labelledby="LabelModalKKO" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalKKO">Modal 2</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <iframe id="frameDetailKKO" type="" width="100%" height="400px"></iframe>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" id="ots_print" target="_blank"><i class="fa-solid fa-print"></i> Cetak
                    OTS</a>
                <button class="btn btn-secondary" onclick="OpenModalKKPK()"><i class="fa-solid fa-arrow-left"></i>
                    Back to Data KKPK</button>
            </div>
        </div>
    </div>
</div>

{{-- second modal Edit OTS --}}
<div class="modal fade" id="ModalEditOTS" aria-hidden="true" aria-labelledby="LabelModalEditOTS" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalEditOTS">Modal 2</h5>
                <button type="button" class="btn-close" onclick=" openFirstModal()" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- load form --}}
                <iframe id="frameEditOTS" frameborder="0" width="100%" height="480px"></iframe>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
