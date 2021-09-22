<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Mail\VerifyEmail;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'user_type' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', "min:8", 'confirmed']
        ]);
       // return response()->json('Verification link sent successfully', 200);

            
        $verifyEmailCode = Str::random(8).date('dmyHis');
        User::create([
            'user_type' => $request->user_type,
            'email' => $request->email,
            'email_verification' => $verifyEmailCode,
            'password' => Hash::make($request->password)
        ]);

        
        $verifyEmailLink = config('app.front_end_domain', 'http://localhost:8080/')."email_verification/" . $verifyEmailCode;
        Mail::to($request->email)->send(new VerifyEmail($verifyEmailLink));

        return response()->json([
            'message' => 'Successful',
        ]);


    }
}
