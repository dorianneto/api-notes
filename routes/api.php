<?php

// no middleware de auth, vou verificar o token
$app->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($app) {
    $app->get('notes', 'Note@get');
    // $app->get('notes/{id}', 'NotesController@find');
    // $app->post('notes', 'NotesController@store');
    // $app->put('notes/{id}', 'NotesController@update');
    // $app->delete('notes/{id}', 'NotesController@destroy');
});

// logar usando email e pass para resgatar o token
$app->post('auth', 'Auth\LoginController@authenticate');

// resetar email e pass através do envio de email
// $app->post('reset', 'Auth\AuthController@reset');

// limpar sessão e excluir token
$app->post('logout', 'Auth\LoginController@logout');

// cadastrar usuário sem o token
// $app->post('sign_up', 'Auth\RegisterController@register');
