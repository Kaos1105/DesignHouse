<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\VerificationController;
use Illuminate\Http\Request;
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
    return new \App\Http\Resources\UserResource($request->user());
});

// Route group for authenticated users only
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::put('settings/profile', [\App\Http\Controllers\User\SettingsController::class, 'updateProfile']);
    Route::put('settings/password', [\App\Http\Controllers\User\SettingsController::class, 'updatePassword']);

    //Upload Designs
    Route::post('designs', [\App\Http\Controllers\Designs\UploadController::class, 'upload']);
    Route::put('designs/{design}', [\App\Http\Controllers\Designs\DesignController::class, 'update']);
    Route::delete('designs/{design}', [\App\Http\Controllers\Designs\DesignController::class, 'destroy']);
});

// Route for guest only
Route::middleware('guest')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('verification/verify/{user}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('verification/resend', [VerificationController::class, 'resend'])->name('verification.resend');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset');
});