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
                                        <span class="description-text">NEED ACTION</span>
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
                                        <span class="description-text">NEED ACTION</span>
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
                                        <span class="description-text">NEED ACTION</span>
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
                                        <span class="description-text">NEED ACTION</span>
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
                                        <span class="description-text">NEED ACTION</span>
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
                                        <span class="description-text">NEED ACTION</span>
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
                                        <span class="description-text">NEED ACTION</span>
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
                                        <span class="description-text">NEED ACTION</span>
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
