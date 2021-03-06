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
Route::get('/taskreport', 'PagesController@taskreport')->name('taskreport');
Route::get('/authuser', 'PagesController@auths')->name('authuser');
Route::get('/regboard', 'PagesController@regboard')->name('regboard');
Route::get('/counter', 'PagesController@livecounter')->name('livecounter');

Route::get('/setup', 'PagesController@setuplist')->name('setup');

Route::get('/calendar', function () {
    return view('chat');
});



Route::resource('registerlist', 'ListsController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/search',['uses' => 'CardsController@report','as' => 'search']);

Route::get('/post_users',['uses' => 'CardsController@setmembers','as' => 'post_users']);

Route::get('/test', 'CardsController@index')->name('load');
Route::get('/reports','CardsController@report');
Route::get('/myreports','CardsController@myreport')->name('myreports');

Route::get('/revision', 'CardsController@revisions')->name('revision');
Route::get('/mytasks', 'CardsController@mytask')->name('mytasks');
Route::get('/excel', 'CardsController@postcards')->name('excel');

Route::get('/auth', 'CardsController@create_auth')->name('auth');

Route::get('/set_roles',['uses' => 'CardsController@setroles','as' => 'set_roles']);

Route::resource('trello', 'ListsController');

Route::post('/setcards', array('as' => 'setcards', 'uses' => 'BoardsController@setcards'));

Route::get('/updatecards', 'UpdatesController@updatecards')->name('updatecards');
Route::get('/getallcards', 'UpdatesController@getcards')->name('getallcards');
Route::get('/gcal', 'gCalendarsController@index')->name('gcal');
Route::get('/oauth', 'gCalendarsController@oauth')->name('oath');
Route::get('/getuser', 'BoardsController@getuser')->name('getuser');
Route::get('/getcards', 'BoardsController@getcards')->name('getcards');
Route::resource('/cal', 'gCalendarsController');
Route::post('/getlist',['uses' => 'BoardsController@getcards','as' => 'search']);
Route::get('/opentask', 'PagesController@opentask')->name('opentask');
//Route::post('/updatecarduser', ['uses' => 'PagesController@updatecarduser', 'as' => 'updatecarduser']);
Route::get('/updatecarduser/{card_id}', 'PagesController@updatecarduser')->name('updatecarduser');
