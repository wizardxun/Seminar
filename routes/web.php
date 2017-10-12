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
    return view('login');
})->name('login');

Route::post('/dashboard' ,'loginController@login')->name('dashboard');

Route::get('/register', function () {
    return view('registier');
});

Route::post('/logout','loginController@logout');
Auth::routes();

Route::get('/senden',function(){
	return view('auftraganlegen');
})->middleware('auth');

Route::post('/gesendet','auftragController@anlegen');

Route::get('/homepage',function(){
	return view('dashboard');
})->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/auftraganzeigen',"auftragController@anzeigen");

Route::get('/liefern', function() {
	return view('routeeingeben');
})->name('routeeingeben');

Route::post('/annehmen',"auftragController@annehmen");

Route::get('/konto', function(){
	return view('konto');
});

Route::post('/liefererbestaetigen', "auftragController@liefererbestaetigen");

Route::post('/abbestaetigen', "auftragController@abbestaetigen");

Route::get('/bestaetigen', function(){
	return view('bestaetigen');
});

Route::post('/bestaetigt', "auftragController@empfbestaetigen");

Route::post('/routeeingeben', "auftragController@liefererzeigen");

