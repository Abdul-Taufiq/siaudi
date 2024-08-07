@extends('partial.main')
@section('konten')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            {{-- Email Pengajuan --}}
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <h4>Pengajuan Email</h4>
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $fp }}</h3>

                                <p>Semua Form</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $acc_fp }}</sup></h3>

                                <p>Form Diterima</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $null_fp }}</h3>

                                <p>Proses</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-spinner" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $rej_fp }}</h3>

                                <p>Form Ditolak</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
            </div>
            <hr>

            {{-- Email Reset --}}
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <h4>Reset Email</h4>
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $fr }}</h3>

                                <p>Semua Form</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $acc_fr }}</sup></h3>

                                <p>Form Diterima</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $null_fr }}</h3>

                                <p>Proses</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-spinner" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $rej_fr }}</h3>

                                <p>Form Ditolak</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
            </div>
            <hr>

            {{-- MSO Pengajuan --}}
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <h4>Pengajuan User MSO</h4>
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $msop }}</h3>

                                <p>Semua Form</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $acc_msop }}</sup></h3>

                                <p>Form Diterima</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $null_msop }}</h3>

                                <p>Proses</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-spinner" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $rej_msop }}</h3>

                                <p>Form Ditolak</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
            </div>
            <hr>

            {{-- MSO Reset --}}
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <h4>MSO Reset Password</h4>
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $msor }}</h3>

                                <p>Semua Form</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $acc_msor }}</sup></h3>

                                <p>Form Diterima</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $null_msor }}</h3>

                                <p>Proses</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-spinner" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $rej_msor }}</h3>

                                <p>Form Ditolak</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
            </div>
            <hr>




            <div class="row">
                <h4 style="letter-spacing: 2px; word-spacing: 8px">&empty; PEMBATALAN TRANSAKSI</h4>
                <!-- AKUNTANSI -->
                <div class="col-md-6">
                    <div class="card card-widget">
                        <div class="user-header bg-primary">
                            <h4 style="text-align: center; margin-top: 6px; letter-spacing: 2px;">
                                &rAarr; &nbsp; Akuntansi &nbsp; &lAarr;
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 border-right bg-info">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $pemAkuntansi }}</h5>
                                        <span class="description-text">ALL</span>
                                    </div>
                                </div>
                                <div class="col-sm-3 border-right bg-success">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $acc_pemAkuntansi }}</h5>
                                        <span class="description-text">APPROVED</span>
                                    </div>
                                </div>
                                <div class="col-sm-3 border-right bg-warning">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $null_pemAkuntansi }}</h5>
                                        <span class="description-text">PROCESS</span>
                                    </div>
                                </div>
                                <div class="col-sm-3 bg-danger">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $rej_pemAkuntansi }}</h5>
                                        <span class="description-text">REJECTED</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Antar Bank -->
                <div class="col-md-6">
                    <div class="card card-widget">
                        <div class="user-header bg-secondary">
                            <h4 style="text-align: center; margin-top: 6px; letter-spacing: 2px;">
                                &rAarr; &nbsp; Antar Bank &nbsp; &lAarr;
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 border-right bg-info">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $pemBank }}</h5>
                                        <span class="description-text">ALL</span>
                                    </div>
                                </div>

                                <div class="col-sm-3 border-right bg-success">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $acc_pemBank }}</h5>
                                        <span class="description-text">APPROVED</span>
                                    </div>
                                </div>

                                <div class="col-sm-3 border-right bg-warning">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $null_pemBank }}</h5>
                                        <span class="description-text">PROCESS</span>
                                    </div>
                                </div>

                                <div class="col-sm-3 bg-danger">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $rej_pemBank }}</h5>
                                        <span class="description-text">REJECTED</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- E-Collector -->
                <div class="col-md-6">
                    <div class="card card-widget">
                        <div class="user-header bg-primary">
                            <h4 style="text-align: center; margin-top: 6px; letter-spacing: 2px;">
                                &rAarr; &nbsp; E-Collector &nbsp; &lAarr;
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 border-right bg-info">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $pemEcoll }}</h5>
                                        <span class="description-text">ALL</span>
                                    </div>
                                </div>
                                <div class="col-sm-3 border-right bg-success">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $acc_pemEcoll }}</h5>
                                        <span class="description-text">APPROVED</span>
                                    </div>
                                </div>
                                <div class="col-sm-3 border-right bg-warning">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $null_pemEcoll }}</h5>
                                        <span class="description-text">PROCESS</span>
                                    </div>
                                </div>
                                <div class="col-sm-3 bg-danger">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $rej_pemEcoll }}</h5>
                                        <span class="description-text">REJECTED</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inventaris -->
                <div class="col-md-6">
                    <div class="card card-widget">
                        <div class="user-header bg-secondary">
                            <h4 style="text-align: center; margin-top: 6px; letter-spacing: 2px;">
                                &rAarr; &nbsp; Inventaris &nbsp; &lAarr;
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 border-right bg-info">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $pemInventaris }}</h5>
                                        <span class="description-text">ALL</span>
                                    </div>
                                </div>

                                <div class="col-sm-3 border-right bg-success">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $acc_pemInventaris }}</h5>
                                        <span class="description-text">APPROVED</span>
                                    </div>
                                </div>

                                <div class="col-sm-3 border-right bg-warning">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $null_pemInventaris }}</h5>
                                        <span class="description-text">PROCESS</span>
                                    </div>
                                </div>

                                <div class="col-sm-3 bg-danger">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $rej_pemInventaris }}</h5>
                                        <span class="description-text">REJECTED</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabungan -->
                <div class="col-md-6">
                    <div class="card card-widget">
                        <div class="user-header bg-primary">
                            <h4 style="text-align: center; margin-top: 6px; letter-spacing: 2px;">
                                &rAarr; &nbsp; Tabungan &nbsp; &lAarr;
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 border-right bg-info">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $pemTabungan }}</h5>
                                        <span class="description-text">ALL</span>
                                    </div>
                                </div>
                                <div class="col-sm-3 border-right bg-success">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $acc_pemTabungan }}</h5>
                                        <span class="description-text">APPROVED</span>
                                    </div>
                                </div>
                                <div class="col-sm-3 border-right bg-warning">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $null_pemTabungan }}</h5>
                                        <span class="description-text">PROCESS</span>
                                    </div>
                                </div>
                                <div class="col-sm-3 bg-danger">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $rej_pemTabungan }}</h5>
                                        <span class="description-text">REJECTED</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- depo -->
                <div class="col-md-6">
                    <div class="card card-widget">
                        <div class="user-header bg-primary">
                            <h4 style="text-align: center; margin-top: 6px; letter-spacing: 2px;">
                                &rAarr; &nbsp; Transaksi Deposito &nbsp; &lAarr;
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 border-right bg-info">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $pemDeposito }}</h5>
                                        <span class="description-text">ALL</span>
                                    </div>
                                </div>
                                <div class="col-sm-3 border-right bg-success">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $acc_pemDeposito }}</h5>
                                        <span class="description-text">APPROVED</span>
                                    </div>
                                </div>
                                <div class="col-sm-3 border-right bg-warning">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $null_pemDeposito }}</h5>
                                        <span class="description-text">NEED ACTION</span>
                                    </div>
                                </div>
                                <div class="col-sm-3 bg-danger">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $rej_pemDeposito }}</h5>
                                        <span class="description-text">REJECTED</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>




            <hr>

            <div class="row">
                <h4 style="letter-spacing: 2px; word-spacing: 8px">&empty; PERUBAHAN TRANSAKSI</h4>
                <!--PENGAJUAN MBS -->
                <div class="col-md-6">
                    <div class="card card-widget">
                        <div class="user-header bg-secondary">
                            <h4 style="text-align: center; margin-top: 6px;">
                                &rAarr; &nbsp; Master CIF &nbsp; &lAarr;
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 border-right bg-info">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $perCif }}</h5>
                                        <span class="description-text">ALL</span>
                                    </div>
                                </div>

                                <div class="col-sm-3 border-right bg-success">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $acc_perCif }}</h5>
                                        <span class="description-text">APPROVED</span>
                                    </div>
                                </div>

                                <div class="col-sm-3 border-right bg-warning">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $null_perCif }}</h5>
                                        <span class="description-text">PROCESS</span>
                                    </div>
                                </div>

                                <div class="col-sm-3 bg-danger">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $rej_perCif }}</h5>
                                        <span class="description-text">REJECTED</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <!-- RESET MBS -->
                <div class="col-md-6">
                    <div class="card card-widget">
                        <div class="user-header bg-primary">
                            <h4 style="text-align: center; margin-top: 6px;">
                                &rAarr; &nbsp; Master Kredit &nbsp; &lAarr;
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 border-right bg-info">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $perKredit }}</h5>
                                        <span class="description-text">ALL</span>
                                    </div>
                                </div>

                                <div class="col-sm-3 border-right bg-success">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $acc_perKredit }}</h5>
                                        <span class="description-text">APPROVED</span>
                                    </div>
                                </div>

                                <div class="col-sm-3 border-right bg-warning">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $null_perKredit }}</h5>
                                        <span class="description-text">PROCESS</span>
                                    </div>
                                </div>

                                <div class="col-sm-3 bg-danger">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $rej_perKredit }}</h5>
                                        <span class="description-text">REJECTED</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- RESET MBS -->
                <div class="col-md-6">
                    <div class="card card-widget">
                        <div class="user-header bg-secondary">
                            <h4 style="text-align: center; margin-top: 6px;">
                                &rAarr; &nbsp; Master Deposito &nbsp; &lAarr;
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 border-right bg-info">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $perDeposito }}</h5>
                                        <span class="description-text">ALL</span>
                                    </div>
                                </div>

                                <div class="col-sm-3 border-right bg-success">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $acc_perDeposito }}</h5>
                                        <span class="description-text">APPROVED</span>
                                    </div>
                                </div>

                                <div class="col-sm-3 border-right bg-warning">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $null_perDeposito }}</h5>
                                        <span class="description-text">PROCESS</span>
                                    </div>
                                </div>

                                <div class="col-sm-3 bg-danger">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $rej_perDeposito }}</h5>
                                        <span class="description-text">REJECTED</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <hr>
            <div class="row">
                <h4 style="letter-spacing: 2px; word-spacing: 8px">&empty; Lainnya</h4>
                <!--PENGAJUAN MBS -->
                <div class="col-md-6">
                    <div class="card card-widget">
                        <div class="user-header bg-secondary">
                            <h4 style="text-align: center; margin-top: 6px;">
                                &rAarr; &nbsp; Perbaikan/Kendala &nbsp; &lAarr;
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 border-right bg-info">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $bantuanTSI }}</h5>
                                        <span class="description-text">ALL</span>
                                    </div>
                                </div>

                                <div class="col-sm-3 border-right bg-success">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $acc_bantuanTSI }}</h5>
                                        <span class="description-text">APPROVED</span>
                                    </div>
                                </div>

                                <div class="col-sm-3 border-right bg-warning">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $null_bantuanTSI }}</h5>
                                        <span class="description-text">NEED ACTION</span>
                                    </div>
                                </div>

                                <div class="col-sm-3 bg-danger">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $rej_bantuanTSI }}</h5>
                                        <span class="description-text">Not Finished</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>





            {{-- Colapse Caution --}}
            <div class="col-md-5">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">PENTING !!!</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        Pastikan Anda sudah membaca JUKNIS APLIKASI KREDIT!
                        Atau Anda bisa lihat dibawah ini. <br>
                        <hr>
                        <button onclick="location.href='{{ asset('Juknis/Juknis.pdf') }}';" target="_blank">Juknis
                            Aplikasi Kredit</button>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>


            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
