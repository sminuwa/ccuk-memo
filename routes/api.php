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

Route::get('/local-to-remote', 'Api\ApiController@localToRemote')->name('api.local_to_remote');
Route::post('/remote-to-local', 'Api\ApiController@remoteToLocal')->name('api.remote_to_local');
Route::post('/sync-attachments', 'Api\ApiController@syncAttachments')->name('api.sync_attachments');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
