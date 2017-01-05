<?php

$app->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($app) {
    $app->get('notes', 'Note@get');
    $app->get('notes/{id}', 'Note@find');
    $app->post('notes', 'Note@store');
    $app->put('notes/{id}', 'Note@update');
    $app->delete('notes/{id}', 'Note@destroy');
});

$app->post('auth', 'Auth\LoginController@authenticate');
// $app->post('reset', 'Auth\AuthController@reset');
$app->post('logout', 'Auth\LoginController@logout');
// $app->post('sign_up', 'Auth\RegisterController@register');
