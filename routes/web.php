<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\{
    EmployeeController,
    LoginController,
    UserController,
    HelperController,
    RegisterController,
    HomeController,
    LainnyaController,
    LogActController,
    LogActivityController,
    LogTrackingController
};
use App\Http\Controllers\Debitur\DebiturController;
use App\Http\Controllers\KKPK\KkpkController;
use App\Http\Controllers\LKHP\{LkhpController, LkhpFinalController, LkhpOpsController, LkhpRekapController, TemuanBerulangController};
use App\Http\Controllers\RiskEvent\RiskEventController;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('login.login');
});

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('view:cache');
    $exitCode = Artisan::call('optimize:clear');
    $exitCode = Artisan::call('logs:clear');
    return 'DONE'; //Return anything
});

// Login
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'postlogin']);
Route::get('/refereshcapcha', [HelperController::class, 'refereshCaptcha']);

// Lupa Password
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

// Register
// Route::get('/register', [RegisterController::class, 'index'])->middleware('cektsi');
Auth::routes(['verify' => true]);


Auth::routes();

Route::group(['middleware' => ['permission']], function () {

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/create', [HomeController::class, 'create']);
        Route::get('/profile', [UserController::class, 'profil']);
        Route::post('/profile/upload', [UserController::class, 'upload']);


        // Risk Event
        Route::resource('risk-event', RiskEventController::class)->parameters(['risk-event' => 'riskEvent']);
        Route::any('/risk-event-delete/{id}', [RiskEventController::class, 'destroy']); // Hapus Data Mode Simple
        Route::post('/risk-event-manual', [RiskEventController::class, 'storeManual']); //store manual

        // Debitur
        Route::resource('debitur', DebiturController::class);
        Route::post('/debitur-manual', [DebiturController::class, 'storeManual']); //store manual
        Route::any('/debitur/noa/all', [DebiturController::class, 'TotalAll']);

        // KKPK
        Route::resource('data-kkpk', KkpkController::class)->parameters(['data-kkpk' => 'kkpk']);
        Route::get('/get-nasabah/{Id}', [KkpkController::class, 'getNasabah']);
        Route::get('/get-detail-nasabah/{Id}', [KkpkController::class, 'detailNasabah']);
        Route::get('/print-kkpk/{Id}', [KkpkController::class, 'PrintKKPK']);
        // KKO (OTS)
        Route::any('/add-kko/{Id}', [KkpkController::class, 'AddKKO']);
        Route::any('/edit-kko/{Id}/edit', [KkpkController::class, 'EditKKO']);
        Route::patch('/edit-kko/{Id}', [KkpkController::class, 'UpdateKKO']);
        Route::get('/show-kko/{Id}', [KkpkController::class, 'ShowKKO']);
        Route::get('/print-kko/{Id}', [KkpkController::class, 'PrintKKO']);

        // LKHP
        Route::resource('data-lkhp', LkhpController::class)->parameters(['data-lkhp' => 'lkhp']);
        Route::get('/get-kkpk/{Id}', [LkhpController::class, 'getKKPK']);
        Route::get('/get-detail-kkpk/{Id}', [LkhpController::class, 'getDetailKKPK']);
        Route::get('/show-detail-kredit/{Id}', [LkhpController::class, 'showDetail']);
        // tambah dari edit
        Route::get('data-lkhp-tambah-kkpk/{Id}', [LkhpController::class, 'CreateLKHP']);
        Route::post('/data-lkhp-tambah-kkpk/{Id}', [LkhpController::class, 'StoreLkhp'])->name('lkhp-kkpk-store');
        // edit dari edit
        Route::get('/data-lkhp-edit/{Id}', [LkhpController::class, 'EditLkhp'])->name('lkhp-edit');
        Route::patch('/data-lkhp-edit/{Id}', [LkhpController::class, 'UpdateLkhp'])->name('lkhp-update');
        // hapus dari edit
        Route::any('data-lkhp-hapus/{Id}/{lkhp}', [LkhpController::class, 'HapusLkhp']);

        // LKHP OPS
        Route::resource('data-lkhp-ops', LkhpOpsController::class)->parameters(['data-lkhp-ops' => 'lkhp']);
        Route::get('/lkhp-ops/{Id}/show', [LkhpOpsController::class, 'show']);
        Route::get('/lkhp-ops-detail/{Id}', [LkhpOpsController::class, 'showDetail']);

        // LKHP Final
        Route::resource('lkhp-final', LkhpFinalController::class)->parameters(['lkhp-final' => 'lkhpFinal']);
        Route::get('/show-detail-final-kredit/{Id}', [LkhpFinalController::class, 'showDetail']);
        Route::any('lkhp-final-ops/{Id}/show', [LkhpFinalController::class, 'showOPS']);
        Route::get('/show-detail-final-ops/{Id}', [LkhpFinalController::class, 'showDetailOPS']);
        Route::get('/print-lkhp-as-pdf/{Id}', [LkhpFinalController::class, 'printLkhpAsPDF']);
        Route::get('/print-lkhp-as-word/{Id}', [LkhpFinalController::class, 'printLkhpAsWord']);
        // getlkhp bayangan
        Route::get('/get-lkhp-bayangan', [LkhpFinalController::class, 'getLkhp']);
        // input data pendukung
        Route::any('/lkhp-input/{Id}', [LkhpFinalController::class, 'InputDataPendukung']);
        Route::any('/lkhp-status/{Id}', [LkhpFinalController::class, 'StatusLkhp']);
        Route::any('/lkhp-status/{Id}/{Tgl}', [LkhpFinalController::class, 'StatusLkhpIA']);


        // LKHP Rekap
        Route::resource('potensi-loss-konsolidasi', LkhpRekapController::class)->parameters(['potensi-loss-konsolidasi' => 'Id']);
        Route::any('lkhp-rekap-all', [LkhpRekapController::class, 'TotalRekap']);

        // Potensi kerugian
        // Route::resource('potensi-kerugian', LkhpRekapController::class)->parameters(['potensi-kerugian' => 'Id']);
        Route::any('potensi-kerugian', [LkhpRekapController::class, 'PotensiLossIndex']);
        Route::any('potensi-kerugian/{min}/{max}/{id_cabang}/{objek_pemeriksaan}', [LkhpRekapController::class, 'PotensiLossShow']);
        // cetak
        Route::any('potensi-kerugian-cetak/{min}/{max}/{id_cabang}/{objek_pemeriksaan}', [LkhpRekapController::class, 'PotensiLossPrint']);


        // Temuan Berulang
        Route::resource('temuan-berulang', TemuanBerulangController::class)->parameters(['temuan-berulang' => 'Id']);

        // Lainnya
        Route::resource('lainnya', LainnyaController::class);

        // Log Activity
        Route::any('log-act', [LogActController::class, 'index'])->name('activity');
    });

    // example
    Route::post('/import-excel', [EmployeeController::class, 'store']);
});
