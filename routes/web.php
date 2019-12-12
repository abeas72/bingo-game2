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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route::get('cards/{user}', function (App\User $user) {
//    return $user->email;
//});

//Route::get('test', function () {
//    return view('test');
//});
Route::get('getcards/{whatCards}','CardController@getCards');

Route::get('cards/current_cards','CardController@index')->name('cards.current_cards');
Route::get('cards/all_cards','CardController@index')->name('cards.all_cards');
Route::get('cards/my_cards','CardController@index')->name('cards.my_cards');
Route::get('cards/select_cards','SelectCardController@index')->name('cards.select_index');
Route::get('cards/select_cards/create','SelectCardController@create')->name('cards.select_create');
Route::get('cards/test_select','CardController@testSelect')->name('cards.test_select');
Route::get('playercards', 'GameController@addCardsPlayers');
Route::resource('cards', 'CardController');
Route::resource('games', 'GameController');
Route::resource('drawresults', 'DrawResultController');
Route::resource('winners', 'WinnerController');




//Route::get('cards', 'CardController@index');
//Route::get('cards', function () {
//    return view('cards.index');
//});