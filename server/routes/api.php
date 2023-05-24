<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\FormController;
use App\Mail\VerifyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});






//public route

Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);

Route::get('/email', function() {
    Mail::to('hello@hello.com')->send(new VerifyMail);
    return new VerifyMail();
});
//protected route
// All Normal Users Routes List
// --------------------------------------------
// --------------------------------------------*/
// Route::group(['middleware' => ['auth:sanctum']], function () {

// });
//protected route
Route::post('email/verification-notification',[EmailVerificationController::class, 'sendEmailVerification'])->middleware('auth:sanctum');
Route::post('verify-email/{id}/{hash}',[EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');

//for logout route
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::post('/logout',[AuthController::class, 'logout']);
    });

//protected route for admin
Route::middleware(['auth:sanctum', 'user-access:admin', 'verified'])->group(function () {
    
});


//protected route for user company
Route::middleware(['auth:sanctum', 'user-access:company', 'verified'])->group(function () {
    Route::post('company/job_form',[FormController::class, 'job_form']);
    Route::get('company/job_posts',[FormController::class, 'job_posts']);
    Route::post('company/update_job_form/{job_id}', [FormController::class, 'update_job_form']);
    Route::post('company/delete_job_form/{job_id}', [FormController::class, 'delete_job_form']);
    Route::get('company/job_posts/{job_id}', [FormController::class, 'get_applied_user']);
});


//protected route for user
Route::middleware(['auth:sanctum', 'user-access:user', 'verified'])->group(function () {
    Route::post('user/form', [FormController::class, 'user_form']);
    Route::post('update_user_form/{id}', [FormController::class, 'update_user_form']);
    Route::post('delete_user_form/{id}', [FormController::class, 'delete_user_form']);
});