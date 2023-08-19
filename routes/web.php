<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\Autentikasi\LoginController;
use App\Http\Controllers\Ormawa\GantiPasswordController;
use App\Http\Controllers\Ormawa\IzinKegiatanController;
use App\Http\Controllers\Ormawa\LaporanKegiatanController;
use App\Http\Controllers\Ormawa\ProfilSayaController;
use App\Http\Controllers\Public\LupaPasswordController;
use App\Http\Controllers\SuperAdmin\GantiPasswordController as SuperAdminGantiPasswordController;
use App\Http\Controllers\SuperAdmin\IzinKegiatanController as SuperAdminIzinKegiatanController;
use App\Http\Controllers\SuperAdmin\LaporanKegiatanController as SuperAdminLaporanKegiatanController;
use App\Http\Controllers\SuperAdmin\PenggunaController;
use App\Http\Controllers\SuperAdmin\ProfilSayaController as SuperAdminProfilSayaController;
use App\Http\Controllers\Wadir\GantiPasswordController as WadirGantiPasswordController;
use App\Http\Controllers\Wadir\IzinKegiatanController as WadirIzinKegiatanController;
use App\Http\Controllers\Wadir\LaporanKegiatanController as WadirLaporanKegiatanController;
use App\Http\Controllers\Wadir\ProfilSayaController as WadirProfilSayaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get("/{token}/reset_password", [LupaPasswordController::class, "konfirmasi"]);
Route::put("/lupa_password/{token}", [LupaPasswordController::class, "update"]);
Route::resource("lupa_password", LupaPasswordController::class);

Route::group(["middleware" => ["guest"]], function() {
    Route::get("/", [LoginController::class, "login"]);
    Route::prefix("login")->group(function() {
        Route::get("/", [LoginController::class, "login"]);
        Route::post("/", [LoginController::class, "post_login"]);
    });
    
});

