<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\NoticeBoardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\MaintainerController;
use App\Http\Controllers\MaintenanceRequestController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\EmailSendingController;
use App\Http\Controllers\EmailAutomationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
require __DIR__ . '/auth.php';

Route::get('/', [HomeController::class,'index'])->middleware(
    [

        'XSS',
    ]
);
Route::get('home', [HomeController::class,'index'])->name('home')->middleware(
    [

        'XSS',
    ]
);
Route::get('dashboard', [HomeController::class,'index'])->name('dashboard')->middleware(
    [

        'XSS',
    ]
);

//-------------------------------User-------------------------------------------

Route::resource('users', UserController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


//-------------------------------Subscription-------------------------------------------


Route::resource('subscriptions', SubscriptionController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function (){

    Route::get('subscription/transaction', [SubscriptionController::class,'transaction'])->name('subscription.transaction');
    Route::post('subscription/{id}/stripe/payment', [SubscriptionController::class,'stripePayment'])->name('subscription.stripe.payment');

}
);

//-------------------------------Settings-------------------------------------------
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function (){
    Route::get('settings/account', [SettingController::class,'account'])->name('setting.account');
    Route::post('settings/account', [SettingController::class,'accountData'])->name('setting.account');
    Route::delete('settings/account/delete', [SettingController::class,'accountDelete'])->name('setting.account.delete');

    Route::get('settings/password', [SettingController::class,'password'])->name('setting.password');
    Route::post('settings/password', [SettingController::class,'passwordData'])->name('setting.password');

    Route::get('settings/general', [SettingController::class,'general'])->name('setting.general');
    Route::post('settings/general', [SettingController::class,'generalData'])->name('setting.general');

    Route::get('settings/smtp', [SettingController::class,'smtp'])->name('setting.smtp');
    Route::post('settings/smtp', [SettingController::class,'smtpData'])->name('setting.smtp');

    Route::get('settings/payment', [SettingController::class,'payment'])->name('setting.payment');
    Route::post('settings/payment', [SettingController::class,'paymentData'])->name('setting.payment');

    Route::get('settings/company', [SettingController::class,'company'])->name('setting.company');
    Route::post('settings/company', [SettingController::class,'companyData'])->name('setting.company');

    Route::get('language/{lang}', [SettingController::class,'lanquageChange'])->name('language.change');
    Route::post('theme/settings', [SettingController::class,'themeSettings'])->name('theme.settings');


}
);

//-------------------------------Role & Permissions-------------------------------------------
Route::resource('permission', PermissionController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('role', RoleController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


//-------------------------------Note-------------------------------------------
Route::resource('note', NoticeBoardController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Contact-------------------------------------------
Route::resource('contact', ContactController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


//-------------------------------Support-------------------------------------------

Route::post('support/reply/{id}', [SupportController::class,'reply'])->name('support.reply')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('support', SupportController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


//-------------------------------Property-------------------------------------------
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function (){
    Route::resource('property', PropertyController::class);
    Route::get('property/{pid}/unit/create', [PropertyController::class,'unitCreate'])->name('unit.create');
    Route::post('property/{pid}/unit/store', [PropertyController::class,'unitStore'])->name('unit.store');
    Route::get('property/{pid}/unit/{id}/edit', [PropertyController::class,'unitEdit'])->name('unit.edit');
    Route::put('property/{pid}/unit/{id}/update', [PropertyController::class,'unitUpdate'])->name('unit.update');
    Route::delete('property/{pid}/unit/{id}/destroy', [PropertyController::class,'unitDestroy'])->name('unit.destroy');
    Route::get('property/{pid}/unit', [PropertyController::class,'getPropertyUnit'])->name('property.unit');
}
);

//-------------------------------Tenant-------------------------------------------
Route::resource('tenant', TenantController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Type-------------------------------------------
Route::resource('type', TypeController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Invoice-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function (){
    Route::get('invoice/{id}/payment/create', [InvoiceController::class,'invoicePaymentCreate'])->name('invoice.payment.create');
    Route::post('invoice/{id}/payment/store', [InvoiceController::class,'invoicePaymentStore'])->name('invoice.payment.store');
    Route::delete('invoice/{id}/payment/{pid}/destroy', [InvoiceController::class,'invoicePaymentDestroy'])->name('invoice.payment.destroy');
    Route::delete('invoice/type/destroy', [InvoiceController::class,'invoiceTypeDestroy'])->name('invoice.type.destroy');
    Route::resource('invoice', InvoiceController::class);
}
);


//------------------------------- Email template -------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function (){
    Route::resource('template', EmailTemplateController::class);
}
);




//------------------------------- Emails -------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function (){
    Route::get('emails/show/{id}', [EmailSendingController::class,'show'])->name('showDetails');
    Route::get('emails/type', [EmailSendingController::class,'chooseType'])->name('typeForm');
    Route::post('emails/type', [EmailSendingController::class,'prepareSend'])->name('prepareSend');
    Route::get('emails/type/preview', [EmailSendingController::class,'previewEmail'])->name('previewEmail');

    Route::post('emails/send', [EmailSendingController::class,'sendSingleEmail'])->name('sendEmail');
    Route::post('emails/sendgroup', [EmailSendingController::class,'sendGroup'])->name('sendGroup');

    Route::resource('emails', EmailSendingController::class);
}
);

//------------------------------- Emails Automatiques -------------------------------------------

Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ], function (){

        Route::get('emailsAuto/new', [EmailAutomationController::class,'chooseTemplate'])->name('newAutoForm');
        Route::post('emailsAuto/new', [EmailAutomationController::class,'showAutoForm'])->name('showAutoForm');
        Route::post('emailsAuto/updateState', [EmailAutomationController::class, 'updateState'])->name('updateState');

        Route::get('emailsAuto/show/{id}', [EmailAutomationController::class,'showTaskDetails'])->name('showTaskDetails');
        Route::delete('emailsAuto/delete-recipient/{id}/{triggerId}', [EmailAutomationController::class,'deleteRecipient'])->name('delete.recipient');
        Route::post('emailsAuto/add-recipient/{id}/{triggerId}', [EmailAutomationController::class,'addRecipient'])->name('add.recipient');

        Route::resource('emailsAuto', EmailAutomationController::class);
    }
);

//-------------------------------Expense-------------------------------------------
Route::resource('expense', ExpenseController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Maintainer-------------------------------------------
Route::resource('maintainer', MaintainerController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Maintenance Request-------------------------------------------
Route::get('maintenance-request/{id}/action', [MaintenanceRequestController::class,'action'])->name('maintenance-request.action');
Route::post('maintenance-request/{id}/action', [MaintenanceRequestController::class,'actionData'])->name('maintenance-request.action');
Route::resource('maintenance-request', MaintenanceRequestController::class)->middleware(
    [
        'auth'
    ]
);



