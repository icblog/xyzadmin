<?php

use Illuminate\Support\Facades\Route;

//AUTH IMPORT

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogOutController;
use App\Http\Controllers\Auth\ForgottenPasswordController;
use App\Http\Controllers\Auth\VerifyController;
use App\Http\Controllers\Auth\ResetPasswordController;


//PAGES IMPORT
use App\Http\Controllers\HomeController;

//USER IMPORT
use App\Http\Controllers\User\UserController;

//Visitor IMPORT
use App\Http\Controllers\Visitor\VisitorsController;

use App\Http\Controllers\VisitingReason\VisitingReasonsController;

//DEPARTMENT AND COMPNAY IMPORT
use App\Http\Controllers\DepartmentAndCompany\DepartmentAndCompanyController;

//ABSENCE IMPORT

use App\Http\Controllers\AbsenceLog\AbsenceController;

use App\Http\Controllers\CommonAbsenceReason\CommonAbsenceReasonController;

//PHONE IMPORT

use App\Http\Controllers\Phone\PhoneController;

//LOCKER IMPORT
use App\Http\Controllers\Locker\LockerController;

//Key IMPORT
use App\Http\Controllers\Key\KeyController;

//Key Log Import
use App\Http\Controllers\KeyLog\KeyLogController;

//Key Storage IMPORT
use App\Http\Controllers\KeyStorage\KeyStorageController;

//Temp offsite
use App\Http\Controllers\TempOffsite\TempOffsiteController;

//EMAILTEST 
use App\Http\Controllers\EmailTest\EmailTestController;



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

// ==========LOGIN ROUTE===========//
Route::get('/login', [LoginController::class, 'index'])->name("login.index")->middleware("isAlreadyLoggedIn");
Route::post('/handle-login-form', [LoginController::class, 'handleLoginForm'])->name("login.handleLoginForm")->middleware("isAlreadyLoggedIn");

// ==========LOGOUT ROUTE===========//
Route::get('/logout', [LogOutController::class, 'index'])->name("logout.index")->middleware("isUser");
Route::post('/handle-logout', [LogOutController::class, 'handleLogout'])->name("logout.handlelogout")->middleware("isUser");

// ==========FORGOTTEN PASSWORD ROUTE===========//
Route::get('/forgotten-password', [ForgottenPasswordController::class, 'index'])->name("forgottenpassword.index")->middleware("isAlreadyLoggedIn");
Route::post('/handle-forgotten-password-form', [ForgottenPasswordController::class, 'handleForgottenPasswordForm'])->name("handleforgottenpassword")->middleware("isAlreadyLoggedIn");


// ==========VERIFY ROUTE===========//

Route::get('/verify/{tk}', [VerifyController::class, 'index'])->name("verify.index")->middleware('isAlreadyLoggedIn');
Route::post('/verify-link', [VerifyController::class, 'verifyLink'])->name("verify.verifyLink")->middleware('isAlreadyLoggedIn');


// ==========RESET PASS ROUTE===========//
Route::get('/reset-password', [ResetPasswordController::class, 'index'])->name("resetPass.index");
Route::post('/handle-reset-password', [ResetPasswordController::class, 'handleResetPassword'])->name("resetPass.handleresetpassword");

// ==========HOME ROUTE===========//
Route::get('/', [HomeController::class, 'index'])->name("home.index")->middleware('isUser');
Route::get('/home', [HomeController::class, 'index'])->name("home.index")->middleware('isUser');

// ==========USER ROUTE===========//
Route::get('/user/add-coworker', [UserController::class, 'addCoworkerIndex'])->name("addcoworker.index")->middleware("isAdmin");
Route::get('/user/add-contractor', [UserController::class, 'addContractorIndex'])->name("addcontractor.index")->middleware("isAdmin");
Route::get('/add-user', [UserController::class, 'addUserIndex'])->name("adduser.index")->middleware("isAdmin");
Route::get('/edit-user', [UserController::class, 'editUserIndex'])->name("edit.index")->middleware("isAdmin");
Route::match(['get', 'post'], '/view-users', [UserController::class, 'viewUsersIndex'])->name("viewusers.index")->middleware('isUser');
Route::post('/handle-add-user', [UserController::class, 'handleAddUser'])->middleware("isAdmin");
Route::post('/find-user-edit', [UserController::class, 'findUserEdit'])->middleware("isAdmin");
Route::post('/update-user', [UserController::class, 'update'])->middleware("isAdmin");
Route::post('/user/delete', [UserController::class, 'delete'])->middleware("isAdmin");
Route::post('/find-coworker', [UserController::class, 'findUser'])->middleware("isUser");


