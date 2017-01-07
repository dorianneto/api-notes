<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\PasswordReset;
use App\User;

/**
 * Password's controller
 *
 * @version   v1.0.0
 * @link      http://hsa.dorianneto.com.br/
 * @author    Dorian Neto <doriansampaioneto@gmail.com>
 */
class Password extends Controller
{
    /**
     * Sends an email to user to them reset your password
     * @param  Request       $request
     * @param  PasswordReset $passwordReset
     * @return json
     */
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
            return response()->json(['error' => 'token_already_sent'], 400);
        }

        $user = User::where('email', $data['email'])->first();

        if (is_null($user)) {
            return response()->json(['error' => 'email_not_found'], 400);
        }

        try {
            $token      = str_random(120);
            $email      = $user->email;
            $created_at = Carbon::now();

            $passwordReset->insert([
                'email'      => $email,
                'token'      => $token,
                'created_at' => $created_at
            ]);

            Mail::raw('Your token is: ' . $token, function($message) use ($email) {
                $message->to($email);
                $message->from(['doriansampaioneto@gmail.com']);
            });

            return response()->json(['message' => 'email_with_token_sent']);
        } catch (QueryException $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Resets the user password throughs your token
     * @param  Request $request
     * @param  string  $token
     * @return json
     */
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
            return response()->json(['error' => 'token_not_found'], 400);
        }

        try {
            $new_password = ['password' => Hash::make($data['password'])];

            $updated = User::where('email', $data['email'])->update($new_password);

            if ($updated) {
                PasswordReset::where('email', $data['email'])->delete();
            }

            return response()->json(['message' => 'password_reseted']);
        } catch (QueryException $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
