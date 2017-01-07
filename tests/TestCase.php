<?php

class TestCase extends Laravel\Lumen\Testing\TestCase
{
    const EMAIL = 'test@test.com';

    const PASSWORD = '3z5DSDPP';

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    protected function getToken()
    {
        $response = $this->call('POST', '/api/auth', ['email' => self::EMAIL, 'password' => self::PASSWORD]);
        $token    = $response->getData()->token;

        return $token;
    }
}
