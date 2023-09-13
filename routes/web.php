<?php
use Illuminate\Support\Facades\Route;

//AUTH IMPORT

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogOutController;
use App\Http\Controllers\ForgottenPasswordController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\VerifyController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\RegisterController;





//USER IMPORT
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VisitorsController;




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



// ==========NOTIFICATION ROUTE===========//
Route::get('/notification',[NotificationController::class, 'index'])->name("notification.index");



// ==========REGISTER ROUTE===========//
Route::get('/register',[RegisterController::class, 'index'])->name("register.index")->middleware('isAlreadyLoggedIn');
Route::get('/complete-register',[RegisterController::class, 'completeRegister'])->name("register.complete.index")->middleware('isAlreadyLoggedIn');
Route::post('handle-initia-register',[RegisterController::class, 'handleInitialRegister'])->name("register.initialRegister")->middleware('isAlreadyLoggedIn');
Route::post('/handle-complete-register',[RegisterController::class, 'handleCompleteRegister'])->name("register.completeRegister")->middleware('isAlreadyLoggedIn');



// ==========LOGIN ROUTE===========//
Route::get('/login',[LoginController::class, 'index'])->name("login.index")->middleware("isAlreadyLoggedIn");
Route::post('/handle-login-form',[LoginController::class, 'handleLoginForm'])->name("login.handleLoginForm")->middleware("isAlreadyLoggedIn");

// ==========LOGOUT ROUTE===========//
Route::get('/logout',[LogOutController::class, 'index'])->name("logout.index")->middleware("isUser");
Route::post('/handle-logout',[LogOutController::class, 'handleLogout'])->name("logout.handlelogout")->middleware("isUser");

// ==========FORGOTTEN PASSWORD ROUTE===========//
Route::get('/forgotten-password',[ForgottenPasswordController::class, 'index'])->name("forgottenpassword.index")->middleware("isAlreadyLoggedIn");
Route::post('/handle-forgotten-password-form',[ForgottenPasswordController::class, 'handleForgottenPasswordForm'])->name("handleforgottenpassword")->middleware("isAlreadyLoggedIn");


// ==========VERIFY ROUTE===========//

Route::get('/verify/{tk}/{action}',[VerifyController::class, 'index'])->name("verify.index")->middleware('isAlreadyLoggedIn');
Route::post('/verify-link',[VerifyController::class, 'verifyLink'])->name("verify.verifyLink")->middleware('isAlreadyLoggedIn');


// ==========RESET PASS ROUTE===========//
Route::get('/reset-password',[ResetPasswordController::class, 'index'])->name("resetPass.index")->middleware('isAlreadyLoggedIn');
Route::post('/handle-reset-password',[ResetPasswordController::class, 'update'])->name("resetPass.update")->middleware('isAlreadyLoggedIn');

// ==========HOME ROUTE===========//
Route::get('/',[HomeController::class, 'index'])->name("home.index");
Route::get('/home',[HomeController::class, 'index'])->name("home.index");

// ==========CHECK OUT VISITORS ROUTE===========//
Route::post('/signout-visitor',[VisitorsController::class, 'signOutVisitor'])->name("signoutvisitor.index");
Route::post('/sort-current-visitor',[VisitorsController::class, 'sortCurrentVisitor'])->name("sortcurrentvisitor");
Route::post('/view-all-visitor',[VisitorsController::class, 'viewAllVisitor'])->name("viewallvisitors");

//Remove this at later date
Route::post('/reset-current-visitor',[VisitorsController::class, 'resetCurrentVisitor'])->name("resetcurrentvisitor");



