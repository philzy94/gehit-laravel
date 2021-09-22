<?php

use Illuminate\Support\Facades\Route;
//use Illuminate\Support\Str;
//use App\Mail\VerifyEmail;
//use Illuminate\Support\Facades\Mail;
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

Route::get('/', function () {
    //Mail::to('holyphilzy@yahoo.com')->send(new VerifyEmail());
    //$random = Str::random(8);
    //return url("/api/verify_email/".date('dmyHis').$random);
    //return view('welcome');
    return view('emails.verifyEmail');
});
Route::get('/login', [LoginController::class, 'login']);