Route::group(["middleware" => ["is_autentikasi"]], function() {
    Route::prefix("super_admin")->group(function() {
        Route::get("/dashboard", [AppController::class, "dashboard_admin"]);

        Route::prefix("izin_kegiatan")->group(function() {
            Route::get("/", [SuperAdminIzinKegiatanController::class, "index"]);
            Route::get("/show/{id}", [SuperAdminIzinKegiatanController::class, "show"]);
            Route::put("/update/{id}", [SuperAdminIzinKegiatanController::class, "update"]);
            Route::get("/download/{id}", [SuperAdminIzinKegiatanController::class, "laporan"]);
            Route::get("/balasan/{id}", [SuperAdminIzinKegiatanController::class, "balasan"]);
        });
        
        Route::prefix("laporan_kegiatan")->group(function() {
            Route::get("/", [SuperAdminLaporanKegiatanController::class, "index"]);
            Route::get("/show/{id}", [SuperAdminLaporanKegiatanController::class, "show"]);
            Route::get("/lpj/{id}", [SuperAdminLaporanKegiatanController::class, "lpj"]);
        });

        Route::prefix("pengguna")->group(function() {
            Route::get("/", [PenggunaController::class, "index"]);
            Route::get("/create", [PenggunaController::class, "create"]);
            Route::post("/store", [PenggunaController::class, "store"]);
            Route::get("/edit/{id}", [PenggunaController::class, "edit"]);
            Route::put("/update/{id}", [PenggunaController::class, "update"]);
            Route::delete("/destroy/{id}", [PenggunaController::class, "destroy"]);
            Route::put("/aktifkan/{id}", [PenggunaController::class, "aktifkan"]);
            Route::put("/non_aktifkan/{id}", [PenggunaController::class, "non_aktifkan"]);
        });

        Route::prefix("profil_saya")->group(function() {
            Route::get("/", [SuperAdminProfilSayaController::class, "index"]);
            Route::put("/update/{id}", [SuperAdminProfilSayaController::class, "update"]);
        });

        Route::prefix("ganti_password")->group(function() {
            Route::get("/", [SuperAdminGantiPasswordController::class, "index"]);
            Route::put("/update/{id}", [SuperAdminGantiPasswordController::class, "update"]);
        });
    });
    
    Route::prefix("wadir")->group(function() {
        Route::get("/dashboard", [AppController::class, "dashboard_wadir"]);

        Route::prefix("izin_kegiatan")->group(function() {
            Route::get("/", [WadirIzinKegiatanController::class, "index"]);
            Route::get("/show/{id}", [WadirIzinKegiatanController::class, "show"]);
            Route::put("/{id}", [WadirIzinKegiatanController::class, "update"]);
            Route::get("/download/{id}", [WadirIzinKegiatanController::class, "laporan"]);
            Route::get("/balasan/{id}", [WadirIzinKegiatanController::class, "balasan"]);
        });

        Route::prefix("laporan_kegiatan")->group(function() {
            Route::get("/", [WadirLaporanKegiatanController::class, "index"]);
            Route::get("/show/{id}", [WadirLaporanKegiatanController::class, "show"]);
            Route::get("/lpj/{id}", [WadirLaporanKegiatanController::class, "lpj"]);
        });

        Route::prefix("profil_saya")->group(function() {
            Route::get("/", [WadirProfilSayaController::class, "index"]);
            Route::put("/update/{id}", [WadirProfilSayaController::class, "update"]);
        });

        Route::prefix("ganti_password")->group(function() {
            Route::get("/", [WadirGantiPasswordController::class, "index"]);
            Route::put("/update/{id}", [WadirGantiPasswordController::class, "update"]);
        });
    });
    
    Route::prefix("ormawa")->group(function() {
        Route::get("/dashboard", [AppController::class, "dashboard_ormawa"]);

        Route::prefix("izin_kegiatan")->group(function() {
            Route::get("/", [IzinKegiatanController::class, "index"]);
            Route::post("/", [IzinKegiatanController::class, "post"]);
            Route::get("/create", [IzinKegiatanController::class, "create"]);
            Route::post("/store", [IzinKegiatanController::class, "store"]);
            Route::get("/edit/{id}", [IzinKegiatanController::class, "edit"]);
            Route::put("/update/{id}", [IzinKegiatanController::class, "update"]);
            Route::get("/show/{id}", [IzinKegiatanController::class, "show"]);
            Route::get("/ulang/{id}", [IzinKegiatanController::class, "ulang"]);
            Route::put("/ajukan/{id}", [IzinKegiatanController::class, "ajukan"]);
            Route::delete("/destroy/{id}", [IzinKegiatanController::class, "destroy"]);
            Route::get("/download/{id}", [IzinKegiatanController::class, "laporan"]);
            Route::get("/balasan/{id}", [IzinKegiatanController::class, "balasan"]);
            Route::get("/{bulan}/{tahun}", [IzinKegiatanController::class, "filter"]);
        });

        Route::prefix("laporan_kegiatan")->group(function() {
            Route::get("/", [LaporanKegiatanController::class, "index"]);
            Route::get("/unggah/{id}", [LaporanKegiatanController::class, "create"]);
            Route::get("/show/{id}", [LaporanKegiatanController::class, "show"]);
            Route::put("/update/{id}", [LaporanKegiatanController::class, "update"]);
            Route::get("/laporan/{id}", [LaporanKegiatanController::class, "laporan"]);
            Route::get("/lpj/{id}", [LaporanKegiatanController::class, "lpj"]);
            Route::post("/simpan/{id}", [LaporanKegiatanController::class, "store"]);
            Route::get("/balasan/{id}", [LaporanKegiatanController::class, "balasan"]);
        });

        Route::prefix("profil_saya")->group(function() {
            Route::get("/", [ProfilSayaController::class, "index"]);
            Route::put("/update/{id}", [ProfilSayaController::class, "update"]);
        });

        Route::prefix("ganti_password")->group(function() {
            Route::get("/", [GantiPasswordController::class, "index"]);
            Route::put("/update/{id}", [GantiPasswordController::class, "update"]);
        });

    });
    
    Route::get("/logout", [LoginController::class, "logout"]);
});
