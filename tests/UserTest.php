<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function testUserStore()
    {
        $data = [
            'name'     => 'Test2',
            'email'    => 'test2@test.com',
            'password' => 'T8Zz2eaP',
        ];

        $this->json('POST', '/api/sign_up', $data)
            ->shouldReturnJson()
            ->seeJsonEquals([
                "message" => "user_stored"
            ])
            ->seeJsonStructure([
                'message'
            ])
            ->assertResponseOk();
    }
}
