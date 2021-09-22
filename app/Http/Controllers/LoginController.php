<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\VerifyEmail;
use App\Mail\ForgetPassword;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;


use function PHPUnit\Framework\throwException;

class LoginController extends Controller
{
    //

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);



        $user = User::where('email', $request->email)->first();


        if (!$user || !Hash::check($request->password, $user->password)) {


            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect']
            ]);
        }

        if (!$user->email_verification ||  $user->email_verification != 'verified') {

            throw ValidationException::withMessages([
                'unverifiedEmail' => ['Email not verified']
            ]);
        }
        return array("token" => $user->createToken('Auth Token')->accessToken, "user" => $user);

        //$http = new \GuzzleHttp\Client();
        /*  $http = new Client();
        $response = $http->post('http://127.0.0.1:8000/oauth/token', [
            'form_params'=>[
               'grant_type'=> 'password',
            'client_id'=> '3',
            'client_secret'=> 'ElE2e5sDoUGKCoN4G6FtF0UA6mL8V9buvCJXsYdw',
            'username'=> '123321holyphilzy@gmail.com',
            'password'=> '1234567890',
            'scope'=> ''
            ]
        ]);
            return json_decode((string) $response->getBody(), true);*/
    }

    public function logout(Request $request)
    {
        //return 'hello';
        $request->user()->tokens()->delete();
        return response()->json('Logout successful', 200);
    }

    public function verifyEmail($verification_id)
    {   if(strtolower($verification_id) == "verified")
        {
            
            throw new Exception('Invalid email verification code');
        }
        $emailVerify = User::where('email_verification', $verification_id)->update(['email_verification' => 'verified']);

        if(!$emailVerify)
        {
            throw new Exception('Invalid email verification code');
        }
        return response()->json('Email verification successful', 200);
    }

    public function resendEmailVerificationLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email']
        ]);

        $verifyEmailCode =  Str::random(8) . date('dmyHis');

        $user = User::where('email', $request->email)->first();

        if ($user) {
            User::where('email', $request->email)->update(['email_verification' => $verifyEmailCode]);
            $verifyEmailLink = config('app.front_end_domain', 'http://localhost:8080/') . "email_verification/" . $verifyEmailCode;
            Mail::to($request->email)->send(new VerifyEmail($verifyEmailLink));
            return response()->json('Verification link sent successfully', 200);
        } else {
            throw ValidationException::withMessages([
                'error' => ['No user with such email']
            ]);
        }
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email']
        ]);
        $newPassword =  Str::random(8);

        $updateNewPasswpord =User::where('email', $request->email)->update(['password' =>  Hash::make($newPassword)]);
        if(!$updateNewPasswpord){
            throw new Exception('Invalid email address');
        }
        Mail::to($request->email)->send(new ForgetPassword($newPassword));
        return response()->json('Password Recover Successful, Please check your email for the new password', 200);
    }
}
