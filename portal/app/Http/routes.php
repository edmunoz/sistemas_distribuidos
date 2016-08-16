<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::post('list_documents_by_type','HomeController@list_documents_by_type');
Route::post('list_documents','HomeController@list_documents');
Route::post('list_types','HomeController@list_types');

Route::post('descargar_xml', 'PDFController@descargar_xml');

Route::post('descargar_pdf', 'PDFController@descargar_pdf');

