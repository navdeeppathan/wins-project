<?php

use App\Http\Controllers\Admin\SecurityDepositController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectPgController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Admin\DailyNoteController;
use App\Http\Controllers\Admin\WithheldController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ScheduleWorkController;
use App\Http\Controllers\Staff\ActivityController as StaffActivityController;
use App\Http\Controllers\Staff\AttachmentController;
use App\Http\Controllers\Staff\BillingController;
use App\Http\Controllers\Staff\BillingItemController;
use App\Http\Controllers\Staff\CorrespondenceController;
use App\Http\Controllers\Staff\DepartmentController as StaffDepartmentController;
use App\Http\Controllers\Staff\InventoryController;
use App\Http\Controllers\Staff\ProjectController;
use App\Http\Controllers\Staff\ProjectPgController as StaffProjectPgController;
use App\Http\Controllers\Staff\RecoveryController;
use App\Http\Controllers\Staff\ScheduleWorkController as StaffScheduleWorkController;
use App\Http\Controllers\Staff\SecurityDepositController as StaffSecurityDepositController;
use App\Http\Controllers\Staff\TAndPController;
use App\Http\Controllers\Staff\VendorController;
use App\Http\Controllers\Admin\CqcVaultController;
/*
|--------------------------------------------------------------------------
| AUTH PROTECTED ADMIN ROUTES
|--------------------------------------------------------------------------
*/


use Illuminate\Support\Facades\Artisan;

Route::get('/run-storage-link', function () {
    Artisan::call('storage:link');

    return 'Storage link created successfully';
});


Route::get('/key', function () {
    Artisan::call('key:generate');
    return "Key generated successfully";
});

