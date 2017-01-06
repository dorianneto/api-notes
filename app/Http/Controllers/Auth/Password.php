<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\PasswordReset;
use App\User;

class Password extends Controller
{
    public function send(Request $request, PasswordReset $passwordReset)
    {
        $data = $request->only('email');

        $validator = $this->validator($data, [
            'email' => 'required|email',
        ]);

        if (!is_null($validator)) {
            return $validator;
        }

        $check_has_password_reset = PasswordReset::where('email', $data['email'])->first();

        if (!is_null($check_has_password_reset)) {
            return response()->json(['error' => 'Token already sent!'], 400);
        }

        $user = User::where('email', $data['email'])->first();

        if (is_null($user)) {
            return response()->json(['error' => 'Email not found.'], 400);
        }

        $token = str_random(120);
        $email = $user->email;

        $passwordReset->insert(['email' => $email, 'token' => $token]);

        Mail::raw('Your token is: ' . $token, function($message) use ($email) {
            $message->to($email);
            $message->from(['doriansampaioneto@gmail.com']);
        });

        return response()->json(['message' => 'Email with token to reset password sent!']);
    }

    public function reset(Request $request, $token)
    {
        $data = $request->only('email', 'password');

        $validator = $this->validator($data, [
            'email'    => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (!is_null($validator)) {
            return $validator;
        }

        $password_reset = PasswordReset::where('email', $data['email'])->where('token', $token)->first();

        if (is_null($password_reset)) {
            return response()->json(['error' => 'Token not found.'], 400);
        }

        $new_password = ['password' => Hash::make($data['password'])];

        $updated = User::where('email', $data['email'])->update($new_password);

        if ($updated) {
            PasswordReset::where('email', $data['email'])->delete();
        }

        return response()->json(['message' => 'Password reseted!']);
    }
}
