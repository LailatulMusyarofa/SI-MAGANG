<?php

use App\Http\Controllers\AdministrasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CetakDashboardController;
use App\Http\Controllers\EditAdministrasiController;
use App\Models\EditAdministrasi;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\GrafikStatusController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CardStatikController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\MagangChartController;
use App\Http\Controllers\ProposalMasukController;
use App\Http\Controllers\UserPermintaanMagangController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\RingkasanController;
use App\Http\Controllers\NotifikasiController;





Route::middleware('guest')->group(function () {
    Route::get('/', function () { return view('pages.auth.login'); })->name('login');

    Route::get('/register', function () {
        return view('pages.auth.registrasi');
    })->name('register');


    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
        Route::post('register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');

    });
});


Route::middleware(['auth', 'check-access', 'authorize-access'])->group(function () {
    Route::get('/beranda', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('menu/get-data-all', [App\Http\Controllers\MenuController::class, 'getDataAll'])->name('menu.get-data-all');
    Route::resource('menu', App\Http\Controllers\MenuController::class);
    
    Route::get('test', [App\Http\Controllers\UserExtrasController::class, 'index'])->name('test');
    


    
    Route::get('Lembaga Pendidikan', [App\Http\Controllers\MasterSklhController::class, 'index'])->name('master_sklh');

    Route::get('lengkapi-data', [App\Http\Controllers\UserExtrasController::class, 'index'])->name('lengkapi_data');
    Route::get('detail-data', [App\Http\Controllers\UserExtrasController::class, 'show'])->name('detail_data');
    Route::get('edit-data', [App\Http\Controllers\UserExtrasController::class, 'edit'])->name('edit_data');
    
    //Permohonan
    Route::get('buat-permohonan', [App\Http\Controllers\UserExtrasController::class, 'index'])->name('buat_permohonan');

    
});

Route::get('master_sklh/{id}/edit', [App\Http\Controllers\MasterSklhController::class, 'edit'])->name('master_sklh.edit');
Route::post('/master_sklh/{id}/verification', [App\Http\Controllers\MasterSklhController::class, 'verification'])
    ->name('master_sklh.verification');
Route::delete('/master_sklh/{id}/delete', [App\Http\Controllers\MasterSklhController::class, 'delete'])
    ->name('master_sklh.delete');
Route::post('/master_sklh/{id}/suspend', [App\Http\Controllers\MasterSklhController::class, 'suspend'])
    ->name('master_sklh.suspend');
Route::post('/master_sklh/{id}/unlock', [App\Http\Controllers\MasterSklhController::class, 'unlock'])
    ->name('master_sklh.unlock');


Route::get('master_sklh/{id}/edit', [App\Http\Controllers\MasterSklhController::class, 'edit'])->name('master_sklh.edit');
Route::post('/editmastersklh', [App\Http\Controllers\MasterSklhController::class, 'update'])->name('master_sklh.update');
Route::post('/master_sklh/reset-password', [App\Http\Controllers\MasterSklhController::class, 'resetPassword'])->name('master_sklh.reset_password');


Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');

Route::get('user_extras', [App\Http\Controllers\UserExtrasController::class, 'index'])->name('user_extras');
Route::post('user_extras', [App\Http\Controllers\UserExtrasController::class, 'store'])->name('user_extras.store');

Route::get('user_extras/viewsklh', [App\Http\Controllers\UserExtrasController::class, 'show']) ->name('user_extras.viewsklh');

Route::post('/editsklh', [App\Http\Controllers\UserExtrasController::class, 'updatesklh'])->name('user_extras.updatesklh');

    
Route::post('/user-extras/simpan-proposal', [App\Http\Controllers\UserExtrasController::class, 'simpanProposalMagang'])->name('user_extras.simpan_proposal');


Route::get('/user/permohonan', [App\Http\Controllers\UserExtrasController::class, 'daftarPermohonanKeluar'])->name('user.daftar_permohonan');
// Route::get('/user/permohonan/{id}', [App\Http\Controllers\UserExtrasController::class, 'lihatPermohonan'])->name('user_extras.lihat_permohonan');

Route::post('/user/permohonan/{id}/update-status', [App\Http\Controllers\UserExtrasController::class, 'updatestatuspermohonan'])->name('user.updatestatuspermohonan');

//Data Peserta Magang
Route::get('addpesertamagang/{id}', [App\Http\Controllers\UserExtrasController::class, 'addPesertaMagang'])->name('user.addpesertamagang');
Route::post('simpanpesertamagang/{id}', [App\Http\Controllers\UserExtrasController::class, 'simpanpesertamagang'])->name('user.simpanpeserta');
Route::delete('/user/hapus-peserta-magang/{id}', [App\Http\Controllers\UserExtrasController::class, 'hapuspesertamagang'])->name('user.hapuspesertamagang');
Route::get('editpesertamagang/{id}', [App\Http\Controllers\UserExtrasController::class, 'editPesertaMagang'])->name('user.editpesertamagang');
Route::put('updatepesertamagang/{id}', [App\Http\Controllers\UserExtrasController::class, 'updatePesertaMagang'])->name('user.updatepesertamagang');
Route::get('/detail-peserta/{id}', [App\Http\Controllers\MasterPsrtController::class, 'view'])->name('masterpsrt.view');


Route::get('/permohonan/{id}/detail', [App\Http\Controllers\UserExtrasController::class, 'viewpermohonankeluar'])->name('user.viewpermohonankeluar');
Route::delete('/user/permohonan/{id}', [App\Http\Controllers\UserExtrasController::class, 'hapusPermohonan'])->name('user.hapus_permohonan');
Route::get('/user/permohonan/{id}/edit', [App\Http\Controllers\UserExtrasController::class, 'editpermohonan'])->name('user.editpermohonankeluar');
Route::put('/user/permohonan/{id}', [App\Http\Controllers\UserExtrasController::class, 'updatepermohonan'])->name('user.updatepermohonankeluar');
Route::get('/user_extras/viewpeserta/{id}', [App\Http\Controllers\UserExtrasController::class, 'viewPesertaMasuk'])->name('user_extras.viewpesertamasuk');


Route::get('/proposal-masuk', [App\Http\Controllers\ProposalMasukController::class, 'index'])->name('proposal_masuk');
Route::get('/proposal/{id}/balas', [App\Http\Controllers\ProposalMasukController::class, 'balasPermohonan'])->name('proposal_masuk.balaspermohonan');
Route::post('/proposal/{id}/tanggapiproposal', [App\Http\Controllers\ProposalMasukController::class, 'tanggapiPermohonan'])->name('proposal_masuk.tanggapiproposal');
Route::get('/proposal-masuk/cetak-pdf/{id}', [App\Http\Controllers\ProposalMasukController::class, 'cetakpdfpermohonanmasuk'])->name('proposal_masuk.cetakpdfpermohonanmasuk');
Route::delete('/proposal-masuk/{id}', [App\Http\Controllers\ProposalMasukController::class, 'destroy'])->name('proposal_masuk.hapus');
Route::get('/proposal_masuk/{id}/viewpeserta', [App\Http\Controllers\ProposalMasukController::class, 'viewPeserta'])->name('proposal_masuk.viewpeserta');



Route::get('/proposal-keluar', [App\Http\Controllers\ProposalKeluarController::class, 'index'])->name('proposal_keluar');
Route::get('/proposal_keluar/{id}/balas', [App\Http\Controllers\ProposalKeluarController::class, 'balasPermohonanKeluar'])->name('proposal_keluar.balaspermohonan');
Route::post('/proposal_keluar/{id}/tanggapiproposal', [App\Http\Controllers\ProposalKeluarController::class, 'tanggapiPermohonanKeluar'])->name('proposal_keluar.tanggapiproposal');
Route::get('/proposal_keluar/{id}/cetakpdf', [App\Http\Controllers\ProposalKeluarController::class, 'cetakpdfpermohonankeluar'])->name('proposal_keluar.cetakpdfpermohonankeluar');
Route::get('/proposal_keluar/{id}/viewpeserta', [App\Http\Controllers\ProposalKeluarController::class, 'viewPeserta'])->name('proposal_keluar.viewpeserta');


//Daftar Diterima
Route::get('/permohonan-masuk', [App\Http\Controllers\UserExtrasController::class, 'daftarPermohonanMasuk'])->name('user.daftar_permohonanmasuk');
Route::get('/permohonan-masuk/{id}', [App\Http\Controllers\UserExtrasController::class, 'detailPermohonanMasuk'])->name('user.detail_permohonanmasuk');

Route::get('master-petugas', [App\Http\Controllers\MasterPetugasController::class, 'daftar'])->name('master_petugas');
Route::get('master-petugas/{id}/edit', [App\Http\Controllers\MasterPetugasController::class, 'edit'])->name('master_petugas.edit');
Route::put('master-petugas/{id}', [App\Http\Controllers\MasterPetugasController::class, 'update'])->name('master_petugas.update');

//Nota Dinas
Route::get('/nota-dinas', [App\Http\Controllers\NotaDinasController::class, 'daftar'])->name('nota_dinas.daftar');
Route::get('/nota-dinas/proposal-selector', [App\Http\Controllers\NotaDinasController::class, 'proposalselector'])->name('nota_dinas.proposalselector');
Route::get('/nota-dinas/add/{id}', [App\Http\Controllers\NotaDinasController::class, 'add'])->name('nota_dinas.add');
Route::post('/nota-dinas/save/{id}', [App\Http\Controllers\NotaDinasController::class, 'save'])->name('nota_dinas.save');
Route::get('/nota_dinas/edit/{id}', [App\Http\Controllers\NotaDinasController::class, 'edit'])->name('nota_dinas.edit');
Route::put('/nota_dinas/{id}', [App\Http\Controllers\NotaDinasController::class, 'update'])->name('nota_dinas.update');
Route::get('/nota_dinas/additem/{id}', [App\Http\Controllers\NotaDinasController::class, 'addItem'])->name('nota_dinas.additem');
Route::post('/nota_dinas/storeitem/{id}', [App\Http\Controllers\NotaDinasController::class, 'storeItem'])->name('nota_dinas.storeitem');
Route::get('/nota_dinas/cetakpdf/{id}', [App\Http\Controllers\NotaDinasController::class, 'cetakPdf'])->name('nota_dinas.cetak_pdf');
Route::get('/nota-dinas/viewpeserta/{id}', [App\Http\Controllers\NotaDinasController::class, 'viewPeserta'])->name('nota_dinas.viewpeserta');

//Daftar Laporan
Route::get('/laporan-magang', [App\Http\Controllers\UserExtrasController::class, 'daftarLaporanMagang'])->name('user.daftar_laporanmagang');
Route::get('/user/showuploadlaporan/{id}', [App\Http\Controllers\UserExtrasController::class, 'showUploadLaporan'])->name('user.showuploadlaporan');
Route::post('/user/uploadlaporan/{id}', [App\Http\Controllers\UserExtrasController::class, 'uploadLaporan'])->name('user.uploadlaporan');
Route::get('/user/preview-laporan/{id}', [App\Http\Controllers\UserExtrasController::class, 'previewLaporan'])->name('user.previewlaporan');


//Laporan & Sertifikat
Route::get('/proposal-final', [App\Http\Controllers\ProposalFinalController::class, 'daftar'])->name('proposal_final.daftar');
Route::get('/proposal-final/tanggapi/{id}', [App\Http\Controllers\ProposalFinalController::class, 'tanggapiProposal'])->name('proposal_final.tanggapi');
Route::get('/proposal-final/penilaian/{id}', [App\Http\Controllers\ProposalFinalController::class, 'penilaian'])->name('proposal_final.penilaian');
Route::post('/proposal-final/penilaian/{id}', [App\Http\Controllers\ProposalFinalController::class, 'simpanPenilaian'])->name('proposal_final.penilaian.simpan');
Route::get('/proposal-final/upload-penilaian/{id}', [App\Http\Controllers\ProposalFinalController::class, 'uploadPenilaianForm'])->name('proposal_final.uploadpenilaian');
Route::post('/proposal-final/upload-penilaian/{id}', [App\Http\Controllers\ProposalFinalController::class, 'simpanUploadPenilaian'])->name('proposal_final.uploadpenilaian.simpan');
Route::get('/proposal-final/cetak-penilaian/{id}', [App\Http\Controllers\ProposalFinalController::class, 'cetakPenilaian'])->name('proposal_final.cetakpenilaian');
Route::get('/proposal-final/upload-sertifikat/{id}', [App\Http\Controllers\ProposalFinalController::class, 'uploadSertifikatForm'])->name('proposal_final.uploadsertifikat');
Route::post('/proposal-final/upload-sertifikat/{id}', [App\Http\Controllers\ProposalFinalController::class, 'simpanUploadSertifikat'])->name('proposal_final.uploadsertifikat.simpan');

//personalisasi akun
Route::get('/user/setting', [App\Http\Controllers\UserController::class, 'setting'])->name('user.setting');
Route::put('/user/setting', [App\Http\Controllers\UserController::class, 'updateSetting'])->name('user.setting.update');
Route::get('/user/daftar', [App\Http\Controllers\UserController::class, 'daftar'])->name('user.daftar');
Route::get('/user/create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');  
Route::post('/user', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
Route::get('/user/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('user.show');   
Route::get('/user/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit'); 
Route::put('/user/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
Route::delete('/user/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.delete');

// Halaman tampilkan form input email lupa password
Route::get('password/reset', function() {
    return view('pages.auth.email');
})->name('password.request');

// Kirim email reset password
Route::post('password/email', function (Illuminate\Http\Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->name('password.email');

// Form reset password dari link yang dikirim via email
Route::get('password/reset/{token}', function ($token) {
    return view('pages.auth.reset', ['token' => $token, 'email' => request()->email]);
})->name('password.reset');

// Proses reset password
Route::post('password/reset', function (Illuminate\Http\Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password)
            ])->save();
        }
    );

    return $status == Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [($status)]]);
})->name('password.update');


