<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\OrganizationDetailController;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
*/

Route::get('/user', function (Request $request) {
    $testing = config('app.front_end_domain', 'http://localhost:8080/');
    //return view('emails.verifyEmail')
});

Route::middleware(['auth:api'])->group(function () {

    Route::prefix('subcategory')->group(function () {

        Route::post('/save', [SubCategoryController::class, 'store']);
        Route::put('/update/{id}', [SubCategoryController::class, 'update']);
        Route::delete('/delete/{id}', [SubCategoryController::class, 'destroy']);

    });

    


});


Route::prefix('location')->group(function () {

    Route::get('/', [LocationController::class, 'index']);
    Route::post('/save', [LocationController::class, 'store']);
    Route::put('/update/{id}', [LocationController::class, 'update']);
    Route::delete('/delete/{id}', [LocationController::class, 'destroy']);
    Route::get('/{id}', [LocationController::class, 'show']);

});

Route::prefix('gallery')->group(function () {
    Route::get('/{id}', [GalleryController::class, 'show']);
    Route::middleware(['auth:api'])->group(function () {

        Route::post('/save', [GalleryController::class, 'store']);
        Route::put('/update/{id}', [GalleryController::class, 'update']);
        Route::delete('/delete/{id}', [GalleryController::class, 'destroy']);

    });
});

Route::prefix('category')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);

    Route::middleware(['auth:api'])->group(function () {

        Route::post('/save', [CategoryController::class, 'store']);
        Route::put('/update/{id}', [CategoryController::class, 'update']);
        Route::delete('/delete/{id}', [CategoryController::class, 'destroy']);

    });
});

Route::prefix('state')->group(function () {
    Route::get('/', [StateController::class, 'index']);
    Route::middleware(['auth:api'])->group(function () {

        Route::post('/save', [StateController::class, 'store']);
        Route::put('/update/{id}', [StateController::class, 'update']);
        Route::delete('/delete/{id}', [StateController::class, 'destroy']);
    });

    });

Route::prefix('comment')->group(function () {
    Route::get('/{id}', [CommentController::class, 'show']);

    Route::middleware(['auth:api'])->group(function () {

        Route::post('/save', [CommentController::class, 'store']);
        Route::delete('/delete/{id}', [CommentController::class, 'destroy']);

    });

});


Route::prefix('business/profile')->group(function () {

    Route::get('/', [OrganizationDetailController::class, 'index']); // Getting artisan details.
    //Route::get('/{id}', [OrganizationDetailController::class, 'show']); // expecting profile id

    Route::middleware(['auth:api'])->group(function () {

    Route::get('/org', [OrganizationDetailController::class, 'show']); // OrganizationDetail index for getting authenticated user businesses details
    Route::post('/save', [OrganizationDetailController::class, 'store']);
    Route::put('/update/{id}', [OrganizationDetailController::class, 'update']);

    });

});

Route::prefix('profile')->group(function () {

    Route::middleware(['auth:api'])->group(function () {
    Route::get('/', [ProfileController::class, 'show']);
        Route::post('/save', [ProfileController::class, 'store']);
        Route::put('/update', [ProfileController::class, 'update']);

    });
});


Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:api');

Route::post('/email_verification_link', [LoginController::class, 'resendEmailVerificationLink']);
Route::put('/verify_email/{verification_id}', [LoginController::class, 'verifyEmail']);
Route::post('/forget_password', [LoginController::class, 'forgotPassword']);


/* Route::get('/test', function () {


    $response = Http::post('http://127.0.0.1:8000/oauth/token', [
        'form_params'=>[
        'grant_type'=> 'password',
         'client_id'=> '3',
         'client_secret'=> 'ElE2e5sDoUGKCoN4G6FtF0UA6mL8V9buvCJXsYdw',
         'username'=> '123321holyphilzy@gmail.com',
         'password'=> '1234567890',
         'scope'=> ''
         ]
    ]);

    return $response->body();


    return 'welcome to';
}); */
