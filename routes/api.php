<?php
use Illuminate\Support\Facades\File;

$app->get('/', function() {
    return File::get(public_path() . '/index.html');
});

$app->group(['prefix' => 'api'], function () use ($app) {
    $app->post('auth', 'Auth\Login@authenticate');
    $app->post('reset', 'Auth\Password@send');
    $app->put('reset/{token}', 'Auth\Password@reset');
    $app->post('sign_up', 'User@store');

    $app->group(['middleware' => ['jwt.auth']], function() use ($app) {
        $app->post('logout', 'Auth\Login@logout');

        $app->get('notes', 'Note@get');
        $app->get('notes/{id}', 'Note@find');
        $app->post('notes', 'Note@store');
        $app->put('notes/{id}', 'Note@update');
        $app->delete('notes/{id}', 'Note@destroy');
    });
});
