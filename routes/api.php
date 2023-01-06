<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('cek-email', 'MemberController@checkEmail');
Route::post('register', 'MemberController@register');
Route::post('login', 'MemberController@login');
Route::middleware('auth:member')->group(function()
{
    Route::post('register-kendaraan', 'MemberController@regisKendaraan');
    Route::post('check-in','MemberController@checkIn');
    Route::post('check-out','MemberController@checkOut');
    Route::get('profile', 'MemberController@profile');
    Route::get('kendaraan-member', 'MemberController@kendaraanMember');
    Route::get('list-point', 'MemberController@listPoint');
    Route::get('list-checkin', 'MemberController@listCheckIn');
    Route::get('list-checkout', 'MemberController@listCheckOut');
});
