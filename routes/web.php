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
    return view('welcome');
});

Auth::routes(
    //    [
    //        'register' => false, // Registration Routes...
    //        'reset' => false, // Password Reset Routes...
    //        'verify' => false, // Email Verification Routes...
    //    ]
);

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => ['auth']], function () {
    Route::get('suplier/datatables', 'SuplierController@datatables')->name('suplier.datatables');
    Route::resource('suplier', 'SuplierController');

    Route::get('member/datatables', 'MemberController@datatables')->name('member.datatables');
    Route::resource('member', 'MemberController');

    Route::get('item/datatables', 'ItemController@datatables')->name('item.datatables');
    Route::resource('item', 'ItemController');

    Route::get('unit/datatables', 'UnitController@datatables')->name('unit.datatables');
    Route::resource('unit', 'UnitController')->only('index', 'store', 'update', 'show', 'destroy');

    Route::get('category/datatables', 'CategoryController@datatables')->name('category.datatables');
    Route::resource('category', 'CategoryController')->only('index', 'store', 'update', 'show', 'destroy');
});
