<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. You're free to add
| as many additional routes to this file as your tool may require.
|
*/

Route::get('/billable/{id}', 'DatabaseSubscriptionsController@show');
Route::get('/subscriptions/{id}', 'StripeSubscriptionsController@show');
Route::put('/subscriptions/{id}', 'StripeSubscriptionsController@update');
Route::post('/subscriptions/{id}/resume', 'StripeSubscriptionsController@resume');
Route::post('/subscriptions/{id}/cancel', 'StripeSubscriptionsController@cancel');
