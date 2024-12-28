<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ExcelCSVController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LogController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/logs', [LogController::class, 'index'])->name('logs');


// Authentication Routes
Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::get('/editor-login', [EditorController::class, 'login'])->name('editor-login');
Route::post('/login', [AdminController::class, 'authenticate']);
Route::post('/editor-login', [EditorController::class, 'authenticate']);
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
Route::post('/editor-logout', [AdminController::class, 'editorLogout'])->name('editor-logout');
// Certificate Routes
Route::group(['middleware' => 'auth'], function () {
    Route::post('/certificates-search', [CertificateController::class, 'search'])->name('certificates-search');
    Route::post('/certificates-searchb', [CertificateController::class, 'searchb'])->name('certificates-searchb');

    Route::get('/certificates/{certificate}', [CertificateController::class, 'show'])->name('certificates.show');
    Route::get('/certificates-index', [CertificateController::class, 'index'])->name('certificates-index');
    Route::get('/certificates-create', [CertificateController::class, 'create'])->name('certificates-create');
    Route::post('/certificates-store', [CertificateController::class, 'store'])->name('certificates-store');
    Route::get('/certificates/{id}/qrcode', [CertificateController::class, 'generateQrCode'])->name('certificates.qrcode');
 
Route::get('excel-csv-file', [ExcelCSVController::class, 'index']);
Route::get('export-excel-csv-file/{slug}', [ExcelCSVController::class, 'exportExcelCSV']);

    Route::group(['middleware' => ['role:editor']], function () {
        // Editor-only routes
        Route::get('/editor/index', [EditorController::class, 'index'])->name('editor.index');

    });

    Route::group(['middleware' => ['role:admin']], function () {
        // Admin-only routes
        Route::get('/admin/index', [AdminController::class, 'index'])->name('admin.index');
        Route::post('/change-password', [AdminController::class, 'changePassword'])->name('change-password');
        Route::get('/admin/password/reset', [AdminController::class, 'resetPassword'])->name('admin.password.reset');
        Route::post('/admin/editor/reset-password', [AdminController::class, 'resetEditorPassword'])->name('admin.editor.reset-password');
        Route::get('/certificates/{certificate}/edit', [CertificateController::class, 'edit'])->name('certificates.edit');
        Route::delete('/certificates/{certificate}', [CertificateController::class, 'destroy'])->name('certificates.destroy');
        Route::put('/certificates/{certificate}', [CertificateController::class, 'update'])->name('certificates.update');
   
        Route::get('/admin/editor/password-reset', [AdminController::class, 'showEditorPasswordResetForm'])->name('admin.editor.password.reset');
        Route::post('/admin/editor/password-reset',  [AdminController::class, 'resetEditorPassword'])->name('admin.editor.password.submit');
    });
});