// ==========VISITORS ROUTE===========//
Route::get('/current-visitor', [VisitorsController::class, 'currentVisitorsIndex'])->name("currentvisitor.index")->middleware('isUser');
Route::match(['get', 'post'], '/view-all-visitor', [VisitorsController::class, 'viewAllVisitorsIndex'])->name("viewallvisitors.index")->middleware('isUser');
Route::post('/sort-current-visitor', [VisitorsController::class, 'sortCurrentVisitor'])->name("sortcurrentvisitor")->middleware('isUser');
Route::post('/signout-visitor', [VisitorsController::class, 'signOutVisitor'])->name("signoutvisitor.index")->middleware('isUser');

// ============VISITING REASON ROUTE==========//
Route::match(['get', 'post'], '/visiting-reasons', [VisitingReasonsController::class, 'index'])->name("visitingreasons.index")->middleware('isUser');
Route::post('/visitor/add-reasons', [VisitingReasonsController::class, 'save'])->middleware('isUser');
Route::post('/visitor/update-reasons', [VisitingReasonsController::class, 'update'])->middleware('isUser');
Route::post('/visitor/delete-reasons', [VisitingReasonsController::class, 'delete'])->middleware('isUser');

// ==========DEPARTMENT/COMPANY ROUTE===========//
Route::get('/departcomp/add', [DepartmentAndCompanyController::class, 'index'])->middleware('isUser');
Route::post('/handle-add-depart-comp', [DepartmentAndCompanyController::class, 'store'])->middleware('isUser');
Route::post('/handle-depart-comp-update', [DepartmentAndCompanyController::class, 'update'])->middleware('isUser');
Route::post('/depart-comp/delete', [DepartmentAndCompanyController::class, 'delete'])->middleware('isUser');
Route::post('/depart-comp/depart-coworkers', [DepartmentAndCompanyController::class, 'getDepartCoWorkers'])->middleware('isUser');
Route::match(['get', 'post'], '/view-all-depart-comp', [DepartmentAndCompanyController::class, 'viewAllDepartCompIndex'])->name("viewalldepartcomp.index")->middleware('isUser');

// ==========CommonAbsenceReason ROUTE===========//
Route::match(['get', 'post'], '/absence/reasons', [CommonAbsenceReasonController::class, 'index'])->name('absencereason.index')->middleware('isUser');
Route::post('/absence/add-reasons', [CommonAbsenceReasonController::class, 'save'])->middleware('isUser');
Route::post('/absence/update-reason', [CommonAbsenceReasonController::class, 'update'])->middleware('isUser');
Route::post('/absence/delete-reason', [CommonAbsenceReasonController::class, 'delete'])->middleware('isUser');

// ==========ABSENCE ROUTE===========//
Route::match(['get', 'post'], '/absence', [AbsenceController::class, 'index'])->name('viewabsence.index')->middleware('isUser');
Route::get('/absence/add', [AbsenceController::class, 'absenceAdd'])->middleware('isUser');
Route::post('/absence/find-user', [AbsenceController::class, 'absenceFindUser'])->middleware('isUser');
Route::post('/absence/store', [AbsenceController::class, 'store'])->middleware('isUser');
Route::post('/get-coworkers-and-phones', [AbsenceController::class, 'getCoworkersAndPhones'])->middleware('isUser');
Route::post('/update-absence-responsible-told', [AbsenceController::class, 'updateAbsenceResponsibleTold'])->middleware('isUser');

