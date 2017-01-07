<?php

class TestCase extends Laravel\Lumen\Testing\TestCase
{
    const BASE_URL = 'http://hsa.dorianneto.com.br/';

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
        $response = $this->post('api/auth', ['email' => self::EMAIL, 'password' => self::PASSWORD]);
        $token    = json_decode($response->response->getContent())->token;

        return $token;
    }
}
