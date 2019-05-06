<?php

Route::post('/api/account/signup', 'Auth\RegisterController@signup');
Route::post('/api/account/signin', 'Auth\LoginController@signin');
Route::get('/api/account/signout', 'Auth\LoginController@logout');

Route::post('/api/board/create', 'BoardController@create');
Route::get('/api/board/all', 'BoardController@all');
Route::get('/api/board/top', 'BoardController@top');

Route::post('/api/comment/create', 'CommentController@create');
Route::delete('/api/comment/delete', 'CommentController@delete');
Route::patch('/api/comment/edit', 'CommentController@edit');
Route::get('/api/comment/find', 'CommentController@find');

Route::get('/{any?}', function () {
    return view('index');
})->where('any', '.+');