// ==========PHONES ROUTE===========//
Route::get('/phones', [PhoneController::class, 'index'])->name('viewphone.index');
Route::get('/phones/add', [PhoneController::class, 'addPhoneIndex'])->name('addphone.index')->middleware('isUser');
Route::get('/phones/edit', [PhoneController::class, 'editPhoneIndex'])->name('editphone.index')->middleware('isUser');
Route::post('/phones/handle-add-phone-form', [PhoneController::class, 'store'])->middleware('isUser');
Route::post('/phones/fetch-department-phones', [PhoneController::class, 'fetchDepartmentPhones'])->middleware('isUser');
Route::post('/phones/delete-phone', [PhoneController::class, 'delete'])->middleware('isUser');
Route::post('/phones/update-phone', [PhoneController::class, 'update'])->middleware('isUser');


// ============LOCKER ROUTE==========//
Route::get('/lockers/add', [LockerController::class, 'addLockerIndex'])->middleware('isUser')->name('addlocker.index');
Route::match(['get', 'post'], '/lockers', [LockerController::class, 'index'])->name('viewlocker.index')->middleware('isUser');
Route::post('/lockers/handle-add-locker', [LockerController::class, 'store'])->middleware('isUser');
Route::post('/lockers/handle-assign-locker', [LockerController::class, 'update'])->middleware('isUser');
Route::post('/lockers/handle-delete-locker', [LockerController::class, 'delete'])->middleware('isUser');

// ============KEYS ROUTE==========//
Route::get('/keys/add', [KeyController::class, 'addKeyIndex'])->middleware('isUser')->name('addkey.index');
Route::get('/edit-key/{key_id}', [KeyController::class, 'updateKeyIndex'])->middleware('isUser')->name('updatekey.index');
Route::match(['get', 'post'], '/view-keys', [KeyController::class, 'index'])->name('viewkeys.index')->middleware('isUser');
Route::post('/keys/handle-add-key', [KeyController::class, 'store'])->middleware('isUser');
Route::post('/keys/handle-update-key', [KeyController::class, 'update'])->middleware('isUser');
Route::post('/keys/handle-delete-key', [KeyController::class, 'delete'])->middleware('isUser');
Route::post('/keys/fetch-key-auth', [KeyController::class, 'getKeyAuth'])->middleware('isUser');

//=================KEY LOG ROUTE=================//
Route::match(['get', 'post'], '/keys/log', [KeyLogController::class, 'index'])->name("keylog.index")->middleware('isUser');
Route::post('/keys/find-key', [KeyLogController::class, 'findKey'])->middleware('isUser');
Route::post('/keys/find-coworker', [KeyLogController::class, 'findCoworker'])->middleware('isUser');
Route::post('/keys/handle-log-key', [KeyLogController::class, 'logAkey'])->middleware('isUser');

// ============KEYS STORAGE ROUTE==========//
Route::match(['get', 'post'], '/keys/storage', [KeyStorageController::class, 'index'])->name('keystorage.index')->middleware('isUser');
Route::post('/keys/add-storage', [KeyStorageController::class, 'save'])->middleware('isUser');
Route::post('/keys/update-storage', [KeyStorageController::class, 'update'])->middleware('isUser');
Route::post('/keys/delete-storage', [KeyStorageController::class, 'delete'])->middleware('isUser');

// ============CURRENT TEMP OFFSITE ROUTE==========//
Route::match(['get', 'post'], '/tempoffsite/view', [TempOffsiteController::class, 'index'])->name('viewtempoffsite.index')->middleware('isUser');
Route::get('/tempoffsite/current', [TempOffsiteController::class, 'currentTempOffsiteIndex'])->name('currenttempoffsite.index')->middleware('isUser');
Route::post('/tempoffsite/sort', [TempOffsiteController::class, 'sortCurrentTempOffsite'])->middleware('isUser');
Route::post('/tempoffsite/sign-in', [TempOffsiteController::class, 'tempOffsiteSignIn'])->middleware('isUser');


//Remove this at later date
Route::get("/email", [EmailTestController::class, 'index']);
Route::post('/reset-current-visitor', [VisitorsController::class, 'resetCurrentVisitor'])->name("resetcurrentvisitor")->middleware('isUser');
