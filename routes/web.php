<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Auth::routes();

Route::get('/', function () {
    return redirect('person');
});

Route::get('/home', function () {
    return redirect('person');
});

Route::get('viewfile/{file}', function ( $file ) {
	$ext = pathinfo( $file, PATHINFO_EXTENSION ); 
	$content = file_get_contents( '../storage/app/uploads/' . $file );
	if ( 'pdf' == $ext ) {
		return Response::make ( $content, 200, [ 'Content-Type' => 'application/pdf' ] );
	}
	else {
		return Response::make ( $content, 200, [ 'Content-Type' => 'image/' . $ext ] );
	}
});

Route::get('person/{id}/viewfile/{file}', 'PersonController@viewfile');
Route::get('person/csv', 'PersonController@csv');
Route::get('person/select/{parameters}', 'PersonController@index');
Route::get('person/select', 'PersonController@index');
Route::post('person/select', 'PersonController@select');
Route::resource('person','PersonController');

Route::get('person/{id}/delete', 'PersonController@delete');

Route::resource('committee','CommitteeController');

Route::resource('admin/user','Admin\UserController');
Route::get('admin/user/{id}/delete', 'Admin\UserController@delete');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('home', 'HomeController@index');
Route::get('test', 'HomeController@test');

Route::get('email/regular/preview', 'Email\EmailController@send_regular');
Route::get('email/regular/send', 'Email\EmailController@send_regular');

