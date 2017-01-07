<?php

namespace App\Http\Controllers\Auth;

use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;

/**
 * Logins's controller
 *
 * @version   v1.0.0
 * @link      http://hsa.dorianneto.com.br/
 * @author    Dorian Neto <doriansampaioneto@gmail.com>
 */
class Login extends Controller
{
    /**
     * Authenticates an user to enable to use the API
     * @param  Request $request
     * @return json
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    /**
     * Disables the user access to API
     * @param  Request $request
     * @return json
     */
    public function logout(Request $request)
    {
        if (!$token = JWTAuth::getToken()) {
            return response()->json(['error' => 'token_not_found'], 500);
        }

        JWTAuth::setToken($token)->invalidate();

        return response()->json(['message' => 'sign_out']);
    }
}
