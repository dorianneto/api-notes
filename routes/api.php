<?php

$app->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($app) {
    $app->get('notes', 'Note@get');
    $app->get('notes/{id}', 'Note@find');
    $app->post('notes', 'Note@store');
    $app->put('notes/{id}', 'Note@update');
    $app->delete('notes/{id}', 'Note@destroy');
});

$app->post('auth', 'Auth\Login@authenticate');
$app->post('reset', 'Auth\Password@send');
$app->put('reset/{token}', 'Auth\Password@reset');
$app->post('logout', 'Auth\Login@logout');
$app->post('sign_up', 'User@store');
