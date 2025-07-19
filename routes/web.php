<?php

use App\Http\Controllers\ApprovalSettingController;
use App\Http\Controllers\BirthCertificateController;
use App\Http\Controllers\BusinessCertificateController;
use App\Http\Controllers\CertificateCategoryController;
use App\Http\Controllers\CoverLetterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\DomicileCertificateController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FamilyCardController;
use App\Http\Controllers\InabilityCertificateController;
use App\Http\Controllers\MarriageCertificateController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\RegencyController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnmarriedCertificateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VillageController;
use App\Http\Controllers\WorkController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;





Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/positions', PositionController::class);
    Route::resource('/ranks', RankController::class);
    Route::resource('/approvalSettings', ApprovalSettingController::class);
    Route::resource('/works', WorkController::class);
    Route::resource('/certificate-categories', CertificateCategoryController::class);
    Route::resource('/educations', EducationController::class);
    Route::resource('/provinces', ProvinceController::class);
    Route::resource('/regencies', RegencyController::class);
    Route::resource('/districts', DistrictController::class);
    Route::resource('/villages', VillageController::class);
    Route::resource('/employees', EmployeeController::class);
    Route::resource('/family-card', FamilyCardController::class);
    Route::resource('/residents', ResidentController::class);
    Route::resource('/cover-letters', CoverLetterController::class);


    Route::resource('/birthCertificates', BirthCertificateController::class);
    Route::resource('/businessCertificates', BusinessCertificateController::class);
    Route::resource('/marriage-certificates', MarriageCertificateController::class);
    Route::resource('/domicile-certificates', DomicileCertificateController::class);
    Route::resource('unmarried-certificates', UnmarriedCertificateController::class);
    Route::resource('inability-certificates', InabilityCertificateController::class);
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/certificate/{certificate}', [NotificationController::class, 'certificate'])->name('notifications.certificate');
    Route::put('/notification/certificate/{id}', [NotificationController::class, 'update'])->name('notifications.update');






    Route::resource('/users', UserController::class);
    Route::resource('/roles', RoleController::class);
    Route::post('/roles/role/{role_id}/permission/{permission_id}', [RoleController::class, 'updateRolePermission'])->name('updateRolePermission');
    Route::resource('/permissions', PermissionController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