Route::get('clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cache cleared successfully";
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    /* ===================== Dashboard ===================== */




    // Show main index page
    Route::get('cqc-vault', [CqcVaultController::class,'index'])->name('cqc-vault.index');
    Route::get('admin/dashboard', [CqcVaultController::class,'dashboard']);
    Route::get('admin/checklist-frequency', [CqcVaultController::class,'checklistfrequency']);
    Route::get('admin/checklist-cqc', [CqcVaultController::class,'checklist']);

    // Audit logs
    Route::get('cqc-vault/audit-logs', [CqcVaultController::class,'auditLogs']);

    // Folder creation
    Route::get('cqc-vault/folder/create', [CqcVaultController::class,'createFolderPage']);
    Route::post('cqc-vault/folder/create', [CqcVaultController::class,'createFolder']);

    // Folder view (show documents & subfolders)
    Route::get('cqc-vault/folder/{id}', [CqcVaultController::class,'viewFolder']);

    // Upload document
    Route::post('cqc-vault/upload', [CqcVaultController::class,'upload']);

    // Document history
    Route::get('cqc-vault/history/{id}', [CqcVaultController::class,'history']);

    // Add multiple subfolders
    Route::post('cqc-vault/folder/{id}/subfolders', [CqcVaultController::class,'addSubfolders']);

    // Delete a folder
    Route::delete('cqc-vault/folder/{id}', [CqcVaultController::class,'dFolder']);
    Route::delete('cqc-vault/folder/{id}', [CqcVaultController::class,'deleteFolder']);
    Route::delete('cqc-vault/document/{id}', [CqcVaultController::class, 'deleteDocument']);


    Route::get('/',[App\Http\Controllers\Admin\ProjectController::class, 'dashboard'])->name('dashboard');

    Route::get('materials', [App\Http\Controllers\Admin\InventoryController::class, 'materialTabs'])->name('materialTabs.index');

    // routes/web.php
    Route::put(
        'projects/{inventory}/inventory-update',
        [App\Http\Controllers\Admin\InventoryController::class, 'updateInventoryDismantal']
    )->name('projects.inventory.update');

       // routes/web.php
    Route::put(
        'projects/{schedule}/schedule-update',
        [App\Http\Controllers\ScheduleWorkController::class, 'updateScheduleDismantal']
    )->name('projects.schedule.update');


    Route::get('users/{user}/projects', [App\Http\Controllers\Admin\ProjectController::class, 'indexUser'])
     ->name('users.projects');

    Route::get('users', [RegisterController::class, 'adminIndex'])->name('users.index');
    Route::get('users/create', [RegisterController::class, 'adminCreate'])->name('users.create');
    Route::post('users', [RegisterController::class, 'userCreate'])->name('users.store');
    Route::get('users/details/{user}', [RegisterController::class, 'adminUserDetails'])->name('users.details.index');
    Route::get('users/{user}/edit', [RegisterController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [RegisterController::class, 'update'])->name('users.update');

    Route::get('daily-notes', [DailyNoteController::class, 'index'])->name('daily-notes.index');
    Route::post('daily-notes', [DailyNoteController::class, 'store'])->name('daily-notes.store');
    Route::post('daily-notes/{id}/update', [DailyNoteController::class, 'update']);
    Route::post('daily-notes/{id}/destroy', [DailyNoteController::class, 'destroy']);
    Route::get('/acceptance', [App\Http\Controllers\Admin\ProjectController::class, 'acceptanceIndex'])->name('projects.acceptance');
    Route::get('/award', [App\Http\Controllers\Admin\ProjectController::class, 'awardIndex'])->name('projects.award');
    Route::get('/awards/{project}', [App\Http\Controllers\Admin\ProjectController::class, 'awardIndexs'])->name('projects.awards');
    Route::get('/agreement', [App\Http\Controllers\Admin\ProjectController::class, 'agreementIndex'])->name('projects.agreement');

    Route::get('/projects/{project}/agreement-date', [App\Http\Controllers\Admin\ProjectController::class, 'agreementDateCreate'])->name('projects.agreementdate.create');


    Route::get('/common', [App\Http\Controllers\Admin\ProjectController::class, 'commonIndex'])->name('projects.common.index');


     Route::get('/common-details/{project}', [App\Http\Controllers\Admin\ProjectController::class, 'commonCreate'])->name('projects.common.create');

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
        '/withheldreturned',
        [App\Http\Controllers\Admin\ProjectController::class, 'withheldreturnIndex']
    )->name('projects.withheldreturned.index');


    Route::get(
        '/allrecoveries',
        [App\Http\Controllers\Admin\RecoveryController::class, 'tabRecoveries']
    )->name('projects.recoveries.tabindex');

     Route::get(
        '/pgforfieted',
        [App\Http\Controllers\Admin\ProjectController::class, 'pgforfietedIndex']
    )->name('projects.pgreturned.forfieted');

    Route::get(
        '/securityforfieted',
        [App\Http\Controllers\Admin\ProjectController::class, 'securityforfietedIndex']
    )->name('projects.securityreturned.forfieted');

     Route::get(
        '/withheldforfieted',
        [App\Http\Controllers\Admin\ProjectController::class, 'withheldforfietedIndex']
    )->name('projects.withheldreturned.forfieted');

    Route::get(
        '/emdreturned/{project}',
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
        '/withheldreturned/{project}',
        [App\Http\Controllers\Admin\ProjectController::class, 'withheldreturnedCreate']
    )->name('projects.withheldreturned.create');

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

     Route::get(
        '/withheldforfieted/{project}',
        [App\Http\Controllers\Admin\ProjectController::class, 'withheldforfietedCreate']
    )->name('projects.withheldforfieted.create');

    /* ===================== PROJECTS (BIDDING) ===================== */
    Route::resource('projects', App\Http\Controllers\Admin\ProjectController::class);

    Route::post(
        'projects/{project}/emd/save',
        [App\Http\Controllers\Admin\ProjectController::class, 'saveEmd']
    )->name('projects.emd.save');


    Route::get(
        '/acceptance/projects/{project}/pg',
        [ProjectPgController::class, 'create']
    )->name('projects.pg.create');

    Route::post(
        'projects/{project}/pg/save',
        [ProjectPgController::class, 'save']
    )->name('projects.pg.save');

    Route::get('correspondence',
        [App\Http\Controllers\Admin\CorrespondenceController::class, 'index']
    )->name('projects.correspondence.index');

    Route::get('correspondence/{project}',
        [App\Http\Controllers\Admin\CorrespondenceController::class, 'index2']
    )->name('projects.correspondence');

    Route::post('projects/{project}/correspondence/save',
        [App\Http\Controllers\Admin\CorrespondenceController::class, 'save']
    )->name('projects.correspondence.save');

    Route::post('correspondence/{correspondence}/destroy',
        [App\Http\Controllers\Admin\CorrespondenceController::class, 'destroy']
    )->name('correspondence.destroy');



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

    Route::post('/projects/update-withheldreturned/{withheldDetail}',
    [App\Http\Controllers\Admin\ProjectController::class, 'updateWithheldReturned'])
    ->name('projects.updateWithheldReturned');

     Route::post('/projects/update-forfieted/{emdDetail}',
    [App\Http\Controllers\Admin\ProjectController::class, 'updateforfittedReturned'])
    ->name('projects.updateForfieted');

     Route::post('/projects/update-pgforfieted/{pgDetail}',
    [App\Http\Controllers\Admin\ProjectController::class, 'updateforfittedPgReturned'])
    ->name('projects.updatePgForfieted');

     Route::post('/projects/update-securityforfieted/{securityDeposit}',
    [App\Http\Controllers\Admin\ProjectController::class, 'updateforfittedSecurityReturned'])
    ->name('projects.updateSecurityForfieted');

     Route::post('/projects/update-withheldforfieted/{withheldDetail}',
    [App\Http\Controllers\Admin\ProjectController::class, 'updateforfittedWithheldReturned'])
    ->name('projects.updateWithheldForfieted');



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
    Route::get('bill/{project}/billing',
        [App\Http\Controllers\Admin\BillingController::class, 'index']
    )->name('projects.billing.index');

     Route::get('bill/projects/{project}/{billing}/recoveries',
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


     Route::get(
        'projects/{project}/{billing}/withheld-deposits/create',
        [WithheldController::class, 'create']
    )->name('withheld-deposits.create');

    Route::post(
        'projects/{project}/{billing}/withheld-deposits',
        [WithheldController::class, 'store']
    )->name('withheld-deposits.store');

     Route::get('bill',
        [App\Http\Controllers\Admin\BillingController::class, 'indexprojects']
    )->name('indexprojects');

    Route::post('projects/{project}/billing',
        [App\Http\Controllers\Admin\BillingController::class, 'store']
    )->name('projects.billing.store');


    Route::post(
        'projects/billing/{billing}/update',
        [App\Http\Controllers\Admin\BillingController::class, 'update']
    )->name('projects.billing.update');

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
    // Route::resource('vendors', App\Http\Controllers\Admin\VendorController::class)->only([
    //     'index', 'store', 'destroy'
    // ]);


    Route::get('vendors', [App\Http\Controllers\Admin\VendorController::class, 'index'])->name('vendors.index');
    Route::get('vendors/create', [App\Http\Controllers\Admin\VendorController::class, 'create'])->name('vendors.create');
    Route::get('vendors/edit/{vendor}', [App\Http\Controllers\Admin\VendorController::class, 'edit'])->name('vendors.edit');
    Route::get('vendors/details/{vendor}', [App\Http\Controllers\Admin\VendorController::class, 'index2'])->name('vendors.details.index');


    Route::post('vendors', [App\Http\Controllers\Admin\VendorController::class, 'store'])->name('vendors.store');
    Route::post('vendors/{vendor}/update', [App\Http\Controllers\Admin\VendorController::class, 'update'])->name('vendors.update');
    Route::post('vendors/{vendor}/destroy', [App\Http\Controllers\Admin\VendorController::class, 'destroy'])->name('vendors.destroy');


     Route::get('t-and-p', [App\Http\Controllers\Admin\TAndPController::class, 'index'])
        ->name('t-and-p.index');

    Route::post('t-and-p/store', [App\Http\Controllers\Admin\TAndPController::class, 'store'])
        ->name('t-and-p.store');

    Route::post('t-and-p/{tAndP}/update', [App\Http\Controllers\Admin\TAndPController::class, 'update'])
        ->name('t-and-p.update');

    Route::post('t-and-p/{tAndP}/destroy', [App\Http\Controllers\Admin\TAndPController::class, 'destroy'])
        ->name('t-and-p.destroy');

    /* ===================== INVENTORY ===================== */
    // Route::resource('inventory', App\Http\Controllers\Admin\InventoryController::class)->only([
    //     'index', 'store', 'destroy'
    // ]);

     Route::get('inventory', [App\Http\Controllers\Admin\InventoryController::class, 'index'])
            ->name('inventory.index');


     Route::get('inventory/tab', [App\Http\Controllers\Admin\InventoryController::class, 'tabindex'])
            ->name('inventory.tabindex');

        // ➕ Create Inventory (AJAX)
        Route::post('inventory', [App\Http\Controllers\Admin\InventoryController::class, 'store'])
            ->name('inventory.store');

        // ✏️ Update Inventory (AJAX inline save)
        Route::post('inventory/{inventory}/update', [App\Http\Controllers\Admin\InventoryController::class, 'update'])
            ->name('inventory.update');

        // ❌ Delete Inventory
        Route::post('inventory/{inventory}/destroy', [App\Http\Controllers\Admin\InventoryController::class, 'destroy'])
            ->name('inventory.destroy');

        Route::patch('/inventory/{inventory}/approve',
            [App\Http\Controllers\Admin\InventoryController::class, 'isApproved']
        )->name('inventory.approve');


    /* ===================== T & P ===================== */
    // Route::resource('tandp', App\Http\Controllers\Admin\TAndPController::class)->only([
    //     'index', 'store'
    // ]);





    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('/activities/{project}', [ActivityController::class, 'index2'])->name('activities.index2');
    Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
    Route::get('/activities/{activity}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
    Route::post('/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');




    Route::get('/schedule-work', [ScheduleWorkController::class, 'index'])->name('schedule-work.index');
    Route::get('schedule-work/{project}',
        [ScheduleWorkController::class,'index2']
        )->name('projects.schedule-work');

    Route::get('schedule-work/{project}/{scheduleWork}',
        [ScheduleWorkController::class,'index3']
        )->name('projects.schedule-work.index3');

    Route::post('projects/{project}/schedule-work/save',
        [ScheduleWorkController::class,'save']
    )->name('projects.schedule-work.save');

    Route::post('projects/schedule-work/delete',
        [ScheduleWorkController::class, 'delete']
    )->name('projects.schedule-work.delete');


    /* ===================== Attachments (POLYMORPHIC) ===================== */
    Route::post('attachments',
        [App\Http\Controllers\Admin\AttachmentController::class, 'store']
    )->name('attachments.store');
});


Route::middleware(['auth'])->prefix('staff')->name('staff.')->group(function () {

    /* ===================== Dashboard ===================== */
    Route::get('/', function () {
      return redirect()->route('staff.projects.index');

    })->name('dashboard');

    Route::resource('departments', StaffDepartmentController::class);


    Route::get('users', [RegisterController::class, 'adminIndex'])->name('users.index');
    Route::get('users/create', [RegisterController::class, 'adminCreate'])->name('users.create');
    Route::post('users', [RegisterController::class, 'userCreate'])->name('users.store');


       Route::get('daily-notes', [DailyNoteController::class, 'index'])->name('daily-notes.index');
        Route::post('daily-notes', [DailyNoteController::class, 'store'])->name('daily-notes.store');
        Route::post('daily-notes/{id}/update', [DailyNoteController::class, 'update']);
        Route::post('daily-notes/{id}/destroy', [DailyNoteController::class, 'destroy']);

      Route::get('/acceptance', [ProjectController::class, 'acceptanceIndex'])
    ->name('projects.acceptance');

     Route::get('/award', [ProjectController::class, 'awardIndex'])
    ->name('projects.award');

     Route::get('/agreement', [ProjectController::class, 'agreementIndex'])
    ->name('projects.agreement');

    Route::get(
        '/projects/{project}/agreement-date',
        [ProjectController::class, 'agreementDateCreate']
    )->name('projects.agreementdate.create');


    Route::get(
        '/common',
        [ProjectController::class, 'commonIndex']
    )->name('projects.common.index');


     Route::get(
        '/common-details/{project}',
        [ProjectController::class, 'commonCreate']
    )->name('projects.common.create');

     Route::get(
        '/emdreturned',
        [ProjectController::class, 'returnIndex']
    )->name('projects.returned.index');

     Route::get(
        '/emdforfieted',
        [ProjectController::class, 'forfietedIndex']
    )->name('projects.returned.forfieted');


     Route::get(
        '/pgreturned',
        [ProjectController::class, 'pgreturnIndex']
    )->name('projects.pgreturned.index');



     Route::get(
        '/securityreturned',
        [ProjectController::class, 'securityreturnIndex']
    )->name('projects.securityreturned.index');

    Route::get(
        '/withheldreturned',
        [ProjectController::class, 'withheldreturnIndex']
    )->name('projects.withheldreturned.index');

     Route::get(
        '/pgforfieted',
        [ProjectController::class, 'pgforfietedIndex']
    )->name('projects.pgreturned.forfieted');

    Route::get(
        '/securityforfieted',
        [ProjectController::class, 'securityforfietedIndex']
    )->name('projects.securityreturned.forfieted');

     Route::get(
        '/withheldforfieted',
        [ProjectController::class, 'withheldforfietedIndex']
    )->name('projects.withheldreturned.forfieted');

    Route::get(
        '/emdreturned/{project}',
        [ProjectController::class, 'returnedCreate']
    )->name('projects.returned.create');

     Route::get(
        '/pgreturned/{project}',
        [ProjectController::class, 'pgreturnedCreate']
    )->name('projects.pgreturned.create');

     Route::get(
        '/securityreturned/{project}',
        [ProjectController::class, 'securityreturnedCreate']
    )->name('projects.securityreturned.create');

      Route::get(
        '/withheldreturned/{project}',
        [ProjectController::class, 'withheldreturnedCreate']
    )->name('projects.withheldreturned.create');

    Route::get(
        '/forfieted/{project}',
        [ProjectController::class, 'forfietedCreate']
    )->name('projects.forfieted.create');

    Route::get(
        '/pgforfieted/{project}',
        [ProjectController::class, 'pgforfietedCreate']
    )->name('projects.pgforfieted.create');

     Route::get(
        '/securityforfieted/{project}',
        [ProjectController::class, 'securityforfietedCreate']
    )->name('projects.securityforfieted.create');

     Route::get(
        '/withheldforfieted/{project}',
        [ProjectController::class, 'withheldforfietedCreate']
    )->name('projects.withheldforfieted.create');

    /* ===================== PROJECTS (BIDDING) ===================== */
    Route::resource('projects', ProjectController::class);

    Route::post(
        'projects/{project}/emd/save',
        [ProjectController::class, 'saveEmd']
    )->name('projects.emd.save');


    Route::get(
        '/projects/{project}/pg',
        [StaffProjectPgController::class, 'create']
    )->name('projects.pg.create');

    Route::post(
        'projects/{project}/pg/save',
        [StaffProjectPgController::class, 'save']
    )->name('projects.pg.save');

    Route::get('correspondence',
        [CorrespondenceController::class, 'index']
    )->name('projects.correspondence.index');

    Route::get('correspondence/{project}',
        [CorrespondenceController::class, 'index2']
    )->name('projects.correspondence');

    Route::post('projects/{project}/correspondence/save',
        [CorrespondenceController::class, 'save']
    )->name('projects.correspondence.save');

    Route::post('correspondence/{correspondence}/destroy',
        [CorrespondenceController::class, 'destroy']
    )->name('correspondence.destroy');



    Route::post('/projects/update-qualified/{project}',
    [ProjectController::class, 'updateQualified'])
    ->name('projects.updateQualified');

    Route::post('/projects/update-returned/{emdDetail}',
    [ProjectController::class, 'updateReturned'])
    ->name('projects.updateReturned');

    Route::post('/projects/update-pgreturned/{pgDetail}',
    [ProjectController::class, 'updatePgReturned'])
    ->name('projects.updatePgReturned');

     Route::post('/projects/update-securityreturned/{securityDeposit}',
    [ProjectController::class, 'updateSecurityReturned'])
    ->name('projects.updateSecurityReturned');

    Route::post('/projects/update-withheldreturned/{withheldDetail}',
    [ProjectController::class, 'updateWithheldReturned'])
    ->name('projects.updateWithheldReturned');

     Route::post('/projects/update-forfieted/{emdDetail}',
    [ProjectController::class, 'updateforfittedReturned'])
    ->name('projects.updateForfieted');

     Route::post('/projects/update-pgforfieted/{pgDetail}',
    [ProjectController::class, 'updateforfittedPgReturned'])
    ->name('projects.updatePgForfieted');

     Route::post('/projects/update-securityforfieted/{securityDeposit}',
    [ProjectController::class, 'updateforfittedSecurityReturned'])
    ->name('projects.updateSecurityForfieted');

     Route::post('/projects/update-withheldforfieted/{withheldDetail}',
    [ProjectController::class, 'updateforfittedWithheldReturned'])
    ->name('projects.updateWithheldForfieted');



    // routes/web.php
    Route::put(
        '/projects/{project}/acceptance-update',
        [ProjectController::class, 'updateDocAndStatus']
    )->name('projects.acceptance.update');

    Route::put(
        '/projects/{project}/award-update',
        [ProjectController::class, 'updateDocAndStatus2']
    )->name('projects.award.update');

     Route::put(
        '/projects/{project}/agreement-update',
        [ProjectController::class, 'updateDocAndStatus3']
    )->name('projects.agreement.update');


     Route::put(
        '/projects/{project}/agreement-date-update',
        [ProjectController::class, 'updateDocAndStatus4']
    )->name('projects.agreementdate.update');


     Route::post('/projects/update-returned/{project}',
    [ProjectController::class, 'updateReturned'])
    ->name('projects.updateReturned');


    /* ---- Project Workflow: Acceptance + Award + Agreement ---- */
    // Route::post('projects/{project}/acceptance',
    //     [App\Http\Controllers\Staff\AcceptanceController::class, 'store']
    // )->name('projects.acceptance.store');

    // Route::post('projects/{project}/award',
    //     [App\Http\Controllers\Staff\AwardController::class, 'store']
    // )->name('projects.award.store');

    // Route::post('projects/{project}/agreement',
    //     [App\Http\Controllers\Staff\AgreementController::class, 'store']
    // )->name('projects.agreement.store');



    /* ===================== BILLING (PROJECT WISE) ===================== */
    Route::get('bill/{project}/billing',
        [BillingController::class, 'index']
    )->name('projects.billing.index');

     Route::get('projects/{project}/{billing}/recoveries',
        [RecoveryController::class, 'index']
    )->name('projects.recoveries.index');

    Route::get(
        'projects/{project}/{billing}/security-deposits/create',
        [StaffSecurityDepositController::class, 'create']
    )->name('security-deposits.create');

    Route::post(
        'projects/{project}/{billing}/security-deposits',
        [StaffSecurityDepositController::class, 'store']
    )->name('security-deposits.store');


     Route::get(
        'projects/{project}/{billing}/withheld-deposits/create',
        [WithheldController::class, 'create']
    )->name('withheld-deposits.create');

    Route::post(
        'projects/{project}/{billing}/withheld-deposits',
        [WithheldController::class, 'store']
    )->name('withheld-deposits.store');

     Route::get('bill',
        [BillingController::class, 'indexprojects']
    )->name('indexprojects');

    Route::post('projects/{project}/billing',
        [BillingController::class, 'store']
    )->name('projects.billing.store');


    Route::post(
        'projects/billing/{billing}/update',
        [BillingController::class, 'update']
    )->name('projects.billing.update');

    /* ---- Approve + Delete Bill ---- */
    Route::post('billing/{billing}/approve',
        [BillingController::class, 'approve']
    )->name('billing.approve');

    Route::delete('billing/{billing}',
        [BillingController::class, 'destroy']
    )->name('billing.destroy');

    /* ---- Billing Items ---- */
    Route::post('billing/{billing}/items',
        [BillingItemController::class, 'store']
    )->name('billing.items.store');

    Route::delete('billing/items/{billingItem}',
        [BillingItemController::class, 'destroy']
    )->name('billing.items.destroy');

    /* ---- Billing Recoveries ---- */
    Route::post('billing/{billing}/recovery',
        [RecoveryController::class, 'store']
    )->name('billing.recovery.store');


    /* ===================== VENDORS ===================== */
    // Route::resource('vendors', App\Http\Controllers\Admin\VendorController::class)->only([
    //     'index', 'store', 'destroy'
    // ]);

    Route::get('vendors', [VendorController::class, 'index'])->name('vendors.index');
    Route::post('vendors', [VendorController::class, 'store'])->name('vendors.store');
    Route::post('vendors/{vendor}/update', [VendorController::class, 'update'])->name('vendors.update');
    Route::post('vendors/{vendor}/destroy', [VendorController::class, 'destroy'])->name('vendors.destroy');


     Route::get('t-and-p', [TAndPController::class, 'index'])
        ->name('t-and-p.index');

    Route::post('t-and-p/store', [TAndPController::class, 'store'])
        ->name('t-and-p.store');

    Route::post('t-and-p/{tAndP}/update', [TAndPController::class, 'update'])
        ->name('t-and-p.update');

    Route::post('t-and-p/{tAndP}/destroy', [TAndPController::class, 'destroy'])
        ->name('t-and-p.destroy');

    /* ===================== INVENTORY ===================== */
    // Route::resource('inventory', App\Http\Controllers\Admin\InventoryController::class)->only([
    //     'index', 'store', 'destroy'
    // ]);

    Route::get('inventory', [InventoryController::class, 'index'])
            ->name('inventory.index');

    Route::get('inventory/tab', [InventoryController::class, 'tabindex'])
            ->name('inventory.tabindex');

        // ➕ Create Inventory (AJAX)
        Route::post('inventory', [InventoryController::class, 'store'])
            ->name('inventory.store');

        // ✏️ Update Inventory (AJAX inline save)
        Route::post('inventory/{inventory}/update', [InventoryController::class, 'update'])
            ->name('inventory.update');

        // ❌ Delete Inventory
        Route::post('inventory/{inventory}/destroy', [InventoryController::class, 'destroy'])
            ->name('inventory.destroy');

    /* ===================== T & P ===================== */
    // Route::resource('tandp', App\Http\Controllers\Admin\TAndPController::class)->only([
    //     'index', 'store'
    // ]);





    Route::get('/activities', [StaffActivityController::class, 'index'])->name('activities.index');
    Route::get('/activities/{project}', [StaffActivityController::class, 'index2'])->name('activities.index2');
    Route::post('/activities', [StaffActivityController::class, 'store'])->name('activities.store');
    Route::get('/activities/{activity}/edit', [StaffActivityController::class, 'edit'])->name('activities.edit');
    Route::post('/activities/{activity}', [StaffActivityController::class, 'update'])->name('activities.update');




    Route::get('/schedule-work', [StaffScheduleWorkController::class, 'index'])->name('schedule-work.index');
    Route::get('schedule-work/{project}',
        [StaffScheduleWorkController::class,'index2']
        )->name('projects.schedule-work');

    Route::post('projects/{project}/schedule-work/save',
        [StaffScheduleWorkController::class,'save']
    )->name('projects.schedule-work.save');



    /* ===================== Attachments (POLYMORPHIC) ===================== */
    Route::post('attachments',
        [AttachmentController::class, 'store']
    )->name('attachments.store');
});

use App\Http\Controllers\Admin\DepartmentController;

Route::resource('departments', DepartmentController::class);



use App\Http\Controllers\Auth\LoginController;


/* ========== AUTH ROUTES (NO UI) ========== */
Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [LoginController::class, 'loginForm'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login');

Route::get('register', [RegisterController::class, 'registerForm'])->name('register.form');
Route::post('register', [RegisterController::class, 'register'])->name('register');

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

/* ========== PROTECTED ADMIN ROUTES ========== */
Route::middleware(['auth'])->prefix('superadmin')->name('superadmin.')->group(function () {

    /* ===================== Dashboard ===================== */
    Route::get('/', function () {
    //   return redirect()->route('superadmin.projects.index');
    return view('superadmin.dashboard');

    })->name('dashboard');


    Route::get('users', [RegisterController::class, 'index'])->name('users.index');
    Route::get('users/create', [RegisterController::class, 'create'])->name('users.create');
    Route::get('users/{user}/allprojects', [App\Http\Controllers\SuperAdmin\ProjectController::class, 'index'])->name('users.allprojects');
    Route::get('users/{user}/allinventories', [App\Http\Controllers\SuperAdmin\InventoryController::class, 'index'])->name('users.allinventories');
    Route::get('users/{user}/allusers', [RegisterController::class, 'indexUser'])->name('users.allusers');
    
    Route::get('users/projects/{project}/allbillings', [App\Http\Controllers\SuperAdmin\BillingController::class, 'index'])->name('users.projects.allbillings');
    Route::get('users/projects/billing/{project}/{billing}/allrecoveries', [App\Http\Controllers\SuperAdmin\RecoveryController::class, 'index'])->name('users.projects.billing.allrecoveries');
   
});


