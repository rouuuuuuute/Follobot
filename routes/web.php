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

Route::get('/howto', function () {
    return view('home.howto');
});

//Twitterアカウント
Route::get('/twitter/accounts', 'TwitterAccountsController@index')->name('twitter.accounts');

Route::POST('/twitter/accounts/request', 'TwitterAccountsController@request')->name('twitter.accounts.request');

Route::POST('/twitter/accounts/delete', 'TwitterAccountsController@destroy')->name('twitter.accounts.destroy');


//サービス利用状況
Route::get('/home', 'HomeController@index')->name('home');

//Route::post('/home/edit', 'HomeController@edit')->name('home.edit');
//
//Route::post('/home/withdraw', 'HomeController@withdraw')->name('home.withdraw');

/////////////////////////////////////
//プロフィール画面
Route::get('/profile', 'ProfileController@index')->name('home.profile');

Route::post('/profile/edit', 'ProfileController@edit')->name('home.profile.edit');

Route::post('/profile/withdraw', 'ProfileController@withdraw')->name('home.profile.withdraw');

/////////////////////////////////////
//自動フォローキーワード
Route::get('/twitter/keywords/follow', 'FollowKeywordsController@index')->name('twitter.followkeywords');

Route::post('/twitter/keywords/follow/new', 'FollowKeywordsController@create')->name('twitter.followkeywords.create');

Route::post('/twitter/keywords/follow/edit', 'FollowKeywordsController@edit')->name('twitter.followkeywords.edit');

Route::post('/twitter/keywords/follow/delete', 'FollowKeywordsController@destroy')->name('twitter.followkeywords.destroy');

/////////////////////////////////////
//自動いいねキーワード
Route::get('/twitter/keywords/favorites', 'FavoritesController@index')->name('twitter.favorites');

Route::post('/twitter/keywords/favorites/new', 'FavoritesController@create')->name('twitter.favorites.create');

Route::post('/twitter/keywords/favorites/edit', 'FavoritesController@edit')->name('twitter.favorites.edit');

Route::post('/twitter/keywords/favorites/delete', 'FavoritesController@destroy')->name('twitter.favorites.destroy');

/////////////////////////////////////
//自動ツイート
Route::get('/twitter/tweets', 'TweetsController@index')->name('twitter.tweets');

Route::post('/twitter/tweets/new', 'TweetsController@create')->name('twitter.tweets.create');

Route::post('/twitter/tweets/edit', 'TweetsController@edit')->name('twitter.tweets.edit');

Route::post('/twitter/tweets/delete', 'TweetsController@destroy')->name('twitter.tweets.destroy');

Route::get('/twitter/tweets/post', 'TweetsController@post')->name('twitter.tweets.post');

/////////////////////////////////////
//ターゲットアカウントリスト
Route::get('/twitter/targets', 'TargetsController@index')->name('twitter.targets');

Route::post('/twitter/targets/new', 'TargetsController@create')->name('twitter.targets.create');

Route::post('/twitter/targets/edit', 'TargetsController@edit')->name('twitter.targets.edit');

Route::post('/twitter/targets/delete', 'TargetsController@destroy')->name('twitter.targets.destroy');


/////////////////////////////////////
//ajax
Route::get('/twitter/json/accounts', 'RequestDatabaseController@accounts');
Route::get('/twitter/keywords/follow/json/keywords', 'RequestDatabaseController@keywords');
Route::get('/twitter/keywords/favorites/json/keywords', 'RequestDatabaseController@favoriteKeywords');
Route::get('/twitter/tweets/json/tweets', 'RequestDatabaseController@tweets');
Route::get('/twitter/tweets/json/reserved', 'RequestDatabaseController@time');
Route::get('/home/json/name', 'RequestDatabaseController@name');
Route::get('/home/json/email', 'RequestDatabaseController@email');
Route::get('/twitter/targets/json/targets', 'RequestDatabaseController@targets');

Route::get('/twitter/follower/json/ratelimit', 'RequestDatabaseController@ratelimit');

/////////////////////////////////////
/// twitterapi
//フォロワーサーチ
Route::get('/twitter/api/search/follower', 'FollowedTargetsController@create')->name('twitter.search.follower');

//フォロー
Route::get('/twitter/api/follow', 'FollowingTargetsController@create')->name('twitter.follow');

//アンフォロー
Route::get('/twitter/api/unfollow', 'UnfollowersController@create')->name('twitter.unfollow');

/////////////////////////////////////
//メール
//15分以内のAPI制限
Route::get('/mail/minutes', 'MailSendController@minutes');

//当日に1000件以上の制限
Route::get('/mail/day', 'MailSendController@day');

//処理完了
Route::get('/mail/finished', 'MailSendController@finished');

//凍結
Route::get('/mail/suspended', 'MailSendController@suspended');
/////////////////////////////////////
