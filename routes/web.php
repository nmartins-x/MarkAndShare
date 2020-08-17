<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () {
    return redirect()->route('home');
});

// login, register and logout routes
Auth::routes();

// Oauth
Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
Route::get('/callback/{provider}', 'SocialController@callback')->name('SocialiteCallback');

Route::middleware('auth')->group(function () {
    Route::get('/user', 'SocialController@user');
    
    Route::resource('/listing', 'ListingController', [
        'except' => ['edit', 'show']
    ])->name('*', 'listing');
    
    Route::get('/listing/user_owned/', 'ListingController@user_owned')->name('listing.user_owned');
    
    Route::resource('/marker', 'MarkerController', [
        'except' => ['edit', 'show', 'index', 'create']
    ])->name('*', 'marker');
});

Route::get('listing/{unique_url}', 'ListingController@show')->name('listing.show');
Route::get('listing/{unique_url}/markers', 'ListingController@getMarkers')->name('listing.markers');

// This allows VueJS router to takeover the routing, should be at the very end of these routes
Route::get('/{vue_capture?}', function () {
 return view('home');
})->where('vue_capture', '[\/\w\.-]*');