<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function() {

    Route::resource('bank-accounts', 'BankAccountController');
    Route::get('categories/dropdown', 'CategoryController@dropDown');
    Route::resource('categories', 'CategoryController');
    Route::resource('finances', 'FinanceController');
    Route::get('balances', 'BalanceController@index');
    Route::post('balances/recalc', 'BalanceController@reCalc');

});
