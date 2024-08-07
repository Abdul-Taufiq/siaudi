<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        body {
            font-family: 'JetBrains Mono';
            font-size: 9pt;
        }
    </style>
</head>

<body>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h4><b>KERTAS KERJA PEMERIKSAAN KREDIT &rarr;</b></h4>
        </div>
        <div class="card-body">
            <div class="row ml-2">
                <div class="col-md-6">
                    <table style="width: 100%;" class="table table-striped">
                        <tr>
                            <th>Kantor Cabang</th>
                            <td>{{ $kkpk->cabang->cabang }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Pemeriksaan</th>
                            <td>{{ $kkpk->tgl_pemeriksaan->translatedFormat('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Nama Pemeriksa</th>
                            <td>{{ $kkpk->nama_pemeriksa }}</td>
                        </tr>
                        <tr>
                            <th>Nama Debitur</th>
                            <td>{{ $kkpk->debitur->nama_nasabah }}</td>
                        </tr>
                        <tr>
                            <th>No Rekening</th>
                            <td>{{ $kkpk->debitur->no_rekening }}</td>
                        </tr>
                        <tr>
                            <th>Tgl Realisasi</th>
                            <td>{{ $kkpk->debitur->tgl_realisasi->translatedFormat('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Plafon</th>
                            <td>
                                {{ $kkpk->debitur->plafon ? 'Rp ' . number_format($kkpk->debitur->plafon, 0, ',', '.') : 'belum ada data' }}
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <table style="width: 100%;" class="table table-striped">
                        <tr>
                            <th>Jenis Pemeriksaan</th>
                            <td>{{ $kkpk->jns_pemeriksaan }}</td>
                        </tr>
                        <tr>
                            <th>Fas Kredit</th>
                            <td>{{ $kkpk->fas_kredit }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kredit</th>
                            <td>{{ $kkpk->jns_kredit }}</td>
                        </tr>
                        <tr>
                            <th>Status (Kol/DPD)</th>
                            <td>{{ $kkpk->debitur->kol . '/' . $kkpk->debitur->dpd }}</td>
                        </tr>
                        <tr>
                            <th>JKW</th>
                            <td>{{ $kkpk->debitur->jkw }}</td>
                        </tr>
                        <tr>
                            <th>Tgl Jatuh Tempo</th>
                            <td>{{ $kkpk->debitur->tgl_jth_tempo != null ? $kkpk->debitur->tgl_jth_tempo->translatedFormat('d F Y') : 'Tanggal tidak valid!' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Baki Debet</th>
                            <td>
                                {{ $kkpk->debitur->baki_debet ? 'Rp ' . number_format($kkpk->debitur->baki_debet, 0, ',', '.') : 'belum ada data' }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card card-outline card-primary mb-0"></div>
    </div>


    {{-- pemutus kredit --}}
    <div class="card card-outline card-warning">
        <div class="card-header">
            <h4><b>PEMUTUS KREDIT &rarr;</b></h4>
        </div>
        <div class="card-body">
            <div class="row ml-2">
                <div class="col-md-6">
                    <table style="width: 100%;" class="table table-striped">
                        <tr>
                            <th>Account Officer</th>
                            <td>{{ $kkpk->nama_ao }}</td>
                        </tr>
                        <tr>
                            <th>Analis</th>
                            <td>{{ $kkpk->nama_analis }}</td>
                        </tr>
                        <tr>
                            <th>Kakom</th>
                            <td>{{ $kkpk->nama_kakom }}</td>
                        </tr>
                        <tr>
                            <th>Pincab</th>
                            <td>{{ $kkpk->nama_pincab }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table style="width: 100%;" class="table table-striped">
                        <tr>
                            <th>Analis Area</th>
                            <td>{{ $kkpk->nama_analis_area }}</td>
                        </tr>
                        <tr>
                            <th>Area Manager</th>
                            <td>{{ $kkpk->nama_area_manager }}</td>
                        </tr>
                        <tr>
                            <th>Manager Bisnis</th>
                            <td>{{ $kkpk->nama_manager_bisnis }}</td>
                        </tr>
                        <tr>
                            <th>Analis KPM</th>
                            <td>{{ $kkpk->nama_analis_kpm }}</td>
                        </tr>
                        <tr>
                            <th>Direksi</th>
                            <td>{{ $kkpk->nama_direksi }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card card-outline card-warning mb-0"></div>
    </div>


    {{-- pemeriksaan --}}
    <div class="card card-outline card-success">
        <div class="card-header">
            <h4><b>PEMERIKSAAN &rarr;</b></h4>
        </div>
        <div class="card-body">
            <div class="row ml-2">
                <div class="col-md-6">
                    <table style="width: 100%;" class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 25%">A/T</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $kkpk->keterangan->ktp_debitur }}</td>
                                <td>KTP Debitur</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->ktp_pasangan }}</td>
                                <td>KTP Pasangan</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->kartu_keluarga }}</td>
                                <td>Kartu Keluarga</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->srt_nikah }}</td>
                                <td>Surat Nikah</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->akte_cerai_kematian }}</td>
                                <td>Akte Cerai / Kematian</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->ktp_debitur_penjamin }}</td>
                                <td>KTP Penjamin</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->ktp_pasangan_penjamin }}</td>
                                <td>KTP Pasangan Penjamin</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->kartu_keluarga_penjamin }}</td>
                                <td>Kartu Keluarga Penjamin</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->srt_nikah_penjamin }}</td>
                                <td>Surat Nikah Penjamin</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->akte_cerai_kematian_penjamin }}</td>
                                <td>Akte Cerai / Kematian Penjamin</td>
                            </tr>

                            <tr>
                                <td>{{ $kkpk->keterangan->npwp }}</td>
                                <td>NPWP*</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->info_siup }}</td>
                                <td>SIUP*/TDP*/SKU*/Akte CV*/Akte PT*</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->slik_debitur }}</td>
                                <td>SLIK Debitur</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->slik_pasangan }}</td>
                                <td>SLIK Pasangan</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->slik_badan_usaha }}</td>
                                <td>SLIK Badan Usaha</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->fa_kredit }}</td>
                                <td>Form Aplikasi Kredit</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->kk_analis }}</td>
                                <td>Kertas Kerja Analis</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->muk }}</td>
                                <td>MUK</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->analisa_lr }}</td>
                                <td>Analisa L/R</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->persetujuan_muk }}</td>
                                <td>Persetujuan MUK*</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->info_deviasi }}</td>
                                <td>Pemberitahuan/Persetujuan Deviasi</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->permohonan_add_deb }}</td>
                                <td>Permohonan Add (Deb)</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->info_add }}</td>
                                <td>Pemberitahuan/Persetujuan Add</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->slip_gaji }}</td>
                                <td>Slip Gaji</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->rek_tabungan }}</td>
                                <td>Rek Tabungan</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->nota_penjualan_pembelian }}</td>
                                <td>Nota Penjualan/Pembelian</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->foto_usaha }}</td>
                                <td>Foto Usaha</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->denah_lokasi_usaha }}</td>
                                <td>Denah lokasi Usaha</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->surat_keterangan }}</td>
                                <td>Surat Keterangan dr Instansi Terkait</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->rab }}</td>
                                <td>RAB</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->spk_mou }}</td>
                                <td>SPK/MOU</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table style="width: 100%;" class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 25%">A/T</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $kkpk->keterangan->bukti_pelunasan }}</td>
                                <td>Mutasi Pembyrn 12bln terakhir (TO)</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->mutasi_to }}</td>
                                <td>Bukti Pelunasan (TO)</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->lp_jaminan }}</td>
                                <td>Lembar Penilaian Jaminan</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->app_independen }}</td>
                                <td>Apprasial Independen</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->foto_jaminan }}</td>
                                <td>Foto Jaminan</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->dl_jaminan }}</td>
                                <td>Denah Lokasi Jaminan</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->gn_rangka }}</td>
                                <td>Gesek No.Rangka</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->gn_mesin }}</td>
                                <td>Gesek No.Mesin</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->fc_stnk }}</td>
                                <td>FC STNK</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->pbb_dll }}</td>
                                <td>PBB, Bukti Lunas PBB</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->imb }}</td>
                                <td>IMB</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->kwitansi_pencairan }}</td>
                                <td>Kwitansi Pencairan</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->pk }}</td>
                                <td>PK</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->perjanjian_fidusia }}</td>
                                <td>Perjanjian Fidusia Notarill</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->pk_notaril }}</td>
                                <td>PK Add (Notarill)</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->sk_pendebetan }}</td>
                                <td>Surat Keterangan Pendebetan</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->sk_menjual }}</td>
                                <td>Surat Keterangan Menjual</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->pt_asuransi }}</td>
                                <td>Surat Pernyataan Tidak Mengikuti Asuransi</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->ba_serah_terima }}</td>
                                <td>Berita Acara Serah Terima</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->spk_barang }}</td>
                                <td>Surat Pernyataan Kepemilikan Barang</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->sim_pekarangan }}</td>
                                <td>Surat Ijin Memasuki Pekarangan</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->skmht }}</td>
                                <td>SKMHT</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->sht }}</td>
                                <td>SHT</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->sertif_fidusia }}</td>
                                <td>Sertif Fidusia</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->foto_akad }}</td>
                                <td>Foto Akad/Pengikatan Kredit</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->sertif_asli }}</td>
                                <td>Sertifikat Asli</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->bpkb_asli }}</td>
                                <td>BPKB Asli</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->covernote_notaris }}</td>
                                <td>Covernote Notaris</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->faktur_kendaraan }}</td>
                                <td>Faktur Mobil/Motor</td>
                            </tr>
                            <tr>
                                <td>{{ $kkpk->keterangan->ksn_bpkb }}</td>
                                <td>Kwitansi Sesuai Nama BPKB (3)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card card-outline card-success mb-0"></div>
    </div>


    {{-- pemutus kredit --}}
    <div class="card card-outline card-secondary">
        <div class="card-header">
            <h4><b>LAINNYA &rarr;</b></h4>
        </div>
        <div class="card-body">
            <div class="col-md-8">
                <table style="width: 100%;" class="table">
                    <tr>
                        <th style="width: 25%">Usaha Debitur</th>
                        <td style="width: 1%">:</td>
                        <td>{!! $kkpk->debitur->usaha_debitur !!}</td>
                    </tr>
                    <tr>
                        <th>Tujuan Kredit</th>
                        <td>:</td>
                        <td>{!! $kkpk->debitur->tujuan_kredit !!}</td>
                    </tr>
                    <tr>
                        <th>Sumber Pembayaran</th>
                        <td>:</td>
                        <td>{!! $kkpk->debitur->sumber_pembayaran !!}</td>
                    </tr>
                    <tr>
                        <th>Data Jaminan</th>
                        <td>:</td>
                        <td>{!! $kkpk->debitur->jaminan !!}</td>
                    </tr>
                </table>
            </div>

            <br>
            <div class="col-md-12">
                <table style="width: 100%;" class="table">
                    <tr>
                        <th>Catatan :</th>
                    </tr>
                    <tr>
                        <td>{!! $kkpk->keterangan->catatan !!}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="card card-outline card-secondary mb-0"></div>
    </div>

</body>

</html>
