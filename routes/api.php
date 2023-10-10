<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
/** Email verification */
Route::controller(AuthController::class)->group(function () {
//    Route::post('/register', 'register')->name('register');
//    Route::post('/register/guest', 'register')->name('register.guest');
    Route::post('login', 'login')->name('user.login');
//    Route::get('/users/{user:email}/verify', 'emailVerification')->name('users.email.verify');
});

Route::middleware(['auth:sanctum', 'auth'])->group(function () {
    Route::apiResource('/feedback', FeedbackController::class);
    Route::post('/feedback/{id}/upvote', [FeedbackController::class,'upvote'])->name('feedback.upvote');
    Route::post('/feedback/{id}/downvote', [FeedbackController::class,'downvote'])->name('feedback.downvote');
    Route::post('/feedback/{feedback:id}/comment', [FeedbackController::class,'comment'])->name('feedback.comment');
});


