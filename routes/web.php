<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();
Route::get('/', 'PagesController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/task', 'PagesController@task')->name('task');
Route::get('/load', 'PagesController@load')->name('load');
Route::get('/taskload', 'PagesController@taskload')->name('load');
Route::get('/livecounter', 'PagesController@counter')->name('counter');
Route::get('/dashboard', 'PagesController@dashboard')->name('board');
Route::get('/register-board', 'PagesController@boardreg')->name('regb');
Route::get('/tasks', 'PagesController@tasks')->name('tasks');

Route::get('/setup', 'PagesController@setuplist')->name('setup');




Route::resource('registerlist', 'ListsController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/search',['uses' => 'CardsController@report','as' => 'search']);

Route::get('/test', 'CardsController@index')->name('load');
Route::get('/reports','CardsController@report');
Route::get('/revision', 'CardsController@revisions')->name('load');
Route::get('/mytasks', 'CardsController@mytask')->name('load');

Route::resource('trello', 'ListsController');

Route::resource('test2', 'CardsController');
