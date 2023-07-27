<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogOutController;
use App\Http\Controllers\ForgottenPasswordController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\VerifyController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\RegisterController;



//ADMIN IMPORT
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AdminCategoryController;


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

// ==========HOME ROUTE===========//
Route::get('/',[HomeController::class, 'index'])->name("home.index");
Route::get('/home',[HomeController::class, 'index'])->name("home.index");

// ==========NOTIFICATION ROUTE===========//
Route::get('/notification',[NotificationController::class, 'index'])->name("notification.index");

// ==========RESUME ROUTE===========//
Route::get('/resume',[ResumeController::class, 'index'])->name("resume.index");

// ==========CONTACT ROUTE===========//
Route::get('/contact',[ContactController::class, 'index'])->name("contact.index");
Route::post('/handle-contact',[ContactController::class, 'handleContact'])->name("handle.contact");

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

// ==========BLOG ROUTE===========//
Route::get('/blog',[BlogController::class, 'redirectToBlogIndex']);
Route::get('/blog/post',[BlogController::class, 'redirectToBlogIndex']);
Route::get('/blog/category',[BlogController::class, 'redirectToBlogIndex']);
Route::post('/blog/search-post',[BlogController::class, 'searchPost'])->name("blog.search");
Route::get('/blog/{action}/{slug}',[BlogController::class, 'index'])->name("blog.index");
Route::get('/blog/{postslug}',[BlogController::class, 'single'])->name("blog.single");
Route::post('/blog/fetch-comment-replies',[BlogController::class, 'fetchCommentReplies'])->name("blog.fetchCommentReplies");
Route::post('/blog/save-comment',[BlogController::class, 'saveComment'])->name("blog.saveComment");
Route::post('/blog/save-comment-reply',[BlogController::class, 'saveCommentReply'])->name("blog.saveCommentReply");
Route::post('/blog/check-reply-already-exit',[BlogController::class, 'checkReplyAlreadyExit'])->name("blog.checkReplyAlreadyExit");
Route::post('/blog/update-or-delete-reply',[BlogController::class, 'updateOrDeleteCommentReply'])->name("blog.updateOrDeleteCommentReply");


// ==========ADMIN  POST ROUTE===========//

Route::get('/admin',[AdminDashboardController::class, 'index'])->name("admin.dashboard")->middleware('isAdmin');
Route::get('/admin/dashboard',[AdminDashboardController::class, 'index'])->name("admin.dashboard")->middleware('isAdmin');
Route::get('/admin/create-post',[AdminPostController::class, 'createPostIndex'])->name("admin.createPostIndex")->middleware('isAdmin');
Route::post('/admin/create-post-save',[AdminPostController::class, 'createPostSave'])->name("admin.createPostSave")->middleware('isAdmin');
Route::get('/admin/allpost',[AdminPostController::class, 'getAllPost'])->name("admin.getAllPost")->middleware('isAdmin');
Route::post('/admin/delete-blog-post',[AdminPostController::class, 'delete'])->middleware('isAdmin');
Route::get('/admin/{postId}',[AdminPostController::class, 'updatePostIndex'])->where('postId', '[0-9]+')->name("admin.updatePostIndex")->middleware('isAdmin');
Route::post('/admin/update-post-save',[AdminPostController::class, 'updatePostSave'])->name("admin.updatePostSave")->middleware('isAdmin');


// ==========ADMIN  CATEGORY ROUTE===========//
Route::get('/admin/categories',[AdminCategoryController::class, 'categoriesIndex'])->name("admin.categoriesIndex")->middleware('isAdmin');
Route::post('/admin/update-category',[AdminCategoryController::class, 'updateCategory'])->name("admin.updateCategory")->middleware('isAdmin');
Route::post('/admin/delete-category',[AdminCategoryController::class, 'deleteCategory'])->name("admin.deleteCategory")->middleware('isAdmin');
Route::post('/admin/create-catgory',[AdminCategoryController::class, 'createCategory'])->name("admin.createCategory")->middleware('isAdmin');
