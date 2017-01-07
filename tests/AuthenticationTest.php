<?php

use Illuminate\Support\Facades\DB;

class AuthenticationTest extends TestCase
{
    public function testAuthenticate()
    {
        $this->json('POST', '/api/auth', ['email' => self::EMAIL, 'password' => self::PASSWORD])
            ->shouldReturnJson()
            ->seeJsonStructure([
                'token'
            ])
            ->assertResponseOk();
    }

    public function testSendReset()
    {
        $this->json('POST', '/api/reset', ['email' => self::EMAIL])
            ->shouldReturnJson()
            ->seeJsonEquals([
                "message" => "email_with_token_sent"
            ])
            ->seeJsonStructure([
                'message'
            ])
            ->assertResponseOk();
    }

    public function testResetWithToken()
    {
        $password_resets = DB::table('password_resets')
            ->select('token')
            ->where('email', self::EMAIL)
            ->first();

        $this->json('PUT', '/api/reset/' . $password_resets->token, ['email' => self::EMAIL, 'password' => self::PASSWORD])
            ->shouldReturnJson()
            ->seeJsonEquals([
                "message" => "password_reseted"
            ])
            ->seeJsonStructure([
                'message'
            ])
            ->assertResponseOk();
    }

    public function testLogout()
    {
        $token = $this->getToken();

        $this->json('POST', '/api/logout', [], ['Authorization' => 'Bearer ' . $token])
            ->shouldReturnJson()
            ->seeJsonEquals([
                "message" => "sign_out"
            ])
            ->seeJsonStructure([
                'message'
            ])
            ->assertResponseOk();
    }
}