// daftar administrator
Route::get('/master_administrasi', [AdministrasiController::class, 'index'])->name('master_administrasi');
Route::get('/master_administrasi/{id}/view', [AdministrasiController::class, 'view'])->name('master_administrasi.view');
Route::put('/master_administrasi/{id}', [AdministrasiController::class, 'update'])->name('master_administrasi.update');
Route::delete('/master_administrasi/{id}', [AdministrasiController::class, 'destroy'])->name('master_administrasi.destroy');
Route::post('/master_administrasi', [AdministrasiController::class, 'store'])->name('master_administrasi.store');
Route::get('/master_administrasi/create', [AdministrasiController::class, 'create'])->name('master_administrasi.create');

// CardStatikController
Route::get('/dashboard/card-json', [CardStatikController::class, 'chartData']);

// PendaftaranController
Route::get('/grafik-pendaftaran/{tahun}', [PendaftaranController::class, 'grafik']);
Route::get('/pendaftaran', [PendaftaranController::class, 'index']);

// MagangChartController
Route::get('/dashboard/magang', [MagangChartController::class, 'index']);
Route::get('/dashboard/magang/chart-data', [MagangChartController::class, 'chartData']);


// Logout route
Route::get('/keluar', function () {
    Auth::logout();
    return redirect('/'); 
})->name('master_keluar');

// ini json statusAdministrasi
Route::get('/statusAdministrasi', function () {
    $path = resource_path('data/statusAdministrasi.json');
    if (!File::exists($path)) {
        return response()->json(['error' => 'File not found'], 404);
    }
    $data = File::get($path);
    return response($data, 200)->header('Content-Type', 'application/json');
});


// ini grafik administrasi peserta
Route::get('/chart-data', [GrafikStatusController::class, 'chartData'])->name('chart.data');

// // ini data ringkasan
// Route::get('/beranda', [RingkasanController::class, 'ringkasan'])->name('home');

// // ini notifikasi 
// Route::get('/beranda', [NotifikasiController::class, 'index'])->name('home');
Route::get('/beranda/print', [CetakDashboardController::class, 'print'])->name('pdf.cetak');
