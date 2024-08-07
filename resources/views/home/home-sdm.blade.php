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

                                <p>Perlu Tindakan</p>
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

                                <p>Perlu Tindakan</p>
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

                                <p>Perlu Tindakan</p>
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

                                <p>Perlu Tindakan</p>
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
