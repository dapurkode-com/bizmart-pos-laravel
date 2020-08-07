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

Route::redirect('/', '/home');

Auth::routes(
    //    [
    //        'register' => false, // Registration Routes...
    //        'reset' => false, // Password Reset Routes...
    //        'verify' => false, // Email Verification Routes...
    //    ]
);




Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('suplier/datatables', 'SuplierController@datatables')->name('suplier.datatables');
    Route::get('member/datatables', 'MemberController@datatables')->name('member.datatables');
    Route::get('item/datatables', 'ItemController@datatables')->name('item.datatables');
    Route::get('unit/datatables', 'UnitController@datatables')->name('unit.datatables');
    Route::get('category/datatables', 'CategoryController@datatables')->name('category.datatables');
    Route::get('user/datatables', 'UserController@datatables')->name('user.datatables');
    Route::get('opname/datatables', 'OpnameController@datatables')->name('opname.datatables');
    Route::get('opname/datatablesOpnameDetail', 'OpnameController@datatablesOpnameDetail')->name('opname.datatables_opname_detail');
    Route::get('opname/get_items', 'OpnameController@getItems')->name('opname.get_items');
    Route::post('opname/store_opname_detail', 'OpnameController@storeOpnameDetail')->name('opname.store_opname_detail');
    Route::post('opname/store_stock_log', 'OpnameController@storeStockLog')->name('opname.store_stock_log');
    Route::get('sell/list', 'SellController@list')->name('sell.list');
    Route::get('sell/datatables', 'SellController@datatables')->name('sell.datatables');

    Route::resource('unit', 'UnitController')->only('index', 'store', 'update', 'show', 'destroy');
    Route::resource('category', 'CategoryController')->only('index', 'store', 'update', 'show', 'destroy');
    Route::resource('buy', 'BuyController')->only('index', 'store', 'create', 'show', 'destroy');

    Route::resources([
        'suplier' => 'SuplierController',
        'member' => 'MemberController',
        'item'  => 'ItemController',
        'user' => 'UserController',
        'opname' => 'OpnameController',
        'sell' => 'SellController'
    ]);
});
