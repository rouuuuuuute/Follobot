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


Route::get('/welcome', function () {
    return view('welcome');
});

//Twitterアカウント
Route::get('/twitter/accounts', 'TwitterAccountsController@index')->name('twitter.accounts');

Route::POST('/twitter/accounts/request', 'TwitterAccountsController@request')->name('twitter.accounts.request');


//プロフィール画面
Route::get('/home', 'HomeController@index')->name('home');

Route::post('/home/edit', 'HomeController@edit')->name('home.edit');

//自動いいねキーワード
Route::get('/twitter/keywords/favorites', 'FavoritesController@index')->name('twitter.favorites');

Route::post('/twitter/keywords/favorites/new', 'FavoritesController@create')->name('twitter.favorites.create');

//自動フォローキーワード
Route::get('/twitter/keywords/follow', 'FollowKeywordsController@index')->name('twitter.followkeywords');

Route::post('/twitter/keywords/follow/new', 'FollowKeywordsController@create')->name('twitter.followkeywords.create');

//自動ツイート
Route::get('/twitter/tweets', 'TweetsController@index')->name('twitter.tweets');

Route::post('/twitter/tweets/new', 'TweetsController@create')->name('twitter.tweets.create');

//ターゲットアカウントリスト
Route::get('/twitter/targets', 'TargetsController@index')->name('twitter.targets');

Route::post('/twitter/targets/new', 'TargetsController@create')->name('twitter.targets.create');
