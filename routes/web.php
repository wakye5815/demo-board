<?php
use App\Http\ResponseBuilders\SuccessResponseBuilder;
use App\Models\Badge;

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
Route::post('/api/comment/reply', 'CommentController@reply');

Route::get('/api/badge/master', function () {
    return (new SuccessResponseBuilder)
        ->setContent(['badge_master' => Badge::all()])
        ->build();
});

Route::get('/{any?}', function () {
    return view('index');
})->where('any', '.+');
