@include('partial.header')
@yield('header')
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



<body>
    <form id="EditForm" action="  {{ url('edit-kko/' . $kkpk->id_kkpk) }} " class="form" method="post"
        enctype="multipart/form-data">
        @method('patch')
        @csrf
        <div class="card card-outline card-primary">
            <div class="card-body">
                <div class="row ml-2">
                    {{-- detail debitur  --}}
                    <div class="col-md-6">
                        <table class="table table-sm" style=" font-size: 14px;">
                            <tr>
                                <th style="width: 40%">Nama Debitur</th>
                                <td>{{ $kkpk->debitur->nama_nasabah }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 40%">No Rekening</th>
                                <td>{{ $kkpk->debitur->no_rekening }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 40%">Alamat</th>
                                <td>{{ $kkpk->debitur->alamat }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 40%">Data Jaminan</th>
                                <td>{!! $kkpk->debitur->jaminan !!}
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 40%">Tujuan Pinjaman</th>
                                <td>{!! $kkpk->debitur->tujuan_kredit !!}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm" style=" font-size: 14px;">
                            <tr>
                                <th style="width: 40%">Tgl Realisasi</th>
                                <td>{{ $kkpk->debitur->tgl_realisasi->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th style="width: 40%">Tgl Jatuh Tempo</th>
                                <td>{{ $kkpk->debitur->tgl_jth_tempo->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th style="width: 40%">Status (Kol/DPD)</th>
                                <td>{{ $kkpk->debitur->kol . '/' . $kkpk->debitur->dpd }}</td>
                            </tr>
                            <tr>
                                <th style="width: 40%">JKW</th>
                                <td>{{ $kkpk->debitur->jkw }}</td>
                            </tr>
                            <tr>
                                <th style="width: 40%">Plafon</th>
                                <td>
                                    {{ $kkpk->debitur->plafon ? 'Rp ' . number_format($kkpk->debitur->plafon, 0, ',', '.') : 'belum ada data' }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 40%">Baki Debet</th>
                                <td>
                                    {{ $kkpk->debitur->baki_debet ? 'Rp ' . number_format($kkpk->debitur->baki_debet, 0, ',', '.') : 'belum ada data' }}
                                </td>
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
                                <input readonly type="text"
                                    class="form-control input datetimepicker-input border-success"
                                    data-target="#date_kunjungan" id="tgl_kunjungan" name="tgl_kunjungan" required
                                    placeholder="format : Tanggal-Bulan-Tahun, contoh: 31-12-1995"
                                    value="{{ $data->tgl_kunjungan->format('d-m-Y') }}" />
                                <div class="input-group-append" data-target="#date_kunjungan"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="alamat_jaminan">Alamat Jaminan</label>
                            <textarea class="form-control input border-success" name="alamat_jaminan" id="alamat_jaminan" cols="30"
                                rows="3" required>
                                {{ $kkpk->debitur->alamat_jaminan }}
                            </textarea>
                        </div>
                    </div>
                </div>

                <div class="row ml-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi :</label>
                            <textarea class="input " name="deskripsi" id="deskripsi" cols="30" rows="10" required>
                                {!! $data->deskripsi !!}
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="form-group input-group-sm mb-3 mb-0">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="terms" class="custom-control-input" id="TermsKKO" required>
                        <label class="custom-control-label" for="TermsKKO">
                            Saya setuju dengan <a href="{{ asset('Juknis/Juknis.pdf') }}" target="_blank">ketentuan
                                yang berlaku</a>.
                        </label>
                    </div>
                    <br>
                    <button id="simpan" type="button" class="btn btn-primary" style="letter-spacing: 2px;">
                        <i class="fa-regular fa-floppy-disk"></i> &nbsp; <b>SIMPAN</b></button>
                </div>
            </div>
            <div class="card card-outline card-primary mb-0"></div>
        </div>
    </form>


    @section('script')
        <script>
            $(document).ready(function() {
                //summernote
                function initializeSummernote(selector, placeholder, height) {
                    $(selector).summernote({
                        placeholder: placeholder,
                        tabsize: 2,
                        height: height,
                        callbacks: {
                            onInit: function() {
                                // Menambahkan kelas CSS ke elemen yang dihasilkan oleh Summernote
                                $(selector).next(".note-editor").addClass("input");
                            },
                        },
                    });
                }

                // Inisialisasi Summernote dengan selector, placeholder, dan tinggi yang berbeda
                initializeSummernote("#deskripsi", "Keterangan...", 200);

                // event hendrler summernote
                $(document).on("summernote.change", function(e, contents) {
                    var $editor = $(e.target).next(".note-editor");

                    // Jika konten editor kosong, tambahkan kelas "border-danger", dan hapus kelas "border-success"
                    if (contents.trim() === "") {
                        $editor.addClass("border-danger").removeClass("border-success");
                    } else {
                        // Jika konten editor tidak kosong, tambahkan kelas "border-success", dan hapus kelas "border-danger"
                        $editor.addClass("border-success").removeClass("border-danger");
                    }
                });
                // Menonaktifkan tombol codeview untuk semua editor Summernote
                $(".btn-codeview").prop("disabled", true);
                $(".btn-fullscreen").prop("disabled", true);
                $(".note-insert button").prop("disabled", true);


                // protect form input
                $("input").attr("autocomplete", "off");
                // default form danger
                $(".input").addClass("border-success");
                $(document).on("input", ".input", function() {
                    if ($(this).val().trim() === "") {
                        // Jika kosong, berikan border warna merah dan hapus border warna hijau
                        $(this).addClass("border-danger").removeClass("border-success");
                    } else {
                        // Jika tidak kosong, berikan border warna hijau dan hapus border warna merah
                        $(this).addClass("border-success").removeClass("border-danger");
                    }
                });

                $("#date_kunjungan").datetimepicker({
                    format: "DD-MM-yyyy",
                });


                // ADD FORM
                $("#simpan").on("click", function() {
                    // Ganti #nama_form sesuai dengan ID formulir Anda
                    var $form = $("#EditForm");

                    // Validasi input yang diperlukan
                    var inputRequired = $form.find("[required]").not(".trix-input--dialog");
                    var terms = document.getElementById("TermsKKO");
                    console.log(terms.checked);

                    var inputKosong = inputRequired.filter(function() {
                        var val = $(this).val();
                        return val === null || val.trim() === "";
                    });
                    // console.log(inputKosong);

                    if (terms.checked == false) {
                        // Jika ada input yang kosong, tampilkan alert gagal simpan
                        Swal.fire({
                            title: "Gagal Simpan Data!",
                            text: "PASTIKAN UNTUK MENYETUJUI TERMS APLIKASI!",
                            icon: "error",
                        });
                        return;
                    } else {
                        if (inputKosong.length > 0) {
                            // Jika ada input yang kosong, tampilkan alert gagal simpan
                            Swal.fire({
                                title: "Gagal Simpan Data!",
                                text: "ADA DATA MANDATORI YANG BELUM DIISI, PASTIKAN UNTUK MENGISI SEMUA DATA MANDATORI!",
                                icon: "error",
                            });
                            return;
                        }

                        // Jika semua input diperlukan sudah terisi, tampilkan konfirmasi simpan
                        Swal.fire({
                            title: "Konfirmasi Simpan Data!",
                            text: "SEBELUM MENYIMPAN DATA HARAP PERHATIKAN BAHWA DATA SUDAH BENAR! DAN JANGAN LEWATKAN PERINGATAN SEKECIL APAPUN!",
                            icon: "info",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Ya, Simpan!",
                            cancelButtonText: "Batal",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $form.submit();
                            }
                        });
                    }
                });
            });
        </script>
    @endsection




    @yield('footer')
    @include('partial.footer')


</body>

</html>
