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

Route::get('/', function () {
    if(Auth::user()){
        return redirect('/home');
    }
    else return redirect('/login');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test',function (){
    event(new \App\Events\AddAlbom());
    return 'ok';
});
