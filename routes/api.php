<?php

use App\Http\Controllers\Api\V1\LocationController;
use App\Http\Controllers\Api\V1\RouteController;

Route::group(['prefix' => 'v1'], function () {
    Route::apiResource('/locations', LocationController::class);
    Route::post('store', [RouteController::class, 'store']);
});
