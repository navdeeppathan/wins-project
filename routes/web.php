<?php

use App\Http\Controllers\Admin\SecurityDepositController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectPgController;

/*
|--------------------------------------------------------------------------
| AUTH PROTECTED ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    /* ===================== Dashboard ===================== */
    Route::get('/', function () {
      return redirect()->route('admin.projects.index');

    })->name('dashboard');

      Route::get('/acceptance', [App\Http\Controllers\Admin\ProjectController::class, 'acceptanceIndex'])
    ->name('projects.acceptance');

     Route::get('/award', [App\Http\Controllers\Admin\ProjectController::class, 'awardIndex'])
    ->name('projects.award');

     Route::get('/agreement', [App\Http\Controllers\Admin\ProjectController::class, 'agreementIndex'])
    ->name('projects.agreement');

    Route::get(
        '/projects/{project}/agreement-date',
        [App\Http\Controllers\Admin\ProjectController::class, 'agreementDateCreate']
    )->name('projects.agreementdate.create');

     Route::get(
        '/emdreturned',
        [App\Http\Controllers\Admin\ProjectController::class, 'returnIndex']
    )->name('projects.returned.index');

     Route::get(
        '/emdforfieted',
        [App\Http\Controllers\Admin\ProjectController::class, 'forfietedIndex']
    )->name('projects.returned.forfieted');


     Route::get(
        '/pgreturned',
        [App\Http\Controllers\Admin\ProjectController::class, 'pgreturnIndex']
    )->name('projects.pgreturned.index');

     Route::get(
        '/securityreturned',
        [App\Http\Controllers\Admin\ProjectController::class, 'securityreturnIndex']
    )->name('projects.securityreturned.index');

    

     Route::get(
        '/pgforfieted',
        [App\Http\Controllers\Admin\ProjectController::class, 'pgforfietedIndex']
    )->name('projects.pgreturned.forfieted');

    Route::get(
        '/securityforfieted',
        [App\Http\Controllers\Admin\ProjectController::class, 'securityforfietedIndex']
    )->name('projects.securityreturned.forfieted');


    Route::get(
        '/returned/{project}',
        [App\Http\Controllers\Admin\ProjectController::class, 'returnedCreate']
    )->name('projects.returned.create');

     Route::get(
        '/pgreturned/{project}',
        [App\Http\Controllers\Admin\ProjectController::class, 'pgreturnedCreate']
    )->name('projects.pgreturned.create');

     Route::get(
        '/securityreturned/{project}',
        [App\Http\Controllers\Admin\ProjectController::class, 'securityreturnedCreate']
    )->name('projects.securityreturned.create');

    Route::get(
        '/forfieted/{project}',
        [App\Http\Controllers\Admin\ProjectController::class, 'forfietedCreate']
    )->name('projects.forfieted.create');

    Route::get(
        '/pgforfieted/{project}',
        [App\Http\Controllers\Admin\ProjectController::class, 'pgforfietedCreate']
    )->name('projects.pgforfieted.create');

     Route::get(
        '/securityforfieted/{project}',
        [App\Http\Controllers\Admin\ProjectController::class, 'securityforfietedCreate']
    )->name('projects.securityforfieted.create');

    /* ===================== PROJECTS (BIDDING) ===================== */
    Route::resource('projects', App\Http\Controllers\Admin\ProjectController::class);



    Route::get(
        '/projects/{project}/pg',
        [ProjectPgController::class, 'create']
    )->name('projects.pg.create');

    Route::post(
        '/projects/{project}/pg',
        [ProjectPgController::class, 'store']
    )->name('projects.pg.store');

  

    Route::post('/projects/update-qualified/{project}', 
    [App\Http\Controllers\Admin\ProjectController::class, 'updateQualified'])
    ->name('projects.updateQualified');

    Route::post('/projects/update-returned/{emdDetail}', 
    [App\Http\Controllers\Admin\ProjectController::class, 'updateReturned'])
    ->name('projects.updateReturned');

    Route::post('/projects/update-pgreturned/{pgDetail}', 
    [App\Http\Controllers\Admin\ProjectController::class, 'updatePgReturned'])
    ->name('projects.updatePgReturned');

     Route::post('/projects/update-securityreturned/{securityDeposit}', 
    [App\Http\Controllers\Admin\ProjectController::class, 'updateSecurityReturned'])
    ->name('projects.updateSecurityReturned');

     Route::post('/projects/update-forfieted/{emdDetail}', 
    [App\Http\Controllers\Admin\ProjectController::class, 'updateforfittedReturned'])
    ->name('projects.updateForfieted');

     Route::post('/projects/update-pgforfieted/{pgDetail}', 
    [App\Http\Controllers\Admin\ProjectController::class, 'updateforfittedPgReturned'])
    ->name('projects.updatePgForfieted');

     Route::post('/projects/update-securityforfieted/{securityDeposit}', 
    [App\Http\Controllers\Admin\ProjectController::class, 'updateforfittedSecurityReturned'])
    ->name('projects.updateSecurityForfieted');

    // routes/web.php
    Route::put(
        '/projects/{project}/acceptance-update',
        [App\Http\Controllers\Admin\ProjectController::class, 'updateDocAndStatus']
    )->name('projects.acceptance.update');

    Route::put(
        '/projects/{project}/award-update',
        [App\Http\Controllers\Admin\ProjectController::class, 'updateDocAndStatus2']
    )->name('projects.award.update');

     Route::put(
        '/projects/{project}/agreement-update',
        [App\Http\Controllers\Admin\ProjectController::class, 'updateDocAndStatus3']
    )->name('projects.agreement.update');


     Route::put(
        '/projects/{project}/agreement-date-update',
        [App\Http\Controllers\Admin\ProjectController::class, 'updateDocAndStatus4']
    )->name('projects.agreementdate.update');


     Route::post('/projects/update-returned/{project}', 
    [App\Http\Controllers\Admin\ProjectController::class, 'updateReturned'])
    ->name('projects.updateReturned');


    /* ---- Project Workflow: Acceptance + Award + Agreement ---- */
    Route::post('projects/{project}/acceptance',
        [App\Http\Controllers\Admin\AcceptanceController::class, 'store']
    )->name('projects.acceptance.store');

    Route::post('projects/{project}/award',
        [App\Http\Controllers\Admin\AwardController::class, 'store']
    )->name('projects.award.store');

    Route::post('projects/{project}/agreement',
        [App\Http\Controllers\Admin\AgreementController::class, 'store']
    )->name('projects.agreement.store');

    

    /* ===================== BILLING (PROJECT WISE) ===================== */
    Route::get('projects/{project}/billing',
        [App\Http\Controllers\Admin\BillingController::class, 'index']
    )->name('projects.billing.index');

     Route::get('projects/{project}/{billing}/recoveries',
        [App\Http\Controllers\Admin\RecoveryController::class, 'index']
    )->name('projects.recoveries.index');

    Route::get(
        'projects/{project}/{billing}/security-deposits/create',
        [SecurityDepositController::class, 'create']
    )->name('security-deposits.create');

    Route::post(
        'projects/{project}/{billing}/security-deposits',
        [SecurityDepositController::class, 'store']
    )->name('security-deposits.store');
    
     Route::get('bill',
        [App\Http\Controllers\Admin\BillingController::class, 'indexprojects']
    )->name('indexprojects');

    Route::post('projects/{project}/billing',
        [App\Http\Controllers\Admin\BillingController::class, 'store']
    )->name('projects.billing.store');

    /* ---- Approve + Delete Bill ---- */
    Route::post('billing/{billing}/approve',
        [App\Http\Controllers\Admin\BillingController::class, 'approve']
    )->name('billing.approve');

    Route::delete('billing/{billing}',
        [App\Http\Controllers\Admin\BillingController::class, 'destroy']
    )->name('billing.destroy');

    /* ---- Billing Items ---- */
    Route::post('billing/{billing}/items',
        [App\Http\Controllers\Admin\BillingItemController::class, 'store']
    )->name('billing.items.store');

    Route::delete('billing/items/{billingItem}',
        [App\Http\Controllers\Admin\BillingItemController::class, 'destroy']
    )->name('billing.items.destroy');

    /* ---- Billing Recoveries ---- */
    Route::post('billing/{billing}/recovery',
        [App\Http\Controllers\Admin\RecoveryController::class, 'store']
    )->name('billing.recovery.store');

    /* ===================== VENDORS ===================== */
    Route::resource('vendors', App\Http\Controllers\Admin\VendorController::class)->only([
        'index', 'store', 'destroy'
    ]);

    /* ===================== INVENTORY ===================== */
    Route::resource('inventory', App\Http\Controllers\Admin\InventoryController::class)->only([
        'index', 'store', 'destroy'
    ]);

    /* ===================== T & P ===================== */
    Route::resource('tandp', App\Http\Controllers\Admin\TAndPController::class)->only([
        'index', 'store'
    ]);

    /* ===================== Attachments (POLYMORPHIC) ===================== */
    Route::post('attachments',
        [App\Http\Controllers\Admin\AttachmentController::class, 'store']
    )->name('attachments.store');
});

use App\Http\Controllers\Admin\DepartmentController;

Route::resource('departments', DepartmentController::class);



use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/* ========== AUTH ROUTES (NO UI) ========== */
Route::get('/', [LoginController::class, 'loginForm'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login');

Route::get('register', [RegisterController::class, 'registerForm'])->name('register.form');
Route::post('register', [RegisterController::class, 'register'])->name('register');

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

/* ========== PROTECTED ADMIN ROUTES ========== */
Route::middleware(['auth'])->prefix('superadmin')->name('superadmin.')->group(function () {

    Route::get('/', function () {
       return redirect()->route('superadmin.projects.index');
    })->name('superdashboard');

    // ⬇ YOUR earlier admin routes here (Projects, Billing, Vendor, etc.)
});

